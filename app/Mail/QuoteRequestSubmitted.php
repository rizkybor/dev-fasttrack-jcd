<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array{kategori: string, layanan: string, detail_layanan: string, nama: string, perusahaan: string|null, no_whatsapp: string, email: string} $data
     */
    public function __construct(public array $data)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Permintaan Penawaran Baru - ' . $this->data['nama'])
            ->replyTo($this->data['email'], $this->data['nama'])
            ->view('emails.quote-request');
    }
}
