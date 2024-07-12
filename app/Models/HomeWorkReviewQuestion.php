<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWorkReviewQuestion extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title',
        'duration',
        'review_type',
        'note',
        'explanation',
        'currect_answer',
        'user_answer',
        'time_taken',
        'home_work_id', 
        'home_work_book_id',
        'home_work_question_id',
        'user_id',
        'home_work_review_id', 
    ];
}
