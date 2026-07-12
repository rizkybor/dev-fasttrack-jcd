<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;

$resolveBaseUrl = static function (Request $request): string {
    $configuredUrl = rtrim((string) config('app.url'), '/');

    return $configuredUrl && !str_contains($configuredUrl, 'localhost')
        ? $configuredUrl
        : $request->getSchemeAndHttpHost();
};

$defaultImageUrl = static fn(string $baseUrl): string => $baseUrl . '/images/og/og-image.png';

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

// ARTIKEL / BLOG
$articles = (static function (): array {
    $path = public_path('data/articles.json');
    if (!file_exists($path)) {
        return [];
    }
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$articles = collect($articles)
    ->map(static function (array $article): array {
        $article['detail_path'] = '/artikel/' . $article['id'];
        return $article;
    })
    ->all();

Route::get('/', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $articles) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Home', [
        'articles' => collect($articles)->take(2)->values()->all(),
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
    ['component' => 'Services/BadanUsahaLuarNegeri/Index', 'title' => 'Badan Usaha Luar Negeri', 'path' => '/badan-usaha-luar-negeri', 'description' => 'Layanan pendirian badan usaha luar negeri untuk mendukung ekspansi bisnis internasional Anda di Indonesia.'],
    ['component' => 'Services/OneSingleSubmission/Index', 'title' => 'One Single Submission', 'path' => '/one-single-submission', 'description' => 'Layanan pengurusan perizinan One Single Submission (OSS) untuk kemudahan berusaha di Indonesia.'],
    ['component' => 'Services/KewajibanPelaporanPerusahaan/Index', 'title' => 'Kewajiban Pelaporan Perusahaan', 'path' => '/kewajiban-pelaporan-perusahaan', 'description' => 'Layanan pengurusan kewajiban pelaporan perusahaan sesuai regulasi yang berlaku di Indonesia.'],
    ['component' => 'Services/LegalisasiKedutaan/Index', 'title' => 'Legalisasi Kedutaan', 'path' => '/legalisasi-kedutaan', 'description' => 'Layanan legalisasi dokumen melalui kedutaan untuk keperluan bisnis internasional Anda.'],
    ['component' => 'Services/KekayaanIntelektual/Index', 'title' => 'Kekayaan Intelektual', 'path' => '/kekayaan-intelektual', 'description' => 'Layanan pendaftaran dan perlindungan kekayaan intelektual termasuk merek, paten, dan hak cipta.'],
    ['component' => 'Services/Penerjemah/Show', 'title' => 'Penerjemah', 'path' => '/penerjemah', 'description' => 'Layanan penerjemahan dan legalisasi dokumen yang dirancang untuk memenuhi kebutuhan individu maupun perusahaan di tingkat global.'],
    ['component' => 'Services/UjiTuntasHukum/Show', 'title' => 'Uji Tuntas Hukum', 'path' => '/uji-tuntas-hukum', 'description' => 'Mengidentifikasi Risiko, Memastikan Kepatuhan, dan Melindungi Investasi Anda dalam setiap transaksi bisnis, investasi, akuisisi, kerja sama strategis, maupun restrukturisasi perusahaan, memahami kondisi hukum suatu Perseroan Terbatas merupakan langkah yang sangat penting.'],
    ['component' => 'Services/PerizinanLainnya/Index', 'title' => 'Perizinan Lainnya', 'path' => '/perizinan-lainnya', 'description' => 'Layanan pengurusan perizinan usaha lainnya yang dibutuhkan untuk mendukung operasional bisnis Anda di Indonesia.'],
    ['component' => 'Services/PerizinanBerusaha/Index', 'title' => 'Perizinan Berusaha', 'path' => '/perizinan-berusaha', 'description' => 'Layanan pengurusan perizinan berusaha berbasis risiko melalui sistem OSS untuk mendukung operasional bisnis Anda di Indonesia.'],
    ['component' => 'Services/NotarisVirtualDanAkta/Index', 'title' => 'Notaris Virtual & Akta', 'path' => '/notaris-virtual-dan-akta', 'description' => 'Layanan notaris virtual dan pembuatan akta untuk kebutuhan legalitas perusahaan Anda secara efisien.'],
    ['component' => 'Services/RestrukturisasiPerseroanTerbatas/Index', 'title' => 'Restrukturisasi Perseroan Terbatas', 'path' => '/restrukturisasi-perseroan-terbatas', 'description' => 'Layanan restrukturisasi perseroan terbatas untuk mendukung transformasi dan pengembangan bisnis Anda.'],
    ['component' => 'Services/PenutupanBadanUsaha/Index', 'title' => 'Penutupan Badan Usaha', 'path' => '/penutupan-badan-usaha', 'description' => 'Layanan pengurusan penutupan badan usaha secara legal dan sesuai regulasi yang berlaku di Indonesia.'],
    ['component' => 'Services/KeimigrasianWniWna/Index', 'title' => 'Keimigrasian WNI & WNA', 'path' => '/keimigrasian-wni-wna', 'description' => 'Layanan keimigrasian untuk WNI dan WNA termasuk pengurusan visa, izin tinggal, dan dokumen keimigrasian lainnya.'],
    ['component' => 'Services/SertifikasiBadanUsaha/Index', 'title' => 'Sertifikasi Badan Usaha', 'path' => '/sertifikasi-badan-usaha', 'description' => 'Layanan pengurusan sertifikasi badan usaha untuk mendukung legalitas dan kredibilitas bisnis Anda di Indonesia.'],
    ['component' => 'Services/VisaMancanegara/Index', 'title' => 'Visa Mancanegara', 'path' => '/visa-mancanegara', 'description' => 'Layanan pengurusan visa ke berbagai negara untuk keperluan bisnis maupun perjalanan pribadi Anda.'],
    ['component' => 'Services/VisaIndonesia/Index', 'title' => 'Visa Indonesia', 'path' => '/visa-indonesia', 'description' => 'Layanan pengurusan visa kunjungan dan visa lainnya ke Indonesia untuk warga negara asing.'],
    ['component' => 'Services/VirtualOffice/Index', 'title' => 'Virtual Office', 'path' => '/virtual-office', 'description' => 'Layanan virtual office dengan alamat prestisius untuk mendukung operasional bisnis Anda secara profesional.'],
    ['component' => 'Services/DigitalMarketing/Index', 'title' => 'Digital Marketing', 'path' => '/digital-marketing', 'description' => 'Layanan digital marketing untuk meningkatkan visibilitas dan pertumbuhan bisnis Anda secara online.'],
    ['component' => 'Services/Naturalisasi/Index', 'title' => 'Naturalisasi', 'path' => '/naturalisasi', 'description' => 'Layanan pengurusan naturalisasi dan kewarganegaraan sesuai ketentuan hukum yang berlaku di Indonesia.'],
    ['component' => 'Services/PerpajakanDanPembukuan/Index', 'title' => 'Perpajakan & Pembukuan', 'path' => '/perpajakan-dan-pembukuan', 'description' => 'Layanan pengurusan perpajakan dan pembukuan untuk memastikan kepatuhan fiskal bisnis Anda.']
];

// BADAN USAHA 
$foundingProducts = (static function (): array {
    $path = public_path('data/foundingProductsBadanUsaha.json');

    if (!file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$foundingProducts = collect($foundingProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/badan-usaha/' . $product['id'];

        return $product;
    })
    ->all();

// KANTOR PERWAKILAN 
$kantorPerwakilanProducts = (static function (): array {
    $path = public_path('data/foundingProductsKantorPerwakilan.json');

    if (!file_exists($path)) {
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

    if (!file_exists($path)) {
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

    if (!file_exists($path)) {
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

    if (!file_exists($path)) {
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

    if (!file_exists($path)) {
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
$badanUsahaLuarNegeriProducts = (static function (): array {
    $path = public_path('data/foundingProductsBadanUsahaLuarNegeri.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$badanUsahaLuarNegeriProducts = collect($badanUsahaLuarNegeriProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/badan-usaha-luar-negeri/' . $product['id'];
        return $product;
    })
    ->all();

// ONE SINGLE SUBMISSION
$oneSingleSubmissionProducts = (static function (): array {
    $path = public_path('data/foundingProductsOneSingleSubmission.json');
    if (!file_exists($path))
        return [];
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
    if (!file_exists($path))
        return [];
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
    if (!file_exists($path))
        return [];
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
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$kekayaanIntelektualProducts = collect($kekayaanIntelektualProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/kekayaan-intelektual/' . $product['id'];
        return $product;
    })
    ->all();

// PENTERJEMAH 
$penerjemahProducts = (static function (): array {
    $path = public_path('data/foundingProductsPenerjemah.json');

    if (!file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$penerjemahProducts = collect($penerjemahProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/penerjemah/' . $product['id'];

        return $product;
    })
    ->all();

// UJI TUNTAS HUKUM 
$ujiTuntasHukumProducts = (static function (): array {
    $path = public_path('data/foundingProductsUjiTuntasHukum.json');

    if (!file_exists($path)) {
        return [];
    }

    $decoded = json_decode(file_get_contents($path), true);

    return is_array($decoded) ? $decoded : [];
})();

$ujiTuntasHukumProducts = collect($ujiTuntasHukumProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/uji-tuntas-hukum/' . $product['id'];

        return $product;
    })
    ->all();

// PERIZINAN LAINNYA
$perizinanLainnyaProducts = (static function (): array {
    $path = public_path('data/foundingProductsPerizinanLainnya.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$perizinanLainnyaProducts = collect($perizinanLainnyaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/perizinan-lainnya/' . $product['id'];
        return $product;
    })
    ->all();

// PERIZINAN BERUSAHA
$perizinanBerusahaProducts = (static function (): array {
    $path = public_path('data/foundingProductsPerizinanBerusaha.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$perizinanBerusahaProducts = collect($perizinanBerusahaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/perizinan-berusaha/' . $product['id'];
        return $product;
    })
    ->all();

// NOTARIS VIRTUAL DAN AKTA
$notarisVirtualDanAktaProducts = (static function (): array {
    $path = public_path('data/foundingProductsNotarisVirtualDanAkta.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$notarisVirtualDanAktaProducts = collect($notarisVirtualDanAktaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/notaris-virtual-dan-akta/' . $product['id'];
        return $product;
    })
    ->all();

// RESTRUKTURISASI PERSEROAN TERBATAS
$restrukturisasiPerseroanTerbatasProducts = (static function (): array {
    $path = public_path('data/foundingProductsRestrukturisasiPerseroanTerbatas.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$restrukturisasiPerseroanTerbatasProducts = collect($restrukturisasiPerseroanTerbatasProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/restrukturisasi-perseroan-terbatas/' . $product['id'];
        return $product;
    })
    ->all();

// PENUTUPAN BADAN USAHA
$penutupanBadanUsahaProducts = (static function (): array {
    $path = public_path('data/foundingProductsPenutupanBadanUsaha.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$penutupanBadanUsahaProducts = collect($penutupanBadanUsahaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/penutupan-badan-usaha/' . $product['id'];
        return $product;
    })
    ->all();

// KEIMIGRASIAN WNI WNA
$keimigrasianWniWnaProducts = (static function (): array {
    $path = public_path('data/foundingProductsKeimigrasianWniWna.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$keimigrasianWniWnaProducts = collect($keimigrasianWniWnaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/keimigrasian-wni-wna/' . $product['id'];
        return $product;
    })
    ->all();

// SERTIFIKASI BADAN USAHA
$sertifikasiBadanUsahaProducts = (static function (): array {
    $path = public_path('data/foundingProductsSertifikasiBadanUsaha.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$sertifikasiBadanUsahaProducts = collect($sertifikasiBadanUsahaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/sertifikasi-badan-usaha/' . $product['id'];
        return $product;
    })
    ->all();

// VISA MANCANEGARA
$visaMancanegaraProducts = (static function (): array {
    $path = public_path('data/foundingProductsVisaMancanegara.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$visaMancanegaraProducts = collect($visaMancanegaraProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/visa-mancanegara/' . $product['id'];
        return $product;
    })
    ->all();

// VISA INDONESIA
$visaIndonesiaProducts = (static function (): array {
    $path = public_path('data/foundingProductsVisaIndonesia.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$visaIndonesiaProducts = collect($visaIndonesiaProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/visa-indonesia/' . $product['id'];
        return $product;
    })
    ->all();

// VIRTUAL OFFICE
$virtualOfficeProducts = (static function (): array {
    $path = public_path('data/foundingProductsVirtualOffice.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$virtualOfficeProducts = collect($virtualOfficeProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/virtual-office/' . $product['id'];
        return $product;
    })
    ->all();

// DIGITAL MARKETING
$digitalMarketingProducts = (static function (): array {
    $path = public_path('data/foundingProductsDigitalMarketing.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$digitalMarketingProducts = collect($digitalMarketingProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/digital-marketing/' . $product['id'];
        return $product;
    })
    ->all();

// NATURALISASI
$naturalisasiProducts = (static function (): array {
    $path = public_path('data/foundingProductsNaturalisasi.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$naturalisasiProducts = collect($naturalisasiProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/naturalisasi/' . $product['id'];
        return $product;
    })
    ->all();

// PERPAJAKAN DAN PEMBUKUAN
$perpajakanDanPembukuanProducts = (static function (): array {
    $path = public_path('data/foundingProductsPerpajakanDanPembukuan.json');
    if (!file_exists($path))
        return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$perpajakanDanPembukuanProducts = collect($perpajakanDanPembukuanProducts)
    ->map(static function (array $product): array {
        $product['detail_path'] = '/perpajakan-dan-pembukuan/' . $product['id'];
        return $product;
    })
    ->all();

$staticPages = [
    '/',
    '/layanan',
    '/artikel',
    '/panduan-kbli',
    '/konversi-kbli',
    '/kebijakan-cookie',
    '/kebijakan-privasi',
    '/simulasi-akta',
    '/faq',
    '/kerjasama',
    '/minta-penawaran'
];

// robots.txt & sitemap.xml are registered at the end of this file (see bottom),
// once every *Products collection and $articles has been defined above.

foreach ($customServices as $service) {
    Route::get($service['path'], function (Request $request) use ($sertifikasiBadanUsahaProducts, $visaMancanegaraProducts, $visaIndonesiaProducts, $virtualOfficeProducts, $naturalisasiProducts, $digitalMarketingProducts, $perpajakanDanPembukuanProducts, $perizinanBerusahaProducts, $keimigrasianWniWnaProducts, $notarisVirtualDanAktaProducts, $perizinanLainnyaProducts, $restrukturisasiPerseroanTerbatasProducts, $penutupanBadanUsahaProducts, $penerjemahProducts, $ujiTuntasHukumProducts, $kekayaanIntelektualProducts, $kewajibanPelaporanPerusahaanProducts, $legalisasiKedutaanProducts, $oneSingleSubmissionProducts, $badanUsahaLuarNegeriProducts, $izinTinggalTetapProducts, $izinTinggalTerbatasProducts, $retainerBerlanggananProducts, $service, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema, $serviceSchema, $foundingProducts, $kantorPerwakilanProducts, $penyusunanDanPeninjauanProducts) {
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
        if ($service['path'] === '/badan-usaha-luar-negeri') {
            $props['products'] = $badanUsahaLuarNegeriProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Badan Usaha Luar Negeri - FastTrack',
                'description' => 'Daftar produk badan usaha luar negeri FastTrack.',
                'url' => $baseUrl . '/badan-usaha-luar-negeri',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($badanUsahaLuarNegeriProducts)->values()->map(
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

        // PENTERJEMAH
        if ($service['path'] === '/penerjemah') {
            $props['products'] = $penerjemahProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Penerjemah - FastTrack',
                'description' => 'Daftar produk penyusunan peninjauan FastTrack.',
                'url' => $baseUrl . '/penerjemah',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($penerjemahProducts)->values()->map(
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

        // UJI TUNTAS HUKUM
        if ($service['path'] === '/uji-tuntas-hukum') {
            $props['products'] = $ujiTuntasHukumProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Product Uji Tuntas Hukum - FastTrack',
                'description' => 'Daftar produk penyusunan peninjauan FastTrack.',
                'url' => $baseUrl . '/uji-tuntas-hukum',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($ujiTuntasHukumProducts)->values()->map(
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

        // PERIZINAN LAINNYA
        if ($service['path'] === '/perizinan-lainnya') {
            $props['products'] = $perizinanLainnyaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Perizinan Lainnya - FastTrack',
                'description' => 'Daftar produk perizinan lainnya FastTrack.',
                'url' => $baseUrl . '/perizinan-lainnya',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($perizinanLainnyaProducts)->values()->map(
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

        // NOTARIS VIRTUAL DAN AKTA
        if ($service['path'] === '/notaris-virtual-dan-akta') {
            $props['products'] = $notarisVirtualDanAktaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Notaris Virtual & Akta - FastTrack',
                'description' => 'Daftar produk notaris virtual dan akta FastTrack.',
                'url' => $baseUrl . '/notaris-virtual-dan-akta',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($notarisVirtualDanAktaProducts)->values()->map(
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

        // RESTRUKTURISASI PERSEROAN TERBATAS
        if ($service['path'] === '/restrukturisasi-perseroan-terbatas') {
            $props['products'] = $restrukturisasiPerseroanTerbatasProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Restrukturisasi Perseroan Terbatas - FastTrack',
                'description' => 'Daftar produk restrukturisasi perseroan terbatas FastTrack.',
                'url' => $baseUrl . '/restrukturisasi-perseroan-terbatas',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($restrukturisasiPerseroanTerbatasProducts)->values()->map(
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

        // PENUTUPAN BADAN USAHA
        if ($service['path'] === '/penutupan-badan-usaha') {
            $props['products'] = $penutupanBadanUsahaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Penutupan Badan Usaha - FastTrack',
                'description' => 'Daftar produk penutupan badan usaha FastTrack.',
                'url' => $baseUrl . '/penutupan-badan-usaha',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($penutupanBadanUsahaProducts)->values()->map(
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

        // KEIMIGRASIAN WNI WNA
        if ($service['path'] === '/keimigrasian-wni-wna') {
            $props['products'] = $keimigrasianWniWnaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Keimigrasian WNI & WNA - FastTrack',
                'description' => 'Daftar produk keimigrasian WNI dan WNA FastTrack.',
                'url' => $baseUrl . '/keimigrasian-wni-wna',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($keimigrasianWniWnaProducts)->values()->map(
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

        // SERTIFIKASI BADAN USAHA
        if ($service['path'] === '/sertifikasi-badan-usaha') {
            $props['products'] = $sertifikasiBadanUsahaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Sertifikasi Badan Usaha - FastTrack',
                'description' => 'Daftar produk sertifikasi badan usaha FastTrack.',
                'url' => $baseUrl . '/sertifikasi-badan-usaha',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($sertifikasiBadanUsahaProducts)->values()->map(
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

        // VISA MANCANEGARA
        if ($service['path'] === '/visa-mancanegara') {
            $props['products'] = $visaMancanegaraProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Visa Mancanegara - FastTrack',
                'description' => 'Daftar produk visa mancanegara FastTrack.',
                'url' => $baseUrl . '/visa-mancanegara',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($visaMancanegaraProducts)->values()->map(
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

        // VISA INDONESIA
        if ($service['path'] === '/visa-indonesia') {
            $props['products'] = $visaIndonesiaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Visa Indonesia - FastTrack',
                'description' => 'Daftar produk visa Indonesia FastTrack.',
                'url' => $baseUrl . '/visa-indonesia',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($visaIndonesiaProducts)->values()->map(
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

        // VIRTUAL OFFICE
        if ($service['path'] === '/virtual-office') {
            $props['products'] = $virtualOfficeProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Virtual Office - FastTrack',
                'description' => 'Daftar produk virtual office FastTrack.',
                'url' => $baseUrl . '/virtual-office',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($virtualOfficeProducts)->values()->map(
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

        // DIGITAL MARKETING
        if ($service['path'] === '/digital-marketing') {
            $props['products'] = $digitalMarketingProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Digital Marketing - FastTrack',
                'description' => 'Daftar produk digital marketing FastTrack.',
                'url' => $baseUrl . '/digital-marketing',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($digitalMarketingProducts)->values()->map(
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

        // NATURALISASI
        if ($service['path'] === '/naturalisasi') {
            $props['products'] = $naturalisasiProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Naturalisasi - FastTrack',
                'description' => 'Daftar produk naturalisasi FastTrack.',
                'url' => $baseUrl . '/naturalisasi',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($naturalisasiProducts)->values()->map(
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

        // PERPAJAKAN DAN PEMBUKUAN
        if ($service['path'] === '/perpajakan-dan-pembukuan') {
            $props['products'] = $perpajakanDanPembukuanProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Perpajakan & Pembukuan - FastTrack',
                'description' => 'Daftar produk perpajakan dan pembukuan FastTrack.',
                'url' => $baseUrl . '/perpajakan-dan-pembukuan',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($perpajakanDanPembukuanProducts)->values()->map(
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

        // PERIZINAN BERUSAHA
        if ($service['path'] === '/perizinan-berusaha') {
            $props['products'] = $perizinanBerusahaProducts;
            $props['schemas'][] = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Perizinan Berusaha - FastTrack',
                'description' => 'Daftar produk perizinan berusaha FastTrack.',
                'url' => $baseUrl . '/perizinan-berusaha',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => collect($perizinanBerusahaProducts)->values()->map(
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
// Helper pick locale — tambahkan di dekat $resolveBaseUrl
$pickLocale = static function (mixed $field, string $locale = null) use (&$pickLocale): mixed {
    $locale = $locale ?? app()->getLocale();
    if (is_array($field) && (isset($field['id']) || isset($field['en']) || isset($field['zh']))) {
        return $field[$locale] ?? $field['id'] ?? null;
    }
    return $field;
};

Route::get('/badan-usaha/{id}', function (Request $request, int $id) use ($foundingProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($foundingProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($foundingProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/BadanUsaha/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

Route::get('/kantor-perwakilan/{id}', function (Request $request, int $id) use ($kantorPerwakilanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($kantorPerwakilanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($kantorPerwakilanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/KantorPerwakilan/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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

Route::get('/penyusunan-peninjauan/{id}', function (Request $request, int $id) use ($penyusunanDanPeninjauanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($penyusunanDanPeninjauanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($penyusunanDanPeninjauanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/PenyusunanDanPeninjauanPerjanjian/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// RETAINER-BERLANGGANAN
Route::get('/retainer-berlangganan/{id}', function (Request $request, int $id) use ($retainerBerlanggananProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($retainerBerlanggananProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($retainerBerlanggananProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/RetainerBerlangganan/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// IZIN TINGGAL TERBATAS 
Route::get('/izin-tinggal-terbatas/{id}', function (Request $request, int $id) use ($izinTinggalTerbatasProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($izinTinggalTerbatasProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($izinTinggalTerbatasProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/IzinTinggalTerbatas/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// IZIN TINGGAL TERBATAS 
Route::get('/izin-tinggal-tetap/{id}', function (Request $request, int $id) use ($izinTinggalTetapProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($izinTinggalTetapProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($izinTinggalTetapProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/IzinTinggalTetap/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// BADAN USAHA LUAR NEGERI
Route::get('/badan-usaha-luar-negeri/{id}', function (Request $request, int $id) use ($badanUsahaLuarNegeriProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($badanUsahaLuarNegeriProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($badanUsahaLuarNegeriProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/BadanUsahaLuarNegeri/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Badan Usaha Luar Negeri', 'item' => $baseUrl . '/badan-usaha-luar-negeri'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// ONE SINGLE SUBMISSION
Route::get('/one-single-submission/{id}', function (Request $request, int $id) use ($oneSingleSubmissionProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($oneSingleSubmissionProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($oneSingleSubmissionProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/OneSingleSubmission/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// KEWAJIBAN PELAPORAN PERUSAHAAN
Route::get('/kewajiban-pelaporan-perusahaan/{id}', function (Request $request, int $id) use ($kewajibanPelaporanPerusahaanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($kewajibanPelaporanPerusahaanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($kewajibanPelaporanPerusahaanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/KewajibanPelaporanPerusahaan/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// LEGALISASI KEDUTAAN
Route::get('/legalisasi-kedutaan/{id}', function (Request $request, int $id) use ($legalisasiKedutaanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($legalisasiKedutaanProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($legalisasiKedutaanProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/LegalisasiKedutaan/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// KEKAYAAN INTELEKTUAL
Route::get('/kekayaan-intelektual/{id}', function (Request $request, int $id) use ($kekayaanIntelektualProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($kekayaanIntelektualProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($kekayaanIntelektualProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/KekayaanIntelektual/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// PENTERJEMAH
Route::get('/penerjemah/{id}', function (Request $request, int $id) use ($penerjemahProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($penerjemahProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($penerjemahProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/Penerjemah/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => 'Penerjemah', 'item' => $baseUrl . '/penerjemah'],
                ['name' => $product['name'], 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// UJI TUNTAS HUKUM
Route::get('/uji-tuntas-hukum/{id}', function (Request $request, int $id) use ($ujiTuntasHukumProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($ujiTuntasHukumProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($ujiTuntasHukumProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/UjiTuntasHukum/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
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
                ['name' => 'Uji Tuntas Hukum', 'item' => $baseUrl . '/uji-tuntas-hukum'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// PERIZINAN LAINNYA
Route::get('/perizinan-lainnya/{id}', function (Request $request, int $id) use ($perizinanLainnyaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($perizinanLainnyaProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($perizinanLainnyaProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/PerizinanLainnya/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Perizinan Lainnya', 'item' => $baseUrl . '/perizinan-lainnya'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// PERIZINAN BERUSAHA
Route::get('/perizinan-berusaha/{id}', function (Request $request, int $id) use ($perizinanBerusahaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($perizinanBerusahaProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($perizinanBerusahaProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/PerizinanBerusaha/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Perizinan Berusaha', 'item' => $baseUrl . '/perizinan-berusaha'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// NOTARIS VIRTUAL DAN AKTA
Route::get('/notaris-virtual-dan-akta/{id}', function (Request $request, int $id) use ($notarisVirtualDanAktaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($notarisVirtualDanAktaProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($notarisVirtualDanAktaProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/NotarisVirtualDanAkta/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Notaris Virtual & Akta', 'item' => $baseUrl . '/notaris-virtual-dan-akta'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// RESTRUKTURISASI PERSEROAN TERBATAS
Route::get('/restrukturisasi-perseroan-terbatas/{id}', function (Request $request, int $id) use ($restrukturisasiPerseroanTerbatasProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($restrukturisasiPerseroanTerbatasProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($restrukturisasiPerseroanTerbatasProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/RestrukturisasiPerseroanTerbatas/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Restrukturisasi Perseroan Terbatas', 'item' => $baseUrl . '/restrukturisasi-perseroan-terbatas'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// PENUTUPAN BADAN USAHA
Route::get('/penutupan-badan-usaha/{id}', function (Request $request, int $id) use ($penutupanBadanUsahaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($penutupanBadanUsahaProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($penutupanBadanUsahaProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    // Resolve field translatable untuk kebutuhan SEO & Schema
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/PenutupanBadanUsaha/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Penutupan Badan Usaha', 'item' => $baseUrl . '/penutupan-badan-usaha'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// KEIMIGRASIAN WNI WNA
Route::get('/keimigrasian-wni-wna/{id}', function (Request $request, int $id) use ($keimigrasianWniWnaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($keimigrasianWniWnaProducts)->firstWhere('id', $id);

    abort_if($product === null, 404);

    $relatedProducts = collect($keimigrasianWniWnaProducts)
        ->where('id', '!=', $id)
        ->take(3)
        ->values()
        ->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/KeimigrasianWniWna/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => [
            'title' => $productName . ' - FastTrack',
            'description' => $productExcerpt,
            'canonical' => $baseUrl . $product['detail_path'],
            'image' => $product['image'] ?: $defaultImageUrl($baseUrl),
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $productName,
                'description' => $productExcerpt,
                'serviceType' => $productName,
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
                'mainEntity' => collect($productFaq)->map(
                    static fn(array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                    ]
                )->all(),
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Keimigrasian WNI & WNA', 'item' => $baseUrl . '/keimigrasian-wni-wna'],
                ['name' => $productName, 'item' => $baseUrl . $product['detail_path']],
            ]),
        ],
    ]);
})->whereNumber('id');

// SERTIFIKASI BADAN USAHA
Route::get('/sertifikasi-badan-usaha/{id}', function (Request $request, int $id) use ($sertifikasiBadanUsahaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($sertifikasiBadanUsahaProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($sertifikasiBadanUsahaProducts)->where('id', '!=', $id)->take(3)->values()->all();
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];
    return Inertia::render('Services/SertifikasiBadanUsaha/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Sertifikasi Badan Usaha', 'item' => $baseUrl . '/sertifikasi-badan-usaha'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');

// VISA MANCANEGARA
Route::get('/visa-mancanegara/{id}', function (Request $request, int $id) use ($visaMancanegaraProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($visaMancanegaraProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($visaMancanegaraProducts)->where('id', '!=', $id)->take(3)->values()->all();
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];
    return Inertia::render('Services/VisaMancanegara/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Visa Mancanegara', 'item' => $baseUrl . '/visa-mancanegara'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');

// VISA INDONESIA
Route::get('/visa-indonesia/{id}', function (Request $request, int $id) use ($visaIndonesiaProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($visaIndonesiaProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($visaIndonesiaProducts)->where('id', '!=', $id)->take(3)->values()->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/VisaIndonesia/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Visa Indonesia', 'item' => $baseUrl . '/visa-indonesia'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');

// VIRTUAL OFFICE
Route::get('/virtual-office/{id}', function (Request $request, int $id) use ($virtualOfficeProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($virtualOfficeProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($virtualOfficeProducts)->where('id', '!=', $id)->take(3)->values()->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/VirtualOffice/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Virtual Office', 'item' => $baseUrl . '/virtual-office'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');

// DIGITAL MARKETING
Route::get('/digital-marketing/{id}', function (Request $request, int $id) use ($digitalMarketingProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($digitalMarketingProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($digitalMarketingProducts)->where('id', '!=', $id)->take(3)->values()->all();

    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];

    return Inertia::render('Services/DigitalMarketing/Show', [
        'service' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Digital Marketing', 'item' => $baseUrl . '/digital-marketing'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');

// NATURALISASI
Route::get('/naturalisasi/{id}', function (Request $request, int $id) use ($naturalisasiProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($naturalisasiProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($naturalisasiProducts)->where('id', '!=', $id)->take(3)->values()->all();
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];
    return Inertia::render('Services/Naturalisasi/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Naturalisasi', 'item' => $baseUrl . '/naturalisasi'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');

// PERPAJAKAN DAN PEMBUKUAN
Route::get('/perpajakan-dan-pembukuan/{id}', function (Request $request, int $id) use ($perpajakanDanPembukuanProducts, $resolveBaseUrl, $defaultImageUrl, $organizationReference, $breadcrumbSchema, $pickLocale) {
    $baseUrl = $resolveBaseUrl($request);
    $product = collect($perpajakanDanPembukuanProducts)->firstWhere('id', $id);
    abort_if($product === null, 404);
    $relatedProducts = collect($perpajakanDanPembukuanProducts)->where('id', '!=', $id)->take(3)->values()->all();
    $productName = $pickLocale($product['name']);
    $productExcerpt = $pickLocale($product['excerpt']);
    $productFaq = $pickLocale($product['faq']) ?? [];
    return Inertia::render('Services/PerpajakanDanPembukuan/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'seo' => ['title' => $productName . ' - FastTrack', 'description' => $productExcerpt, 'canonical' => $baseUrl . $product['detail_path'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl)],
        'schemas' => [
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $productName, 'description' => $productExcerpt, 'serviceType' => $productName, 'provider' => $organizationReference($baseUrl), 'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'], 'image' => $product['image'] ?: $defaultImageUrl($baseUrl), 'url' => $baseUrl . $product['detail_path'], 'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock', 'url' => $baseUrl . $product['detail_path']]],
            ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($productFaq)->map(static fn(array $faq): array => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->all()],
            $breadcrumbSchema([['name' => 'Beranda', 'item' => $baseUrl . '/'], ['name' => 'Perpajakan & Pembukuan', 'item' => $baseUrl . '/perpajakan-dan-pembukuan'], ['name' => $productName, 'item' => $baseUrl . $product['detail_path']]]),
        ],
    ]);
})->whereNumber('id');



// ====== BATAS LAYANAN ======

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

Route::get('/artikel', function (Request $request) use ($articles, $resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    $search = trim((string) $request->query('search', ''));
    $perPage = 5;

    $filteredArticles = collect($articles)
        ->filter(function (array $article) use ($search) {
            if ($search === '') {
                return true;
            }

            $haystack = strtolower(implode(' ', array_filter([
                $article['title'] ?? '',
                $article['excerpt'] ?? '',
                $article['category'] ?? '',
            ])));

            return str_contains($haystack, strtolower($search));
        })
        ->values();

    $total = $filteredArticles->count();
    $lastPage = max(1, (int) ceil($total / $perPage));
    $currentPage = max(1, min($lastPage, (int) $request->query('page', 1)));

    $paginatedArticles = $filteredArticles
        ->forPage($currentPage, $perPage)
        ->values()
        ->all();

    return Inertia::render('Articles/Index', [
        'articles' => $paginatedArticles,
        'pagination' => [
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'per_page' => $perPage,
            'total' => $total,
        ],
        'filters' => [
            'search' => $search,
        ],
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
                        static fn(array $article, int $index): array => [
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

// KERJA SAMA
Route::get('/kerjasama', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Kerjasama', [
        'seo' => [
            'title' => 'Kerjasama - FastTrack',
            'description' => 'Bergabunglah sebagai mitra referral FastTrack Legal melalui Program Client Get Client dan raih keuntungan bersama setiap kali rekomendasi Anda berhasil.',
            'canonical' => $baseUrl . '/kerjasama',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Kerjasama - FastTrack',
                'description' => 'Bergabunglah sebagai mitra referral FastTrack Legal melalui Program Client Get Client dan raih keuntungan bersama setiap kali rekomendasi Anda berhasil.',
                'url' => $baseUrl . '/kerjasama',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Kerjasama', 'item' => $baseUrl . '/kerjasama'],
            ]),
        ],
    ]);
});

Route::post('/kerjasama', function (Request $request) {
    $request->validate([
        'nama_lengkap' => ['required', 'string', 'max:255'],
        'nama_pic' => ['nullable', 'string', 'max:255'],
        'jenis_peserta' => ['required', 'string', 'max:100'],
        'jenis_peserta_lainnya' => ['nullable', 'string', 'max:255'],
        'bidang_usaha' => ['required', 'string', 'max:255'],
        'nomor_identitas' => ['nullable', 'string', 'max:100'],
        'no_whatsapp' => ['required', 'string', 'max:30'],
        'email' => ['required', 'email', 'max:255'],
        'alamat_domisili' => ['required', 'string', 'max:1000'],
        'media_sosial' => ['nullable', 'string', 'max:255'],
        'nama_bank' => ['required', 'string', 'max:100'],
        'nomor_rekening' => ['required', 'string', 'max:100'],
        'atas_nama' => ['required', 'string', 'max:255'],
        'nama_klien' => ['required', 'string', 'max:255'],
        'nama_pic_klien' => ['required', 'string', 'max:255'],
        'nomor_kontak_klien' => ['required', 'string', 'max:30'],
        'email_klien' => ['nullable', 'email', 'max:255'],
        'layanan_dibutuhkan' => ['nullable', 'array'],
        'layanan_dibutuhkan.*' => ['string', 'max:255'],
        'keterangan_tambahan' => ['nullable', 'string', 'max:2000'],
        'skema_insentif' => ['required', 'string', 'max:100'],
        'setuju_pernyataan' => ['accepted'],
    ]);

    // TODO: belum ada persistensi (DB/email) — saat ini submission hanya divalidasi
    // dan dikonfirmasi kembali ke pengguna. Tambahkan model/migration/notifikasi
    // di sini kalau data pendaftaran mitra referral perlu disimpan/ditindaklanjuti.

    return back()->with('success', 'Pendaftaran mitra referral Anda berhasil dikirim. Tim kami akan segera menghubungi Anda.');
})->name('kerjasama.store');

// MINTA PENAWARAN
Route::get('/minta-penawaran', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('MintaPenawaran', [
        'seo' => [
            'title' => 'Minta Penawaran - FastTrack',
            'description' => 'Ajukan permintaan penawaran layanan FastTrack sesuai kebutuhan legalitas bisnis Anda.',
            'canonical' => $baseUrl . '/minta-penawaran',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Minta Penawaran - FastTrack',
                'description' => 'Ajukan permintaan penawaran layanan FastTrack sesuai kebutuhan legalitas bisnis Anda.',
                'url' => $baseUrl . '/minta-penawaran',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Minta Penawaran', 'item' => $baseUrl . '/minta-penawaran'],
            ]),
        ],
    ]);
});

// PENAWARAN KHUSUS
Route::get('/penawaran-khusus', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('TermCondition', [
        'seo' => [
            'title' => 'Syarat dan Ketentuan - FastTrack',
            'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
            'canonical' => $baseUrl . '/penawaran-khusus',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Syarat dan Ketentuan - FastTrack',
                'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
                'url' => $baseUrl . '/penawaran-khusus',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Syarat dan Ketentuan', 'item' => $baseUrl . '/penawaran-khusus'],
            ]),
        ],
    ]);
});

// TENTANG-KAMI
Route::get('/penawaran-khusus', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('TermCondition', [
        'seo' => [
            'title' => 'Syarat dan Ketentuan - FastTrack',
            'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
            'canonical' => $baseUrl . '/penawaran-khusus',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Syarat dan Ketentuan - FastTrack',
                'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
                'url' => $baseUrl . '/penawaran-khusus',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Syarat dan Ketentuan', 'item' => $baseUrl . '/penawaran-khusus'],
            ]),
        ],
    ]);
});

// FAQ
Route::get('/faq', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('Faq', [
        'seo' => [
            'title' => 'FAQ - FastTrack',
            'description' => 'Jawaban singkat untuk pertanyaan yang paling sering ditanyakan terkait legalitas bisnis dan layanan FastTrack.',
            'canonical' => $baseUrl . '/faq',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'FAQ - FastTrack',
                'description' => 'Jawaban singkat untuk pertanyaan yang paling sering ditanyakan terkait legalitas bisnis dan layanan FastTrack.',
                'url' => $baseUrl . '/faq',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'FAQ', 'item' => $baseUrl . '/faq'],
            ]),
        ],
    ]);
});

// SIMULASI AKTA
Route::get('/simulasi-akta', function (Request $request) use ($resolveBaseUrl, $defaultImageUrl, $breadcrumbSchema) {
    $baseUrl = $resolveBaseUrl($request);

    return Inertia::render('SimulasiAkta', [
        'seo' => [
            'title' => 'Syarat dan Ketentuan - FastTrack',
            'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
            'canonical' => $baseUrl . '/simulasi-akta',
            'image' => $defaultImageUrl($baseUrl),
            'type' => 'website',
        ],
        'schemas' => [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Syarat dan Ketentuan - FastTrack',
                'description' => 'Syarat dan ketentuan penggunaan layanan FastTrack. Baca ketentuan lengkap sebelum menggunakan layanan kami.',
                'url' => $baseUrl . '/simulasi-akta',
            ],
            $breadcrumbSchema([
                ['name' => 'Beranda', 'item' => $baseUrl . '/'],
                ['name' => 'Syarat dan Ketentuan', 'item' => $baseUrl . '/simulasi-akta'],
            ]),
        ],
    ]);
});

// SYARAT KETENTUAN
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

// SITEMAP & ROBOTS
$allServiceProducts = array_merge(
    $foundingProducts,
    $kantorPerwakilanProducts,
    $penyusunanDanPeninjauanProducts,
    $retainerBerlanggananProducts,
    $izinTinggalTerbatasProducts,
    $izinTinggalTetapProducts,
    $badanUsahaLuarNegeriProducts,
    $oneSingleSubmissionProducts,
    $kewajibanPelaporanPerusahaanProducts,
    $legalisasiKedutaanProducts,
    $kekayaanIntelektualProducts,
    $penerjemahProducts,
    $ujiTuntasHukumProducts,
    $perizinanLainnyaProducts,
    $perizinanBerusahaProducts,
    $notarisVirtualDanAktaProducts,
    $restrukturisasiPerseroanTerbatasProducts,
    $penutupanBadanUsahaProducts,
    $keimigrasianWniWnaProducts,
    $sertifikasiBadanUsahaProducts,
    $visaMancanegaraProducts,
    $visaIndonesiaProducts,
    $virtualOfficeProducts,
    $digitalMarketingProducts,
    $naturalisasiProducts,
    $perpajakanDanPembukuanProducts,
    // $perizinanDasarProducts intentionally excluded: Services/PerizinanDasar/Index & Show
    // Vue components don't exist yet, so those routes 404 client-side. Add it back
    // to $allServiceProducts (and drop the $customServices filter below) once built.
);

// Services without a working Vue page yet should not be submitted to search engines.
$sitemapCustomServices = collect($customServices)
    ->values()
    ->all();

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

Route::get('/sitemap.xml', function (Request $request) use ($staticPages, $sitemapCustomServices, $articles, $allServiceProducts, $resolveBaseUrl) {
    $baseUrl = $resolveBaseUrl($request);

    $urls = collect($staticPages)
        ->map(fn($path) => [
            'loc' => $baseUrl . $path,
            'lastmod' => now()->toDateString(),
            'changefreq' => 'weekly',
            'priority' => $path === '/' ? '1.0' : '0.8',
        ])
        ->merge(
            collect($sitemapCustomServices)->map(fn($service) => [
                'loc' => $baseUrl . $service['path'],
                'lastmod' => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ])
        )
        ->merge(
            Service::query()->get()->map(fn($service) => [
                'loc' => $baseUrl . '/layanan/' . $service->slug,
                'lastmod' => $service->updated_at?->toDateString() ?? now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ])
        )
        ->merge(
            collect($articles)->map(fn($article) => [
                'loc' => $baseUrl . $article['detail_path'],
                'lastmod' => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ])
        )
        ->merge(
            collect($allServiceProducts)->map(fn($product) => [
                'loc' => $baseUrl . $product['detail_path'],
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

// require __DIR__.'/auth.php';
