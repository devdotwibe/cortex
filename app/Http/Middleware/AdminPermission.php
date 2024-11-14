<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          /**
         * @var Admin
         */
        $admin = Auth::guard('admin')->user();

         if ($admin) {
          
            $adminId = $admin->id;
            dd('Admin ID: ' . $adminId);  

        } else {
          
            return redirect()->route('login');  
        }

        return $next($request);
    }
}
