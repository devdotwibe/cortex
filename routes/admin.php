<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClassDetailController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\FullMockExamController;
use App\Http\Controllers\Admin\HomeWorkController;
use App\Http\Controllers\Admin\LearnController;
use App\Http\Controllers\Admin\LessonMaterialController;
use App\Http\Controllers\Admin\LessonRecordController;
use App\Http\Controllers\Admin\LiveClassController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\QuestionBankController;
use App\Http\Controllers\Admin\QuestionBankControllerNew;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SetController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TopicTestController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\CommunityControllerController;
use Illuminate\Support\Facades\Route;



Route::name('admin.')->prefix('admin')->group(function(){
    Route::middleware('guest:web,admin')->group(function(){
        Route::get('/login', [AdminMainController::class,'login'])->name('login');
        Route::post('/login', [AdminMainController::class,'loginSubmit']);
        Route::get('community/',[AdminMainController::class,'index'])->name('index');
    });
    Route::middleware(['auth:admin','isAdmin'])->group(function(){

        Route::post("/upload",[UploadController::class,'uploadFile'])->name("upload");

        Route::get('/upload/{tag}/status',[AdminMainController::class,'uploadstatus'])->name('uploadstatus');
        Route::get('/upload/{tag}/cancel',[AdminMainController::class,'uploadcancel'])->name('uploadcancel');

        Route::get('/',[AdminMainController::class,'index']);
        Route::get('/dashboard',[AdminMainController::class,'index'])->name('dashboard');
        Route::get('/logout',[AdminMainController::class,'logout'])->name('logout');

        Route::resource("/user",UserController::class);
        Route::post('/user/{user}/resetpassword',[UserController::class,'resetpassword'])->name('user.resetpassword');
        Route::post('/user/bulk/action',[UserController::class,'bulkaction'])->name('user.bulkaction');
        Route::get('/user/{user}/getdata',[UserController::class,'getdata'])->name('user.students');
        Route::get('/user/{user}/spectate',[UserController::class,'userspectate'])->name('user.spectate');
        Route::resource("/exam",ExamController::class);
        Route::get('/full-mock-exam-options',[ExamController::class,'examoptions'])->name('exam.options');
        Route::post('/full-mock-exam-options',[ExamController::class,'examoptionssave']);

        Route::resource("/payment",PaymentController::class);

        Route::prefix('full-mock-exam')->name('full-mock-exam.')->group(function () {
            Route::get('/{exam}',[FullMockExamController::class,'index'])->name('index');
            Route::get('/{exam}/question/{question}',[FullMockExamController::class,'show'])->name('show');
            Route::get('/{exam}/create',[FullMockExamController::class,'create'])->name('create');
            Route::get('/{exam}/question/{question}/edit',[FullMockExamController::class,'edit'])->name('edit');
            Route::post('/{exam}/store',[FullMockExamController::class,'store'])->name('store');
            Route::post('/{exam}/import',[FullMockExamController::class,'importquestion'])->name('import');
        });
        // Route::prefix('question-bank-old')->name('question-bank-old.')->group(function () {
        //     Route::get('/',[QuestionBankControllerOld::class,'index'])->name('index');
        //     Route::post('/subtitle',[QuestionBankControllerOld::class,'subtitle'])->name('subtitle');
        //     Route::get('/{category}',[QuestionBankControllerOld::class,'show'])->name('show');
        //     Route::get('/{category}/create',[QuestionBankControllerOld::class,'create'])->name('create');
        //     Route::get('/{category}/{question}/edit',[QuestionBankControllerOld::class,'edit'])->name('edit');
        //     Route::post('/{category}/store',[QuestionBankControllerOld::class,'store'])->name('store');
        // });

        Route::prefix('question-bank')->name('question-bank.')->group(function () {
            Route::get('/',[QuestionBankController::class,'index'])->name('index');
            Route::post('/subtitle',[QuestionBankController::class,'subtitle'])->name('subtitle');
            Route::get('/{setname}',[QuestionBankController::class,'show'])->name('show');
            Route::get('/{setname}/create',[QuestionBankController::class,'create'])->name('create');
            Route::get('/{setname}/{question}/edit',[QuestionBankController::class,'edit'])->name('edit');
            Route::post('/{setname}/store',[QuestionBankController::class,'store'])->name('store');
            Route::get('/{category}/subcategory',[QuestionBankController::class,'subcategory'])->name('subcategory');
            Route::get('/{sub_category}/set',[QuestionBankController::class,'subcategoryset'])->name('subcategoryset');
            Route::post('/{setname}/import',[QuestionBankController::class,'importquestion'])->name('import');
        });

        Route::prefix('topic-test')->name('topic-test.')->group(function () {
            Route::get('/',[TopicTestController::class,'index'])->name('index');
            Route::post('/subtitle',[TopicTestController::class,'subtitle'])->name('subtitle');
            Route::get('/{category}',[TopicTestController::class,'show'])->name('show');
            Route::get('/{category}/create',[TopicTestController::class,'create'])->name('create');
            Route::get('/{category}/{question}/edit',[TopicTestController::class,'edit'])->name('edit');
            Route::post('/{category}/store',[TopicTestController::class,'store'])->name('store');
            Route::post('/{category}/updatetime',[TopicTestController::class,'updatetime'])->name('updatetime');
            Route::post('/{category}/import',[TopicTestController::class,'importquestion'])->name('import');
        });
        Route::resource("/question",QuestionController::class);
        Route::get('/question/{question}/visibility',[QuestionController::class,'visibility'])->name('question.visibility');
        // Route::resource("/learn",LearnController::class);

        Route::prefix('learn')->name('learn.')->group(function () {
            Route::get('/',[LearnController::class,'index'])->name('index');
            Route::get('/{category}',[LearnController::class,'show'])->name('show');
            Route::get('/{category}/create',[LearnController::class,'create'])->name('create');
            Route::get('/{category}/{learn}/edit',[LearnController::class,'edit'])->name('edit');
            Route::post('/{category}/store',[LearnController::class,'store'])->name('store');
            Route::put('/{category}/{learn}/update',[LearnController::class,'update'])->name('update');

            Route::get('/{learn}/visibility',[LearnController::class,'visibility'])->name('visibility');
            Route::delete('/{category}/{learn}',[LearnController::class,'destroy'])->name('destroy');
        });


        Route::prefix('community')->name('community.')->group(function () {
            Route::get('/',[CommunityControllerController::class,'index'])->name('index');
            Route::get('/post',[CommunityControllerController::class,'create'])->name('create');
            Route::post('/post/store',[CommunityControllerController::class,'store'])->name('store');
            Route::get('/post/show',[CommunityControllerController::class,'show'])->name('show');
            
           
            
            Route::get('/poll/create',[CommunityControllerController::class,'createPoll'])->name('poll.create');
            Route::get('/polls',[CommunityControllerController::class,'getPolls'])->name('poll.index');
            Route::post('/poll/store',[CommunityControllerController::class,'storePoll'])->name('poll.store');
            Route::put('/poll/vote',[CommunityControllerController::class,'votePoll'])->name('poll.vote');
            Route::get('/poll/edit/{id}', [CommunityControllerController::class,'edit'])->name('poll.edit');
            Route::put('/poll/update/{id}', [CommunityControllerController::class, 'update'])->name('poll.update');
            Route::delete('/poll/delete/{id}', [CommunityControllerController::class, 'destroy'])->name('poll.destroy');
          

           

            
        });

        // Route::resource("/options",CategoryController::class);

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/',[CategoryController::class,'index'])->name('index');
            Route::get('/create',[CategoryController::class,'create'])->name('create');
            Route::post('/',[CategoryController::class,'store'])->name('store');
            Route::get('/{category}/edit',[CategoryController::class,'edit'])->name('edit');
            Route::put('/{category}',[CategoryController::class,'update'])->name('update');
            Route::get('/{category}',[CategoryController::class,'show'])->name('show');
            Route::delete('/{category}',[CategoryController::class,'destroy'])->name('destroy');
            Route::get('/{category}/visibility',[CategoryController::class,'visibility'])->name('visibility');
        });

        Route::post('/add-subcatecory/{category}',[CategoryController::class,'add_subcatecory'])->name('add_subcatecory');

        Route::get('/get-category',[CategoryController::class,'get_edit_details'])->name('get_edit_details');


        // Route::resource("/subcategory",SubCategoryController::class);

        Route::prefix('subcategory')->name('subcategory.')->group(function () {
            Route::get('/',[SubCategoryController::class,'index'])->name('index');
            Route::get('/create',[SubCategoryController::class,'create'])->name('create');
            Route::post('/',[SubCategoryController::class,'store'])->name('store');
            Route::get('/{sub_category}/edit',[SubCategoryController::class,'edit'])->name('edit');
            Route::put('/{sub_category}',[SubCategoryController::class,'update'])->name('update');
            Route::get('/{sub_category}',[SubCategoryController::class,'show'])->name('show');
            Route::delete('/{sub_category}',[SubCategoryController::class,'destroy'])->name('destroy');
            Route::get('/{sub_category}/visibility',[SubCategoryController::class,'visibility'])->name('visibility');
        });

        Route::get('/view-subcatecory',[SubCategoryController::class,'subcategory_table'])->name('subcategory_table.show');

        // Route::resource("/set",SetController::class);

        Route::prefix('set')->name('set.')->group(function () {
            Route::get('/',[SetController::class,'index'])->name('index');
            Route::get('/create',[SetController::class,'create'])->name('create');
            Route::post('/',[SetController::class,'store'])->name('store');
            Route::get('/{setname}/edit',[SetController::class,'edit'])->name('edit');
            Route::put('/{setname}',[SetController::class,'update'])->name('update');
            Route::get('/{setname}',[SetController::class,'show'])->name('show');
            Route::delete('/{setname}',[SetController::class,'destroy'])->name('destroy');
            Route::get('/{setname}/visibility',[SetController::class,'visibility'])->name('visibility');
        });

        Route::get('/set/view',[SetController::class,'set_table_show'])->name('set_table.show');

        Route::post('/set/store/{slug}',[SetController::class,'set_store'])->name('set.set_store');

        Route::prefix('live-class')->name('live-class.')->group(function () {

            Route::get('/',[LiveClassController::class,'index'])->name('index');

            Route::post('/',[LiveClassController::class,'store'])->name('store');
            Route::get('/private/class/{private_class}/requests/accept',[LiveClassController::class,'private_class_request_accept'])->name('request.accept');
            Route::get('/private/class/{private_class}/requests/reject',[LiveClassController::class,'private_class_request_reject'])->name('request.reject');
            Route::get('/private/class/{private_class}/requests/status',[LiveClassController::class,'private_class_request_status'])->name('request.status');
            
            Route::delete('/private/class/{private_class}/requests',[LiveClassController::class,'private_class_request_destroy'])->name('request.destroy');
            Route::get('/private/class/requests',[LiveClassController::class,'private_class_request'])->name('private_class_request');
            Route::get('/private/class/requests/export',[LiveClassController::class,'private_class_request_export'])->name('private_class_request_export');

            Route::post('/private/class',[LiveClassController::class,'private_class'])->name('private_class');

            Route::get('/private/class',[LiveClassController::class,'private_class_create'])->name('private_class_create');

            Route::post('/intensive/class',[LiveClassController::class,'intensive_class'])->name('intensive_class');
            
        });

        Route::prefix('term')->name('term.')->group(function () {

            Route::get('/',[TermController::class,'index'])->name('index');

            Route::post('/',[TermController::class,'store'])->name('store');

            Route::delete('/{term_name}/destory-class',[TermController::class,'destroy_class_detail'])->name('destroy_class_detail');

            Route::delete('/{term_name}/destory-lesson-material',[TermController::class,'destroy_lesson_material'])->name('destroy_lesson_material');

            Route::delete('/{term_name}/destory-home-work',[TermController::class,'destroy_home_work'])->name('destroy_home_work');

            Route::delete('/{term_name}/destory-lesson-recording',[TermController::class,'destroy_lesson_recording'])->name('destroy_lesson_recording');

            Route::get('/{term_name}/edit-class',[TermController::class,'edit_class'])->name('edit_class');

            Route::get('/{term_name}/edit-lesson-material',[TermController::class,'edit_lesson_material'])->name('edit_lesson_material');

            Route::get('/{term_name}/edit-home-work',[TermController::class,'edit_home_work'])->name('edit_home_work');

            Route::get('/{term_name}/edit-lesson-recording',[TermController::class,'edit_lesson_recording'])->name('edit_lesson_recording');

            Route::post('/{term_name}/update-class',[TermController::class,'update_class_detail'])->name('update_class_detail');
            
            Route::post('/{term_name}/update-lesson-material',[TermController::class,'update_lesson_material'])->name('update_lesson_material');

            Route::post('/{term_name}/update-home-work',[TermController::class,'update_home_work'])->name('update_home_work');

            Route::post('/{term_name}/update-lesson-recording',[TermController::class,'update_lesson_recording'])->name('update_lesson_recording');

            Route::get('/show/class-details',[TermController::class,'show_table'])->name('show_table');

            Route::get('/show/lesson-material',[TermController::class,'show_table_lesson_material'])->name('show_table_lesson_material');

            Route::get('/show/home-work',[TermController::class,'show_table_home_work'])->name('show_table_home_work');

            Route::get('/show/home-work-booklet',[TermController::class,'show_table_week_booklet'])->name('show_table_week_booklet');

            Route::get('/show/lesson-recording',[TermController::class,'show_table_lesson_recording'])->name('show_table_lesson_recording');
            
            Route::get('/class-detail',[TermController::class,'class_detail'])->name('class_detail');

            Route::get('/lesson-material',[TermController::class,'lesson_material'])->name('lesson_material');
            Route::get('/home-work',[TermController::class,'home_work'])->name('home_work');
            Route::get('/lesson-recording',[TermController::class,'lesson_recording'])->name('lesson_recording');
            
        });

        Route::prefix('class-detail')->name('class-detail.')->group(function () {

            Route::get('/{slug}',[ClassDetailController::class,'show'])->name('show');

            Route::post('/',[ClassDetailController::class,'store'])->name('store');
            
            Route::delete('/{subclass}/destory-sub-class',[ClassDetailController::class,'destroy_sub_class'])->name('destroy_sub_class');
            
            Route::get('/{subclass}/edit-sub-class',[ClassDetailController::class,'edit_sub_class'])->name('edit_sub_class');
            
            Route::post('/{subclass}/update-sub-class',[ClassDetailController::class,'update_sub_class'])->name('update_sub_class');
            
        });

        Route::prefix('lesson-material')->name('lesson-material.')->group(function () {

            Route::get('/{slug}',[LessonMaterialController::class,'show'])->name('show');

            Route::post('/',[LessonMaterialController::class,'store'])->name('store');
            
            Route::delete('/{sub_lesson_material}/destory-lesson-material',[LessonMaterialController::class,'destroy_lesson_material'])->name('destroy_lesson_material');
            
            Route::get('/{sub_lesson_material}/edit-sub-class',[LessonMaterialController::class,'edit_sub_class'])->name('edit_sub_class');
            
            Route::post('/{subclass}/update-sub-class',[LessonMaterialController::class,'update_sub_class'])->name('update_sub_class');
            
        });
        Route::prefix('home-work')->name('home-work.')->group(function () {
            Route::get('/{home_work}',[HomeWorkController::class,'show'])->name('show'); 
            Route::get('/{home_work}/question/create',[HomeWorkController::class,'create'])->name('create');
            Route::post('/{home_work}/question/create',[HomeWorkController::class,'store'])->name('store');
            Route::get('/{home_work}/question/{home_work_question}/edit',[HomeWorkController::class,'edit'])->name('edit');
            Route::put('/{home_work}/question/{home_work_question}/edit',[HomeWorkController::class,'update'])->name('update');
            Route::delete('/{home_work}/question/{home_work_question}/destroy',[HomeWorkController::class,'destroy'])->name('destroy');
            Route::get('/{home_work}/question/{home_work_question}/visibility',[HomeWorkController::class,'questionvisibility'])->name('visibility');

            Route::post('/home-work/booklet/create',[HomeWorkController::class,'storebooklet'])->name('storebooklet');
            Route::get('/home-work/booklet/{home_work_book}/show',[HomeWorkController::class,'showbooklet'])->name('showbooklet');
            Route::put('/home-work/booklet/{home_work_book}/update',[HomeWorkController::class,'updatebooklet'])->name('updatebooklet');
            Route::delete('/home-work/booklet/{home_work_book}/destroy',[HomeWorkController::class,'destroybooklet'])->name('destroybooklet');
        });
        Route::prefix('lesson-record')->name('lesson-record.')->group(function () {
            Route::get('/{lesson_recording}',[LessonRecordController::class,'show'])->name('show');
            Route::get('/{lesson_recording}/video/create',[LessonRecordController::class,'create'])->name('create');
            Route::post('/{lesson_recording}/video/create',[LessonRecordController::class,'store'])->name('store');
            Route::get('/{lesson_recording}/video/{record_video}/edit',[LessonRecordController::class,'edit'])->name('edit');
            Route::put('/{lesson_recording}/video/{record_video}/edit',[LessonRecordController::class,'update'])->name('update');
            Route::delete('/{lesson_recording}/video/{record_video}/destroy',[LessonRecordController::class,'destroy'])->name('destroy');
            Route::get('/{lesson_recording}/video/{record_video}/visibility',[LessonRecordController::class,'visibility'])->name('visibility');
        });
    });
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/',[SettingsController::class,'index'])->name('index');
        Route::post('/store',[SettingsController::class,'store'])->name('store');
    });

   
});