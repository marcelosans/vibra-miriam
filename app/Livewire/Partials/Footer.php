<?php

namespace App\Livewire\Partials;

use App\Models\Contacto;
use App\Models\SocialMedia;
use Livewire\Component;

class Footer extends Component
{
    public $contacto;
    public $redes_sociales;
    public function render()
    {
        return view('livewire.partials.footer');
    }

    public function mount()
    {
        $this->contacto = Contacto::first();
        $this->redes_sociales = SocialMedia::get();
    }
}
