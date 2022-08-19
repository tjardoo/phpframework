<?php

use App\Route;
use App\Controllers\CurlController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/task', [TaskController::class, 'index']);
Route::get('/curl', [CurlController::class, 'index']);
