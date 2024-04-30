<?php

namespace App\Http\Controllers\Publish;

use App\Http\Controllers\Controller;
use App\Models\Publish\Post;
use Illuminate\Http\Request;

class PostFunctionController extends Controller
{
    public function preview(Post $post){
        return view('publish.preview',compact('post'));
    }
}
