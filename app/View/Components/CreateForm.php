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
    /**
     * Create a new component instance.
     */
    public function __construct($name,$fields,$frmID=null,$btnsubmit=null)
    {
        $this->name = $name;
        $this->fields = json_decode(json_encode($fields),false); 
        $this->frmID = $frmID??"frm".Str::random(5).time(); 
        $this->btnsubmit = $btnsubmit??"Save";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.create-form');
    }
}
