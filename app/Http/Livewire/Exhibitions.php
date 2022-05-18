<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Exhibition;
use App\Models\File;
use App\Models\Receipt;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Exhibitions extends Component
{
    use WithFileUploads;

    public $name;

    public $address;

    public $starts_at;

    public $ends_at;

    public bool $keyToEdit;

    public $editableExhibition;

    public $auction_date;

    public $auction_date_ends;

    public $tickets_count;

    public $tickets;

    public $receiptPhoto;

    public $price;

    public function createExhibition()
    {
        $exhibition = new Exhibition();
        $exhibition->name = $this->name;
        $exhibition->address = $this->address;
        $exhibition->starts_at = $this->starts_at;
        $exhibition->ends_at = $this->ends_at;
        $exhibition->tickets_count = $this->tickets_count;
        $exhibition->price = $this->price;

        $auction = new Auction(['starts_at' => $this->auction_date,
                                'ends_at' => $this->auction_date_ends]);

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
        $this->tickets_count = $this->editableExhibition->tickets_count;
        $this->price = $this->editableExhibition->price;
        $this->auction_date = $this->editableExhibition->auction->starts_at ?? null;
        $this->auction_date_ends = $this->editableExhibition->auction->ends_at ?? null;
    }

    public function addReceipt($exhibition_id)
    {
        $this->editableExhibition = Exhibition::find($exhibition_id);
    }

    public function createTicket()
    {
        $ticket = new Ticket();
        $ticket->exhibition_id = $this->editableExhibition->id;
        $ticket->user_id = Auth::user()->id;
        $ticket->save();

        $receipt = new Receipt();
        $receipt->ticket_id = $ticket->id;
        $receipt->status = 'checking';
        $fileName = time().uniqid(rand()).'.'.$this->receiptPhoto->getClientOriginalExtension();
        $file = new File(['name' => $fileName]);
        $receipt->save();
        $receipt->file()->save($file);

        $this->uploadImage($fileName);
        $this->receiptPhoto = null;
    }

    public function uploadImage($fileName)
    {
        $image = $this->receiptPhoto;
        $img = Image::make($image->getRealPath())->encode('jpg', 65);$img->stream(); // <-- Key point
        Storage::disk('local')->put('public/img/receipts' . '/' . $fileName, $img, 'public');$this->receiptPhoto = null;
    }

    public function updateExhibition()
    {
        $this->editableExhibition->name = $this->name;
        $this->editableExhibition->address = $this->address;
        $this->editableExhibition->starts_at = $this->starts_at;
        $this->editableExhibition->ends_at = $this->ends_at;
        $this->editableExhibition->tickets_count = $this->tickets_count;
        $this->editableExhibition->price = $this->price;

        if (!empty($this->editableExhibition->auction)) {
            $this->editableExhibition->auction->starts_at = $this->auction_date;
            $this->editableExhibition->auction->ends_at = $this->auction_date_ends;
            $this->editableExhibition->save();
            $this->editableExhibition->auction->save();
        }
        else {
            $auction = new Auction();
            $auction->exhibition_id = $this->editableExhibition->id;
            $auction->starts_at = $this->auction_date;
            $auction->ends_at = $this->auction_date_ends;
            $auction->save();
        }

        $this->keyToEdit = false;
    }

    public function deleteExhibition($exhibition_id)
    {
        $this->editableExhibition = Exhibition::find($exhibition_id);
        if ($this->editableExhibition->auction !== null) {
            $this->editableExhibition->auction->bids()->delete();
        }
        if ($this->editableExhibition->expositions !== null) {
            foreach ($this->editableExhibition->expositions as $exposition)
            {
                if ($exposition->paintings !== null)
                {
                    $exposition->paintings()->delete();
                }
            }
            $this->editableExhibition->expositions()->delete();
        }
        $this->editableExhibition->auction()->delete();
        $this->editableExhibition->tickets()->delete();
        $this->editableExhibition->delete();
    }

    public function render()
    {
        if (Auth::check()) {
            $this->tickets = Ticket::where('user_id', Auth::user()->id)->get();
        }
        $exhibitions = Exhibition::orderBy('starts_at', 'asc')->get();
        return view('livewire.exhibitions', ['exhibitions' => $exhibitions]);
    }
}
