<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OllamaEmbedService;
use App\Models\FaqEntry;
use App\Models\Product;

class EmbedFaqProducts extends Command
{
  protected $signature = 'embed:build {--model=all-minilm}';
  protected $description = 'Build embeddings for FAQ entries and products using Ollama';

  protected OllamaEmbedService $embedSvc;

  public function __construct(OllamaEmbedService $embedSvc)
  {
    parent::__construct();
    $this->embedSvc = $embedSvc;
  }

  public function handle()
  {
    $model = $this->option('model') ?? 'all-minilm';
    $this->info("Using model: {$model}");

    $faqs = FaqEntry::where('active', true)->get();
    $this->info("Embedding {$faqs->count()} FAQ entries...");
    foreach ($faqs as $faq) {
      $text = trim(($faq->question ?? '') . "\n" . ($faq->answer ?? ''));
      try {
        $vec = $this->embedSvc->embed($text, $model);
        $faq->embedding = json_encode($vec);
        $faq->save();
        $this->line("Saved FAQ: {$faq->id}");
      } catch (\Exception $e) {
        $this->error("FAQ {$faq->id} error: " . $e->getMessage());
      }
    }

    $products = Product::where('status', 'published')->get();
    $this->info("Embedding {$products->count()} products...");
    foreach ($products as $p) {
      $text = trim($p->name . "\n" . ($p->description ?? ''));
      try {
        $vec = $this->embedSvc->embed($text, $model);
        $p->embedding = json_encode($vec);
        $p->save();
        $this->line("Saved Product: {$p->id}");
      } catch (\Exception $e) {
        $this->error("Product {$p->id} error: " . $e->getMessage());
      }
    }

    $this->info("Done.");
  }
}
