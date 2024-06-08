<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Str;

class GeneralForm extends Component
{
    public $url;
    public $frmID;
 
    public $fields;
    public $btnsubmit;
    public $cancel;
 /**
     * Create a new component instance.
     */
    public function __construct($fields,$url,$cancel=null, $frmID=null,$btnsubmit=null)
    {
        $this->url = $url;
        $this->cancel = $cancel;
        $this->fields = json_decode(json_encode($fields),false); 
        $this->frmID = $frmID??"frm".Str::random(5).time(); 
        $this->btnsubmit = $btnsubmit??"Save";
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.general-form');
    }
}
