<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Render halaman error (404/403/500/503) sebagai halaman Inertia
        // yang sesuai desain situs, alih-alih halaman error default Laravel.
        // 404/403 selalu pakai halaman kustom (tidak butuh debug trace).
        // 500/503 tetap pakai halaman debug bawaan Laravel di local/testing
        // supaya stack trace masih terlihat saat development.
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            $status = $response->getStatusCode();

            $customizable = in_array($status, [404, 403], true)
                || (in_array($status, [500, 503], true) && !app()->environment(['local', 'testing']));

            if ($customizable && !$request->expectsJson()) {
                return Inertia::render('Errors/Show', [
                    'status' => $status,
                    'seo' => [
                        'robots' => 'noindex, nofollow',
                    ],
                ])
                    ->toResponse($request)
                    ->setStatusCode($status);
            }

            return $response;
        });
    })->create();
