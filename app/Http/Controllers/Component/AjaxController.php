<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassType;
use App\Models\UserProfile;
use App\View\Components\Modal\Module\SearchResultListComponent;
use App\View\Components\modal\SearchComponent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    public function open_modal(Request $request): JsonResponse
    {
        $menuMarkButtons = new SearchComponent($request->input('class_types'));
        $menuMarkButtonsView = $menuMarkButtons->render()->render();
        return response()->json(
            [
                'data' => $menuMarkButtonsView,
            ]
        );
    }

    public function search_in_class(Request $request): JsonResponse
    {
        $search_value = $request->input('search_value') ?? "";
        $class_type_id = $request->input('class_types') ?? "";
        $class_type = ClassType::where('id', $class_type_id)->first();
//        $getCache = ClassType::getCache(1);

        $data = UserProfile::
        where('first_name', 'like', "%".$search_value."%")
        ->orWhere('last_name', 'like', "%".$search_value."%")
        ->orWhere('surname', 'like', "%".$search_value."%")
            ->limit(10)
            ->get();
        $menuMarkButtons = new SearchResultListComponent($data, $class_type->link);
        $menuMarkButtonsView = $menuMarkButtons->render()->render();

        return response()->json(
            [
                'data' => $menuMarkButtonsView,

            ]
        );
    }
}
