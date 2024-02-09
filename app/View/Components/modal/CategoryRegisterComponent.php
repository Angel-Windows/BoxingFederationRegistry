<?php

namespace App\View\Components\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryRegisterComponent extends Component
{
    public function __construct(public $category_name,public $get_data = '')
    {
    }

    public function render(): View|Closure|string
    {

        return view('components.modal.category-register-component')
            ->with('class_name', $this->category_name)
            ->with('get', $this->get_data)
            ;
    }
}
