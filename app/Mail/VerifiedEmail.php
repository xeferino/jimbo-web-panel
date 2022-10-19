<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifiedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data  = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('sender-email.events.email_verified_at'), config('app.name'))
            ->subject('¿Para disfrutar sin limites de Jimbo sorteos verifique su email?')
            ->view('emails.verifiedEmail', ['data' => $this->data]);
    }
}
