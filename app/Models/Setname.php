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
        'visible_status'
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
   
}
