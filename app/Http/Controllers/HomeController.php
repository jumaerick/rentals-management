<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    

    public function chats(){
        $course_id  =1;
        $myComments = Comment::where('course_id', $course_id)->get();
        // $othersComments = Comment::where('course_id', $course_id)->where('user_id', '!=', Auth::user()->id)->get();
        return view('chats')->with(['comments'=>$myComments]);
    }

    public function partners(){
        return view('partners');
    }

    public function comment(Request $request){
        $comment = new Comment();
        $comment->message = $request->message;
        $comment->user_id = $request->user_id;
        $comment->course_id = $request->course_id;
        $comment->save();
        // event(new CommentCreated($comment)); // Dispatch the event

        $subscribers = User::all();

        foreach ($subscribers as $subscriber){
                dispatch(new SendWelcomeEmailJob([
                    'email' => $subscriber->email,
                    'name' => $subscriber->name,
                ]));
            }


        return back();
    }

        public function generatePdf()
    {

        // dd('hapa');
        $data = [
            'param1' => 'value1',
            // other data
        ];

        $pdf = Pdf::loadView('pdf-view', $data)
            ->setOption([
                'defaultFont' => 'Poppins'
            ]);

    return $pdf->stream('sample.pdf');
    }
}
