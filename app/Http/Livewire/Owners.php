<?php

namespace App\Http\Livewire;

use App\Models\File;
use App\Models\Owner;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Owners extends Component
{
    use WithFileUploads;

    public $fio;

    public $file;

    public bool $keyToEdit;

    public $editableOwner;

    public function createOwner()
    {
        $Owner = new Owner();
        $Owner->FIO = $this->fio;

        $fileName = time().uniqid(rand()).'.'.$this->file->getClientOriginalExtension();
        $file = new File(['name' => $fileName]);
        $Owner->save();
        $Owner->file()->save($file);

        $this->uploadImage($fileName);
        $this->file = null;
    }

    public function uploadImage($fileName)
    {
        $image = $this->file;
        $img = Image::make($image->getRealPath())->encode('jpg', 65)->fit(100, 100, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $img->stream(); // <-- Key point
        Storage::disk('local')->put('public/img/owners' . '/' . $fileName, $img, 'public');
        $this->file = null;
    }

    public function editOwner($owner_id)
    {
        $this->keyToEdit = true;
        $this->editableOwner = Owner::find($owner_id);
        $this->fio = $this->editableOwner->FIO;
    }

    public function updateOwner()
    {
        $this->editableOwner->FIO = $this->fio;
        $this->editableOwner->save();

        if ($this->file !== null)
        {
            $fileName = time() . uniqid(rand()) . '.' . $this->file->getClientOriginalExtension();
            $file = new File(['name' => $fileName]);
            $this->editableOwner->file()->delete();
            $this->editableOwner->file()->save($file);
            $this->uploadImage($fileName);
            $this->file = null;
        }

        $this->keyToEdit = false;
    }

    public function deleteOwner($owner_id)
    {
        $this->editableOwner = Owner::find($owner_id);
        $this->editableOwner->delete();
    }

    public function render()
    {
        $owners = Owner::with('file')->get();
        return view('livewire.owners', ['owners' => $owners]);
    }
}
