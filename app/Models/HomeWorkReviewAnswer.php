<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWorkReviewAnswer extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title',
        'iscorrect',
        'user_answer',
        'home_work_id',
        'home_work_book_id',
        'home_work_answer_id',
        'home_work_review_id',
        'home_work_question_id',
        'home_work_review_question_id',
    ];
}
