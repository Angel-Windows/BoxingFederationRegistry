<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalRegisterSelectComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $category_name)
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $buttons = [
            'box_federations'=>[
                'employees_federation'=>'Реєстрація працівника',
                'box_federations'=>'Реєстрація федерації',
            ],
            'category_insurances'=>[
                'category_insurances_member'=>'Реєстрація працівника',
                'category_insurances'=>'Реєстрація компанії',

            ],
            'category_medicals'=>[
                'category_medicals_member'=>'Реєстрація працівника',
                'category_medicals'=>'Реєстрація закладу',

            ],
            'category_sports_institutions'=>[
                'category_sports_institutions_member'=>'Реєстрація працівника',
                'category_sports_institutions'=>'Реєстрація закладу',

            ],
            'category_schools'=>[
                'category_schools_member'=>'Реєстрація працівника',
                'category_schools'=>'Реєстрація закладу',

            ],
        ];
        return view('components.modal-register-select-component')
            ->with('category_name', $this->category_name)
            ->with('buttons', $buttons[$this->category_name])
            ;
    }
}
