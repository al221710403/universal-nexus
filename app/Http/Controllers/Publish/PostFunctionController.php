<?php

namespace App\Http\Controllers\Publish;

use App\Models\Publish\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostFunctionController extends Controller
{
    public function preview(Post $post,$action = "Preview"){
        $dataJson = [
            "title" => $action,
        ];

        if ($action == "recovery") {
            $pathAutoSave = 'publish/post/autosave/';
            $fileAutoSave = 'file_autosave_'.$post->id.'.json';
            $dataJson = [
                "title" => "Archivo de recuperación",
            ];

            // Si existe un archivo de recuperación
            if (file_exists('storage/' . $pathAutoSave . $fileAutoSave)) {
                $data = json_decode(Storage::get($pathAutoSave . $fileAutoSave), true);
                $post->title = $data['blog_title'];
                $post->body = $data['blog_content'];
            }else{
                return redirect()->route('publish.posts.index');
            }
        }

        $data_json = json_decode($post->metadata, true);
        $keywords = $data_json["keywords"] ?? [];

        return view('publish.preview',compact('post','dataJson','keywords'));
    }
}
