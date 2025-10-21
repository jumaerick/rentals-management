<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\RecommendationEngine;
use Auth;

class HomeController extends Controller
{
    //

    public function home(){
        return view('welcome');
    }

    public function recommendation(RecommendationEngine $engine){
        $user =Auth::user();
        
        //Get recommendations
        $recommendations = $engine->recommendCourses($user);
        return view('recommendations', compact('recommendations'));
    }
}
