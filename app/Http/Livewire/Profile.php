<?php

namespace App\Http\Livewire;

use App\Models\File;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public string $name;
    public string $email;
    public $file;

    public function mount()
    {
        $this->user = User::find(Auth::user()->id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function saveNewParameters()
    {
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->save();

        if ($this->user->file)
        {
            $this->user->file->delete();
        }
        $fileName = time().uniqid(rand()).'.'.$this->file->getClientOriginalExtension();
        $file = new File(['name' => $fileName]);
        $this->user->file()->save($file);

        $image = $this->file;
        $img = Image::make($image->getRealPath())->encode('jpg', 65)->fit(100, 100, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $img->stream(); // <-- Key point
        Storage::disk('local')->put('public/img/profile' . '/' . $fileName, $img, 'public');

        return redirect()->route('/');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
