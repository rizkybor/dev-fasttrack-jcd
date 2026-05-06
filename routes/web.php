<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Service;

Route::get('/', function () {
    return Inertia::render('Home', [
        'seo' => [
            'title' => 'FastTrack - Layanan Legalitas Bisnis Terpercaya',
            'description' => 'Platform layanan legalitas pendirian PT/CV dengan standar profesional tinggi.'
        ]
    ]);
});

Route::get('/layanan', function () {
    return Inertia::render('Services/Index', [
        'services' => Service::all(),
        'seo' => [
            'title' => 'Daftar Layanan Legalitas - FastTrack',
            'description' => 'Pilih layanan legalitas bisnis yang sesuai dengan kebutuhan Anda.'
        ]
    ]);
});

Route::get('/layanan/{slug}', function ($slug) {
    $service = Service::where('slug', $slug)->firstOrFail();
    return Inertia::render('Services/Show', [
        'service' => $service,
        'seo' => [
            'title' => $service->meta_title ?? $service->name . ' - FastTrack',
            'description' => $service->meta_description ?? $service->description
        ]
    ]);
});

Route::get('/artikel', function () {
    return Inertia::render('Blog', [
        'seo' => [
            'title' => 'Artikel & Edukasi Hukum Bisnis - FastTrack',
            'description' => 'Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.'
        ]
    ]);
});

Route::get('/kontak', function () {
    return Inertia::render('Contact', [
        'seo' => [
            'title' => 'Hubungi Kami - FastTrack',
            'description' => 'Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami.'
        ]
    ]);
});

// require __DIR__.'/auth.php';
