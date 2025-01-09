<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPositionController;

Route::apiResource('users', UserController::class)->only(['index','show','store']);
Route::apiResource('positions', UserPositionController::class)->only('index');