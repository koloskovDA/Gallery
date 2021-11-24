<?php

namespace App\Http\Livewire;

use App\Models\Author;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Authors extends Component
{
    use WithFileUploads;

    public $fio;

    public $file;

    public bool $keyToEdit;

    public $editableAuthor;

    public function createAuthor()
    {
        $author = new Author();
        $author->FIO = $this->fio;

        $fileName = time().uniqid(rand()).'.'.$this->file->getClientOriginalExtension();
        $file = new File(['name' => $fileName]);
        $author->save();
        $author->file()->save($file);

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
        Storage::disk('local')->put('public/img/authors' . '/' . $fileName, $img, 'public');
        $this->file = null;
    }

    public function editAuthor($author_id)
    {
        $this->keyToEdit = true;
        $this->editableAuthor = Author::find($author_id);
        $this->fio = $this->editableAuthor->FIO;
    }

    public function updateAuthor()
    {
        $this->editableAuthor->FIO = $this->fio;
        $this->editableAuthor->save();

        if ($this->file !== null)
        {
            $fileName = time() . uniqid(rand()) . '.' . $this->file->getClientOriginalExtension();
            $file = new File(['name' => $fileName]);
            $this->editableAuthor->file()->delete();
            $this->editableAuthor->file()->save($file);
            $this->uploadImage($fileName);
            $this->file = null;
        }

        $this->keyToEdit = false;
    }

    public function deleteAuthor($author_id)
    {
        $this->editableAuthor = Author::find($author_id);
        $this->editableAuthor->delete();
    }

    public function render()
    {
        $authors = Author::with('file')->get();
        return view('livewire.authors', ['authors' => $authors]);
    }
}
