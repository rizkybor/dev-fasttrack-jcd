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
    ['component' => 'Services/KantorPerwakilan/Index', 'title' => 'Kantor Perwakilan', 'path' => '/kantor-perwakilan', 'description' => 'Layanan pendirian kantor perwakilan untuk mendukung ekspansi bisnis Anda di Indonesia.'],
    ['component' => 'Services/PenyusunanDanPeninjauanPerjanjian/Index', 'title' => 'Penyusunan Peninjauan', 'path' => '/penyusunan-peninjauan', 'description' => 'Layanan pendirian kantor perwakilan untuk mendukung ekspansi bisnis Anda di Indonesia.'],
    ['component' => 'Services/RetainerBerlangganan/Index', 'title' => 'Retainer / Berlangganan', 'path' => '/retainer-berlangganan', 'description' => 'Layanan pendirian kantor perwakilan untuk mendukung ekspansi bisnis Anda di Indonesia.'],
    ['component' => 'Services/IzinTinggalTerbatas/Index', 'title' => 'Izin Tinggal Terbatas', 'path' => '/izin-tinggal-terbatas', 'description' => 'Layanan pendirian kantor perwakilan untuk mendukung ekspansi bisnis Anda di Indonesia.'],
    ['component' => 'Services/IzinTinggalTetap/Index', 'title' => 'Izin Tinggal Tetap', 'path' => '/izin-tinggal-tetap', 'description' => 'Layanan pendirian kantor perwakilan untuk mendukung ekspansi bisnis Anda di Indonesia.'],
    ['component' => 'Services/BadanHukumLuarNegeri/Index', 'title' => 'Badan Hukum Luar Negeri', 'path' => '/badan-hukum-luar-negeri', 'description' => 'Layanan pendirian badan usaha luar negeri untuk mendukung ekspansi bisnis internasional Anda di Indonesia.'],
    ['component' => 'Services/OneSingleSubmission/Index', 'title' => 'One Single Submission', 'path' => '/one-single-submission', 'description' => 'Layanan pengurusan perizinan One Single Submission (OSS) untuk kemudahan berusaha di Indonesia.'],
    ['component' => 'Services/KewajibanPelaporanPerusahaan/Index', 'title' => 'Kewajiban Pelaporan Perusahaan', 'path' => '/kewajiban-pelaporan-perusahaan', 'description' => 'Layanan pengurusan kewajiban pelaporan perusahaan sesuai regulasi yang berlaku di Indonesia.'],
    ['component' => 'Services/LegalisasiKedutaan/Index', 'title' => 'Legalisasi Kedutaan', 'path' => '/legalisasi-kedutaan', 'description' => 'Layanan legalisasi dokumen melalui kedutaan untuk keperluan bisnis internasional Anda.'],
    ['component' => 'Services/KekayaanIntelektual/Index', 'title' => 'Kekayaan Intelektual', 'path' => '/kekayaan-intelektual', 'description' => 'Layanan pendaftaran dan perlindungan kekayaan intelektual termasuk merek, paten, dan hak cipta.'],
];

// BADAN USAHA 
$foundingProducts = (static function (): array {
    $path = public_path('data/foundingProductsBadanUsaha.json');

    if (! file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$foundingProducts = collect($foundingProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = $product['id'] === 1
            ? '/badan-usaha/paket'
            : '/badan-usaha/' . $product['id'];

        return $product;
    })
    ->all();

// KANTOR PERWAKILAN 
$kantorPerwakilanProducts = (static function (): array {
    $path = public_path('data/foundingProductsKantorPerwakilan.json');

    if (! file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$kantorPerwakilanProducts = collect($kantorPerwakilanProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/kantor-perwakilan/' . $product['id'];

        return $product;
    })
    ->all();

// PENYUSUNAN PENINJAUAN 
$penyusunanDanPeninjauanProducts = (static function (): array {
    $path = public_path('data/foundingProductsPenyusunanPeninjauan.json');

    if (! file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$penyusunanDanPeninjauanProducts = collect($penyusunanDanPeninjauanProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/penyusunan-peninjauan/' . $product['id'];

        return $product;
    })
    ->all();

// RETAINER BERLANGGANAN 
$retainerBerlanggananProducts = (static function (): array {
    $path = public_path('data/foundingRetainerBerlangganan.json');

    if (! file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$retainerBerlanggananProducts = collect($retainerBerlanggananProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/retainer-berlangganan/' . $product['id'];

        return $product;
    })
    ->all();

// IZIN TINGGAL TERBATAS
$izinTinggalTerbatasProducts = (static function (): array {
    $path = public_path('data/foundingProductsIzinTinggalTerbatas.json');

    if (! file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$izinTinggalTerbatasProducts = collect($izinTinggalTerbatasProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/izin-tinggal-terbatas/' . $product['id'];

        return $product;
    })
    ->all();

// IZIN TINGGAL TETAP
$izinTinggalTetapProducts = (static function (): array {
    $path = public_path('data/foundingProductsIzinTinggalTetap.json');

    if (! file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$izinTinggalTetapProducts = collect($izinTinggalTetapProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/izin-tinggal-tetap/' . $product['id'];

        return $product;
    })
    ->all();

// BADAN HUKUM LUAR NEGERI
$badanHukumLuarNegeriProducts = (static function (): array {
    $path = public_path('data/foundingProductsBadanHukumLuarNegeri.json');
    if (! file_exists($path)) return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$badanHukumLuarNegeriProducts = collect($badanHukumLuarNegeriProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/badan-hukum-luar-negeri/' . $product['id'];
        return $product;
    })
    ->all();

// ONE SINGLE SUBMISSION
$oneSingleSubmissionProducts = (static function (): array {
    $path = public_path('data/foundingProductsOneSingleSubmission.json');
    if (! file_exists($path)) return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$oneSingleSubmissionProducts = collect($oneSingleSubmissionProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/one-single-submission/' . $product['id'];
        return $product;
    })
    ->all();

// KEWAJIBAN PELAPORAN PERUSAHAAN
$kewajibanPelaporanPerusahaanProducts = (static function (): array {
    $path = public_path('data/foundingProductsKewajibanPelaporanPerusahaan.json');
    if (! file_exists($path)) return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$kewajibanPelaporanPerusahaanProducts = collect($kewajibanPelaporanPerusahaanProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/kewajiban-pelaporan-perusahaan/' . $product['id'];
        return $product;
    })
    ->all();

// LEGALISASI KEDUTAAN
$legalisasiKedutaanProducts = (static function (): array {
    $path = public_path('data/foundingProductsLegalisasiKedutaan.json');
    if (! file_exists($path)) return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$legalisasiKedutaanProducts = collect($legalisasiKedutaanProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/legalisasi-kedutaan/' . $product['id'];
        return $product;
    })
    ->all();

// KEKAYAAN INTELEKTUAL
$kekayaanIntelektualProducts = (static function (): array {
    $path = public_path('data/foundingProductsKekayaanIntelektual.json');
    if (! file_exists($path)) return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$kekayaanIntelektualProducts = collect($kekayaanIntelektualProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/kekayaan-intelektual/' . $product['id'];
        return $product;
    })
    ->all();

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
    Route::get($service['path'], function (Request $request) use ($kekayaanIntelektualProducts, $kewajibanPelaporanPerusahaanProducts, $legalisasiKedutaanProducts, $oneSingleSubmissionProducts, $badanHukumLuarNegeriProducts, $izinTinggalTetapProducts, $izinTinggalTerbatasProducts, $retainerBerlanggananProducts, $service, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema, $serviceSchema, $foundingProducts, $kantorPerwakilanProducts, $penyusunanDanPeninjauanProducts) {
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

        if ($service['path'] === '/kantor-perwakilan') {
            $props['products'] = $kantorPerwakilanProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Kantor Perwakilan - FastTrack',
                'description' => 'Daftar produk kantor perwakilan FastTrack.',
                'url' => $baseUrl . '/kantor-perwakilan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($kantorPerwakilanProducts)->values()->map(
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

        if ($service['path'] === '/penyusunan-peninjauan') {
            $props['products'] = $penyusunanDanPeninjauanProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Penyusunan Peninjauan - FastTrack',
                'description' => 'Daftar produk penyusunan peninjauan FastTrack.',
                'url' => $baseUrl . '/penyusunan-peninjauan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($penyusunanDanPeninjauanProducts)->values()->map(
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

        // RETAINER-BERLANGGANAN
        if ($service['path'] === '/retainer-berlangganan') {
            $props['products'] = $retainerBerlanggananProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Retainer / Berlangganan - FastTrack',
                'description' => 'Daftar produk penyusunan peninjauan FastTrack.',
                'url' => $baseUrl . '/retainer-berlangganan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($retainerBerlanggananProducts)->values()->map(
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

        // IZIN TINGGAL TERBATAS 
        if ($service['path'] === '/izin-tinggal-terbatas') {
            $props['products'] = $izinTinggalTerbatasProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Pendirian Perusahaan - FastTrack',
                'description' => 'Daftar produk pendirian perusahaan FastTrack untuk PT, CV, Firma, PMA, yayasan, koperasi, dan perkumpulan.',
                'url' => $baseUrl . '/izin-tinggal-terbatas',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($izinTinggalTerbatasProducts)->values()->map(
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

        // IZIN TINGGAL TETAP 
        if ($service['path'] === '/izin-tinggal-tetap') {
            $props['products'] = $izinTinggalTetapProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Izin Tinggal Tetap - FastTrack',
                'description' => 'Daftar produk pendirian perusahaan FastTrack untuk PT, CV, Firma, PMA, yayasan, koperasi, dan perkumpulan.',
                'url' => $baseUrl . '/izin-tinggal-tetap',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($izinTinggalTetapProducts)->values()->map(
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

        // BADAN USAHA LUAR NEGERI
        if ($service['path'] === '/badan-hukum-luar-negeri') {
            $props['products'] = $badanHukumLuarNegeriProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Badan Hukum Luar Negeri - FastTrack',
                'description' => 'Daftar produk badan usaha luar negeri FastTrack.',
                'url' => $baseUrl . '/badan-hukum-luar-negeri',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($badanHukumLuarNegeriProducts)->values()->map(
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

        // ONE SINGLE SUBMISSION
        if ($service['path'] === '/one-single-submission') {
            $props['products'] = $oneSingleSubmissionProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'One Single Submission - FastTrack',
                'description' => 'Daftar produk One Single Submission FastTrack.',
                'url' => $baseUrl . '/one-single-submission',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($oneSingleSubmissionProducts)->values()->map(
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

        // KEWAJIBAN PELAPORAN PERUSAHAAN
        if ($service['path'] === '/kewajiban-pelaporan-perusahaan') {
            $props['products'] = $kewajibanPelaporanPerusahaanProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Kewajiban Pelaporan Perusahaan - FastTrack',
                'description' => 'Daftar produk kewajiban pelaporan perusahaan FastTrack.',
                'url' => $baseUrl . '/kewajiban-pelaporan-perusahaan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($kewajibanPelaporanPerusahaanProducts)->values()->map(
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

        // LEGALISASI KEDUTAAN
        if ($service['path'] === '/legalisasi-kedutaan') {
            $props['products'] = $legalisasiKedutaanProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Legalisasi Kedutaan - FastTrack',
                'description' => 'Daftar produk legalisasi kedutaan FastTrack.',
                'url' => $baseUrl . '/legalisasi-kedutaan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($legalisasiKedutaanProducts)->values()->map(
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

        // KEKAYAAN INTELEKTUAL
        if ($service['path'] === '/kekayaan-intelektual') {
            $props['products'] = $kekayaanIntelektualProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Kekayaan Intelektual - FastTrack',
                'description' => 'Daftar produk kekayaan intelektual FastTrack.',
                'url' => $baseUrl . '/kekayaan-intelektual',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($kekayaanIntelektualProducts)->values()->map(
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

Route::get('/kantor-perwakilan/{id}', function (Request $request, int $id) use ($kantorPerwakilanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($kantorPerwakilanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($kantorPerwakilanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/KantorPerwakilan/Show', [
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
                ['name' => 'Kantor Perwakilan', 'item' => $baseUrl . '/kantor-perwakilan'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

Route::get('/penyusunan-peninjauan/{id}', function (Request $request, int $id) use ($penyusunanDanPeninjauanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($penyusunanDanPeninjauanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($penyusunanDanPeninjauanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/PenyusunanDanPeninjauanPerjanjian/Show', [
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
                ['name' => 'Penyusunan Peninjauan', 'item' => $baseUrl . '/penyusunan-peninjauan'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// RETAINER-BERLANGGANAN
Route::get('/retainer-berlangganan/{id}', function (Request $request, int $id) use ($retainerBerlanggananProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($retainerBerlanggananProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($retainerBerlanggananProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/RetainerBerlangganan/Show', [
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
                ['name' => 'Penyusunan Peninjauan', 'item' => $baseUrl . '/retainer-berlangganan'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// IZIN TINGGAL TERBATAS 
Route::get('/izin-tinggal-terbatas/{id}', function (Request $request, int $id) use ($izinTinggalTerbatasProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($izinTinggalTerbatasProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($izinTinggalTerbatasProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/IzinTinggalTerbatas/Show', [
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
                ['name' => 'Izin Tinggal Terbatas', 'item' => $baseUrl . '/izin-tinggal-terbatas'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// IZIN TINGGAL TERBATAS 
Route::get('/izin-tinggal-tetap/{id}', function (Request $request, int $id) use ($izinTinggalTetapProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($izinTinggalTetapProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($izinTinggalTetapProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/IzinTinggalTetap/Show', [
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
                ['name' => 'Izin Tinggal Terbatas', 'item' => $baseUrl . '/izin-tinggal-tetap'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// BADAN USAHA LUAR NEGERI
Route::get('/badan-hukum-luar-negeri/{id}', function (Request $request, int $id) use ($badanHukumLuarNegeriProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($badanHukumLuarNegeriProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($badanHukumLuarNegeriProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/BadanHukumLuarNegeri/Show', [
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
                'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
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
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Badan Hukum Luar Negeri', 'item' => $baseUrl . '/badan-hukum-luar-negeri'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// ONE SINGLE SUBMISSION
Route::get('/one-single-submission/{id}', function (Request $request, int $id) use ($oneSingleSubmissionProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($oneSingleSubmissionProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($oneSingleSubmissionProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/OneSingleSubmission/Show', [
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
                'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
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
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'One Single Submission', 'item' => $baseUrl . '/one-single-submission'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// KEWAJIBAN PELAPORAN PERUSAHAAN
Route::get('/kewajiban-pelaporan-perusahaan/{id}', function (Request $request, int $id) use ($kewajibanPelaporanPerusahaanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($kewajibanPelaporanPerusahaanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($kewajibanPelaporanPerusahaanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/KewajibanPelaporanPerusahaan/Show', [
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
                'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
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
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Kewajiban Pelaporan Perusahaan', 'item' => $baseUrl . '/kewajiban-pelaporan-perusahaan'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// LEGALISASI KEDUTAAN
Route::get('/legalisasi-kedutaan/{id}', function (Request $request, int $id) use ($legalisasiKedutaanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($legalisasiKedutaanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($legalisasiKedutaanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/LegalisasiKedutaan/Show', [
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
                'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
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
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Legalisasi Kedutaan', 'item' => $baseUrl . '/legalisasi-kedutaan'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// KEKAYAAN INTELEKTUAL
Route::get('/kekayaan-intelektual/{id}', function (Request $request, int $id) use ($kekayaanIntelektualProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($kekayaanIntelektualProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($kekayaanIntelektualProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    return Inertia::render('Services/KekayaanIntelektual/Show', [
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
                'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
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
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Kekayaan Intelektual', 'item' => $baseUrl . '/kekayaan-intelektual'],
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

// Route Tools KBLI 2025
Route::get('/panduan-kbli', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    $kbliData = [];
    $kbliPath = public_path('data/kbli2025.json');
    if (file_exists($kbliPath)) {
        $kbliData = json_decode(file_get_contents($kbliPath), true) ?? [];
    }

    return Inertia::render('PanduanKBLI/Index', [
        'seo' => [
            'title' => 'Panduan KBLI - FastTrack',
            'description' => 'Jelajahi Klasifikasi Baku Lapangan Usaha Indonesia (KBLI) secara bertahap — dari Kategori, Golongan Pokok, Golongan, Subgolongan, hingga Kelompok usaha yang sesuai.',
            'canonical' => $baseUrl . '/panduan-kbli',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Panduan KBLI - FastTrack',
                'description' => 'Jelajahi Klasifikasi Baku Lapangan Usaha Indonesia (KBLI) secara bertahap.',
                'url' => $baseUrl . '/panduan-kbli',
                'inLanguage' => 'id-ID',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Panduan KBLI', 'item' => $baseUrl . '/panduan-kbli'],
            ]),
        ],
        'kbliData' => $kbliData,
    ]);
});

// Route Konversi KBLI 2020 x 2025
Route::get('/konversi-kbli', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('KonversiKBLI/Index', [
        'seo' => [
            'title' => 'Tabel Konversi KBLI 2020 x KBLI 2025 - FastTrack',
            'description' => 'Panduan penyesuaian kode lapangan usaha dari KBLI 2020 ke KBLI 2025 untuk kepentingan statistik maupun administrasi.',
            'canonical' => $baseUrl . '/konversi-kbli',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Tabel Konversi KBLI 2020 x KBLI 2025 - FastTrack',
                'description' => 'Panduan penyesuaian kode lapangan usaha dari KBLI 2020 ke KBLI 2025.',
                'url' => $baseUrl . '/konversi-kbli',
                'inLanguage' => 'id-ID',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Layanan', 'item' => $baseUrl . '/layanan'],
                ['name' => 'Konversi KBLI', 'item' => $baseUrl . '/konversi-kbli'],
            ]),
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
