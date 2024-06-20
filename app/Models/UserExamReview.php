<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamReview extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title',
        'name', 
        'progress', 
        'user_id',
        'exam_id', 
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
    ];
}
