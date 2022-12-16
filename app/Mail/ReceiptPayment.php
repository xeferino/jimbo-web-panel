<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptPayment extends Mailable
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
        $subject = null;
        $name = null;
        if( $this->data['type'] == 'Compra' &&  $this->data['operation'] == 'buyer'){
            $subject =  'Recibo de pago #'.$this->data['number'].', Compra de Boletos.';
            $name = "Recibo-de-". $this->data['type']."-".str_pad($this->data['sale']->id,6,"0",STR_PAD_LEFT).".pdf";
        } elseif ( $this->data['type'] == 'Venta' &&  $this->data['operation'] == 'buyer') {
            $subject =  'Recibo de pago #'.$this->data['number'].', Compra de Boletos.';
            $name = "Recibo-de-compra-".str_pad($this->data['sale']->id,6,"0",STR_PAD_LEFT).".pdf";
        } elseif ( $this->data['type'] == 'Venta' &&  $this->data['operation'] == 'seller') {
            $subject =  'Recibo de pago #'.$this->data['number'].', Venta de Boletos.';
            $name = "Recibo-de-". $this->data['type']."-".str_pad($this->data['sale']->id,6,"0",STR_PAD_LEFT).".pdf";
        }

        return $this->from(config('sender-email.events.notif_user_receipt_payment_email_from'), config('app.name'))
            ->subject($subject)
            ->view('emails.receiptPayment', ['data' => $this->data])
            ->attachData($this->data['pdf'], $name, ['mime' => 'application/pdf']);
    }
}
