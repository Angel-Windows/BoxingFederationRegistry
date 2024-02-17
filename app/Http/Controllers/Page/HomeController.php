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
        return view('test_page')//            ->with()
            ;
    }

    public function test_page_edit(Request $request)
    {
        $photo = $request->file('photo');

        if (!$photo) {
            return [
                'errors' => true,
                'patch' => null,
            ];
        }
        $validator = \Validator::make(['photo' => $photo], [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:20048',
        ]);

        if ($validator->fails()) {
            return [
                'errors' => $validator->errors()->all(),
                'patch' => "",
            ];
        }

        return [
            'errors' => false,
            'patch' => $photo->store('photos'),
        ];
    }

}
