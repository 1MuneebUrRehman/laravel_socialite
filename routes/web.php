<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');

Route::get('/privacypolicy', function () {
    return view('privacypolicy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Socialite Github
Route::get('/auth/redirect', [LoginController::class,'githubRedirect']);
Route::get('/auth/callback', [LoginController::class,'githubCallback']);

// Socialite Google
Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

// Socialite Facebook
Route::get('auth/facebook', [LoginController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [LoginController::class, 'loginWithFacebook']);
