<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([VisibleStatus::class])]
class Learn extends Model
{
    use HasFactory,ResourceModel,SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'learn_type',
        'video_url',
        'short_question',
        'short_answer',
        'note',
        'explanation',
        'mcq_question',
        'category_id',
        'sub_category_id',
        'visible_status',
        'order_no',
    ];



    public function learnanswers()
    {
        return $this->hasMany(LearnAnswer::class,'learn_id','id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
