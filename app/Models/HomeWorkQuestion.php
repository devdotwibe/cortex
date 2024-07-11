<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([VisibleStatus::class])]
class HomeWorkQuestion extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title',
        'duration',
        'description',
        'explanation',
        'visible_status',
        'home_work_id', 
        'home_work_book_id',
    ];
    public function homeWorkBook(){
        return $this->belongsTo(HomeWorkBook::class);
    }
    public function answers(){
        return $this->hasMany(HomeWorkAnswer::class);
    }
}
