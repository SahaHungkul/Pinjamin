<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CategoryImageController;
use App\Http\Controllers\Api\V1\ToolController;
use App\Http\Controllers\Api\V1\ToolImageController;
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

        Route::get('/tools/option', [ToolController::class, 'option']);
        Route::post('/tools/{id}/image', [ToolImageController::class, 'store']);
        Route::apiResource('tools', ToolController::class);
    });
});
