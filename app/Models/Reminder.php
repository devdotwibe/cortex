<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'name', 
        'remind_date', 
        'status',  
        'user_id',   
    ];
    public function user(){
       return $this->belongsTo(User::class);
    }
}
