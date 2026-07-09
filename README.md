# FastTrack — Business Legal Services Website

Website layanan legalitas bisnis `FastTrack`, dibangun dengan `Laravel + Inertia.js + Vue 3 + Vite`, mendukung tiga bahasa (Indonesia / Inggris / Mandarin) di seluruh halaman layanan.

Untuk penjelasan arsitektur lengkap (routing, i18n, sitemap, welcome banner, dsb.), lihat [`architecture.md`](./architecture.md).

## Tech Stack

- **Backend:** PHP ^8.3, Laravel ^13.7, Inertia Laravel ^2.0, Ziggy, Sanctum
- **Frontend:** Vue 3, `@inertiajs/vue3`, `vue-i18n` (trilingual `id`/`en`/`zh`), Tailwind CSS
- **Build:** Vite ^8, `laravel-vite-plugin`

## Persiapan Lokal

Prasyarat: PHP 8.3+, Composer, Node.js + NPM, database (MySQL/MariaDB atau SQLite untuk lokal).

```bash
# clone & masuk ke folder project
git clone <repo-url>
cd dev-fasttrack-jcd

# install dependency
composer install
npm install

# environment
cp .env.example .env
php artisan key:generate

# konfigurasi koneksi database di .env, lalu jalankan migrasi
php artisan migrate

# build asset (development)
npm run dev
```

Atau pakai script gabungan bawaan Composer yang menjalankan server, queue listener, log viewer, dan Vite sekaligus:

```bash
composer run dev
```

Server akan tersedia di `http://localhost:8000` (sesuaikan dengan `APP_URL` di `.env`).

## Build Production

```bash
npm run build   # menjalankan `vite build` + `vite build --ssr`
```

> Build SSR (`bootstrap/ssr/`) berhasil dibuat dan Inertia SSR **enabled by default** di konfigurasi package, tapi repo ini belum menyediakan proses supervisor untuk menjalankan `php artisan inertia:start-ssr`. Tanpa proses tersebut aktif, aplikasi tetap berjalan normal via client-side rendering. Lihat [`architecture.md`](./architecture.md#utang-teknis--hal-yang-perlu-diperhatikan) untuk detail.

## Environment Variables Penting

Selain variabel standar Laravel (`APP_*`, `DB_*`), project ini punya beberapa env var khusus:

| Variabel | Default | Kegunaan |
| --- | --- | --- |
| `APP_LOCALE` | `en` | Locale Laravel untuk `app()->getLocale()`, dipakai `$pickLocale` di `routes/web.php` untuk resolve SEO/schema. **Tidak otomatis sinkron** dengan pilihan bahasa user di frontend (lihat `architecture.md`). |
| `WELCOME_BANNER_ENABLED` | `false` | Mengaktifkan/menonaktifkan welcome banner full-screen. |
| `WELCOME_BANNER_START_DATE` | *(kosong)* | Format `Y-m-d`. Banner mulai tampil sejak tanggal ini (kosong = tanpa batas awal). |
| `WELCOME_BANNER_END_DATE` | *(kosong)* | Format `Y-m-d`. Banner otomatis berhenti tampil setelah tanggal ini (kosong = tanpa batas akhir). |
| `INERTIA_SSR_ENABLED` | `true` | Bawaan package `inertiajs/inertia-laravel`. |

Konfigurasi welcome banner ada di `config/welcome-banner.php`.

## Struktur Konten Trilingual

Sebagian besar konten layanan disimpan dalam struktur `{ "id": "...", "en": "...", "zh": "..." }`, baik di:

- **`public/data/foundingProducts*.json`** — data produk per layanan (satu file per service)
- **`resources/js/i18n/locales/{id,en,zh}/`** — teks UI statis (hero, form, kartu layanan)

Field struktural (`id` numerik, `price`, `image`, `detail_path`, dsb.) tetap disimpan sebagai nilai biasa, tidak dibungkus per-bahasa. Detail pola dan helper (`pick()` di Vue, `$pickLocale` di Laravel) ada di [`architecture.md`](./architecture.md#3-i18n-layer-trilingual-content).

## Testing

```bash
composer test   # php artisan config:clear + php artisan test
```

## Dokumentasi Tambahan

- [`architecture.md`](./architecture.md) — arsitektur lengkap: routing, shared Inertia data, i18n, sitemap, welcome banner, daftar 25 layanan, utang teknis yang diketahui.
