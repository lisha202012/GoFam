<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class CreateHabit extends Component
{
    public $step = 1; 
    public $selectedCategory = null; 

    public function nextStep()
    {
        if ($this->step == 1 && $this->selectedCategory) {
            Log::info('✅ Proceeding to Step 2 with Selected Category: ' . $this->selectedCategory);
            $this->step++;
        }
    }

    public function updatedSelectedCategory($value)
    {
        Log::info('🔄 Selected Category Updated: ' . $value);
    }

    public function render()
    {
        Log::info('🖥 Rendering CreateHabit Component - Selected Category: ' . ($this->selectedCategory ?? 'None'));

        return view('livewire.create-habit');
    }
}
