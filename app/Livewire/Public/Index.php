<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.pages.public.index')->layout('components.layouts.public');
    }
}
