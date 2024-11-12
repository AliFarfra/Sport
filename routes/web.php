<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\AdherentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Adherent routes
Route::middleware(['auth'])->group(function () {
    Route::get('/adherents/dashboard', [AdherentController::class, 'dashboard'])
        ->name('adherents.dashboard');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->hasRole('admin')) {
            return view('dashboard'); // Admin dashboard view
        } elseif (Auth::user()->hasRole('adherent')) {
            return redirect()->route('adherents.dashboard'); // Redirect adherents to their dashboard
        }

        return redirect('/')->with('error', 'You do not have access to this page.');
    })->name('dashboard');

    Route::resource('packs', PackController::class);
    Route::resource('cours', CoursController::class);
    Route::resource('administrateurs', AdministrateurController::class);
    Route::resource('adherents', AdherentController::class);

    // Subscription routes
    Route::get('users/{user}/subscriptions/create', [AdherentController::class, 'createSubscription'])
        ->name('users.createSubscription');
    Route::post('subscriptions', [AdherentController::class, 'storeSubscription'])
        ->name('subscriptions.store');
    Route::delete('subscriptions/{subscription}', [AdherentController::class, 'destroySubscription'])
        ->name('subscriptions.destroy');
// Routes for payments
Route::get('/adherents/{userId}/payment', [AdherentController::class, 'createPayment'])->name('adherents.createPayment');
Route::post('/adherents/payment/store', [AdherentController::class, 'storePayment'])->name('adherents.storePayment');    // Profile routes
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';