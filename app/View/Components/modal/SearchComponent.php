<?php

namespace App\View\Components\modal;

use App\Models\Class\ClassType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $class_types = '', public $appeal = '')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $class_types = ClassType::where('id', $this->class_types)->first();
        return view('components.modal.search-component')
            ->with('class_types', $class_types);
    }
}
