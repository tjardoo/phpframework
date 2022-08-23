<?php

use App\Route;
use App\Controllers\LogController;
use App\Controllers\CurlController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;
use App\Controllers\InvokeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/task', [TaskController::class, 'index']);
Route::get('/curl', [CurlController::class, 'index']);
Route::get('/log', [LogController::class, 'index']);
Route::get('/invoke', InvokeController::class);

Route::match(['get', 'post'], '/get-post-example', function () {
    dd('Get post example route');
});

Route::get('/company/{company}/department/{department}', function ($company, $department) {
    echo "Company: {$company}, department: {$department}";
});

Route::get('/test2/{value}', [HomeController::class, 'placeholderTester']);
