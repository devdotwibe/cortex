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
        'subject',
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
