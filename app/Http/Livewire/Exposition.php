<?php

namespace App\Http\Livewire;

use App\Models\Author;
use App\Models\Direction;
use App\Models\File;
use App\Models\Owner;
use App\Models\Painting;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Exposition extends Component
{
    use WithFileUploads;

    public $name;

    public $direction;

    public $directions;

    public $type;

    public $types;

    public $author;

    public $authors;

    public $year;

    public $price;

    public $owner;

    public $owners;

    public bool $keyToEdit;

    public $editablePainting;

    public $file;

    public function createPainting()
    {
        $painting = new \App\Models\Painting();
        $painting->name = $this->name;
        $painting->direction_id = $this->direction;
        $painting->type_id = $this->type;
        $painting->author_id = $this->author;
        $painting->year = $this->year;
        $painting->price = $this->price;
        $painting->owner_id = $this->owner;

        $painting->exposition_id = $this->exposition_id;

        $fileName = time().uniqid(rand()).'.'.$this->file->getClientOriginalExtension();
        $file = new File(['name' => $fileName]);
        $painting->save();
        $painting->file()->save($file);

        $this->uploadImage($fileName);
        $this->file = null;
    }

    public function uploadImage($fileName)
    {
        $image = $this->file;
        $img = Image::make($image->getRealPath())->encode('jpg', 65)->fit(1280, 400, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $img->stream(); // <-- Key point
        Storage::disk('local')->put('public/img/paintings' . '/' . $fileName, $img, 'public');
        $this->file = null;
    }

    public function editPainting($painting_id)
    {
        $this->keyToEdit = true;
        $this->editablePainting = Painting::find($painting_id);
        $this->name = $this->editablePainting->name;
        $this->direction = $this->editablePainting->direction_id;
        $this->type = $this->editablePainting->type_id;
        $this->author = $this->editablePainting->author_id;
        $this->year = $this->editablePainting->year;
        $this->price = $this->editablePainting->price;
        $this->owner = $this->editablePainting->owner_id;
    }

    public function updatePainting()
    {
        $this->editablePainting->name = $this->name;
        $this->editablePainting->direction_id = $this->direction;
        $this->editablePainting->type_id = $this->type;
        $this->editablePainting->author_id = $this->author;
        $this->editablePainting->year = $this->year;
        $this->editablePainting->price = $this->price;
        $this->editablePainting->owner_id = $this->owner;

        if ($this->file !== null)
        {
            $fileName = time() . uniqid(rand()) . '.' . $this->file->getClientOriginalExtension();
            $file = new File(['name' => $fileName]);
            $this->editablePainting->file()->delete();
            $this->editablePainting->file()->save($file);
            $this->uploadImage($fileName);
            $this->file = null;
        }

        $this->editablePainting->save();

        $this->keyToEdit = false;
    }

    public function deletePainting($painting_id)
    {
        $this->editablePainting = Painting::find($painting_id);
        $this->editablePainting->delete();
    }

    public int $exposition_id;

    public function mount()
    {
        $url = explode('/', url()->current());
        $this->exposition_id = end($url);
    }

    public function render()
    {
        $this->directions = Direction::all();
        $this->types = Type::all();
        $this->owners = Owner::all();
        $this->authors = Author::all();

        $paintings = Painting::where('exposition_id', $this->exposition_id)->get();

        return view('livewire.exposition', ['paintings' => $paintings]);
    }
}
