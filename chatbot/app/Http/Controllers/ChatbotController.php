<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function askQuestion(Request $request)
    {
        $message = $request->input('message', 'Hello');
        try {
            $response = $this->chatbotService->getChatbotResponse($message);
            return response()->json(['answer' => $response]);
        } catch (\Exception $e) {
            Log::error('Error in Chatbot API:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to get a response from the chatbot.'], 500);
        }
    }
}
