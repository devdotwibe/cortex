<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamRetryAnswer;
use App\Models\ExamRetryQuestion;
use App\Models\ExamRetryReview;
use App\Models\Question;
use App\Models\User;
use App\Models\UserExam;
use App\Models\UserExamQuestion;
use App\Models\UserExamReview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubmitRetryReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** 
     *
     * @var ExamRetryReview
     */
    protected $review; 

    /**
     * Summary of questions
     * @var array
     */
    protected $questions;

    /**
     * Summary of questions
     * @var array
     */
    protected $answers;

    /**
     * Summary of __construct
     * @param ExamRetryReview $review
     * @param array $questions
     * @param array $name
     */
    public function __construct($review,$questions,$answers)
    {
        $this->review=$review;
        $this->questions=$questions;
        $this->answers=$answers;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        switch ($this->review->name) {      
            case 'topic-test':
                $this->topicTestHandle();
                break;
            case 'full-mock-exam':
                $this->fullMockExamHandle();
                break;
            default: 
                break;
        }
    }
    private function topicTestHandle(){
        $user=User::find($this->review->user_id);
        $userExamReview=UserExamReview::find($this->review->user_exam_review_id);
        $exam=Exam::find($this->review->exam_id);
        $category=Category::find($this->review->category_id); 
        $takentime=json_decode($user->progress($this->review->times),true);
        $takentimereview=[]; 
        foreach (UserExamQuestion::whereNotIn('slug',$this->questions)->where('user_exam_id',$userExamReview->ticket)->get() as $k=> $question) {
              
            $user_answer=$this->answers[$question->slug]??"";

            $revquestion=ExamRetryQuestion::store([
                'title'=>$question->title, 
                'user_exam_review_id'=>$this->review->user_exam_review_id,
                'exam_retry_review_id'=>$this->review->id,
                'review_type'=>'mcq',
                'note'=>$question->description, 
                'explanation'=>$question->explanation, 
                'currect_answer'=>'', 
                'user_answer'=>$user_answer,  
                'exam_id'=> $this->review->exam_id,
                'question_id'=> $question->question_id,
                'title_text'=> $question->title_text,
                'sub_question'=> $question->sub_question,
                'user_id'=>$this->review->user_id,
                'time_taken'=>$takentime[$question->slug]??0
            ]);
            
            // $takentimereview[$revquestion->slug]=$takentime[$question->slug]??0;
            
            foreach($question->answers as $ans){
                ExamRetryAnswer::store([
                    'exam_retry_review_id'=>$this->review->id,
                    'user_exam_review_id'=>$this->review->user_exam_review_id,
                    'exam_retry_question_id'=>$revquestion->id,
                    'title'=>$ans->title,
                    'iscorrect'=>$ans->iscorrect,
                    'user_answer'=>(($ans->slug==$user_answer)?true:false),
                    'exam_id'=> $this->review->exam_id,
                    'question_id'=> $question->question_id,
                    'answer_id'=> $ans->answer_id,
                    'user_id'=>$this->review->user_id,
                ]); 
            }  
        }

    }
    private function fullMockExamHandle(){

        $user=User::find($this->review->user_id);
        $exam=Exam::find($this->review->exam_id); 
        $userExamReview=UserExamReview::find($this->review->user_exam_review_id);
        // $takentime=json_decode($user->progress($this->review->times),true);
        $takentimereview=[]; 
        $userExam=UserExam::findSlug($userExamReview->ticket);
        $takentime=json_decode($this->review->times,true);
        if (!is_array($this->questions)) {
            $this->questions=json_decode( $this->questions,true);
        } 
        $q = UserExamQuestion::whereIn('slug',$this->questions)->where('user_exam_id',$userExam->id)->get();
        // foreach (UserExamQuestion::whereNotIn('slug',$this->questions)->where('user_exam_id',$userExamReview->ticket)->get() as $k=> $question) {
        foreach ($q as $k=> $question) {
              
            $user_answer=$this->answers[$question->slug]??"";

            $revquestion=ExamRetryQuestion::store([
                'title'=>$question->title, 
                'user_exam_review_id'=>$this->review->user_exam_review_id,
                'exam_retry_review_id'=>$this->review->id,
                'review_type'=>'mcq',
                'note'=>$question->description, 
                'explanation'=>$question->explanation, 
                'currect_answer'=>'', 
                'user_answer'=>$user_answer,  
                'exam_id'=> $this->review->exam_id,
                'question_id'=> $question->question_id,
                'title_text'=> $question->title_text,
                'sub_question'=> $question->sub_question,
                'user_id'=>$this->review->user_id,
                'time_taken'=>$takentime[$question->slug]??0,
                'category_id'=>$question->category_id,
                'sub_category_id'=>$question->sub_category_id,
                'sub_category_set'=>$question->sub_category_set
            ]);
            
            // $takentimereview[$revquestion->slug]=$takentime[$question->slug]??0;
            
            foreach($question->answers as $ans){
                ExamRetryAnswer::store([
                    'exam_retry_review_id'=>$this->review->id,
                    'user_exam_review_id'=>$this->review->user_exam_review_id,
                    'exam_retry_question_id'=>$revquestion->id,
                    'title'=>$ans->title,
                    'iscorrect'=>$ans->iscorrect,
                    'user_answer'=>(($ans->slug==$user_answer)?true:false),
                    'exam_id'=> $this->review->exam_id,
                    'question_id'=> $question->question_id,
                    'answer_id'=> $ans->answer_id,
                    'user_id'=>$this->review->user_id,
                ]); 
            }  
        }
    }
}
