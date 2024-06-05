<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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



Route::get('/',  [HomeController::class,'index']);
