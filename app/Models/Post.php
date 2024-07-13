<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title', 
        'description', 
        'type', 
        'image', 
        'video', 
        'user_id',  
        'status'
    ];

    public function user(){
       return $this->belongsTo(User::class);
    }
}
