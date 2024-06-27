<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([VisibleStatus::class])]
class SubCategory extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'name',
        'category_id',
        'visible_status'
    ];

    public function setname()
    {
        return $this->hasMany(Setname::class,'sub_category_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
