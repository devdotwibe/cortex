<?php

namespace App\Trait;
 
use Illuminate\Support\Str;

trait ResourceModel
{
    protected $formFields=[];

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|$this
     */
    public static function store($fields=[]){ 
        $fields['slug']=md5(Str::random(16).time()); 
        return  parent::create($fields);
    }
    public static function edit($fields=[],$id){  
        return  self::where('id',$id)->update($fields);
    }
    public static function findSlug($slug){
        return self::where("slug",$slug)->first();
    }
    public function getRouteKeyName(){
        return 'slug';
    } 
    public function getIdx(){
        return self::where('id', '<', $this->id)->count();
    } 
    // public function getKeyName(){
    //     return 'slug';
    // } 
    // public function getFields(){
    //     static::getFormFields();
    // }
    // public static function getFormFields(){
    //     $fields=[];
    //     foreach(parent::newInstance()->fillable as $f){
    //         if(!in_array($f,['slug','id','created_at','updated_at'])){
    //             if(empty(self::$formFields[$f])){
    //                 $fields[$f]= ["name"=>$f,"size"=>4,"value"=>parent::$$f??""];
    //             }else{
    //                 $fields[$f]=self::$formFields[$f];
    //             }
    //         }
    //     }
    //     return $fields;
    // }

}
