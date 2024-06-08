<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\MainController as UserMainController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/**
 * Development
 */

Route::get('/rollback', function() {
    Artisan::call('migrate:rollback');
    dd(Artisan::output());
});


Route::get('/migrate', function() {
    Artisan::call('migrate');
    dd(Artisan::output());
});
Route::get('/fresh', function() {
    Artisan::call('migrate:fresh');
    dd(Artisan::output());
});


Route::get('/db-seed', function() {
    Artisan::call('db:seed');
    dd(Artisan::output());
});



Route::get('/',[HomeController::class,'index']);

Route::middleware('guest')->group(function(){
    Route::get('/login', [HomeController::class,'login'])->name('login');
    Route::post('/login', [HomeController::class,'loginSubmit']);
    Route::get('/register', [HomeController::class,'register'])->name('register');
    Route::post('/register', [HomeController::class,'registerSubmit']);
});
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[UserMainController::class,'index'])->name('dashboard');
    Route::get('/logout',[UserMainController::class,'logout'])->name('logout');

    Route::get('/profile',[ProfileController::class,'index'])->name('profile');


});

Route::middleware('signed')->get('email/{id}/{hash}/verify', [HomeController::class,'verifyemail'])->name('verification.verify');