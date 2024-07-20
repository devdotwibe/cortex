<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'option1',
        'option2',
        'option1_votes',
        'option2_votes'
    ];
}
