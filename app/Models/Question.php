<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([VisibleStatus::class])]
class Question extends Model
{
    use HasFactory,ResourceModel,SoftDeletes;
    protected $fillable = [
        'title', 
        'description', 
        'duration', 
        'exam_id', 
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
        'slug',
        'explanation',
        'visible_status',
        'title_text',
        'sub_question',
        'order_no',
        'admin_id',
    ];
    
    public function questionExam(){
        return $this->hasOne(Exam::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
    public function setname(){
        return $this->belongsTo(Setname::class,'sub_category_set');
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
