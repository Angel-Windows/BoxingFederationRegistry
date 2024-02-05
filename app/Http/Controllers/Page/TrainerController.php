<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;

use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;
use App\Repositories\Category\CategoryInstitutionsRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use App\Traits\FondyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TrainerController extends Controller
{
    use FondyTrait;

    public function class_page($class_name, $id, Request $request)
    {
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

    public function edit_page($class_name, $id, Request $request)
    {
//        switch ($class_name) {
//            case 'box_federations':
//                $data_info = (new CategoryFederationRepository())->edit_page($id);
//                break;
//            case 'category_sportsmen':
//                $data_info = (new SportsmanFederationRepository())->edit_page($id);
//                break;
//            case 'category_trainers':
//                $data_info = (new CategoryTrainerRepository())->edit_page($id);
//                break;
//            case 'category_judges':
//                $data_info = (new CategoryJudgeRepository())->edit_page($id);
//                break;
//            case 'category_insurances':
//                $data_info = (new CategoryInstitutionsRepository())->edit_page($id, 'insurance');
//                break;
//            case 'category_medicals':
//                $data_info = (new CategoryInstitutionsRepository())->edit_page($id, 'medical');
//                break;
//            case 'category_schools':
//                $data_info = (new CategoryInstitutionsRepository())->edit_page($id, 'school');
//                break;
//            case 'category_fun_zones':
//                $data_info = (new CategoryFunZonesRepository())->edit_page($id);
//                break;
//            case 'category_stores':
//                return response()->view('errors.505', [], 404);
//            default :
//                return response()->view('errors.404', [], 404);
//        }
        return view('page.trainer_edit')
            ->with('class_name', $class_name)
            ->with('id', $id);
    }

    public function edit($class_name, $id, Request $request)
    {
        switch ($class_name) {
            case 'box_federations':
                $result = (new CategoryFederationRepository())->edit($id, $request);
                break;
            case 'category_sportsmen':
                $result = (new SportsmanFederationRepository())->edit($id, $request);
                break;
            case 'category_trainers':
                $result = (new CategoryTrainerRepository())->edit($id, $request, 'edit');
                break;
            case 'category_judges':
                $result = (new CategoryJudgeRepository())->edit($id, $request);
                break;
            case 'category_insurances':
                $result = (new CategoryInstitutionsRepository())->edit_page($id, 'insurance');
                break;
            case 'category_medicals':
                $result = (new CategoryInstitutionsRepository())->edit_page($id, 'medical');
                break;
            case 'category_schools':
                $result = (new CategoryInstitutionsRepository())->edit_page($id, 'school');
                break;
            case 'category_fun_zones':
                $result = (new CategoryFunZonesRepository())->edit($id, $request);
                break;
            case 'category_stores':
                return response()->view('errors.505', [], 404);
            default :
                return response()->view('errors.404', [], 404);
        }
        dump($request->file('photo'));
//        return redirect()->back();
    }

    public function register_category($class_name, $id, Request $request)
    {
        $result = $this->get_category('register', $class_name, $id, $request);
        if ($result['error']) {
            return false;
        }
        $response_url = route('payment.fondy.response-url');
        $callback_url = route('payment.fondy.callback-url');
        $merchant_data = [
            'id' => $id,
            'type' => $class_name,
        ];
        $get_fondy_url = self::fondyBuy(1,$merchant_data, 'eliphas.sn@gmail.com', $response_url, $callback_url);

        $route = json_decode($get_fondy_url->content(), false, 512, JSON_THROW_ON_ERROR)->paymentUrl->checkout_url;
        return redirect($route);

    }

    public function get_category($type, $class_name, $id, $request)
    {
        switch ($class_name) {
            case 'box_federations':
                $result = (new CategoryFederationRepository())->edit($id, $request, $type);
                break;
            case 'category_sportsmen':
                $result = (new SportsmanFederationRepository())->edit($id, $request, $type);
                break;
            case 'category_trainers':
                $result = (new CategoryTrainerRepository())->edit($id, $request, $type);
                break;
            case 'category_judges':
                $result = (new CategoryJudgeRepository())->edit($id, $request, $type);
                break;

            case 'category_fun_zones':
                $result = (new CategoryFunZonesRepository())->edit($id, $request, $type);
                break;
            case 'category_insurances':
                $result = (new CategoryInstitutionsRepository())->edit_page($id, 'insurance');
                break;
            case 'category_medicals':
                $result = (new CategoryInstitutionsRepository())->edit_page($id, 'medical');
                break;
            case 'category_schools':
                $result = (new CategoryInstitutionsRepository())->edit_page($id, 'school');
                break;
            case 'category_stores':
                return response()->view('errors.505', [], 404);
            default :
                return response()->view('errors.404', [], 404);
        }
        return $result;
    }
}
