<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'showFeedbackForm'])
    ->name('feedback.form');

Route::post('/feedback', [PageController::class, 'submitFeedback'])
    ->name('feedback.submit');

Route::get('/feedback/success', [PageController::class, 'feedbackSuccess'])
    ->name('feedback.success');
