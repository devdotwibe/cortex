<?php

namespace App\Models;

use App\Models\Scopes\PublicBan;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([PublicBan::class])]
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
        'admin_id', 
        'status',
        'visible_status',
    ];

    public function user(){
       return $this->belongsTo(User::class);
    }
    public function admin(){
       return $this->belongsTo(Admin::class);
    }
    public function pollOption(){
        return $this->hasMany(PollOption::class);
    }
    public function likes(){
        return $this->hasMany(PostLike::class);
    }
    public function hashtaglist(){
        return $this->belongsTo(Hashtag::class);
    }
    public function comments(){
        return $this->hasMany(PostComment::class);
    }
}
