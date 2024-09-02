<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {

  return Redirect::route('login');
  // return Inertia::render('Welcome', [
  //   'canLogin' => Route::has('login'),
  //   'canRegister' => Route::has('register'),
  //   'laravelVersion' => Application::VERSION,
  //   'phpVersion' => PHP_VERSION,
  // ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
  Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
  })->name('dashboard');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->resource('/users', UserController::class);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->resource('/dashboard/customers', CustomerController::class);
