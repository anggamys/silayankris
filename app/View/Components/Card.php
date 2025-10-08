<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public $class;
    public $header;
    public $description;
    public $footer;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->class = $class ?? null;
        $this->header = $header ?? null;
        $this->footer = $footer ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.card');
    }
}
