<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login',[UserController::class, 'loginProcess'])->name('login.process');

Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::post('/contact', [HomeController::class, 'store'])->name('contact.store');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register',[UserController::class, 'registerProcess'])->name('register.process');