<?php

namespace App\Trait;

use App\Models\PrivateClass;
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
    protected static $withCondition=[];
    protected static $orderbycondition=[];
    protected static $orderbyrawcondition=[];
    protected static $whereHasCondition=[];

    protected static $whereInCondition=[];
    protected static $defaultActions=['view','edit','delete'];

    public static function reset(){

     $model=null;
     $routeName=null;
     $columns=[];

     $actions=[];
     $whereCondition=[];
     $withCondition=[];
     $orderbycondition=[];
     $orderbyrawcondition=[];
     $whereHasCondition=[];
     $whereInCondition=[];
    }
    public function addAction(callable $action){
        self::$actions[]=$action;
        return $this;
    }    
    public function where(...$condition){
        self::$whereCondition[]=$condition;
        return $this;
    }
    public function with(...$condition){
        self::$withCondition[]=$condition;
        return $this;
    }
    public function orderBy(...$condition){
        self::$orderbycondition[]=$condition;
        return $this;
    }
    public function orderByRaw(...$condition){
        self::$orderbyrawcondition[]=$condition;
        return $this;
    }
    public function whereHas(...$condition){
        self::$whereHasCondition[]=$condition;
        return $this;
    }
    public function whereIn(...$condition){
        self::$whereInCondition[]=$condition;
        return $this;
    }
    public function buildSelectOption($searchfield="name",$limit=12){
        $query=app(self::$model)->query();

        foreach(self::$withCondition as $condition){
            $query->where(...$condition);
        }
        foreach(self::$whereCondition as $condition){
            $query->where(...$condition);
        }
        foreach(self::$orderbycondition as $condition){
            $query->orderBy($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbyrawcondition as $condition){
            $query->orderByRaw($condition[0]??"",$condition[1]??null);
        }

        foreach(self::$whereInCondition as $condition){
            $query->whereIn(...$condition);
        }

        foreach(self::$whereHasCondition as $condition){
            if(count($condition)==1){
                $query->has($condition[0]);
            }else{
                $query->whereHas(...$condition);
            }
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
    public function buildPagination($limit=12)                                                                                                                                                                                                                                                                            {
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbycondition as $condition){
            $query->orderBy($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbyrawcondition as $condition){
            $query->orderByRaw($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$whereHasCondition as $condition){
            if(count($condition)==1){
                $query->has($condition[0]);
            }else{
                $query->whereHas(...$condition);
            }
        }
        return $query->paginate($limit);
    }
    public function buildResult($limit=12){
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbycondition as $condition){
            $query->orderBy($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbyrawcondition as $condition){
            $query->orderByRaw($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$whereHasCondition as $condition){
            if(count($condition)==1){
                $query->has($condition[0]);
            }else{
                $query->whereHas(...$condition);
            }
        }
        return $query->get();
    }
    public function buildTable($rawColumn=[]){
        $rawColumn[]="action";
        $rawColumn[]="selectbox";
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$whereHasCondition as $condition){
            if(count($condition)==1){
                $query->has($condition[0]);
            }else{
                $query->whereHas(...$condition);
            }
        }
        foreach(self::$orderbycondition as $condition){
            $query->orderBy($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbyrawcondition as $condition){
            $query->orderByRaw($condition[0]??"",$condition[1]??null);
        }
        
        $table=DataTables::of($query);
        $table->addColumn('selectbox',function($data){

            $privateclass =PrivateClass::where('user_id',$data->id)->first();
            $register_user ="";

            $inlinestyle ="";

            if(!empty($privateclass))
            {
                $register_user ="registered";

                $inlinestyle = "style='border-color: green !important;'";
            }

            return ' 

            <div class="form-check selectbox-box">
                <input type="checkbox"  class="selectbox form-check-box '.$register_user.'" '.$inlinestyle.' name="selectbox[]" value="'.($data->id).'" '.(request('select_all','no')=="yes"?"checked":"").'> 
            </div>
                
            ';
        })
        ->addColumn('date',function($data){
            return $data->created_at->format('Y-m-d');
        })
        ->addColumn('updated_at',function($data){
            return $data->updated_at->format('Y-m-d');
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
                                   <a href="' . route(self::$routeName . ".show", $data->slug??$data->id) . '" class="btn btn-icons eye-button">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/mdi_incognito.svg") . '" alt="View">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/view-yellow.svg") . '" alt="View Active" title="View">
                            </span>
                            </a>

                            ';
                            break;
                        case 'edit':
                                $action.='
                               <a href="' . route(self::$routeName . ".edit", $data->slug??$data->id) . '" class="btn btn-icons edit_btn">
                                    <span class="adminside-icon">
                                        <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                                    </span>
                                    <span class="adminactive-icon">
                                        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                                    </span>
                                </a>

                                ';
                            break;
                        case 'delete':
                                $action.='
                                <a class="btn btn-icons dlt_btn" data-delete="' . route(self::$routeName . ".destroy", $data->slug??$data->id) . '">
                                    <span class="adminside-icon">
                                        <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                                    </span>
                                    <span class="adminactive-icon">
                                        <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                                    </span>
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
        $query=app(self::$model)->query();
        foreach(self::$whereCondition as $condition){
            $query->where($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbycondition as $condition){
            $query->orderBy($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$orderbyrawcondition as $condition){
            $query->orderByRaw($condition[0]??"",$condition[1]??null);
        }
        foreach(self::$whereHasCondition as $condition){
            if(count($condition)==1){
                $query->has($condition[0]);
            }else{
                $query->whereHas(...$condition);
            }
        }
        return $query->count();
    }
    public function addColumn(string $name, callable|string $content){
        self::$columns[$name]=$content;
        return $this;
    }
}
