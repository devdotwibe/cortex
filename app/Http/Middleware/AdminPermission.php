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
    public function handle(Request $request, Closure $next, $opt): Response
    {
        /**
         * @var Admin
         */

        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('login');
        }

        if ($admin->role != 'master') {

            if (!empty($admin->permission)) {

                switch ($opt) {

                    case 'users':

                        if ($admin->permission->users != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Users.');
                        }
                        break;

                    case 'learn':

                        if ($admin->permission->learn != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Learn.');
                        }
                        break;

                    case 'options':

                        if ($admin->permission->options != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Options.');
                        }
                        break;

                    case 'question_bank':

                        if ($admin->permission->question_bank != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Question Bank.');
                        }
                        break;

                    case 'topic_exam':

                        if ($admin->permission->topic_exam != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Exam Simulator.');
                        }
                        break;

                    case 'full_mock_exam':

                        if ($admin->permission->full_mock_exam != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Exam Simulator.');
                        }
                        break;

                    case 'live_teaching':

                        if ($admin->permission->live_teaching != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Live Teaching.');
                        }
                        break;

                    case 'community':

                        if ($admin->permission->community != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Community.');
                        }
                        break;

                    case 'pages':

                        if ($admin->permission->pages != 'Y') {

                            return redirect()->route('admin.admin_dashboard')->with('error', 'You do not have permission to access Pages.');
                        }
                        break;

                    default:

                        return redirect()->route('admin.admin_dashboard')->with('error', 'Permission option is invalid.');
                }
            } else {
                return redirect()->route('admin.admin_dashboard')->with('error', 'No permissions found for this admin.');
            }

        }

        return $next($request);

    }
}
