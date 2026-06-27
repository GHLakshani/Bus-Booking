<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusScheduleController;
use App\Http\Controllers\GpsController;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/', [BusScheduleController::class, 'home'])->name('home');
Route::post('/search', [BusScheduleController::class, 'search'])->name('search');
Route::get('/seat-booking/{busSchedule}', [BusScheduleController::class, 'seatBooking'])->name('seat.booking');
Route::get('/track-bus/{busSchedule}', [GpsController::class, 'trackBus'])->name('track.bus');

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated User ────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/my-account', [BookingController::class, 'myAccount'])->name('my.account');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings');
    Route::post('/book/{busSchedule}', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/cancel-booking/{booking}', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/buses', [AdminController::class, 'busIndex'])->name('buses');
    Route::get('/buses/create', [AdminController::class, 'busCreate'])->name('buses.create');
    Route::post('/buses', [AdminController::class, 'busStore'])->name('buses.store');
    Route::get('/buses/{busSchedule}/edit', [AdminController::class, 'busEdit'])->name('buses.edit');
    Route::put('/buses/{busSchedule}', [AdminController::class, 'busUpdate'])->name('buses.update');
    Route::delete('/buses/{busSchedule}', [AdminController::class, 'busDestroy'])->name('buses.destroy');
    Route::get('/bookings', [AdminController::class, 'viewBookings'])->name('bookings');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
    Route::get('/notify-delay', [AdminController::class, 'notifyDelayForm'])->name('notify.delay');
    Route::post('/notify-delay', [AdminController::class, 'notifyDelaySubmit'])->name('notify.submit');
    Route::get('/update-gps', [GpsController::class, 'adminGpsForm'])->name('update.gps');
    Route::post('/update-gps', [GpsController::class, 'adminGpsSubmit'])->name('gps.submit');
});
