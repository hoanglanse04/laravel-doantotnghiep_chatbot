<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaEmbedService
{
  protected string $base;

  public function __construct()
  {
    $this->base = env('OLLAMA_BASE', 'http://127.0.0.1:11434');
  }

  /**
   * Trả về 1 vector float[] (embedding) cho text
   * @param string $text
   * @param string $model (vd: all-minilm, embeddinggemma)
   * @return array
   * @throws \Exception
   */
  public function embed(string $text, string $model = 'all-minilm'): array
  {
    $resp = Http::post($this->base . '/api/embed', [
      'model' => $model,
      'input' => $text,
    ]);

    if (!$resp->ok()) {
      throw new \Exception('Ollama embed error: ' . $resp->body());
    }

    $json = $resp->json();

    if (isset($json['embeddings'])) {
      return $json['embeddings'][0];
    }
    if (isset($json['embedding'])) {
      // some versions return 'embedding'
      return is_array($json['embedding'][0]) ? $json['embedding'][0] : $json['embedding'];
    }

    throw new \Exception('Unexpected embed response: ' . json_encode($json));
  }
}
