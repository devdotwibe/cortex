<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCategoryTitle extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'title',
        'exam_id',
        'category_id', 
        'slug'
    ];
}
