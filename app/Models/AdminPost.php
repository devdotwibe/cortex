<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPost extends Model
{
    use HasFactory;


    protected $table = 'admin_post';

    protected $fillable = [
        'slug',
        'title', 
        'description', 
        'type', 
        'image', 
        'video', 
        'status'
    ];
}
