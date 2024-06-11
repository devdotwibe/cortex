<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setname extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'name',
        'sub_category_id',
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
   
}
