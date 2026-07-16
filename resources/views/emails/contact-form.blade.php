<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Baru dari Formulir Kontak</title>
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
                <h2 style="margin: 0 0 16px; font-size: 18px; color: #1A1B18;">Pesan Baru dari Formulir Kontak</h2>
                <p style="margin: 0 0 20px; font-size: 13px; color: #686964;">Anda menerima pesan baru melalui formulir kontak di website FastTrack Legal.</p>

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #1A1B18;">
                    <tr>
                        <td style="padding: 6px 0; width: 120px; color: #686964;">Nama</td>
                        <td style="padding: 6px 0;">: {{ $data['name'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #686964;">Email</td>
                        <td style="padding: 6px 0;">: {{ $data['email'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #686964;">WhatsApp</td>
                        <td style="padding: 6px 0;">: {{ $data['whatsapp'] }}</td>
                    </tr>
                    @if (!empty($data['business']))
                        <tr>
                            <td style="padding: 6px 0; color: #686964; vertical-align: top;">Bidang Usaha</td>
                            <td style="padding: 6px 0;">: {{ $data['business'] }}</td>
                        </tr>
                    @endif
                </table>

                <div style="margin-top: 16px; padding: 16px; background-color: #F7F7F5; border-radius: 8px;">
                    <p style="margin: 0 0 6px; font-size: 12px; color: #686964; text-transform: uppercase; letter-spacing: 0.05em;">Pesan</p>
                    <p style="margin: 0; font-size: 13px; color: #1A1B18; white-space: pre-line;">{{ $data['message'] }}</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding: 16px 28px; background-color: #F7F7F5; text-align: center;">
                <span style="font-size: 11px; color: #9A9A97;">Dikirim otomatis dari formulir kontak fasttrack.legal</span>
            </td>
        </tr>
    </table>
</body>
</html>
