<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\LearnController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\QuestionBankChapterController;
use App\Http\Controllers\Admin\QuestionBankController;
use App\Http\Controllers\Admin\QuestionBankSectionController;
use App\Http\Controllers\Admin\QuestionBankTopicController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SetController;
use App\Http\Controllers\Admin\UploadController;
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

        Route::prefix('question-bank')->name('question-bank.')->group(function () { 
            Route::get('/',[QuestionBankController::class,'index'])->name('index');
            Route::get('/{category}',[QuestionBankController::class,'show'])->name('show');
            Route::get('/{category}/create',[QuestionBankController::class,'create'])->name('create');
            Route::post('/{category}/store',[QuestionBankController::class,'store'])->name('store');  
        });
        Route::post('/upload', [UploadController::class, 'uploadfile'])->name('upload');


        Route::resource("/question",QuestionController::class);

        Route::resource("/learn",LearnController::class);

    
        Route::resource("/options",CategoryController::class);

        Route::resource("/set",SetController::class);

        Route::get('/set/view',[SetController::class,'set_table_show'])->name('set_table.show');

        Route::post('/set/store/{slug}',[SetController::class,'set_store'])->name('set.set_store');
        

        Route::post('/add-subcatecory/{slug}',[CategoryController::class,'add_subcatecory'])->name('add_subcatecory');

        Route::get('/view-subcatecory',[CategoryController::class,'sub_category_table'])->name('sub_category_table.show');

        Route::get('/edit-subcatecory',[CategoryController::class,'sub_category_edit'])->name('sub_category_table.edit');

        Route::get('/destroy-subcatecory',[CategoryController::class,'sub_category_edit'])->name('sub_category_table.destroy');

        Route::get('/get-category',[CategoryController::class,'get_category'])->name('get_category');
        
        
    });





});
