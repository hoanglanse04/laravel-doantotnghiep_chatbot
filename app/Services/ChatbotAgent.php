<?php
namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\FaqEntry;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatbotAgent
{
  private string $embeddingModel = 'all-minilm';
  private float $faqThreshold = 0.75;

  /**
   * handle(session, message, payload=null, user=null)
   * payload: optional quick-reply payload like "faq:warranty" or "suggest:top_sellers"
   */
  public function handle(ChatSession $session, string $message, $payload = null, $user = null): array
  {
    $message = trim((string) $message);
    $messageLower = mb_strtolower($message);

    // 1) If payload present, prefer payload flow
    if ($payload && is_string($payload)) {
      $res = $this->handlePayload($payload);
      if ($res)
        return $res;
    }

    // 1b) detect suggestion text (plain text user asked for top sellers)
    $suggestionKeywords = ['bán chạy', 'gợi ý sản phẩm', 'sản phẩm bán chạy', 'top seller'];
    foreach ($suggestionKeywords as $kw) {
      if (mb_strpos($messageLower, $kw) !== false) {
        return $this->suggestTopSellers();
      }
    }

    // 2) Try FAQ keyword rules (fast path)
    if ($faq = $this->matchFaq($message)) {
      return [
        'text' => $faq->answer,
        'meta' => ['source' => 'faq', 'faq_id' => $faq->id]
      ];
    }

    // 3) Try product semantic search (embedding)
    $products = $this->searchProducts($message);
    if (!empty($products)) {
      return [
        'text' => $this->formatProductList($products),
        'meta' => ['source' => 'products', 'count' => count($products)]
      ];
    }

    // 4) fallback
    return $this->fallbackMessage();
  }

  private function handlePayload(string $payload): ?array
  {
    if (strpos($payload, ':') === false) {
      return null;
    }
    [$type, $value] = explode(':', $payload, 2);

    if ($type === 'faq') {
      $faq = FaqEntry::where('topic', $value)
        ->where('active', 1)
        ->first();
      if ($faq) {
        return ['text' => $faq->answer, 'meta' => ['source' => "faq:$value", 'faq_id' => $faq->id]];
      }
      return null;
    }

    if ($type === 'suggest' && $value === 'top_sellers') {
      return $this->suggestTopSellers();
    }

    return null;
  }

  private function suggestTopSellers(): array
  {
    $top = OrderItem::select('product_id', DB::raw('SUM(qty) as total_qty'))
      ->groupBy('product_id')
      ->orderByDesc('total_qty')
      ->limit(5)
      ->pluck('total_qty', 'product_id');

    $products = collect();
    if ($top->isEmpty()) {
      $products = Product::where('status', 'published')->take(5)->get();
    } else {
      $productMap = Product::whereIn('id', array_keys($top->toArray()))
        ->where('status', 'published')
        ->get()
        ->keyBy('id');

      foreach ($top as $productId => $sold) {
        if (isset($productMap[$productId])) {
          $p = $productMap[$productId];
          $p->total_sold = (int) $sold;
          $products->push($p);
        }
      }
    }

    if ($products->isEmpty()) {
      return ['text' => 'Hiện chưa có dữ liệu sản phẩm bán chạy.', 'meta' => ['source' => 'suggestions', 'count' => 0]];
    }

    return ['text' => $this->formatProductList($products), 'meta' => ['source' => 'suggestions', 'count' => $products->count()]];
  }

  private function matchFaq(string $message): ?FaqEntry
  {
    $messageLower = mb_strtolower($message);

    $faqTopics = [
      'warranty' => ['bảo hành', 'bảo đảm', 'bh', 'đổi mới'],
      'payment' => ['thanh toán', 'trả tiền', 'payment'],
      'shipping' => ['vận chuyển', 'ship', 'giao hàng'],
      'returns' => ['đổi trả', 'hoàn hàng', 'refund', 'đổi lại'],
    ];

    foreach ($faqTopics as $topic => $keywords) {
      foreach ($keywords as $w) {
        if (mb_strpos($messageLower, $w) !== false) {
          return FaqEntry::where('topic', $topic)->where('active', 1)->first();
        }
      }
    }

    return null;
  }

  private function searchProducts(string $message)
  {
    // 1. quick keyword filter (safe, fast)
    $keywords = preg_split('/\s+/u', mb_strtolower($message));
    $q = Product::query()->where('status', 'published')->whereNotNull('embedding');

    // try match by category/name/slug keywords
    $q->where(function ($b) use ($keywords) {
      foreach ($keywords as $kw) {
        $kw = trim($kw);
        if ($kw === '')
          continue;
        $b->orWhere('name', 'LIKE', "%{$kw}%")
          ->orWhere('description', 'LIKE', "%{$kw}%")
          ->orWhere('slug', 'LIKE', "%{$kw}%");
      }
    });

    // fallback: if keyword filter returns nothing, broaden to all published with embedding
    $candidates = $q->take(200)->get();
    if ($candidates->isEmpty()) {
      $candidates = Product::whereNotNull('embedding')->where('status', 'published')->take(200)->get();
    }

    // 2. embed query and rerank
    try {
      $ollamaBase = rtrim(config('ollama.base', env('OLLAMA_BASE', 'http://localhost:11434')), '/');
      $resp = Http::post("{$ollamaBase}/api/embed", ['model' => $this->embeddingModel, 'input' => $message]);
      if (!$resp->ok()) {
        \Log::warning('ollama.embed_failed', ['status' => $resp->status()]);
        return null;
      }
      $qv = $resp->json()['embeddings'][0] ?? null;
      if (!$qv)
        return null;
    } catch (\Exception $e) {
      \Log::error('ollama.embed_exc', ['msg' => $e->getMessage()]);
      return null;
    }

    $scored = collect();
    foreach ($candidates as $p) {
      $emb = is_string($p->embedding) ? json_decode($p->embedding, true) : $p->embedding;
      if (!is_array($emb) || count($emb) !== count($qv))
        continue;
      // compute dot (query and db likely L2-normalized -> dot == cosine)
      $dot = 0;
      $m1 = 0;
      $m2 = 0;
      for ($i = 0; $i < count($qv); $i++) {
        $a = (float) $qv[$i];
        $b = (float) $emb[$i];
        $dot += $a * $b;
        $m1 += $a * $a;
        $m2 += $b * $b;
      }
      $score = ($m1 > 0 && $m2 > 0) ? $dot / (sqrt($m1) * sqrt($m2)) : 0;
      $p->score = $score;
      $scored->push($p);
    }

    // sort and take top 8
    $top = $scored->sortByDesc('score')->values()->take(8);

    // If no good scores, optionally return top-k by simple keyword match (no embedding)
    if ($top->isEmpty() && !empty($candidates)) {
      return $candidates->take(5);
    }

    // Option: set threshold from env
    $threshold = (float) env('CHATBOT_EMBED_THRESHOLD', 0.55);
    $final = $top->filter(fn($p) => $p->score >= $threshold);
    // If final empty, loosen and return top regardless (to avoid always fallback)
    if ($final->isEmpty()) {
      return $top; // return best candidates even if low score
    }
    return $final;
  }


  private function cosineSimilarity(array $a, array $b): float
  {
    $dot = 0;
    $m1 = 0;
    $m2 = 0;
    foreach ($a as $i => $v) {
      $bv = $b[$i] ?? 0;
      $dot += $v * $bv;
      $m1 += $v * $v;
      $m2 += $bv * $bv;
    }
    return ($m1 > 0 && $m2 > 0) ? ($dot / (sqrt($m1) * sqrt($m2))) : 0.0;
  }

  private function formatProductList($items)
  {
    $txt = "🔥 Sản phẩm liên quan bạn có thể quan tâm:\n\n";
    foreach ($items as $p) {
      $price = $p->final_price ?? ($p->price ?? null);
      $priceText = $price ? number_format($price) . " đ" : '';
      $line = "• {$p->name} {$priceText}";
      if (isset($p->total_sold))
        $line .= " | Đã bán: {$p->total_sold}";
      $txt .= $line . "\n";
    }
    return $txt;
  }

  private function fallbackMessage()
  {
    return [
      'text' => "Mình chưa rõ ý bạn. Bạn muốn hỏi về:\n1) Bảo hành\n2) Thanh toán\n3) Vận chuyển\n4) Đổi trả\n5) Gợi ý sản phẩm bán chạy?",
      'meta' => [
        'source' => 'fallback',
        'quick_replies' => [
          ['title' => 'Bảo hành', 'payload' => 'faq:warranty'],
          ['title' => 'Thanh toán', 'payload' => 'faq:payment'],
          ['title' => 'Vận chuyển', 'payload' => 'faq:shipping'],
          ['title' => 'Đổi trả', 'payload' => 'faq:returns'],
          ['title' => 'Sản phẩm bán chạy', 'payload' => 'suggest:top_sellers'],
        ]
      ]
    ];
  }
}
