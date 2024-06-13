<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExamController; 
use App\Http\Controllers\Admin\FullMockExamController;
use App\Http\Controllers\Admin\LearnController;
use App\Http\Controllers\Admin\MainController as AdminMainController; 
use App\Http\Controllers\Admin\QuestionBankController; 
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SetController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TopicTestController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->group(function(){
    Route::middleware('guest:admin')->group(function(){
        Route::get('/login', [AdminMainController::class,'login'])->name('login');
        Route::post('/login', [AdminMainController::class,'loginSubmit']);
    });
    Route::middleware('auth:admin')->group(function(){

        Route::post("/upload",[UploadController::class,'uploadFile'])->name("upload");

        Route::get('/',[AdminMainController::class,'index']);
        Route::get('/dashboard',[AdminMainController::class,'index'])->name('dashboard');
        Route::get('/logout',[AdminMainController::class,'logout'])->name('logout');

        Route::resource("/user",UserController::class);
        Route::resource("/exam",ExamController::class);

        Route::prefix('full-mock-exam')->name('full-mock-exam.')->group(function () { 
            Route::get('/{exam}',[FullMockExamController::class,'index'])->name('index');
            Route::get('/{exam}/question/{question}',[FullMockExamController::class,'show'])->name('show');
            Route::get('/{exam}/create',[FullMockExamController::class,'create'])->name('create');
            Route::get('/{exam}/question/{question}/edit',[FullMockExamController::class,'edit'])->name('edit');
            Route::post('/{exam}/store',[FullMockExamController::class,'store'])->name('store');  
        });
        Route::prefix('question-bank')->name('question-bank.')->group(function () { 
            Route::get('/',[QuestionBankController::class,'index'])->name('index');
            Route::get('/{category}',[QuestionBankController::class,'show'])->name('show');
            Route::get('/{category}/create',[QuestionBankController::class,'create'])->name('create');
            Route::get('/{category}/{question}/edit',[QuestionBankController::class,'edit'])->name('edit');
            Route::post('/{category}/store',[QuestionBankController::class,'store'])->name('store');  
        });
       
        Route::prefix('topic-test')->name('topic-test.')->group(function () { 
            Route::get('/',[TopicTestController::class,'index'])->name('index');
            Route::get('/{category}',[TopicTestController::class,'show'])->name('show');
            Route::get('/{category}/create',[TopicTestController::class,'create'])->name('create');
            Route::get('/{category}/{question}/edit',[TopicTestController::class,'edit'])->name('edit');
            Route::post('/{category}/store',[TopicTestController::class,'store'])->name('store');  
        });
        Route::resource("/question",QuestionController::class);

        // Route::resource("/learn",LearnController::class);

        Route::prefix('learn')->name('learn.')->group(function () { 
            Route::get('/',[LearnController::class,'index'])->name('index');
            Route::get('/{category}',[LearnController::class,'show'])->name('show');
            Route::get('/{category}/create',[LearnController::class,'create'])->name('create');
            Route::get('/{category}/{learn}/edit',[LearnController::class,'edit'])->name('edit');
            Route::post('/{category}/store',[LearnController::class,'store'])->name('store');  

            Route::delete('/{category}',[LearnController::class,'destroy'])->name('destroy');
        });

        // Route::resource("/options",CategoryController::class);

        Route::prefix('options')->name('options.')->group(function () { 
            Route::get('/',[CategoryController::class,'index'])->name('index');
            Route::get('/create',[CategoryController::class,'create'])->name('create');
            Route::post('/',[CategoryController::class,'store'])->name('store');
            Route::get('/{category}/edit',[CategoryController::class,'edit'])->name('edit');
            Route::put('/{category}',[CategoryController::class,'update'])->name('update');
            Route::get('/{category}',[CategoryController::class,'show'])->name('show');
            Route::delete('/{category}',[CategoryController::class,'destroy'])->name('destroy');
        });

        Route::post('/add-subcatecory/{slug}',[CategoryController::class,'add_subcatecory'])->name('add_subcatecory');

        Route::get('/get-category',[CategoryController::class,'get_edit_details'])->name('get_edit_details');
        

        // Route::resource("/subcategory",SubCategoryController::class);

        Route::prefix('subcategory')->name('subcategory.')->group(function () { 
            Route::get('/',[SubCategoryController::class,'index'])->name('index');
            Route::get('/create',[SubCategoryController::class,'create'])->name('create');
            Route::post('/',[SubCategoryController::class,'store'])->name('store');
            Route::get('/{subcategory}/edit',[SubCategoryController::class,'edit'])->name('edit');
            Route::put('/{subcategory}',[SubCategoryController::class,'update'])->name('update');
            Route::get('/{subcategory}',[SubCategoryController::class,'show'])->name('show');
            Route::delete('/{subcategory}',[SubCategoryController::class,'destroy'])->name('destroy');
        });

        Route::get('/view-subcatecory',[SubCategoryController::class,'subcategory_table'])->name('subcategory_table.show');

        // Route::resource("/set",SetController::class);

        Route::prefix('set')->name('set.')->group(function () { 
            Route::get('/',[SetController::class,'index'])->name('index');
            Route::get('/create',[SetController::class,'create'])->name('create');
            Route::post('/',[SetController::class,'store'])->name('store');
            Route::get('/{set}/edit',[SetController::class,'edit'])->name('edit');
            Route::put('/{set}',[SetController::class,'update'])->name('update');
            Route::get('/{set}',[SetController::class,'show'])->name('show');
            Route::delete('/{set}',[SetController::class,'destroy'])->name('destroy');
        });

        Route::get('/set/view',[SetController::class,'set_table_show'])->name('set_table.show');

        Route::post('/set/store/{slug}',[SetController::class,'set_store'])->name('set.set_store');
        

        

    });





});
