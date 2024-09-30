<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'name',
        'title',
        'timed',
        'user_id',
        'exam_id',
        'progress',
        'category_id',
        'time_of_exam',
        'sub_category_id',
        'sub_category_set', 
    ];
}
