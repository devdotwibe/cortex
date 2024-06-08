<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankChapter extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title', 
        'question_bank_topic_id'
    ];
}
