<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\OpeningScreen;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitScheduleController;
use App\Http\Controllers\MoodController;

Route::get('/', OpeningScreen::class);
Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
Route::get('/otp-verification', [AuthController::class, 'showOtpVerification'])->name('otp-verification');
Route::get('/dashboard', function () {
    return view('dashboard'); 
})->middleware('auth')->name('dashboard');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/opening-screen', function () {
    return view('opening');
})->name('opening');
Route::get('/create-habit', function () {
    return view('create-habit');
});
Route::get('/next-screen', function () {
    return view('next-screen');
});
Route::post('/store-habit', [HabitController::class, 'store'])->middleware('auth');
Route::post('/store-habit-schedule', [HabitScheduleController::class, 'store']);
Route::get('/activity-tracker', [HabitScheduleController::class, 'showActivityTracker'])->middleware('auth');
Route::get('/get-habits', [HabitScheduleController::class, 'getHabits'])->middleware('auth');
Route::get('/get-habit-count', [HabitScheduleController::class, 'getHabitsByMonth'])->middleware('auth');
Route::get('/habit-tracker', [HabitScheduleController::class, 'showHabits'])->middleware('auth');
Route::get('/home', function () {
    return view('home');
});

Route::get('/profile', function () {
    return view('profile');
});
Route::post('/mood/save', [MoodController::class, 'store'])->middleware('auth');
Route::middleware('auth')->get('/mood/fetch', [MoodController::class, 'fetch']);
