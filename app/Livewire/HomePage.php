<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Blog;

class HomePage extends Component
{
    public $services;
    public $blogs;

    public function mount()
    {
        $this->services = Service::get();
        $this->blogs = Blog::orderBy('fecha', 'desc')->limit(2)->get();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
