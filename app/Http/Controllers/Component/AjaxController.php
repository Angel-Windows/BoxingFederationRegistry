<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\UserProfile;
use App\Services\MyAuthService;
use App\View\Components\modal\CategoryRegisterComponent;
use App\View\Components\modal\CheckCodeComponent;
use App\View\Components\modal\ModalNofFoundComponent;
use App\View\Components\Modal\Module\SearchResultListComponent;
use App\View\Components\modal\RegisterComponent;
use App\View\Components\modal\SearchComponent;
use App\View\Components\ModalAddFormItemComponent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
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
                    $menuMarkButtons = new CategoryRegisterComponent($category_name);
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
//        $search_value = $request->input('search_value') ?? "";
//        $class_type_id = $request->input('class_types') ?? "";
//        $class_type = ClassType::where('id', $class_type_id)->first()->link;
//        $data = DB::table($class_type)
//            ->where('name', 'like', "%" . $search_value . "%")
//            ->limit(10)
//            ->get();
//        $menuMarkButtons = new SearchResultListComponent($data, $class_type);
//        $menuMarkButtonsView = $menuMarkButtons->render()->render();

        return response()->json(
            [
                'data' => 'asdfasdfasdf',
//                'data' => $menuMarkButtonsView,

            ]
        );
    }

    public function upload_img(Request $request)
    {

    }


}
