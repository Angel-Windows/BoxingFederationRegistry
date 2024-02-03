<?php

namespace App\View\Components\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryRegisterComponent extends Component
{
    public function __construct(public $category = '')
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.modal.category-register-component')
            ->with('category', $this->category);
    }
}
