<?php

namespace App\Http\Livewire;

use App\Models\Bid;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Painting extends Component
{
    public $painting;

    public $bids;

    public $bidSum;

    public $ratings;

    public $rating = 5;

    public $comment;

    public function addToFavourites()
    {
        $cache = Cache::get(Auth::user()->id);
        !empty($cache) ? $cache->push($this->painting->id) : $cache = collect([$this->painting->id]);
        Cache::put(
            Auth::user()->id,
            $cache->unique(),
            now()->addDays(100)
        );
    }

    public function removeFromFavourites()
    {
        $cache = Cache::get(Auth::user()->id);
        $id = $this->painting->id;
        $cache = $cache->reject(function ($value) use ($id) {
            return $value === $id;
        });
        Cache::put(
            Auth::user()->id,
            $cache->unique(),
            now()->addDays(100)
        );
    }

    public function leaveReview()
    {
        if ($this->rating !== null)
        {
            $rating = new Rating();
            $rating->rating = $this->rating;
            $rating->user_id = Auth::user()->id;
            $rating->painting_id = $this->painting->id;
            $rating->save();
        }

        if ($this->comment !== null)
        {
            $comment = new Comment();
            $comment->text = $this->comment;
            $comment->user_id = Auth::user()->id;
            $comment->painting_id = $this->painting->id;
            $comment->save();
        }
    }

    public function mount()
    {
        $id = explode('/', URL::full());
        $this->painting = \App\Models\Painting::find(end($id));
    }

    public $amountRating;

    public function render()
    {
        if ($this->painting->ratings->count() !== 0)
            $this->amountRating = $this->painting->ratings->pluck('rating')->sum() / $this->painting->ratings->count();
        else
            $this->amountRating = 0;

        $this->bids = $this->painting->bids->sortByDesc('sum')->take(5);
        $this->ratings = Rating::all();
        return view('livewire.painting');
    }

    public function makeBid()
    {
        $sum = $this?->bids?->first()?->sum;
        if ($sum === null)
        {
            $sum = 0;
        }
        $this->validate(
            ['bidSum' => 'required|gt:'.$sum],
            ['bidSum.gt' => 'Ваша ставка должна быть больше последней!']
        );
        $bid = new Bid();
        $bid->painting_id = $this->painting->id;
        $bid->auction_id = $this->painting->exposition->exhibition->auction->id;
        $bid->user_id = Auth::user()->id;
        $bid->sum = $this->bidSum;
        $bid->save();
    }
}
