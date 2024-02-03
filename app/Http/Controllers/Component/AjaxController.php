<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\UserProfile;
use App\View\Components\modal\CategoryRegisterComponent;
use App\View\Components\modal\ModalNofFoundComponent;
use App\View\Components\Modal\Module\SearchResultListComponent;
use App\View\Components\modal\RegisterComponent;
use App\View\Components\modal\SearchComponent;
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
                case "register":
                    $menuMarkButtons = new RegisterComponent();
                    break;
                case "category-register":
                    $category_name = $request->input('category') ?? "";
                    $menuMarkButtons = new CategoryRegisterComponent($category_name);
                    break;
                default:
                    $menuMarkButtons = new ModalNofFoundComponent($request->input('modal'));
            }
        }

        $menuMarkButtonsView = $menuMarkButtons->render()->render();
        return response()->json(
            [
                'data' => $menuMarkButtonsView,
                'class_name' =>$request->input('modal'),
                'log' => $request->input('category') ?? "",
            ]
        );
    }

    public function search_in_class(Request $request): JsonResponse
    {
        $search_value = $request->input('search_value') ?? "";
        $class_type_id = $request->input('class_types') ?? "";
        $class_type = ClassType::where('id', $class_type_id)->first()->link;
        $data = DB::table($class_type)
            ->where('name', 'like', "%" . $search_value . "%")
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
    public function upload_img(Request $request){
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Пример валидации
        ]);

        $photoPath = $request->file('photo')->store('photos');

        // Сохранение информации о фотографии в базе данных
//        $photo = new Photo();
//        $photo->path = $photoPath;
//        $photo->save();

        return response()->json(['message' => 'Фотография успешно загружена.']);

    }

    public function show($filename)
    {
        $path = storage_path('app/photos/' . $filename); // Путь к файлу в хранилище

        if (!\Storage::exists('photos/' . $filename)) {
            abort(404); // Если файл не найден, вернем HTTP ошибку 404
        }

        return response()->file($path); // Вернем файл в ответ на запрос
    }
}
