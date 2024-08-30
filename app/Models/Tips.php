<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Trait\ResourceModel;

class Tips extends Model
{
    use HasFactory;

    protected $table = 'tip_advice';
    protected $fillable = [
        
        'tip', 
                 
        'category_id', 
            
        'advice'
        
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
