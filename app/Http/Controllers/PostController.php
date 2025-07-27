<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function index(Request $request){
        $morePosts = False;
        $perPage = 5;
        $posts = Post::paginate($perPage);
        $lastPage = $posts->lastPage();
        if($posts->lastPage() > 1){
        $morePosts = True;
        }
        
        if ($request->ajax()) {

            $view = view('data', compact('posts'))->render();
            return response()->json(['html' => $view]);
        }

  
        return view('posts.index')->with(['posts'=>$posts, 'morePosts'=>$morePosts, 'lastPage'=>$lastPage]);
    }

}
