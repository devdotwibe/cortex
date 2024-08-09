<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = ['slug','post_id', 'option', 'votes'];

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
