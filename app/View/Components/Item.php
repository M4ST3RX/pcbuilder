<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Item extends Component
{
    public $item;
    public $slotId;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $slotId, $placeholder = null)
    {
        $this->item = $item;
        $this->slotId = $slotId;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item');
    }
}
