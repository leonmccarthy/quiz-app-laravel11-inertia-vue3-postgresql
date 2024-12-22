<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia('Home');
});

Route::get('/questions', [QuestionController::class, 'index']);