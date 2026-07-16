export default {
    hero: {
        breadcrumb: 'Request a Quote',
        title: 'Fasttrack Offer',
        desc: 'Your quick step to getting FASTTRACK services.',
    },
    pilih_layanan: {
        link: 'Choose a Service',
        kategori_label: 'Category',
        kategori_placeholder: 'Select a category',
        layanan_label: 'Service',
        layanan_placeholder: 'Select a service',
        detail_label: 'Service Detail',
        detail_placeholder: 'Select a service detail',
        starting_from: 'Starting from',
        empty_state: 'Select a category, service, and service detail to see the offer summary.',
    },
    kategori_options: [
        {
            value: 'pendirian-badan-usaha',
            label: 'Indonesian Business Entity Establishment',
        },
        {
            value: 'kantor-perwakilan-asing',
            label: 'Representative Office & Foreign Business Entities',
        },
        {
            value: 'oss-nib',
            label: 'OSS & Business Identification Number (NIB)',
        },
        {
            value: 'perizinan',
            label: 'Basic Licensing & Business Licensing',
        },
        {
            value: 'notaris-akta',
            label: 'Notary - Corporate/Personal Deeds',
        },
        {
            value: 'hukum-korporasi',
            label: 'Corporate Legal Services',
        },
        {
            value: 'penutupan-badan-usaha',
            label: 'Business Entity Dissolution',
        },
        {
            value: 'legalisasi-terjemahan',
            label: 'Legalization, Apostille & Translation',
        },
        {
            value: 'kekayaan-intelektual',
            label: 'Intellectual Property Rights',
        },
        {
            value: 'keimigrasian-visa',
            label: 'Immigration & Visa',
        },
        {
            value: 'perpajakan-kepatuhan',
            label: 'Tax & Corporate Compliance',
        },
        {
            value: 'sertifikasi-lainnya',
            label: 'Certification & Other Services',
        },
    ],
    layanan_by_kategori: {
        'pendirian-badan-usaha': [
            {
                value: 'badan-usaha',
                label: 'Business Entity',
            },
        ],
        'kantor-perwakilan-asing': [
            {
                value: 'kantor-perwakilan',
                label: 'Representative Office',
            },
            {
                value: 'badan-usaha-luar-negeri',
                label: 'Foreign Business Entities',
            },
        ],
        'oss-nib': [
            {
                value: 'oss-nib-layanan',
                label: 'NIB Registration & Amendment',
            },
        ],
        perizinan: [
            {
                value: 'perizinan-berusaha',
                label: 'Business Licensing',
            },
            {
                value: 'perizinan-lainnya',
                label: 'Other Licenses',
            },
        ],
        'notaris-akta': [
            {
                value: 'notaris-akta-layanan',
                label: 'Notarial Deeds',
            },
        ],
        'hukum-korporasi': [
            {
                value: 'restrukturisasi-pt',
                label: 'Limited Liability Company Restructuring',
            },
            {
                value: 'penyusunan-perjanjian',
                label: 'Agreement Drafting & Review',
            },
            {
                value: 'retainer-berlangganan',
                label: 'Retainer / Subscription',
            },
            {
                value: 'uji-tuntas-hukum',
                label: 'Legal Due Diligence',
            },
        ],
        'penutupan-badan-usaha': [
            {
                value: 'penutupan-badan-usaha-layanan',
                label: 'Business Entity Dissolution / Closure',
            },
        ],
        'legalisasi-terjemahan': [
            {
                value: 'legalisasi-apostille',
                label: 'Embassy Legalization / Apostille',
            },
            {
                value: 'penerjemah',
                label: 'Translator',
            },
        ],
        'kekayaan-intelektual': [
            {
                value: 'kekayaan-intelektual-layanan',
                label: 'Intellectual Property',
            },
        ],
        'keimigrasian-visa': [
            {
                value: 'visa-indonesia',
                label: 'Indonesian Visa',
            },
            {
                value: 'visa-mancanegara',
                label: 'Overseas Visa',
            },
            {
                value: 'izin-tinggal-terbatas',
                label: 'Limited Stay Permit (ITAS)',
            },
            {
                value: 'izin-tinggal-tetap',
                label: 'Permanent Stay Permit (ITAP)',
            },
            {
                value: 'keimigrasian-wni-wna',
                label: 'Immigration for Indonesian/Foreign Citizens',
            },
            {
                value: 'naturalisasi',
                label: 'Naturalization',
            },
        ],
        'perpajakan-kepatuhan': [
            {
                value: 'perpajakan-pembukuan',
                label: 'Tax & Bookkeeping',
            },
            {
                value: 'kewajiban-pelaporan',
                label: 'Corporate Reporting Obligations',
            },
        ],
        'sertifikasi-lainnya': [
            {
                value: 'sertifikasi-badan-usaha',
                label: 'Business Entity Certification',
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
                label: 'Establishment of PT PMDN',
                harga: 3250000,
            },
            {
                value: 'pt-pma',
                label: 'Establishment of PT PMA',
                harga: 17250000,
            },
            {
                value: 'cv',
                label: 'Establishment of CV',
                harga: 2750000,
            },
            {
                value: 'yayasan',
                label: 'Establishment of a Foundation (Yayasan)',
                harga: 3250000,
            },
            {
                value: 'koperasi',
                label: 'Establishment of a Cooperative (Koperasi)',
                harga: 9750000,
            },
            {
                value: 'persekutuan-perdata',
                label: 'Civil Partnership (Persekutuan Perdata)',
                harga: 2750000,
            },
            {
                value: 'persekutuan-firma',
                label: 'General Partnership (Firma)',
                harga: 2750000,
            },
        ],
        'kantor-perwakilan': [
            {
                value: 'kppa',
                label: 'Foreign Company Representative Office (KPPA)',
                harga: 4500000,
            },
            {
                value: 'kp3a-perdagangan',
                label: 'Foreign Trading Company Representative Office (KP3A)',
                harga: 4500000,
            },
            {
                value: 'kp3a-pmse',
                label: 'KP3A for Trade Through Electronic Systems',
                harga: 3500000,
            },
            {
                value: 'bujka',
                label: 'Foreign Construction Services Business Entity Representative Office (BUJKA)',
                harga: 3500000,
            },
        ],
        'badan-usaha-luar-negeri': [
            {
                value: 'pemberi-waralaba',
                label: 'Franchisor (Franchise Registration Certificate)',
                harga: 9000000,
            },
            {
                value: 'pse-asing',
                label: 'Foreign Electronic System Provider',
                harga: 3500000,
            },
        ],
        'oss-nib-layanan': [
            {
                value: 'pendaftaran-nib',
                label: 'Business Identification Number (NIB) Registration',
                harga: 1000000,
            },
            {
                value: 'perubahan-nib',
                label: 'NIB Amendment/Update',
                harga: 1000000,
            },
        ],
        'perizinan-berusaha': [
            {
                value: 'perizinan-dasar',
                label: 'Basic Licensing',
                harga: null,
            },
            {
                value: 'sertifikat-standar',
                label: 'Business Licensing (Standard Certificate/License)',
                harga: null,
            },
            {
                value: 'pb-umku',
                label: 'Business Licensing to Support Business Activities (PB UMKU)',
                harga: 2000000,
            },
        ],
        'perizinan-lainnya': [
            {
                value: 'npwp',
                label: 'Taxpayer Identification Number (NPWP)',
                harga: 1250000,
            },
            {
                value: 'sp-pkp',
                label: 'Taxable Entrepreneur Confirmation Letter (SP PKP)',
                harga: 1750000,
            },
            {
                value: 'lks',
                label: 'Social Welfare Institution Registration Certificate (LKS)',
                harga: null,
            },
            {
                value: 'izin-lks-dki',
                label: 'Regional/Local LKS Activity Permit — DKI Jakarta',
                harga: null,
            },
            {
                value: 'daftar-yayasan',
                label: 'Foundation Registration Certificate',
                harga: null,
            },
            {
                value: 'peraturan-perusahaan',
                label: 'Company Regulations',
                harga: null,
            },
        ],
        'notaris-akta-layanan': [
            {
                value: 'perubahan-anggaran-dasar',
                label: 'Amendment to the Company\'s Articles of Association',
                harga: 3500000,
            },
            {
                value: 'perubahan-data-perseroan',
                label: 'Company Data Amendment',
                harga: 1750000,
            },
            {
                value: 'rups-tahunan',
                label: 'Annual General Meeting of Shareholders',
                harga: 3000000,
            },
            {
                value: 'akta-lainnya',
                label: 'Other Notarial Deeds',
                harga: 750000,
            },
        ],
        'restrukturisasi-pt': [
            {
                value: 'akuisisi',
                label: 'Company Acquisition (Takeover)',
                harga: 9000000,
            },
            {
                value: 'merger',
                label: 'Company Merger',
                harga: 9000000,
            },
            {
                value: 'alih-status',
                label: 'Company Status Conversion',
                harga: 9000000,
            },
        ],
        'penyusunan-perjanjian': [
            {
                value: 'penyusunan-kontrak',
                label: 'Drafting & Review of Agreements / Contracts',
                harga: 500000,
            },
        ],
        'retainer-berlangganan': [
            {
                value: 'retainer',
                label: 'Retainer / Subscription',
                harga: 2000000,
            },
        ],
        'uji-tuntas-hukum': [
            {
                value: 'uji-tuntas',
                label: 'Legal Due Diligence',
                harga: null,
            },
        ],
        'penutupan-badan-usaha-layanan': [
            {
                value: 'pembubaran-pt',
                label: 'Dissolution of the Company',
                harga: 12000000,
            },
            {
                value: 'penutupan-cv',
                label: 'Closure of a CV',
                harga: 7000000,
            },
            {
                value: 'penutupan-kantor-perwakilan',
                label: 'Closure of Representative Office',
                harga: 3000000,
            },
        ],
        'legalisasi-apostille': [
            {
                value: 'legalisasi-kedutaan',
                label: 'Embassy Legalization',
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
                label: 'Sworn Translator',
                harga: 50000,
            },
        ],
        'kekayaan-intelektual-layanan': [
            {
                value: 'merek',
                label: 'Trademark Registration',
                harga: 3000000,
            },
            {
                value: 'perpanjangan-merek',
                label: 'Trademark Renewal',
                harga: 3000000,
            },
            {
                value: 'hak-cipta',
                label: 'Copyright',
                harga: 3000000,
            },
        ],
        'visa-indonesia': [
            {
                value: 'visa-kunjungan-1x',
                label: 'Single-Entry Visit Visa',
                harga: 2000000,
            },
            {
                value: 'visa-kunjungan-multi',
                label: 'Multiple-Entry Visit Visa',
                harga: 3500000,
            },
            {
                value: 'visa-investor',
                label: 'Investor Visa',
                harga: 12750000,
            },
            {
                value: 'visa-keluarga',
                label: 'Family Visa',
                harga: 9050000,
            },
            {
                value: 'visa-repatriasi',
                label: 'Repatriation Visa for Former Indonesian Citizens and Their Descendants',
                harga: 12750000,
            },
            {
                value: 'visa-rumah-kedua',
                label: 'Second Home Visa',
                harga: 19750000,
            },
        ],
        'visa-mancanegara': [
            {
                value: 'visa-china',
                label: 'China Visa',
                harga: 1000000,
            },
            {
                value: 'visa-usa',
                label: 'United States of America Visa',
                harga: 1000000,
            },
            {
                value: 'visa-uea',
                label: 'United Arab Emirates Visa',
                harga: 1000000,
            },
            {
                value: 'visa-australia',
                label: 'Australia Visa',
                harga: 1000000,
            },
            {
                value: 'visa-taiwan',
                label: 'Taiwan Visa',
                harga: 1000000,
            },
            {
                value: 'visa-korsel',
                label: 'South Korea Visa',
                harga: 1000000,
            },
            {
                value: 'visa-india',
                label: 'India Visa',
                harga: 1000000,
            },
            {
                value: 'visa-uk',
                label: 'United Kingdom (UK) Visa',
                harga: 1000000,
            },
            {
                value: 'visa-afsel',
                label: 'South Africa Visa',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-jerman',
                label: 'Schengen Visa – Germany',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-italia',
                label: 'Schengen Visa – Italy',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-selandia-baru',
                label: 'Schengen Visa – New Zealand',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-swedia',
                label: 'Schengen Visa – Sweden',
                harga: 1000000,
            },
            {
                value: 'visa-jepang',
                label: 'Japan Visa',
                harga: 1000000,
            },
        ],
        'izin-tinggal-terbatas': [
            {
                value: 'itas-kerja-tka',
                label: 'Foreign Worker Stay & Work Permit',
                harga: 9050000,
            },
            {
                value: 'itas-keluarga-tka',
                label: 'Foreign Worker Family Stay Permit',
                harga: 9050000,
            },
            {
                value: 'itas-investor',
                label: 'Investor Limited Stay Permit',
                harga: 4500000,
            },
            {
                value: 'itas-lansia',
                label: 'Elderly Limited Stay Permit',
                harga: 3500000,
            },
        ],
        'izin-tinggal-tetap': [
            {
                value: 'itap-sponsor-perusahaan',
                label: 'Conversion of Limited Stay Permit to Permanent Stay Permit with Company Sponsorship',
                harga: 4500000,
            },
            {
                value: 'itap-sponsor-pasangan',
                label: 'Conversion of Limited Stay Permit to Permanent Stay Permit Sponsored by an Indonesian Spouse',
                harga: 3500000,
            },
        ],
        'keimigrasian-wni-wna': [
            {
                value: 'e-paspor',
                label: 'Republic of Indonesia E-Passport',
                harga: 3150000,
            },
            {
                value: 'mutasi-alamat',
                label: 'Address Change',
                harga: 1750000,
            },
            {
                value: 'mutasi-paspor-itas',
                label: 'Passport Change for ITAS Holders',
                harga: 1750000,
            },
            {
                value: 'epo',
                label: 'Exit Permit Only (EPO)',
                harga: 4000000,
            },
            {
                value: 'tsp',
                label: 'Exit Termination of Stay Permit (TSP)',
                harga: 3750000,
            },
        ],
        naturalisasi: [
            {
                value: 'naturalisasi',
                label: 'Naturalization (Citizenship Transfer)',
                harga: null,
            },
        ],
        'perpajakan-pembukuan': [
            {
                value: 'akuntansi-pajak',
                label: 'Accounting & Tax Reporting',
                harga: 4000000,
            },
            {
                value: 'lapor-spt-pribadi',
                label: 'Personal Tax Return Filing Service',
                harga: 2500000,
            },
            {
                value: 'lapor-spt-badan',
                label: 'Corporate Tax Return Filing Service',
                harga: 4500000,
            },
        ],
        'kewajiban-pelaporan': [
            {
                value: 'lkpm',
                label: 'Investment Activity Report (LKPM)',
                harga: 1000000,
            },
            {
                value: 'siinas',
                label: 'Industry Report (SIINAS)',
                harga: 1750000,
            },
            {
                value: 'wajib-lapor-ketenagakerjaan',
                label: 'Mandatory Company Employment Report',
                harga: 1500000,
            },
            {
                value: 'wajib-lapor-fasilitas-kesejahteraan',
                label: 'Mandatory Worker Welfare Facility Report',
                harga: 2000000,
            },
        ],
        'sertifikasi-badan-usaha': [
            {
                value: 'sbu-jasa-konstruksi',
                label: 'Construction Services Business Entity Certification',
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
        title: 'Service Cost',
        biaya_label: 'Service Fee',
        ppn_label: 'VAT 11%',
        subtotal_label: 'Subtotal',
        note: 'The price above does not include other fees. Full details can be seen on the service detail page.',
        empty: 'Select a service first to see the cost breakdown.',
        hubungi_kami: 'Contact Us',
    },
    pemohon: {
        title: 'Applicant',
        nama_label: 'Name',
        nama_placeholder: 'Enter your full name',
        perusahaan_label: 'Company',
        perusahaan_placeholder: 'Enter your company name',
        whatsapp_label: 'WhatsApp Number',
        whatsapp_placeholder: 'Enter your WhatsApp number',
        email_label: 'Email',
        email_placeholder: 'Enter your email',
    },
    submit_cta: 'Request a Quote',
    submitting: 'Sending...',
    info_box: 'Your submission will create an account on the Customer Dashboard. Logging in to the Customer Dashboard uses OTP via WhatsApp. Make sure you use an active WhatsApp number.',
    errors: {
        kategori_required: 'Please select a category, service, and service detail first.',
        nama_required: 'Name is required.',
        email_required: 'Email address is required.',
        email_invalid: 'Please enter a valid email address.',
        whatsapp_required: 'WhatsApp number is required.',
        whatsapp_invalid: 'WhatsApp number must be numeric, between 10 and 13 digits.',
    },
    submit_success: 'Your quote request has been sent successfully. Our team will contact you shortly.',
    submit_error: 'Failed to send your quote request. Please try again.',
    cta: {
        title: 'Need a More Specific Explanation?',
        desc: 'Our team is ready to help you find the right solution for your business legal needs.',
        whatsapp: 'Chat Directly via WhatsApp',
    },
}
