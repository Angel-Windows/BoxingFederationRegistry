<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function showImg(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = $request->input('filename');
        $path = storage_path('app/' . $filename);
        if (!\Storage::exists($filename)) {
            dd($filename, $path);
//            abort(404);
        }

        return response()->file($path);
    }
}
