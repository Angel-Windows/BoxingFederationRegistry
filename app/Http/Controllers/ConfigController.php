<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function showImg($fileName )
    {
        $path = storage_path('app/photos/' . $fileName); // Путь к файлу в хранилище

        if (!\Storage::exists('photos/' . $fileName)) {
            abort(404); // Если файл не найден, вернем HTTP ошибку 404
        }

        return response()->file($path); // Вернем файл в ответ на запрос
    }
}
