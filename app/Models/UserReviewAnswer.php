<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReviewAnswer extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description',
        'user_exam_review_id',  
        'user_review_question_id', 
        'iscorrect', 
        'slug'
    ];
}
