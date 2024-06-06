<?php

use App\Http\Controllers\Admin\MainController; 
use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->group(function(){
    Route::middleware('guest:admin')->group(function(){
        Route::get('/login', [MainController::class,'login'])->name('login');
        Route::post('/login', [MainController::class,'loginSubmit']);
    });
    Route::middleware('auth:admin')->group(function(){
        Route::get('/',[MainController::class,'index']);
        Route::get('/dashboard',[MainController::class,'index']);
        Route::get('/logout',[MainController::class,'logout'])->name('logout');
    });
});
