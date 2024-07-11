<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\User\ExamQuestionController;
use App\Http\Controllers\User\LearnTopicController;
use App\Http\Controllers\User\LiveClassController;
use App\Http\Controllers\User\MainController as UserMainController;
use App\Http\Controllers\User\MockExamController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TopicExamController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\StripePaymentController;
use App\Http\Controllers\User\StripeWebHookController;
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

Route::prefix('stripe')->name('stripe.')->group(function () {
    Route::post('/webhook',[StripeWebHookController::class,'handlewebhook']);
    Route::get('/workshop/{user}/payment/{payment}',[StripePaymentController::class,'workshop_payment'])->name('payment.workshop');
});

Route::middleware('guest:web,admin')->group(function(){
    Route::get('/login', [HomeController::class,'login'])->name('login');
    Route::post('/login', [HomeController::class,'loginSubmit']);
    Route::get('/register', [HomeController::class,'register'])->name('register');
    Route::post('/register', [HomeController::class,'registerSubmit']);

    Route::get('/password-reset', [HomeController::class,'sendresetlink'])->name('password-reset');
    Route::post('/password-reset', [HomeController::class,'submitresetlink']);

    Route::get('/password-change/{token}', [HomeController::class,'resetpassword'])->name('password.reset');
    Route::post('/password-change/{token}', [HomeController::class,'updatepassword']);

});
Route::middleware(['auth','IsUser'])->group(function(){
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
        Route::get('/{category}/lesson/{sub_category}/history',[LearnTopicController::class,'lessonhistory'])->name('lesson.history');
        Route::get('/{category}/lesson/{sub_category}/review',[LearnTopicController::class,'lessonreview'])->name('lesson.review');
        Route::get('/{category}/lesson/{sub_category}/submit',[LearnTopicController::class,'lessonreviewsubmit'])->name('lesson.submit');
        Route::get('/attempt/{user_exam_review}/preview',[LearnTopicController::class,'preview'])->name('preview');
    });

     Route::get('/subscribe',[StripeController::class,'subscribe'])->name('stripe.payment');
     Route::post('/subscription-handle', [StripeController::class, 'handlePayment'])->name('subscribe.handle');
     Route::get('/stripe/information',[StripeController::class,'stripeinformation'])->name('stripe.information');

    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/workshop',[StripePaymentController::class,'workshop'])->name('workshop');
    });

    Route::prefix('question-bank')->name('question-bank.')->group(function () {
        Route::get('/',[ExamQuestionController::class,'index'])->name('index');
        Route::get('/{category}',[ExamQuestionController::class,'show'])->name('show');
        Route::get('/{category}/{sub_category}/set/{setname}',[ExamQuestionController::class,'setshow'])->name('set.show');
        Route::get('/{category}/{sub_category}/set/{setname}/history',[ExamQuestionController::class,'sethistory'])->name('set.history');
        Route::post('/{category}/{sub_category}/set/{setname}/submit',[ExamQuestionController::class,'setsubmit'])->name('set.submit');
        Route::post('/{category}/{sub_category}/set/{setname}/verify',[ExamQuestionController::class,'setverify'])->name('set.verify');
        Route::get('/{category}/{sub_category}/set/{setname}/review',[ExamQuestionController::class,'setreview'])->name('set.review');
        Route::get('/attempt/{user_exam_review}/preview',[ExamQuestionController::class,'preview'])->name('preview');
        Route::get('/{category}/set/complete',[ExamQuestionController::class,'setcomplete'])->name('set.complete');
    });



    Route::prefix('topic-test')->name('topic-test.')->group(function () {
        Route::get('/',[TopicExamController::class,'index'])->name('index');
        Route::get('/{category}',[TopicExamController::class,'show'])->name('show');
        Route::get('/{category}/attempt',[TopicExamController::class,'confirmshow'])->name('confirmshow');
        Route::get('/{category}/history',[TopicExamController::class,'topichistory'])->name('topic.history');
        Route::post('/{category}/submit',[TopicExamController::class,'topicsubmit'])->name('topic.submit');
        Route::post('/{category}/verify',[TopicExamController::class,'topicverify'])->name('topic.verify');
        Route::get('/{category}/review',[TopicExamController::class,'topicreview'])->name('topic.review');
        Route::get('/attempt/{user_exam_review}/preview',[TopicExamController::class,'preview'])->name('preview');
        Route::get('/{category}/complete',[TopicExamController::class,'topiccomplete'])->name('complete');
    });

    Route::prefix('full-mock-exam')->name('full-mock-exam.')->group(function () {
        /*
            Route::get('/',[MockExamController::class,'index'])->name('index');
            Route::get('/{exam}',[MockExamController::class,'show'])->name('show');
            Route::get('/{exam}/question/{question}',[MockExamController::class,'question'])->name('question');
        */
        Route::get('/',[MockExamController::class,'index'])->name('index');
        Route::get('/{exam}',[MockExamController::class,'show'])->name('show');
        Route::get('/{exam}/attempt',[MockExamController::class,'confirmshow'])->name('confirmshow');
        Route::get('/{exam}/history',[MockExamController::class,'examhistory'])->name('history');
        Route::post('/{exam}/submit',[MockExamController::class,'examsubmit'])->name('submit');
        Route::post('/{exam}/verify',[MockExamController::class,'examverify'])->name('verify');
        Route::get('/{exam}/review',[MockExamController::class,'examreview'])->name('review');
        Route::get('/attempt/{user_exam_review}/preview',[MockExamController::class,'preview'])->name('preview');
        Route::get('/{exam}/complete',[MockExamController::class,'examcomplete'])->name('complete');
    });
    Route::prefix('live-class')->name('live-class.')->group(function () {     
        Route::get('/',[LiveClassController::class,'index'])->name('index');
        Route::get('/{live}',[LiveClassController::class,'show'])->name('show');
        Route::get('/{live}/workshop',[LiveClassController::class,'workshop'])->name('workshop');
        Route::get('/{live}/workshop/form',[LiveClassController::class,'workshopform'])->name('workshop.form');
        Route::get('/{live}/private-class',[LiveClassController::class,'privateclass'])->name('privateclass');
        Route::get('/{live}/private-class/form',[LiveClassController::class,'privateclassform'])->name('privateclass.form');
        Route::get('/{live}/private-class/room',[LiveClassController::class,'privateclassroom'])->name('privateclass.room');
        Route::get('/{live}/private-class/details',[LiveClassController::class,'privateclassdetails'])->name('privateclass.details');
        Route::get('/{live}/private-class/{class_detail}/term',[LiveClassController::class,'privateclassterm'])->name('privateclass.term');
        Route::get('/{live}/private-class/lesson',[LiveClassController::class,'privateclasslesson'])->name('privateclass.lesson');
        Route::get('/{live}/private-class/lesson/{lesson_material}/show',[LiveClassController::class,'privateclasslessonshow'])->name('privateclass.lessonshow');
        Route::get('/{live}/private-class/lesson/{sub_lesson_material}.pdf',[LiveClassController::class,'privateclasslessonpdf'])->name('privateclass.lessonpdf');
        Route::get('/{live}/private-class/lesson/{sub_lesson_material}/load/{file}',[LiveClassController::class,'privateclasslessonpdfload'])->name('privateclass.lessonpdf.load');
    });
}); 
Route::middleware('signed')->get('email/{id}/{hash}/verify', [HomeController::class,'verifyemail'])->name('verification.verify');
