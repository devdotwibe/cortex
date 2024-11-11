<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtagstore extends Model
{
    use HasFactory;

    
    protected $table = 'hashtagstore';

   
    protected $fillable = ['hashtag'];

  
}
