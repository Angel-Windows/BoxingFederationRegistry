<?php

namespace App\View\Components;

use App\Models\Class\ClassType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class AppBreadCrumbsComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $page_name = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $page_name = Route::current()->parameters()['class_name'] ?? "";

//        dd(Route::current()->parameters()['class_name']);
        $arr_bread = [[
            'route' => 'page.home',
            'text' => 'Головна',
        ]
        ];
        if ($page_name) {
            $get_data = ClassType::getFind('link', $page_name)
                ?? ClassType::getFind('link', substr($page_name,0,-1))
                ?? ClassType::getFind('link', $page_name . 's')
            ;
            $arr_bread[] = [
                'route' => 'page.home',
                'text' => $get_data->name ?? '',
            ];
            switch ($page_name) {
                case 'trainer':
                    $arr_bread[] = [
                        'route' => 'page.home',
                        'text' => 'Тренери',
                    ];
                    break;
                case 'insurance-companies':
                    $arr_bread[] = [
                        'route' => 'page.home',
                        'text' => 'Страхові компанії',
                    ];
                    break;
                case '':
                    break;

            }

            return view('components.app.bread-crumbs-component', compact('arr_bread'));
        }
        return view('components.app.bread-crumbs-component', compact('arr_bread'));
    }
}
