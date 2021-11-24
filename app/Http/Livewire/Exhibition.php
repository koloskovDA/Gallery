<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Exposition;
use Livewire\Component;

class Exhibition extends Component
{

    public $name;

    public bool $keyToEdit;

    public $editableExposition;

    public function createExposition()
    {
        $exposition = new \App\Models\Exposition();
        $exposition->name = $this->name;

        $exposition->exhibition_id = $this->exhibition_id;
        $exposition->save();
    }

    public function editExposition($exposition_id)
    {
        $this->keyToEdit = true;
        $this->editableExposition = Exposition::find($exposition_id);
        $this->name = $this->editableExposition->name;
    }

    public function updateExposition()
    {
        $this->editableExposition->name = $this->name;
        $this->editableExposition->save();

        $this->keyToEdit = false;
    }

    public function deleteExposition($exposition_id)
    {
        $this->editableExposition = Exposition::find($exposition_id);
        $this->editableExposition->delete();
    }

    public int $exhibition_id;

    public function mount()
    {
        $url = explode('/', url()->current());
        $this->exhibition_id = end($url);
    }

    public function render()
    {
        $expositions = Exposition::where('exhibition_id', $this->exhibition_id)->get();

        return view('livewire.exhibition', ['expositions' => $expositions]);
    }
}
