<?php

namespace App\Http\Livewire;

use App\Models\Direction;
use Livewire\Component;

class Directions extends Component
{

    public $name;

    public bool $keyToEdit;

    public $editableDirection;

    public function createDirection()
    {
        $direction = new Direction();
        $direction->name = $this->name;
        $direction->save();
    }

    public function editDirection($direction_id)
    {
        $this->keyToEdit = true;
        $this->editableDirection = Direction::find($direction_id);
        $this->name = $this->editableDirection->name;
    }

    public function updateDirection()
    {
        $this->editableDirection->name = $this->name;
        $this->editableDirection->save();

        $this->keyToEdit = false;
    }

    public function deleteDirection($direction_id)
    {
        $this->editableDirection = Direction::find($direction_id);
        $this->editableDirection->delete();
    }

    public function render()
    {
        $directions = Direction::all();
        return view('livewire.directions', ['directions' => $directions]);
    }
}
