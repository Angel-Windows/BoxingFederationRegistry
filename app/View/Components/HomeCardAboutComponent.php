<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeCardAboutComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $data)
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.card-about-component')
            ->with('card_data', $this->data);
    }
}
