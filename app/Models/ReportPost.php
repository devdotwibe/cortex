<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPost extends Model
{   
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'reason', 
        'type', 
        'post_id',  
        'user_id',   
        'status',   
    ];
    public function user(){
       return $this->belongsTo(User::class);
    }
    public function post(){
       return $this->belongsTo(Post::class);
    }
}
