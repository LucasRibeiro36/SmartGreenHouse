<?php

use App\Http\Controllers\SoilSensorDataController;
use App\Http\Controllers\TempSensorDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Nomeie as rotas aqui
Route::get('/get_latest_temp_data', [TempSensorDataController::class, 'getLatestData'])->name('api.get_latest_temp_data');
Route::get('/get_latest_soil_data', [SoilSensorDataController::class, 'getLatestData'])->name('api.get_latest_soil_data');
Route::post('/save_temp_data', [TempSensorDataController::class, 'saveData'])->name('api.save_temp_data');
Route::post('/save_soil_data', [SoilSensorDataController::class, 'saveData'])->name('api.save_soil_data');
