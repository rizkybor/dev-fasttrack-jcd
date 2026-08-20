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
        {
            value: 'pendirian-badan-usaha',
            label: 'Pendirian Badan Usaha Indonesia',
        },
        {
            value: 'kantor-perwakilan-asing',
            label: 'Kantor Perwakilan & Badan Usaha Asing',
        },
        {
            value: 'oss-nib',
            label: 'OSS & Nomor Induk Berusaha (NIB)',
        },
        {
            value: 'perizinan',
            label: 'Perizinan Dasar & Perizinan Berusaha',
        },
        {
            value: 'notaris-akta',
            label: 'Notaris - Akta Perusahaan/Perorangan',
        },
        {
            value: 'hukum-korporasi',
            label: 'Layanan Hukum Korporasi',
        },
        {
            value: 'penutupan-badan-usaha',
            label: 'Pembubaran Badan Usaha',
        },
        {
            value: 'legalisasi-terjemahan',
            label: 'Legalisasi, Apostille & Terjemahan',
        },
        {
            value: 'kekayaan-intelektual',
            label: 'Hak Kekayaan Intelektual',
        },
        {
            value: 'keimigrasian-visa',
            label: 'Keimigrasian & Visa',
        },
        {
            value: 'perpajakan-kepatuhan',
            label: 'Perpajakan & Kepatuhan Perusahaan',
        },
        {
            value: 'sertifikasi-lainnya',
            label: 'Sertifikasi & Layanan Lainnya',
        },
    ],
    layanan_by_kategori: {
        'pendirian-badan-usaha': [
            {
                value: 'badan-usaha',
                label: 'Badan Usaha',
            },
        ],
        'kantor-perwakilan-asing': [
            {
                value: 'kantor-perwakilan',
                label: 'Kantor Perwakilan',
            },
            {
                value: 'badan-usaha-luar-negeri',
                label: 'Badan Usaha Luar Negeri',
            },
        ],
        'oss-nib': [
            {
                value: 'oss-nib-layanan',
                label: 'Pendaftaran & Perubahan NIB',
            },
        ],
        perizinan: [
            {
                value: 'perizinan-berusaha',
                label: 'Perizinan Berusaha',
            },
            {
                value: 'perizinan-lainnya',
                label: 'Perizinan Lainnya',
            },
        ],
        'notaris-akta': [
            {
                value: 'notaris-akta-layanan',
                label: 'Akta Notaris',
            },
        ],
        'hukum-korporasi': [
            {
                value: 'restrukturisasi-pt',
                label: 'Restrukturisasi Perseroan Terbatas',
            },
            {
                value: 'penyusunan-perjanjian',
                label: 'Penyusunan & Peninjauan Perjanjian',
            },
            {
                value: 'retainer-berlangganan',
                label: 'Retainer / Berlangganan',
            },
            {
                value: 'uji-tuntas-hukum',
                label: 'Uji Tuntas Hukum',
            },
        ],
        'penutupan-badan-usaha': [
            {
                value: 'penutupan-badan-usaha-layanan',
                label: 'Pembubaran / Penutupan Badan Usaha',
            },
        ],
        'legalisasi-terjemahan': [
            {
                value: 'legalisasi-apostille',
                label: 'Legalisasi Kedutaan / Apostille',
            },
            {
                value: 'penerjemah',
                label: 'Penerjemah / Translator',
            },
        ],
        'kekayaan-intelektual': [
            {
                value: 'kekayaan-intelektual-layanan',
                label: 'Kekayaan Intelektual',
            },
        ],
        'keimigrasian-visa': [
            {
                value: 'visa-indonesia',
                label: 'Visa Indonesia',
            },
            {
                value: 'visa-mancanegara',
                label: 'Visa Mancanegara',
            },
            {
                value: 'izin-tinggal-terbatas',
                label: 'Izin Tinggal Terbatas (ITAS)',
            },
            {
                value: 'izin-tinggal-tetap',
                label: 'Izin Tinggal Tetap (ITAP)',
            },
            {
                value: 'keimigrasian-wni-wna',
                label: 'Keimigrasian WNI/WNA',
            },
            {
                value: 'naturalisasi',
                label: 'Naturalisasi',
            },
        ],
        'perpajakan-kepatuhan': [
            {
                value: 'perpajakan-pembukuan',
                label: 'Perpajakan & Pembukuan',
            },
            {
                value: 'kewajiban-pelaporan',
                label: 'Kewajiban Pelaporan Perusahaan',
            },
        ],
        'sertifikasi-lainnya': [
            {
                value: 'sertifikasi-badan-usaha',
                label: 'Sertifikasi Badan Usaha',
            },
            {
                value: 'digital-marketing',
                label: 'Digital Marketing & Design',
            },
            {
                value: 'virtual-office',
                label: 'Virtual Office',
            },
        ],
    },
    detail_by_layanan: {
        'badan-usaha': [
            {
                value: 'pt-perorangan',
                label: 'PT Perorangan',
                harga: 750000,
            },
            {
                value: 'pt-pmdn',
                label: 'Pendirian PT PMDN',
                harga: 3250000,
            },
            {
                value: 'pt-pma',
                label: 'PT Pendirian PMA',
                harga: 17250000,
            },
            {
                value: 'cv',
                label: 'Pendirian CV',
                harga: 2750000,
            },
            {
                value: 'yayasan',
                label: 'Pendirian Yayasan',
                harga: 3250000,
            },
            {
                value: 'koperasi',
                label: 'Pendirian Koperasi',
                harga: 9750000,
            },
            {
                value: 'persekutuan-perdata',
                label: 'Persekutuan Perdata',
                harga: 2750000,
            },
            {
                value: 'persekutuan-firma',
                label: 'Persekutuan Firma',
                harga: 2750000,
            },
        ],
        'kantor-perwakilan': [
            {
                value: 'kppa',
                label: 'Kantor Perwakilan Perusahaan Asing (KPPA)',
                harga: 4500000,
            },
            {
                value: 'kp3a-perdagangan',
                label: 'Kantor Perwakilan Perusahaan Perdagangan Asing',
                harga: 4500000,
            },
            {
                value: 'kp3a-pmse',
                label: 'KP3A Perdagangan Melalui Sistem Elektronik',
                harga: 3500000,
            },
            {
                value: 'bujka',
                label: 'Kantor Perwakilan Badan Usaha Jasa Konstruksi Asing',
                harga: 3500000,
            },
        ],
        'badan-usaha-luar-negeri': [
            {
                value: 'pemberi-waralaba',
                label: 'Pemberi Waralaba (Surat Tanda Pendaftaran Waralaba)',
                harga: 9000000,
            },
            {
                value: 'pse-asing',
                label: 'Penyelenggara Sistem Elektronik Asing',
                harga: 3500000,
            },
        ],
        'oss-nib-layanan': [
            {
                value: 'pendaftaran-nib',
                label: 'Pendaftaran Nomor Induk Berusaha (NIB)',
                harga: 1000000,
            },
            {
                value: 'perubahan-nib',
                label: 'Perubahan/Pemutakhiran NIB',
                harga: 1000000,
            },
        ],
        'perizinan-berusaha': [
            {
                value: 'perizinan-dasar',
                label: 'Perizinan Dasar',
                harga: null,
            },
            {
                value: 'sertifikat-standar',
                label: 'Perizinan Berusaha (Sertifikat Standar/Izin)',
                harga: null,
            },
            {
                value: 'pb-umku',
                label: 'Perizinan Berusaha Untuk Menunjang Kegiatan Usaha (PB UMKU)',
                harga: 2000000,
            },
        ],
        'perizinan-lainnya': [
            {
                value: 'npwp',
                label: 'Nomor Pokok Wajib Pajak (NPWP)',
                harga: 1250000,
            },
            {
                value: 'sp-pkp',
                label: 'Surat Pengukuhan Pengusaha Kena Pajak (SP PKP)',
                harga: 1750000,
            },
            {
                value: 'lks',
                label: 'Tanda Daftar Lembaga Kesejahteraan Sosial (LKS)',
                harga: null,
            },
            {
                value: 'izin-lks-dki',
                label: 'Izin Kegiatan LKS Daerah/Lokal — DKI Jakarta',
                harga: null,
            },
            {
                value: 'daftar-yayasan',
                label: 'Tanda Daftar Yayasan',
                harga: null,
            },
            {
                value: 'peraturan-perusahaan',
                label: 'Peraturan Perusahaan',
                harga: null,
            },
        ],
        'notaris-akta-layanan': [
            {
                value: 'perubahan-anggaran-dasar',
                label: 'Perubahan Anggaran Dasar Perseroan',
                harga: 3500000,
            },
            {
                value: 'perubahan-data-perseroan',
                label: 'Perubahan Data Perseroan',
                harga: 1750000,
            },
            {
                value: 'rups-tahunan',
                label: 'Rapat Umum Pemegang Saham Tahunan',
                harga: 3000000,
            },
            {
                value: 'akta-lainnya',
                label: 'Akta Notaris Lainnya',
                harga: 750000,
            },
        ],
        'restrukturisasi-pt': [
            {
                value: 'akuisisi',
                label: 'Pengambilalihan Perseroan (Akuisisi)',
                harga: 9000000,
            },
            {
                value: 'merger',
                label: 'Penggabungan Perseroan (Merger)',
                harga: 9000000,
            },
            {
                value: 'alih-status',
                label: 'Alih Status Perseroan',
                harga: 9000000,
            },
        ],
        'penyusunan-perjanjian': [
            {
                value: 'penyusunan-kontrak',
                label: 'Penyusunan & Peninjauan Perjanjian / Kontrak',
                harga: 500000,
            },
        ],
        'retainer-berlangganan': [
            {
                value: 'retainer',
                label: 'Retainer / Berlangganan',
                harga: 2000000,
            },
        ],
        'uji-tuntas-hukum': [
            {
                value: 'uji-tuntas',
                label: 'Uji Tuntas Hukum',
                harga: null,
            },
        ],
        'penutupan-badan-usaha-layanan': [
            {
                value: 'pembubaran-pt',
                label: 'Pembubaran Perseroan',
                harga: 12000000,
            },
            {
                value: 'penutupan-cv',
                label: 'Penutupan CV',
                harga: 7000000,
            },
            {
                value: 'penutupan-kantor-perwakilan',
                label: 'Penutupan Kantor Perwakilan',
                harga: 3000000,
            },
        ],
        'legalisasi-apostille': [
            {
                value: 'legalisasi-kedutaan',
                label: 'Legalisasi Kedutaan',
                harga: 4500000,
            },
            {
                value: 'apostille',
                label: 'Apostille',
                harga: null,
            },
        ],
        penerjemah: [
            {
                value: 'penerjemah-tersumpah',
                label: 'Penerjemah Tersumpah (Sworn Translator)',
                harga: 50000,
            },
        ],
        'kekayaan-intelektual-layanan': [
            {
                value: 'merek',
                label: 'Pendaftaran Merek',
                harga: 3000000,
            },
            {
                value: 'perpanjangan-merek',
                label: 'Perpanjangan Merek',
                harga: 3000000,
            },
            {
                value: 'hak-cipta',
                label: 'Hak Cipta',
                harga: 3000000,
            },
        ],
        'visa-indonesia': [
            {
                value: 'visa-kunjungan-1x',
                label: 'Visa Kunjungan Satu Kali Perjalanan',
                harga: 2000000,
            },
            {
                value: 'visa-kunjungan-multi',
                label: 'Visa Kunjungan Beberapa Kali Perjalanan',
                harga: 3500000,
            },
            {
                value: 'visa-investor',
                label: 'Visa Investor',
                harga: 12750000,
            },
            {
                value: 'visa-keluarga',
                label: 'Visa Keluarga',
                harga: 9050000,
            },
            {
                value: 'visa-repatriasi',
                label: 'Visa Repatriasi Dan Keturunan EX-WNI',
                harga: 12750000,
            },
            {
                value: 'visa-rumah-kedua',
                label: 'Visa Rumah Kedua',
                harga: 19750000,
            },
        ],
        'visa-mancanegara': [
            {
                value: 'visa-china',
                label: 'Visa China',
                harga: 1000000,
            },
            {
                value: 'visa-usa',
                label: 'Visa United State Of America',
                harga: 1000000,
            },
            {
                value: 'visa-uea',
                label: 'Visa Uni Emirat Arab',
                harga: 1000000,
            },
            {
                value: 'visa-australia',
                label: 'Visa Australia',
                harga: 1000000,
            },
            {
                value: 'visa-taiwan',
                label: 'Visa Taiwan',
                harga: 1000000,
            },
            {
                value: 'visa-korsel',
                label: 'Visa Korea Selatan',
                harga: 1000000,
            },
            {
                value: 'visa-india',
                label: 'Visa India',
                harga: 1000000,
            },
            {
                value: 'visa-uk',
                label: 'Visa United Kingdom (Inggris)',
                harga: 1000000,
            },
            {
                value: 'visa-afsel',
                label: 'Visa Afrika Selatan',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-jerman',
                label: 'Visa Schengen – Germany',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-italia',
                label: 'Visa Schengen – Italy',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-selandia-baru',
                label: 'Visa Schengen – New Zealand',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-swedia',
                label: 'Visa Schengen – Sweden',
                harga: 1000000,
            },
            {
                value: 'visa-jepang',
                label: 'Visa Jepang',
                harga: 1000000,
            },
        ],
        'izin-tinggal-terbatas': [
            {
                value: 'itas-kerja-tka',
                label: 'Izin Tinggal & Kerja Tenaga Kerja Asing',
                harga: 9050000,
            },
            {
                value: 'itas-keluarga-tka',
                label: 'Izin Tinggal Keluarga Tenaga Kerja Asing',
                harga: 9050000,
            },
            {
                value: 'itas-investor',
                label: 'Izin Tinggal Terbatas Investor',
                harga: 4500000,
            },
            {
                value: 'itas-lansia',
                label: 'Izin Tinggal Terbatas Lansia',
                harga: 7000000,
            },
        ],
        'izin-tinggal-tetap': [
            {
                value: 'itap-sponsor-perusahaan',
                label: 'Alih Status Izin Tinggal Terbatas ke Izin Tinggal Tetap Sponsor Perusahaan',
                harga: 4500000,
            },
            {
                value: 'itap-sponsor-pasangan',
                label: 'Alih Status Izin Tinggal Terbatas ke Izin Tinggal Tetap Sponsor Suami/Istri WNI',
                harga: 3500000,
            },
        ],
        'keimigrasian-wni-wna': [
            {
                value: 'e-paspor',
                label: 'E-Paspor Republik Indonesia',
                harga: 3150000,
            },
            {
                value: 'mutasi-alamat',
                label: 'Mutasi Alamat',
                harga: 1750000,
            },
            {
                value: 'mutasi-paspor-itas',
                label: 'Mutasi Paspor Pemegang Itas',
                harga: 1750000,
            },
            {
                value: 'epo',
                label: 'Exit Permit Only (EPO)',
                harga: 4000000,
            },
            {
                value: 'tsp',
                label: 'Exit Termination Of Stay Permit (TSP)',
                harga: 3750000,
            },
        ],
        naturalisasi: [
            {
                value: 'naturalisasi',
                label: 'Naturalisasi (Alih Kewarganegaraan)',
                harga: null,
            },
        ],
        'perpajakan-pembukuan': [
            {
                value: 'akuntansi-pajak',
                label: 'Akuntansi & Pelaporan Pajak',
                harga: 4000000,
            },
            {
                value: 'lapor-spt-pribadi',
                label: 'Jasa Lapor SPT Pribadi',
                harga: 2500000,
            },
            {
                value: 'lapor-spt-badan',
                label: 'Jasa Lapor SPT Badan',
                harga: 4500000,
            },
        ],
        'kewajiban-pelaporan': [
            {
                value: 'lkpm',
                label: 'Laporan Kegiatan Penanaman Modal (LKPM)',
                harga: 1000000,
            },
            {
                value: 'siinas',
                label: 'Laporan Industri (SIINAS)',
                harga: 1750000,
            },
            {
                value: 'wajib-lapor-ketenagakerjaan',
                label: 'Wajib Lapor Ketenagakerjaan Perusahaan',
                harga: 1500000,
            },
            {
                value: 'wajib-lapor-fasilitas-kesejahteraan',
                label: 'Wajib Lapor Fasilitas Kesejahteraan Pekerja',
                harga: 2000000,
            },
        ],
        'sertifikasi-badan-usaha': [
            {
                value: 'sbu-jasa-konstruksi',
                label: 'Sertifikasi Badan Usaha Jasa Konstruksi',
                harga: 2500000,
            },
        ],
        'digital-marketing': [
            {
                value: 'design',
                label: 'Design',
                harga: 9000000,
            },
            {
                value: 'digital-marketing',
                label: 'Digital Marketing',
                harga: 3500000,
            },
        ],
        'virtual-office': [
            {
                value: 'virtual-office',
                label: 'Virtual Office',
                harga: 2000000,
            },
        ],
    },
    biaya: {
        title: 'Biaya Layanan',
        biaya_label: 'Biaya Layanan',
        ppn_label: 'PPN 11%',
        subtotal_label: 'Subtotal',
        note: 'Harga diatas belum termasuk biaya lain. Rincian lengkap dapat dilihat di halaman detail layanan.',
        empty: 'Pilih layanan terlebih dahulu untuk melihat rincian biaya.',
        hubungi_kami: 'Hubungi Kami',
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
    submit_cta: 'Minta Penawaran',
    submitting: 'Mengirim...',
    info_box: 'Pengajuan kamu akan dibuatkan akun ke Dashboard Pelanggan. Login ke Dashboard Pelanggan akan menggunakan OTP melalui Whatsapp. Pastikan kamu menggunakan nomor Whatsapp yang aktif.',
    errors: {
        kategori_required: 'Pilih kategori, layanan, dan detail layanan terlebih dahulu.',
        nama_required: 'Nama wajib diisi.',
        email_required: 'Alamat email wajib diisi.',
        email_invalid: 'Format alamat email tidak valid.',
        whatsapp_required: 'Nomor WhatsApp wajib diisi.',
        whatsapp_invalid: 'Nomor WhatsApp harus berupa angka, minimal 10 dan maksimal 13 digit.',
    },
    close: 'Tutup',
    submit_success_title: 'Berhasil Terkirim!',
    submit_success: 'Permintaan penawaran Anda berhasil dikirim. Tim kami akan segera menghubungi Anda.',
    submit_error: 'Gagal mengirim permintaan penawaran. Silakan coba lagi.',
    cta: {
        title: 'Butuh Penjelasan Lebih Spesifik?',
        desc: 'Tim kami siap membantu Anda menemukan solusi yang tepat untuk kebutuhan legalitas bisnis Anda.',
        whatsapp: 'Chat Langsung via Whatsapp',
    },
}
