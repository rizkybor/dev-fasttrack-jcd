<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;

$resolveBaseUrl = static function (Request $request): string {
    $configuredUrl = rtrim((string) config('app.url'), '/');

    return $configuredUrl && ! str_contains($configuredUrl, 'localhost')
        ? $configuredUrl
        : $request->getSchemeAndHttpHost();
};

$defaultImageUrl = static fn(string $baseUrl): string => $baseUrl . '/favicon.ico';

$organizationReference = static fn(string $baseUrl): array => [
    '@type' => 'Organization',
    'name' => 'FastTrack',
    'url' => $baseUrl,
];

$breadcrumbSchema = static function (array $items): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(
            static fn(array $item, int $index): array => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['item'],
            ]
        )->all(),
    ];
};

$serviceSchema = static function (string $baseUrl, array $service, ?string $price = null): array {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service['title'] ?? $service['name'],
        'description' => $service['description'],
        'serviceType' => $service['title'] ?? $service['name'],
        'provider' => [
            '@type' => 'Organization',
            'name' => 'FastTrack',
            'url' => $baseUrl,
        ],
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'Indonesia',
        ],
        'url' => $baseUrl . ($service['path'] ?? '/layanan/' . $service['slug']),
        'image' => $baseUrl . '/favicon.ico',
    ];

    if ($price !== null) {
        $schema['offers'] = [
            '@type' => 'Offer',
            'priceCurrency' => 'IDR',
            'price' => $price,
            'availability' => 'https://schema.org/InStock',
            'url' => $baseUrl . '/layanan/' . $service['slug'],
        ];
    }

    return $schema;
};

Route::get('/', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Home', [
        'seo' => [
            'title' => 'FastTrack - Layanan Legalitas Bisnis Terpercaya',
            'description' => 'Platform layanan legalitas pendirian PT/CV dengan standar profesional tinggi.',
            'canonical' => $baseUrl . '/',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'FastTrack - Layanan Legalitas Bisnis Terpercaya',
                'description' => 'Platform layanan legalitas pendirian PT/CV dengan standar profesional tinggi.',
                'url' => $baseUrl . '/',
                'inLanguage' => 'id-ID',
            ],
        ],
    ]);
});

// Route::get('/promo', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     $promoItems = [
//         'Promo Pendirian PT Hemat 30%',
//         'Bundling PT + Virtual Office',
//         'Diskon Pendirian CV Untuk UMKM',
//         'Promo Pendaftaran Merek',
//         'Paket Perubahan Akta Cepat',
//         'Paket Perizinan OSS & NIB',
//         'Promo Konsultasi Hukum Perusahaan',
//         'Promo Launching Website Bisnis',
//         'Promo Virtual Office Premium',
//         'Promo Laporan LKPM',
//         'Promo Investor Asing',
//         'Promo Pengurusan Izin Properti',
//     ];

//     return Inertia::render('Promo', [
//         'seo' => [
//             'title' => 'Promo Legalitas Bisnis - FastTrack',
//             'description' => 'Temukan promo legalitas bisnis FastTrack untuk pendirian PT, CV, HAKI, virtual office, perizinan usaha, dan layanan profesional lainnya.',
//             'canonical' => $baseUrl . '/promo',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'CollectionPage',
//                 'name' => 'Promo Legalitas Bisnis - FastTrack',
//                 'description' => 'Halaman promo FastTrack berisi penawaran legalitas bisnis, virtual office, HAKI, dan layanan profesional lainnya.',
//                 'url' => $baseUrl . '/promo',
//                 'mainEntity' => [
//                     '@type' => 'ItemList',
//                     'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
//                     'numberOfItems' => count($promoItems),
//                     'itemListElement' => collect($promoItems)->values()->map(
//                         static fn (string $name, int $index): array => [
//                             '@type' => 'ListItem',
//                             'position' => $index + 1,
//                             'name' => $name,
//                             'url' => $baseUrl . '/promo',
//                         ]
//                     )->all(),
//                 ],
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Promo', 'item' => $baseUrl . '/promo'],
//             ]),
//         ],
//     ]);
// });

Route::get('/layanan', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $services = Service::all();

    return Inertia::render('Services/Index', [
        'services' => $services,
        'seo' => [
            'title' => 'Daftar Layanan Legalitas - FastTrack',
            'description' => 'Pilih layanan legalitas bisnis yang sesuai dengan kebutuhan Anda.',
            'canonical' => $baseUrl . '/layanan',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Daftar Layanan Legalitas - FastTrack',
                'description' => 'Pilih layanan legalitas bisnis yang sesuai dengan kebutuhan Anda.',
                'url' => $baseUrl . '/layanan',
                'hasPart' => $services->map(static fn(Service $service): array => [
                    '@type' => 'Service',
                    'name' => $service->name,
                    'url' => $baseUrl . '/layanan/' . $service->slug,
                ])->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Layanan', 'item' => $baseUrl . '/layanan'],
            ]),
        ],
    ]);
});

// Dynamic custom routes for mega menu services
$customServices = [
    ['component' => 'Services/BadanUsaha/Index', 'title' => 'Pendirian Perusahaan', 'path' => '/badan-usaha', 'description' => 'Membantu Anda menjalankan bisnis dengan legalitas serta badan usaha yang bonafide.'],
    // ['component' => 'Services/PenutupanPerusahaan/Index', 'title' => 'Penutupan Perusahaan', 'path' => '/penutupan-perusahaan', 'description' => 'Proses penutupan perusahaan yang sesuai dengan prosedur hukum yang berlaku.'],
    // ['component' => 'Services/VirtualOffice/Index', 'title' => 'Virtual Office', 'path' => '/virtual-office-jakarta', 'description' => 'Layanan alamat bisnis prestisius untuk meningkatkan citra perusahaan Anda.'],
    // ['component' => 'Services/PerizinanKhusus/Index', 'title' => 'Perizinan Khusus', 'path' => '/perizinan', 'description' => 'Pengurusan izin khusus untuk berbagai sektor bisnis sesuai regulasi terbaru.'],
    // ['component' => 'Services/PembuatanPerjanjian/Index', 'title' => 'Pembuatan dan Peninjauan Perjanjian', 'path' => '/pembuatan-perjanjian', 'description' => 'Penyusunan dan review kontrak bisnis untuk melindungi kepentingan Anda.'],
    // ['component' => 'Services/PerubahanAkta/Index', 'title' => 'Pembuatan dan Perubahan Dokumen Perusahaan', 'path' => '/perubahan-akta', 'description' => 'Layanan perubahan akta dan penyesuaian dokumen perusahaan.'],
    // ['component' => 'Services/DigitalMarketing/Index', 'title' => 'Digital Marketing', 'path' => '/digital-marketing', 'description' => 'Strategi pemasaran digital terpadu untuk meningkatkan pertumbuhan bisnis Anda.'],
    // ['component' => 'Services/PerizinanUsaha/Index', 'title' => 'Perizinan Usaha', 'path' => '/perizinan-usaha', 'description' => 'Solusi perizinan usaha menyeluruh melalui sistem OSS dan NIB.'],
    // ['component' => 'Services/IzinTax/Index', 'title' => 'Izin Tax', 'path' => '/perpajakan', 'description' => 'Layanan perpajakan dan pembukuan profesional untuk kepatuhan bisnis.'],
    // ['component' => 'Services/IzinHaki/Index', 'title' => 'Izin HAKI', 'path' => '/haki', 'description' => 'Perlindungan Hak Kekayaan Intelektual untuk merek dan karya Anda.'],
    // ['component' => 'Services/InvestInAsia/Index', 'title' => 'Invest in Asia', 'path' => '/foreignservice', 'description' => 'Layanan profesional untuk pendirian perusahaan bagi investor asing di Indonesia.'],
    // ['component' => 'Services/IzinHukum/Index', 'title' => 'Izin Hukum', 'path' => '/hukum', 'description' => 'Solusi hukum profesional dengan biaya yang transparan.'],
    // ['component' => 'Services/IzinProperti/Index', 'title' => 'Izin Properti', 'path' => '/izin-properti', 'description' => 'Solusi untuk mengurus seluruh kebutuhan legalitas seputar tanah dan properti.'],
    // ['component' => 'Services/IzinPrivilege/Index', 'title' => 'Izin Privilege', 'path' => '/izin-privilege', 'description' => 'Benefit eksklusif untuk Klien yang menggunakan layanan khusus FastTrack.'],
    // ['component' => 'Services/LayananLainnya/Index', 'title' => 'Layanan Lainnya', 'path' => '/layanan-lain', 'description' => 'Berbagai layanan tambahan untuk mendukung kelancaran operasional bisnis Anda.']
];

$foundingProducts = [
    [
        'id' => 1,
        'name' => 'PT Perorangan',
        'tag' => 'Paling Diminati',
        'price' => '750000',
        'price_label' => 'Rp 750.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Perseroan Terbatas (PT) Perorangan adalah Badan Hukum yang didirikan oleh 1 (satu) seorang',
        'excerpt' => 'Paket pendirian PT untuk usaha yang membutuhkan badan hukum terpisah, perlindungan tanggung jawab, dan kesiapan ekspansi.',
        'audience' => 'Cocok untuk startup, agency, distributor, manufaktur, konsultan, dan bisnis yang menargetkan pertumbuhan jangka panjang.',
        'content' => [
            'PT Perorangan adalah badan hukum yang didirikan oleh satu orang, yang sekaligus merangkap sebagai pemegang saham dan direktur.',
        ],
        'term_condition' => [
            'Perseroan Terbatas yang selanjutnya disebut Persero merupakan badan hukum yang dibentuk berdasarkan kriteria usaha mikro dan kecil.',
            'Menyusun Surat Pernyataan Pendirian sesuai dengan format yang tercantum dalam lampiran PP Nomor 8  Tahun 2021 tentang Modal UMK.',
            'Perseroan perorangan hanya dapat didirikan oleh satu orang pendiri.',
            'Perseroan perorangan wajib mempunyai modal dasar dan modal disetor. Ketentuan modal disetor sama seperti Perseroan Terbatas, yaitu sekurang-kurangnya 25% dari modal dasar yang dibuktikan dengan bukti penyetoran yang sah.',
            'Perseroan perorangan didirikan oleh Warga Negara Indonesia dengan mengisi pernyataan pendirian dalam Bahasa Indonesia.',
            'Warga Negara Indonesia sebagaimana dimaksud wajib memenuhi persyaratan, yaitu berusia minimal 17 tahun dan memiliki kecakapan hukum.',
        ],
        'benefits' => [
            [
                'title' => 'Legalitas Resmi dan Kredibel',
                'description' => 'PT Perorangan memiliki status badan hukum yang sah dan tercatat di Kementerian Hukum, sehingga dapat meningkatkan kepercayaan dari pihak bank, rekan usaha, maupun pelanggan.',
            ],
            [
                'title' => 'Pemisahan Aset Pribadi & Bisnis',
                'description' => 'Harta pribadi pemilik terpisah dari aset perusahaan, sehingga memberikan perlindungan terhadap risiko kerugian usaha.',
            ],
            [
                'title' => 'Proses Praktis & Terjangkau',
                'description' => 'PT Perorangan dapat didirikan hanya oleh satu orang tanpa memerlukan akta notaris.',
            ],
            [
                'title' => 'Kebebasan Mengelola Usaha',
                'description' => 'Sebagai pemilik tunggal, Anda memiliki kendali penuh dalam mengambil keputusan bisnis tanpa harus mengadakan rapat pemegang saham.',
            ],
            [
                'title' => 'Seluruh Keuntungan Menjadi Hak Pemilik',
                'description' => 'Semua laba atau dividen usaha dapat dinikmati sepenuhnya tanpa perlu dibagikan kepada partner bisnis.',
            ],
            [
                'title' => 'Lebih Mudah Mendapatkan Pendanaan',
                'description' => 'Dengan legalitas usaha yang jelas, proses pengajuan pinjaman atau pembiayaan ke bank maupun lembaga keuangan menjadi lebih mudah.',
            ],
        ],
        'requirements' => [
            [
                'title' => 'KTP/NIK Pendiri',
                'description' => 'Scan berwarna, masih berlaku',
            ],
            [
                'title' => 'Nomor Pokok Wajib Pajak (NPWP) Pendiri',
                'description' => 'Scan berwarna, masih berlaku',
            ],
            [
                'title' => 'Nama Perseroan Terbatas yang akan Dimohon',
                'description' => 'Penamaan wajib dalam Bahasa Indonesia dengan ketentuan berikut:',
                'notes' => [
                    'Terdiri dari minimal tiga kata',
                    'Belum digunakan oleh perseroan lain di Kementerian Hukum',
                    'Menggunakan huruf Latin',
                    'Mencantumkan bentuk badan usaha "PT" atau "Perseroan Terbatas"',
                    'Tidak memakai angka, simbol, atau karakter yang tidak membentuk kata jelas',
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan',
            ],
            [
                'title' => 'Uraian Kegiatan Usaha',
                'description' => 'Untuk menentukan kode KBLI yang akan didaftarkan',
            ],
            [
                'title' => 'Modal Usaha',
                'description' => 'Besaran modal dasar dan modal disetor perseroan',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen diterima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Pengecekan Nama',
                'description' => 'Drafting akta notaris',
            ],
            [
                'title' => 'Proses Kemenkumham',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Kapan sebaiknya memilih PT?', 'answer' => 'PT cocok ketika bisnis membutuhkan badan hukum terpisah, struktur yang lebih profesional, dan kesiapan untuk kerja sama yang lebih luas.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
        'plans' => [
            [
                'name' => 'PT Perorangan Starter',
                'popular' => false,
                'price' => 'Rp. 750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Sertifikat Pendirian', 'included' => true],
                    ['label' => 'NPWP & SKT', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => false],
                    ['label' => 'Sertifikat Standar/Izin*', 'included' => false],
                    ['label' => 'Virtual Office 1 (satu) Tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => false],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => false],
                    ['label' => 'Fasttrack Kit', 'included' => false],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => false],
                    ['label' => 'Stempel Perusahaan', 'included' => false],
                    ['label' => 'Kartu Nama', 'included' => false],
                ],
            ],
            [
                'name' => 'PT Perorangan Standart',
                'popular' => true,
                'price' => 'Rp. 3.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Sertifikat Pendirian', 'included' => true],
                    ['label' => 'NPWP & SKT', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => true],
                    ['label' => 'Sertifikat Standar/Izin*', 'included' => false],
                    ['label' => 'Virtual Office 1 (satu) Tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'PT Perorangan Premium + VO',
                'popular' => false,
                'price' => 'Rp. 6.000.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Sertifikat Pendirian', 'included' => true],
                    ['label' => 'NPWP & SKT', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => true],
                    ['label' => 'Sertifikat Standar/Izin*', 'included' => true],
                    ['label' => 'Virtual Office 1 (satu) Tahun', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
        ],
        'plans_alert' => [],
        'dasar_hukum' => [
            'Undang-undang No. 6 Tahun 2023 Penetapan Peraturan Pemerintah Pengganti Undang-undang Nomor 2 Tahun 2022 Tentang Cipta Kerja menjadi Undang-Undang',
            'Peraturan Pemerintah (PP) Republik Indonesia No. 8 Tahun 2021:',
            'Peraturan Pemerintah (PP) Republik Indonesia No. 7 Tahun 2021 tentang Kemudahan, Pelindungan, dan Pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah (UMKM):',
            'Peraturan Menteri Hukum Republik Indonesia Nomor 49 Tahun 2025 tentang Syarat dan Tata Cara Pendirian, Perubahan, dan Pembubaran Badan Hukum Perseroan Terbatas',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan',
        ],
    ],
    [
        'id' => 2,
        'name' => 'Pendirian PT PMDN',
        'tag' => 'UMKM Favorit',
        'price' => '3250000',
        'price_label' => 'Rp 3.250.000',
        'duration' => 'Estimasi 5-10 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Pilihan praktis untuk pelaku usaha yang membutuhkan legalitas usaha dengan proses yang efisien dan biaya lebih terjangkau.',
        'excerpt' => 'Paket pendirian PT PMDN untuk usaha lokal yang membutuhkan badan hukum resmi, struktur profesional, dan kesiapan ekspansi.',
        'audience' => 'Cocok untuk UMKM, bisnis keluarga, kontraktor kecil, perdagangan, dan penyedia jasa lokal.',
        'content' => [
            'Perseroan Terbatas (PT) adalah badan hukum yang merupakan persekutuan modal, didirikan berdasarkan perjanjian, melakukan kegiatan usaha dengan modal dasar yang terbagi dalam saham, serta memenuhi persyaratan yang ditetapkan dalam peraturan perundang-undangan.',
            'Penanaman Modal Dalam Negeri (PMDN) adalah kegiatan menanam modal untuk melakukan usaha di wilayah negara Republik Indonesia yang dilakukan oleh penanam modal dalam negeri dengan menggunakan Modal Dalam Negeri.',
            'Yang dimaksud dengan Modal Dalam Negeri adalah modal yang dimiliki oleh negara Republik Indonesia, perseorangan warga negara Indonesia, atau badan usaha yang berbentuk badan hukum atau tidak berbadan hukum.',
        ],
        'term_condition' => [
            [
                'title' => 'Pendiri',
                'description' => 'Berdasarkan ketentuan umum:',
                'notes' => [
                    'Minimal didirikan oleh 2 orang atau lebih;',
                    'Pendiri dapat orang perseorangan atau badan hukum.',
                ],
            ],
            [
                'title' => 'Akta Pendirian',
                'description' => 'Pendirian PT wajib dibuat dengan:',
                'notes' => [
                    'Akta notaris;',
                    'Dalam bahasa Indonesia.',
                ],
                'notes_extra' => [
                    'label' => 'Akta pendirian memuat antara lain:',
                    'items' => [
                        'Nama dan tempat kedudukan PT;',
                        'Maksud dan Tujuan usaha;',
                        'Modal Dasar;',
                        'Susunan Pemegang Saham;',
                        'Susunan Direksi dan Dewan Komisaris.',
                    ],
                ],
            ],
            [
                'title' => 'Nama Perseroan',
                'description' => 'Nama PT harus:',
                'notes' => [
                    'Menggunakan huruf latin;',
                    'Belum dipakai secara sah oleh PT lain;',
                    'Tidak menggunakan symbol;',
                    'Tidak bertentangan dengan ketertiban umum dan kesusilaan.',
                ],
            ],
            [
                'title' => 'Modal Perseroan',
                'description' => 'Sebelumnya modal dasar minimal PT adalah Rp50.000.000. Namun setelah PP 8 Tahun 2021:',
                'notes' => [
                    'Besaran modal dasar ditentukan berdasarkan keputusan para pendiri;',
                    'Khusus UMK diberikan kemudahan modal.',
                ],
            ],
        ],
        'benefits' => [
            [
                'title' => 'Memiliki Status dan Badan Hukum Resmi',
                'description' => 'PT memiliki kedudukan hukum terpisah dari pemegang saham — dapat memiliki kekayaan, melakukan perjanjian, dan menggugat atas nama perusahaan.',
            ],
            [
                'title' => 'Struktur Organisasi Lebih Jelas',
                'description' => 'PT memiliki organ resmi (RUPS, Direksi, Komisaris) yang membuat pengelolaan perusahaan lebih terstruktur, profesional, dan mudah diawasi.',
            ],
            [
                'title' => 'Tanggung Jawab Pemegang Saham Terbatas',
                'description' => 'Pemegang saham hanya bertanggung jawab sebesar modal yang dimiliki — harta pribadi tidak ikut menanggung utang perusahaan.',
            ],
            [
                'title' => 'Mudah Ekspansi & Ikut Tender',
                'description' => 'Badan hukum yang kuat memudahkan PT mengikuti tender, memperoleh pembiayaan bank, membuka cabang, dan menjalin kerja sama perusahaan lain.',
            ],
            [
                'title' => 'Lebih Mudah Mendapat Modal & Investor',
                'description' => 'Modal terbagi dalam saham sehingga perusahaan lebih fleksibel memperoleh tambahan modal melalui penambahan pemegang saham atau kerja sama investasi.',
            ],
            [
                'title' => 'Saham Dapat Dialihkan',
                'description' => 'Saham PT dapat dialihkan atau diperjualbelikan sesuai anggaran dasar — memberikan fleksibilitas bagi pemegang saham dalam mengelola investasi.',
            ],
            [
                'title' => 'Kredibilitas Lebih Tinggi',
                'description' => 'PT dipandang lebih profesional oleh perbankan, investor, mitra usaha, dan instansi pemerintah — memperkuat kepercayaan dalam kerja sama bisnis.',
            ],
            [
                'title' => 'Perlindungan Nama & Legalitas Usaha',
                'description' => 'Nama PT yang disahkan Kemenkumham memperoleh perlindungan hukum dan tidak dapat digunakan perusahaan lain.',
            ],
            [
                'title' => 'Kelangsungan Usaha Lebih Stabil',
                'description' => 'Perusahaan tetap berjalan meski terjadi pergantian pemegang saham, direksi, atau komisaris — kesinambungan usaha lebih terjamin jangka panjang.',
            ],
            [
                'title' => ' Peluang Kerja Sama Bisnis Lebih Luas',
                'description' => 'Banyak perusahaan dan instansi pemerintah lebih memilih bermitra dengan PT karena legalitas yang jelas, struktur profesional, dan kemampuan bisnis yang terukur.',
            ],
        ],
        'requirements' => [
            [
                'title' => 'Data para Pemegang Saham',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'notes' => [
                            'Perseorangan Indonesia, agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                            'Badan Hukum Indonesia agar melampirkan scancopy bewarna Akta Pendirian Perusahaan dan perubahannya lengkap dengan pengesahan dan persetujuan/pemberitahuan Dari Menteri Hukum dan Hak Asasi Manusia serta rekaman Nomor Pokok Wajib Pajak (NPWP) perusahaan dan copy KTP Direktur.',
                        ],
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data para Direksi',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'description' => 'Scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP);',
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data para Komisaris',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'description' => 'Scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP);',
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama Perseroan Terbatas yang akan Dimohon',
                'description' => 'Perseroan yang seluruh kepemilikan saham oleh warga negara Indonesia atau badan hukum Indonesia, maka dalam hal penamaan perusahaan wajib memakai Bahasa Indonesia, dengan ketentuan sebagai berikut :',
                'notes' => [
                    [
                        'bold' => 'Terdiri dari Minimal Tiga Kata',
                        'detail' => 'Nama perseroan pada umumnya harus memuat sedikitnya tiga kata dalam Bahasa Indonesia.',
                    ],
                    [
                        'bold' => 'Belum Digunakan oleh Perseroan Lain',
                        'detail' => 'Nama yang diajukan harus diawali dengan denominasi yang identik ataupun memiliki kemiripan dengan nama PT lain yang sudah tercatat di Kementerian Hukum.',
                    ],
                    [
                        'bold' => 'Menggunakan Huruf Latin',
                        'detail' => 'Penulisan nama perseroan wajib memakai alfabet atau huruf Latin.',
                    ],
                    [
                        'bold' => 'Mencantumkan Bentuk Badan Usaha',
                        'detail' => 'Nama perseroan harus diawali dengan frasa "Perseroan Terbatas" atau menggunakan singkatan "PT".',
                    ],
                    [
                        'bold' => 'Tidak Memakai Karakter Tertentu',
                        'detail' => 'Nama perseroan dilarang menggunakan angka, gabungan angka, maupun rangkaian huruf yang tidak membentuk suatu kata yang jelas.',
                    ],
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Uraian Kegiatan Usaha',
                'description' => 'Untuk menentukan KBLI yang akan di daftarkan',
            ],
            [
                'title' => 'Modal Perseroan',
                'notes' => [
                    'Modal Dasar',
                    'Modal Disetor (minimal 25% dari Modal Dasar)',
                    'Modal Ditempatkan (sama dengan Modal Disetor)',
                ],
            ],
            [
                'title' => 'Nilai Saham',
                'description' => 'Yakni nilai perlembar saham',
            ],
            [
                'title' => 'Komposisi Kepemilikan Saham',
                'description' => 'Jumlah lembar saham yang dimiliki oleh masing-masing Pendiri/Pemegang Saham',
            ],
            [
                'title' => 'Susunan Direksi',
                'description' => 'Jika lebih dari 1 (satu) orang, salah satu ditunjuk sebagai Direktur Utama',
            ],
            [
                'title' => 'Susunan Dewan Komisaris',
                'description' => 'Jika lebih dari 1 (satu) orang, salah satu ditunjuk sebagai Komisaris Utama',
            ],
            [
                'title' => 'Tahun Buku',
                'description' => 'Umumnya 1 Januari hingga 31 Desember',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Pengecekan Nama',
                'description' => 'Drafting akta notaris',
            ],
            [
                'title' => 'Proses Kemenkumham',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apa perbedaan PT PMDN dan PT Perorangan?', 'answer' => 'PT PMDN dapat didirikan oleh lebih dari satu pemegang saham dan cocok untuk usaha yang membutuhkan struktur kepemilikan bersama, sedangkan PT Perorangan hanya untuk satu pendiri.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
        'plans' => [
            [
                'name' => 'PT PMDN Starter',
                'popular' => false,
                'price' => 'Rp. 3.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Pembuatan poligon', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => false],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => false],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => false],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => false],
                    ['label' => 'Stempel Perusahaan', 'included' => false],
                    ['label' => 'Kartu Nama', 'included' => false],
                ],
            ],
            [
                'name' => 'PT PMDN Standart',
                'popular' => true,
                'price' => 'Rp. 6.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => false],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => false],
                    ['label' => 'Pengukuhan – Pengusaha Kena Pajak (PKP)', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'PT PMDN Premium',
                'popular' => false,
                'price' => 'Rp. 8.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Pengukuhan – Pengusaha Kena Pajak (PKP)', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'PT PMDN Premium + PKP',
                'popular' => false,
                'price' => 'Rp. 9.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum dan HAM', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dari instansi terkait', 'included' => true],
                    ['label' => 'Pengukuhan – Pengusaha Kena Pajak (PKP)', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => false],
                    ['label' => 'Kartu Nama', 'included' => false],
                ],
            ],
            [
                'name' => 'PT PMDN Premium + VO',
                'popular' => false,
                'price' => 'Rp. 10.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum dan HAM', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
        ],
        'plans_alert' => ['+ Rp. 1.000.000,- bila Modal PT di atas Rp. 1 Miliar.'],
        'dasar_hukum' => [
            'Undang-Undang Nomor 25 Tahun 2007 tentang Penanaman Modal',
            'Undang-undang Nomor 40 Tahun 2007 tentang Perseroan Terbatas',
            'Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja',
            'Undang-Undang Nomor 6 Tahun 2023 tentang Penetapan Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang',
            'Peraturan Pemerintah Nomor 7 Tahun 2021 tentang Kemudahan, Perlindungan, dan Pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah',
            'Peraturan Pemerintah Nomor 8 Tahun 2021 tentang Modal Dasar Perseroan serta Pendaftaran Pendirian, Perubahan, dan Pembubaran Perseroan yang Memenuhi Kriteria untuk Usaha Mikro dan Kecil',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko',
            'Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal',
            'Peraturan Presiden Nomor 49 Tahun 2021 tentang Perubahan Atas Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission)',
            'Peraturan Menteri Hukum Nomor 49 Tahun 2025 tentang Syarat dan Tata Cara Pendirian, Perubahan, dan Pembubaran Badan Hukum Perseroan Terbatas.',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan.',
        ],
    ],
    [
        'id' => 3,
        'name' => 'PT Pendirian PMA',
        'tag' => 'Profesional',
        'price' => '17250000',
        'price_label' => 'Rp 17.250.000',
        'duration' => 'Estimasi 7-12 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Dirancang untuk usaha bersama yang dibangun atas kepercayaan dan keterlibatan aktif para sekutu dalam operasional bisnis.',
        'excerpt' => 'Paket pendirian firma untuk usaha profesional yang dijalankan bersama oleh para sekutu aktif.',
        'audience' => 'Cocok untuk kantor konsultan, firma profesional, studio kreatif, dan usaha berbasis kemitraan aktif.',
        'content' => [
            'Penanaman Modal Asing (PMA) adalah kegiatan menanam modal untuk melakukan usaha di wilayah negara Republik Indonesia yang dilakukan oleh Penanam Modal Asing, baik yang menggunakan modal asing sepenuhnya maupun yang berpatungan dengan penanam modal dalam negeri.',
            'Penanam Modal Asing dapat dilakukan oleh perseorangan warga negara asing, badan usaha asing, dan/atau pemerintah asing yang melakukan penanaman modal di wilayah negara Republik Indonesia. Kegiatan usaha atau jenis usaha terbuka bagi kegiatan penanaman modal, kecuali bidang usaha atau jenis usaha yang dinyatakan tertutup dan terbuka dengan persyaratan dan batasan kepemilikan modal asing atas bidang usaha perusahaan diatur di dalam Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal dan Peraturan Presiden Nomor 49 Tahun 2021 tentang Perubahan Atas Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal;',
        ],
        'term_condition' => [
            [
                'title' => 'Pendiri',
                'description' => 'Berdasarkan ketentuan umum:',
                'notes' => [
                    'Minimal didirikan oleh 2 orang atau lebih;',
                    'Pendiri dapat orang perseorangan atau badan hukum.',
                ],
            ],
            [
                'title' => 'Akta Pendirian',
                'description' => 'Pendirian PT wajib dibuat dengan:',
                'notes' => [
                    'Akta notaris;',
                    'Dalam bahasa Indonesia.',
                ],
                'notes_extra' => [
                    'label' => 'Akta pendirian memuat antara lain:',
                    'items' => [
                        'Nama dan tempat kedudukan PT;',
                        'Maksud dan Tujuan usaha;',
                        'Modal Dasar;',
                        'Susunan Pemegang Saham;',
                        'Susunan Direksi dan Dewan Komisaris.',
                    ],
                ],
            ],
            [
                'title' => 'Nama Perseroan',
                'description' => 'Nama PT harus:',
                'notes' => [
                    'Menggunakan huruf latin;',
                    'Belum dipakai secara sah oleh PT lain;',
                    'Tidak menggunakan symbol;',
                    'Tidak bertentangan dengan ketertiban umum dan kesusilaan.',
                ],
            ],
            [
                'title' => 'Modal Perseroan',
                'description' => 'Sebelumnya modal dasar minimal PT adalah Rp50.000.000. Namun setelah PP 8 Tahun 2021:',
                'notes' => [
                    'Besaran modal dasar ditentukan berdasarkan keputusan para pendiri;',
                    'Khusus UMK diberikan kemudahan modal.',
                ],
            ],
        ],
        'benefits' => [
            [
                'title' => 'Memiliki Status dan Badan Hukum Resmi',
                'description' => 'PT memiliki kedudukan hukum terpisah dari pemegang saham — dapat memiliki kekayaan, melakukan perjanjian, dan menggugat atas nama perusahaan.',
            ],
            [
                'title' => 'Struktur Organisasi Lebih Jelas',
                'description' => 'PT memiliki organ resmi (RUPS, Direksi, Komisaris) yang membuat pengelolaan perusahaan lebih terstruktur, profesional, dan mudah diawasi.',
            ],
            [
                'title' => 'Tanggung Jawab Pemegang Saham Terbatas',
                'description' => 'Pemegang saham hanya bertanggung jawab sebesar modal yang dimiliki — harta pribadi tidak ikut menanggung utang perusahaan.',
            ],
            [
                'title' => 'Mudah Ekspansi & Ikut Tender',
                'description' => 'Badan hukum yang kuat memudahkan PT mengikuti tender, memperoleh pembiayaan bank, membuka cabang, dan menjalin kerja sama perusahaan lain.',
            ],
            [
                'title' => 'Lebih Mudah Mendapat Modal & Investor',
                'description' => 'Modal terbagi dalam saham sehingga perusahaan lebih fleksibel memperoleh tambahan modal melalui penambahan pemegang saham atau kerja sama investasi.',
            ],
            [
                'title' => 'Saham Dapat Dialihkan',
                'description' => 'Saham PT dapat dialihkan atau diperjualbelikan sesuai anggaran dasar — memberikan fleksibilitas bagi pemegang saham dalam mengelola investasi.',
            ],
            [
                'title' => 'Kredibilitas Lebih Tinggi',
                'description' => 'PT dipandang lebih profesional oleh perbankan, investor, mitra usaha, dan instansi pemerintah — memperkuat kepercayaan dalam kerja sama bisnis.',
            ],
            [
                'title' => 'Perlindungan Nama & Legalitas Usaha',
                'description' => 'Nama PT yang disahkan Kemenkumham memperoleh perlindungan hukum dan tidak dapat digunakan perusahaan lain.',
            ],
            [
                'title' => 'Kelangsungan Usaha Lebih Stabil',
                'description' => 'Perusahaan tetap berjalan meski terjadi pergantian pemegang saham, direksi, atau komisaris — kesinambungan usaha lebih terjamin jangka panjang.',
            ],
            [
                'title' => ' Peluang Kerja Sama Bisnis Lebih Luas',
                'description' => 'Banyak perusahaan dan instansi pemerintah lebih memilih bermitra dengan PT karena legalitas yang jelas, struktur profesional, dan kemampuan bisnis yang terukur.',
            ],
        ],
        'requirements' => [
            [
                'title' => 'Data para Pemegang Saham',
                'sections' => [
                    [
                        'label' => 'A. Peserta Asing',
                        'groups' => [
                            [
                                'label' => 'Dokumen:',
                                'notes' => [
                                    'Perseorangan asing : Copy paspor yang mencantumkan dengan jelas nama, tandatangan pemilik paspor serta masa berlaku paspor.',
                                    'Badan Hukum/Usaha Asing, agar melampirkan copy anggaran dasar (article of association) dalam bahasa inggris atau terjemahannya dalam Bahasa Indonesia dari penerjemah tersumpah atau di legalisasi oleh perwakilan Republik Indonesia di luar negeri dan copy passport penanggungjawab.',
                                ],
                            ],
                            [
                                'label' => 'Data:',
                                'notes' => [
                                    'Nomor telepon',
                                    'Alamat email',
                                    'Alamat/Domisili di Negara Asal',
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'B. Peserta Dalam Negeri',
                        'groups' => [
                            [
                                'label' => 'Dokumen:',
                                'notes' => [
                                    'Perseorangan Indonesia, agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                                    'Badan Hukum Indonesia agar melampirkan scancopy bewarna Akta Pendirian Perusahaan dan perubahannya lengkap dengan pengesahan dan persetujuan/pemberitahuan Dari Menteri Hukum dan Hak Asasi Manusia serta rekaman Nomor Pokok Wajib Pajak (NPWP) perusahaan dan copy KTP Direktur.',
                                ],
                            ],
                            [
                                'label' => 'Data:',
                                'notes' => [
                                    'Nomor telepon',
                                    'Alamat email',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data para Direksi',
                'sections' => [
                    [
                        'label' => 'A. Warga Negara Indonesia :',
                        'groups' => [
                            [
                                'label' => 'Dokumen:',
                                'description' => 'Scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP);',
                            ],
                            [
                                'label' => 'Data:',
                                'notes' => [
                                    'Nomor telepon',
                                    'Alamat email',
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'B. Warga Negara Asing :',
                        'groups' => [
                            [
                                'label' => 'Dokumen:',
                                'description' => 'Scancopy bewarna paspor yang masih berlaku;',
                            ],
                            [
                                'label' => 'Data:',
                                'notes' => [
                                    'Nomor telepon',
                                    'Alamat email',
                                    'Alamat tempat tinggal',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data para Komisaris',
                'sections' => [
                    [
                        'label' => 'A. Warga Negara Indonesia :',
                        'groups' => [
                            [
                                'label' => 'Dokumen:',
                                'description' => 'Scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP);',
                            ],
                            [
                                'label' => 'Data:',
                                'notes' => [
                                    'Nomor telepon',
                                    'Alamat email',
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'B. Warga Negara Asing :',
                        'groups' => [
                            [
                                'label' => 'Dokumen:',
                                'description' => 'Scancopy bewarna paspor yang masih berlaku;',
                            ],
                            [
                                'label' => 'Data:',
                                'notes' => [
                                    'Nomor telepon',
                                    'Alamat email',
                                    'Alamat tempat tinggal',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama Perseroan Terbatas yang akan Dimohon',
                'description' => 'Nama perseroan yang seluruh kepemilikan saham oleh warga negara Indonesia atau badan hukum Indonesia, maka dalam hal penamaan perusahaan wajib memakai **Bahasa Indonesia**, dengan ketentuan sebagai berikut :',
                'notes' => [
                    [
                        'bold' => 'Terdiri dari Minimal Tiga Kata',
                        'detail' => 'Nama perseroan pada umumnya harus memuat sedikitnya tiga kata dalam Bahasa Indonesia.',
                    ],
                    [
                        'bold' => 'Belum Digunakan oleh Perseroan Lain',
                        'detail' => 'Nama yang diajukan harus diawali dengan denominasi yang identik ataupun memiliki kemiripan dengan nama PT lain yang sudah tercatat di Kementerian Hukum.',
                    ],
                    [
                        'bold' => 'Menggunakan Huruf Latin',
                        'detail' => 'Penulisan nama perseroan wajib memakai alfabet atau huruf Latin.',
                    ],
                    [
                        'bold' => 'Mencantumkan Bentuk Badan Usaha',
                        'detail' => 'Nama perseroan harus diawali dengan frasa "Perseroan Terbatas" atau menggunakan singkatan "PT".',
                    ],
                    [
                        'bold' => 'Tidak Memakai Karakter Tertentu',
                        'detail' => 'Nama perseroan dilarang menggunakan angka, gabungan angka, maupun rangkaian huruf yang tidak membentuk suatu kata yang jelas.',
                    ],
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Uraian Kegiatan Usaha',
                'description' => 'Untuk menentukan KBLI yang akan di daftarkan',
            ],
            [
                'title' => 'Modal Perseroan',
                'notes' => [
                    'Modal Dasar',
                    'Modal Disetor (minimal 25% dari Modal Dasar)',
                    'Modal Ditempatkan (sama dengan Modal Disetor)',
                ],
            ],
            [
                'title' => 'Nilai Saham',
                'description' => 'Yakni nilai perlembar saham',
            ],
            [
                'title' => 'Komposisi Kepemilikan Saham',
                'description' => 'Jumlah lembar saham yang dimiliki oleh masing-masing Pendiri/Pemegang Saham',
            ],
            [
                'title' => 'Susunan Direksi',
                'description' => 'Jika lebih dari 1 (satu) orang, salah satu ditunjuk sebagai Direktur Utama',
            ],
            [
                'title' => 'Susunan Dewan Komisaris',
                'description' => 'Jika lebih dari 1 (satu) orang, salah satu ditunjuk sebagai Komisaris Utama',
            ],
            [
                'title' => 'Tahun Buku',
                'description' => 'Umumnya 1 Januari hingga 31 Desember',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Pengecekan Nama',
                'description' => 'Drafting akta notaris',
            ],
            [
                'title' => 'Proses Kemenkumham',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apa perbedaan PT PMDN dan PT Perorangan?', 'answer' => 'PT PMDN dapat didirikan oleh lebih dari satu pemegang saham dan cocok untuk usaha yang membutuhkan struktur kepemilikan bersama, sedangkan PT Perorangan hanya untuk satu pendiri.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
        'plans' => [
            [
                'name' => 'PT PMA',
                'popular' => false,
                'price' => 'Rp. 17.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Pengukuhan – Pengusaha Kena Pajak (PKP)', 'included' => false],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'PT PMA  + PKP',
                'popular' => true,
                'price' => 'Rp. 19.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Pengukuhan – Pengusaha Kena Pajak (PKP)', 'included' => true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'PT PMA  + PKP + VO',
                'popular' => false,
                'price' => 'Rp. 26.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Pengukuhan – Pengusaha Kena Pajak (PKP)', 'included' => true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
        ],
        'plans_alert' => ['+ Rp. 1.000.000,- bila Modal PT di atas Rp. 1 Miliar.'],
        'dasar_hukum' => [
            'Undang-Undang Nomor 25 Tahun 2007 tentang Penanaman Modal',
            'Undang-undang Nomor 40 Tahun 2007 tentang Perseroan Terbatas',
            'Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja',
            'Undang-Undang Nomor 6 Tahun 2023 tentang Penetapan Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang',
            'Peraturan Pemerintah Nomor 7 Tahun 2021 tentang Kemudahan, Perlindungan, dan Pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah',
            'Peraturan Pemerintah Nomor 8 Tahun 2021 tentang Modal Dasar Perseroan serta Pendaftaran Pendirian, Perubahan, dan Pembubaran Perseroan yang Memenuhi Kriteria untuk Usaha Mikro dan Kecil',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko',
            'Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal',
            'Peraturan Presiden Nomor 49 Tahun 2021 tentang Perubahan Atas Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission)',
            'Peraturan Menteri Hukum Nomor 49 Tahun 2025 tentang Syarat dan Tata Cara Pendirian, Perubahan, dan Pembubaran Badan Hukum Perseroan Terbatas.',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan.',
        ],
    ],
    [
        'id' => 4,
        'name' => 'Pendirian CV',
        'tag' => 'Kolaboratif',
        'price' => '2750000',
        'price_label' => 'Rp 2.750.000',
        'duration' => 'Estimasi 5-10 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Solusi legal untuk para pihak yang ingin bekerja sama secara perdata dengan pengaturan kontribusi, tujuan, dan pembagian tanggung jawab yang lebih jelas.',
        'excerpt' => 'Paket persekutuan perdata untuk kerja sama usaha atau proyek yang membutuhkan struktur perdata yang lebih tertata.',
        'audience' => 'Cocok untuk kolaborasi proyek, konsorsium kecil, studio, klinik, dan kerja sama profesional tertentu.',
        'content' => [
            'Pengaturan mengenai syarat, tata cara, serta ketentuan pendirian persekutuan komanditer atau Commanditaire Vennootschap (“CV”) pada awalnya diatur dalam Kitab Undang-Undang Hukum Dagang (KUHD). CV merupakan bentuk persekutuan yang didirikan oleh dua orang atau lebih, di mana terdapat pihak yang berkedudukan sebagai sekutu komanditer yang berperan sebagai penyetor modal, serta pihak lainnya sebagai sekutu komplementer yang bertanggung jawab menjalankan dan mengelola kegiatan usaha CV.',
        ],
        'term_condition' => [
            [
                'title' => 'Pendiri',
                'description' => 'Didirikan oleh paling tidak 2 (dua) orang, sekutu aktif dan sekutu pasif, seluruhnya harus Warga Negara Indonesia',
                'notes' => [],
            ],
            [
                'title' => 'Akta Pendirian',
                'description' => 'Pendirian CV wajib dibuat dengan:',
                'notes' => [
                    'Akta notaris;',
                    'Dalam bahasa Indonesia.',
                ],
                'notes_extra' => [
                    'label' => 'Akta pendirian memuat antara lain:',
                    'items' => [
                        'Nama dan tempat kedudukan CV;',
                        'Maksud dan Tujuan usaha;',
                    ],
                ],
            ],
            [
                'title' => 'Nama',
                'description' => 'Nama CV harus:',
                'notes' => [
                    'Nama persekutuan wajib ditulis dengan menggunakan huruf Latin.',
                    'Nama yang diajukan belum pernah terdaftar atau digunakan secara sah oleh CV lain dalam Sistem Administrasi Badan Usaha (SABU).',
                    'Penamaan CV tidak boleh bertentangan dengan norma ketertiban umum dan/atau kesusilaan yang berlaku di masyarakat.',
                    'Nama CV tidak diperkenankan memiliki kesamaan atau kemiripan dengan nama lembaga negara, instansi pemerintah, maupun organisasi internasional, kecuali telah memperoleh persetujuan dari pihak yang terkait.',
                    'Selain itu, nama yang digunakan tidak boleh berupa angka, susunan angka, huruf, ataupun rangkaian huruf yang tidak membentuk suatu kata yang memiliki makna jelas.',
                ],
            ],
        ],
        'benefits' => [
            [
                'title' => 'Memudahkan Pengembangan dan Ekspansi Usaha',
                'description' => 'Dengan bentuk badan usaha, CV lebih mudah untuk:',
                'notes' => [
                    'mengikuti tender;',
                    'memperoleh pembiayaan dari bank;',
                    'membuka cabang;',
                    'menjalin kerja sama dengan perusahaan lain.',
                ],
                'footer' => 'Hal ini mendukung pertumbuhan dan ekspansi usaha secara lebih luas.',
            ],
            [
                'title' => 'Memiliki Perlindungan Nama dan Legalitas Usaha',
                'description' => 'Nama CV yang telah disahkan oleh Kementerian Hukum dan HAM memperoleh perlindungan hukum sehingga tidak dapat digunakan oleh perusahaan lain. Selain itu, legalitas yang lengkap memudahkan perusahaan dalam menjalankan kegiatan usaha secara resmi dan sesuai ketentuan hukum.',
            ],
            [
                'title' => 'Meningkatkan Peluang Kerja Sama Bisnis',
                'description' => 'Banyak perusahaan maupun instansi pemerintah lebih memilih bekerja sama dengan badan usaha berbentuk PT maupun CV karena dianggap memiliki:',
                'notes' => [
                    'Legalitas yang jelas;',
                    'Struktur perusahaan yang profesional;',
                    'Kemampuan bisnis yang lebih terukur.',
                ],
                'footer' => 'Oleh karena itu, bentuk CV dapat membuka peluang kerja sama yang lebih besar dalam dunia usaha.',
            ],
        ],
        'requirements' => [
            [
                'title' => 'Data Pendiri dan Sekutu',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'notes' => [
                            'Perseorangan Indonesia, agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                        ],
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data Para Sekutu Aktif (Direksi)',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'description' => 'Scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP);',
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama CV yang akan Dimohon',
                'notes' => [
                    'Nama persekutuan wajib ditulis dengan menggunakan huruf Latin.',
                    'Nama yang diajukan belum pernah terdaftar atau digunakan secara sah oleh CV lain dalam Sistem Administrasi Badan Usaha (SABU).',
                    'Penamaan CV tidak boleh bertentangan dengan norma ketertiban umum dan/atau kesusilaan yang berlaku di masyarakat.',
                    'Nama CV tidak diperkenankan memiliki kesamaan atau kemiripan dengan nama lembaga negara, instansi pemerintah, maupun organisasi internasional, kecuali telah memperoleh persetujuan dari pihak yang terkait.',
                    'Selain itu, nama yang digunakan tidak boleh berupa angka, susunan angka, huruf, ataupun rangkaian huruf yang tidak membentuk suatu kata yang memiliki makna jelas.'
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Uraian Kegiatan Usaha',
                'description' => 'Untuk menentukan KBLI yang akan di daftarkan',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Pengecekan Nama',
                'description' => 'Drafting akta notaris',
            ],
            [
                'title' => 'Proses Kemenkumham',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apa perbedaan PT PMDN dan PT Perorangan?', 'answer' => 'PT PMDN dapat didirikan oleh lebih dari satu pemegang saham dan cocok untuk usaha yang membutuhkan struktur kepemilikan bersama, sedangkan PT Perorangan hanya untuk satu pendiri.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
        'plans' => [
            [
                'name' => 'CV Starter',
                'popular' => false,
                'price' => 'Rp. 2.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama CV', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Pembuatan poligon', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => false],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => false],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => false],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => false],
                    ['label' => 'Stempel Perusahaan', 'included' => false],
                    ['label' => 'Kartu Nama', 'included' => false],
                ],
            ],
            [
                'name' => 'CV Standart',
                'popular' => true,
                'price' => 'Rp. 4.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama CV', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => false],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => false],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'CV Premium',
                'popular' => false,
                'price' => 'Rp. 5.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama CV', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'CV PREMIUM + VO',
                'popular' => false,
                'price' => 'Rp. 7.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama CV', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included' => true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
        ],
        'plans_alert' => [],
        'dasar_hukum' => [
            'Kitab Undang-undang Hukum Dagang;',
            'Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja;',
            'Undang-Undang Nomor 6 Tahun 2023 tentang Penetapan Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang;',
            'Peraturan Pemerintah Nomor 7 Tahun 2021 tentang Kemudahan, Perlindungan, dan Pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah;',
            'Peraturan Pemerintah Nomor 8 Tahun 2021 tentang Modal Dasar Perseroan serta Pendaftaran Pendirian, Perubahan, dan Pembubaran Perseroan yang Memenuhi Kriteria untuk Usaha Mikro dan Kecil;',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko;',
            'Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal;',
            'Peraturan Presiden Nomor 49 Tahun 2021 tentang Perubahan Atas Peraturan Presiden Nomor 10 Tahun 2021 tentang Bidang Usaha Penanaman Modal;',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission);',
            'Peraturan Menteri Hukum Nomor 25 Tahun 2025 tentang Penyelenggaraan Layanan Jasa Hukum Persekutuan Perdata, Persekutuan Firma, dan Persekutuan Komanditer;',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan.',
        ],
    ],
    [
        'id' => 5,
        'name' => 'Pendirian Yayasan',
        'tag' => 'Kolaboratif',
        'price' => '3250000',
        'price_label' => 'Rp 3.250.000',
        'duration' => 'Estimasi 5-10 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Solusi legal untuk para pihak yang ingin bekerja sama secara perdata dengan pengaturan kontribusi, tujuan, dan pembagian tanggung jawab yang lebih jelas.',
        'excerpt' => 'Paket persekutuan perdata untuk kerja sama usaha atau proyek yang membutuhkan struktur perdata yang lebih tertata.',
        'audience' => 'Cocok untuk kolaborasi proyek, konsorsium kecil, studio, klinik, dan kerja sama profesional tertentu.',
        'content' => [
            'Yayasan merupakan salah satu bentuk badan hukum yang memiliki peranan penting dalam mendukung kegiatan sosial, keagamaan, dan kemanusiaan di tengah masyarakat. Berbeda dengan badan usaha pada umumnya yang berorientasi pada keuntungan, yayasan dibentuk dengan tujuan memberikan manfaat sosial secara berkelanjutan dan terorganisir.',
            'Secara hukum, yayasan didefinisikan sebagai badan hukum yang terdiri atas kekayaan yang dipisahkan dan diperuntukkan untuk mencapai tujuan tertentu di bidang sosial, keagamaan, dan kemanusiaan, serta tidak mempunyai anggota. Definisi ini menunjukkan bahwa yayasan berdiri sebagai entitas yang mandiri, dengan kekayaan yang terpisah dari harta pribadi pendirinya.',
            'Pemisahan kekayaan tersebut menjadi unsur penting dalam sebuah yayasan karena seluruh aset yang dimiliki digunakan untuk mendukung kegiatan dan tujuan organisasi, bukan untuk kepentingan pribadi. Dengan demikian, yayasan memiliki tanggung jawab untuk mengelola aset dan program secara profesional, transparan, dan sesuai dengan ketentuan hukum yang berlaku.',
        ],
        'term_condition' => [
            [
                'title' => 'Didirikan oleh Satu Orang atau Lebih',
                'description' => 'Berdasarkan ketentuan Undang-Undang Yayasan, yayasan dapat didirikan oleh satu orang atau lebih dengan tujuan menjalankan kegiatan di bidang sosial, keagamaan, maupun kemanusiaan. Pendiri dapat berasal dari Warga Negara Indonesia (WNI) maupun melibatkan Warga Negara Asing (WNA) sesuai ketentuan yang berlaku.',
                'notes' => [],
            ],
            [
                'title' => 'Memiliki Kekayaan Awal yang Dipisahkan',
                'description' => 'Salah satu unsur utama dalam pendirian yayasan adalah adanya pemisahan harta kekayaan pribadi pendiri untuk dijadikan kekayaan awal yayasan. Ketentuan ini menegaskan bahwa yayasan merupakan badan hukum yang berdiri sendiri dan terpisah dari kepentingan pribadi para pendirinya. Secara umum, ketentuan minimal kekayaan awal meliputi:',
                'notes' => [
                    'Rp10.000.000 untuk yayasan yang didirikan oleh WNI',
                    'Rp100.000.000 untuk yayasan yang melibatkan WNA',
                ],
                'notes_extra' => [
                    'label' => 'Kekayaan awal tersebut dapat berupa uang tunai maupun aset lain yang memiliki nilai ekonomi dan digunakan untuk mendukung kegiatan yayasan.',
                    'items' => [],
                ],
            ],
            [
                'title' => 'Memiliki Struktur Organisasi yang Jelas',
                'description' => 'Undang-Undang Yayasan mewajibkan adanya tiga organ utama dalam struktur organisasi yayasan, yaitu:',
                'notes' => [
                    'Pembina',
                    'Pengurus',
                    'Pengawas',
                ],
                'notes_extra' => [
                    'label' => 'Masing-masing organ memiliki fungsi dan kewenangan yang berbeda sehingga tidak diperbolehkan adanya rangkap jabatan antarorganisasi. Ketentuan ini bertujuan menciptakan sistem pengelolaan yang profesional, transparan, dan saling mengawasi. Dalam praktiknya, susunan pengurus yayasan minimal terdiri dari:',
                    'items' => [
                        'Ketua',
                        'Sekretaris',
                        'Bendahara'
                    ],
                ],
                'notes_extra_plus' => [
                    'label' => 'Struktur tersebut menjadi dasar operasional yayasan dalam menjalankan program dan kegiatan organisasi.',
                    'items' => [],
                ],
            ],
            [
                'title' => 'Wajib Dibuat dengan Akta Notaris',
                'description' => 'Pendirian yayasan harus dituangkan dalam akta notaris yang dibuat dalam bahasa Indonesia. Ketentuan ini diatur dalam Undang-Undang Yayasan sebagai syarat utama untuk memperoleh pengesahan badan hukum. Akta pendirian umumnya memuat:',
                'notes' => [
                    'Nama dan domisili yayasan',
                    'Maksud dan tujuan yayasan',
                    'Struktur organisasi',
                    'Ketentuan pengelolaan kekayaan',
                    'Mekanisme pengambilan keputusan organisasi'
                ],
            ],
            [
                'title' => 'Nama Yayasan',
                'description' => 'Nama yayasan wajib diajukan terlebih dahulu untuk mendapatkan persetujuan dari Kementerian Hukum dan HAM. Nama yang digunakan tidak boleh sama atau menyerupai nama yayasan lain yang telah terdaftar sebelumnya. Ketentuan ini bertujuan untuk menghindari penyalahgunaan identitas dan menjaga kepastian hukum dalam administrasi badan hukum.',
                'notes' => [],
            ],
            [
                'title' => 'Pengesahan Badan Hukum oleh Kemenkum',
                'description' => 'Yayasan baru memperoleh status badan hukum setelah akta pendiriannya disahkan oleh Kementerian Hukum Republik Indonesia (Kemenkum). Pengesahan tersebut memberikan legalitas resmi kepada yayasan sehingga dapat menjalankan kegiatan secara sah, melakukan kerja sama, menerima bantuan dana, serta memiliki hak dan kewajiban sebagai badan hukum.',
                'notes' => [],
            ],
            [
                'title' => 'Dokumen Legalitas Operasional Yayasan',
                'description' => 'Setelah memperoleh pengesahan badan hukum, yayasan masih perlu melengkapi sejumlah dokumen administratif untuk menunjang kegiatan operasionalnya.',
                'notes' => [],
            ],
            [
                'title' => 'Nomor Induk Berusaha',
                'description' => 'NIB diperlukan sebagai legalitas operasional apabila Yayasan melakukan kegiatan komersial yang menghasil bagi Yayasan sesuai ketentuan yang berlaku.',
                'notes' => [],
            ],
            [
                'title' => 'Nomor Pokok Wajib Pajak (NPWP) Yayasan',
                'description' => 'NPWP diperlukan sebagai identitas perpajakan yayasan dalam menjalankan administrasi keuangan dan kewajiban perpajakan sesuai ketentuan yang berlaku.',
                'notes' => [],
            ],
            [
                'title' => 'Surat Keterangan Domisili Yayasan (SKDY)',
                'description' => 'SKDY diterbitkan oleh kelurahan atau kecamatan setempat sebagai bukti alamat resmi yayasan. Dokumen ini biasanya menjadi salah satu syarat pengurusan administrasi lainnya.',
                'notes' => [],
            ],
            [
                'title' => 'Tanda Daftar Yayasan atau Izin Operasional',
                'description' => 'Beberapa jenis kegiatan yayasan memerlukan izin operasional atau tanda daftar dari instansi terkait, terutama yayasan yang bergerak di bidang pendidikan, kesehatan, atau pelayanan sosial tertentu.',
                'notes' => [],
            ],
        ],
        'benefits' => [
            [
                'title' => 'Pemisahan Kekayaan yang Jelas',
                'description' => 'Yayasan memiliki kekayaan terpisah dari harta pribadi pendiri — aset pribadi tidak terkait langsung dengan kewajiban hukum yayasan.',
            ],
            [
                'title' => 'Dapat Mendirikan Badan Usaha Pendukung',
                'description' => 'Yayasan boleh mendirikan sekolah, klinik, atau unit usaha lain — keuntungan dikembalikan untuk operasional dan tujuan sosial.',
            ],
            [
                'title' => ' Legalitas Resmi dari Negara',
                'description' => 'Disahkan oleh Kementerian Hukum dan HAM — memberikan pengakuan resmi untuk menjalankan aktivitas organisasi secara sah.',
            ],
            [
                'title' => 'Sarana Mewujudkan Kepedulian Sosial',
                'description' => 'Wadah resmi untuk menjalankan kegiatan kemanusiaan, pendidikan, dan keagamaan secara terstruktur dan berkelanjutan.',
            ],
            [
                'title' => 'Meningkatkan Kepercayaan Publik',
                'description' => 'Struktur dan administrasi yang tertib meningkatkan kredibilitas di mata donatur, mitra kerja, dan instansi pemerintah.',
            ],
            [
                'title' => 'Meningkatkan Kesejahteraan Masyarakat',
                'description' => 'Membuka lapangan pekerjaan dan meningkatkan kualitas hidup masyarakat melalui berbagai program pemberdayaan sosial.',
            ],
            [
                'title' => 'Akses Hibah & Bantuan Lebih Luas',
                'description' => 'Yayasan berbadan hukum lebih mudah memperoleh pendanaan dari hibah, program CSR, pemerintah, hingga lembaga internasional.',
            ],
            [
                'title' => 'Keberlangsungan Program Terjamin',
                'description' => 'Struktur pembina, pengurus, dan pengawas memastikan program sosial tetap berjalan konsisten meski terjadi pergantian kepengurusan.',
            ],
            [
                'title' => 'Fleksibel dalam Pengelolaan Dana',
                'description' => 'Dapat menerima hibah, wakaf, dan wasiat secara sah — seluruh dana dikelola sesuai Anggaran Dasar untuk tujuan organisasi.',
            ],
            [
                'title' => 'Potensi Fasilitas Perpajakan',
                'description' => 'Yayasan dapat memperoleh pengecualian objek pajak atas sisa lebih yang digunakan kembali untuk sarana sosial sesuai ketentuan berlaku.',
            ],
        ],
        'requirements' => [
            [
                'title' => 'Data para Pendiri',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'notes' => [
                            'Perseorangan Indonesia : agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                            'Badan Hukum Indonesia agar melampirkan scancopy bewarna Akta Pendirian Perusahaan dan seluruh perubahannya lengkap dengan pengesahan dan persetujuan/pemberitahuan Dari Menteri Hukum dan Hak Asasi Manusia serta  rekaman Nomor Pokok Wajib Pajak (NPWP) perusahaan dan copy KTP Direktur.',
                            'Perseorangan asing : Copy paspor yang mencantumkan dengan jelas nama, tandatangan pemilik paspor serta masa berlaku paspor.',
                        ],
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data Pembina, Pengawas dan Pengurus',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'description' => 'Scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP) jika WNI dan/atau copy paspor yang mencantumkan dengan jelas nama, tandatangan pemilik paspor serta masa berlaku paspor.;',
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama Yayasan Terbatas yang akan Dimohon',
                'groups' => [
                    [
                        'label' => null,
                        'description' => 'Perseroan yang seluruh kepemilikan saham oleh warga negara Indonesia atau badan hukum Indonesia, maka dalam hal penamaan perusahaan wajib memakai Bahasa Indonesia, dengan ketentuan sebagai berikut :',
                    ],
                    [
                        'label' => null,
                        'notes' => [
                            'Menggunakan huruf latin.',
                            'Minimal terdiri dari 3 kata.',
                            'Terdiri dari rangkaian huruf yang membentuk kata.',
                            'Tidak menggunakan angka dan tanda baca.',
                            'Tidak hanya menggunakan maksud dan tujuan serta kegiatan sebagai nama yayasan.',
                            'Tidak bertentangan dengan ketertiban umum dan/atau kesusilaan.',
                            'Tidak mempunyai arti sebagai yayasan atau memiliki arti yang sama dengan yayasan, badan hukum, persekutuan perdata, atau entitas lain yang bukan merupakan kewenangan Menteri Hukum dan HAM untuk mengesahkan.'
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Uraian Kegiatan Usaha',
                'description' => 'Untuk menentukan KBLI yang akan di daftarkan',
            ],
            [
                'title' => 'Susunan Pembina',
                'description' => 'Sekurang-kurangnya 1 (satu) orang',
            ],
            [
                'title' => 'Susunan Pengurus',
                'description' => 'Sekurang-kurangnya 3 (orang). Dimana masing-masing minimal 1 (satu) orang Ketua - 1 (satu) orang Bendahara dan 1 (satu) orang Sekretaris',
            ],
            [
                'title' => 'Susunan Pengawas',
                'description' => 'Sekurang-kurangnya 1 (satu) orang',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Pengecekan Nama',
                'description' => 'Drafting akta notaris',
            ],
            [
                'title' => 'Proses Kemenkumham',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apa perbedaan PT PMDN dan PT Perorangan?', 'answer' => 'PT PMDN dapat didirikan oleh lebih dari satu pemegang saham dan cocok untuk usaha yang membutuhkan struktur kepemilikan bersama, sedangkan PT Perorangan hanya untuk satu pendiri.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
        'plans' => [
            [
                'name' => 'Yayasan Starter',
                'popular' => false,
                'price' => 'Rp. 3.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Pembuatan poligon', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => false],
                    ['label' => 'Surat Keterangan Domisili Yayasan', 'included' => false],
                    ['label' => 'Tanda Daftar Yayasan', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => false],
                    ['label' => 'Stempel Perusahaan', 'included' => false],
                    ['label' => 'Kartu Nama', 'included' => false],
                ],
            ],
            [
                'name' => 'Yayasan Standart',
                'popular' => true,
                'price' => 'Rp. 6.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Surat Keterangan Domisili Yayasan', 'included' => false],
                    ['label' => 'Tanda Daftar Yayasan', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'Yayasan Premium',
                'popular' => false,
                'price' => 'Rp. 8.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Perseroan', 'included' => true],
                    ['label' => 'Drafting Akta Perusahaan', 'included' => true],
                    ['label' => 'Akta Pendirian Perusahaan', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Perusahaan dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Surat Keterangan Domisili Yayasan', 'included' => true],
                    ['label' => 'Tanda Daftar Yayasan', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
        ],
        'plans_alert' => [],
        'dasar_hukum' => [
            'Undang-undang No. 16 tahun 2021 tentang Yayasan',
            'Undang-undang No. 28 tahun 2004 tentang Perubahan Undang-undang No. 16 Tahun 2001 tentang Yayasan',
            'Peraturan Pemerintah No. 63 tahun 2008 tentang Yayasan',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko;',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission);',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan',
            'Peraturan Menteri Hukum dan HAM Nomor 2 Tahun 2016 tentang Tata Cara Pengajuan Permohonan Pengesahan Badan Hukum dan Persetujuan Perubahan Anggaran Dasar Serta Penyampaian Pemberitahuan Perubahan Anggaran Dasar dan Perubahan Data Yayasan.',
            'Peraturan Menteri Hukum dan HAM Nomor 13 Tahun 2019 tentang Perubahan atas Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 2 Tahun 2016 Tentang Tata Cara Pengajuan Permohonan Pengesahan Badan Hukum dan Persetujuan Perubahan Anggaran Dasar Serta Penyampaian Pemberitahuan Perubahan Anggaran Dasar dan Perubahan Data Yayasan.',
        ],
    ],
    [
        'id' => 6,
        'name' => 'Pendirian Koperasi',
        'tag' => 'Sosial & Pendidikan',
        'price' => '9750000',
        'price_label' => 'Rp 9.750.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Layanan pendirian yayasan untuk kegiatan sosial, pendidikan, keagamaan, dan kemanusiaan dengan struktur dokumen yang tertib.',
        'excerpt' => 'Paket pendirian yayasan untuk organisasi nirlaba yang membutuhkan dasar hukum yang lebih jelas dan profesional.',
        'audience' => 'Cocok untuk lembaga pendidikan, kegiatan sosial, komunitas keagamaan, dan organisasi kemanusiaan.',
        'content' => [
            'Koperasi adalah badan usaha yang beranggotakan orang-seorang atau badan hukum Koperasi dengan melandaskan kegiatannya berdasarkan prinsip Koperasi sekaligus sebagai gerakan ekonomi rakyat yang berdasar atas asas kekeluargaan.',
            'Koperasi merupakan salah satu bentuk badan usaha yang memiliki peran penting dalam meningkatkan kesejahteraan anggota dan memperkuat perekonomian masyarakat. Berlandaskan asas kekeluargaan dan gotong royong, koperasi hadir sebagai wadah usaha bersama yang bertujuan menciptakan manfaat ekonomi secara adil dan berkelanjutan.',
        ],
        'term_condition' => [
            [
                'title' => 'Jumlah Minimal Pendiri',
                'description' => 'Secara umum:',
                'notes' => [
                    'Koperasi Primer didirikan oleh minimal 9 orang perseorangan',
                    'Koperasi Sekunder didirikan oleh minimal 3 badan hukum koperasi'
                ],
                'notes_extra' => [
                    'label' => 'Ketentuan ini bertujuan memastikan bahwa koperasi benar-benar dibentuk atas dasar kepentingan bersama dan memiliki partisipasi anggota yang memadai sejak awal pendiriannya.',
                    'items' => [],
                ],
            ],
            [
                'title' => 'Memiliki Kesamaan Kepentingan Ekonomi',
                'description' => 'Para anggota koperasi harus memiliki kesamaan aktivitas, tujuan, atau kepentingan ekonomi. Prinsip ini menjadi dasar penting dalam sistem koperasi karena seluruh kegiatan usaha dijalankan untuk mendukung kebutuhan dan kesejahteraan bersama para anggota. Sebagai contoh, koperasi dapat dibentuk berdasarkan:',
                'notes' => [
                    'Kesamaan profesi',
                    'Kesamaan jenis usaha',
                    'Kesamaan kebutuhan ekonomi',
                    'Kesamaan lingkungan kerja atau wilayah'
                ],
                'notes_extra' => [],
            ],
            [
                'title' => 'Dokumen Identitas Pendiri',
                'description' => 'Dalam proses pendirian koperasi, seluruh pendiri wajib melampirkan dokumen identitas berupa salinan Kartu Tanda Penduduk (KTP). Dokumen ini digunakan untuk keperluan verifikasi data anggota serta administrasi pengesahan badan hukum koperasi. Dalam praktiknya, susunan pengurus yayasan minimal terdiri dari:',
                'notes' => [],
            ],
            [
                'title' => 'Berita Acara Rapat Pembentukan',
                'description' => 'Pendirian koperasi harus diawali dengan rapat pembentukan yang dihadiri oleh para pendiri. Hasil rapat tersebut kemudian dituangkan dalam berita acara sebagai bukti kesepakatan bersama untuk mendirikan koperasi. Berita acara rapat umumnya memuat:',
                'notes' => [
                    'Kesepakatan pendirian koperasi',
                    'Penetapan nama koperasi',
                    'Pemilihan pengurus dan pengawas',
                    'Penetapan bidang usaha',
                    'Persetujuan Anggaran Dasar',
                ],
                'notes_extra' => [],
            ],
            [
                'title' => 'Anggaran Dasar dan Anggaran Rumah Tangga (AD/ART)',
                'description' => 'Koperasi wajib memiliki Anggaran Dasar dan Anggaran Rumah Tangga sebagai pedoman utama dalam menjalankan organisasi dan kegiatan usaha. AD/ART biasanya memuat:',
                'notes' => [
                    'Nama dan domisili koperasi',
                    'Maksud dan tujuan koperasi',
                    'Bidang usaha sesuai Klasifikasi Baku Lapangan Usaha Indonesia (KBLI)',
                    'Hak dan kewajiban anggota',
                    'Struktur kepengurusan',
                    'Mekanisme rapat anggota',
                    'Ketentuan pembagian sisa hasil usaha (SHU)',
                ],
                'notes_extra' => [],
            ],
            [
                'title' => 'Rencana Awal Kegiatan Usaha',
                'description' => 'Selain dokumen organisasi, koperasi juga perlu menyusun rencana awal kegiatan usaha yang menggambarkan prospek usaha dan program kerja ke depan. Rencana tersebut umumnya mencakup:',
                'notes' => [
                    'Jenis usaha yang akan dijalankan',
                    'Target pasar atau anggota',
                    'Strategi operasional',
                    'Rencana pengembangan usaha',
                    'Proyeksi manfaat ekonomi bagi anggota',
                ],
                'notes_extra' => [],
            ],
            [
                'title' => 'Permodalan Koperasi - Modal Sendiri Koperasi',
                'description' => 'Dalam menjalankan kegiatan usahanya, koperasi wajib memiliki modal awal yang berasal dari anggota. Modal sendiri koperasi umumnya terdiri dari:',
                'notes' => [
                    'Simpanan Pokok',
                    'Simpanan Wajib'
                ],
                'notes_extra' => [
                    'label' => 'Simpanan pokok merupakan sejumlah uang yang dibayarkan anggota saat pertama kali bergabung, sedangkan simpanan wajib adalah iuran berkala yang dibayarkan sesuai ketentuan koperasi.',
                    'items' => [],
                ],
                'notes_extra_plus' => [
                    'label' => ' Modal tersebut menjadi sumber pendanaan awal untuk mendukung operasional dan pengembangan usaha koperasi.',
                    'items' => [],
                ],
            ],
            [
                'title' => 'Bukti Penyetoran Modal Awal',
                'description' => 'Sebagai bagian dari persyaratan legalitas, koperasi perlu memiliki bukti penyetoran modal awal yang disimpan pada rekening bank atas nama koperasi.',
                'notes' => [],
                'notes_extra' => [
                    'label' => 'Dokumen bukti setoran ini menunjukkan bahwa koperasi telah memiliki kesiapan finansial untuk menjalankan kegiatan usaha serta menjadi salah satu syarat dalam proses pengajuan pengesahan badan hukum koperasi.',
                    'items' => [],
                ],
                'notes_extra_plus' => [],
            ],
        ],
        'benefits' => [
            [
                'title' => 'Pembagian Sisa Hasil Usaha (SHU)',
                'description' => 'Anggota memperoleh bagian keuntungan bersih koperasi sesuai tingkat partisipasi — mencerminkan prinsip keadilan dan kebersamaan.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Pendidikan & Pelatihan bagi Anggota',
                'description' => 'Koperasi menyediakan pelatihan manajemen usaha, pengelolaan keuangan, kewirausahaan, dan pendampingan untuk meningkatkan kapasitas anggota.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Akses Modal & Pinjaman Lebih Mudah',
                'description' => 'Unit simpan pinjam koperasi menawarkan pembiayaan dengan persyaratan sederhana dan bunga lebih ringan dari lembaga keuangan komersial.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Memperluas Relasi & Jaringan Usaha',
                'description' => 'Keanggotaan koperasi membuka peluang membangun jaringan dengan sesama anggota dan pelaku usaha untuk mendukung pengembangan bisnis.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Harga Kebutuhan Lebih Terjangkau',
                'description' => 'Anggota dapat memperoleh barang kebutuhan pokok dan alat produksi dengan harga ekonomis serta potongan harga khusus keanggotaan.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Asas Kekeluargaan & Demokrasi Ekonomi',
                'description' => 'Keputusan strategis diambil melalui Rapat Anggota Tahunan (RAT) — setiap anggota berhak menyampaikan pendapat dan menentukan arah kebijakan.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Sarana Simpanan & Investasi yang Aman',
                'description' => 'Dana simpanan anggota dikelola secara transparan dan profesional — menjadikan koperasi sebagai sarana investasi kolektif yang terpercaya.',
                'notes' => [],
                'footer' => '',
            ],
            [
                'title' => 'Pilar Ekonomi & Kesejahteraan Masyarakat',
                'description' => 'Dikelola secara profesional, transparan, dan sesuai hukum — koperasi menjadi sarana efektif meningkatkan kesejahteraan anggota dan perekonomian nasional.',
                'notes' => [],
                'footer' => '',
            ],
        ],
        'requirements' => [
            [
                'title' => 'Data para Pendiri Pengawas dan Pengurus',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'notes' => [
                            'Perseorangan Indonesia : agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                            'Badan Hukum Indonesia agar melampirkan scancopy bewarna Akta Pendirian Perusahaan dan seluruh perubahannya lengkap dengan pengesahan dan persetujuan/pemberitahuan Dari Menteri Hukum dan Hak Asasi Manusia serta  rekaman Nomor Pokok Wajib Pajak (NPWP) perusahaan dan copy KTP Ketua',
                        ],
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Rencana Kerja Koperasi',
                'notes' => [
                    'Selama 3 (tiga) tahun',
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama Koperasi Terbatas yang akan Dimohon',
                'notes' => [
                    'Terdiri dari paling sedikit 3 (tiga) kata setelah frasa Koperasi dan jenis Koperasi, kecuali nama Koperasi untuk Koperasi Desa/Kelurahan Merah Putih atau jenis lain yang ditetapkan oleh peraturan perundang-undangan atau merupakan program pemerintah;',
                    'Ditulis dengan huruf latin;',
                    'Belum dipakai secara sah oleh Koperasi lain;',
                    'Tidak bertentangan dengan ketertiban umum dan/atau kesusilaan;',
                    'Tidak sama atau tidak mirip dengan nama lembaga negara, lembaga pemerintah, atau lembaga internasional, kecuali mendapat izin dari lembaga yang bersangkutan; dan',
                    'Tidak terdiri atas angka atau rangkaian angka, huruf atau rangkaian huruf, yang tidak membentuk kata.'
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Surat Bukti Penyetoran Modal, Paling Sedikit  Sebesar Simpanan Pokok Serta Dapat Ditambah Simpanan Wajib dan Hibah',
                'description' => null,
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Pengecekan Nama',
                'description' => 'Drafting akta notaris',
            ],
            [
                'title' => 'Proses Kemenkumham',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apa perbedaan PT PMDN dan PT Perorangan?', 'answer' => 'PT PMDN dapat didirikan oleh lebih dari satu pemegang saham dan cocok untuk usaha yang membutuhkan struktur kepemilikan bersama, sedangkan PT Perorangan hanya untuk satu pendiri.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
        'plans' => [
            [
                'name' => 'Koperasi Starter',
                'popular' => false,
                'price' => 'Rp. 9.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Koperasi', 'included' => true],
                    ['label' => 'Akta Pendirian Koperasi', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Koperasi dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Penyuluhan Pendirian Koperasi', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Pembuatan poligon', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => false],
                    ['label' => 'Nomor Induk Koperasi', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Perusahaan', 'included' => false],
                    ['label' => 'Stempel Perusahaan', 'included' => false],
                    ['label' => 'Kartu Nama', 'included' => false],
                ],
            ],
            [
                'name' => 'Koperasi Standart',
                'popular' => true,
                'price' => 'Rp. 14.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Koperasi', 'included' => true],
                    ['label' => 'Akta Pendirian Koperasi', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Koperasi dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Penyuluhan Pendirian Koperasi', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Nomor Induk Koperasi', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
            [
                'name' => 'Koperasi Premium + Nik',
                'popular' => false,
                'price' => 'Rp. 18.500.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Koperasi', 'included' => true],
                    ['label' => 'Akta Pendirian Koperasi', 'included' => true],
                    ['label' => 'Pengesahan Akta Pendirian Koperasi dari Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Penyuluhan Pendirian Koperasi', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Pembuatan poligon', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI', 'included' => true],
                    ['label' => 'Nomor Induk Koperasi', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Perusahaan', 'included' => true],
                    ['label' => 'Stempel Perusahaan', 'included' => true],
                    ['label' => 'Kartu Nama', 'included' => true],
                ],
            ],
        ],
        'plans_alert' => [],
        'dasar_hukum' => [
            'Undang-Undang Nomor 25 Tahun 1992 tentang Perkoperasian.',
            'Undang-Undang Nomor 6 Tahun 2023 tentang Penetapan Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang.',
            'Peraturan Menteri Hukum Nomor 13 Tahun 2025 tentang Pengesahan Koperasi',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko;',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission);',
        ],
    ],
    [
        'id' => 7,
        'name' => 'Persekutuan Perdata',
        'tag' => 'Komunitas Tumbuh',
        'price' => '2750000',
        'price_label' => 'Rp 2.750.000',
        'duration' => 'Estimasi 10-20 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Pendampingan pendirian koperasi untuk komunitas, asosiasi, atau kelompok usaha yang ingin tumbuh bersama secara lebih terstruktur.',
        'excerpt' => 'Paket pendirian koperasi untuk kelompok usaha atau komunitas yang ingin memiliki wadah legal yang lebih kuat.',
        'audience' => 'Cocok untuk koperasi karyawan, koperasi simpan pinjam, komunitas usaha, dan asosiasi ekonomi bersama.',
        'content' => [
            'Persekutuan Perdata (Maatschap) merupakan suatu bentuk perjanjian yang dibuat oleh dua orang atau lebih, di mana para pihak sepakat untuk menyertakan modal berupa uang, barang, maupun keahlian tertentu (inbreng) ke dalam suatu persekutuan dengan tujuan memperoleh dan membagikan keuntungan secara bersama-sama. Ketentuan mengenai Persekutuan Perdata diatur dalam Pasal 1618 sampai dengan Pasal 1652 Kitab Undang-Undang Hukum Perdata (KUHPerdata).',
            'Berdasarkan Permenkum No. 25 Tahun 2025, Persekutuan Perdata adalah “Persekutuan Perdata adalah persekutuan yang menjalankan profesi secara terus menerus dan setiap sekutunya bertindak atas nama sendiri serta bertanggung jawab sendiri terhadap pihak ketiga.”',
            'Persekutuan ini merupakan suatu bentuk kerja sama yang lahir berdasarkan kesepakatan para pihak untuk menjalankan kegiatan secara berkelanjutan, di mana masing-masing sekutu bertindak atas nama pribadi serta memikul tanggung jawabnya sendiri terhadap pihak ketiga.',
            'Pada umumnya, bentuk persekutuan ini digunakan untuk menjalankan kegiatan usaha bersama, khususnya di bidang jasa profesi, seperti kantor advokat, akuntan, konsultan, maupun praktik dokter.'
        ],
        'term_condition' => [],
        'benefits' => [],
        'requirements' => [
            [
                'title' => 'Data Pendiri dan Seluruh Sekutu',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'notes' => [
                            'Perseorangan Indonesia, agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                        ],
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama Persekutuan Perdata yang akan Dimohon',
                'notes' => [
                    'Nama persekutuan wajib ditulis dengan menggunakan huruf Latin.',
                    'Nama yang diajukan belum pernah terdaftar atau digunakan secara sah oleh Persekutuan lain dalam Sistem Administrasi Badan Usaha (SABU).',
                    'Penamaan Persekutuan tidak boleh bertentangan dengan norma ketertiban umum dan/atau kesusilaan yang berlaku di masyarakat.',
                    'Nama Persekutuan tidak diperkenankan memiliki kesamaan atau kemiripan dengan nama lembaga negara, instansi pemerintah, maupun organisasi internasional, kecuali telah memperoleh persetujuan dari pihak yang terkait.',
                    'Selain itu, nama yang digunakan tidak boleh berupa angka, susunan angka, huruf, ataupun rangkaian huruf yang tidak membentuk suatu kata yang memiliki makna jelas.',
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Verifikasi Anggota',
                'description' => 'Pengurus & tujuan disusun',
            ],
            [
                'title' => 'Proses Kemenkop',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apakah koperasi cocok untuk komunitas usaha?', 'answer' => 'Ya, koperasi sangat relevan untuk kelompok yang ingin bertumbuh bersama secara kolektif dan terstruktur.'],
            ['question' => 'Apa manfaat legalitas koperasi?', 'answer' => 'Legalitas membantu koperasi berjalan lebih tertib, mudah berkoordinasi, dan lebih dipercaya oleh para anggotanya maupun mitra.'],
        ],
        'plans' => [
            [
                'name' => 'Persekutuan Perdata Starter',
                'popular' => false,
                'price' => 'Rp. 2.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Pendirian Persekutuan Perdata', 'included' => true],
                    ['label' => 'Akta Pendirian Persekutuan Perdata', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => false],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => false],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included', false],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery S...', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure St...', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Koperasi', 'included' => false],
                    ['label' => 'Stempel Koperasi', 'included' => false],
                    ['label' => 'Kartu Anggota', 'included' => false],
                ],
            ],
            [
                'name' => 'Persekutuan Perdata Standart',
                'popular' => true,
                'price' => 'Rp. 4.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Pendirian Persekutuan Perdata', 'included' => true],
                    ['label' => 'Akta Pendirian Persekutuan Perdata', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included', true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery S...', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure St...', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Koperasi', 'included' => true],
                    ['label' => 'Stempel Koperasi', 'included' => true],
                    ['label' => 'Kartu Anggota', 'included' => true],
                ],
            ],
            [
                'name' => 'Persekutuan Perdata Premium + VO',
                'popular' => false,
                'price' => 'Rp. 7.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Pendirian Persekutuan Perdata', 'included' => true],
                    ['label' => 'Akta Pendirian Persekutuan Perdata', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included', true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery S...', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure St...', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Koperasi', 'included' => true],
                    ['label' => 'Stempel Koperasi', 'included' => true],
                    ['label' => 'Kartu Anggota', 'included' => true],
                ],
            ]
        ],
        'plans_alert' => [],
        'dasar_hukum' => [
            'Kitab Undang-undang Hukum Dagang;',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko;',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission);',
            'Peraturan Menteri Hukum Nomor 25 Tahun 2025 tentang Penyelenggaraan Layanan Jasa Hukum Persekutuan Perdata, Persekutuan Firma, dan Persekutuan Komanditer',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan',
        ],
    ],
    [
        'id' => 8,
        'name' => 'Pendirian Firma',
        'tag' => 'Komunitas Resmi',
        'price' => '4300000',
        'price_label' => 'Rp 4.300.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Layanan pendirian perkumpulan untuk organisasi berbasis komunitas, hobi, profesi, atau kepentingan bersama yang ingin tampil lebih resmi.',
        'excerpt' => 'Paket pendirian perkumpulan untuk komunitas atau organisasi keanggotaan yang membutuhkan legalitas formal.',
        'audience' => 'Cocok untuk komunitas profesi, asosiasi, organisasi hobi, dan kelompok kepentingan bersama.',
        'content' => [
            'Firma Hukum atau law firm merupakan bentuk persekutuan yang dijalankan oleh lebih dari satu orang yang bergerak di bidang hukum. Bentuk usaha ini umumnya hadir dalam wujud kantor hukum, kantor advokat, kantor pengacara, maupun layanan hukum profesional lainnya yang bertujuan memberikan pendampingan dan perlindungan hukum kepada masyarakat.',
            'Dalam praktiknya, firma hukum menjadi wadah berkumpulnya para praktisi hukum, baik yang memiliki lisensi maupun yang belum berlisensi, untuk bekerja sama dalam memberikan layanan hukum secara profesional. Kehadiran firma hukum memiliki peranan penting dalam membantu masyarakat memahami hak dan kewajibannya di hadapan hukum, sekaligus memberikan solusi atas berbagai persoalan hukum yang dihadapi.',
            'Layanan yang diberikan oleh firma hukum mencakup bantuan hukum di bidang pidana maupun perdata. Penanganan perkara tersebut dapat dilakukan melalui jalur pengadilan (litigasi) maupun penyelesaian di luar pengadilan (non-litigasi), seperti mediasi, negosiasi, dan konsultasi hukum. Dengan demikian, firma hukum tidak hanya berfungsi sebagai pendamping dalam proses persidangan, tetapi juga sebagai mitra strategis dalam mencari penyelesaian hukum yang efektif dan sesuai dengan ketentuan peraturan perundang-undangan.',
            'Di era modern saat ini, keberadaan firma hukum semakin dibutuhkan karena meningkatnya kesadaran masyarakat terhadap pentingnya perlindungan hukum. Melalui layanan yang profesional dan terpercaya, firma hukum diharapkan mampu memberikan rasa aman, kepastian hukum, serta membantu terciptanya keadilan bagi setiap pihak yang membutuhkan bantuan hukum.'
        ],
        'term_condition' => [],
        'benefits' => [],
        'requirements' => [
            [
                'title' => 'Data Pendiri dan Seluruh Sekutu',
                'groups' => [
                    [
                        'label' => 'Dokumen:',
                        'notes' => [
                            'Perseorangan Indonesia, agar melampirkan scancopy bewarna Kartu Tanda Penduduk (e-KTP) yang masih berlaku dan rekaman Nomor Pokok Wajib Pajak (NPWP), dan/atau;',
                        ],
                    ],
                    [
                        'label' => 'Data:',
                        'notes' => [
                            'Nomor telepon',
                            'Alamat email',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bukti Kepemilikan/Perjanjian Sewa Lokasi Usaha',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office.',
                ],
            ],
            [
                'title' => 'Copy Izin Mendirikan Bangunan (IMB)',
                'notes' => [
                    'Scan copy bewarna.',
                ],
            ],
            [
                'title' => 'Konfirmasi/Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (P/KKKPR)',
                'notes' => [
                    'Scan copy bewarna.',
                    'Apabila pada lokasi usaha yang digunakan baik pemilik/pengguna sebelum-nya telah memiliki K/PKKPR.',
                ],
            ],
            [
                'title' => 'Nama Persekutuan Firma yang akan Dimohon',
                'notes' => [
                    'Nama persekutuan wajib ditulis dengan menggunakan huruf Latin.',
                    'Nama yang diajukan belum pernah terdaftar atau digunakan secara sah oleh Persekutuan lain dalam Sistem Administrasi Badan Usaha (SABU).',
                    'Penamaan Firma tidak boleh bertentangan dengan norma ketertiban umum dan/atau kesusilaan yang berlaku di masyarakat.',
                    'Nama Firma tidak diperkenankan memiliki kesamaan atau kemiripan dengan nama lembaga negara, instansi pemerintah, maupun organisasi internasional, kecuali telah memperoleh persetujuan dari pihak yang terkait.',
                    'Selain itu, nama yang digunakan tidak boleh berupa angka, susunan angka, huruf, ataupun rangkaian huruf yang tidak membentuk suatu kata yang memiliki makna jelas.',
                ],
            ],
            [
                'title' => 'Alamat Kantor/Usaha',
                'description' => 'Apabila telah memiliki lokasi kantor/usaha atau tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Nomor Telepon Lokasi Usaha',
                'description' => 'Tidak menggunakan layanan Virtual Office',
            ],
            [
                'title' => 'Alamat Email Usaha',
                'description' => 'Alamat email aktif perusahaan.',
            ],
            [
                'title' => 'Formulir/Surat yang telah Dilengkapi dan Ditandatangani oleh Seluruh Pihak',
                'description' => 'Seluruh rancangan dan isi akan kami siapkan setelah pemesanan dan seluruh persyaratan dokumen dan informasi kami terima',
            ],
        ],
        'process' => [
            [
                'title' => 'Konsultasi & Persiapan',
                'description' => 'Dokumen dikumpulkan',
            ],
            [
                'title' => 'Verifikasi Anggota',
                'description' => 'Pengurus & tujuan disusun',
            ],
            [
                'title' => 'Proses Kemenkop',
                'description' => 'Pengesahan resmi',
            ],
            [
                'title' => 'Selesai & Dikirim',
                'description' => 'Dokumen Anda siap',
            ],
        ],
        'faq' => [
            ['question' => 'Apakah koperasi cocok untuk komunitas usaha?', 'answer' => 'Ya, koperasi sangat relevan untuk kelompok yang ingin bertumbuh bersama secara kolektif dan terstruktur.'],
            ['question' => 'Apa manfaat legalitas koperasi?', 'answer' => 'Legalitas membantu koperasi berjalan lebih tertib, mudah berkoordinasi, dan lebih dipercaya oleh para anggotanya maupun mitra.'],
        ],
        'plans' => [
            [
                'name' => 'Persekutuan Firma Starter',
                'popular' => false,
                'price' => 'Rp. 2.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Pendirian Persekutuan Firma', 'included' => true],
                    ['label' => 'Akta Pendirian Persekutuan Firma', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => false],
                    ['label' => 'Pendaftaran OSS', 'included' => false],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => false],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => false],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included', false],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Koperasi', 'included' => false],
                    ['label' => 'Stempel Koperasi', 'included' => false],
                    ['label' => 'Kartu Anggota', 'included' => false],
                ],
            ],
            [
                'name' => 'Persekutuan Firma Standart',
                'popular' => true,
                'price' => 'Rp. 4.750.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Pendirian Persekutuan Firma', 'included' => true],
                    ['label' => 'Akta Pendirian Persekutuan Firma', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included', true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => false],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => false],
                    ['label' => 'Logo Koperasi', 'included' => true],
                    ['label' => 'Stempel Koperasi', 'included' => true],
                    ['label' => 'Kartu Anggota', 'included' => true],
                ],
            ],
            [
                'name' => 'Persekutuan Firma Premium + VO',
                'popular' => false,
                'price' => 'Rp. 7.250.000,-',
                'bonus_note' => 'GRATIS Konsultasi Persiapan dan Pasca Selesai',
                'dokumen' => [
                    ['label' => 'Pengecekan Nama Koperasi', 'included' => true],
                    ['label' => 'Drafting Akta Pendirian Persekutuan Firma', 'included' => true],
                    ['label' => 'Akta Pendirian Persekutuan Firma', 'included' => true],
                    ['label' => 'Surat Keterangan Terdaftar Kementerian Hukum RI', 'included' => true],
                    ['label' => 'Nomor Pokok Wajib Pajak (NPWP) & Surat Keterangan Terdaftar (SKT)', 'included' => true],
                    ['label' => 'Pendaftaran OSS', 'included' => true],
                    ['label' => 'Nomor Induk Berusaha 20 KBLI*', 'included' => true],
                    ['label' => 'Aktifasi Angka Pengenal Importir', 'included' => true],
                    ['label' => 'Perizinan Dasar (Penapisan Izin Lingkungan & KKKPR) dan Perizinan Berusaha (Sertifikat Standar) non-verifikasi', 'included', true],
                    ['label' => 'Sewa Alamat Kantor Virtual 1 tahun + 5 jam meeting room per-tahun', 'included' => true],
                ],
                'termasuk' => [
                    ['label' => 'Fasttrack Document Delivery Service', 'included' => true],
                    ['label' => 'Fasttrack Digital Files Secure Storage', 'included' => true],
                    ['label' => 'Fasttrack Kit', 'included' => true],
                ],
                'bonus' => [
                    ['label' => 'Pembukaan Rekening Bank', 'included' => true],
                    ['label' => 'Logo Koperasi', 'included' => true],
                    ['label' => 'Stempel Koperasi', 'included' => true],
                    ['label' => 'Kartu Anggota', 'included' => true],
                ],
            ]
        ],
        'plans_alert' => [],
        'dasar_hukum' => [
            'Kitab Undang-undang Hukum Dagang;',
            'Peraturan Pemerintah Nomor 28 Tahun 2025 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko;',
            'Peraturan Menteri Investasi dan Hilirisasi/Kepala Badan Koordinasi Penanaman Modal Nomor 5 Tahun 2025 tentang Pedoman dan Tata Cara Penyelenggaraan Perizinan Berusaha Berbasis Risiko dan Fasilitas Penanaman Modal Melalui Sistem Perizinan Berusaha Terintegrasi Secara Elektronik (Online Single Submission);',
            'Peraturan Menteri Hukum Nomor 25 Tahun 2025 tentang Penyelenggaraan Layanan Jasa Hukum Persekutuan Perdata, Persekutuan Firma, dan Persekutuan Komanditer',
            'Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan',
        ],
    ],
];

$foundingProducts = collect($foundingProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = $product['id'] === 1
            ? '/badan-usaha/paket'
            : '/badan-usaha/' . $product['id'];

        return $product;
    })
    ->all();

// $foundingPackages = [
//     [
//         'id' => 1,
//         'slug' => 'persekutuan-modal',
//         'name' => 'PT Persekutuan Modal',
//         'short_name' => 'Persekutuan Modal',
//         'tag' => 'Pilihan Umum',
//         'price' => '5500000',
//         'price_label' => 'Rp 5.500.000',
//         'duration' => 'Estimasi 7-14 hari kerja',
//         'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
//         'description' => 'Pilihan paket untuk pendirian PT dengan lebih dari satu pihak pemegang saham yang ingin membangun perusahaan dengan struktur modal yang jelas dan profesional.',
//         'excerpt' => 'Paket PT Persekutuan Modal untuk bisnis dengan dua pihak atau lebih yang ingin memiliki badan hukum Perseroan Terbatas.',
//         'audience' => 'Cocok untuk founder bersama, agency, distributor, bisnis keluarga modern, dan perusahaan yang akan berkembang dengan lebih dari satu pemegang saham.',
//         'content' => [
//             'PT Persekutuan Modal adalah bentuk Perseroan Terbatas yang didirikan oleh dua pihak atau lebih dengan pembagian saham, peran, dan tanggung jawab yang disusun lebih jelas sejak awal.',
//             'Bentuk ini cocok ketika bisnis dibangun bersama partner atau investor dan membutuhkan struktur korporasi yang lebih siap untuk kerja sama, pengembangan usaha, maupun pengelolaan internal.',
//             'Melalui FastTrack, proses pendiriannya dirancang agar user memahami struktur dasar PT, pilihan KBLI, kebutuhan dokumen, dan langkah legalitas penting tanpa merasa rumit.',
//         ],
//         'benefits' => [
//             'Struktur kepemilikan saham lebih jelas untuk dua pihak atau lebih',
//             'Lebih siap untuk kerja sama bisnis, tender, dan ekspansi',
//             'Meningkatkan kredibilitas usaha di mata klien dan partner',
//             'Dokumen legal disusun lebih rapi sesuai kebutuhan usaha',
//         ],
//         'requirements' => [
//             'Data seluruh pemegang saham dan pengurus',
//             'Nama perusahaan beserta alternatif cadangan',
//             'Alamat usaha yang akan digunakan',
//             'Ruang lingkup kegiatan usaha untuk penentuan KBLI',
//         ],
//         'process' => [
//             'Konsultasi struktur perusahaan dan pembagian saham',
//             'Pemeriksaan data pendiri, pengurus, dan nama perusahaan',
//             'Penyusunan akta pendirian serta proses legalitas dasar',
//             'Serah terima dokumen dan pengarahan langkah lanjutan',
//         ],
//         'faq' => [
//             ['question' => 'Kapan memilih PT Persekutuan Modal?', 'answer' => 'Paket ini tepat ketika bisnis dibangun oleh dua pihak atau lebih dan membutuhkan struktur saham yang lebih jelas.'],
//             ['question' => 'Apakah cocok untuk bisnis yang ingin berkembang?', 'answer' => 'Ya, PT Persekutuan Modal sangat cocok untuk bisnis yang menargetkan pertumbuhan, kerja sama korporasi, dan peluang investasi.'],
//         ],
//         'why_cards' => [
//             [
//                 'icon' => 'shield',
//                 'title' => 'Meningkatkan Kredibilitas Bisnis',
//                 'description' => 'PT memberi citra usaha yang lebih profesional saat berhadapan dengan klien, vendor, institusi, dan calon investor.',
//             ],
//             [
//                 'icon' => 'office',
//                 'title' => 'Alamat Bisnis Lebih Siap Pakai',
//                 'description' => 'Virtual Office membantu bisnis memiliki alamat usaha yang lebih representatif untuk kebutuhan administrasi dan komunikasi usaha.',
//             ],
//             [
//                 'icon' => 'document',
//                 'title' => 'Mempermudah Proses Legalitas Lanjutan',
//                 'description' => 'Struktur PT dan dukungan alamat usaha yang tepat membantu proses pengurusan dokumen lanjutan menjadi lebih tertata.',
//             ],
//             [
//                 'icon' => 'growth',
//                 'title' => 'Lebih Siap untuk Ekspansi',
//                 'description' => 'Kombinasi PT dan Virtual Office cocok untuk pengusaha yang ingin bertumbuh lebih cepat tanpa harus langsung menanggung biaya kantor penuh.',
//             ],
//         ],
//         'plans' => [
//             [
//                 'name' => 'PT Lite',
//                 'highlight' => 'Pilihan hemat',
//                 'subtitle' => 'Solusi awal untuk memulai legalitas PT dengan alur yang lebih sederhana.',
//                 'promo_price' => null,
//                 'price' => 'Mulai dari Rp 5.500.000',
//                 'includes' => [
//                     'Konsultasi struktur PT dan pilihan KBLI',
//                     'Penyusunan dokumen pendirian dasar',
//                     'Pendampingan proses legalitas awal',
//                 ],
//                 'note' => 'Cocok untuk bisnis yang ingin bergerak cepat dengan kebutuhan dokumen dasar yang efisien.',
//             ],
//             [
//                 'name' => 'PT Lengkap',
//                 'highlight' => 'Paling fleksibel',
//                 'subtitle' => 'Dirancang untuk bisnis yang membutuhkan paket pendirian lebih komprehensif.',
//                 'promo_price' => 'Promo Rp 7.500.000',
//                 'price' => 'Harga normal Rp 8.500.000',
//                 'includes' => [
//                     'Kelengkapan dokumen pendirian yang lebih luas',
//                     'Pendampingan legalitas dasar hingga siap digunakan',
//                     'Arahan penggunaan dokumen untuk operasional awal',
//                 ],
//                 'note' => 'Pilihan yang pas untuk bisnis yang ingin fondasi legal lebih matang sejak awal.',
//             ],
//             [
//                 'name' => 'PT Lengkap + PKP',
//                 'highlight' => 'Untuk bisnis berkembang',
//                 'subtitle' => 'Paket untuk usaha yang membutuhkan kesiapan legalitas dan administrasi pajak lebih lanjut.',
//                 'promo_price' => null,
//                 'price' => 'Mulai dari Rp 11.500.000',
//                 'includes' => [
//                     'Paket pendirian PT lengkap',
//                     'Pendampingan kebutuhan PKP sejak awal',
//                     'Konsultasi kesiapan dokumen perpajakan',
//                 ],
//                 'note' => 'Ideal untuk bisnis yang menargetkan transaksi lebih formal dan pertumbuhan lebih cepat.',
//             ],
//             [
//                 'name' => 'PT Lengkap + Daftar Merek',
//                 'highlight' => 'Lindungi brand',
//                 'subtitle' => 'Gabungan legalitas PT dan langkah awal perlindungan identitas merek bisnis.',
//                 'promo_price' => 'Promo Rp 10.900.000',
//                 'price' => 'Harga normal Rp 12.000.000',
//                 'includes' => [
//                     'Paket PT lengkap',
//                     'Pendampingan awal pendaftaran merek',
//                     'Review dasar nama dan identitas brand',
//                 ],
//                 'note' => 'Direkomendasikan untuk bisnis yang serius membangun brand jangka panjang.',
//             ],
//             [
//                 'name' => 'PT Lengkap + Virtual Office by vOffice',
//                 'highlight' => 'Alamat strategis',
//                 'subtitle' => 'Menggabungkan legalitas PT dan kebutuhan alamat usaha yang lebih representatif.',
//                 'promo_price' => 'Promo Rp 9.900.000',
//                 'price' => 'Harga normal Rp 11.500.000',
//                 'includes' => [
//                     'Paket PT lengkap',
//                     'Virtual Office by vOffice',
//                     'Pendampingan kebutuhan administrasi alamat usaha',
//                 ],
//                 'note' => 'Sesuai untuk bisnis yang ingin tampil profesional tanpa langsung menyewa kantor fisik penuh.',
//             ],
//             [
//                 'name' => 'PT Lengkap + Virtual Office Premium by vOffice',
//                 'highlight' => 'Kelas premium',
//                 'subtitle' => 'Pilihan premium untuk bisnis yang membutuhkan kesan profesional dan eksklusif.',
//                 'promo_price' => 'Promo Rp 12.900.000',
//                 'price' => 'Harga normal Rp 14.500.000',
//                 'includes' => [
//                     'Paket PT lengkap',
//                     'Virtual Office Premium by vOffice',
//                     'Dukungan citra bisnis yang lebih eksklusif',
//                 ],
//                 'note' => 'Direkomendasikan untuk bisnis yang banyak berinteraksi dengan klien korporasi dan partner strategis.',
//             ],
//             [
//                 'name' => 'PAKET PT + VO (Free Trade)',
//                 'highlight' => 'Bundling praktis',
//                 'subtitle' => 'Bundling legalitas PT dan virtual office untuk kebutuhan operasional yang lebih dinamis.',
//                 'promo_price' => null,
//                 'price' => 'Mulai dari Rp 9.500.000',
//                 'includes' => [
//                     'Pendirian PT dasar',
//                     'Fasilitas Virtual Office pilihan',
//                     'Pendampingan proses yang lebih praktis dalam satu alur',
//                 ],
//                 'note' => 'Pilihan tepat untuk owner yang ingin solusi bundling praktis dan efisien.',
//             ],
//         ],
//     ],
//     [
//         'id' => 2,
//         'slug' => 'perorangan',
//         'name' => 'PT Perorangan',
//         'short_name' => 'Perorangan',
//         'tag' => 'Praktis',
//         'price' => '2500000',
//         'price_label' => 'Rp 2.500.000',
//         'duration' => 'Estimasi 3-7 hari kerja',
//         'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80&fm=webp',
//         'description' => 'Pilihan paket untuk pemilik usaha tunggal yang ingin memiliki badan hukum PT dengan proses yang lebih sederhana, efisien, dan tetap profesional.',
//         'excerpt' => 'Paket PT Perorangan untuk pelaku usaha tunggal yang ingin naik kelas dengan badan hukum yang lebih formal.',
//         'audience' => 'Cocok untuk solo founder, konsultan, bisnis digital, UMKM yang berkembang, dan pemilik usaha yang ingin legalitas lebih rapi.',
//         'content' => [
//             'PT Perorangan menjadi pilihan menarik bagi pemilik usaha tunggal yang ingin memiliki badan hukum lebih formal tanpa struktur multi pemegang saham.',
//             'Bentuk ini cocok untuk usaha yang sudah berjalan atau sedang bersiap tumbuh dan membutuhkan identitas hukum yang lebih kredibel untuk kebutuhan operasional maupun kerja sama.',
//             'FastTrack membantu user memahami apakah PT Perorangan merupakan opsi yang tepat, sekaligus mendampingi proses dokumen agar tetap efisien dan nyaman diikuti.',
//         ],
//         'benefits' => [
//             'Proses pendirian lebih sederhana untuk pemilik usaha tunggal',
//             'Membantu bisnis tampil lebih kredibel dan profesional',
//             'Cocok untuk solo founder yang ingin menata legalitas bisnis',
//             'Lebih efisien sebagai langkah awal naik kelas usaha',
//         ],
//         'requirements' => [
//             'Identitas pemilik usaha',
//             'Nama perusahaan dan alternatif cadangan',
//             'Alamat usaha yang akan digunakan',
//             'Deskripsi kegiatan usaha utama',
//         ],
//         'process' => [
//             'Diskusi model usaha dan kecocokan PT Perorangan',
//             'Persiapan data dan validasi nama perusahaan',
//             'Pengurusan dokumen pendirian dan legalitas dasar',
//             'Serah terima dokumen dan arahan penggunaan awal',
//         ],
//         'faq' => [
//             ['question' => 'Siapa yang cocok memakai PT Perorangan?', 'answer' => 'PT Perorangan cocok untuk pelaku usaha tunggal yang ingin memiliki badan hukum yang lebih formal dan profesional.'],
//             ['question' => 'Apakah PT Perorangan cocok untuk UMKM?', 'answer' => 'Ya, paket ini relevan untuk UMKM yang sedang berkembang dan ingin menata fondasi legal usahanya dengan lebih baik.'],
//         ],
//         'about' => [
//             'PT Perorangan adalah bentuk badan hukum yang dirancang untuk pemilik usaha tunggal yang ingin meningkatkan legalitas usahanya tanpa harus membangun struktur multi pemegang saham.',
//             'Bentuk ini menjadi solusi menarik bagi pelaku usaha mikro dan kecil yang ingin tampil lebih profesional, memiliki entitas usaha yang lebih formal, dan mulai menata administrasi bisnis dengan lebih baik.',
//             'Dengan pendekatan yang lebih sederhana, PT Perorangan membantu solo founder atau owner bisnis agar bisa naik kelas tanpa harus langsung masuk ke struktur PT biasa yang lebih kompleks.',
//         ],
//         'plans' => [
//             [
//                 'name' => 'PT Lite',
//                 'highlight' => 'Mulai cepat',
//                 'subtitle' => 'Paket awal untuk owner tunggal yang ingin menata legalitas bisnis lebih cepat.',
//                 'promo_price' => null,
//                 'price' => 'Mulai dari Rp 2.500.000',
//                 'includes' => [
//                     'Konsultasi dasar PT Perorangan',
//                     'Pendampingan proses legalitas awal',
//                     'Checklist dokumen dan arahan penggunaan',
//                 ],
//                 'note' => 'Cocok untuk usaha yang baru naik kelas dan ingin struktur legal lebih rapi.',
//             ],
//             [
//                 'name' => 'PT Perorangan Lengkap',
//                 'highlight' => 'Paket utama',
//                 'subtitle' => 'Pilihan lengkap untuk usaha yang ingin fondasi legal lebih matang sejak awal.',
//                 'promo_price' => 'Promo Rp 3.900.000',
//                 'price' => 'Harga normal Rp 4.500.000',
//                 'includes' => [
//                     'Dokumen PT Perorangan yang lebih lengkap',
//                     'Pendampingan proses hingga siap digunakan',
//                     'Briefing tindak lanjut operasional awal',
//                 ],
//                 'note' => 'Sesuai untuk owner bisnis yang ingin paket lebih lengkap tanpa proses yang terasa rumit.',
//             ],
//             [
//                 'name' => 'PT Perorangan Lengkap + Virtual Office Silver Promo by vOffice',
//                 'highlight' => 'Promo VO',
//                 'subtitle' => 'Gabungan legalitas PT Perorangan dan virtual office untuk citra usaha yang lebih rapi.',
//                 'promo_price' => 'Promo Rp 5.900.000',
//                 'price' => 'Harga normal Rp 6.800.000',
//                 'includes' => [
//                     'Paket PT Perorangan lengkap',
//                     'Virtual Office Silver Promo by vOffice',
//                     'Pendampingan kebutuhan alamat usaha',
//                 ],
//                 'note' => 'Direkomendasikan untuk bisnis digital, jasa, dan usaha modern yang perlu alamat usaha representatif.',
//             ],
//             [
//                 'name' => 'PT Perorangan Lengkap + Virtual Office Premium by vOffice',
//                 'highlight' => 'Premium',
//                 'subtitle' => 'Solusi premium untuk owner bisnis yang ingin tampil lebih profesional dan eksklusif.',
//                 'promo_price' => 'Promo Rp 7.900.000',
//                 'price' => 'Harga normal Rp 9.000.000',
//                 'includes' => [
//                     'Paket PT Perorangan lengkap',
//                     'Virtual Office Premium by vOffice',
//                     'Kesan brand dan alamat usaha yang lebih kuat',
//                 ],
//                 'note' => 'Cocok untuk bisnis yang ingin menaikkan citra brand dan kenyamanan komunikasi bisnis.',
//             ],
//         ],
//         'differences' => [
//             [
//                 'aspect' => 'Jumlah Pendiri',
//                 'perorangan' => 'Didirikan oleh satu orang pemilik usaha.',
//                 'biasa' => 'Umumnya melibatkan dua pihak atau lebih sebagai pemegang saham.',
//             ],
//             [
//                 'aspect' => 'Struktur Kepemilikan',
//                 'perorangan' => 'Lebih sederhana karena fokus pada satu owner.',
//                 'biasa' => 'Lebih kompleks karena ada pembagian saham, peran, dan pengambilan keputusan bersama.',
//             ],
//             [
//                 'aspect' => 'Kecocokan Bisnis',
//                 'perorangan' => 'Ideal untuk usaha mikro dan kecil yang sedang bertumbuh.',
//                 'biasa' => 'Lebih cocok untuk bisnis yang menargetkan skala lebih besar atau melibatkan partner/investor.',
//             ],
//             [
//                 'aspect' => 'Administrasi Awal',
//                 'perorangan' => 'Cenderung lebih ringkas bagi owner tunggal.',
//                 'biasa' => 'Perlu penyesuaian lebih banyak karena melibatkan beberapa pihak dan struktur korporasi.',
//             ],
//         ],
//         'business_types' => [
//             'Bisnis digital dan jasa profesional yang dijalankan owner tunggal',
//             'Konsultan, agency kecil, dan freelancer yang ingin naik kelas',
//             'UMKM produk atau perdagangan yang mulai berkembang',
//             'Bisnis online yang ingin terlihat lebih profesional di mata klien atau partner',
//             'Usaha layanan yang membutuhkan identitas badan hukum lebih rapi',
//             'Owner bisnis yang ingin menyiapkan fondasi legal sebelum ekspansi',
//         ],
//         'requirements_detail' => [
//             'Pendiri merupakan WNI dan menjalankan usaha atas nama sendiri',
//             'Menyiapkan nama perusahaan dan deskripsi kegiatan usaha',
//             'Memiliki alamat usaha yang dapat digunakan untuk kebutuhan administrasi',
//             'Menentukan modal, kegiatan usaha, dan data identitas pendukung',
//             'Memastikan usaha masuk dalam kategori yang relevan untuk skema PT Perorangan',
//         ],
//     ],
// ];

// $articles = [
//     [
//         'id' => 1,
//         'title' => 'Panduan Lengkap Mendirikan PT Tahun 2024',
//         'excerpt' => 'Mendirikan Perseroan Terbatas kini semakin mudah dengan adanya sistem OSS. Pelajari langkah-langkah penting, dokumen, dan estimasi prosesnya.',
//         'content' => [
//             'Mendirikan PT menjadi langkah penting bagi pelaku usaha yang ingin membangun bisnis dengan struktur legal yang lebih profesional. Dengan badan hukum yang jelas, perusahaan memiliki kredibilitas lebih tinggi di mata mitra, investor, maupun pelanggan.',
//             'Proses pendirian PT umumnya dimulai dari penentuan nama perusahaan, pemilihan KBLI yang relevan, penyusunan akta pendirian, hingga pengurusan NIB dan dokumen penunjang lainnya. Ketelitian pada tahap awal akan membantu proses berjalan lebih cepat dan minim revisi.',
//             'FastTrack membantu Anda mengelola proses tersebut dengan pendampingan yang terstruktur, komunikasi yang jelas, dan timeline yang realistis agar bisnis bisa segera berjalan dengan pondasi legal yang kuat.',
//         ],
//         'category' => 'Legalitas',
//         'date' => '12 Mei 2024',
//         'reading_time' => '5 menit baca',
//         'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80&fm=webp',
//     ],
//     [
//         'id' => 2,
//         'title' => 'Perbedaan PT dan CV: Mana yang Cocok Untuk Bisnis Anda?',
//         'excerpt' => 'Kenali perbedaan mendasar antara PT dan CV agar Anda bisa memilih bentuk usaha yang sesuai dengan kebutuhan operasional dan pengembangan bisnis.',
//         'content' => [
//             'PT dan CV adalah dua bentuk usaha yang paling sering dipilih oleh pelaku bisnis di Indonesia. Masing-masing memiliki karakteristik, struktur tanggung jawab, dan implikasi legal yang berbeda.',
//             'PT lebih cocok bagi bisnis yang membutuhkan badan hukum terpisah, perlindungan tanggung jawab terbatas, dan peluang pengembangan usaha yang lebih luas. Sementara itu, CV kerap dipilih oleh usaha skala kecil hingga menengah yang mengutamakan fleksibilitas awal.',
//             'Sebelum memutuskan, penting untuk mempertimbangkan model bisnis, kebutuhan perizinan, rencana investasi, dan risiko usaha. Konsultasi yang tepat akan membantu Anda memilih struktur yang paling efisien.',
//         ],
//         'category' => 'Bisnis',
//         'date' => '10 Mei 2024',
//         'reading_time' => '6 menit baca',
//         'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
//     ],
//     [
//         'id' => 3,
//         'title' => 'Pentingnya Memilih KBLI Yang Tepat Sebelum Mengurus NIB',
//         'excerpt' => 'Pemilihan KBLI yang akurat membantu proses OSS lebih lancar dan mengurangi risiko kendala legal saat bisnis mulai berjalan.',
//         'content' => [
//             'KBLI adalah fondasi penting dalam proses legalitas usaha karena menjadi acuan utama dalam menentukan jenis kegiatan bisnis yang dijalankan perusahaan.',
//             'Kesalahan memilih KBLI dapat berdampak pada terhambatnya proses perizinan, ketidaksesuaian dokumen usaha, hingga hambatan saat bekerja sama dengan pihak lain atau mengurus izin lanjutan.',
//             'Dengan analisis kegiatan usaha yang tepat, pemilik bisnis dapat memilih KBLI yang paling relevan agar proses pengurusan NIB dan legalitas lain berjalan lebih aman dan efisien.',
//         ],
//         'category' => 'KBLI',
//         'date' => '8 Mei 2024',
//         'reading_time' => '4 menit baca',
//         'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80&fm=webp',
//     ],
//     [
//         'id' => 4,
//         'title' => 'Kapan Bisnis Membutuhkan Virtual Office?',
//         'excerpt' => 'Virtual office menjadi solusi efisien untuk bisnis modern yang ingin tetap terlihat profesional tanpa harus menyewa kantor fisik penuh.',
//         'content' => [
//             'Virtual office banyak dipilih oleh startup, konsultan, hingga bisnis digital yang membutuhkan alamat usaha strategis namun tetap ingin menjaga efisiensi biaya operasional.',
//             'Selain menunjang citra perusahaan, virtual office juga membantu pemenuhan kebutuhan administratif dan legal untuk jenis usaha tertentu, terutama di kota besar seperti Jakarta.',
//             'Sebelum memilih layanan virtual office, pastikan lokasi, legalitas penyedia, dan fasilitas pendukungnya benar-benar sesuai dengan kebutuhan bisnis Anda.',
//         ],
//         'category' => 'Virtual Office',
//         'date' => '5 Mei 2024',
//         'reading_time' => '4 menit baca',
//         'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80&fm=webp',
//     ],
//     [
//         'id' => 5,
//         'title' => 'Cara Mengurus Perubahan Akta Perusahaan Dengan Efisien',
//         'excerpt' => 'Perubahan data perusahaan perlu ditangani dengan teliti agar tidak mengganggu legalitas, operasional, dan administrasi bisnis.',
//         'content' => [
//             'Perubahan akta perusahaan dapat terjadi karena perubahan direksi, pemegang saham, alamat kantor, modal, maupun kegiatan usaha. Semua perubahan tersebut perlu disesuaikan secara legal.',
//             'Dokumen pendukung, notulen, hingga penyesuaian data pada sistem administrasi perusahaan perlu dipastikan konsisten agar tidak memunculkan masalah pada tahap berikutnya.',
//             'Pendampingan profesional membantu proses perubahan akta menjadi lebih ringkas, akurat, dan sesuai dengan ketentuan yang berlaku.',
//         ],
//         'category' => 'Dokumen',
//         'date' => '2 Mei 2024',
//         'reading_time' => '5 menit baca',
//         'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80&fm=webp',
//     ],
//     [
//         'id' => 6,
//         'title' => 'Tips Menyiapkan Legalitas Bisnis Untuk Menarik Investor',
//         'excerpt' => 'Legalitas yang tertata rapi menjadi salah satu faktor penting ketika bisnis Anda mulai dilirik oleh investor atau mitra strategis.',
//         'content' => [
//             'Investor akan lebih percaya pada bisnis yang memiliki struktur legal yang jelas, dokumen korporasi yang tertata, dan kepatuhan administratif yang baik.',
//             'Selain Badan Usaha, aspek seperti perjanjian, perlindungan merek, pajak, dan perizinan operasional juga memengaruhi tingkat kesiapan bisnis untuk berkembang lebih besar.',
//             'Dengan fondasi legal yang kuat, perusahaan tidak hanya lebih siap untuk tumbuh, tetapi juga lebih meyakinkan dalam proses due diligence dan negosiasi bisnis.',
//         ],
//         'category' => 'Investasi',
//         'date' => '30 April 2024',
//         'reading_time' => '6 menit baca',
//         'image' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
//     ],
// ];

$staticPages = [
    '/',
    // '/promo',
    '/layanan',
    // '/artikel',
    // '/kbli',
    // '/faq',
    // '/tentang-kami',
    // '/kontak',
];

// Route::get('/robots.txt', function (Request $request) use ($resolveBaseUrl) {
//     $baseUrl = $resolveBaseUrl($request);

//     $content = implode("\n", [
//         'User-agent: *',
//         'Allow: /',
//         '',
//         'Sitemap: ' . $baseUrl . '/sitemap.xml',
//     ]);

//     return response($content, 200)->header('Content-Type', 'text/plain');
// });

// Route::get('/sitemap.xml', function (Request $request) use ($staticPages, $customServices, $articles, $resolveBaseUrl, $foundingProducts, $foundingPackages) {
//     $baseUrl = $resolveBaseUrl($request);

//     $urls = collect($staticPages)
//         ->map(fn ($path) => [
//             'loc' => $baseUrl . $path,
//             'lastmod' => now()->toDateString(),
//             'changefreq' => 'weekly',
//             'priority' => $path === '/' ? '1.0' : '0.8',
//         ])
//         ->merge(
//             collect($customServices)->map(fn ($service) => [
//                 'loc' => $baseUrl . $service['path'],
//                 'lastmod' => now()->toDateString(),
//                 'changefreq' => 'weekly',
//                 'priority' => '0.8',
//             ])
//         )
//         ->merge(
//             Service::query()->get()->map(fn ($service) => [
//                 'loc' => $baseUrl . '/layanan/' . $service->slug,
//                 'lastmod' => $service->updated_at?->toDateString() ?? now()->toDateString(),
//                 'changefreq' => 'monthly',
//                 'priority' => '0.7',
//             ])
//         )
//         ->merge(
//             collect($articles)->map(fn ($article) => [
//                 'loc' => $baseUrl . '/artikel/' . $article['id'],
//                 'lastmod' => now()->toDateString(),
//                 'changefreq' => 'monthly',
//                 'priority' => '0.7',
//             ])
//         )
//         ->merge(
//             collect($foundingProducts)->map(fn ($product) => [
//                 'loc' => $baseUrl . $product['detail_path'],
//                 'lastmod' => now()->toDateString(),
//                 'changefreq' => 'monthly',
//                 'priority' => '0.7',
//             ])
//         )
//         ->merge(
//             collect($foundingPackages)->map(fn ($package) => [
//                 'loc' => $baseUrl . '/badan-usaha/paket/' . $package['slug'],
//                 'lastmod' => now()->toDateString(),
//                 'changefreq' => 'monthly',
//                 'priority' => '0.7',
//             ])
//         )
//         ->unique('loc')
//         ->values();

//     $xml = view('sitemap', ['urls' => $urls])->render();

//     return response($xml, 200)->header('Content-Type', 'application/xml');
// });

foreach ($customServices as $service) {
    Route::get($service['path'], function (Request $request) use ($service, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema, $serviceSchema, $foundingProducts) {
        $baseUrl = $resolveBaseUrl($request);
        $props = [
            'service' => $service,
            'seo' => [
                'title' => $service['title'] . ' - FastTrack',
                'description' => $service['description'],
                'canonical' => $baseUrl . $service['path'],
                'image' => $defaultImageUrl($baseUrl),
            ],
            'schemas' => [
                $breadcrumbSchema([
                    ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                    ['name' => 'Layanan', 'item' => $baseUrl . '/layanan'],
                    ['name' => $service['title'], 'item' => $baseUrl . $service['path']],
                ]),
                $serviceSchema($baseUrl, $service, null),
            ],
        ];

        if ($service['path'] === '/badan-usaha') {
            $props['products'] = $foundingProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Pendirian Perusahaan - FastTrack',
                'description' => 'Daftar produk pendirian perusahaan FastTrack untuk PT, CV, Firma, PMA, yayasan, koperasi, dan perkumpulan.',
                'url' => $baseUrl . '/badan-usaha',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($foundingProducts)->values()->map(
                        static fn(array $product, int $index): array => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $product['name'],
                            'url' => $baseUrl . $product['detail_path'],
                        ]
                    )->all(),
                ],
            ];
        }

        return Inertia::render($service['component'], $props);
    });
}

// Route::get('/badan-usaha/1', function () {
//     return redirect('/badan-usaha/paket', 301);
// });

// Route::get('/badan-usaha/paket', function (Request $request) use ($foundingPackages, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     return Inertia::render('Services/BadanUsaha/Paket/Index', [
//         'packages' => $foundingPackages,
//         'seo' => [
//             'title' => 'Paket Pendirian PT - FastTrack',
//             'description' => 'Pilih paket pendirian PT yang sesuai: PT Persekutuan Modal atau PT Perorangan dengan alur legalitas yang lebih rapi dan profesional.',
//             'canonical' => $baseUrl . '/badan-usaha/paket',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'CollectionPage',
//                 'name' => 'Paket Pendirian PT - FastTrack',
//                 'description' => 'Pilihan paket pendirian PT untuk kebutuhan bisnis yang berbeda.',
//                 'url' => $baseUrl . '/badan-usaha/paket',
//                 'mainEntity' => [
//                     '@type' => 'ItemList',
//                     'itemListElement' => collect($foundingPackages)->values()->map(
//                         static fn (array $package, int $index): array => [
//                             '@type' => 'ListItem',
//                             'position' => $index + 1,
//                             'name' => $package['name'],
//                             'url' => $baseUrl . '/badan-usaha/paket/' . $package['slug'],
//                         ]
//                     )->all(),
//                 ],
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Pendirian Perusahaan', 'item' => $baseUrl . '/badan-usaha'],
//                 ['name' => 'Paket', 'item' => $baseUrl . '/badan-usaha/paket'],
//             ]),
//         ],
//     ]);
// });

// Route::get('/badan-usaha/paket/{slug}', function (Request $request, string $slug) use ($foundingPackages, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);
//     $package = collect($foundingPackages)->firstWhere('slug', $slug);

//     abort_if($package === null, 404);

//     return Inertia::render('Services/BadanUsaha/Paket/Show', [
//         'package' => $package,
//         'relatedPackages' => collect($foundingPackages)->where('slug', '!=', $slug)->values()->all(),
//         'seo' => [
//             'title' => $package['name'] . ' - FastTrack',
//             'description' => $package['excerpt'],
//             'canonical' => $baseUrl . '/badan-usaha/paket/' . $package['slug'],
//             'image' => $package['image'] ?: $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'Service',
//                 'name' => $package['name'],
//                 'description' => $package['excerpt'],
//                 'serviceType' => $package['name'],
//                 'provider' => $organizationReference($baseUrl),
//                 'areaServed' => [
//                     '@type' => 'Country',
//                     'name' => 'Indonesia',
//                 ],
//                 'image' => $package['image'] ?: $defaultImageUrl($baseUrl),
//                 'url' => $baseUrl . '/badan-usaha/paket/' . $package['slug'],
//                 'offers' => [
//                     '@type' => 'Offer',
//                     'priceCurrency' => 'IDR',
//                     'price' => $package['price'],
//                     'availability' => 'https://schema.org/InStock',
//                     'url' => $baseUrl . '/badan-usaha/paket/' . $package['slug'],
//                 ],
//             ],
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'FAQPage',
//                 'mainEntity' => collect($package['faq'])->map(
//                     static fn (array $faq): array => [
//                         '@type' => 'Question',
//                         'name' => $faq['question'],
//                         'acceptedAnswer' => [
//                             '@type' => 'Answer',
//                             'text' => $faq['answer'],
//                         ],
//                     ]
//                 )->all(),
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Pendirian Perusahaan', 'item' => $baseUrl . '/badan-usaha'],
//                 ['name' => 'Paket', 'item' => $baseUrl . '/badan-usaha/paket'],
//                 ['name' => $package['short_name'], 'item' => $baseUrl . '/badan-usaha/paket/' . $package['slug']],
//             ]),
//         ],
//     ]);
// });

Route::get('/badan-usaha/{id}', function (Request $request, int $id) use ($foundingProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($foundingProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($foundingProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/BadanUsaha/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $product['name'] . ' - FastTrack',
            'description' => $product['excerpt'],
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $product['name'],
                'description' => $product['excerpt'],
                'serviceType' => $product['name'],
                'provider' => $organizationReference($baseUrl),
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => 'Indonesia',
                ],
                'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
                'url' => $baseUrl . $product['detail_path'],
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'IDR',
                    'price' => $product['price'],
                    'availability' => 'https://schema.org/InStock',
                    'url' => $baseUrl . $product['detail_path'],
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => collect($product['faq'])->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['answer'],
                        ],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Pendirian Perusahaan', 'item' => $baseUrl . '/badan-usaha'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

Route::get('/layanan/{slug}', function (Request $request, $slug) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema, $serviceSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $service = Service::where('slug', $slug)->firstOrFail();

    return Inertia::render('Services/Show', [
        'service' => $service,
        'seo' => [
            'title' => $service->meta_title ?? $service->name . ' - FastTrack',
            'description' => $service->meta_description ?? $service->description,
            'canonical' => $baseUrl . '/layanan/' . $service->slug,
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Layanan', 'item' => $baseUrl . '/layanan'],
                ['name' => $service->name, 'item' => $baseUrl . '/layanan/' . $service->slug],
            ]),
            $serviceSchema($baseUrl, $service->toArray(), (string) $service->price),
        ],
    ]);
});

// Route::get('/artikel', function (Request $request) use ($articles, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     return Inertia::render('Blog', [
//         'articles' => $articles,
//         'seo' => [
//             'title' => 'Artikel & Edukasi Hukum Bisnis - FastTrack',
//             'description' => 'Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.',
//             'canonical' => $baseUrl . '/artikel',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'CollectionPage',
//                 'name' => 'Artikel & Edukasi Hukum Bisnis - FastTrack',
//                 'description' => 'Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.',
//                 'url' => $baseUrl . '/artikel',
//                 'mainEntity' => [
//                     '@type' => 'ItemList',
//                     'itemListElement' => collect($articles)->values()->map(
//                         static fn (array $article, int $index): array => [
//                             '@type' => 'ListItem',
//                             'position' => $index + 1,
//                             'name' => $article['title'],
//                             'url' => $baseUrl . '/artikel/' . $article['id'],
//                         ]
//                     )->all(),
//                 ],
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Artikel', 'item' => $baseUrl . '/artikel'],
//             ]),
//         ],
//     ]);
// });

// Route::get('/artikel/{id}', function (Request $request, int $id) use ($articles, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);
//     $article = collect($articles)->firstWhere('id', $id);

//     abort_if($article === null, 404);

//     $relatedArticles = collect($articles)
//         ->where('id', '!=', $id)
//         ->take(3)
//         ->values()
//         ->all();

//     return Inertia::render('Articles/Show', [
//         'article' => $article,
//         'relatedArticles' => $relatedArticles,
//         'seo' => [
//             'title' => $article['title'] . ' - FastTrack',
//             'description' => $article['excerpt'],
//             'canonical' => $baseUrl . '/artikel/' . $article['id'],
//             'image' => $article['image'] ?: $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'Article',
//                 'headline' => $article['title'],
//                 'description' => $article['excerpt'],
//                 'image' => $article['image'] ?: $defaultImageUrl($baseUrl),
//                 'author' => $organizationReference($baseUrl),
//                 'publisher' => $organizationReference($baseUrl),
//                 'datePublished' => '2024-05-12',
//                 'dateModified' => now()->toDateString(),
//                 'mainEntityOfPage' => $baseUrl . '/artikel/' . $article['id'],
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Artikel', 'item' => $baseUrl . '/artikel'],
//                 ['name' => $article['title'], 'item' => $baseUrl . '/artikel/' . $article['id']],
//             ]),
//         ],
//     ]);
// });

// Route::get('/kbli', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     return Inertia::render('Kbli', [
//         'seo' => [
//             'title' => 'Panduan KBLI - FastTrack',
//             'description' => 'Pelajari fungsi dan pemilihan KBLI yang tepat untuk legalitas bisnis Anda.',
//             'canonical' => $baseUrl . '/kbli',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'Article',
//                 'headline' => 'Panduan KBLI - FastTrack',
//                 'description' => 'Pelajari fungsi dan pemilihan KBLI yang tepat untuk legalitas bisnis Anda.',
//                 'author' => $organizationReference($baseUrl),
//                 'publisher' => $organizationReference($baseUrl),
//                 'mainEntityOfPage' => $baseUrl . '/kbli',
//                 'image' => $defaultImageUrl($baseUrl),
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'KBLI', 'item' => $baseUrl . '/kbli'],
//             ]),
//         ],
//     ]);
// });

// Route::get('/faq', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     return Inertia::render('Faq', [
//         'seo' => [
//             'title' => 'FAQ - FastTrack',
//             'description' => 'Jawaban untuk pertanyaan umum terkait legalitas bisnis dan layanan FastTrack.',
//             'canonical' => $baseUrl . '/faq',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'FAQPage',
//                 'mainEntity' => [
//                     [
//                         '@type' => 'Question',
//                         'name' => 'Berapa lama proses pendirian PT?',
//                         'acceptedAnswer' => [
//                             '@type' => 'Answer',
//                             'text' => 'Estimasi waktu bervariasi tergantung kelengkapan dokumen, namun umumnya proses dasar dapat dimulai dalam beberapa hari kerja.',
//                         ],
//                     ],
//                     [
//                         '@type' => 'Question',
//                         'name' => 'Apakah FastTrack membantu memilih KBLI?',
//                         'acceptedAnswer' => [
//                             '@type' => 'Answer',
//                             'text' => 'Ya, kami membantu mencocokkan aktivitas bisnis Anda dengan KBLI yang paling relevan untuk kebutuhan OSS dan legalitas.',
//                         ],
//                     ],
//                     [
//                         '@type' => 'Question',
//                         'name' => 'Apakah layanan konsultasi tersedia secara online?',
//                         'acceptedAnswer' => [
//                             '@type' => 'Answer',
//                             'text' => 'Tersedia. Anda dapat menghubungi tim kami melalui form konsultasi atau WhatsApp untuk diskusi awal.',
//                         ],
//                     ],
//                 ],
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'FAQ', 'item' => $baseUrl . '/faq'],
//             ]),
//         ],
//     ]);
// });

// Route::get('/tentang-kami', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     return Inertia::render('About', [
//         'seo' => [
//             'title' => 'Tentang Kami - FastTrack',
//             'description' => 'Kenali filosofi, visi misi, komitmen, keunggulan, dan tim profesional FastTrack.',
//             'canonical' => $baseUrl . '/tentang-kami',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'AboutPage',
//                 'name' => 'Tentang Kami - FastTrack',
//                 'description' => 'Kenali filosofi, visi misi, komitmen, keunggulan, dan tim profesional FastTrack.',
//                 'url' => $baseUrl . '/tentang-kami',
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Tentang Kami', 'item' => $baseUrl . '/tentang-kami'],
//             ]),
//         ],
//     ]);
// });

// Route::get('/kontak', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
//     $baseUrl = $resolveBaseUrl($request);

//     return Inertia::render('Contact', [
//         'seo' => [
//             'title' => 'Hubungi Kami - FastTrack',
//             'description' => 'Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami.',
//             'canonical' => $baseUrl . '/kontak',
//             'image' => $defaultImageUrl($baseUrl),
//         ],
//         'schemas' => [
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'ContactPage',
//                 'name' => 'Hubungi Kami - FastTrack',
//                 'description' => 'Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami.',
//                 'url' => $baseUrl . '/kontak',
//             ],
//             [
//                 '@context' => 'https://schema.org',
//                 '@type' => 'LegalService',
//                 'name' => 'FastTrack Legalitas',
//                 'image' => $defaultImageUrl($baseUrl),
//                 'url' => $baseUrl,
//                 'telephone' => '+622173885036',
//                 'email' => 'cs@fasttrack.legal',
//                 'address' => [
//                     '@type' => 'PostalAddress',
//                     'streetAddress' => 'Grand Bintaro Blok A7, Jl. Raya Bintaro Permai, Pesanggrahan, Bintaro',
//                     'addressLocality' => 'Jakarta Selatan',
//                     'postalCode' => '12330',
//                     'addressCountry' => 'ID',
//                 ],
//                 'contactPoint' => [
//                     '@type' => 'ContactPoint',
//                     'telephone' => '+6282298604144',
//                     'contactType' => 'customer service',
//                     'email' => 'cs@fasttrack.legal',
//                     'areaServed' => 'ID',
//                     'availableLanguage' => ['id', 'en'],
//                 ],
//                 'openingHoursSpecification' => [
//                     '@type' => 'OpeningHoursSpecification',
//                     'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
//                     'opens' => '09:00',
//                     'closes' => '17:00',
//                 ],
//             ],
//             $breadcrumbSchema([
//                 ['name' => 'Beranda', 'item' => $baseUrl . '/'],
//                 ['name' => 'Kontak', 'item' => $baseUrl . '/kontak'],
//             ]),
//         ],
//     ]);
// });

Route::get('/kebijakan-cookie', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('CookiePolicy', [
        'seo' => [
            'title' => 'Kebijakan Cookie - FastTrack',
            'description' => 'Kebijakan cookie FastTrack. Pelajari bagaimana kami menggunakan cookie dan teknologi serupa untuk meningkatkan pengalaman Anda.',
            'canonical' => $baseUrl . '/kebijakan-cookie',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Kebijakan Cookie - FastTrack',
                'description' => 'Kebijakan cookie FastTrack. Pelajari bagaimana kami menggunakan cookie dan teknologi serupa untuk meningkatkan pengalaman Anda.',
                'url' => $baseUrl . '/kebijakan-cookie',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Kebijakan Cookie', 'item' => $baseUrl . '/kebijakan-cookie'],
            ]),
        ],
    ]);
});

Route::get('/kebijakan-privasi', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('PrivacyPolicy', [
        'seo' => [
            'title' => 'Kebijakan Privasi - FastTrack',
            'description' => 'Kebijakan privasi FastTrack. Pelajari bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda.',
            'canonical' => $baseUrl . '/kebijakan-privasi',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Kebijakan Privasi - FastTrack',
                'description' => 'Kebijakan privasi FastTrack. Pelajari bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda.',
                'url' => $baseUrl . '/kebijakan-privasi',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Kebijakan Privasi', 'item' => $baseUrl . '/kebijakan-privasi'],
            ]),
        ],
    ]);
});

Route::get('/syarat-ketentuan', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('TermCondition', [
        'seo' => [
            'title' => 'Syarat dan Ketentuan - FastTrack',
            'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
            'canonical' => $baseUrl . '/syarat-ketentuan',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Syarat dan Ketentuan - FastTrack',
                'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
                'url' => $baseUrl . '/syarat-ketentuan',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Syarat dan Ketentuan', 'item' => $baseUrl . '/syarat-ketentuan'],
            ]),
        ],
    ]);
});

// require __DIR__.'/auth.php';
