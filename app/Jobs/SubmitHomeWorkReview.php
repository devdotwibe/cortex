<?php

namespace App\Jobs;

use App\Models\HomeWork;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Models\HomeWorkReview;
use App\Models\HomeWorkReviewAnswer;
use App\Models\HomeWorkReviewQuestion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubmitHomeWorkReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** 
     *
     * @var HomeWorkReview
     */
    protected $review;
    
    /**
     * Summary of __construct
     * @param HomeWorkReview $review
     */
    public function __construct($review)
    {
        $this->review=$review;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $user=User::find($this->review->user_id);
        $homeWork=HomeWork::find($this->review->home_work_id);
        $homeWorkBook=HomeWorkBook::find($this->review->home_work_book_id); 
        $takentime=json_decode($user->progress("home-work-review-{$this->review->id}-times",'[]'),true);
        $takentimereview=[];
        foreach (HomeWorkQuestion::where('home_work_id',$homeWork->id)->where('home_work_book_id',$homeWorkBook->id)->get() as $k=> $question) {
            $user_answer=$user->progress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-answer-of-".$question->slug,"");
            $revquestion=HomeWorkReviewQuestion::store([
                'title'=>$question->title, 
                'home_work_review_id'=>$this->review->id,
                'review_type'=>'mcq',
                'note'=>$question->description, 
                'explanation'=>$question->explanation, 
                'currect_answer'=>'', 
                'user_answer'=>$user_answer,  
                'home_work_id'=> $this->review->home_work_id,
                'home_work_book_id'=> $this->review->home_work_book_id,
                'home_work_question_id'=> $question->id,
                'user_id'=>$this->review->user_id,
                'time_taken'=>$takentime[$question->slug]??0
            ]);
            
            $takentimereview[$revquestion->slug]=$takentime[$question->slug]??0;
            
            foreach($question->answers as $ans){
                HomeWorkReviewAnswer::store([
                    'home_work_review_id'=>$this->review->id,
                    'home_work_review_question_id'=>$revquestion->id,
                    'title'=>$ans->title,
                    'iscorrect'=>$ans->iscorrect,
                    'user_answer'=>(($ans->slug==$user_answer)?true:false),
                    'home_work_id'=> $this->review->home_work_id,
                    'home_work_book_id'=> $this->review->home_work_book_id,
                    'home_work_question_id'=> $question->id,
                    'home_work_answer_id'=> $ans->id, 
                ]); 
            } 
            $user->setProgress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-answer-of-".$question->slug,null);
        }
        $user->setProgress("home-work-review-{$this->review->id}-times",json_encode($takentimereview));

        $user->setProgress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-complete-review",null);
        $user->setProgress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-progress-ids",null);
        $user->setProgress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-progress-url",null);
    }
}
