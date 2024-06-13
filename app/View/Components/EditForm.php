<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class EditForm extends Component
{
    public $id;
    public $frmID;
    public $name;
    public $params;

 
    public $fields;
    public $btnsubmit;
    public $cancel;
    /**
     * Create a new component instance.
     */
    public function __construct($name,$fields,$id, $params=null,$frmID=null,$btnsubmit=null,$cancel=null)
    {
        $this->id = $id;
        $this->name = $name; 
        $this->fields = json_decode(json_encode($fields),false); 
        $this->frmID = $frmID??"frm".Str::random(5).time(); 
        $this->btnsubmit = $btnsubmit??"Save";
        $this->cancel = $cancel; 
        $this->params=$params??[];
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-form');
    }
}
