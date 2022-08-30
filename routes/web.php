<?php

use App\Route;
use App\Controllers\LogController;
use App\Controllers\CurlController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;
use App\Controllers\InvokeController;
use App\Middleware\AnotherLogMiddleware;
use App\Router;
use App\Routing\Redirect;

Route::get('/', [HomeController::class, 'index'])->middleware(AnotherLogMiddleware::class)->name('homepage');
Route::get('/no-twig', [HomeController::class, 'welcomeWithoutTwig']);
Route::get('/task', [TaskController::class, 'index'])->name('tasks');
Route::get('/curl', [CurlController::class, 'index'])->name('dutch-railway-example');
Route::get('/log', [LogController::class, 'index'])->name('log');
Route::get('/invoke', InvokeController::class)->name('invoke');

Route::get('/test2/{value}', [HomeController::class, 'placeholderTester']);

// TODO add middleware support to match routes
Route::match(['get', 'post'], '/get-post-example', function () {
    dd('Get post example route');
});

Route::get('/company/{company}/department/{department}', function ($company, $department) {
    echo "Company: {$company}, department: {$department}";
});

Route::get('/away', function () {
    Redirect::to('/log');
});

Route::get('/away-named-route', function () {
    Redirect::to(Router::getRouteByName('log'));
});
