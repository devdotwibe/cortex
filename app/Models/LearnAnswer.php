<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnAnswer extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'mcq_answer',
        'learn_id',
    ];

    public function learn()
    {
        return $this->belongsTo(Learn::class);
    }

}
