<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Mitra Referral Baru</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background-color: #F7F7F5; margin: 0; padding: 24px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; margin: 0 auto; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; border: 1px solid #E8E8E6;">
        <tr>
            <td style="background-color: #9e1f16; padding: 20px 28px;">
                <span style="color: #FFFFFF; font-size: 18px; font-weight: bold;">FastTrack Legal</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 28px;">
                <h2 style="margin: 0 0 16px; font-size: 18px; color: #1A1B18;">Pendaftaran Mitra Referral Baru</h2>
                <p style="margin: 0 0 20px; font-size: 13px; color: #686964;">Ada pendaftaran baru pada Program Client Get Client di website FastTrack Legal.</p>

                <p style="margin: 20px 0 6px; font-size: 12px; color: #686964; text-transform: uppercase; letter-spacing: 0.05em; font-weight: bold;">1. Data Peserta</p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #1A1B18;">
                    <tr>
                        <td style="padding: 4px 0; width: 160px; color: #686964;">Nama Lengkap / Perusahaan</td>
                        <td style="padding: 4px 0;">: {{ $data['nama_lengkap'] }}</td>
                    </tr>
                    @if (!empty($data['nama_pic']))
                        <tr>
                            <td style="padding: 4px 0; color: #686964;">Nama PIC</td>
                            <td style="padding: 4px 0;">: {{ $data['nama_pic'] }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Jenis Peserta</td>
                        <td style="padding: 4px 0;">: {{ $data['jenis_peserta'] }}{{ !empty($data['jenis_peserta_lainnya']) ? ' - ' . $data['jenis_peserta_lainnya'] : '' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Bidang Usaha / Profesi</td>
                        <td style="padding: 4px 0;">: {{ $data['bidang_usaha'] }}</td>
                    </tr>
                    @if (!empty($data['nomor_identitas']))
                        <tr>
                            <td style="padding: 4px 0; color: #686964;">No. KTP / NPWP / NIB</td>
                            <td style="padding: 4px 0;">: {{ $data['nomor_identitas'] }}</td>
                        </tr>
                    @endif
                </table>

                <p style="margin: 20px 0 6px; font-size: 12px; color: #686964; text-transform: uppercase; letter-spacing: 0.05em; font-weight: bold;">2. Kontak Peserta</p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #1A1B18;">
                    <tr>
                        <td style="padding: 4px 0; width: 160px; color: #686964;">No. WhatsApp</td>
                        <td style="padding: 4px 0;">: {{ $data['no_whatsapp'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Email</td>
                        <td style="padding: 4px 0;">: {{ $data['email'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964; vertical-align: top;">Alamat Domisili</td>
                        <td style="padding: 4px 0;">: {{ $data['alamat_domisili'] }}</td>
                    </tr>
                    @if (!empty($data['media_sosial']))
                        <tr>
                            <td style="padding: 4px 0; color: #686964;">Media Sosial / Website</td>
                            <td style="padding: 4px 0;">: {{ $data['media_sosial'] }}</td>
                        </tr>
                    @endif
                </table>

                <p style="margin: 20px 0 6px; font-size: 12px; color: #686964; text-transform: uppercase; letter-spacing: 0.05em; font-weight: bold;">3. Informasi Rekening</p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #1A1B18;">
                    <tr>
                        <td style="padding: 4px 0; width: 160px; color: #686964;">Nama Bank</td>
                        <td style="padding: 4px 0;">: {{ $data['nama_bank'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Nomor Rekening</td>
                        <td style="padding: 4px 0;">: {{ $data['nomor_rekening'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Atas Nama</td>
                        <td style="padding: 4px 0;">: {{ $data['atas_nama'] }}</td>
                    </tr>
                </table>

                <p style="margin: 20px 0 6px; font-size: 12px; color: #686964; text-transform: uppercase; letter-spacing: 0.05em; font-weight: bold;">4. Data Referensi Klien</p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #1A1B18;">
                    <tr>
                        <td style="padding: 4px 0; width: 160px; color: #686964;">Nama Klien</td>
                        <td style="padding: 4px 0;">: {{ $data['nama_klien'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Nama PIC Klien</td>
                        <td style="padding: 4px 0;">: {{ $data['nama_pic_klien'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #686964;">Nomor Kontak Klien</td>
                        <td style="padding: 4px 0;">: {{ $data['nomor_kontak_klien'] }}</td>
                    </tr>
                    @if (!empty($data['email_klien']))
                        <tr>
                            <td style="padding: 4px 0; color: #686964;">Email Klien</td>
                            <td style="padding: 4px 0;">: {{ $data['email_klien'] }}</td>
                        </tr>
                    @endif
                    @if (!empty($data['layanan_dibutuhkan']))
                        <tr>
                            <td style="padding: 4px 0; color: #686964; vertical-align: top;">Layanan Dibutuhkan</td>
                            <td style="padding: 4px 0;">: {{ implode(', ', $data['layanan_dibutuhkan']) }}</td>
                        </tr>
                    @endif
                    @if (!empty($data['keterangan_tambahan']))
                        <tr>
                            <td style="padding: 4px 0; color: #686964; vertical-align: top;">Keterangan Tambahan</td>
                            <td style="padding: 4px 0;">: {{ $data['keterangan_tambahan'] }}</td>
                        </tr>
                    @endif
                </table>

                <p style="margin: 20px 0 6px; font-size: 12px; color: #686964; text-transform: uppercase; letter-spacing: 0.05em; font-weight: bold;">5. Skema Insentif</p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #1A1B18;">
                    <tr>
                        <td style="padding: 4px 0;">: {{ $data['skema_insentif'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 16px 28px; background-color: #F7F7F5; text-align: center;">
                <span style="font-size: 11px; color: #9A9A97;">Dikirim otomatis dari halaman Kerjasama (Client Get Client) fasttrack.legal</span>
            </td>
        </tr>
    </table>
</body>
</html>
