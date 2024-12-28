<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia('Home');
});

Route::get('/questions', [QuestionController::class, 'index'])->name('questions');
Route::post('/questions', [QuestionController::class, 'store']);
Route::put('/answers', [AnswerController::class, 'update']);
