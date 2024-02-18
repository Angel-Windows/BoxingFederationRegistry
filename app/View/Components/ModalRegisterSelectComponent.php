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
                'employees_insurances'=>'Реєстрація працівника',
                'category_insurances'=>'Реєстрація компанії',
            ],

            'category_sports_institutions'=>[
                'employees_sports_institution'=>'Реєстрація працівника',
                'category_sports_institutions'=>'Реєстрація закладу',
            ],


            'category_medicals'=>[
                'employees_medical'=>'Реєстрація працівника',
                'category_medicals'=>'Реєстрація закладу',

            ],
            'category_schools'=>[
                'employees_school'=>'Реєстрація працівника',
                'category_schools'=>'Реєстрація закладу',

            ],
            'category_sportsmen'=>[
                'category_sportsmen'=>'Реєстрація спортсмена',
            ],
            'category_trainers'=>[
                'category_trainers'=>'Реєстрація тренера',
            ],
            'category_judges'=>[
                'category_judges'=>'Реєстрація судді',
            ],
            'category_fun_zones'=>[
                'category_fun_zones'=>'Реєстрація ФанЗони',
            ],
        ];
        return view('components.modal-register-select-component')
            ->with('category_name', $this->category_name)
            ->with('buttons', $buttons[$this->category_name])
            ;
    }
}
