<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia('Home');
});

Route::get('/questions', [QuestionController::class, 'index'])->name('questions');
Route::post('/questions', [QuestionController::class, 'store']);
Route::put('/question', [QuestionController::class, 'update']);
Route::delete('/questions/{question}', [QuestionController::class, 'destroy']);
Route::put('/answers', [AnswerController::class, 'update']);

Route::get('/quiz', [QuizController::class, 'index']);
Route::post('/results', [QuizController::class, 'results']);

// INCASE SOME ROUTES THAT BRING PROBLEMS ARE ENGAGED
Route::fallback(function(){
    return Inertia('Home');
});
