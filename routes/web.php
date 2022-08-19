<?php

use App\Route;
use App\Controllers\CurlController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/task', [TaskController::class, 'index']);
Route::get('/curl', [CurlController::class, 'index']);

Route::match(['get', 'post'], '/get-post-example', function () {
    dd('Get post example route');
});

Route::get('/company/{company}/department/{department}', function ($company, $department) {
    echo "Company: {$company}, department: {$department}";
});

Route::get('/test2/{value}', [HomeController::class, 'placeholderTester']);
