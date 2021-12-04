<?php

namespace App\Http\Livewire;

use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Painting extends Component
{
    public $painting;

    public $bids;

    public $bidSum;

    public function mount()
    {
        $id = explode('/', URL::full());
        $this->painting = \App\Models\Painting::find(end($id));
    }
    public function render()
    {
        $this->bids = $this->painting->bids->sortByDesc('sum')->take(5);
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
