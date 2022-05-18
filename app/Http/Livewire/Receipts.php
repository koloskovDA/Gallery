<?php

namespace App\Http\Livewire;

use App\Models\File;
use App\Models\Receipt;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Receipts extends Component
{
    public $receipts;

    public bool $keyToCheck;

    public Receipt $editableReceipt;

    public function editReceipt($receipt_id)
    {
        $this->editableReceipt = Receipt::find($receipt_id);
    }

    public function approveReceipt()
    {
        $this->editableReceipt->status = 'approved';
        $this->editableReceipt->save();
        $this->editableReceipt->ticket->exhibition->tickets_count -= 1;
        $this->editableReceipt->ticket->exhibition->save();
        unset($this->editableReceipt);
    }

    public function rejectReceipt()
    {
        $this->editableReceipt->status = 'rejected';
        $this->editableReceipt->save();
        unset($this->editableReceipt);
    }

    public function render()
    {
        $this->receipts = Receipt::all();

        return view('livewire.receipts');
    }
}
