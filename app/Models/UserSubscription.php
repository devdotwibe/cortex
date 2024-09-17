<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'stripe_id',
        'payment_id',
        'payment_status',
        'amount',
        'user_id',
        'subscription_plan_id',
        'expire_at',
        'email',
        'status'
    ];
}
