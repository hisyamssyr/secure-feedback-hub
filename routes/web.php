<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'showFeedbackForm'])->name('feedback.form');
Route::post('/feedback', [PageController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/feedback/success', [PageController::class, 'feedbackSuccess'])->name('feedback.success');

Route::get('/admin', [AdminController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
