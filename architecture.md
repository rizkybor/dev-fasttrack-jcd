# FASTTRACK Architecture

## Ringkasan

Project ini adalah website layanan legalitas bisnis `FastTrack` yang dibangun dengan arsitektur `Laravel + Inertia.js + Vue 3 + Vite SSR`.

Fokus utamanya saat ini adalah:

- website publik dengan UI/UX profesional
- halaman layanan legalitas dan edukasi bisnis
- SEO metadata dan structured data per halaman
- sitemap dan robots untuk kebutuhan indexing
- mobile responsive layout dengan navigasi desktop dan mobile

Walaupun project masih membawa halaman bawaan auth/profile dari Laravel Breeze, fokus implementasi aktif saat ini ada pada halaman publik.

## Tech Stack

### Backend

- `PHP 8.3`
- `Laravel 13`
- `Inertia Laravel`
- `Ziggy`
- `Laravel Sanctum`
- `Eloquent / MySQL-ready` untuk data `services`

### Frontend

- `Vue 3`
- `@inertiajs/vue3`
- `Vite`
- `Vue SSR` via `@vue/server-renderer`
- `Tailwind CSS`
- `Axios`

### Tooling

- `Composer`
- `NPM`
- `Vite build + SSR build`
- `Laravel Breeze`
- `PHPUnit`
- `Laravel Pint`

## Struktur Arsitektur

### 1. HTTP Layer

Routing utama berada di `routes/web.php`.

Peran file ini:

- mendefinisikan seluruh public routes
- mengirim props ke halaman Inertia
- mengatur SEO metadata per halaman
- mengatur JSON-LD schema per halaman
- mendefinisikan data mock untuk artikel dan product pendirian
- menghasilkan `robots.txt` dan `sitemap.xml`

### 2. Shared Inertia Layer

Middleware `app/Http/Middleware/HandleInertiaRequests.php` membagikan data global ke seluruh halaman:

- `site.name`
- `site.tagline`
- `site.url`
- `site.current_url`
- `site.default_image`
- default `seo`
- `ziggy`

Ini membuat semua page bisa memakai fallback SEO dan branding yang konsisten.

### 3. Layout Layer

Layout utama ada di `resources/js/Layouts/MainLayout.vue`.

Tanggung jawab layout ini:

- render `<Head>` untuk meta tags
- inject global schema `Organization` dan `WebSite`
- render navbar desktop/mobile
- render mega menu layanan
- render dropdown Tips Bisnis
- render footer dan informasi kantor

Dengan pola ini, setiap halaman cukup fokus pada konten utama, sementara shell aplikasi tetap terpusat.

### 4. Page Layer

Halaman-halaman Vue berada di `resources/js/Pages`.

Struktur utamanya:

- `Home.vue`
- `Promo.vue`
- `About.vue`
- `Contact.vue`
- `Articles.vue`
- `Articles/Show.vue`
- `Kbli.vue`
- `Faq.vue`
- `Services/Index.vue`
- `Services/Show.vue`
- `Services/<ServiceName>/Index.vue`
- `Services/PendirianPerusahaan/Show.vue`

Pendekatan ini memisahkan:

- halaman umum
- halaman artikel
- halaman layanan database-driven
- halaman layanan custom yang punya desain spesifik

### 5. Data Strategy

Saat ini project memakai kombinasi data:

- `database` untuk route `layanan/{slug}` melalui model `App\Models\Service`
- `in-memory arrays` di `routes/web.php` untuk:
  - artikel
  - custom service pages
  - product pendirian perusahaan

Ini berarti sebagian halaman sudah siap memakai database, sementara sebagian konten marketing/public page masih dikelola sebagai data statis di route.

## Pola Rendering

Project memakai `Inertia.js` sehingga Laravel tetap menjadi entry backend utama, sedangkan Vue menangani rendering halaman.

Alur sederhananya:

1. request masuk ke route Laravel
2. route menghitung `baseUrl`, SEO, dan schema
3. route memanggil `Inertia::render(...)`
4. Vue page menerima props
5. `MainLayout.vue` membungkus page, meta tags, schema, navbar, dan footer

Project juga dikonfigurasi untuk SSR build:

- `vite build`
- `vite build --ssr`

Jadi arsitekturnya adalah `Laravel + Inertia SSR-oriented public website`.

## SEO Architecture

SEO dibangun di dua level:

### Global SEO

Disediakan oleh `HandleInertiaRequests.php` dan `MainLayout.vue`:

- default title
- default description
- canonical fallback
- OG tags
- Twitter card
- robots
- default image
- schema `Organization`
- schema `WebSite`

### Page SEO

Setiap route publik dapat mengirim:

- `seo.title`
- `seo.description`
- `seo.canonical`
- `seo.image`
- `seo.type`
- `schemas`

Schema yang sudah dipakai di project ini antara lain:

- `Organization`
- `WebSite`
- `WebPage`
- `CollectionPage`
- `ItemList`
- `Service`
- `Article`
- `FAQPage`
- `AboutPage`
- `ContactPage`
- `LegalService`
- `BreadcrumbList`

## UI/UX Architecture

Project memakai pola:

- satu `MainLayout` global
- section-based page composition
- Tailwind utility classes untuk responsive design
- komponen page-level tanpa over-abstraction berlebihan

Karakter UI saat ini:

- warna utama pink / primary
- warna secondary dark grey
- layout marketing style
- CTA kuat ke konsultasi dan WhatsApp
- desain mobile-first

## Halaman dan Modul Utama

### Public Marketing

- `Beranda`
- `Promo`
- `Tentang Kami`
- `Kontak`

### Edukasi Bisnis

- `Artikel`
- `Detail Artikel`
- `KBLI`
- `FAQ`

### Layanan

- `Daftar Layanan`
- `Detail layanan database`
- custom pages:
  - `Pendirian Perusahaan`
  - `Penutupan Perusahaan`
  - `Virtual Office`
  - `Perizinan Khusus`
  - `Pembuatan dan Peninjauan Perjanjian`
  - `Pembuatan dan Perubahan Dokumen Perusahaan`
  - `Digital Marketing`
  - `Perizinan Usaha`
  - `Izin Tax`
  - `Izin HAKI`
  - `Invest in Asia`
  - `Izin Hukum`
  - `Izin Properti`
  - `Izin Privilege`
  - `Layanan Lainnya`

### Product Detail Khusus

Pada modul `Pendirian Perusahaan`, tersedia katalog dan detail produk by id untuk:

- `Paket Pendirian PT`
- `Paket Pendirian CV`
- `Paket Pendirian Firma`
- `Persekutuan Perdata`
- `PMA`
- `Pendirian Yayasan`
- `Pendirian Koperasi`
- `Pendirian Perkumpulan`

## Sitemap Publik

Sitemap XML dihasilkan oleh route `GET /sitemap.xml`.

Sitemap saat ini mencakup:

### Static Pages

- `/`
- `/promo`
- `/layanan`
- `/artikel`
- `/kbli`
- `/faq`
- `/tentang-kami`
- `/kontak`

### Custom Service Pages

- `/badan-usaha`
- `/penutupan-perusahaan`
- `/virtual-office-jakarta`
- `/perizinan`
- `/pembuatan-perjanjian`
- `/perubahan-akta`
- `/digital-marketing`
- `/perizinan-usaha`
- `/perpajakan`
- `/haki`
- `/foreignservice`
- `/hukum`
- `/izin-properti`
- `/izin-privilege`
- `/layanan-lain`

### Dynamic Service Pages

Berasal dari database `services`:

- `/layanan/{slug}`

### Artikel

Berasal dari data artikel:

- `/artikel/{id}`

### Product Pendirian

Berasal dari data product pendirian:

- `/badan-usaha/{id}`

## Robots

Route `GET /robots.txt` saat ini:

- mengizinkan semua crawler
- mengarahkan crawler ke `sitemap.xml`

## Struktur Folder yang Relevan

```text
app/
  Http/Middleware/
    HandleInertiaRequests.php

resources/
  js/
    Layouts/
      MainLayout.vue
    Pages/
      Home.vue
      Promo.vue
      About.vue
      Contact.vue
      Articles.vue
      Kbli.vue
      Faq.vue
      Articles/
        Show.vue
      Services/
        Index.vue
        Show.vue
        PendirianPerusahaan/
          Index.vue
          Show.vue
        ...

routes/
  web.php

resources/views/
  app.blade.php
  sitemap.blade.php

public/
  favicon.ico
```

## Catatan Teknis Penting

- Stack aktual repository saat ini menggunakan `Laravel 13`, bukan `Laravel 11`.
- Project sudah siap untuk `SSR build`, tetapi deployment perlu memastikan proses SSR dan build assets dijalankan.
- Route `/layanan` dan `/layanan/{slug}` bergantung pada data database `services`.
- Banyak halaman marketing saat ini masih memakai data statis dari `routes/web.php`, sehingga mudah untuk demo tetapi nantinya sebaiknya dipindahkan ke source data yang lebih terstruktur.

## Rekomendasi Evolusi Selanjutnya

- pindahkan data artikel dan product marketing ke database atau CMS
- pecah data besar di `routes/web.php` ke service layer atau config/content layer
- buat reusable component untuk card produk, CTA, dan section hero
- tambahkan dokumentasi deployment terpisah untuk Railway / VPS / SSR
- tambahkan visual sitemap atau diagram arsitektur jika dibutuhkan untuk handoff tim
