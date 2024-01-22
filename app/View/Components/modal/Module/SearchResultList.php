<?php

namespace App\View\Components\Modal\Module;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchResultList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.module.search-result-list');
    }
}
