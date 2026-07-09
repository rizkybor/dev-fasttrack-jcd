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
        { value: 'pendirian-badan-usaha', label: 'Business Entity Incorporation' },
        { value: 'perizinan', label: 'Licensing' },
        { value: 'keimigrasian', label: 'Immigration' },
        { value: 'perpajakan', label: 'Tax & Bookkeeping' },
    ],
    layanan_by_kategori: {
        'pendirian-badan-usaha': [
            { value: 'pendirian-pt-perorangan', label: 'Individual PT Incorporation' },
            { value: 'pendirian-pt-pmdn', label: 'PT PMDN Incorporation' },
            { value: 'pendirian-pt-pma', label: 'PT PMA Incorporation' },
            { value: 'pendirian-cv', label: 'CV Incorporation' },
            { value: 'pendirian-yayasan', label: 'Foundation Incorporation' },
        ],
        perizinan: [
            { value: 'nib', label: 'Business Identification Number (NIB)' },
            { value: 'izin-usaha', label: 'Business License' },
        ],
        keimigrasian: [
            { value: 'kitas', label: 'KITAS' },
            { value: 'visa-kunjungan', label: 'Visit Visa' },
        ],
        perpajakan: [
            { value: 'pembukuan-bulanan', label: 'Monthly Bookkeeping' },
            { value: 'lapor-pajak', label: 'Annual Tax Reporting' },
        ],
    },
    detail_by_layanan: {
        'pendirian-pt-perorangan': [
            { value: 'standar', label: 'Individual PT Incorporation', harga: 3500000 },
        ],
        'pendirian-pt-pmdn': [
            { value: 'standar', label: 'PT PMDN Incorporation', harga: 5500000 },
        ],
        'pendirian-pt-pma': [
            { value: 'standar', label: 'PT PMA Incorporation', harga: 12000000 },
        ],
        'pendirian-cv': [
            { value: 'standar', label: 'CV Incorporation', harga: 3000000 },
        ],
        'pendirian-yayasan': [
            { value: 'standar', label: 'Foundation Incorporation', harga: 6000000 },
        ],
        nib: [{ value: 'standar', label: 'NIB Processing', harga: 1500000 }],
        'izin-usaha': [{ value: 'standar', label: 'Business License', harga: 2500000 }],
        kitas: [{ value: 'standar', label: 'KITAS', harga: 8000000 }],
        'visa-kunjungan': [
            { value: 'standar', label: 'Visit Visa', harga: 1200000 },
        ],
        'pembukuan-bulanan': [
            { value: 'standar', label: 'Monthly Bookkeeping', harga: 1000000 },
        ],
        'lapor-pajak': [
            { value: 'standar', label: 'Annual Tax Reporting', harga: 1500000 },
        ],
    },
    biaya: {
        title: 'Service Cost',
        biaya_label: 'Service Fee',
        ppn_label: 'VAT 11%',
        subtotal_label: 'Subtotal',
        note: 'The price above does not include other fees. Full details can be seen on the service detail page.',
        empty: 'Select a service first to see the cost breakdown.',
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
    captcha_label: "I'm not a robot",
    submit_cta: 'Request a Quote',
    info_box: 'Your submission will create an account on the Customer Dashboard. Logging in to the Customer Dashboard uses OTP via WhatsApp. Make sure you use an active WhatsApp number.',
    cta: {
        title: 'Need a More Specific Explanation?',
        desc: 'Our team is ready to help you find the right solution for your business legal needs.',
        whatsapp: 'Chat Directly via WhatsApp',
    },
}
