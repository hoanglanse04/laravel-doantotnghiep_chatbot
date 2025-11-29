<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatbotAgent;
use App\Models\ChatSession;
use App\Models\ChatMessage;

class ChatbotController extends Controller
{
  protected ChatbotAgent $agent;

  public function __construct(ChatbotAgent $agent)
  {
    $this->agent = $agent;
  }

  public function send(Request $request)
  {
    $user = $request->user();
    $session = ChatSession::firstOrCreate(
      ['user_id' => $user?->id, 'status' => 'open'],
      ['meta' => json_encode(['ip' => $request->ip()])]
    );

    $msg = $request->input('message') ?? $request->input('text') ?? '';
    $payload = $request->input('payload') ?? null; // payload từ quick reply (nếu có)

    // Save user message (optional)
    ChatMessage::create([
      'session_id' => $session->id,
      'sender' => 'user',
      'content' => $msg,
      'metadata' => $payload ? json_encode(['payload' => $payload]) : null,
    ]);

    // Gọi agent: truyền payload (nếu có)
    $reply = $this->agent->handle($session, $msg, $payload, $user);

    // Save bot message
    ChatMessage::create([
      'session_id' => $session->id,
      'sender' => 'bot',
      'content' => $reply['text'] ?? '',
      'metadata' => isset($reply['meta']) ? json_encode($reply['meta']) : null,
    ]);

    return response()->json(['reply' => $reply]);
  }
}
