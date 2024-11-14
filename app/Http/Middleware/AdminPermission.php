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

        $admin = Auth::guard('admin')->user();

        if ($admin->role !='master') {
          
            // $admin_permission = AdminPermission::where('admin_id',$admin->id)->first();

            if(!empty($admin->permission))
            {
                switch ($opt) {

                    case 'users':
                       
                        if ($admin->permission->users != 'Y') {

                            return $next($request);
                        }
                        break;
                    
                    case 'learn':
                     
                        if ($admin->permission->learn != 'Y') {

                            return $next($request);
                        }
                        break;
        
                    case 'options':
                     
                        if ($admin->permission->options != 'Y') {

                            return $next($request);
                        }
                        break;

                    case 'question_bank':
                    
                        if ($admin->permission->question_bank != 'Y') {

                            return $next($request);
                        }
                        break;
                    
                    case 'exam_simulator':
                
                        if ($admin->permission->exam_simulator != 'Y') {

                            return $next($request);
                        }
                        break;

                    case 'live_teaching':
                
                        if ($admin->permission->live_teaching != 'Y') {

                            return $next($request);
                        }
                        break;

                    case 'community':
                
                        if ($admin->permission->community != 'Y') {

                            return $next($request);
                        }
                        break;

                    case 'pages':
            
                        if ($admin->permission->pages != 'Y') {

                            return $next($request);
                        }
                        break;
        
                    default:
                      
                        return redirect()->back();
                }
            }
            else
            {
                return redirect()->back();
            }
          

        } else {
          
            return $next($request);
        }

    }
}
