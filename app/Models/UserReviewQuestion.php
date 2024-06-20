<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReviewQuestion extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'user_exam_review_id',
        'review_type',
        'note', 
        'explanation', 
        'currect_answer', 
        'user_answer', 
        'duration',
        'takenduration',
        'slug'
    ];
}
