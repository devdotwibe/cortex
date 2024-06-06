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

        
    public function buildTable($rawColumn=[]){
        $table=DataTables::of(app(self::$model)->query());
        foreach (self::$columns as $key => $value) {
            $table->addColumn($key ,$value);
        }
        if(auth("admin")->check()){
            $table->addColumn('action',function($data){
                return '
                <div>
                    <a href="'.route(self::$routeName.".show",$data->slug).'" class="btn btn-icons view_btn">
                        <img src="'.asset("assets/images/view.svg").'" alt="">
                    </a>
                    <a href="'.route(self::$routeName.".edit",$data->slug).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    <a  class="btn btn-icons dlt_btn">
                        <img src="'.asset("assets/images/delete.svg").'" alt="">
                    </a>
                </div>
                
                ';
            });
        }
        return $table->rawColumns($rawColumn)->addIndexColumn()->make(true);
    }
    public function addColumn(string $name, callable|string $content){
        self::$columns[$name]=$content;
        return $this;
    }


    public function create($fields=[]){ 
        $fields['slug']=md5(Str::random(16).time());
        return  app(self::$model)->create($fields);
    }
    public function update($fields=[],$id){  
        return  app(self::$model)->where('id',$id)->update($fields);
    }

}
