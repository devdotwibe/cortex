<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermAccess extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable=[
        'slug',
        'user_id',
        'type',
        'term_id'
    ];
}
