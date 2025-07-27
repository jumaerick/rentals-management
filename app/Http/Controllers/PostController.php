<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Carbon\Carbon;

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

    public function showDueDates(){
        $dueDates = collect([
        (object)[
            'id' => 1,
            'title' => 'Math 101 Homework',
            'due_date' => Carbon::now()->addDays(3)->setHour(23)->setMinute(59),
            'description' => 'Complete exercises 1 to 10.',
        ],
        (object)[
            'id' => 2,
            'title' => 'Physics Lab Report',
            'due_date' => Carbon::now()->addWeek()->setHour(17)->setMinute(0),
            'description' => 'Submit lab report on pendulum experiment.',
        ],
        (object)[
            'id' => 3,
            'title' => 'English Essay',
            'due_date' => Carbon::now()->addDays(5)->setHour(20)->setMinute(0),
            'description' => 'Write an essay on modern poetry.',
        ],
    ]);

    return view('posts.due_dates', compact('dueDates'));
    }

}
