<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table='subscription';
    protected $fillable=['user_id','payment_id','customer_id','amount','start_date','expiration_date'];
    use HasFactory;
}
