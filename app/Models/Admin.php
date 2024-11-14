<?php

namespace App\Models;

use App\Http\Middleware\AdminPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 

class Admin extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $guard = "admin";


    public function permission(){
        return $this->belongsTo(AdminPermission::class);
    }
}
