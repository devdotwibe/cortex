<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = ['slug','user_id','post_id','comment','post_comment_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes(){
        return $this->hasMany(CommentLike::class);
    }
    public function replys(){
        return $this->hasMany(PostComment::class);
    }
}
