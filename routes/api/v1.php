<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/me', function (Request $request) {
    return response()->json([
        'data' => $request->user()
    ]);
})->middleware('auth:sanctum');

Route::prefix('/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify', [AuthController::class, 'verify']);
});
