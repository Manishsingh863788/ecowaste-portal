<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WasteRequestController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleController;

// ── Public: Home ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Public: Auth (guests only) ────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Google OAuth Routes
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Protected: Logged-in users ────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Waste Requests (any logged-in user)
    Route::get('/request/new',  [WasteRequestController::class, 'create'])->name('request.create');
    Route::post('/request/new', [WasteRequestController::class, 'store'])->name('request.store');
    Route::get('/request/confirmation/{trackingNumber}', [WasteRequestController::class, 'confirmation'])->name('request.confirmation');
});

// ── Admin Only ────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {
    // All requests list + status update — admin only
    Route::get('/requests', [WasteRequestController::class, 'index'])->name('requests.index');
    Route::patch('/requests/{wasteRequest}/status', [WasteRequestController::class, 'updateStatus'])->name('requests.updateStatus');
});

// ── Public: Track (everyone can track, but cannot change status) ──
Route::match(['get', 'post'], '/request/track', [WasteRequestController::class, 'track'])->name('request.track');

// ── Public: Contact ───────────────────────────────────────────────
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ── Admin Setup Helper ────────────────────────────────────────────
Route::get('/seed-admin', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return response()->json([
        'status'  => 'success',
        'message' => 'Database migrated and admin user created successfully!',
        'admin'   => [
            'email'    => 'admin@ecowaste.com',
            'password' => 'password',
        ],
    ]);
});

