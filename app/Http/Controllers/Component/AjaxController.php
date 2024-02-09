<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassType;
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

    public function open_modal(Request $request): JsonResponse
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
                    $menuMarkButtons = new CategoryRegisterComponent($category_name, $get_data);
                    break;
                case "register-box":
                    $category_name = $request->input('category') ?? "";
                    switch ($category_name) {
                        case 'category_sportsmen':
                        case 'category_trainers':
                        case 'category_judges':
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
                    $menuMarkButtons = new ModalAddFormItemComponent();
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


}
