<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
