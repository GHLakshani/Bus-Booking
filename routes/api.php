<?php

use App\Http\Controllers\GpsController;
use Illuminate\Support\Facades\Route;

// GPS tracking API endpoints (used by GPS devices and the frontend polling)
Route::post('/gps/update', [GpsController::class, 'updateLocation']);
Route::get('/gps/{busSchedule}', [GpsController::class, 'getLocation']);
