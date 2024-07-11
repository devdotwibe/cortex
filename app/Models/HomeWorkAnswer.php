<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWorkAnswer extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description', 
        'iscorrect', 
        'slug',
        'home_work_id', 
        'home_work_book_id',
        'home_work_question_id'
    ];
}
