<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
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
        return $this->subject('🌸Cita Confirmada🌸')
                    ->view('emails.appointment-confirmed');
    }
}
