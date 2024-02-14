<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassType;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class HomeController extends Controller
{
    public function index()
    {
//        SmsService::sendSms('+380956686191', 'test');
        $card_data = ClassType::whereIsset('description');
        return view('page.home', compact('card_data'));
    }
}
