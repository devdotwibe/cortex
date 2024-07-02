<?php

namespace App\Support\Helpers;

use App\Models\SiteOption;

class OptionHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getData($key,$default=null){
        $option=SiteOption::where('keyname',$key)->first();
        if(!empty($option)){
            return $option->keyvalue;
        }
        return $default;
    }

    public static function setData($key,$value){
        $option=SiteOption::where('keyname',$key)->first();
        if(!empty($option)){
            $option->keyvalue=$value;
            $option->save();
        }else{
            $option=new SiteOption;
            $option->keyname=$key;
            $option->keyvalue=$value;
            $option->save();
        } 
    }

    public static function deleteData($key){
        return SiteOption::where('keyname',$key)->delete();
    }
}
