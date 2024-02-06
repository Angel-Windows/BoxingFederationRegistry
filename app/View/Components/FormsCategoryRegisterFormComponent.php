<?php

namespace App\View\Components;

use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;
use App\Repositories\Category\CategoryInstitutionsRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormsCategoryRegisterFormComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $route = 'edit', public $get = [])
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
            ->with('route_type', $this->route);
    }
}
