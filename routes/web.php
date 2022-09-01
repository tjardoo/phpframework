<?php

use App\Route;
use App\Controllers\LogController;
use App\Controllers\CurlController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;
use App\Controllers\InvokeController;
use App\Controllers\UploadController;
use App\Middleware\AnotherLogMiddleware;

Route::get('/', [HomeController::class, 'index'])->middleware(AnotherLogMiddleware::class)->name('homepage');
Route::get('/no-twig', [HomeController::class, 'welcomeWithoutTwig']);
Route::get('/task', [TaskController::class, 'index'])->name('tasks');
Route::get('/curl', [CurlController::class, 'index'])->name('dutch-railway-example');
Route::get('/log', [LogController::class, 'index'])->name('log');
Route::get('/invoke', InvokeController::class)->name('invoke');

Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');

Route::get('/test2/{value}', [HomeController::class, 'placeholderTester']);

// TODO add middleware support to match routes
Route::match(['get', 'post'], '/get-post-example', function () {
    dd('Get post example route');
});

Route::get('/company/{company}/department/{department}', function ($company, $department) {
    echo "Company: {$company}, department: {$department}";
});

Route::get('/away', function () {
    redirect('/log');
});

Route::get('/away-named-route', function () {
    redirect(route('log'));
});
