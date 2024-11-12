<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtagstore extends Model
{
    use HasFactory;

    
    protected $table = 'hashtagstore';

   
    protected $fillable = ['hashtag'];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'hashtags', 'hashtagstore_id', 'post_id')
                    ->withPivot('hashtag')
                    ->withTimestamps();
    }
  
}
