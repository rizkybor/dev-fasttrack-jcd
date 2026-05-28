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

$defaultImageUrl = static fn (string $baseUrl): string => $baseUrl . '/favicon.ico';

$organizationReference = static fn (string $baseUrl): array => [
    '@type' => 'Organization',
    'name' => 'FastTrack',
    'url' => $baseUrl,
];

$breadcrumbSchema = static function (array $items): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(
            static fn (array $item, int $index): array => [
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

Route::get('/promo', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    $promoItems = [
        'Promo Pendirian PT Hemat 30%',
        'Bundling PT + Virtual Office',
        'Diskon Pendirian CV Untuk UMKM',
        'Promo Pendaftaran Merek',
        'Paket Perubahan Akta Cepat',
        'Paket Perizinan OSS & NIB',
        'Promo Konsultasi Hukum Perusahaan',
        'Promo Launching Website Bisnis',
        'Promo Virtual Office Premium',
        'Promo Laporan LKPM',
        'Promo Investor Asing',
        'Promo Pengurusan Izin Properti',
    ];

    return Inertia::render('Promo', [
        'seo' => [
            'title' => 'Promo Legalitas Bisnis - FastTrack',
            'description' => 'Temukan promo legalitas bisnis FastTrack untuk pendirian PT, CV, HAKI, virtual office, perizinan usaha, dan layanan profesional lainnya.',
            'canonical' => $baseUrl . '/promo',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Promo Legalitas Bisnis - FastTrack',
                'description' => 'Halaman promo FastTrack berisi penawaran legalitas bisnis, virtual office, HAKI, dan layanan profesional lainnya.',
                'url' => $baseUrl . '/promo',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'numberOfItems' => count($promoItems),
                    'itemListElement' => collect($promoItems)->values()->map(
                        static fn (string $name, int $index): array => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $name,
                            'url' => $baseUrl . '/promo',
                        ]
                    )->all(),
                ],
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Promo', 'item' => $baseUrl . '/promo'],
            ]),
        ],
    ]);
});

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
                'hasPart' => $services->map(static fn (Service $service): array => [
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
    ['component' => 'Services/PendirianPerusahaan/Index', 'title' => 'Pendirian Perusahaan', 'path' => '/pendirian-perusahaan', 'description' => 'Membantu Anda menjalankan bisnis dengan legalitas serta badan usaha yang bonafide.'],
    ['component' => 'Services/PenutupanPerusahaan/Index', 'title' => 'Penutupan Perusahaan', 'path' => '/penutupan-perusahaan', 'description' => 'Proses penutupan perusahaan yang sesuai dengan prosedur hukum yang berlaku.'],
    ['component' => 'Services/VirtualOffice/Index', 'title' => 'Virtual Office', 'path' => '/virtual-office-jakarta', 'description' => 'Layanan alamat bisnis prestisius untuk meningkatkan citra perusahaan Anda.'],
    ['component' => 'Services/PerizinanKhusus/Index', 'title' => 'Perizinan Khusus', 'path' => '/perizinan', 'description' => 'Pengurusan izin khusus untuk berbagai sektor bisnis sesuai regulasi terbaru.'],
    ['component' => 'Services/PembuatanPerjanjian/Index', 'title' => 'Pembuatan dan Peninjauan Perjanjian', 'path' => '/pembuatan-perjanjian', 'description' => 'Penyusunan dan review kontrak bisnis untuk melindungi kepentingan Anda.'],
    ['component' => 'Services/PerubahanAkta/Index', 'title' => 'Pembuatan dan Perubahan Dokumen Perusahaan', 'path' => '/perubahan-akta', 'description' => 'Layanan perubahan akta dan penyesuaian dokumen perusahaan.'],
    ['component' => 'Services/DigitalMarketing/Index', 'title' => 'Digital Marketing', 'path' => '/digital-marketing', 'description' => 'Strategi pemasaran digital terpadu untuk meningkatkan pertumbuhan bisnis Anda.'],
    ['component' => 'Services/PerizinanUsaha/Index', 'title' => 'Perizinan Usaha', 'path' => '/perizinan-usaha', 'description' => 'Solusi perizinan usaha menyeluruh melalui sistem OSS dan NIB.'],
    ['component' => 'Services/IzinTax/Index', 'title' => 'Izin Tax', 'path' => '/perpajakan', 'description' => 'Layanan perpajakan dan pembukuan profesional untuk kepatuhan bisnis.'],
    ['component' => 'Services/IzinHaki/Index', 'title' => 'Izin HAKI', 'path' => '/haki', 'description' => 'Perlindungan Hak Kekayaan Intelektual untuk merek dan karya Anda.'],
    ['component' => 'Services/InvestInAsia/Index', 'title' => 'Invest in Asia', 'path' => '/foreignservice', 'description' => 'Layanan profesional untuk pendirian perusahaan bagi investor asing di Indonesia.'],
    ['component' => 'Services/IzinHukum/Index', 'title' => 'Izin Hukum', 'path' => '/hukum', 'description' => 'Solusi hukum profesional dengan biaya yang transparan.'],
    ['component' => 'Services/IzinProperti/Index', 'title' => 'Izin Properti', 'path' => '/izin-properti', 'description' => 'Solusi untuk mengurus seluruh kebutuhan legalitas seputar tanah dan properti.'],
    ['component' => 'Services/IzinPrivilege/Index', 'title' => 'Izin Privilege', 'path' => '/izin-privilege', 'description' => 'Benefit eksklusif untuk Klien yang menggunakan layanan khusus FastTrack.'],
    ['component' => 'Services/LayananLainnya/Index', 'title' => 'Layanan Lainnya', 'path' => '/layanan-lain', 'description' => 'Berbagai layanan tambahan untuk mendukung kelancaran operasional bisnis Anda.']
];

$foundingProducts = [
    [
        'id' => 1,
        'name' => 'Paket Pendirian PT',
        'tag' => 'Paling Diminati',
        'price' => '5500000',
        'price_label' => 'Rp 5.500.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Solusi pendirian Perseroan Terbatas untuk bisnis yang ingin tampil kredibel, siap bekerja sama dengan klien korporasi, dan bertumbuh secara profesional.',
        'excerpt' => 'Paket pendirian PT untuk usaha yang membutuhkan badan hukum terpisah, perlindungan tanggung jawab, dan kesiapan ekspansi.',
        'audience' => 'Cocok untuk startup, agency, distributor, manufaktur, konsultan, dan bisnis yang menargetkan pertumbuhan jangka panjang.',
        'content' => [
            'Perseroan Terbatas menjadi bentuk badan usaha yang paling sering dipilih ketika bisnis mulai membutuhkan struktur yang lebih tertata, pemisahan tanggung jawab yang lebih jelas, dan kredibilitas yang lebih kuat di mata mitra maupun investor.',
            'Melalui paket pendirian PT, FastTrack membantu Anda mulai dari diskusi struktur usaha, pemilihan KBLI, pengecekan nama perusahaan, penyusunan dokumen pendirian, hingga pendampingan pada proses legalitas dasar yang dibutuhkan agar bisnis dapat segera berjalan.',
            'Layanan ini tidak hanya berfokus pada terbitnya dokumen, tetapi juga memastikan fondasi legal bisnis Anda selaras dengan kebutuhan operasional dan rencana pengembangan usaha.',
        ],
        'benefits' => [
            'Badan hukum terpisah yang lebih kredibel untuk kerja sama bisnis',
            'Pendampingan pemilihan KBLI dan struktur usaha sejak awal',
            'Dokumen pendirian disusun lebih rapi dan mudah ditindaklanjuti',
            'Lebih siap untuk kebutuhan investor, tender, dan kemitraan',
        ],
        'requirements' => [
            'Nama perusahaan dan alternatif cadangan',
            'Data pendiri, pengurus, dan komposisi kepemilikan',
            'Alamat usaha yang akan digunakan',
            'Rencana kegiatan usaha untuk penentuan KBLI',
        ],
        'process' => [
            'Konsultasi awal untuk memahami model bisnis dan kebutuhan legalitas',
            'Verifikasi data, penyusunan struktur, dan pemilihan KBLI',
            'Penyusunan dokumen pendirian dan pengurusan legalitas dasar',
            'Serah terima dokumen dan arahan langkah lanjutan bisnis',
        ],
        'faq' => [
            ['question' => 'Kapan sebaiknya memilih PT?', 'answer' => 'PT cocok ketika bisnis membutuhkan badan hukum terpisah, struktur yang lebih profesional, dan kesiapan untuk kerja sama yang lebih luas.'],
            ['question' => 'Apakah FastTrack membantu memilih KBLI?', 'answer' => 'Ya, tim FastTrack membantu mencocokkan aktivitas usaha dengan KBLI yang paling relevan agar proses legalitas lebih aman dan efisien.'],
        ],
    ],
    [
        'id' => 2,
        'name' => 'Paket Pendirian CV',
        'tag' => 'UMKM Favorit',
        'price' => '3500000',
        'price_label' => 'Rp 3.500.000',
        'duration' => 'Estimasi 5-10 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Pilihan praktis untuk pelaku usaha yang membutuhkan legalitas usaha dengan proses yang efisien dan biaya lebih terjangkau.',
        'excerpt' => 'Paket pendirian CV untuk UMKM dan bisnis jasa yang ingin segera memiliki legalitas usaha dengan proses yang efisien.',
        'audience' => 'Cocok untuk UMKM, bisnis keluarga, kontraktor kecil, perdagangan, dan penyedia jasa lokal.',
        'content' => [
            'Commanditaire Vennootschap atau CV sering menjadi pilihan pelaku usaha yang ingin segera memiliki legalitas bisnis dengan proses yang relatif efisien.',
            'Bentuk usaha ini banyak digunakan oleh bisnis skala kecil hingga menengah yang memerlukan identitas usaha resmi untuk operasional, kerja sama dengan vendor, maupun pengurusan izin lanjutan.',
            'FastTrack membantu proses pendirian CV agar lebih ringkas, mulai dari pemeriksaan data, penyusunan dokumen, hingga memastikan kebutuhan dasar legalitas Anda tertangani dengan jelas.',
        ],
        'benefits' => [
            'Biaya awal lebih efisien untuk legalitas usaha',
            'Proses pendirian ringkas dan mudah dipahami',
            'Cocok untuk bisnis operasional yang ingin segera berjalan',
            'Pendampingan agar dokumen dan data usaha lebih tertata',
        ],
        'requirements' => [
            'Nama usaha dan data sekutu aktif maupun pasif',
            'Alamat usaha dan kegiatan usaha utama',
            'Identitas para pihak yang terlibat',
            'Informasi modal awal dan gambaran operasional',
        ],
        'process' => [
            'Diskusi singkat untuk menentukan struktur CV yang sesuai',
            'Pengumpulan data dan pengecekan kesiapan dokumen',
            'Penyusunan dokumen pendirian dan pengurusan legalitas dasar',
            'Finalisasi dokumen dan briefing penggunaan dokumen usaha',
        ],
        'faq' => [
            ['question' => 'Apa keunggulan CV dibanding usaha perorangan?', 'answer' => 'CV memberi bentuk usaha yang lebih formal dan sering lebih mudah diterima dalam kerja sama bisnis tertentu.'],
            ['question' => 'Siapa yang cocok memakai CV?', 'answer' => 'CV cocok untuk usaha skala kecil hingga menengah yang membutuhkan legalitas operasional namun tetap ingin proses yang efisien.'],
        ],
    ],
    [
        'id' => 3,
        'name' => 'Paket Pendirian Firma',
        'tag' => 'Profesional',
        'price' => '4200000',
        'price_label' => 'Rp 4.200.000',
        'duration' => 'Estimasi 7-12 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Dirancang untuk usaha bersama yang dibangun atas kepercayaan dan keterlibatan aktif para sekutu dalam operasional bisnis.',
        'excerpt' => 'Paket pendirian firma untuk usaha profesional yang dijalankan bersama oleh para sekutu aktif.',
        'audience' => 'Cocok untuk kantor konsultan, firma profesional, studio kreatif, dan usaha berbasis kemitraan aktif.',
        'content' => [
            'Firma umum digunakan ketika beberapa pihak ingin menjalankan usaha bersama dengan keterlibatan aktif dalam pengelolaan bisnis sehari-hari.',
            'Karena karakter firma sangat menekankan kepercayaan dan tanggung jawab antar sekutu, penyusunan struktur, ruang lingkup wewenang, dan dokumen pendirian perlu dipikirkan secara matang sejak awal.',
            'FastTrack membantu Anda memahami implikasi bentuk usaha ini, sekaligus menyusun dokumen yang lebih terarah agar hubungan kerja sama para sekutu menjadi lebih jelas.',
        ],
        'benefits' => [
            'Struktur kerja sama aktif antarsekutu lebih jelas',
            'Cocok untuk usaha profesional berbasis reputasi',
            'Dokumen pendirian membantu mengurangi potensi salah paham',
            'Pendampingan penyesuaian model bisnis dan legalitas',
        ],
        'requirements' => [
            'Data seluruh sekutu yang terlibat',
            'Kesepakatan pembagian peran dan kewenangan',
            'Alamat dan ruang lingkup usaha firma',
            'Nama usaha dan data identitas pendukung',
        ],
        'process' => [
            'Konsultasi model kemitraan dan struktur peran para sekutu',
            'Pengecekan data, nama usaha, dan ruang lingkup kegiatan',
            'Penyusunan dokumen pendirian dan kelengkapan legalitas',
            'Serah terima dokumen serta arahan implementasi',
        ],
        'faq' => [
            ['question' => 'Apa pembeda firma dengan CV?', 'answer' => 'Firma umumnya menekankan keterlibatan aktif para sekutu dalam menjalankan usaha, sedangkan CV mengenal sekutu aktif dan pasif.'],
            ['question' => 'Apakah firma cocok untuk usaha jasa profesional?', 'answer' => 'Ya, firma sering digunakan untuk usaha yang dibangun atas reputasi dan keterlibatan aktif para pendirinya.'],
        ],
    ],
    [
        'id' => 4,
        'name' => 'Persekutuan Perdata',
        'tag' => 'Kolaboratif',
        'price' => '3900000',
        'price_label' => 'Rp 3.900.000',
        'duration' => 'Estimasi 5-10 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Solusi legal untuk para pihak yang ingin bekerja sama secara perdata dengan pengaturan kontribusi, tujuan, dan pembagian tanggung jawab yang lebih jelas.',
        'excerpt' => 'Paket persekutuan perdata untuk kerja sama usaha atau proyek yang membutuhkan struktur perdata yang lebih tertata.',
        'audience' => 'Cocok untuk kolaborasi proyek, konsorsium kecil, studio, klinik, dan kerja sama profesional tertentu.',
        'content' => [
            'Persekutuan perdata sering digunakan untuk kerja sama usaha atau profesi yang mengutamakan kesepakatan antar pihak mengenai kontribusi, tujuan, dan pembagian hasil.',
            'Struktur ini menuntut kejelasan dalam ruang lingkup kerja sama agar hak dan kewajiban masing-masing pihak tidak menimbulkan sengketa di kemudian hari.',
            'FastTrack membantu menyiapkan dasar legalnya dengan pendekatan yang terstruktur agar kerja sama dapat berjalan lebih tertib sejak awal.',
        ],
        'benefits' => [
            'Pengaturan hak dan kewajiban para pihak lebih jelas',
            'Mendukung kerja sama usaha atau proyek secara profesional',
            'Meminimalkan salah tafsir dalam pembagian kontribusi',
            'Lebih siap untuk kerja sama jangka menengah dan panjang',
        ],
        'requirements' => [
            'Data para pihak yang akan bersekutu',
            'Tujuan kerja sama dan bentuk kontribusi masing-masing',
            'Alamat korespondensi dan ruang lingkup kegiatan',
            'Kesepakatan awal pembagian hasil atau manfaat',
        ],
        'process' => [
            'Konsultasi struktur kerja sama perdata yang diinginkan',
            'Identifikasi hak, kewajiban, dan kontribusi para pihak',
            'Penyusunan dokumen dasar dan penguatan legalitas',
            'Finalisasi dokumen kerja sama dan arahan implementasi',
        ],
        'faq' => [
            ['question' => 'Apakah persekutuan perdata cocok untuk proyek bersama?', 'answer' => 'Ya, bentuk ini sering dipakai ketika beberapa pihak ingin berkolaborasi dengan pembagian kontribusi yang jelas.'],
            ['question' => 'Mengapa dokumen kerja sama harus detail?', 'answer' => 'Dokumen yang detail membantu mengurangi potensi sengketa dan membuat pelaksanaan kerja sama lebih terukur.'],
        ],
    ],
    [
        'id' => 5,
        'name' => 'PMA',
        'tag' => 'Investor Asing',
        'price' => '12500000',
        'price_label' => 'Rp 12.500.000',
        'duration' => 'Estimasi 14-30 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Paket pendirian PMA untuk investor asing yang ingin masuk ke pasar Indonesia dengan struktur legal yang lebih siap dan terarah.',
        'excerpt' => 'Paket PMA untuk investor asing atau joint venture yang ingin membangun bisnis resmi di Indonesia.',
        'audience' => 'Cocok untuk investor asing, joint venture, holding regional, dan bisnis ekspansi lintas negara.',
        'content' => [
            'Perusahaan Penanaman Modal Asing atau PMA membutuhkan pendekatan yang lebih hati-hati karena menyangkut kepatuhan investasi, struktur kepemilikan, perizinan, dan kelayakan model bisnis di Indonesia.',
            'Dalam banyak kasus, investor asing tidak hanya membutuhkan dokumen pendirian, tetapi juga membutuhkan pemetaan langkah, pemahaman regulasi, dan komunikasi yang jelas mengenai prosesnya.',
            'FastTrack mendampingi tahap awal pendirian PMA dengan bahasa yang lebih mudah dipahami dan workflow yang dirancang agar proses lebih efisien dan minim kebingungan.',
        ],
        'benefits' => [
            'Pendampingan awal untuk memahami struktur PMA',
            'Komunikasi proses yang lebih jelas untuk investor',
            'Membantu menyesuaikan model bisnis dengan kebutuhan legal',
            'Lebih siap untuk ekspansi bisnis lintas negara',
        ],
        'requirements' => [
            'Data pemegang saham dan struktur kepemilikan',
            'Rencana bisnis serta aktivitas usaha utama',
            'Alamat usaha dan data pengurus perusahaan',
            'Dokumen identitas dan data korporasi yang relevan',
        ],
        'process' => [
            'Kickoff meeting untuk memahami tujuan investasi dan model usaha',
            'Review struktur kepemilikan, ruang lingkup usaha, dan kesiapan data',
            'Penyusunan dokumen pendirian dan koordinasi legalitas dasar',
            'Serah terima dokumen dan pengarahan langkah lanjutan operasional',
        ],
        'faq' => [
            ['question' => 'Apakah PMA cocok untuk joint venture?', 'answer' => 'Ya, PMA sering menjadi opsi untuk kolaborasi investasi asing yang memerlukan entitas resmi di Indonesia.'],
            ['question' => 'Mengapa PMA memerlukan pendampingan lebih detail?', 'answer' => 'Karena pendirian PMA berkaitan dengan struktur investasi dan kepatuhan yang umumnya lebih kompleks dibanding badan usaha lokal biasa.'],
        ],
    ],
    [
        'id' => 6,
        'name' => 'Pendirian Yayasan',
        'tag' => 'Sosial & Pendidikan',
        'price' => '4800000',
        'price_label' => 'Rp 4.800.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Layanan pendirian yayasan untuk kegiatan sosial, pendidikan, keagamaan, dan kemanusiaan dengan struktur dokumen yang tertib.',
        'excerpt' => 'Paket pendirian yayasan untuk organisasi nirlaba yang membutuhkan dasar hukum yang lebih jelas dan profesional.',
        'audience' => 'Cocok untuk lembaga pendidikan, kegiatan sosial, komunitas keagamaan, dan organisasi kemanusiaan.',
        'content' => [
            'Yayasan banyak dipilih untuk kegiatan nirlaba yang berorientasi pada tujuan sosial, pendidikan, keagamaan, atau kemanusiaan.',
            'Agar yayasan dapat berjalan dengan baik, penting untuk merancang struktur pembina, pengurus, dan pengawas secara proporsional serta memastikan tujuan organisasi dituangkan dengan jelas.',
            'FastTrack membantu pendirian yayasan secara lebih rapi agar organisasi Anda memiliki fondasi legal yang siap digunakan untuk operasional maupun kolaborasi ke depan.',
        ],
        'benefits' => [
            'Struktur organisasi yayasan lebih jelas sejak awal',
            'Dokumen tujuan dan kegiatan lebih tertata',
            'Mendukung kerja sama dengan donor atau mitra institusi',
            'Pendampingan proses legalitas yang mudah dipahami',
        ],
        'requirements' => [
            'Nama yayasan dan tujuan utama organisasi',
            'Data pembina, pengurus, dan pengawas',
            'Alamat domisili yayasan',
            'Rencana kegiatan pokok dan dukungan data identitas',
        ],
        'process' => [
            'Diskusi tujuan yayasan dan struktur organisasi',
            'Pengumpulan data serta validasi kebutuhan dokumen',
            'Penyusunan dokumen pendirian dan pengurusan legalitas awal',
            'Serah terima dokumen dan pengarahan operasional dasar',
        ],
        'faq' => [
            ['question' => 'Apakah yayasan bisa dipakai untuk kegiatan sosial dan pendidikan?', 'answer' => 'Ya, yayasan umum dipakai untuk kegiatan nirlaba di bidang sosial, pendidikan, keagamaan, dan kemanusiaan.'],
            ['question' => 'Mengapa struktur pengurus yayasan penting?', 'answer' => 'Karena struktur pengurus yang jelas membantu organisasi berjalan lebih tertib dan akuntabel.'],
        ],
    ],
    [
        'id' => 7,
        'name' => 'Pendirian Koperasi',
        'tag' => 'Komunitas Tumbuh',
        'price' => '6500000',
        'price_label' => 'Rp 6.500.000',
        'duration' => 'Estimasi 10-20 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Pendampingan pendirian koperasi untuk komunitas, asosiasi, atau kelompok usaha yang ingin tumbuh bersama secara lebih terstruktur.',
        'excerpt' => 'Paket pendirian koperasi untuk kelompok usaha atau komunitas yang ingin memiliki wadah legal yang lebih kuat.',
        'audience' => 'Cocok untuk koperasi karyawan, koperasi simpan pinjam, komunitas usaha, dan asosiasi ekonomi bersama.',
        'content' => [
            'Koperasi menjadi pilihan tepat bagi kelompok usaha atau komunitas yang ingin berkembang bersama dengan prinsip kebersamaan dan manfaat kolektif.',
            'Pendirian koperasi memerlukan kesiapan struktur anggota, tujuan organisasi, dan pengelolaan yang lebih disiplin agar tata kelolanya sehat sejak awal.',
            'FastTrack membantu Anda menyiapkan dasar legal koperasi agar pembentukan organisasi, dokumen, dan arah operasionalnya lebih tertib.',
        ],
        'benefits' => [
            'Mendukung pertumbuhan ekonomi bersama dalam satu wadah legal',
            'Struktur anggota dan pengurus lebih terorganisir',
            'Dokumen koperasi lebih siap untuk operasional dan koordinasi',
            'Pendampingan proses yang ramah bagi komunitas atau kelompok usaha',
        ],
        'requirements' => [
            'Data pendiri atau anggota awal koperasi',
            'Tujuan, jenis koperasi, dan ruang lingkup kegiatan',
            'Data pengurus yang akan ditunjuk',
            'Alamat dan dokumen identitas pendukung',
        ],
        'process' => [
            'Konsultasi tipe koperasi dan tujuan pembentukannya',
            'Verifikasi data anggota, pengurus, dan ruang lingkup kegiatan',
            'Penyusunan dokumen pendirian serta koordinasi legalitas',
            'Finalisasi dokumen dan arahan langkah awal operasional koperasi',
        ],
        'faq' => [
            ['question' => 'Apakah koperasi cocok untuk komunitas usaha?', 'answer' => 'Ya, koperasi sangat relevan untuk kelompok yang ingin bertumbuh bersama secara kolektif dan terstruktur.'],
            ['question' => 'Apa manfaat legalitas koperasi?', 'answer' => 'Legalitas membantu koperasi berjalan lebih tertib, mudah berkoordinasi, dan lebih dipercaya oleh para anggotanya maupun mitra.'],
        ],
    ],
    [
        'id' => 8,
        'name' => 'Pendirian Perkumpulan',
        'tag' => 'Komunitas Resmi',
        'price' => '4300000',
        'price_label' => 'Rp 4.300.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Layanan pendirian perkumpulan untuk organisasi berbasis komunitas, hobi, profesi, atau kepentingan bersama yang ingin tampil lebih resmi.',
        'excerpt' => 'Paket pendirian perkumpulan untuk komunitas atau organisasi keanggotaan yang membutuhkan legalitas formal.',
        'audience' => 'Cocok untuk komunitas profesi, asosiasi, organisasi hobi, dan kelompok kepentingan bersama.',
        'content' => [
            'Perkumpulan cocok untuk komunitas atau organisasi yang dibangun atas dasar kesamaan minat, profesi, atau tujuan bersama dan ingin memiliki identitas hukum yang lebih resmi.',
            'Dengan legalitas yang lebih jelas, perkumpulan akan lebih siap dalam koordinasi keanggotaan, penyelenggaraan kegiatan, maupun kerja sama dengan pihak eksternal.',
            'FastTrack membantu proses pendiriannya dengan pendekatan yang praktis agar komunitas Anda dapat fokus pada pertumbuhan organisasi tanpa terbebani proses administratif yang membingungkan.',
        ],
        'benefits' => [
            'Status organisasi lebih resmi dan profesional',
            'Memudahkan koordinasi kegiatan dan keanggotaan',
            'Lebih siap untuk kolaborasi dengan sponsor atau mitra',
            'Pendampingan legalitas komunitas secara lebih praktis',
        ],
        'requirements' => [
            'Nama organisasi dan tujuan perkumpulan',
            'Data pendiri dan pengurus awal',
            'Alamat domisili atau alamat korespondensi',
            'Rencana kegiatan inti organisasi',
        ],
        'process' => [
            'Konsultasi tujuan organisasi dan bentuk perkumpulan',
            'Pengumpulan data pendiri, pengurus, dan aktivitas organisasi',
            'Penyusunan dokumen pendirian dan koordinasi legalitas',
            'Penyerahan dokumen dan arahan pengelolaan dasar organisasi',
        ],
        'faq' => [
            ['question' => 'Apakah perkumpulan cocok untuk asosiasi profesi?', 'answer' => 'Ya, perkumpulan banyak dipilih oleh asosiasi profesi atau komunitas yang ingin memiliki struktur organisasi lebih formal.'],
            ['question' => 'Apa manfaat legalitas perkumpulan?', 'answer' => 'Legalitas membuat organisasi lebih mudah dipercaya, lebih tertata, dan lebih siap menjalin kerja sama eksternal.'],
        ],
    ],
];

$foundingProducts = collect($foundingProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = $product['id'] === 1
            ? '/pendirian-perusahaan/paket'
            : '/pendirian-perusahaan/' . $product['id'];

        return $product;
    })
    ->all();

$foundingPackages = [
    [
        'id' => 1,
        'slug' => 'persekutuan-modal',
        'name' => 'PT Persekutuan Modal',
        'short_name' => 'Persekutuan Modal',
        'tag' => 'Pilihan Umum',
        'price' => '5500000',
        'price_label' => 'Rp 5.500.000',
        'duration' => 'Estimasi 7-14 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Pilihan paket untuk pendirian PT dengan lebih dari satu pihak pemegang saham yang ingin membangun perusahaan dengan struktur modal yang jelas dan profesional.',
        'excerpt' => 'Paket PT Persekutuan Modal untuk bisnis dengan dua pihak atau lebih yang ingin memiliki badan hukum Perseroan Terbatas.',
        'audience' => 'Cocok untuk founder bersama, agency, distributor, bisnis keluarga modern, dan perusahaan yang akan berkembang dengan lebih dari satu pemegang saham.',
        'content' => [
            'PT Persekutuan Modal adalah bentuk Perseroan Terbatas yang didirikan oleh dua pihak atau lebih dengan pembagian saham, peran, dan tanggung jawab yang disusun lebih jelas sejak awal.',
            'Bentuk ini cocok ketika bisnis dibangun bersama partner atau investor dan membutuhkan struktur korporasi yang lebih siap untuk kerja sama, pengembangan usaha, maupun pengelolaan internal.',
            'Melalui FastTrack, proses pendiriannya dirancang agar user memahami struktur dasar PT, pilihan KBLI, kebutuhan dokumen, dan langkah legalitas penting tanpa merasa rumit.',
        ],
        'benefits' => [
            'Struktur kepemilikan saham lebih jelas untuk dua pihak atau lebih',
            'Lebih siap untuk kerja sama bisnis, tender, dan ekspansi',
            'Meningkatkan kredibilitas usaha di mata klien dan partner',
            'Dokumen legal disusun lebih rapi sesuai kebutuhan usaha',
        ],
        'requirements' => [
            'Data seluruh pemegang saham dan pengurus',
            'Nama perusahaan beserta alternatif cadangan',
            'Alamat usaha yang akan digunakan',
            'Ruang lingkup kegiatan usaha untuk penentuan KBLI',
        ],
        'process' => [
            'Konsultasi struktur perusahaan dan pembagian saham',
            'Pemeriksaan data pendiri, pengurus, dan nama perusahaan',
            'Penyusunan akta pendirian serta proses legalitas dasar',
            'Serah terima dokumen dan pengarahan langkah lanjutan',
        ],
        'faq' => [
            ['question' => 'Kapan memilih PT Persekutuan Modal?', 'answer' => 'Paket ini tepat ketika bisnis dibangun oleh dua pihak atau lebih dan membutuhkan struktur saham yang lebih jelas.'],
            ['question' => 'Apakah cocok untuk bisnis yang ingin berkembang?', 'answer' => 'Ya, PT Persekutuan Modal sangat cocok untuk bisnis yang menargetkan pertumbuhan, kerja sama korporasi, dan peluang investasi.'],
        ],
        'why_cards' => [
            [
                'icon' => 'shield',
                'title' => 'Meningkatkan Kredibilitas Bisnis',
                'description' => 'PT memberi citra usaha yang lebih profesional saat berhadapan dengan klien, vendor, institusi, dan calon investor.',
            ],
            [
                'icon' => 'office',
                'title' => 'Alamat Bisnis Lebih Siap Pakai',
                'description' => 'Virtual Office membantu bisnis memiliki alamat usaha yang lebih representatif untuk kebutuhan administrasi dan komunikasi usaha.',
            ],
            [
                'icon' => 'document',
                'title' => 'Mempermudah Proses Legalitas Lanjutan',
                'description' => 'Struktur PT dan dukungan alamat usaha yang tepat membantu proses pengurusan dokumen lanjutan menjadi lebih tertata.',
            ],
            [
                'icon' => 'growth',
                'title' => 'Lebih Siap untuk Ekspansi',
                'description' => 'Kombinasi PT dan Virtual Office cocok untuk pengusaha yang ingin bertumbuh lebih cepat tanpa harus langsung menanggung biaya kantor penuh.',
            ],
        ],
        'plans' => [
            [
                'name' => 'PT Lite',
                'highlight' => 'Pilihan hemat',
                'subtitle' => 'Solusi awal untuk memulai legalitas PT dengan alur yang lebih sederhana.',
                'promo_price' => null,
                'price' => 'Mulai dari Rp 5.500.000',
                'includes' => [
                    'Konsultasi struktur PT dan pilihan KBLI',
                    'Penyusunan dokumen pendirian dasar',
                    'Pendampingan proses legalitas awal',
                ],
                'note' => 'Cocok untuk bisnis yang ingin bergerak cepat dengan kebutuhan dokumen dasar yang efisien.',
            ],
            [
                'name' => 'PT Lengkap',
                'highlight' => 'Paling fleksibel',
                'subtitle' => 'Dirancang untuk bisnis yang membutuhkan paket pendirian lebih komprehensif.',
                'promo_price' => 'Promo Rp 7.500.000',
                'price' => 'Harga normal Rp 8.500.000',
                'includes' => [
                    'Kelengkapan dokumen pendirian yang lebih luas',
                    'Pendampingan legalitas dasar hingga siap digunakan',
                    'Arahan penggunaan dokumen untuk operasional awal',
                ],
                'note' => 'Pilihan yang pas untuk bisnis yang ingin fondasi legal lebih matang sejak awal.',
            ],
            [
                'name' => 'PT Lengkap + PKP',
                'highlight' => 'Untuk bisnis berkembang',
                'subtitle' => 'Paket untuk usaha yang membutuhkan kesiapan legalitas dan administrasi pajak lebih lanjut.',
                'promo_price' => null,
                'price' => 'Mulai dari Rp 11.500.000',
                'includes' => [
                    'Paket pendirian PT lengkap',
                    'Pendampingan kebutuhan PKP sejak awal',
                    'Konsultasi kesiapan dokumen perpajakan',
                ],
                'note' => 'Ideal untuk bisnis yang menargetkan transaksi lebih formal dan pertumbuhan lebih cepat.',
            ],
            [
                'name' => 'PT Lengkap + Daftar Merek',
                'highlight' => 'Lindungi brand',
                'subtitle' => 'Gabungan legalitas PT dan langkah awal perlindungan identitas merek bisnis.',
                'promo_price' => 'Promo Rp 10.900.000',
                'price' => 'Harga normal Rp 12.000.000',
                'includes' => [
                    'Paket PT lengkap',
                    'Pendampingan awal pendaftaran merek',
                    'Review dasar nama dan identitas brand',
                ],
                'note' => 'Direkomendasikan untuk bisnis yang serius membangun brand jangka panjang.',
            ],
            [
                'name' => 'PT Lengkap + Virtual Office by vOffice',
                'highlight' => 'Alamat strategis',
                'subtitle' => 'Menggabungkan legalitas PT dan kebutuhan alamat usaha yang lebih representatif.',
                'promo_price' => 'Promo Rp 9.900.000',
                'price' => 'Harga normal Rp 11.500.000',
                'includes' => [
                    'Paket PT lengkap',
                    'Virtual Office by vOffice',
                    'Pendampingan kebutuhan administrasi alamat usaha',
                ],
                'note' => 'Sesuai untuk bisnis yang ingin tampil profesional tanpa langsung menyewa kantor fisik penuh.',
            ],
            [
                'name' => 'PT Lengkap + Virtual Office Premium by vOffice',
                'highlight' => 'Kelas premium',
                'subtitle' => 'Pilihan premium untuk bisnis yang membutuhkan kesan profesional dan eksklusif.',
                'promo_price' => 'Promo Rp 12.900.000',
                'price' => 'Harga normal Rp 14.500.000',
                'includes' => [
                    'Paket PT lengkap',
                    'Virtual Office Premium by vOffice',
                    'Dukungan citra bisnis yang lebih eksklusif',
                ],
                'note' => 'Direkomendasikan untuk bisnis yang banyak berinteraksi dengan klien korporasi dan partner strategis.',
            ],
            [
                'name' => 'PAKET PT + VO (Free Trade)',
                'highlight' => 'Bundling praktis',
                'subtitle' => 'Bundling legalitas PT dan virtual office untuk kebutuhan operasional yang lebih dinamis.',
                'promo_price' => null,
                'price' => 'Mulai dari Rp 9.500.000',
                'includes' => [
                    'Pendirian PT dasar',
                    'Fasilitas Virtual Office pilihan',
                    'Pendampingan proses yang lebih praktis dalam satu alur',
                ],
                'note' => 'Pilihan tepat untuk owner yang ingin solusi bundling praktis dan efisien.',
            ],
        ],
    ],
    [
        'id' => 2,
        'slug' => 'perorangan',
        'name' => 'PT Perorangan',
        'short_name' => 'Perorangan',
        'tag' => 'Praktis',
        'price' => '2500000',
        'price_label' => 'Rp 2.500.000',
        'duration' => 'Estimasi 3-7 hari kerja',
        'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80&fm=webp',
        'description' => 'Pilihan paket untuk pemilik usaha tunggal yang ingin memiliki badan hukum PT dengan proses yang lebih sederhana, efisien, dan tetap profesional.',
        'excerpt' => 'Paket PT Perorangan untuk pelaku usaha tunggal yang ingin naik kelas dengan badan hukum yang lebih formal.',
        'audience' => 'Cocok untuk solo founder, konsultan, bisnis digital, UMKM yang berkembang, dan pemilik usaha yang ingin legalitas lebih rapi.',
        'content' => [
            'PT Perorangan menjadi pilihan menarik bagi pemilik usaha tunggal yang ingin memiliki badan hukum lebih formal tanpa struktur multi pemegang saham.',
            'Bentuk ini cocok untuk usaha yang sudah berjalan atau sedang bersiap tumbuh dan membutuhkan identitas hukum yang lebih kredibel untuk kebutuhan operasional maupun kerja sama.',
            'FastTrack membantu user memahami apakah PT Perorangan merupakan opsi yang tepat, sekaligus mendampingi proses dokumen agar tetap efisien dan nyaman diikuti.',
        ],
        'benefits' => [
            'Proses pendirian lebih sederhana untuk pemilik usaha tunggal',
            'Membantu bisnis tampil lebih kredibel dan profesional',
            'Cocok untuk solo founder yang ingin menata legalitas bisnis',
            'Lebih efisien sebagai langkah awal naik kelas usaha',
        ],
        'requirements' => [
            'Identitas pemilik usaha',
            'Nama perusahaan dan alternatif cadangan',
            'Alamat usaha yang akan digunakan',
            'Deskripsi kegiatan usaha utama',
        ],
        'process' => [
            'Diskusi model usaha dan kecocokan PT Perorangan',
            'Persiapan data dan validasi nama perusahaan',
            'Pengurusan dokumen pendirian dan legalitas dasar',
            'Serah terima dokumen dan arahan penggunaan awal',
        ],
        'faq' => [
            ['question' => 'Siapa yang cocok memakai PT Perorangan?', 'answer' => 'PT Perorangan cocok untuk pelaku usaha tunggal yang ingin memiliki badan hukum yang lebih formal dan profesional.'],
            ['question' => 'Apakah PT Perorangan cocok untuk UMKM?', 'answer' => 'Ya, paket ini relevan untuk UMKM yang sedang berkembang dan ingin menata fondasi legal usahanya dengan lebih baik.'],
        ],
        'about' => [
            'PT Perorangan adalah bentuk badan hukum yang dirancang untuk pemilik usaha tunggal yang ingin meningkatkan legalitas usahanya tanpa harus membangun struktur multi pemegang saham.',
            'Bentuk ini menjadi solusi menarik bagi pelaku usaha mikro dan kecil yang ingin tampil lebih profesional, memiliki entitas usaha yang lebih formal, dan mulai menata administrasi bisnis dengan lebih baik.',
            'Dengan pendekatan yang lebih sederhana, PT Perorangan membantu solo founder atau owner bisnis agar bisa naik kelas tanpa harus langsung masuk ke struktur PT biasa yang lebih kompleks.',
        ],
        'plans' => [
            [
                'name' => 'PT Lite',
                'highlight' => 'Mulai cepat',
                'subtitle' => 'Paket awal untuk owner tunggal yang ingin menata legalitas bisnis lebih cepat.',
                'promo_price' => null,
                'price' => 'Mulai dari Rp 2.500.000',
                'includes' => [
                    'Konsultasi dasar PT Perorangan',
                    'Pendampingan proses legalitas awal',
                    'Checklist dokumen dan arahan penggunaan',
                ],
                'note' => 'Cocok untuk usaha yang baru naik kelas dan ingin struktur legal lebih rapi.',
            ],
            [
                'name' => 'PT Perorangan Lengkap',
                'highlight' => 'Paket utama',
                'subtitle' => 'Pilihan lengkap untuk usaha yang ingin fondasi legal lebih matang sejak awal.',
                'promo_price' => 'Promo Rp 3.900.000',
                'price' => 'Harga normal Rp 4.500.000',
                'includes' => [
                    'Dokumen PT Perorangan yang lebih lengkap',
                    'Pendampingan proses hingga siap digunakan',
                    'Briefing tindak lanjut operasional awal',
                ],
                'note' => 'Sesuai untuk owner bisnis yang ingin paket lebih lengkap tanpa proses yang terasa rumit.',
            ],
            [
                'name' => 'PT Perorangan Lengkap + Virtual Office Silver Promo by vOffice',
                'highlight' => 'Promo VO',
                'subtitle' => 'Gabungan legalitas PT Perorangan dan virtual office untuk citra usaha yang lebih rapi.',
                'promo_price' => 'Promo Rp 5.900.000',
                'price' => 'Harga normal Rp 6.800.000',
                'includes' => [
                    'Paket PT Perorangan lengkap',
                    'Virtual Office Silver Promo by vOffice',
                    'Pendampingan kebutuhan alamat usaha',
                ],
                'note' => 'Direkomendasikan untuk bisnis digital, jasa, dan usaha modern yang perlu alamat usaha representatif.',
            ],
            [
                'name' => 'PT Perorangan Lengkap + Virtual Office Premium by vOffice',
                'highlight' => 'Premium',
                'subtitle' => 'Solusi premium untuk owner bisnis yang ingin tampil lebih profesional dan eksklusif.',
                'promo_price' => 'Promo Rp 7.900.000',
                'price' => 'Harga normal Rp 9.000.000',
                'includes' => [
                    'Paket PT Perorangan lengkap',
                    'Virtual Office Premium by vOffice',
                    'Kesan brand dan alamat usaha yang lebih kuat',
                ],
                'note' => 'Cocok untuk bisnis yang ingin menaikkan citra brand dan kenyamanan komunikasi bisnis.',
            ],
        ],
        'differences' => [
            [
                'aspect' => 'Jumlah Pendiri',
                'perorangan' => 'Didirikan oleh satu orang pemilik usaha.',
                'biasa' => 'Umumnya melibatkan dua pihak atau lebih sebagai pemegang saham.',
            ],
            [
                'aspect' => 'Struktur Kepemilikan',
                'perorangan' => 'Lebih sederhana karena fokus pada satu owner.',
                'biasa' => 'Lebih kompleks karena ada pembagian saham, peran, dan pengambilan keputusan bersama.',
            ],
            [
                'aspect' => 'Kecocokan Bisnis',
                'perorangan' => 'Ideal untuk usaha mikro dan kecil yang sedang bertumbuh.',
                'biasa' => 'Lebih cocok untuk bisnis yang menargetkan skala lebih besar atau melibatkan partner/investor.',
            ],
            [
                'aspect' => 'Administrasi Awal',
                'perorangan' => 'Cenderung lebih ringkas bagi owner tunggal.',
                'biasa' => 'Perlu penyesuaian lebih banyak karena melibatkan beberapa pihak dan struktur korporasi.',
            ],
        ],
        'business_types' => [
            'Bisnis digital dan jasa profesional yang dijalankan owner tunggal',
            'Konsultan, agency kecil, dan freelancer yang ingin naik kelas',
            'UMKM produk atau perdagangan yang mulai berkembang',
            'Bisnis online yang ingin terlihat lebih profesional di mata klien atau partner',
            'Usaha layanan yang membutuhkan identitas badan hukum lebih rapi',
            'Owner bisnis yang ingin menyiapkan fondasi legal sebelum ekspansi',
        ],
        'requirements_detail' => [
            'Pendiri merupakan WNI dan menjalankan usaha atas nama sendiri',
            'Menyiapkan nama perusahaan dan deskripsi kegiatan usaha',
            'Memiliki alamat usaha yang dapat digunakan untuk kebutuhan administrasi',
            'Menentukan modal, kegiatan usaha, dan data identitas pendukung',
            'Memastikan usaha masuk dalam kategori yang relevan untuk skema PT Perorangan',
        ],
    ],
];

$articles = [
    [
        'id' => 1,
        'title' => 'Panduan Lengkap Mendirikan PT Tahun 2024',
        'excerpt' => 'Mendirikan Perseroan Terbatas kini semakin mudah dengan adanya sistem OSS. Pelajari langkah-langkah penting, dokumen, dan estimasi prosesnya.',
        'content' => [
            'Mendirikan PT menjadi langkah penting bagi pelaku usaha yang ingin membangun bisnis dengan struktur legal yang lebih profesional. Dengan badan hukum yang jelas, perusahaan memiliki kredibilitas lebih tinggi di mata mitra, investor, maupun pelanggan.',
            'Proses pendirian PT umumnya dimulai dari penentuan nama perusahaan, pemilihan KBLI yang relevan, penyusunan akta pendirian, hingga pengurusan NIB dan dokumen penunjang lainnya. Ketelitian pada tahap awal akan membantu proses berjalan lebih cepat dan minim revisi.',
            'FastTrack membantu Anda mengelola proses tersebut dengan pendampingan yang terstruktur, komunikasi yang jelas, dan timeline yang realistis agar bisnis bisa segera berjalan dengan pondasi legal yang kuat.',
        ],
        'category' => 'Legalitas',
        'date' => '12 Mei 2024',
        'reading_time' => '5 menit baca',
        'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80&fm=webp',
    ],
    [
        'id' => 2,
        'title' => 'Perbedaan PT dan CV: Mana yang Cocok Untuk Bisnis Anda?',
        'excerpt' => 'Kenali perbedaan mendasar antara PT dan CV agar Anda bisa memilih bentuk usaha yang sesuai dengan kebutuhan operasional dan pengembangan bisnis.',
        'content' => [
            'PT dan CV adalah dua bentuk usaha yang paling sering dipilih oleh pelaku bisnis di Indonesia. Masing-masing memiliki karakteristik, struktur tanggung jawab, dan implikasi legal yang berbeda.',
            'PT lebih cocok bagi bisnis yang membutuhkan badan hukum terpisah, perlindungan tanggung jawab terbatas, dan peluang pengembangan usaha yang lebih luas. Sementara itu, CV kerap dipilih oleh usaha skala kecil hingga menengah yang mengutamakan fleksibilitas awal.',
            'Sebelum memutuskan, penting untuk mempertimbangkan model bisnis, kebutuhan perizinan, rencana investasi, dan risiko usaha. Konsultasi yang tepat akan membantu Anda memilih struktur yang paling efisien.',
        ],
        'category' => 'Bisnis',
        'date' => '10 Mei 2024',
        'reading_time' => '6 menit baca',
        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
    ],
    [
        'id' => 3,
        'title' => 'Pentingnya Memilih KBLI Yang Tepat Sebelum Mengurus NIB',
        'excerpt' => 'Pemilihan KBLI yang akurat membantu proses OSS lebih lancar dan mengurangi risiko kendala legal saat bisnis mulai berjalan.',
        'content' => [
            'KBLI adalah fondasi penting dalam proses legalitas usaha karena menjadi acuan utama dalam menentukan jenis kegiatan bisnis yang dijalankan perusahaan.',
            'Kesalahan memilih KBLI dapat berdampak pada terhambatnya proses perizinan, ketidaksesuaian dokumen usaha, hingga hambatan saat bekerja sama dengan pihak lain atau mengurus izin lanjutan.',
            'Dengan analisis kegiatan usaha yang tepat, pemilik bisnis dapat memilih KBLI yang paling relevan agar proses pengurusan NIB dan legalitas lain berjalan lebih aman dan efisien.',
        ],
        'category' => 'KBLI',
        'date' => '8 Mei 2024',
        'reading_time' => '4 menit baca',
        'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80&fm=webp',
    ],
    [
        'id' => 4,
        'title' => 'Kapan Bisnis Membutuhkan Virtual Office?',
        'excerpt' => 'Virtual office menjadi solusi efisien untuk bisnis modern yang ingin tetap terlihat profesional tanpa harus menyewa kantor fisik penuh.',
        'content' => [
            'Virtual office banyak dipilih oleh startup, konsultan, hingga bisnis digital yang membutuhkan alamat usaha strategis namun tetap ingin menjaga efisiensi biaya operasional.',
            'Selain menunjang citra perusahaan, virtual office juga membantu pemenuhan kebutuhan administratif dan legal untuk jenis usaha tertentu, terutama di kota besar seperti Jakarta.',
            'Sebelum memilih layanan virtual office, pastikan lokasi, legalitas penyedia, dan fasilitas pendukungnya benar-benar sesuai dengan kebutuhan bisnis Anda.',
        ],
        'category' => 'Virtual Office',
        'date' => '5 Mei 2024',
        'reading_time' => '4 menit baca',
        'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80&fm=webp',
    ],
    [
        'id' => 5,
        'title' => 'Cara Mengurus Perubahan Akta Perusahaan Dengan Efisien',
        'excerpt' => 'Perubahan data perusahaan perlu ditangani dengan teliti agar tidak mengganggu legalitas, operasional, dan administrasi bisnis.',
        'content' => [
            'Perubahan akta perusahaan dapat terjadi karena perubahan direksi, pemegang saham, alamat kantor, modal, maupun kegiatan usaha. Semua perubahan tersebut perlu disesuaikan secara legal.',
            'Dokumen pendukung, notulen, hingga penyesuaian data pada sistem administrasi perusahaan perlu dipastikan konsisten agar tidak memunculkan masalah pada tahap berikutnya.',
            'Pendampingan profesional membantu proses perubahan akta menjadi lebih ringkas, akurat, dan sesuai dengan ketentuan yang berlaku.',
        ],
        'category' => 'Dokumen',
        'date' => '2 Mei 2024',
        'reading_time' => '5 menit baca',
        'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80&fm=webp',
    ],
    [
        'id' => 6,
        'title' => 'Tips Menyiapkan Legalitas Bisnis Untuk Menarik Investor',
        'excerpt' => 'Legalitas yang tertata rapi menjadi salah satu faktor penting ketika bisnis Anda mulai dilirik oleh investor atau mitra strategis.',
        'content' => [
            'Investor akan lebih percaya pada bisnis yang memiliki struktur legal yang jelas, dokumen korporasi yang tertata, dan kepatuhan administratif yang baik.',
            'Selain pendirian badan usaha, aspek seperti perjanjian, perlindungan merek, pajak, dan perizinan operasional juga memengaruhi tingkat kesiapan bisnis untuk berkembang lebih besar.',
            'Dengan fondasi legal yang kuat, perusahaan tidak hanya lebih siap untuk tumbuh, tetapi juga lebih meyakinkan dalam proses due diligence dan negosiasi bisnis.',
        ],
        'category' => 'Investasi',
        'date' => '30 April 2024',
        'reading_time' => '6 menit baca',
        'image' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
    ],
];

$staticPages = [
    '/',
    '/promo',
    '/layanan',
    '/artikel',
    '/kbli',
    '/faq',
    '/tentang-kami',
    '/kontak',
];

Route::get('/robots.txt', function (Request $request) use ($resolveBaseUrl) {
    $baseUrl = $resolveBaseUrl($request);

    $content = implode("\n", [
        'User-agent: *',
        'Allow: /',
        '',
        'Sitemap: ' . $baseUrl . '/sitemap.xml',
    ]);

    return response($content, 200)->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function (Request $request) use ($staticPages, $customServices, $articles, $resolveBaseUrl, $foundingProducts, $foundingPackages) {
    $baseUrl = $resolveBaseUrl($request);

    $urls = collect($staticPages)
        ->map(fn ($path) => [
            'loc' => $baseUrl . $path,
            'lastmod' => now()->toDateString(),
            'changefreq' => 'weekly',
            'priority' => $path === '/' ? '1.0' : '0.8',
        ])
        ->merge(
            collect($customServices)->map(fn ($service) => [
                'loc' => $baseUrl . $service['path'],
                'lastmod' => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ])
        )
        ->merge(
            Service::query()->get()->map(fn ($service) => [
                'loc' => $baseUrl . '/layanan/' . $service->slug,
                'lastmod' => $service->updated_at?->toDateString() ?? now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ])
        )
        ->merge(
            collect($articles)->map(fn ($article) => [
                'loc' => $baseUrl . '/artikel/' . $article['id'],
                'lastmod' => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ])
        )
        ->merge(
            collect($foundingProducts)->map(fn ($product) => [
                'loc' => $baseUrl . $product['detail_path'],
                'lastmod' => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ])
        )
        ->merge(
            collect($foundingPackages)->map(fn ($package) => [
                'loc' => $baseUrl . '/pendirian-perusahaan/paket/' . $package['slug'],
                'lastmod' => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ])
        )
        ->unique('loc')
        ->values();

    $xml = view('sitemap', ['urls' => $urls])->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

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

        if ($service['path'] === '/pendirian-perusahaan') {
            $props['products'] = $foundingProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Pendirian Perusahaan - FastTrack',
                'description' => 'Daftar produk pendirian perusahaan FastTrack untuk PT, CV, Firma, PMA, yayasan, koperasi, dan perkumpulan.',
                'url' => $baseUrl . '/pendirian-perusahaan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($foundingProducts)->values()->map(
                        static fn (array $product, int $index): array => [
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

Route::get('/pendirian-perusahaan/1', function () {
    return redirect('/pendirian-perusahaan/paket', 301);
});

Route::get('/pendirian-perusahaan/paket', function (Request $request) use ($foundingPackages, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Services/PendirianPerusahaan/Paket/Index', [
        'packages' => $foundingPackages,
        'seo' => [
            'title' => 'Paket Pendirian PT - FastTrack',
            'description' => 'Pilih paket pendirian PT yang sesuai: PT Persekutuan Modal atau PT Perorangan dengan alur legalitas yang lebih rapi dan profesional.',
            'canonical' => $baseUrl . '/pendirian-perusahaan/paket',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Paket Pendirian PT - FastTrack',
                'description' => 'Pilihan paket pendirian PT untuk kebutuhan bisnis yang berbeda.',
                'url' => $baseUrl . '/pendirian-perusahaan/paket',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($foundingPackages)->values()->map(
                        static fn (array $package, int $index): array => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $package['name'],
                            'url' => $baseUrl . '/pendirian-perusahaan/paket/' . $package['slug'],
                        ]
                    )->all(),
                ],
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Pendirian Perusahaan', 'item' => $baseUrl . '/pendirian-perusahaan'],
                ['name' => 'Paket', 'item' => $baseUrl . '/pendirian-perusahaan/paket'],
            ]),
        ],
    ]);
});

Route::get('/pendirian-perusahaan/paket/{slug}', function (Request $request, string $slug) use ($foundingPackages, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $package = collect($foundingPackages)->firstWhere('slug', $slug);

    abort_if($package === null, 404);

    return Inertia::render('Services/PendirianPerusahaan/Paket/Show', [
        'package' => $package,
        'relatedPackages' => collect($foundingPackages)->where('slug', '!=', $slug)->values()->all(),
        'seo' => [
            'title' => $package['name'] . ' - FastTrack',
            'description' => $package['excerpt'],
            'canonical' => $baseUrl . '/pendirian-perusahaan/paket/' . $package['slug'],
            'image' => $package['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $package['name'],
                'description' => $package['excerpt'],
                'serviceType' => $package['name'],
                'provider' => $organizationReference($baseUrl),
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => 'Indonesia',
                ],
                'image' => $package['image'] ?: $defaultImageUrl($baseUrl),
                'url' => $baseUrl . '/pendirian-perusahaan/paket/' . $package['slug'],
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'IDR',
                    'price' => $package['price'],
                    'availability' => 'https://schema.org/InStock',
                    'url' => $baseUrl . '/pendirian-perusahaan/paket/' . $package['slug'],
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => collect($package['faq'])->map(
                    static fn (array $faq): array => [
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
                ['name' => 'Pendirian Perusahaan', 'item' => $baseUrl . '/pendirian-perusahaan'],
                ['name' => 'Paket', 'item' => $baseUrl . '/pendirian-perusahaan/paket'],
                ['name' => $package['short_name'], 'item' => $baseUrl . '/pendirian-perusahaan/paket/' . $package['slug']],
            ]),
        ],
    ]);
});

Route::get('/pendirian-perusahaan/{id}', function (Request $request, int $id) use ($foundingProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($foundingProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($foundingProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/PendirianPerusahaan/Show', [
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
                    static fn (array $faq): array => [
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
                ['name' => 'Pendirian Perusahaan', 'item' => $baseUrl . '/pendirian-perusahaan'],
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

Route::get('/artikel', function (Request $request) use ($articles, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Blog', [
        'articles' => $articles,
        'seo' => [
            'title' => 'Artikel & Edukasi Hukum Bisnis - FastTrack',
            'description' => 'Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.',
            'canonical' => $baseUrl . '/artikel',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Artikel & Edukasi Hukum Bisnis - FastTrack',
                'description' => 'Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.',
                'url' => $baseUrl . '/artikel',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($articles)->values()->map(
                        static fn (array $article, int $index): array => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $article['title'],
                            'url' => $baseUrl . '/artikel/' . $article['id'],
                        ]
                    )->all(),
                ],
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Artikel', 'item' => $baseUrl . '/artikel'],
            ]),
        ],
    ]);
});

Route::get('/artikel/{id}', function (Request $request, int $id) use ($articles, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $article = collect($articles)->firstWhere('id', $id);

    abort_if($article === null, 404);

    $relatedArticles = collect($articles)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Articles/Show', [
        'article' => $article,
        'relatedArticles' => $relatedArticles,
        'seo' => [
            'title' => $article['title'] . ' - FastTrack',
            'description' => $article['excerpt'],
            'canonical' => $baseUrl . '/artikel/' . $article['id'],
            'image' => $article['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $article['title'],
                'description' => $article['excerpt'],
                'image' => $article['image'] ?: $defaultImageUrl($baseUrl),
                'author' => $organizationReference($baseUrl),
                'publisher' => $organizationReference($baseUrl),
                'datePublished' => '2024-05-12',
                'dateModified' => now()->toDateString(),
                'mainEntityOfPage' => $baseUrl . '/artikel/' . $article['id'],
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Artikel', 'item' => $baseUrl . '/artikel'],
                ['name' => $article['title'], 'item' => $baseUrl . '/artikel/' . $article['id']],
            ]),
        ],
    ]);
});

Route::get('/kbli', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Kbli', [
        'seo' => [
            'title' => 'Panduan KBLI - FastTrack',
            'description' => 'Pelajari fungsi dan pemilihan KBLI yang tepat untuk legalitas bisnis Anda.',
            'canonical' => $baseUrl . '/kbli',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => 'Panduan KBLI - FastTrack',
                'description' => 'Pelajari fungsi dan pemilihan KBLI yang tepat untuk legalitas bisnis Anda.',
                'author' => $organizationReference($baseUrl),
                'publisher' => $organizationReference($baseUrl),
                'mainEntityOfPage' => $baseUrl . '/kbli',
                'image' => $defaultImageUrl($baseUrl),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'KBLI', 'item' => $baseUrl . '/kbli'],
            ]),
        ],
    ]);
});

Route::get('/faq', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Faq', [
        'seo' => [
            'title' => 'FAQ - FastTrack',
            'description' => 'Jawaban untuk pertanyaan umum terkait legalitas bisnis dan layanan FastTrack.',
            'canonical' => $baseUrl . '/faq',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name' => 'Berapa lama proses pendirian PT?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Estimasi waktu bervariasi tergantung kelengkapan dokumen, namun umumnya proses dasar dapat dimulai dalam beberapa hari kerja.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Apakah FastTrack membantu memilih KBLI?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Ya, kami membantu mencocokkan aktivitas bisnis Anda dengan KBLI yang paling relevan untuk kebutuhan OSS dan legalitas.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Apakah layanan konsultasi tersedia secara online?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Tersedia. Anda dapat menghubungi tim kami melalui form konsultasi atau WhatsApp untuk diskusi awal.',
                        ],
                    ],
                ],
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'FAQ', 'item' => $baseUrl . '/faq'],
            ]),
        ],
    ]);
});

Route::get('/tentang-kami', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('About', [
        'seo' => [
            'title' => 'Tentang Kami - FastTrack',
            'description' => 'Kenali filosofi, visi misi, komitmen, keunggulan, dan tim profesional FastTrack.',
            'canonical' => $baseUrl . '/tentang-kami',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'Tentang Kami - FastTrack',
                'description' => 'Kenali filosofi, visi misi, komitmen, keunggulan, dan tim profesional FastTrack.',
                'url' => $baseUrl . '/tentang-kami',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Tentang Kami', 'item' => $baseUrl . '/tentang-kami'],
            ]),
        ],
    ]);
});

Route::get('/kontak', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Contact', [
        'seo' => [
            'title' => 'Hubungi Kami - FastTrack',
            'description' => 'Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami.',
            'canonical' => $baseUrl . '/kontak',
            'image' => $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => 'Hubungi Kami - FastTrack',
                'description' => 'Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami.',
                'url' => $baseUrl . '/kontak',
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'LegalService',
                'name' => 'FastTrack Legalitas',
                'image' => $defaultImageUrl($baseUrl),
                'url' => $baseUrl,
                'telephone' => '+622173885036',
                'email' => 'cs@fasttrack.legal',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Grand Bintaro Blok A7, Jl. Raya Bintaro Permai, Pesanggrahan, Bintaro',
                    'addressLocality' => 'Jakarta Selatan',
                    'postalCode' => '12330',
                    'addressCountry' => 'ID',
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '+6282298604144',
                    'contactType' => 'customer service',
                    'email' => 'cs@fasttrack.legal',
                    'areaServed' => 'ID',
                    'availableLanguage' => ['id', 'en'],
                ],
                'openingHoursSpecification' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '17:00',
                ],
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Kontak', 'item' => $baseUrl . '/kontak'],
            ]),
        ],
    ]);
});

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
