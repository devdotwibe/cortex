<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#[ScopedBy([VisibleStatus::class])]
class Category extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'name',
        'visible_status',
        'time_of_exam',
        'tip_icon'
    ];

    public function tipIcon($id,$defaultIcon){
        $icon=optional($this->where("id",$id)->first())->tip_icon;
        if(!empty($icon)){
            return url("d0/$icon");
        }else{
            return $defaultIcon;
        } 
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class,'category_id','id')->orderBy('created_at', 'asc');
    }
    public function question()
    {
        return $this->hasMany(Question::class,'category_id','id');
    }

   
    // public function getExamAvgPercentage($exam){

    //     $avg=$this->getExamAvg($exam);
    //     $total=$this->getQuestionCount($exam);
    //     if($avg>0&&$total>0){
    //         return round($avg*100/$total,2);
    //     }else{
    //         return 0;
    //     }
    // }

    // public function getExamAvg($exam){
    //     $anscnt=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
    //     $exmcnt=UserExamReview::whereIn('id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->count();
    //     if($anscnt>0&&$exmcnt>0){
    //         return round($anscnt/$exmcnt,2);
    //     }else{
    //         return 0;
    //     }
    // }

  
    public function getExamAvg($exam) {


        $examIds = Exam::where('name', $exam)->pluck('id');
    
        // $totalQuestions = Question::whereIn('exam_id', $examIds)
        //     ->where('category_id', $this->id)
        //     ->count();
            
        // $totalQuestions = UserReviewQuestion::whereIn('exam_id', $examIds)
        // ->where("category_id", $this->id)
        // ->count();
        // $totalQuestions = UserReviewQuestion::whereIn('exam_id',Exam::where('name',$exam)
        //                 ->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)
        //                 ->select('id'))->where("category_id",$this->id)
        //                 ->select('id'))->count();

        $totalQuestions = UserReviewAnswer::join('user_exam_reviews', 'user_review_answers.user_exam_review_id', '=', 'user_exam_reviews.id')
            ->whereIn('user_exam_reviews.exam_id', $examIds)
            ->where('user_exam_reviews.category_id', $this->id)
            ->where('user_review_answers.iscorrect', true)
            ->distinct()
            ->count('user_review_answers.question_id'); 
    
        if ($totalQuestions == 0) {
            return 0;
        }
        $totalUsers = UserExamReview::whereIn('exam_id', $examIds)
            ->where('category_id', $this->id)
            ->distinct()
            ->count('user_id');
    
        if ($totalUsers == 0) {
            return 0;
        }
    
        // $userScores = UserReviewAnswer::join('questions', 'user_review_answers.question_id', '=', 'questions.id')
        //     ->join('user_exam_reviews', 'user_review_answers.user_exam_review_id', '=', 'user_exam_reviews.id')
        //     ->whereIn('questions.exam_id', $examIds)
        //     ->where('questions.category_id', $this->id)
        //     ->where('user_review_answers.iscorrect', true)
        //     ->selectRaw('user_review_answers.user_exam_review_id, COUNT(user_review_answers.id) as correct_answers')
        //     ->groupBy('user_review_answers.user_exam_review_id')
        //     ->get();

        $userScores = UserReviewAnswer::join('user_exam_reviews', 'user_review_answers.user_exam_review_id', '=', 'user_exam_reviews.id')
        ->whereIn('user_exam_reviews.exam_id', $examIds)
        ->where('user_exam_reviews.category_id', $this->id)
        ->where('user_review_answers.iscorrect', true)
        ->selectRaw('user_review_answers.user_exam_review_id, COUNT(user_review_answers.id) as correct_answers')
        ->groupBy('user_review_answers.user_exam_review_id')
        ->havingRaw('COUNT(user_review_answers.id) > 0') 
        ->get();
    
        $totalScore = 0;
    
        foreach ($userScores as $userScore) {
       
            $userAverage = $userScore->correct_answers / $totalQuestions;
            $totalScore += $userAverage;
        }

        return round($totalScore / $totalUsers, 2);
    }
    


    // public function getExamAvg($exam) {
    

    //     $examId = Exam::where('name', $exam)->select('id')->first();
    
    //     if (!$examId) {
    //         return 0; 
    //     }
    
    //     $totalQuestions = UserReviewQuestion::where('exam_id', $examId->id)
    //                                         ->whereIn('question_id', Question::where('exam_id', $examId->id)
    //                                         ->where("category_id", $this->id)
    //                                         ->pluck('id'))
    //                                         ->count();
    
    //     if ($totalQuestions == 0) {
    //         return 0;  
    //     }
        
    //     $userScores = UserExamReview::where('exam_id', $examId->id)
    //     ->where("category_id", $this->id)
    //     ->groupBy('user_id')
    //     ->select(DB::raw('MAX(id) as latest_id'), 'user_id')
    //     ->get();
    
    //     $totalUsers = $userScores->count();
    
    //     $totalScore = 0;
    
    //     foreach ($userScores as $userScore) {
    //         $userAverage = $userScore->correct_answers / $totalQuestions;
    //         $totalScore += $userAverage;
    //     }
    
    //     if ($totalUsers > 0) {
    //         return round($totalScore / $totalUsers, 2);
    //     }
    
    //     return 0;  // Return 0 if no users have taken the exam
    // }
    

    public function getExamUser($exam)
    {
        $userScores = UserExamReview::whereIn('exam_id', Exam::where('name', $exam)->select('id'))
        ->where("category_id", $this->id)
        ->distinct('user_id')
        ->count('user_id'); 

        return $userScores;
    }
    
    public function getExamAvgPercentage($exam){

        $avg=$this->getExamAvg($exam);

        $total_users=$this->getExamUser($exam);

        // $total=$this->getQuestionCount($exam);

        if($avg>0&&$total_users>0){
            return round($avg*100/$total_users,2);
        }else{
            return 0;
        }
    }

    public function getExamAvgTime($exam){
        return round(UserReviewQuestion::whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function getQuestionCount($exam){
        return Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->count();
    }

    public function getQuestionUserCount($exam,$user){

        return UserReviewQuestion::where('user_id',$user)->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->count();
    }
    public function getExamQuestionTime($exam){
        $cnt=$this->getQuestionCount($exam);
        if($exam=="topic-test"){
            if(!empty($this->time_of_exam)&&$cnt>0){
                $time=explode(':',$this->time_of_exam);
                return round(((trim($time[0])*(count($time)*60))+(trim($time[1]??0)*60))/$cnt,2);
            }
        }
        if($exam=="question-bank"){
            $time=Setname::whereIn('id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('sub_category_set'))->whereNotNull('time_of_exam')->sum(DB::raw("(CAST(SUBSTRING_INDEX(time_of_exam, ':', 1) AS UNSIGNED) * 3600) + (CAST(SUBSTRING_INDEX(time_of_exam, ':', -1) AS UNSIGNED) * 60)"));
            if($cnt>0){
                return round($time/$cnt,2);
            }
        }
        return 0;
    }
    public function getExamMark($exam,$user){

        return UserReviewAnswer::where('user_id',$user)->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
        // ->whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))
    }
    public function getExamTime($exam,$user){
        return round(UserReviewQuestion::where('user_id',$user)->whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function getExamMarkPercentage($exam,$user){
        $avg=$this->getExamMark($exam,$user);
        $total=$this->getQuestionUserCount($exam,$user);
        if($avg>0&&$total>0){
            return round($avg*100/$total,2);
        }else{
            return 0;
        }
    }


    public function tips()
    {
        return $this->hasMany(Tips::class);
    }
}
