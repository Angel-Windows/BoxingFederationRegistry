<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function showImg(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = $request->input('filename');
        $newPath = null;
        $path = null;
        if ($filename) {
            $path = storage_path('app/' . $filename);
            $relativePath = str_replace(storage_path('app') . '/', '', $path);
            if ($relativePath) {
                $newPath = $path;
            }
        }
        if (!$newPath) {
            $newFilename = 'img/no_img.jpg';
            $newPath = resource_path($newFilename);
            $path = $newPath;
        }



        return response()->file($path);
    }
}
