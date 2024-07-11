<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWorkBook extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title',
        'home_work_id', 
        'slug'
    ];

}
