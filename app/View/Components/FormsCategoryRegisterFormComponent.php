<?php

namespace App\View\Components;


use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormsCategoryRegisterFormComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $route = 'edit', public $get = [], public $class = '', public $id = 0,  public $typesubmit='edit')
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.forms.category-register-form-component')
            ->with('table', $this->get['table'])
            ->with('more_data', $this->get['more_data'])
            ->with('category_name', $this->class)
            ->with('id', $this->id)
            ->with('type_submit', $this->typesubmit)
            ->with('route_type', $this->route);
    }
}
