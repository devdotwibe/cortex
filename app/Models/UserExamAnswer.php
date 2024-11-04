<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamAnswer extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description',
        'user_exam_id',  
        'user_exam_question_id', 
        'iscorrect', 
        'user_answer',
        'slug',
        'exam_id',
        'question_id',
        'answer_id',
        'user_id'
    ];

    public function answer() {
        return $this->belongsTo(Answer::class);
    }
}
