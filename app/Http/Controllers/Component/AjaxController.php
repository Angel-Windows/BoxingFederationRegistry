<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Class\Trainer;
use App\Models\UserProfile;
use App\View\Components\Modal\Module\SearchResultListComponent;
use App\View\Components\modal\SearchComponent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
        $class_type = ClassType::where('id', $class_type_id)->first()->link;
        $data = DB::table($class_type)
            ->where('name', 'like', "%".$search_value."%")
            ->limit(10)
            ->get();

        $menuMarkButtons = new SearchResultListComponent($data, $class_type);
        $menuMarkButtonsView = $menuMarkButtons->render()->render();

        return response()->json(
            [
                'data' => $menuMarkButtonsView,

            ]
        );
    }
}
