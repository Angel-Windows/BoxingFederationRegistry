<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Category\CategorySportsman;
use App\Models\Class\ClassType;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class HomeController extends Controller
{
    public function index()
    {



        $card_data = ClassType::whereIsset('description');
        return view('page.home', compact('card_data'));
    }
    public function test_page()
    {
        $sportsmans = CategorySportsman::get();

        foreach ($sportsmans as $sportsman) {
            $name = explode(' ', $sportsman->name);
            $user = CategorySportsman::find( $sportsman->id);
            if($user){
//                dd($user);
                $user->update(['name'=> $name[1] . ' ' . $name[0] . ' ' . ($name[2] ?? '')]);
            }
        }
    }

}
