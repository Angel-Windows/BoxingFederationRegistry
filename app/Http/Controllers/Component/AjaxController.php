<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use App\View\Components\modal\CategoryRegisterComponent;
use App\View\Components\modal\CheckCodeComponent;
use App\View\Components\modal\ModalNofFoundComponent;
use App\View\Components\modal\RegisterComponent;
use App\View\Components\modal\SearchComponent;
use App\View\Components\ModalAddFormItemComponent;
use App\View\Components\ModalModuleSearchResultListComponent;
use App\View\Components\ModalRegisterSelectComponent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    use CategoryUITrait;

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

                            $category_name = $request->input('category') ?? "";
                            $get_data = $this->get_data($category_name, ['id' => null, 'type' => 'register_page'], $request);
                            $menuMarkButtons = new CategoryRegisterComponent($category_name, $get_data);
                            break;
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
                'log' => $request->input('category') ?? "",
            ]
        );
    }

    public function search_in_class(Request $request): JsonResponse
    {

        $search_value = $request->input('search_value') ?? "";
        $class_type_id = $request->input('class_types') ?? "";
        $class_type = ClassType::where('id', $class_type_id)->first()->link;
        $data = DB::table($class_type)
            ->where('name', 'like', "%" . $search_value . "%")
            ->limit(10)
            ->orWhere('phone', $search_value)
            ->get();
        $menuMarkButtons = new ModalModuleSearchResultListComponent($data, $class_type);
        $menuMarkButtonsView = $menuMarkButtons->render()->render();

        return response()->json(
            [
                'data' => $menuMarkButtonsView,
//                'log' => 222,
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
