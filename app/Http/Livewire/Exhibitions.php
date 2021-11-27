<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Exhibition;
use Livewire\Component;

class Exhibitions extends Component
{
    public $name;

    public $address;

    public $starts_at;

    public $ends_at;

    public bool $keyToEdit;

    public $editableExhibition;

    public $auction_date;

    public function createExhibition()
    {
        $exhibition = new Exhibition();
        $exhibition->name = $this->name;
        $exhibition->address = $this->address;
        $exhibition->starts_at = $this->starts_at;
        $exhibition->ends_at = $this->ends_at;

        $auction = new Auction(['starts_at' => $this->auction_date]);

        $exhibition->save();
        $exhibition->auction()->save($auction);
    }

    public function editExhibition($exhibition_id)
    {
        $this->keyToEdit = true;
        $this->editableExhibition = Exhibition::find($exhibition_id);
        $this->name = $this->editableExhibition->name;
        $this->address = $this->editableExhibition->address;
        $this->starts_at = $this->editableExhibition->starts_at;
        $this->ends_at = $this->editableExhibition->ends_at;
        $this->auction_date = $this->editableExhibition->auction->starts_at ?? null;
    }

    public function updateExhibition()
    {
        $this->editableExhibition->name = $this->name;
        $this->editableExhibition->address = $this->address;
        $this->editableExhibition->starts_at = $this->starts_at;
        $this->editableExhibition->ends_at = $this->ends_at;
        $this->editableExhibition->save();
        $this->editableExhibition->auction()->starts_at = $this->auction_date;
        $this->editableExhibition->auction()->delete();
        $this->editableExhibition->auction()->save();

        $this->keyToEdit = false;
    }

    public function deleteExhibition($exhibition_id)
    {
        $this->editableExhibition = Exhibition::find($exhibition_id);
        $this->editableExhibition->auction()->delete();
        $this->editableExhibition->delete();
    }

    public function render()
    {
        $exhibitions = Exhibition::all();
        return view('livewire.exhibitions', ['exhibitions' => $exhibitions]);
    }
}
