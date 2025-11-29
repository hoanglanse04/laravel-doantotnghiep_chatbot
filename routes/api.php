<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::post('/chat/send', action: [ChatbotController::class, 'send']);
