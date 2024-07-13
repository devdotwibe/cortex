<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasAvailablePrivateClass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         *  @var User
         */
        $user=Auth::user();
        if((optional($user->privateClass)->status??"")=="approved"&&(optional($user->privateClass)->is_valid??false)){
            return $next($request);
        }
        return redirect()->back()->with('error',"Private Class Not-Available");
    }
}
