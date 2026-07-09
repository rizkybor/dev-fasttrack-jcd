<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $currentUrl = $request->url();
        $configuredUrl = rtrim((string) config('app.url'), '/');
        $siteUrl = $configuredUrl && ! str_contains($configuredUrl, 'localhost')
            ? $configuredUrl
            : $request->getSchemeAndHttpHost();
        $defaultImage = $siteUrl . '/images/og/og-image.png';

        // Tanggal aktif welcome banner selalu ditafsirkan sebagai waktu Indonesia (WIB),
        // bukan app.timezone (UTC) — supaya "2026-07-10" berarti awal hari itu di Jakarta,
        // sesuai maksud admin saat mengisi WELCOME_BANNER_START_DATE/END_DATE.
        $welcomeBannerEnabled = (bool) config('welcome-banner.enabled');
        $welcomeBannerStart = config('welcome-banner.start_date');
        $welcomeBannerEnd = config('welcome-banner.end_date');
        $now = Carbon::now('Asia/Jakarta');
        $isAfterStart = ! $welcomeBannerStart || $now->greaterThanOrEqualTo(Carbon::parse($welcomeBannerStart, 'Asia/Jakarta')->startOfDay());
        $isBeforeEnd = ! $welcomeBannerEnd || $now->lessThanOrEqualTo(Carbon::parse($welcomeBannerEnd, 'Asia/Jakarta')->endOfDay());

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'site' => [
                'name' => config('app.name', 'FastTrack'),
                'tagline' => 'Partner Tepercaya untuk Pendirian Perusahaan, Perizinan, dan Legalitas Bisnis Anda di Indonesia',
                'url' => $siteUrl,
                'current_url' => $currentUrl,
                'default_image' => $defaultImage,
                'locale' => 'id_ID',
            ],
            'welcomeBanner' => [
                'active' => $welcomeBannerEnabled && $isAfterStart && $isBeforeEnd,
            ],
            'seo' => fn () => [
                'title' => $request->session()->get('seo.title', 'Layanan Legalitas Bisnis | FastTrack'),
                'description' => $request->session()->get('seo.description', 'FastTrack Legal Services adalah partner tepercaya untuk pendirian perusahaan, perizinan usaha, dan legalitas bisnis Anda di Indonesia — profesional, cepat, dan terpercaya.'),
                'canonical' => $currentUrl,
                'image' => $defaultImage,
                'type' => 'website',
                'robots' => 'index, follow, max-image-preview:large',
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $currentUrl,
            ],
        ];
    }
}
