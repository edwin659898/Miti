<?php

namespace App\Http\Livewire;

use App\Models\Mtn as ModelsMtn;
use Livewire\Component;

class Mtn extends Component
{
    public function render()
    {
        return view('livewire.mtn',[
            'payments' => ModelsMtn::with('user')
            ->where('status','verified')
            ->latest()
            ->paginate(10),
        ]);
    }
}
