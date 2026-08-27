// Mapping id (dari data list i18n & JSON produk) -> slug URL, per grup layanan.
// Dipakai oleh halaman Index.vue untuk membangun link detail berbasis slug,
// menggantikan link lama yang berbasis ID numerik (mis. /badan-usaha/1).
export default {
    "badan-usaha": {
        1: "pt-perorangan",
        2: "pendirian-pt-pmdn",
        3: "pt-pendirian-pma",
        4: "pendirian-cv",
        5: "pendirian-yayasan",
        6: "pendirian-koperasi",
        7: "persekutuan-perdata",
        8: "persekutuan-firma",
    },
    "kantor-perwakilan": {
        1: "kantor-perwakilan-perusahaan-asing-kppa",
        2: "kantor-perwakilan-perusahaan-perdagangan-asing",
        3: "kp3a-perdagangan-melalui-sistem-elektronik",
        4: "kantor-perwakilan-badan-usaha-jasa-konstruksi-asing",
    },
    "penyusunan-peninjauan": {
        1: "penyusunan-peninjauan-perjanjian-kontrak",
    },
    "retainer-berlangganan": {
        1: "retainer-berlangganan",
    },
    "izin-tinggal-terbatas": {
        1: "izin-tinggal-kerja-tenaga-kerja-asing",
        2: "izin-tinggal-keluarga-tenaga-kerja-asing",
        3: "izin-tinggal-terbatas-investor",
        4: "izin-tinggal-terbatas-lansia",
    },
    "izin-tinggal-tetap": {
        1: "itap-sponsor-perusahaan",
        2: "itap-sponsor-suami-istri-wni",
    },
    "badan-usaha-luar-negeri": {
        1: "pemberi-waralaba-surat-tanda-pendaftaran-waralaba",
        2: "penyelenggara-sistem-elektronik-asing",
    },
    "one-single-submission": {
        1: "pendaftaran-nomor-induk-berusaha-nib",
        2: "perubahan-pemutakhiran-nib",
    },
    "kewajiban-pelaporan-perusahaan": {
        1: "laporan-kegiatan-penanaman-modal-lkpm",
        2: "laporan-industri-siinas",
        3: "wajib-lapor-ketenagakerjaan-perusahaan",
        4: "wajib-lapor-fasilitas-kesejahteraan-pekerja",
    },
    "legalisasi-kedutaan": {
        1: "legalisasi-kedutaan",
        2: "apostille",
    },
    "kekayaan-intelektual": {
        1: "pendaftaran-merek",
        2: "perpanjangan-merek",
        3: "hak-cipta",
    },
    "perizinan-lainnya": {
        1: "nomor-pokok-wajib-pajak-npwp",
        2: "surat-pengukuhan-pengusaha-kena-pajak-sp-pkp",
        3: "tanda-daftar-lembaga-kesejahteraan-sosial-lks",
        4: "izin-kegiatan-lks-daerah-lokal-dki-jakarta",
        5: "tanda-daftar-yayasan",
        6: "peraturan-perusahaan",
    },
    "perizinan-berusaha": {
        1: "perizinan-dasar",
        2: "perizinan-berusaha-sertifikat-standar-izin",
        3: "perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku",
    },
    "notaris-virtual-dan-akta": {
        1: "perubahan-anggaran-dasar-perseroan",
        2: "perubahan-data-perseroan",
        3: "rapat-umum-pemegang-saham-tahunan",
        4: "akta-notaris-lainnya",
    },
    "restrukturisasi-perseroan-terbatas": {
        1: "pengambilalihan-perseroan-akuisisi",
        2: "penggabungan-perseroan-merger",
        3: "alih-status-perseroan",
    },
    "penutupan-badan-usaha": {
        1: "pembubaran-perseroan",
        2: "penutupan-cv",
        3: "penutupan-kantor-perwakilan",
    },
    "keimigrasian-wni-wna": {
        1: "e-paspor-republik-indonesia",
        2: "mutasi-alamat",
        3: "mutasi-paspor-pemegang-itas",
        4: "exit-permit-only-epo",
        5: "exit-termination-of-stay-permit-tsp",
    },
    "sertifikasi-badan-usaha": {
        1: "sertifikasi-badan-usaha-jasa-konstruksi",
    },
    "visa-mancanegara": {
        1: "visa-china",
        2: "visa-united-state-of-america",
        3: "visa-uni-emirat-arab",
        4: "visa-australia",
        5: "visa-taiwan",
        6: "visa-korea-selatan",
        7: "visa-india",
        8: "visa-united-kingdom-inggris",
        9: "visa-afrika-selatan",
        10: "visa-schengen-germany",
        11: "visa-schengen-italy",
        12: "visa-schengen-new-zealand",
        13: "visa-schengen-sweden",
        14: "visa-jepang",
    },
    "visa-indonesia": {
        1: "visa-kunjungan-satu-kali-perjalanan",
        2: "visa-kunjungan-beberapa-kali-perjalanan",
        3: "visa-investor",
        4: "visa-keluarga",
        5: "visa-repatriasi-dan-keturunan-ex-wni",
        6: "visa-rumah-kedua",
    },
    "virtual-office": {
        1: "virtual-office",
    },
    "digital-marketing": {
        1: "design",
        2: "digital-marketing",
    },
    naturalisasi: {
        1: "naturalisasi-alih-kewarganegaraan",
    },
    "perpajakan-dan-pembukuan": {
        1: "akuntansi-pelaporan-pajak",
        2: "jasa-lapor-spt-pribadi",
        3: "jasa-lapor-spt-badan",
    },
};
