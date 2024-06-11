<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description', 
        'duration', 
        'exam_id', 
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
        'slug'
    ];
}
