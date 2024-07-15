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
        $status=optional($user->privateClass)->status??"";
        if($status=="approved"){
            if((optional($user->privateClass)->is_valid??false)){
                return $next($request);
            }else{
                return redirect()->back()->with('error',"Your Private Class is temporarily deactivated by admin. For further details please contact admin@cortex.com");
            }
        }elseif($status=="rejected"){
            return redirect()->back()->with('error',"Your account is rejected by the admin, To know more please contact admin@cortex.com");
        }
        else{
            return redirect()->back()->with('error',"Your account is under verification, verification may take 24 hours, please wait.");
        }

    }
}
