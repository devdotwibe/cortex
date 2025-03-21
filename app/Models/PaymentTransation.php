<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransation extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
