export default {
    hero: {
        breadcrumb: 'Minta Penawaran',
        title: 'Penawaran Fasttrack',
        desc: 'Langkah cepat kamu untuk mendapatkan layanan FASTTRACK.',
    },
    pilih_layanan: {
        link: 'Pilih Layanan',
        kategori_label: 'Kategori',
        kategori_placeholder: 'Pilih kategori',
        layanan_label: 'Layanan',
        layanan_placeholder: 'Pilih layanan',
        detail_label: 'Detail Layanan',
        detail_placeholder: 'Pilih detail layanan',
        starting_from: 'Mulai dari',
        empty_state: 'Pilih kategori, layanan, dan detail layanan untuk melihat ringkasan penawaran.',
    },
    kategori_options: [
        { value: 'pendirian-badan-usaha', label: 'Pendirian Badan Usaha' },
        { value: 'perizinan', label: 'Perizinan' },
        { value: 'keimigrasian', label: 'Keimigrasian' },
        { value: 'perpajakan', label: 'Perpajakan & Pembukuan' },
    ],
    layanan_by_kategori: {
        'pendirian-badan-usaha': [
            { value: 'pendirian-pt-perorangan', label: 'Pendirian PT Perorangan' },
            { value: 'pendirian-pt-pmdn', label: 'Pendirian PT PMDN' },
            { value: 'pendirian-pt-pma', label: 'Pendirian PT PMA' },
            { value: 'pendirian-cv', label: 'Pendirian CV' },
            { value: 'pendirian-yayasan', label: 'Pendirian Yayasan' },
        ],
        perizinan: [
            { value: 'nib', label: 'Nomor Induk Berusaha (NIB)' },
            { value: 'izin-usaha', label: 'Izin Usaha' },
        ],
        keimigrasian: [
            { value: 'kitas', label: 'KITAS' },
            { value: 'visa-kunjungan', label: 'Visa Kunjungan' },
        ],
        perpajakan: [
            { value: 'pembukuan-bulanan', label: 'Pembukuan Bulanan' },
            { value: 'lapor-pajak', label: 'Lapor Pajak Tahunan' },
        ],
    },
    detail_by_layanan: {
        'pendirian-pt-perorangan': [
            { value: 'standar', label: 'Pendirian PT Perorangan', harga: 3500000 },
        ],
        'pendirian-pt-pmdn': [
            { value: 'standar', label: 'Pendirian PT PMDN', harga: 5500000 },
        ],
        'pendirian-pt-pma': [
            { value: 'standar', label: 'Pendirian PT PMA', harga: 12000000 },
        ],
        'pendirian-cv': [
            { value: 'standar', label: 'Pendirian CV', harga: 3000000 },
        ],
        'pendirian-yayasan': [
            { value: 'standar', label: 'Pendirian Yayasan', harga: 6000000 },
        ],
        nib: [{ value: 'standar', label: 'Pengurusan NIB', harga: 1500000 }],
        'izin-usaha': [{ value: 'standar', label: 'Izin Usaha', harga: 2500000 }],
        kitas: [{ value: 'standar', label: 'KITAS', harga: 8000000 }],
        'visa-kunjungan': [
            { value: 'standar', label: 'Visa Kunjungan', harga: 1200000 },
        ],
        'pembukuan-bulanan': [
            { value: 'standar', label: 'Pembukuan Bulanan', harga: 1000000 },
        ],
        'lapor-pajak': [
            { value: 'standar', label: 'Lapor Pajak Tahunan', harga: 1500000 },
        ],
    },
    biaya: {
        title: 'Biaya Layanan',
        biaya_label: 'Biaya Layanan',
        ppn_label: 'PPN 11%',
        subtotal_label: 'Subtotal',
        note: 'Harga diatas belum termasuk biaya lain. Rincian lengkap dapat dilihat di halaman detail layanan.',
        empty: 'Pilih layanan terlebih dahulu untuk melihat rincian biaya.',
    },
    pemohon: {
        title: 'Pemohon',
        nama_label: 'Nama',
        nama_placeholder: 'Masukkan nama lengkap',
        perusahaan_label: 'Perusahaan',
        perusahaan_placeholder: 'Masukkan nama perusahaan',
        whatsapp_label: 'No Whatsapp',
        whatsapp_placeholder: 'Masukkan no whatsapp',
        email_label: 'Email',
        email_placeholder: 'Masukkan email',
    },
    captcha_label: "I'm not a robot",
    submit_cta: 'Minta Penawaran',
    info_box: 'Pengajuan kamu akan dibuatkan akun ke Dashboard Pelanggan. Login ke Dashboard Pelanggan akan menggunakan OTP melalui Whatsapp. Pastikan kamu menggunakan nomor Whatsapp yang aktif.',
    cta: {
        title: 'Butuh Penjelasan Lebih Spesifik?',
        desc: 'Tim kami siap membantu Anda menemukan solusi yang tepat untuk kebutuhan legalitas bisnis Anda.',
        whatsapp: 'Chat Langsung via Whatsapp',
    },
}
