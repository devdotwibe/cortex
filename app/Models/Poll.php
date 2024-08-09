<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = ['slug','user_id','post_id','poll_option_id'];

    public function pollOption(){
        return $this->belongsTo(PollOption::class);
    }

    public function votes()
    {
        return $this->hasMany(PollOption::class);
    }

    
}
