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

    public function ask(Request $request)
{
    $message = $request->input('message', 'Hello');
    try {
        $response = $this->chatbotService->getChatbotResponse($message);
        Log::info('Chatbot response received:', ['response' => $response]);
        return response()->json([
            'response' => $response,
        ]);
    } catch (\Exception $e) {
        Log::error('Error in Chatbot API:', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Failed to get a response from the chatbot.'], 500);
    }
}
}
