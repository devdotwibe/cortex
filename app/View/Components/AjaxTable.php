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
    public $popupid;
    public $ajaxcreate;
    public $createurl;
    public $fields;

    public $btnsubmit;
    public $cancel;
    public $onclick;
    public $beforeajax;

    public $bulkaction;
    public $bulkactionlink;
    public $tableinit;
    public $deletecallbackbefore;
    public $deletecallbackafter;
    public $action;
    public $bulkotheraction;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($coloumns,$url=null,$fields=null,$tableid=null,$popupid=null,$ajaxcreate=null,$createurl=null,$cancel=null,$btnsubmit=null,$onclick=null,$beforeajax=null,$bulkaction=false,$bulkactionlink=null,$tableinit=null,$deletecallbackbefore=null,$deletecallbackafter=null,$action=true,$bulkotheraction=null)
    {
        $this->coloumns = json_decode(json_encode($coloumns),false); 
        $this->url = $url??url()->current();
        $this->ajaxcreate = $ajaxcreate??false;
        $this->createurl = $createurl;
        $this->fields = json_decode(json_encode($fields),false); 
        $this->tableid = $tableid??"tb".Str::random(5).time();
        $this->popupid = $popupid??null;
        $this->btnsubmit = $btnsubmit??"Save";
        $this->cancel = $cancel;
        $this->onclick = $onclick;
        $this->beforeajax = $beforeajax;
        $this->bulkaction = $bulkaction;
        $this->bulkactionlink = $bulkactionlink;
        $this->tableinit = $tableinit;
        $this->deletecallbackbefore=$deletecallbackbefore;
        $this->deletecallbackafter=$deletecallbackafter;
        $this->action=$action;
        $this->bulkotheraction=$bulkotheraction;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ajax-table');
    }
}
