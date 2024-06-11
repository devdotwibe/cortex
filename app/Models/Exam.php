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
}
