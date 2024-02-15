<?php

namespace App\View\Components;

use App\Models\Class\ClassType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppHeaderComponent extends Component
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
        $card_data = ClassType::whereIsset('description');
        return view('components.app.header-component', compact('card_data'));
    }
}
