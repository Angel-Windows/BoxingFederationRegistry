<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;

use App\Models\Category\CategoryTrainer;
use App\Models\Category\Operations\TransactionCategory;
use App\Models\Class\ClassType;

use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;

use App\Repositories\Category\CategoryInsurancesRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategoryMedicalsRepository;
use App\Repositories\Category\CategorySchoolRepository;
use App\Repositories\Category\CategorySportsInstitutionsRepository;

use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use App\Repositories\Employees\EmployeesFederationRepository;
use App\Repositories\Employees\EmployeesInsurancesRepository;
use App\Repositories\Employees\EmployeesMedicalRepository;
use App\Repositories\Employees\EmployeesSchoolRepository;
use App\Repositories\Employees\EmployeesSportsInstitutionsRepository;
use App\Services\MyAuthService;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use App\Traits\FondyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\Concerns\Has;


class TrainerController extends Controller
{
    use FondyTrait;
    use DataTypeTrait;
    use CategoryUITrait;

    public function class_page($class_name, $id)
    {

        $get_data = $this->get_data($class_name, ['id' => $id, 'type' => 'preview']);
        return view('page.trainer')
            ->with('modeles', $get_data['modeles'])
            ->with('data_info', $get_data['table'])
            ->with('more_data', $get_data['more_data']);
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
            ->with('modeles', $class_name)
            ->with('id', $id);
    }

    public function register_category($class_name, $id, Request $request)
    {
        $result = $this->get_category('register_page', $class_name, null, $request);

        $response_url = route('payment.fondy.response-url');
        $callback_url = route('payment.fondy.callback-url');


        do {
            $key = \Str::random(32);
        } while (TransactionCategory::where('key', $key)->first());
        dd($result);
        $merchant_data = [
            'id' => $result['data']->id,
            'type' => $class_name,
            'key'=> $key
        ];

        $transaction = new TransactionCategory();
        $transaction->category_id = $merchant_data['id'];
        $transaction->key = $merchant_data['key'];
        $transaction->type = ClassType::getIdCategory($class_name);
        $transaction->send_transaction_at = Carbon::now();
        $transaction->save();


        $get_fondy_url = self::fondyBuy(1, $merchant_data, 'eliphas.sn@gmail.com', $response_url, $callback_url);

        $route = json_decode($get_fondy_url->content(), false, 512, JSON_THROW_ON_ERROR)->paymentUrl->checkout_url;

        return redirect($route);
    }

    public function edit($class_name, $id, Request $request)
    {
        $get_data = $this->get_data($class_name, ['id' => $id, 'type' => 'edit'], $request);

        return response()->json(
            [
                'data' => '',
                'alert_type' => 'success',
                'alert' => 'Успішно збережено',
//                'log' => 222,
            ]
        );

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
                $result = (new CategoryInsurancesRepository())->edit($id, $request, $type);
                break;
            case 'category_sports_institutions':
                $result = (new CategorySportsInstitutionsRepository())->edit($id, $request, $type);
                break;
            case 'category_medicals':
                $result = (new CategoryMedicalsRepository())->edit($id, $request, $type);
                break;
            case 'category_schools':
                $result = (new CategorySchoolRepository())->edit($id, $request, $type);
                break;
            case 'category_stores':
                return response()->view('errors.505', [], 404);



            case 'employees_school':
                $result = (new EmployeesSchoolRepository())->edit($id, $request, $type);
                break;
            case 'employees_medical':
                $result = (new EmployeesMedicalRepository())->edit($id, $request, $type);
                break;
            case 'employees_federation':
                $result = (new EmployeesFederationRepository())->edit($id, $request, $type);
                break;
            case 'employees_sports_institution':
                $result = (new EmployeesSportsInstitutionsRepository())->edit($id, $request, $type);
                break;
            case 'employees_insurances':
                $result = (new EmployeesInsurancesRepository())->edit($id, $request, $type);
                break;
            default :
                return response()->view('errors.404', [], 404);
        }
        return $result;
    }
}
