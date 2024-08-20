<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Info.
     */
    public $name;
    public $email;
    public $phone;
    public $message;
    public $product_name;
    public $product_ref;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $message, $product_name, $product_ref)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $this->product_name = $product_name;
        $this->product_ref = $product_ref;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Consulta de Stock CD-SOLEC')->markdown('emails.stock');
    }
}
