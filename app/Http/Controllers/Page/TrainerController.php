<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;

use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;
use App\Repositories\Category\CategoryInstitutionsRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use Illuminate\Http\Request;


class TrainerController extends Controller
{
    public function edit_page(): array
    {

    }

    public function class_page($class_name, $id, Request $request)
    {
        if ($request->has('edit')) {
            $temp__info_list = $this->edit_page();
            return view('page.trainer_edit', compact('temp__info_list'));
        }
        switch ($class_name) {
            case 'box_federations':
                $data_info = (new CategoryFederationRepository())->index($id);
                break;
            case 'category_sportsmen':
                $data_info = (new SportsmanFederationRepository())->index($id);
                break;
            case 'category_trainers':
                $data_info = (new CategoryTrainerRepository())->index($id);
                break;
            case 'category_judges':
                $data_info = (new CategoryJudgeRepository())->index($id);
                break;
            case 'category_insurances':
                $data_info = (new CategoryInstitutionsRepository())->index($id, 'insurance');
                break;
            case 'category_medicals':
                $data_info = (new CategoryInstitutionsRepository())->index($id, 'medical');
                break;
            case 'category_schools':
                $data_info = (new CategoryInstitutionsRepository())->index($id, 'school');
                break;
            case 'category_fun_zones':
                $data_info = (new CategoryFunZonesRepository())->index($id);
                break;
            case 'category_stores':
                return response()->view('errors.404', [], 404);
                break;
            default :
                return response()->view('errors.404', [], 404);
        }

        return view('page.trainer')
            ->with('data_info', $data_info);
    }
}
