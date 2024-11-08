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
        
        try {
            // Use a temporary hardcoded API key for debugging
            $apiKey = 'YOUR_ACTUAL_API_KEY';

            Log::info('Attempting API Request:', ['url' => $url, 'payload' => $payload, 'api_key' => $apiKey]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post($url, $payload);

            Log::info('Response status:', [$response->status()]);
            Log::info('Response body:', [$response->body()]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Chatbot Response:', ['data' => $data]);
                return $data[0]['generated_text'] ?? 'No response generated';
            } else {
                Log::error('Failed API response', ['status' => $response->status(), 'body' => $response->body()]);
                return 'Failed to retrieve response from the model';
            }
        } catch (\Exception $e) {
            Log::error('Exception in ChatbotService', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 'Exception occurred';
        }
    }
}
