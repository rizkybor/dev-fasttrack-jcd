<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerReferralSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array{
     *     nama_lengkap: string, nama_pic: ?string, jenis_peserta: string, jenis_peserta_lainnya: ?string,
     *     bidang_usaha: string, nomor_identitas: ?string, no_whatsapp: string, email: string,
     *     alamat_domisili: string, media_sosial: ?string, nama_bank: string, nomor_rekening: string,
     *     atas_nama: string, nama_klien: string, nama_pic_klien: string, nomor_kontak_klien: string,
     *     email_klien: ?string, layanan_dibutuhkan: array, keterangan_tambahan: ?string, skema_insentif: string,
     * } $data
     */
    public function __construct(public array $data)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Pendaftaran Mitra Referral Baru - ' . $this->data['nama_lengkap'])
            ->replyTo($this->data['email'], $this->data['nama_lengkap'])
            ->view('emails.partner-referral');
    }
}
