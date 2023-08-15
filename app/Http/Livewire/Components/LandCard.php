<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class LandCard extends Component
{
    public $land;
    public function mount($land)
    {
        $this->land = $land;
    }
    public function render()
    {
        return view('livewire.components.land-card');
    }
}
