<?php

namespace App\Jobs;

use App\Models\Question;
use App\Models\UserExamAnswer;
use App\Models\UserExamQuestion;
use App\Models\UserProgress;
use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ProcessExamSetup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userExam;

    public function __construct($userExam)
    {
        $this->userExam = $userExam;
    }

    public function handle()
    {
        $questions = Question::with('answers')
            ->where('exam_id', $this->userExam->exam_id)
            ->where('category_id', $this->userExam->category_id)
            ->where('sub_category_id', $this->userExam->sub_category_id)
            ->where('sub_category_set', $this->userExam->sub_category_set)
            ->get();

        foreach ($questions as $question) {
            $userQuestion = UserExamQuestion::store([
                'title' => $question->title,
                'description' => $question->description,
                'duration' => $question->duration,
                'exam_id' => $this->userExam->exam_id,
                'user_exam_id' => $this->userExam->id,
                'category_id' => $question->category_id,
                'sub_category_id' => $question->sub_category_id,
                'sub_category_set' => $question->sub_category_set,
                'explanation' => $question->explanation,
                'title_text' => $question->title_text,
                'sub_question' => $question->sub_question,
                'question_id' => $question->id,
                'user_id' => $this->userExam->user_id,
                'order_no' => $question->order_no
            ]);

            foreach ($question->answers as $answer) {
                UserExamAnswer::store([
                    'title' => $answer->title,
                    'description' => $answer->description,
                    'image' => $answer->image,
                    'user_exam_question_id' => $userQuestion->id,
                    'iscorrect' => $answer->iscorrect,
                    'question_id' => $question->id,
                    'answer_id' => $answer->id,
                    'user_id' => $this->userExam->user_id,
                    'exam_id' => $this->userExam->exam_id,
                    'user_exam_id' => $this->userExam->id,
                ]);
            }
        }
    }
}

