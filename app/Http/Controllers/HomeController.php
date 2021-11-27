<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Carousel;
use App\Models\Exhibition;
use App\Models\Member;
use App\Models\MemberAction;
use App\Models\News;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function painting($painting_id)
    {
        $painting = Painting::find($painting_id);
        return view('painting', ['painting' => $painting]);
    }

    public function welcome()
    {
        $exhibitions = Exhibition::inRandomOrder()->with(['expositions.paintings' => function ($query) {
            $query->inRandomOrder()->with('file');
        }])->limit(5)->get();
        return view('welcome', ['exhibitions' => $exhibitions]);
    }

    public function directionPaintings($direction_id)
    {
        $paintings = Painting::where('direction_id', $direction_id)->get();

        return view('dP', ['paintings' => $paintings]);
    }

    public function typePaintings($type_id)
    {
        $paintings = Painting::where('type_id', $type_id)->get();

        return view('tP', ['paintings' => $paintings]);
    }

    public function authorPaintings($author_id)
    {
        $paintings = Painting::where('author_id', $author_id)->get();

        return view('aP', ['paintings' => $paintings]);
    }

    public function ownerPaintings($owner_id)
    {
        $paintings = Painting::where('owner_id', $owner_id)->get();

        return view('oP', ['paintings' => $paintings]);
    }
}
