<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

Route::post('/get-data', [SensorController::class, 'store']);
Route::get('/get-data', fn () => response('', 204));
