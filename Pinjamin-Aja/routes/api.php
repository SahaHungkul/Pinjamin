<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CategoryImageController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::post('/login',[AuthController::class,'login']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/me', [AuthController::class,'me']);
        Route::post('/logout', [AuthController::class,'logout']);

        Route::get('/categories/option',[CategoryController::class, 'option']);
        // Route::post('categories/{id}/image',[CategoryImageController::class, 'store']);
        Route::apiResource('categories', CategoryController::class);
    });
});
