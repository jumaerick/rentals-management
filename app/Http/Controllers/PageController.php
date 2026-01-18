<?php

namespace App\Http\Controllers;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //

    public function index(){
        return view('index');
    }

    public function enquiryStore(Request $request){
        $validated = $request->validate(
            ['name'=>'required|max:200',
                    'email'=>'required|email',
                    'message'=>'required',
            ]);

            Enquiry::create($validated);

            return redirect()
            ->back()
            ->with('success', "Your message has been sent successfully!");
        // dd($data);
    }
}
