<?php

namespace App\Livewire;

use Livewire\Component;

class OpeningScreen extends Component
{
    public function nextStep()
    {
        return redirect()->route('login'); 
    }

    public function render()
    {
        return view('livewire.opening-screen');
    }
}

