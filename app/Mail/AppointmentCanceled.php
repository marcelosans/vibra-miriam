<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentCanceled extends Mailable
{
    use Queueable, SerializesModels;

    public $date;
    public $time;
    public $user;

    public function __construct($user, $date, $time)
    {
        $this->user = $user;
        $this->date = $date;
        $this->time = $time;
    }

    public function build()
    {
        return $this->subject('🚫Cita Cancelada😔')
                    ->view('emails.appointment-canceled');
    }
}
