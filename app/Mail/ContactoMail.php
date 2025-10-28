<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $email;
    public $mensaje;

    public function __construct($nombre, $email, $mensaje)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->mensaje = $mensaje;
    }

    public function build()
    {
       return $this->from(config('mail.from.address'), config('mail.from.name'))
                ->replyTo($this->email, $this->nombre)
                ->subject("Nuevo mensaje de contacto de {$this->nombre}")
                ->view('emails.contacto');
    }
}
