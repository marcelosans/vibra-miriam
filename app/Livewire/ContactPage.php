<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contacto;
use App\Models\SocialMedia;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;

class ContactPage extends Component
{
    public $contacto;
    public $redes_sociales;

    public $nombre;
    public $email;
    public $mensaje;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'email' => 'required|email',
        'mensaje' => 'required|string|min:5',
    ];

    public function mount()
    {
        $this->redes_sociales = SocialMedia::get();
        $this->contacto = Contacto::first();
    }

    public function enviar()
    {
        $this->validate();

        // Enviar el correo al admin
        Mail::to($this->contacto->correo)->send(
            new ContactoMail($this->nombre, $this->email, $this->mensaje)
        );

        // Resetear campos
        $this->reset(['nombre', 'email', 'mensaje']);

        // Mensaje de confirmación
        session()->flash('success', '¡Tu mensaje ha sido enviado correctamente!');
    }

    public function render()
    {
        return view('livewire.contact-page');
    }
}
