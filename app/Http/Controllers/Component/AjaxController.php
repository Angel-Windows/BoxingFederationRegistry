<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use App\View\Components\form\OptionListComponent;
use App\View\Components\modal\CategoryRegisterComponent;
use App\View\Components\modal\CheckCodeComponent;
use App\View\Components\modal\ModalNofFoundComponent;
use App\View\Components\modal\RegisterComponent;
use App\View\Components\modal\SearchComponent;
use App\View\Components\modal\SuccessRegisterComponent;
use App\View\Components\ModalAddFormItemComponent;
use App\View\Components\ModalModuleSearchResultListComponent;
use App\View\Components\ModalRegisterSelectComponent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use function Termwind\render;

class AjaxController extends Controller
{
    use CategoryUITrait;

    private function get_arr_federation($trainer_id)
    {
        $linking_trainer = CategoryTrainer::find($trainer_id);
        if (!$linking_trainer) return [];
        $arr_federation = [];

        $old_id = $linking_trainer ? $linking_trainer->federation : null;

        if ($old_id) {
            $arr_federation[$old_id] = $old_id;
        }
        $max = 0;
        $linking_federation = null;
        while ($max < BoxFederation::count() - 1) {
            $linking_federation = BoxFederation::where('id', $old_id)
                ->whereNotIn('id', $arr_federation)
                ->first();

            if ($linking_federation) {
                $old_id = $linking_federation->federation;
                $arr_federation[$old_id] = $old_id;
            } else {
                break;
            }

            $max++;
        }


        return $arr_federation;

    }

    public function open_modal(Request $request)
    {
        if ($request->has('modal')) {
            switch ($request->input('modal')) {
                case "search":
                    $menuMarkButtons = new SearchComponent($request->input('class_types'));
                    break;
                case "auth":
                    $menuMarkButtons = new RegisterComponent();
                    break;
                case "check-code":
                    $menuMarkButtons = new CheckCodeComponent();
                    break;
                case "success-register":
                    $menuMarkButtons = new SuccessRegisterComponent();
                    break;
                case "category-register":
                    $category_name = $request->input('category') ?? "";
                    $get_data = $this->get_data($category_name, ['id' => null, 'type' => 'register_page'], $request);
                    $menuMarkButtons = new CategoryRegisterComponent($category_name, $get_data, 'register');
                    break;
                case "register-box":
                    $category_name = $request->input('category') ?? "";
                    switch ($category_name) {
                        case 'category_sportsmen':
                        case 'category_trainers':
                        case 'category_judges':
                        case 'category_fun_zones':

//                            $category_name = $request->input('category') ?? "";
//                            $get_data = $this->get_data($category_name, ['id' => null, 'type' => 'register_page'], $request);
//                            $menuMarkButtons = new CategoryRegisterComponent($category_name, $get_data);
//                            break;
                        default :

                            $menuMarkButtons = new ModalRegisterSelectComponent($category_name);
                            break;
                    }
                    break;
                case "add-form-item":


//                    return response((new ModalAddFormItemComponent($request))->render());
                    $menuMarkButtons = new ModalAddFormItemComponent($request);
                    break;

                default:
                    $menuMarkButtons = new ModalNofFoundComponent($request->input('modal'));
            }
        }

        $menuMarkButtonsView = $menuMarkButtons->render()->render();
        return response()->json(
            [
                'data' => $menuMarkButtonsView,
                'class_name' => $request->input('modal'),
//                'log' => $request->input('category') ?? "",
            ]
        );
    }

    public function search_in_class(Request $request): JsonResponse
    {

        $search_value = $request->input('search_value') ?? "";
        $class_type_id = $request->input('class_types') ?? "";
        $class_type = ClassType::where('id', $class_type_id)->first();

        if ($class_type) {
            $class_table = $class_type->link;

            $data = DB::table($class_table)
                ->where(function ($query) use ($search_value) {
                    $query->where('name', 'like', "%" . $search_value . "%")
                        ->orWhere('phone', $search_value);
                })
                ->limit(20)
                ->get();


            $data_class = [
                'box_federations' => [
                    'employees_federations'
                ],
                'category_insurances' => [
                    'employees_insurances'
                ],

                'category_sports_institutions' => [
                    'employees_sports_institutions'
                ],

                'category_medicals' => [
                    'employees_medicals'
                ],
                'category_schools' => [
                    'employees_schools'
                ],
            ];
            $employees_table = $data_class[$class_table][0] ?? null;

            if (Schema::hasTable($employees_table)) {
                $data_employees = [
                    'table' => $employees_table,
                    'data' => DB::table($employees_table)
                        ->where(function ($query) use ($search_value) {
                            $query->where('name', 'like', "%" . $search_value . "%")
                                ->orWhere('phone', $search_value);
                        })
                        ->limit(20)
                        ->get()
                ];
                // Объединение результатов поиска

                $menuMarkButtons = new ModalModuleSearchResultListComponent($data, $class_table, 'a', $data_employees);

            } else {

                $menuMarkButtons = new ModalModuleSearchResultListComponent($data, $class_table);
            }

            $menuMarkButtonsView = $menuMarkButtons->render()->render();
            return response()->json(
                [
                    'data' => $menuMarkButtonsView,
//                'log' => 222,
                ]
            );
        }


        return response()->json(
            [
                'data' => [],
                'log' => 'Error not Find',
            ]
        );
    }

    public function search_in_class_no_form(Request $request): JsonResponse
    {
        $search_value = $request->input('search_value') ?? "";
        $class_type_id = $request->input('class_types') ?? "";
        $class_type = ClassType::where('id', $class_type_id)->first()->link;
        $data = DB::table($class_type)
            ->where('name', 'like', "%" . $search_value . "%")
            ->limit(10)
            ->orWhere('phone', $search_value)
            ->get();
        $menuMarkButtons = new ModalModuleSearchResultListComponent($data, $class_type, $tag = '');
        $menuMarkButtonsView = $menuMarkButtons->render()->render();

        return response()->json(
            [
                'data' => $menuMarkButtonsView,
            ]
        );
    }

    public function upload_img(Request $request)
    {

    }

    public function select_trainer(Request $request)
    {
        $trainer_id = $request->input('trainer_id') ?? null;
        $federation_id = $request->input('federation_id') ?? null;
        $sports_institutions_id = $request->input('sports_institutions_id') ?? null;

        if (!$trainer_id) {
            return response()->json(
                [
                    'data' => 'err',
                    'alert_type' => 'error',
                    'alert' => 'Тренер не знайдений',
                ]
            );
        }

        $linking = LinkingMembers::where('member_id', $trainer_id)
            ->where('category_type', ClassType::getIdCategory('category_sports_institutions'))
            ->pluck('category_id');
        if (count($linking)) {
            $institutions = CategorySportsInstitutions::whereIn('id', $linking)
                ->pluck('name', 'id');
        } else {
            $institutions = CategorySportsInstitutions::pluck('name', 'id');
        }

        $data_sports_institutions = [];
        $data_federations = [];
        foreach ($institutions as $key => $item) {
            $data_sports_institutions[] = [
                'text' => $item,
                'value' => $key,
            ];
        }


        $arr_federation = $this->get_arr_federation($trainer_id);
        if ($arr_federation) {
            $federation_db = BoxFederation::whereIn('id', $arr_federation)
                ->pluck('name', 'id')->all();

            if (empty($federation_db)) {
                $federation_db = BoxFederation::pluck('name', 'id')->all();
            }
        }else{
            $federation_db = BoxFederation::pluck('name', 'id')->all();
        }

        foreach ($federation_db as $key => $item) {
            $data_federations[] = [
                'text' => $item,
                'value' => $key,
            ];
        }


        $sports_institutions_list = (new OptionListComponent($data_sports_institutions, $sports_institutions_id))->render()->render();
        $federation_list = (new OptionListComponent($data_federations, $federation_id))->render()->render();
        return response()->json(
            [
                'data' => '',
                'sports_institutions' => $sports_institutions_list,
                'federation' => $federation_list,
            ]
        );
    }

    public function add_history_work(Request $request)
    {
        $type_class = $request->input('class_types');
        $linkingMembers = new LinkingMembers();
        $linkingMembers->category_id = $request->input('sport_institute');
        $linkingMembers->category_type = ClassType::getIdCategory('category_sports_institutions');
        $linkingMembers->member_id = $request->input('id');
        $linkingMembers->member_type = 3;
        $linkingMembers->type = 1;
        $linkingMembers->role = 1;
        $linkingMembers->date_start_at = $request->input('date_start');
        $linkingMembers->save();

        return redirect()->back();
    }


}
