<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WasteRequestController;
use Illuminate\Support\Facades\Route;

// ── Public: Home ─────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Public: Auth ─────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Protected: Dashboard ─────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Waste Requests
    Route::get('/request/new',   [WasteRequestController::class, 'create'])->name('request.create');
    Route::post('/request/new',  [WasteRequestController::class, 'store'])->name('request.store');
    Route::get('/request/confirmation/{trackingNumber}', [WasteRequestController::class, 'confirmation'])->name('request.confirmation');

    // Admin: All Requests
    Route::get('/requests',                              [WasteRequestController::class, 'index'])->name('requests.index');
    Route::patch('/requests/{wasteRequest}/status',      [WasteRequestController::class, 'updateStatus'])->name('requests.updateStatus');
});

// ── Public: Track (no login needed) ──────────────────────────────
Route::match(['get', 'post'], '/request/track', [WasteRequestController::class, 'track'])->name('request.track');

// ── Public: Contact ───────────────────────────────────────────────
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
