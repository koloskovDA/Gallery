<?php

namespace App\Http\Livewire;

use App\Models\Type;
use Livewire\Component;

class Types extends Component
{
    public $name;

    public bool $keyToEdit;

    public $editableType;

    public function createType()
    {
        $type = new Type();
        $type->name = $this->name;
        $type->save();
    }

    public function editType($type_id)
    {
        $this->keyToEdit = true;
        $this->editableType = Type::find($type_id);
        $this->name = $this->editableType->name;
    }

    public function updateType()
    {
        $this->editableType->name = $this->name;
        $this->editableType->save();

        $this->keyToEdit = false;
    }

    public function deleteType($type_id)
    {
        $this->editableType = Type::find($type_id);
        $this->editableType->delete();
    }

    public function render()
    {
        $types = Type::all();
        return view('livewire.types', ['types' => $types]);
    }
}
