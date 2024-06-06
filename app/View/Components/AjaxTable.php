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
    public $tableID;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($coloumns,$url=null,$tableID=null)
    {
        $this->coloumns = json_decode(json_encode($coloumns),false); 
        $this->url = $url??url()->current();
        $this->tableID = $tableID??"tb".Str::random(5).time();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ajax-table');
    }
}
