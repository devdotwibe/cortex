<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class AjaxImport extends Component
{
    public $fields=[];

    public $url;
    public $onupdate;
    /**
     * Create a new component instance.
     */
    public function __construct($url,$fields=[],$onupdate=null)
    {
        $this->fields=json_decode(json_encode($fields),false);
        $this->url=$url;
        $this->onupdate=$onupdate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $id=md5(Str::random(8)."-iD-aJx-".time());
        return view('components.ajax-import',compact('id'));
    }
}
