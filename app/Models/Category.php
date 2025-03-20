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
    

      public function getExamAvg($exam) {


        $examId = Exam::where('name', $exam)->select('id')->get();

       $user =  User::whereIn('id',UserExamReview::whereIn('exam_id', Exam::where('name', $exam)->select('id'))
       ->where("category_id", $this->id)->select('user_id'))->get();

       foreach($user as $avg)
       {
            $correct_answer =  UserReviewAnswer::where('user_id',$avg->id)
                                ->whereIn('exam_id',Exam::where('name',$exam)
                                ->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)
                                ->select('id'))->where("category_id",$this->id)->select('id'))
                                ->where('iscorrect',true)->where('user_answer',true)->count();

            $total_question = UserReviewQuestion::where('user_id',$avg->id)
                ->whereIn('exam_id',Exam::where('name',$exam)
                ->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)
                ->select('id'))->where("category_id",$this->id)
                ->select('id'))->count();
       }
       

    }

    public function getExamUser($exam)
    {
        $userScores = UserExamReview::whereIn('exam_id', Exam::where('name', $exam)->select('id'))
        ->where("category_id", $this->id)
        ->distinct('user_id')
        ->count('user_id'); 

        return $userScores;
    }
    
    // public function getExamAvgPercentage($exam){

    //     $avg=$this->getExamAvg($exam);

    //     $total_users=$this->getExamUser($exam);

    //     // $total=$this->getQuestionCount($exam);

    //     if($avg>0&&$total_users>0){
    //         return round($avg*100/$total_users,2);
    //     }else{
    //         return 0;
    //     }
    // }

    public function getExamAvgPercentage($exam){
   

        if (session()->has('exam_average_percentage_'.$this->id)) {

            return session('exam_average_percentage_'.$this->id);
        }

        $users = UserReviewAnswer::whereIn('exam_id', Exam::where('name', $exam)
        ->where('iscorrect', true) 
        ->select('id'))->distinct('user_id')
        ->pluck('user_id');
    
        $totalPercentage = 0;
        $userCount = count($users); 
    
        if ($userCount > 0) {
            foreach ($users as $user) {
              
                $total = $this->getQuestionUserCount($exam, $user);
                $avg = $this->getExamMark($exam, $user);
                
                if ($avg > 0 && $total > 0) {
                 
                    $totalPercentage += round($avg * 100 / $total, 2);
                }
            }
            
            return round($totalPercentage / $userCount, 2);
        } else {
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

    public function getExamAvgMark($exam) {
       

        if (session()->has('exam_average_mark_'.$this->id)) {

            return session('exam_average_mark_'.$this->id);
        }

        $examId = Exam::where('name', $exam)->value('id');
        
        if (!$examId) {
            return 0; 
        }

        $users = UserReviewAnswer::select('user_id')
            ->where('exam_id', $examId)
            ->where('iscorrect', true) 
            ->distinct('user_id')
            ->pluck('user_id');
        
        $totalMarks = 0;
        $userCount = count($users);
    
        if ($userCount > 0) {
         
            foreach ($users as $user) {
                $total = $this->getQuestionUserCount($exam, $user);
                $avg = $this->getExamMark($exam, $user);
    
                if ($avg > 0 && $total > 0) {
                    $totalMarks += $avg; 
                }
            }
    
            return round($totalMarks / $userCount, 2);
        } else {
            return 0; 
        }
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
