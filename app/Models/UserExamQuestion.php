<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamQuestion extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description', 
        'duration', 
        'exam_id', 
        'user_exam_id', 
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
        'slug',
        'explanation',
        'visible_status',
        'title_text',
        'sub_question',
        'user_id',
        'question_id'
    ];
    public function answers(){
        return $this->hasMany(UserExamAnswer::class);
    }
}
