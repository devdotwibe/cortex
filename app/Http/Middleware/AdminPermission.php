<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,$opt): Response
    {
          /**
         * @var Admin
         */

         dd($opt);

        $admin = Auth::guard('admin')->user();

         if ($admin->role !='master') {
          
          
            return $next($request);

        } else {
          
            return $next($request);
        }

    }
}
