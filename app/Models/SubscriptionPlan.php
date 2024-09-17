<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'name', 
        'title', 
        'basic_amount',   
        'combo_amount',   
        'content',
        'icon',
        'basic_amount_id',   
        'combo_amount_id',   
        'is_external',
        'external_link',
        'external_label'
    ]; 

}
