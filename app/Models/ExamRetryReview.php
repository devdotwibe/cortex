<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRetryReview extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'title',
        'name',  
        'user_id',
        'exam_id', 
        'progress',
        'timetaken',
        'flags',
        'times',
        'passed',
        'questions',
        'time_of_exam',
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
        'user_exam_review_id', 
    ];
}
