<?php

namespace App\View\Components\Modal\Module;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchResultListComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $data, public $class_type)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.module.search-result-list-component')
            ->with('data', $this->data)
            ->with('class_type', $this->class_type)
            ;
    }
}
