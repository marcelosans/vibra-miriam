<?php

namespace App\Livewire\Partials;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $user;
    public $isAuthenticated = false;

    public $services;

    public function mount()
    {
        $this->services = Service::get();
        $this->user = Auth::user();
        $this->isAuthenticated = Auth::check();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
