<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListItem extends Component
{
    public $item;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $placeholder = null)
    {
        $this->item = $item;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-item');
    }
}
