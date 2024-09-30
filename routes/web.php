<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\UserTermsController;
use App\Http\Controllers\UserPrivacyController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\User\AnalyticsController;
use App\Http\Controllers\User\CommunityController;
use App\Http\Controllers\User\ExamQuestionController;
use App\Http\Controllers\User\LearnTopicController;
use App\Http\Controllers\User\LessonRecordVideoController;
use App\Http\Controllers\User\LiveClassController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\MainController as UserMainController;
use App\Http\Controllers\User\MockExamController;
use App\Http\Controllers\User\PrivateClassHomeWorkController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\StripePaymentController;
use App\Http\Controllers\User\StripeWebHookController;
use App\Http\Controllers\User\TipsAndAdviceController;
use App\Http\Controllers\User\TopicExamController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/**
 *
 * Development
 */

Route::get('/rollback', function () {
    Artisan::call('migrate:rollback');
    dd(Artisan::output());
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    dd(Artisan::output());
});
Route::get('/fresh', function () {
    Artisan::call('migrate:fresh');
    dd(Artisan::output());
});

Route::get('/db-seed', function () {
    Artisan::call('db:seed');
    dd(Artisan::output());
});

Route::get('/', [HomeController::class, 'index']); 

Route::get('d0/{avathar}/{name}', [DocumentController::class, 'getuploadedFiles'])->name('file.view');
Route::get('/d0/{avathar}/{name}/download', [DocumentController::class, 'downloaduploadedFiles'])->name('file.download');

Route::prefix('stripe')->name('stripe.')->group(function () {
    Route::post('/webhook', [StripeWebHookController::class, 'handlewebhook']);
    Route::get('/workshop/{user}/payment/{payment}', [StripePaymentController::class, 'workshop_payment'])->name('payment.workshop');
    // Route::get('/subscription/{user}/payment/{payment}', [StripePaymentController::class, 'subscription_payment'])->name('payment.subscription');
    Route::get('/subscription/{user}/plan/{subscription_plan}/{type}/payment/{payment}', [StripePaymentController::class, 'subscription_payment'])->name('payment.subscription');
});

Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing.index');
Route::get('/pricing/{subscription_plan}', [HomeController::class, 'getpricing'])->name('pricing.pay');
Route::post('/pricing/{subscription_plan}', [HomeController::class, 'verifypricing']);
Route::post('/combo-email', [HomeController::class, 'combo_mail'])->name('combo-email');
Route::get('/verify-coupon', [HomeController::class, 'verifycoupon'])->name('coupon-verify');

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::middleware('guest:web,admin')->group(function () {
    Route::post('/login', [HomeController::class, 'loginSubmit']);
    Route::get('/register', [HomeController::class, 'register'])->name('register');
    Route::post('/register', [HomeController::class, 'registerSubmit']);

    Route::get('/password-reset', [HomeController::class, 'sendresetlink'])->name('password-reset');
    Route::post('/password-reset', [HomeController::class, 'submitresetlink']);

    Route::get('/password-change/{token}', [HomeController::class, 'resetpassword'])->name('password.reset');
    Route::post('/password-change/{token}', [HomeController::class, 'updatepassword']);

});
Route::middleware(['auth', 'isUser'])->group(function () {

    Route::get('/verification/notice',[HomeController::class,'verificationnotice'])->name('verification.notice');
    Route::get('/verification/resend',[HomeController::class,'verificationresend'])->name('verification.resend');
    Route::post('/verification/resend',[HomeController::class,'verificationresend']);

    Route::get('/subscription-payment/{payment_intent}/notice',[HomeController::class,'subscriptionnotice'])->name('subscription-payment.notice');

    Route::post("/upload",[UploadController::class,'uploadFile'])->name("upload");

    Route::get('/reminder', [UserMainController::class, 'reminder'])->name('reminder.index');
    Route::get('/reminder/{reminder}/show', [UserMainController::class, 'showreminder'])->name('reminder.show');
    Route::post('/reminder/add', [UserMainController::class, 'addreminder'])->name('reminder.store');
    Route::put('/reminder/{reminder}/edit', [UserMainController::class, 'editreminder'])->name('reminder.update');
    Route::get('/dashboard', [UserMainController::class, 'index'])->name('dashboard');
    Route::post('/progress', [UserMainController::class, 'progress'])->name('progress');
    Route::post('/getprogress', [UserMainController::class, 'getprogress'])->name('getprogress');
    Route::get('/logout', [UserMainController::class, 'logout'])->name('logout');
    Route::get('/profile/edit', [ProfileController::class, 'index'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update']);
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');

    Route::middleware('verified')->group(function(){

        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/workshop', [StripePaymentController::class, 'workshop'])->name('workshop');
            Route::get('/subscription', [StripePaymentController::class, 'subscription'])->name('subscription');
        });

        Route::prefix('learn')->name('learn.')->group(function () {
            Route::get('/', [LearnTopicController::class, 'index'])->name('index');
            Route::middleware('subscription:learn')->get('/{category}', [LearnTopicController::class, 'show'])->name('show');
            Route::middleware('subscription:learn')->get('/{category}/lesson/{sub_category}', [LearnTopicController::class, 'lessonshow'])->name('lesson.show');
            Route::get('/{category}/lesson/{sub_category}/history', [LearnTopicController::class, 'lessonhistory'])->name('lesson.history');
            Route::middleware('subscription:learn')->get('/{category}/lesson/{sub_category}/review', [LearnTopicController::class, 'lessonreview'])->name('lesson.review');
            Route::middleware('subscription:learn')->get('/{category}/lesson/{sub_category}/submit', [LearnTopicController::class, 'lessonreviewsubmit'])->name('lesson.submit');
            Route::get('/attempt/{user_exam_review}/preview', [LearnTopicController::class, 'preview'])->name('preview');
        });

        Route::prefix('question-bank')->name('question-bank.')->group(function () {
            Route::get('/', [ExamQuestionController::class, 'index'])->name('index');
            Route::middleware('subscription:question-bank')->get('/{category}', [ExamQuestionController::class, 'show'])->name('show');
            Route::middleware('subscription:question-bank')->get('/{category}/{sub_category}/set/{setname}/attempt', [ExamQuestionController::class, 'setattempt'])->name('set.show');
            Route::middleware('subscription:question-bank')->get('/{category}/{sub_category}/set/{setname}', [ExamQuestionController::class, 'setshow'])->name('set.attempt');
            Route::get('/{category}/{sub_category}/set/{setname}/history', [ExamQuestionController::class, 'sethistory'])->name('set.history');
            Route::middleware('subscription:question-bank')->post('/{category}/{sub_category}/set/{setname}/submit', [ExamQuestionController::class, 'setsubmit'])->name('set.submit');
            Route::middleware('subscription:question-bank')->post('/{category}/{sub_category}/set/{setname}/verify', [ExamQuestionController::class, 'setverify'])->name('set.verify');
            Route::middleware('subscription:question-bank')->get('/{category}/{sub_category}/set/{setname}/review', [ExamQuestionController::class, 'setreview'])->name('set.review');
            Route::get('/attempt/{user_exam_review}/preview', [ExamQuestionController::class, 'preview'])->name('preview');
            Route::get('/{user_exam_review}/set/complete', [ExamQuestionController::class, 'setcomplete'])->name('set.complete');
        });

        Route::prefix('topic-test')->name('topic-test.')->group(function () {
            Route::get('/', [TopicExamController::class, 'index'])->name('index');
            Route::middleware('subscription:topic-test')->get('/{category}', [TopicExamController::class, 'show'])->name('show');
            Route::middleware('subscription:topic-test')->get('/{category}/questions', [TopicExamController::class, 'questions'])->name('questions');
            Route::middleware('subscription:topic-test')->get('/{category}/attempt', [TopicExamController::class, 'confirmshow'])->name('confirmshow');
            Route::get('/{category}/history', [TopicExamController::class, 'topichistory'])->name('topic.history');
            Route::middleware('subscription:topic-test')->post('/{category}/submit', [TopicExamController::class, 'topicsubmit'])->name('topic.submit');
            Route::middleware('subscription:topic-test')->post('/{category}/verify', [TopicExamController::class, 'topicverify'])->name('topic.verify');
            Route::middleware('subscription:topic-test')->get('/{category}/review', [TopicExamController::class, 'topicreview'])->name('topic.review');
            Route::get('/attempt/{user_exam_review}/preview', [TopicExamController::class, 'preview'])->name('preview');
            Route::get('/{user_exam_review}/complete', [TopicExamController::class, 'topiccomplete'])->name('complete');
            Route::get('/{user_exam_review}/retry', [TopicExamController::class, 'topicretry'])->name('retry');
            Route::post('/fetch/{attemt}/progress', [TopicExamController::class, 'getprogress'])->name('attemtprogress');
            Route::post('/update/{attemt}/progress', [TopicExamController::class, 'updateprogress'])->name('updateprogress');
            Route::post('/retry/{user_exam_review}/submit', [TopicExamController::class, 'retrysubmit'])->name('retry.submit');
            Route::get('/retry/{user_exam_review}/attempt/{exam_retry_review}/result', [TopicExamController::class, 'retryresult'])->name('retry.result');
            Route::get('/retry/{user_exam_review}/attempt/{exam_retry_review}/preview', [TopicExamController::class, 'retrypreview'])->name('retry.preview');
            Route::get('/retry/{user_exam_review}/history', [TopicExamController::class, 'retryhistory'])->name('retryhistory');
        });

        Route::prefix('full-mock-exam')->name('full-mock-exam.')->group(function () {
            Route::get('/', [MockExamController::class, 'index'])->name('index');
            Route::middleware('subscription:full-mock-exam')->get('/{exam}', [MockExamController::class, 'show'])->name('show');
            Route::middleware('subscription:full-mock-exam')->get('/{exam}/attempt', [MockExamController::class, 'confirmshow'])->name('confirmshow');
            Route::get('/{exam}/history', [MockExamController::class, 'examhistory'])->name('history');
            Route::middleware('subscription:full-mock-exam')->post('/{exam}/submit', [MockExamController::class, 'examsubmit'])->name('submit');
            Route::middleware('subscription:full-mock-exam')->post('/{exam}/verify', [MockExamController::class, 'examverify'])->name('verify');
            Route::middleware('subscription:full-mock-exam')->get('/{exam}/review', [MockExamController::class, 'examreview'])->name('review');
            Route::get('/attempt/{user_exam_review}/preview', [MockExamController::class, 'preview'])->name('preview');
            Route::get('/{user_exam_review}/complete', [MockExamController::class, 'examcomplete'])->name('complete');
            
            Route::get('/{user_exam_review}/retry', [MockExamController::class, 'mocexamretry'])->name('retry');
            Route::post('/fetch/{attemt}/progress', [MockExamController::class, 'getprogress'])->name('attemtprogress');
            Route::post('/update/{attemt}/progress', [MockExamController::class, 'updateprogress'])->name('updateprogress');
            Route::post('/retry/{user_exam_review}/submit', [MockExamController::class, 'retrysubmit'])->name('retry.submit');
            Route::get('/retry/{user_exam_review}/attempt/{exam_retry_review}/result', [MockExamController::class, 'retryresult'])->name('retry.result');
            Route::get('/retry/{user_exam_review}/attempt/{exam_retry_review}/preview', [MockExamController::class, 'retrypreview'])->name('retry.preview');
            Route::get('/retry/{user_exam_review}/history', [MockExamController::class, 'retryhistory'])->name('retryhistory');
        });

        Route::middleware('subscription')->group(function () {

            Route::prefix('live-class')->name('live-class.')->group(function () {
                Route::get('/', [LiveClassController::class, 'index'])->name('index');
                Route::get('/{live}', [LiveClassController::class, 'show'])->name('show');
                Route::get('/{live}/workshop', [LiveClassController::class, 'workshop'])->name('workshop');
                Route::get('/{live}/workshop/form', [LiveClassController::class, 'workshopform'])->name('workshop.form');
                Route::get('/{live}/private-class', [LiveClassController::class, 'privateclass'])->name('privateclass');
                Route::get('/{live}/private-class/form', [LiveClassController::class, 'privateclassform'])->name('privateclass.form');
                Route::post('/{live}/private-class/form', [LiveClassController::class, 'privateclassformsubmit']);

                Route::middleware('hasPrivateClass')->group(function () {
                    Route::get('/{live}/private-class/room', [LiveClassController::class, 'privateclassroom'])->name('privateclass.room');
                    Route::get('/{live}/private-class/details', [LiveClassController::class, 'privateclassdetails'])->name('privateclass.details');
                    Route::get('/{live}/private-class/{class_detail}/term', [LiveClassController::class, 'privateclassterm'])->name('privateclass.term');
                    Route::get('/{live}/private-class/lesson', [LiveClassController::class, 'privateclasslesson'])->name('privateclass.lesson');
                    Route::get('/{live}/private-class/lesson/{lesson_material}/show', [LiveClassController::class, 'privateclasslessonshow'])->name('privateclass.lessonshow');
                    Route::get('/{live}/private-class/lesson/{sub_lesson_material}.pdf', [LiveClassController::class, 'privateclasslessonpdf'])->name('privateclass.lessonpdf');
                    Route::get('/{live}/private-class/lesson/{sub_lesson_material}/load/{file}', [LiveClassController::class, 'privateclasslessonpdfload'])->name('privateclass.lessonpdf.load');
                });
            });
            Route::middleware('hasPrivateClass')->group(function () {
                Route::prefix('home-work')->name('home-work.')->group(function () {
                    Route::get('/', [PrivateClassHomeWorkController::class, 'index'])->name('index');
                    Route::get('/{home_work}', [PrivateClassHomeWorkController::class, 'show'])->name('show');
                    Route::get('/{home_work}/booklet/{home_work_book}', [PrivateClassHomeWorkController::class, 'booklet'])->name('booklet');
                    Route::get('/{home_work}/booklet/{home_work_book}/history', [PrivateClassHomeWorkController::class, 'booklethistory'])->name('history');
                    Route::post('/{home_work}/booklet/{home_work_book}/verify', [PrivateClassHomeWorkController::class, 'bookletverify'])->name('booklet.verify');
                    Route::post('/{home_work}/booklet/{home_work_book}/submit', [PrivateClassHomeWorkController::class, 'bookletsubmit'])->name('booklet.submit');
                    Route::get('/attempt/booklet/{home_work_review}/preview', [PrivateClassHomeWorkController::class, 'preview'])->name('preview');
                });
                Route::prefix('lesson-record')->name('lesson-record.')->group(function () {
                    Route::get('/', [LessonRecordVideoController::class, 'index'])->name('index');
                    Route::get('/{lesson_recording}', [LessonRecordVideoController::class, 'show'])->name('show');
                });
            });

            Route::prefix('community')->name('community.')->group(function () {
                Route::get('/', [CommunityController::class, 'posts'])->name('index');
                Route::get('/ajaxindex', [CommunityController::class, 'posts'])->name('ajaxindex');
                Route::resource('/post', CommunityController::class);
                Route::get('/poll/{poll_option}/vote', [CommunityController::class, 'pollVote'])->name('poll.vote');
                Route::get('/post/{post}/like', [CommunityController::class, 'postLike'])->name('post.like');
                Route::post('/post/{post}/comment', [CommunityController::class, 'postComment'])->name('post.comment');
                Route::get('/post/{post}/comment/{post_comment}/reply', [CommunityController::class, 'postCommentReplay'])->name('post.comment.reply');
                Route::get('/post/{post}/comment/{post_comment}/like', [CommunityController::class, 'commentLike'])->name('post.comment.like');
                Route::post('/post/{post}/report', [CommunityController::class, 'postReport'])->name('post.report');
            });

            Route::prefix('analytics')->name('analytics.')->group(function () {
                Route::get('/', [AnalyticsController::class, 'index'])->name('index');
            });

        });






        Route::prefix('support')->name('support.')->group(function () {
            Route::get('/', [SupportController::class, 'index'])->name('index');
            Route::resource('/post',SupportController ::class);

        });


        Route::prefix('tipsandadvice')->name('tipsandadvise.')->group(function () {
            Route::get('/', [TipsAndAdviceController::class, 'index'])->name('index');
            Route::resource('/post',TipsAndAdviceController ::class);
            Route::get('/tips-show/{id}', [TipsAndAdviceController::class, 'tip_show'])->name('tip_show');

        });

    });




});




Route::get('/course', [UserCourseController::class, 'index'])->name('course.index');
Route::post('/contact-submit', [UserCourseController::class, 'submit'])->name('contact.submit');







Route::middleware('signed')->get('email/{id}/{hash}/verify', [HomeController::class, 'verifyemail'])->name('verification.verify');





Route::get('/privacy', [UserPrivacyController::class, 'index'])->name('privacy.index');




Route::get('/terms', [UserTermsController::class, 'index'])->name('terms.index');



Route::fallback(function () {
    return redirect('/'); // Redirect to the landing page
});