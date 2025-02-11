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
        if($user->subscriptionExpire()){

            return $next($request);
        }

        // if ($user->progress('cortext-subscription-payment', '') == "paid") {
        //     return $next($request);
        // }
        $subscription=$user->subscription();
        if(!empty($subscription)&&$subscription->status=="subscribed"){
            return $next($request);
        }
        
        if (in_array('learn', $opt)) {
            $category = $request->route('category');
           
            if (!empty($category) && in_array($category->id, explode(',', $user->free_access_terms)) || Category::where('id', '<', $category->id)->whereIn("id", Learn::select('category_id'))->count() == 0 ) {

                // if (Category::where('id', '<', $category->id)->whereIn("id", Learn::select('category_id'))->count() == 0) {

                    $subcategory = $request->route('sub_category');

                    if (!empty($subcategory)) {
                        // dd(SubCategory::where('id', '<', $subcategory->id)->where('category_id', $category->id)->whereIn("id", Learn::select('sub_category_id'))->count());

                        if (SubCategory::where('id', '<', $subcategory->id)->where('category_id', $category->id)->whereIn("id", Learn::select('sub_category_id'))->count() == 0) {
                            return $next($request);
                        }
                    } else {
                        return $next($request);
                    }
                // }
            }
        }
        if (in_array('question-bank', $opt)) {

            $category = $request->route('category');

            $exam = Exam::where("name", 'question-bank')->first();
            if (empty($exam)) {
                $exam = Exam::store([
                    "title" => "Question Bank",
                    "name" => "question-bank",
                ]);
                $exam = Exam::find($exam->id);
            }

            if (!empty($category) && in_array('question_bank', explode(',', $user->free_access_terms)) || Category::where('id', '<', $category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'))->count() == 0) {
             
                // if (Category::where('id', '<', $category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'))->count() == 0) {

                    $setname = $request->route('setname');
                    if (!empty($setname)) {

                        if (Setname::where('id', '<', $setname->id)->where('category_id',$category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('sub_category_set'))->count() == 0) {
                            return $next($request);
                        }
                    } else {

                        return $next($request);
                    }

                // }

                // return $next($request);
            }

        }
        if (in_array('topic-test', $opt)) {
            $category = $request->route('category');

            $exam = Exam::where("name", 'topic-test')->first();
            if (empty($exam)) {
                $exam = Exam::store([
                    "title" => "Topic Test",
                    "name" => "topic-test",
                ]);
                $exam = Exam::find($exam->id);
            }

            if (!empty($category) && in_array('exam_simulator', explode(',', $user->free_access_terms)) || Category::where('id', '<', $category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'))->count() == 0) {
               
                // if (Category::where('id', '<', $category->id)->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'))->count() == 0) {
                //     return $next($request);
                // }

                return $next($request);
            }
        }

        if (in_array('full-mock-exam', $opt)) {
            $exam = $request->route('exam');
            if (!empty($exam) && in_array('exam_simulator', explode(',', $user->free_access_terms))) {
                
                // if (Exam::where('id', '<', $exam->id)->where("name", 'full-mock-exam')->whereIn("id", Question::select('exam_id'))->count() == 0) {
                //     return $next($request);
                // }

                return $next($request);
            }
        }
        if(!empty($subscription)&&$subscription->status=="expired"){
            return redirect(route('pricing.index')."#subscription")->with('error', 'Your Subscription Plan is expired.Please Subscribe for continue.')->with('subscribe', 'Your Subscription Plan is expired.Please Subscribe for continue.');
        } 
        return redirect(route('pricing.index')."#subscription")->with('error', 'Please Subscribe the plan.')->with('subscribe', 'Please Subscribe the plan.');

    }
}
