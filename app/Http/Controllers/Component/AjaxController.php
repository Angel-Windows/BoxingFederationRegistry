<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\View\Components\modal\SearchComponent;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function open_modal(Request $request){

        $menuMarkButtons = new SearchComponent();
        $menuMarkButtonsView = $menuMarkButtons->render()->render();

        return response()->json(
            ['data' => $menuMarkButtonsView]
        );
    }
}
