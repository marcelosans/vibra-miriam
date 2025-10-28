<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Service;

class ServicioDetailPage extends Component
{
    public $service;
    public function mount($slug)
    {
        $this->service = Service::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.servicio-detail-page');
    }
}
