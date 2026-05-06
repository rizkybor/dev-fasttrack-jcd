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

$defaultImageUrl = static fn (string $baseUrl): string => $baseUrl . '/fasttrack-og.svg';

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
        'image' => $baseUrl . '/fasttrack-og.svg',
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

Route::get('/sitemap.xml', function (Request $request) use ($staticPages, $customServices, $articles, $resolveBaseUrl) {
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
        ->unique('loc')
        ->values();

    $xml = view('sitemap', ['urls' => $urls])->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

foreach ($customServices as $service) {
    Route::get($service['path'], function (Request $request) use ($service, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema, $serviceSchema) {
        $baseUrl = $resolveBaseUrl($request);

        return Inertia::render($service['component'], [
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
        ]);
    });
}

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

// require __DIR__.'/auth.php';
