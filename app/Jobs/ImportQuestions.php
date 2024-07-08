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
     * @var Category
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
     * @param Category $category
     * @param SubCategory|null $subCategory
     * @param Setname|null $setname
     * @param array|null $fields
     */
    public function __construct($filename,$exam,$category,$subCategory=null,$setname=null,$fields=[])
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
            $question=Question::findSlug($row[$this->fields['slug']]);
            if(empty($question)){
                $question=new Question;
                $question->slug=$row[$this->fields['slug']];
                $question->exam_id=$this->exam->id;
                $question->category_id=$this->category->id;
                $question->sub_category_id=optional($this->subCategory)->id;
                $question->sub_category_set=optional($this->setname)->id;
                $question->description=$row[$this->fields['description']];
                $question->explanation=$row[$this->fields['explanation']];
                $question->save();                
            }
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>in_array($row[$this->fields['iscorrect']]??"",['true',true,1,'Y','Yes','YES'])?true:false,
                "title"=>$row[$this->fields['answer']]
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
