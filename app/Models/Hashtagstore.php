<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtagstore extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'hashtagstore';

    // Specify which attributes can be mass-assigned
    protected $fillable = ['name'];

    // Optionally, if you do not want timestamps, you can disable them:
    // public $timestamps = false;
}
