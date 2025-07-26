<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\API\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserController::class, 'me']);

    // Company
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{company}', [CompanyController::class, 'show']);
    Route::put('/companies/{company}', [CompanyController::class, 'update']);
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);

    // Set Active Company
    Route::post('/companies/{company}/set-active', [UserController::class, 'setActiveCompany']);

    // projects
    Route::get('/projects-details', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
});
