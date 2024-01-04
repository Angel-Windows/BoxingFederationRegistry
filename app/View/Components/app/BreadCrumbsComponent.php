<?php

namespace App\View\Components\app;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class BreadCrumbsComponent extends Component
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
        $current_name = Route::current()->getName();
        $page_name = str_replace('page.', '', $current_name);
        $arr_bread = [[
            'route' => 'page.home',
            'text' => 'Головна',
        ]
        ];
        switch ($page_name) {
            case 'trainer':
                $arr_bread[] = [
                    'route' => 'page.trainer',
                    'text' => 'Тренери',
                ];
                break;
            case '':
                break;
        }

        return view('components.app.bread-crumbs-component', compact('arr_bread'));
    }
}
