<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;  // Make sure this is here

Route::get('/', function () {
    return view('welcome');
});

// Define the route for frontend testing (optional)
Route::get('/chatbot', function () {
    return view('chatbot');  // This will load the frontend page for the chatbot
});

Route::post('/ask-question', [ChatbotController::class, 'askQuestion'])->name('ask.question');
Route::post('/ask', [ChatbotController::class, 'ask']);  // Check for this route as well

