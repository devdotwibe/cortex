<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRetryQuestion extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'user_exam_review_id',
        'exam_retry_review_id',
        'review_type',
        'note', 
        'explanation', 
        'currect_answer', 
        'user_answer', 
        'duration',
        'takenduration',
        'slug',
        'exam_id',
        'question_id',
        'user_id',
        'time_taken',
        'title_text',
        'sub_question',
        'category_id',
        'sub_category_id',
        'sub_category_set'
    ];
}
