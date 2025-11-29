<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class GenerateProductEmbeddings extends Command
{
  protected $signature = 'products:generate-embeddings';
  protected $description = 'Generate embeddings for all products using Ollama';

  private string $model = 'all-minilm';

  public function handle()
  {
    $ollamaBase = rtrim(config('ollama.base'), '/');

    $products = Product::where('status', 'published')->get();

    if ($products->isEmpty()) {
      $this->warn("No published products found.");
      return;
    }

    $this->info("Generating embeddings for {$products->count()} products...");

    foreach ($products as $product) {
      $text = trim(strip_tags($product->name . ' ' . $product->description));

      if (!$text) {
        $this->warn("Product {$product->id} skipped (empty text).");
        continue;
      }

      $response = Http::post("{$ollamaBase}/api/embed", [
        'model' => $this->model,
        'input' => $text
      ]);

      if (!$response->ok()) {
        $this->error("Failed embedding for product {$product->id}");
        continue;
      }

      $embedding = $response->json()['embeddings'][0] ?? null;

      if ($embedding) {
        $product->embedding = json_encode($embedding);
        $product->save();

        $this->info("✔ Product {$product->id} updated");
      } else {
        $this->error("❌ No vector returned for product {$product->id}");
      }

      sleep(1); // tránh spam API
    }

    $this->info("All embeddings generated successfully!");
  }
}
