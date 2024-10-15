<?php

namespace App\Models;
use App\Models\Scopes\Hashtagban;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// #[ScopedBy([Hashtagban::class])]
class Hashtag extends Model
{
    use HasFactory;

    protected $fillable = ['hashtag', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Prevent mass assignment vulnerabilities
    protected $guarded = [];
}