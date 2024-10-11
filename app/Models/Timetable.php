<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $table = 'timetable';

    // Fillable fields
    protected $fillable = [
        'starttime', 
        'endtime', 
        'starttime_am_pm', 
        'endtime_am_pm', 
        'day', 
        'classtime', 
        'count'
    ];
}
