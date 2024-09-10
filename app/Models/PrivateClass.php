<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateClass extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'email', 
        'full_name', 
        'parent_name', 
        'phone', 
        'timeslot', 
        'user_id',  
        'status',
        'is_valid'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'timeslot' => 'array', 
        ];
    }
}
