<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title',
        'name',
        'description', 
        'price',  
        'discount',
        'duration',
        'time_of_exam',
        'overview',
        'requirements',
        'fees', 
        'slug'
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function subtitle($id,$defaultTitle){
        return optional($this->categoryTitle()->where("category_id",$id)->first())->title??$defaultTitle;
    }
    public function categoryTitle(){
        return $this->hasMany(ExamCategoryTitle::class);
    }
}
