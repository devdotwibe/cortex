<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class CreateForm extends Component
{

    public $frmID;
    public $name;

    public $fields;
    public $btnsubmit;
    public $params;
    public $cancel;
    /**
     * Create a new component instance.
     */
    public function __construct($name,$fields,$params=null,$frmID=null,$btnsubmit=null,$cancel=null)
    {
        $this->name = $name;
        $this->fields = json_decode(json_encode($fields),false); 
        $this->frmID = $frmID??"frm".Str::random(5).time(); 
        $this->btnsubmit = $btnsubmit??"Save";
        $this->params=$params??[];
        $this->cancel = $cancel; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.create-form');
    }
}
