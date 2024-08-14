<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = ['slug','user_id','post_id','post_comment_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
