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
    public function addAction(callable $action){
        self::$actions[]=$action;
        return $this;
    }
    public function buildTable($rawColumn=[]){
        $table=DataTables::of(app(self::$model)->query());
        $table->addColumn('date',function($data){
            return $data->created_at->format('Y-m-d');
        });
        foreach (self::$columns as $key => $value) {
            $table->addColumn($key ,$value);
        }
        if(auth("admin")->check()){
            $table->addColumn('action',function($data){
                $action="";
                foreach (self::$actions as $callable) {
                  $action.=($callable($data)??"");
                }
                return  '
                <div>
                    '.$action.'
                    <a href="'.route(self::$routeName.".show",$data->slug).'" class="btn btn-icons view_btn">
                        <img src="'.asset("assets/images/view.svg").'" alt="">
                    </a>
                    <a href="'.route(self::$routeName.".edit",$data->slug).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    <a  class="btn btn-icons dlt_btn" onclick="deleteRecord('."'".route(self::$routeName.".destroy",$data->slug)."'".')">
                        <img src="'.asset("assets/images/delete.svg").'" alt="">
                    </a> 
                </div>
                
                ';
            });
        }
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
