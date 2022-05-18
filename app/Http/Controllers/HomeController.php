<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Carousel;
use App\Models\Exhibition;
use App\Models\Member;
use App\Models\MemberAction;
use App\Models\News;
use App\Models\Painting;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function generatePDF($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        $data = [
            'title' => 'Билет #1 на выставку '.$ticket->exhibition->name,
            'date' => \Carbon\Carbon::make($ticket->exhibition->starts_at)->translatedFormat('d F Y (l), H:i'),
            'exhibition' => $ticket->exhibition,
        ];

        $pdf = Pdf::loadView('myPDF', $data);

        return $pdf->download('Билет_#'.$ticket_id.'.pdf');
    }

    public function favourites()
    {
        $collection = new Collection();
        $pain = null;
        $paintings = Cache::get(Auth::user()->id);
        if ($paintings !== null)
        {
            foreach ($paintings as $key => $painting)
            {
                $pain = Painting::find($painting);
                $collection->push($pain);
            }
        }
        return view('favourites', ['paintings' => $collection]);
    }

    public function index()
    {
        return view('home');
    }

    public function myLots()
    {
        $paintings = Painting::whereHas('bids', function ($bids) {
            $bids->where('user_id', Auth::user()->id);
        })->get();

        return view('my-lots', ['paintings' => $paintings]);
    }

    public function myTickets()
    {
        $exhibitions = Exhibition::whereHas('tickets', function ($tickets) {
            $tickets->where('user_id', Auth::user()->id);
        })->get();

        return view('my-tickets', ['exhibitions' => $exhibitions]);
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
