<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

trait ResourceController
{
    /** 
     *
     * @var Model
     */
    protected static $model;
    protected static $routeName;
    protected static $columns=[];

    protected static $actions=[];
    protected static $whereCondition=[];
    protected static $defaultActions=['view','edit','delete'];

    public static function reset(){

     $model=null;
     $routeName=null;
     $columns=[];

     $actions=[];
     $whereCondition=[];
    }
    public function addAction(callable $action){
        self::$actions[]=$action;
        return $this;
    }    
    public function where(...$condition){
        self::$whereCondition[]=$condition;
        return $this;
    }
    public function buildSelectOption($searchfield="name",$limit=12){
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where(...$condition);
        }
        if(!empty(request("term"))){
            $query->where($searchfield,'like',"%".(request("term"))."%");
        }
        $paginate=$query->paginate($limit);
        $result=[];
        foreach ($paginate->items() as $row) {
            $result[]=[
                "id"=>$row->id,
                "text"=>$row->$searchfield
            ];
        }
        return [
            "results"=>$result,
            "pagination"=>[
                "more"=>$paginate->hasMorePages()
            ]
        ];
    }
    public function buildPagination($limit=12){
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        return $query->paginate($limit);
    }
    public function buildResult($limit=12){
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        return $query->get();
    }
    public function buildTable($rawColumn=[]){
        $rawColumn[]="action";
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        $table=DataTables::of($query);
        $table->addColumn('date',function($data){
            return $data->created_at->format('Y-m-d');
        });
        foreach (self::$columns as $key => $value) {
            $table->addColumn($key ,$value);
        }
        // if(auth("admin")->check()){
            $table->addColumn('action',function($data){
                $action="";
                foreach (self::$actions as $callable) {
                  $action.=($callable($data)??"");
                }
                foreach (self::$defaultActions as $act) {
                    switch ($act) {
                        case 'view':
                            $action.='                            
                                    <a href="'.route(self::$routeName.".show",$data->slug).'" class="btn btn-icons view_btn">
                                        <img src="'.asset("assets/images/view.svg").'" alt="">
                                    </a>
                            ';
                            break;
                        case 'edit':
                                $action.='
                                <a href="'.route(self::$routeName.".edit",$data->slug).'" class="btn btn-icons edit_btn">
                                    <img src="'.asset("assets/images/edit.svg").'" alt="">
                                </a>
                                ';
                            break;
                        case 'delete':
                                $action.='
                                 <a  class="btn btn-icons dlt_btn" onclick="deleteRecord('."'".route(self::$routeName.".destroy",$data->slug)."'".')">
                                    <img src="'.asset("assets/images/delete.svg").'" alt="">
                                </a> 
                                ';
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }
                return  '
                <div>
                    '.$action.' 
                </div>
                
                ';
            });
        // }
        return $table->rawColumns($rawColumn)->addIndexColumn()->make(true);
    }
    public function totalCount(){
        return app(self::$model)->count();
    }
    public function addColumn(string $name, callable|string $content){
        self::$columns[$name]=$content;
        return $this;
    }
}
