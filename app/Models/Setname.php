<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([VisibleStatus::class])]
class Setname extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'name',
        'sub_category_id',
        'category_id',
        'visible_status',
        'time_of_exam'
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class,'sub_category_id');
    }
   
}
