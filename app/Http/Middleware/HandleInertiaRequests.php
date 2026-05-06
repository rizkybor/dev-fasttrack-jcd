<?php

namespace App\Http\Middleware;

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
        $defaultImage = $siteUrl . '/fasttrack-og.svg';

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'site' => [
                'name' => config('app.name', 'FastTrack'),
                'tagline' => 'Legal Services - Partner Terbaik Perusahaan Anda',
                'url' => $siteUrl,
                'current_url' => $currentUrl,
                'default_image' => $defaultImage,
                'locale' => 'id_ID',
            ],
            'seo' => fn () => [
                'title' => $request->session()->get('seo.title', 'Layanan Legalitas Bisnis | FastTrack'),
                'description' => $request->session()->get('seo.description', 'Legal Services - Partner Terbaik Perusahaan Anda'),
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
