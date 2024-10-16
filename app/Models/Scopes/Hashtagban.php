<?php

namespace App\Models\Scopes;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class Hashtagban implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {        
        if(Auth::guard('admin')->check()||session('is.logined.as','admin')=="user"){
            $builder->whereIn('post_id', function($query) {
                $query->select('id')
                      ->from('posts') // Assuming the table name is 'posts'
                      ->whereIn('user_id', function($subQuery) {
                          $subQuery->select('id')
                                   ->from('users') // Assuming the table name is 'users'
                                   ->where('post_status', 'active');
                      })->orWhereNotNull('admin_id');
            });
        }
        
    }
}