<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\User\LearnTopicController;
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

Route::get('d0/{avathar}/{name}', [DocumentController::class, 'getuploadedFiles'])->name('file.view');
Route::get('/d0/{avathar}/{name}/download', [DocumentController::class, 'downloaduploadedFiles'])->name('file.download');

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
    Route::post('/progress',[UserMainController::class,'progress'])->name('progress');
    Route::post('/getprogress',[UserMainController::class,'getprogress'])->name('getprogress');
    Route::get('/logout',[UserMainController::class,'logout'])->name('logout');
    Route::get('/profile/edit',[ProfileController::class,'index'])->name('profile.edit');
    Route::post('/profile/edit',[ProfileController::class,'update']);
    Route::get('/profile',[ProfileController::class,'view'])->name('profile.view');


    Route::prefix('learn')->name('learn.')->group(function () { 
        Route::get('/',[LearnTopicController::class,'index'])->name('index');
        Route::get('/{category}',[LearnTopicController::class,'show'])->name('show');
        Route::get('/{category}/lesson/{sub_category}',[LearnTopicController::class,'lessonshow'])->name('lesson.show');
        Route::get('/{category}/lesson/{sub_category}/review',[LearnTopicController::class,'lessonreview'])->name('lesson.review');
        Route::get('/{category}/create',[LearnTopicController::class,'create'])->name('create');
        Route::get('/{category}/{learn}/edit',[LearnTopicController::class,'edit'])->name('edit');
        Route::post('/{category}/store',[LearnTopicController::class,'store'])->name('store');  
        Route::put('/{category}/{learn}/update',[LearnTopicController::class,'update'])->name('update');

        Route::delete('/{category}/{learn}',[LearnTopicController::class,'destroy'])->name('destroy');
    });

});

Route::middleware('signed')->get('email/{id}/{hash}/verify', [HomeController::class,'verifyemail'])->name('verification.verify');