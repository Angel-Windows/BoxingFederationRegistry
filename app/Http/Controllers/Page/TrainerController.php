<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;

use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;
use App\Repositories\Category\CategoryInstitutionsRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategorySportsInstitutionsRepository;
use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use App\Services\MyAuthService;
use App\Traits\FondyTrait;
use Illuminate\Http\Request;


class TrainerController extends Controller
{
    use FondyTrait;


    public function class_page($class_name, $id)
    {
        $get_data = $this->get_data($class_name, ['id' => $id, 'type' => 'preview']);

        return view('page.trainer')
            ->with('data_info', $get_data['table'])
            ->with('more_data', $get_data['more_data']);
    }

    public function get_data($class_name, $data = [])
    {
        switch ($class_name) {

            case 'category_fun_zones':
                $data_info = (new CategoryFunZonesRepository())->get_data($data);
                break;

            case 'category_sportsmen':
                $data_info = (new SportsmanFederationRepository())->get_data($data);
                break;




            case 'category_insurances':
                $data_info = (new CategoryInstitutionsRepository())->get_data($data, 'insurance');
                break;
            case 'category_medicals':
                $data_info = (new CategoryInstitutionsRepository())->get_data($data, 'medical');
                break;
            case 'category_schools':
                $data_info = (new CategoryInstitutionsRepository())->get_data($data, 'school');
                break;
            case 'category_sports_institutions':
                $data_info = (new CategorySportsInstitutionsRepository())->get_data($data);
                break;
            case 'category_judges':
                $data_info = (new CategoryJudgeRepository())->get_data($data);
                break;
            case 'box_federations':
                $data_info = (new CategoryFederationRepository())->get_data($data);
                break;
            case 'category_trainers':
                $data_info = (new CategoryTrainerRepository())->get_data($data);
                break;
            case 'category_stores':
                return response()->view('errors.404', [], 404);
            default :
                return response()->view('errors.404', [], 405);
        }
        return $data_info;
    }

    public function edit_page($class_name, $id, Request $request)
    {

        $get = $this->get_data($class_name, ['id' => $id, 'type' => 'edit_page']);

        if (!MyAuthService::CheckMiddlewareRoute($get['more_data'])) {
            return redirect()->route('page.class', [
                'class_name' => $class_name,
                'id' => $id
            ]);
        }
        return view('page.trainer_edit')
            ->with('get', $get)
            ->with('class_name', $class_name)
            ->with('id', $id);
    }

    public function edit($class_name, $id, Request $request)
    {
        if (!MyAuthService::CheckMiddleware('+380956686191')) {
            return redirect()->back();
        }
        switch ($class_name) {
            case 'box_federations':
                $result = (new CategoryFederationRepository())->edit($id, $request);
                break;
            case 'category_sportsmen':
                $result = (new SportsmanFederationRepository())->edit($id, $request);
                break;
            case 'category_trainers':
                $result = (new CategorySportsInstitutionsRepository())->edit($id, $request, 'edit');
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
            dd($result['error']);
        }

        $response_url = route('payment.fondy.response-url');
        $callback_url = route('payment.fondy.callback-url');
        $merchant_data = [
            'id' => $id,
            'type' => $class_name,
        ];
        $get_fondy_url = self::fondyBuy(1, $merchant_data, 'eliphas.sn@gmail.com', $response_url, $callback_url);

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
                $result = (new CategorySportsInstitutionsRepository())->edit($id, $request, $type);
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
