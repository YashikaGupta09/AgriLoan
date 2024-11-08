<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    public function getChatbotResponse($message)
    {
        $url = 'https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill';
        $payload = ['inputs' => $message];
        
        $apiKey = env('HUGGINGFACE_API_KEY');  // Ensure your API key is in .env file

        Log::info('Attempting API Request:', ['url' => $url, 'payload' => $payload]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post($url, $payload);

        if ($response->successful()) {
            $data = $response->json();
            return $data[0]['generated_text'] ?? 'No response generated';
        } else {
            Log::error('Failed API response', ['status' => $response->status(), 'body' => $response->body()]);
            return 'Failed to retrieve response from the model';
        }
    }
}
