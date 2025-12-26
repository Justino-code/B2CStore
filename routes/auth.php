<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Auth\AuthManager;
use App\Livewire\Auth\RegisterManager;

Route::middleware('guest')->group(function () {
    // Rota de registro
    Volt::route('register', RegisterManager::class)
        ->name('register');

    // Rota de login
    Volt::route('login', AuthManager::class)
        ->name('login');

    // Rota de solicitação de senha esquecida
    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    // Rota de reset de senha
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    // Rota de verificação de e-mail
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    // Rota de verificação de e-mail com hash
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Rota para confirmação de senha
    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    // Rota de logout
    Route::post('logout', [AuthManager::class, 'logout'])
        ->name('logout'); // Chama o método logout do componente Livewire
});

