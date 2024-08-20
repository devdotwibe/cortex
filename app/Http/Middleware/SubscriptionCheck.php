<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$opt): Response
    {
        /**
         * @var User
         */
        $user = Auth::user();
        if($user->is_free_access){
            return $next($request);
        }
        
        if (in_array('learn', $opt)) {
            $category = $request->route('category');
            if (!empty($category)) {
                if (Category::where('id', '<', $category->id)->whereIn("id", Learn::select('category_id'))->count() == 0) {
                    $subcategory = $request->route('sub_category');
                    if (!empty($subcategory)) {
                        if (SubCategory::where('id', '<', $subcategory->id)->whereIn("id", Learn::select('sub_category_id'))->count() == 0) {
                            return $next($request);
                        }
                    } else {
                        return $next($request);
                    }
                }
            }

        }
        if (in_array('question-bank', $opt)) {
            $category = $request->route('category');
            if (!empty($category)) {
                $exam = Exam::where("name", 'question-bank')->first();
                if (empty($exam)) {
                    $exam = Exam::store([
                        "title" => "Question Bank",
                        "name" => "question-bank",
                    ]);
                    $exam = Exam::find($exam->id);
                }
                if (Category::where('id', '<', $category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'))->count() == 0) {
                    $setname = $request->route('setname');
                    if (!empty($setname)) {
                        if (Setname::where('id', '<', $setname->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('sub_category_set'))->count() == 0) {
                            return $next($request);
                        }
                    } else {
                        return $next($request);
                    }
                }
            }

        }
        if (in_array('topic-test', $opt)) {
            $category = $request->route('category');
            if (!empty($category)) {
                $exam = Exam::where("name", 'topic-test')->first();
                if (empty($exam)) {
                    $exam = Exam::store([
                        "title" => "Topic Test",
                        "name" => "topic-test",
                    ]);
                    $exam = Exam::find($exam->id);
                }
                if (Category::where('id', '<', $category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'))->count() == 0) {
                    return $next($request);
                }
            }
        }

        if (in_array('full-mock-exam', $opt)) {
            $exam = $request->route('exam');
            if (!empty($exam)) {
                if (Exam::where('id', '<', $exam->id)->where("name", 'full-mock-exam')->whereIn("id", Question::select('exam_id'))->count() == 0) {
                    return $next($request);
                }
            }
        }

        if ($user->progress('cortext-subscription-payment', '') == "paid") {
            return $next($request);
        }
        if ($user->progress('cortext-subscription-payment', '') == "expired") {
            return redirect()->route('profile.view')->with('error', 'Your Subscription Plan is expired.Please Subscribe for continue.')->with('subscribe', 'Your Subscription Plan is expired.Please Subscribe for continue.');
        }
        return redirect()->route('profile.view')->with('error', 'Please Subscribe the plan.')->with('subscribe', 'Please Subscribe the plan.');

    }
}
