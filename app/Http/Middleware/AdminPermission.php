<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
{

    protected $parameter;

    /**
     * AdminPermission constructor.
     * 
     * @param string $parameter
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;  // Store the parameter
    }

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

         dd($this->parameter);
         
        $admin = Auth::guard('admin')->user();

         if ($admin->role !='master') {
          
          
            return $next($request);

        } else {
          
            return $next($request);
        }

    }
}
