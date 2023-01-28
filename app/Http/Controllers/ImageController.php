<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $path = 'publish/post/image';
        $url = Storage::put($path, $request->file('upload'));

        return [
            'url' => Storage::url($url)
        ];
    }
}
