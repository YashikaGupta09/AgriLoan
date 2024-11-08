<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

// Route for frontend chatbot page
Route::get('/chatbot', function () {
    return view('chatbot');  // Load the chatbot frontend view
});

// Route for processing the question
Route::post('/ask-question', [ChatbotController::class, 'askQuestion'])->name('ask.question');
