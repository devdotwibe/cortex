<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRetryAnswer extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description',
        'user_exam_review_id',  
        'exam_retry_review_id',  
        'exam_retry_question_id', 
        'iscorrect', 
        'user_answer',
        'slug',
        'exam_id',
        'question_id',
        'answer_id',
        'user_id'
    ];
}
