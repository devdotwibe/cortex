<?php

namespace App\Jobs;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Support\Helpers\OptionHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportQuestions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    
    /**
     * 
     * @var Exam
     */
    protected $exam; 

    protected $fields=[];

    /**
     * Category variable
     *
     * @var Category|null
     */
    protected $category;


    /**
     * SubCategory variable
     *
     * @var SubCategory|null
     */
    protected $subCategory;

    /**
     * SubCategory Set variable
     *
     * @var Setname|null
     */
    protected $setname;
    
    /**
     * Summary of __construct
     * @param string $filename
     * @param Exam $exam
     * @param Category|null $category
     * @param SubCategory|null $subCategory
     * @param Setname|null $setname
     * @param array|null $fields
     */
    public function __construct($filename,$exam,$category=null,$subCategory=null,$setname=null,$fields=[])
    {
        $this->filename=$filename;
        $this->exam=$exam;
        $this->fields=$fields;
        $this->category=$category;
        $this->subCategory=$subCategory;
        $this->setname=$setname;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        OptionHelper::setData("{$this->exam->name}-import-question",'started');
        OptionHelper::setData("{$this->exam->name}-import-question-status",'progress');
        $datalist=Storage::json("importfile/{$this->filename}")??[];
        $count=count($datalist);  
        foreach ($datalist as $i => $row) { 
            if(OptionHelper::getData("{$this->exam->name}-import-question","")=="stop"){
                break;
            }
            $row=$datalist[$i];  
            if($this->exam->name=="full-mock-exam"){

                $question=Question::store([
                    "exam_id"=>$this->exam->id,
                    "category_id"=>$row[$this->fields['category']],
                    "sub_category_id"=>optional($this->subCategory)->id,
                    "sub_category_set"=>optional($this->setname)->id,
                    "description"=>$row[$this->fields['description']],
                    "explanation"=>$row[$this->fields['explanation']]
                ]);
            } else{

                $question=Question::store([
                    "exam_id"=>$this->exam->id,
                    "category_id"=>optional($this->category)->id,
                    "sub_category_id"=>optional($this->subCategory)->id,
                    "sub_category_set"=>optional($this->setname)->id,
                    "description"=>$row[$this->fields['description']],
                    "explanation"=>$row[$this->fields['explanation']]
                ]);
            }
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="A"?true:false,
                "title"=>$row[$this->fields['answer_1']]
            ]);
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="B"?true:false,
                "title"=>$row[$this->fields['answer_2']]
            ]);
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="C"?true:false,
                "title"=>$row[$this->fields['answer_3']]
            ]);
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="D"?true:false,
                "title"=>$row[$this->fields['answer_4']]
            ]);
            $i++;
            OptionHelper::setData("{$this->exam->name}-import-question-completed",round($i*100/$count,2));
        }
        OptionHelper::setData("{$this->exam->name}-import-question",'end');
        sleep(1);
        Storage::delete("importfile/{$this->filename}");
        OptionHelper::setData("{$this->exam->name}-import-question",null);
        OptionHelper::setData("{$this->exam->name}-import-question-status",null);
        OptionHelper::setData("{$this->exam->name}-import-question-completed",null);
    } 
}
