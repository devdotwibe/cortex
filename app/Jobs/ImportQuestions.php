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
use Illuminate\Support\Facades\Log;
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
        OptionHelper::setData("{$this->exam->name}-import-question-{$this->exam->slug}",'started');
        OptionHelper::setData("{$this->exam->name}-import-question-status-{$this->exam->slug}",'progress');
        $datalist=Storage::json("importfile/{$this->filename}")??[];
      
        $count=count($datalist);
        Log::info('Count:'.$count);
        foreach ($datalist as $i => $row) {
            if(OptionHelper::getData("{$this->exam->name}-import-question-{$this->exam->slug}","stop")=="stop"){
                break;
            }
            $row=$datalist[$i];
            if($this->exam->name=="full-mock-exam"){
                $category = Category::firstOrCreate(
                    ['name' => $row[$this->fields['category']]],
               
                );
                $category_id = $category->id;

                $question_count = Question::where('exam_id', $this->exam->id)->count();
                
                if(!empty($question_count))
                {
                    $order = $question_count+1; 
                }
                else
                {
                    $order = 1; 
                }

                $question=Question::store([
                    "order_no"=>$order,
                    "exam_id"=>$this->exam->id,
                    "category_id"=>$category_id,
                    "sub_category_id"=>optional($this->subCategory)->id,
                    "sub_category_set"=>optional($this->setname)->id,
                    "description"=>nl2br($row[$this->fields['description']]),
                    "title_text" => (isset($this->fields['title_text']) && isset($row[$this->fields['title_text']])) ? '<p>' . nl2br($row[$this->fields['title_text']]) . '</p>' : null,
                    "sub_question" => (isset($this->fields['sub_question']) && isset($row[$this->fields['sub_question']])) ? '<p>' . nl2br($row[$this->fields['sub_question']]) . '</p>' : null,
                    "explanation" => (isset($this->fields['explanation']) && isset($row[$this->fields['explanation']])) ? '<p>' . nl2br($row[$this->fields['explanation']]) . '</p>': null,
                ]);
            }
            else if($this->exam->name=="question-bank"){

                $question_count = Question::where('category_id',optional($this->category)->id)
                ->where('sub_category_id',optional($this->subCategory)->id)
                ->where('sub_category_set',optional($this->setname)->id)
                ->where('exam_id', $this->exam->id)->count();
                
                if(!empty($question_count))
                {
                    $order = $question_count+1; 
                }
                else
                {
                    $order = 1; 
                }

                $question=Question::store([
                    "order_no"=>$order,
                    "exam_id"=>$this->exam->id,
                    "category_id"=>optional($this->category)->id,
                    "sub_category_id"=>optional($this->subCategory)->id,
                    "sub_category_set"=>optional($this->setname)->id,
                    "description"=>nl2br($row[$this->fields['description']]),
                    "explanation" => (isset($this->fields['explanation']) && isset($row[$this->fields['explanation']])) ? '<p>' . nl2br($row[$this->fields['explanation']]) . '</p>'  : null,
                    "title_text" => (isset($this->fields['title_text']) && isset($row[$this->fields['title_text']])) ? '<p>' . nl2br($row[$this->fields['title_text']]) . '</p>'  : null,
                    "sub_question" => (isset($this->fields['sub_question']) && isset($row[$this->fields['sub_question']])) ? '<p>' . nl2br($row[$this->fields['sub_question']]) . '</p>'  : null,
                ]);

            }
             else{

                $question_count = Question::where('category_id',optional($this->category)->id)
                ->where('exam_id', $this->exam->id)->count();
                
                if(!empty($question_count))
                {
                    $order = $question_count+1; 
                }
                else
                {
                    $order = 1; 
                }

                $question=Question::store([
                    "order_no"=>$order,
                    "exam_id"=>$this->exam->id,
                    "category_id"=>optional($this->category)->id,
                    "sub_category_id"=>optional($this->subCategory)->id,
                    "sub_category_set"=>optional($this->setname)->id,
                    "description"=>nl2br($row[$this->fields['description']]),
                    "explanation" => (isset($this->fields['explanation']) && isset($row[$this->fields['explanation']])) ? '<p>' . nl2br($row[$this->fields['explanation']]) . '</p>' : null,
                    "title_text" => (isset($this->fields['title_text']) && isset($row[$this->fields['title_text']])) ? '<p>' . nl2br($row[$this->fields['title_text']]) . '</p>' : null,
                    "sub_question" => (isset($this->fields['sub_question']) && isset($row[$this->fields['sub_question']])) ? '<p>' . nl2br($row[$this->fields['sub_question']]) . '</p>' : null,
                ]);
            }
            if(isset($this->fields['answer_1']) && isset($row[$this->fields['answer_1']]))
            {     
                Answer::store([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="A"?true:false,
                    "title"=>$row[$this->fields['answer_1']],
                ]);
            }
            if(isset($this->fields['answer_2']) && isset($row[$this->fields['answer_2']]))
            { 
                Answer::store([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="B"?true:false,
                    "title"=>$row[$this->fields['answer_2']],
                ]);
            }
            if(isset($this->fields['answer_3']) && isset($row[$this->fields['answer_3']]))
            { 
                Answer::store([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="C"?true:false,
                    "title" => (isset($this->fields['answer_3']) && isset($row[$this->fields['answer_3']])) ? $row[$this->fields['answer_3']] : null,
                ]);
            }
            if(isset($this->fields['answer_4']) && isset($row[$this->fields['answer_4']]))
            { 
                Answer::store([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>($row[$this->fields['iscorrect']]??"")=="D"?true:false,
                    "title" => (isset($this->fields['answer_4']) && isset($row[$this->fields['answer_4']])) ? $row[$this->fields['answer_4']] : null,
                ]);
            }
            $i++;
            OptionHelper::setData("{$this->exam->name}-import-question-completed-{$this->exam->slug}",round($i*100/$count,2));
        }
        OptionHelper::setData("{$this->exam->name}-import-question-{$this->exam->slug}",'end');
        sleep(1);
        Storage::delete("importfile/{$this->filename}");
        OptionHelper::setData("{$this->exam->name}-import-question-{$this->exam->slug}",null);
        OptionHelper::setData("{$this->exam->name}-import-question-status-{$this->exam->slug}",null);
        OptionHelper::setData("{$this->exam->name}-import-question-completed-{$this->exam->slug}",null);
    } 

}


