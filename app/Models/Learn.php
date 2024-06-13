<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learn extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'title',
        'learn_type',
        'video_url',
        'short_question',
        'short_answer',
        'mcq_question',
        'category_id',
        'sub_category_id',
    ];



    public function learnanswers()
    {
        return $this->hasMany(LearnAnswer::class,'learn_id','id');
    }

    public function subcategories()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
