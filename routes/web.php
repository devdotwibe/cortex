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

    Route::get('/password-reset', [HomeController::class,'sendresetlink'])->name('password-reset');
    Route::post('/password-reset', [HomeController::class,'submitresetlink']);

    Route::get('/password-change/{token}', [HomeController::class,'resetpassword'])->name('password.reset');
    Route::post('/password-change/{token}', [HomeController::class,'updatepassword']);
    
});
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[UserMainController::class,'index'])->name('dashboard');
    Route::get('/logout',[UserMainController::class,'logout'])->name('logout');

    Route::get('/profile/edit',[ProfileController::class,'index'])->name('profile.edit');
    Route::post('/profile/edit',[ProfileController::class,'update']);

    Route::get('/profile',[ProfileController::class,'view'])->name('profile.view');

   
});

Route::middleware('signed')->get('email/{id}/{hash}/verify', [HomeController::class,'verifyemail'])->name('verification.verify');