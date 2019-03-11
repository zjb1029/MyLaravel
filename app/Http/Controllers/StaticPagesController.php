<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{

    public function home(){
        $list = [];
        if(Auth::check()){
            $list = Auth::user()->feed()->paginate(30);
        }
        return view("static/home",compact("list"));
    }

    public function about(){
        return view("static/about");
    }

    public function help(){
        return view("static/help");
    }
}
