<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $card_data = ClassType::all();
        return view('page.home', compact('card_data'));
    }
}
