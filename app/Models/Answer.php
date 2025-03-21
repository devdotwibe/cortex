<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description',
        'exam_id',  
        'question_id', 
        'iscorrect', 
        'slug',
        'image'
    ];
}
