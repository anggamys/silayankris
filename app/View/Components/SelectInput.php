<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public $id;
    public $label;
    public $name;
    public $options;
    public $placeholder;
    public $disabled;
    public $dropdownClass;
    public $buttonClass;
    public $ulClass;
    public $selected;
    public $searchable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $id,
        $label,
        $name,
        $options = [],
        $placeholder = null,
        $disabled = false,
        $dropdownClass = '',
        $buttonClass = '',
        $ulClass = '',
        $selected = null,
        $searchable = true,
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->disabled = $disabled;
        $this->dropdownClass = $dropdownClass;
        $this->buttonClass = $buttonClass;
        $this->ulClass = $ulClass;
        $this->selected = $selected;
        $this->searchable = $searchable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-input');
    }
}
