<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class AjaxTable extends Component
{
    public $coloumns;
    public $url;
    public $tableid;
    public $ajaxcreate;
    public $createurl;
    public $fields;

    public $btnsubmit;
    public $cancel;
    public $onclick;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($coloumns,$url=null,$fields=null,$tableid=null,$ajaxcreate=null,$createurl=null,$cancel=null,$btnsubmit=null,$onclick=null)
    {
        $this->coloumns = json_decode(json_encode($coloumns),false); 
        $this->url = $url??url()->current();
        $this->ajaxcreate = $ajaxcreate??false;
        $this->createurl = $createurl;
        $this->fields = json_decode(json_encode($fields),false); 
        $this->tableid = $tableid??"tb".Str::random(5).time();
        $this->btnsubmit = $btnsubmit??"Save";
        $this->cancel = $cancel;
        $this->onclick = $onclick;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ajax-table');
    }
}
