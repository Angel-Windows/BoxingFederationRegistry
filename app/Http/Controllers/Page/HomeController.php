<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
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



        foreach ($card_data as $all_datum) {
            $all_datum->count = DB::table($all_datum->link)->count();
        }

        return view('page.home', compact('card_data'));
    }
    public function test_page()
    {
        $path = resource_path('img/no_img.jpg');

//        $sportsmans = CategoryTrainer::get();
//
//        foreach ($sportsmans as $sportsman) {
//            $name = explode(' ', $sportsman->name);
//            $user = CategoryTrainer::find( $sportsman->id);
//            if($user){
////                dd($user);
//                $user->update(['name'=> $name[1] . ' ' . $name[0] . ' ' . ($name[2] ?? '')]);
//            }
//        }
    }

}
