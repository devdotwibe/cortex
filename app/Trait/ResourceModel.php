<?php

namespace App\Trait;
use Illuminate\Support\Str;

trait ResourceModel
{
    public static function store($fields=[]){ 
        $fields['slug']=md5(Str::random(16).time());
        return  parent::create($fields);
    }
    public static function edit($fields=[],$id){  
        return  self::where('id',$id)->update($fields);
    }

    public function getRouteKeyName(){
        return 'slug';
    } 

}
