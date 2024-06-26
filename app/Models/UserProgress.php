<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'user_id',
        'name',
        'value', 
    ];
}
