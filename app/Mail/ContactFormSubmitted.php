<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array{name: string, email: string, whatsapp: string, business: string|null, message: string} $data
     */
    public function __construct(public array $data)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Pesan Baru dari Formulir Kontak - ' . $this->data['name'])
            ->replyTo($this->data['email'], $this->data['name'])
            ->view('emails.contact-form');
    }
}
