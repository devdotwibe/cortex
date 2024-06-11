<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'name',
        'category_id',
    ];

    public function setname()
    {
        return $this->belongsTo(Setname::class,'id','sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
