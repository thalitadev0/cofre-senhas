<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TwoFactorController;

// Rota pública
Route::get('/', function () {
    return view('welcome');
});

// Rotas de 2FA — protegidas só com auth
Route::middleware('auth')->group(function () {
    Route::get('/2fa', [TwoFactorController::class, 'index'])->name('2fa.index');
    Route::post('/2fa', [TwoFactorController::class, 'store'])->name('2fa.store');
    Route::get('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');
});

// Rotas protegidas com auth + 2FA obrigatório
Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Exportação ANTES do resource para não conflitar
    Route::get('/passwords/export', [PasswordController::class, 'export'])->name('passwords.export');

    // CRUD de senhas
    Route::resource('passwords', PasswordController::class);

    // Perfil
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
