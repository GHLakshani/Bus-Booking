<?php

use App\Http\Controllers\GpsController;
use Illuminate\Support\Facades\Route;

// GPS write endpoint — requires X-GPS-Token header (for GPS devices / drivers)
Route::middleware('api.token')->post('/gps/update', [GpsController::class, 'updateLocation']);

// GPS read endpoint — open to all (polled by passenger tracking page)
Route::get('/gps/{busSchedule}', [GpsController::class, 'getLocation']);
