<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Str;

class ModalForm extends Component
{
    public $url;
    public $frmID;
 
    public $fields;
    public $btnsubmit;
    public $cancel;
    public $onclick;
    /**
     * Create a new component instance.
     */
    public function __construct($fields,$url,$cancel=null, $frmID=null,$btnsubmit=null,$onclick=null)
    {
        $this->url = $url;
        $this->cancel = $cancel;
        $this->onclick = $onclick;
        $this->fields = json_decode(json_encode($fields),false); 
        $this->frmID = $frmID??"frm".Str::random(5).time(); 
        $this->btnsubmit = $btnsubmit??"Save";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-form');
    }
}
