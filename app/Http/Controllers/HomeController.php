<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Carousel;
use App\Models\Exhibition;
use App\Models\Member;
use App\Models\MemberAction;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $exhibitions = Exhibition::orderBy('starts_at', 'desc')->with('expositions.paintings.file')->limit(5)->get();
        return view('welcome', ['exhibitions' => $exhibitions]);
    }
}
