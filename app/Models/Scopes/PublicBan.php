<?php

namespace App\Models\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class PublicBan implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {       
        // Apply the condition for checking posts with admin_id not null
        $adminpostExists = $builder->whereNotNull('admin_id')->exists();

        if (!Auth::guard('admin')->check() || session('is.logined.as') === 'user' || !$adminpostExists) {
            $builder->where(function($qry){
                $qry->where(function($iqry){
                    $iqry->where('visible_status','show')->whereIn('user_id',User::where('post_status','active')->select('id'));
                });
                $qry->orWhere('user_id',Auth::id());
            });
        }
    }
}
