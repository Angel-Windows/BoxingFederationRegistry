<?php

namespace App\View\Components;

use App\Traits\DataTypeTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalAddFormItemComponent extends Component
{
    use DataTypeTrait;
    /**
     * Create a new component instance.
     */
    public function __construct(public $request)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = $this->data_option;
        return view('components.modal.add-form-item-component')
            ->with('request', $this->request)
            ->with('data', $data);
    }
}
