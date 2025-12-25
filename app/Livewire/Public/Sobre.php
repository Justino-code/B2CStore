<?php
// app/Livewire/Public/Sobre.php

namespace App\Livewire\Public;

use Livewire\Component;

class Sobre extends Component
{
    public function render()
    {
        return view('livewire.pages.public.sobre')
            ->layout('components.layouts.public', [
                'title' => 'Sobre Nós - B2CStore',
                'description' => 'Conheça a história, valores e equipe da B2CStore. Saiba mais sobre nossa missão de transformar o comércio eletrônico com qualidade e inovação.',
                'keywords' => 'sobre, empresa, história, valores, equipe, missão, visão',
                'canonical' => route('sobre')
            ]);
    }
}