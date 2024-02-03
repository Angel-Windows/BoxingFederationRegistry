<?php

namespace App\View\Components\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalNofFoundComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $modal_name = '')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.modal-nof-found-component')
            ->with('modal_name', $this->modal_name);
    }
}
