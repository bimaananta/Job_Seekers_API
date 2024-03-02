<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AvailablePositionController;
use App\Http\Controllers\JobApplySocietyController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\ValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "/v1"], function(){
    Route::group(["prefix" => "/auth"], function(){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // Development routes
    Route::apiResource('/vacancy', JobVacancyController::class);
    Route::apiResource('/position', AvailablePositionController::class);
    Route::apiResource('/validation', ValidationController::class);
    Route::apiResource('/applications', JobApplySocietyController::class);
    Route::apiResource('/society', SocietyController::class);
});
