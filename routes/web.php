<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/events', [DashboardController::class, 'userEvents'])->name('dashboard.events');
    Route::post('/topup', [DashboardController::class, 'topUp'])->name('dashboard.topup');

    // Customer Bookings
    Route::get('/bookings/checkout', [BookingController::class, 'checkoutForm'])->name('bookings.checkout');
    Route::post('/bookings/checkout', [BookingController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/bookings/receipt/{code}', [BookingController::class, 'showReceipt'])->name('bookings.receipt');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');

    // Admin Specific Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // Category Management
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // Event Management
        Route::get('/admin/events', [EventController::class, 'adminIndex'])->name('admin.events.index');
        Route::get('/admin/events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/admin/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::put('/admin/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
        Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');

        // Transaction Management
        Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
        Route::post('/admin/transactions/{booking}/cancel', [TransactionController::class, 'cancel'])->name('admin.transactions.cancel');

        // User Management
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.role');
    });
});

