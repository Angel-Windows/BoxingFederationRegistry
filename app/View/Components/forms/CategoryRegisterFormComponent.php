<?php

namespace App\View\Components\forms;

use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;
use App\Repositories\Category\CategoryInstitutionsRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryRegisterFormComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $class = '', public $id = 0, public $route = 'edit')
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $id = $this->id;
        switch ($this->class) {
            case 'box_federations':
                $data_info = (new CategoryFederationRepository())->edit_page($id);
                break;
            case 'category_sportsmen':
                $data_info = (new SportsmanFederationRepository())->edit_page($id);
                break;
            case 'category_trainers':
                $data_info = (new CategoryTrainerRepository())->edit_page($id);
                break;
            case 'category_judges':
                $data_info = (new CategoryJudgeRepository())->edit_page($id);
                break;
            case 'category_insurances':
                $data_info = (new CategoryInstitutionsRepository())->edit_page($id, 'insurance');
                break;
            case 'category_medicals':
                $data_info = (new CategoryInstitutionsRepository())->edit_page($id, 'medical');
                break;
            case 'category_schools':
                $data_info = (new CategoryInstitutionsRepository())->edit_page($id, 'school');
                break;
            case 'category_fun_zones':
                $data_info = (new CategoryFunZonesRepository())->edit_page($id);
                break;
            case 'category_stores':
                return response()->view('errors.506', [], 404);
            default :
                return response()->view('errors.506', [], 405);
        }
        return view('components.forms.category-register-form-component')
            ->with('route_type', $this->route)
            ->with('temp__info_list', $data_info);
    }
}
