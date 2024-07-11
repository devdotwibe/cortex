<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([VisibleStatus::class])]
class HomeWorkBook extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title',
        'home_work_id', 
        'slug',
        'visible_status'
    ];

}
