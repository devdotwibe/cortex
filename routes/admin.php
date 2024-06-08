<?php

use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->group(function(){
    Route::middleware('guest:admin')->group(function(){
        Route::get('/login', [AdminMainController::class,'login'])->name('login');
        Route::post('/login', [AdminMainController::class,'loginSubmit']);
    });
    Route::middleware('auth:admin')->group(function(){
        Route::get('/',[AdminMainController::class,'index']);
        Route::get('/dashboard',[AdminMainController::class,'index'])->name('dashboard');
        Route::get('/logout',[AdminMainController::class,'logout'])->name('logout');

        Route::resource("/user",UserController::class);
        Route::resource("/exam",ExamController::class);


        
    });





});
