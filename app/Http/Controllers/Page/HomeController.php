<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $card_data = ClassType::all();
        dd($card_data);
        return view('page.home', compact('card_data'));
    }
}
