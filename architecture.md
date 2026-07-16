# FASTTRACK Architecture

## Ringkasan

Project ini adalah website layanan legalitas bisnis `FastTrack` yang dibangun dengan arsitektur `Laravel + Inertia.js + Vue 3 + Vite`, dan mendukung **tiga bahasa** (Indonesia, Inggris, Mandarin) di sisi frontend.

Fokus utamanya saat ini adalah:

- website publik dengan UI/UX profesional untuk ~25 layanan legalitas bisnis
- struktur konten trilingual (`id` / `en` / `zh`) di hampir seluruh halaman layanan
- SEO metadata dan structured data (JSON-LD) per halaman
- sitemap dan robots yang menyesuaikan otomatis dengan seluruh route yang aktif
- welcome banner promosi yang bisa diaktifkan/nonaktifkan dan dijadwalkan dari server
- mobile responsive layout dengan navigasi desktop dan mobile
- tiga form publik (kontak, minta penawaran, kerjasama/referral) dengan validasi email/WhatsApp, honeypot anti-spam, rate limiting, dan notifikasi email ke tim internal

Project masih membawa halaman bawaan auth/profile dari Laravel Breeze, tetapi fokus implementasi aktif ada pada halaman publik.

## Tech Stack

### Backend

- `PHP ^8.3`
- `Laravel ^13.7`
- `inertiajs/inertia-laravel ^2.0`
- `tightenco/ziggy ^2.0`
- `laravel/sanctum ^4.0`
- `Eloquent / MySQL` untuk data `services` (`App\Models\Service`, route `/layanan/{slug}`)
- `Illuminate\Mail` (Laravel Mail) untuk notifikasi form — 3 `Mailable` (`app/Mail/`), mailer aktif via `.env` `MAIL_MAILER` (`log` di dev, belum ada SMTP terkonfigurasi untuk production)

### Frontend

- `Vue 3 (^3.4)`, `<script setup>` di semua komponen
- `@inertiajs/vue3 ^2.0`
- `vue-i18n ^9.14` — trilingual UI (`id` / `en` / `zh`)
- `Vite ^8.0` + `laravel-vite-plugin` (alias `@` → `resources/js` disediakan otomatis oleh plugin ini, lihat `jsconfig.json`)
- `Tailwind CSS ^3.2`
- `jsPDF` untuk generate dokumen (fitur simulasi akta)

### Tooling

- `Composer`, `NPM`
- `Vite build`
- `Laravel Breeze` (auth scaffold, tidak jadi fokus utama)
- `PHPUnit`, `Laravel Pint`

## Struktur Arsitektur

### 1. HTTP Layer

Routing utama berada di `routes/web.php` (~3300 baris). Peran file ini:

- mendefinisikan seluruh public routes (halaman statis, `/layanan/{service}`, `/layanan/{service}/{id}`)
- memuat data produk per layanan dari `public/data/*.json` ke variabel `$xxxProducts`, lalu menyuntik `detail_path`
- mengatur SEO metadata dan JSON-LD schema per halaman
- me-resolve field trilingual (`{id, en, zh}`) ke string tunggal untuk kebutuhan SEO/schema via closure `$pickLocale`
- menghasilkan `robots.txt` dan `sitemap.xml` (didefinisikan di akhir file, setelah seluruh `$xxxProducts` dan `$articles` terdefinisi)

### 2. Shared Inertia Layer

Middleware `app/Http/Middleware/HandleInertiaRequests.php` membagikan data global ke seluruh halaman:

- `site.name`, `site.tagline`, `site.url`, `site.current_url`, `site.default_image`, `site.locale`
- `welcomeBanner.active` — boolean hasil kalkulasi `config('welcome-banner.*')` + tanggal server saat ini (lihat bagian [Welcome Banner](#welcome-banner))
- default `seo` (title/description/canonical/image/type/robots)
- `ziggy` (named route helper untuk frontend)

### 3. i18n Layer (Trilingual Content)

Ini adalah bagian arsitektur paling signifikan di project ini.

**Setup:** `resources/js/i18n/index.js` membuat instance `vue-i18n` dengan `legacy: false`, `fallbackLocale: 'id'`, dan locale awal dibaca dari `localStorage.getItem('locale')` (default `'id'`).

```
resources/js/i18n/locales/
  id/
    common.js         # navbar, footer, tombol umum
    home.js
    faq.js
    kerjasama.js
    minta-penawaran.js
    index.js           # menggabungkan semua module di atas + services/*
    services/
      badan-usaha.js
      izin-tinggal-terbatas.js
      virtual-office.js
      ... (21 file, satu per service Index.vue)
  en/  (struktur identik)
  zh/  (struktur identik)
```

**Dua pola konten trilingual dipakai berdampingan:**

1. **Static/UI copy** (hero text, label form, daftar kartu Index.vue) — disimpan di file `resources/js/i18n/locales/{id,en,zh}/**/*.js`, dikonsumsi via `t()` / `tm()` dari `useI18n()`.
2. **Data produk per-service** (`public/data/foundingProducts*.json`) — setiap field yang bisa dibaca user (`name`, `excerpt`, `tag`, `duration`, deskripsi paket, FAQ, dsb.) disimpan sebagai object `{ "id": "...", "en": "...", "zh": "..." }`, bukan string biasa. Field struktural (`id` numerik, `price`, `price_label`, `image`, `detail_path`) tetap plain, tidak pernah dibungkus per-locale.

**Di sisi Vue (`Services/<Nama>/Show.vue`)**, pola standarnya:

```js
const { locale } = useI18n();
const pick = (field) => {
    if (field && typeof field === "object" && !Array.isArray(field) &&
        ("id" in field || "en" in field || "zh" in field)) {
        return field[locale.value] ?? field.id ?? field;
    }
    return field;
};
const localizedProduct = computed(() => ({ ...props.product, name: pick(props.product.name), /* ... */ }));
const product = localizedProduct; // shadow prop supaya template tetap pakai `product.xxx`
```

Untuk data yang sangat bernested (mis. `sections`, `baru`/`perpanjangan`, `detail`), seluruh subtree dibungkus sekali per-locale (`{ id: {...}, en: {...}, zh: {...} }`) alih-alih membungkus tiap leaf field satu per satu.

**Di sisi Laravel (`routes/web.php`)**, closure `$pickLocale` melakukan hal yang sama untuk kebutuhan SEO/schema (title, description, FAQ JSON-LD):

```php
$pickLocale = static function (mixed $field, string $locale = null) use (&$pickLocale): mixed {
    $locale = $locale ?? app()->getLocale();
    if (is_array($field) && (isset($field['id']) || isset($field['en']) || isset($field['zh']))) {
        return $field[$locale] ?? $field['id'] ?? null;
    }
    return $field;
};
```

> ⚠️ **Catatan penting:** `app()->getLocale()` memakai `config('app.locale')` (`.env` → `APP_LOCALE`, saat ini `en`), **bukan** locale yang dipilih user di frontend (`useLocale.js` menyimpan pilihan hanya di `localStorage`, tidak pernah dikirim ke server via cookie/header). Artinya SEO title/description hasil render server **tidak otomatis mengikuti** bahasa yang sedang dipilih user di browser — keduanya berjalan independen. Ini bukan bug yang baru diperbaiki, melainkan keterbatasan arsitektur yang perlu diperhatikan bila SEO per-bahasa jadi prioritas ke depan (solusinya: sinkronkan locale via cookie yang dibaca middleware sebelum `HandleInertiaRequests`).

### 4. Layout Layer

Layout utama ada di `resources/js/Layouts/MainLayout.vue`. Tanggung jawab layout ini:

- render `<Head>` untuk meta tags, OG tags, Twitter card, dan JSON-LD (global + per halaman)
- render `<WelcomeBanner />` (lihat bagian tersendiri di bawah)
- render `AppHeader` (navbar desktop/mobile, mega menu layanan, language switcher via `useLocale`)
- render `AppFooter` (kontak, sosial media, navigasi, kantor cabang, **Popular Links**)

Dengan pola ini, setiap halaman cukup fokus pada konten utama, sementara shell aplikasi tetap terpusat.

### 5. Page Layer

Halaman-halaman Vue berada di `resources/js/Pages`. Struktur nyata saat ini:

```
Pages/
  Home.vue
  Faq.vue
  Kerjasama.vue
  MintaPenawaran.vue
  Articles.vue / Articles/Show.vue
  TermCondition.vue     # placeholder generik, masih dipakai oleh beberapa route yang belum dibuatkan halaman sendiri (lihat "Utang Teknis")
  Services/
    Index.vue           # daftar semua layanan (/layanan)
    Show.vue             # detail layanan database-driven (/layanan/{slug})
    BadanUsaha/{Index,Show}.vue
    VirtualOffice/{Index,Show}.vue
    DigitalMarketing/{Index,Show}.vue
    VisaIndonesia/{Index,Show}.vue
    ... (25 folder service, masing-masing Index.vue + Show.vue)
```

Setiap service custom (bukan yang database-driven `/layanan/{slug}`) punya folder sendiri di `Pages/Services/<Nama>` dengan pola konsisten:

- `Index.vue` — daftar produk/paket dalam service tsb., konten dari `tm("services.<namaService>.list")`
- `Show.vue` — detail satu produk, menerima prop `product` (JSON dari `public/data/`) + `relatedProducts`

### 6. Mail / Notification Layer

Tiga form publik mengirim notifikasi email ke tim internal (`config('mail.contact_recipient')`, env `MAIL_CONTACT_RECIPIENT`, default `cs@fasttrack.legal`) alih-alih hanya memvalidasi lalu diam. Pola untuk ketiganya konsisten:

| Form (route) | Mailable | Blade view | Data yang dikirim |
| --- | --- | --- | --- |
| Kontak di `Home.vue` — `POST /kontak` | `App\Mail\ContactFormSubmitted` | `emails/contact-form.blade.php` | nama, email, whatsapp, bidang usaha, pesan |
| `MintaPenawaran.vue` — `POST /minta-penawaran` | `App\Mail\QuoteRequestSubmitted` | `emails/quote-request.blade.php` | kategori/layanan/detail layanan (value + label snapshot), estimasi biaya, data pemohon |
| `Kerjasama.vue` — `POST /kerjasama` | `App\Mail\PartnerReferralSubmitted` | `emails/partner-referral.blade.php` | seluruh 6 section form pendaftaran mitra referral |

Setiap `Mailable` menerima `array $data` polos di constructor (bukan Eloquent model), set `replyTo($data['email'], $data['name'])` supaya tim bisa langsung membalas ke pengirim, dan me-render Blade view dengan `{{ }}` (auto-escaped, tidak ada `{!! !!}`) untuk mencegah HTML/XSS injection dari input user. `Mail::send()` dipanggil **sinkron** (Mailable tidak implement `ShouldQueue`) — lihat catatan di [Utang Teknis](#utang-teknis--hal-yang-perlu-diperhatikan).

**Pola anti-spam & validasi (dipakai di ketiga form, konsisten di client & server):**

- **Honeypot**, bukan reCAPTCHA — field tersembunyi `website` (posisi `absolute left-[-9999px]`, `tabindex="-1"`, `autocomplete="off"`) yang harus selalu kosong untuk user asli. Kalau terisi (bot yang auto-fill semua field), server membalas seolah sukses (`return back()->with('success', ...)`) tanpa benar-benar mengirim email — supaya bot tidak tahu bahwa ia terdeteksi.
- **Rate limiting** — `->middleware('throttle:5,1')` di ketiga route (maks. 5 request/menit per IP).
- **Validasi WhatsApp & Email seragam** — client-side regex `EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/` dan `WHATSAPP_PATTERN = /^[0-9]{10,13}$/` (angka saja, 10–13 digit; spasi/tanda hubung di-strip sebelum divalidasi & sebelum dikirim ke server), dicerminkan di server via Laravel `email` rule dan `regex:/^[0-9]{10,13}$/`. Error ditampilkan lewat komponen `InputError.vue` yang sudah ada, bukan validasi baru.

`MintaPenawaran.vue` juga sekaligus jadi *single source of truth* katalog layanan: dropdown kategori → layanan → detail (12 kategori, 26 grup layanan, ±85 item, harga diambil langsung dari `public/data/foundingProducts*.json`) didefinisikan di `resources/js/i18n/locales/{id,en,zh}/minta-penawaran.js`, lalu **dipakai ulang** oleh `Kerjasama.vue` sebagai sumber `<datalist>` autotext untuk field "Jenis Layanan Yang Dibutuhkan" (`tm("mintaPenawaran.detail_by_layanan")` diakses lintas-namespace, valid karena semua locale module di-spread jadi satu object di `locales/{id,en,zh}/index.js`).

### 7. Data Strategy

Kombinasi data yang dipakai:

- **Database** untuk route `/layanan/{slug}` via `App\Models\Service`
- **JSON file di `public/data/foundingProducts*.json`** untuk tiap service custom (25 file), dibaca sekali di awal `routes/web.php` dan di-cache dalam variabel `$xxxProducts` selama request berlangsung
- **In-memory array di `routes/web.php`** untuk daftar service (`$customServices`) dan artikel (`$articles`)

Setiap `$xxxProducts` melalui transform yang sama:

```php
$xProducts = (static function (): array {
    $path = public_path('data/foundingProductsX.json');
    if (!file_exists($path)) return [];
    $decoded = json_decode(file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
})();

$xProducts = collect($xProducts)
    ->map(fn (array $p): array => [...$p, 'detail_path' => '/x/' . $p['id']])
    ->all();
```

## Pola Rendering

Project memakai `Inertia.js` sehingga Laravel tetap menjadi entry backend utama, sedangkan Vue menangani rendering halaman. SSR **enabled by default** di config `inertiajs/inertia-laravel` (`ssr.enabled` default `true`, mengarah ke `http://127.0.0.1:13714`), dan `npm run build` (`vite build && vite build --ssr`) berhasil menghasilkan bundle SSR ke `bootstrap/ssr/`. Namun repo ini **belum punya proses/supervisor** yang menjalankan `php artisan inertia:start-ssr` di production — tanpa proses tersebut berjalan, Inertia akan fallback diam-diam ke client-side rendering biasa (ini yang terjadi di semua environment dev/testing sepanjang project ini dikerjakan).

Alur sederhananya:

1. request masuk ke route Laravel
2. route menghitung `baseUrl`, resolve field trilingual via `$pickLocale`, menyusun SEO + schema
3. route memanggil `Inertia::render('Services/<Nama>/Show', [...])`
4. Vue page menerima props (termasuk data trilingual mentah `{id,en,zh}`)
5. Vue page melokalkan data sesuai `locale` yang dipilih user (`pick()` helper)
6. `MainLayout.vue` membungkus page, meta tags, schema, navbar, welcome banner, dan footer

## SEO Architecture

SEO dibangun di dua level:

### Global SEO

Disediakan oleh `HandleInertiaRequests.php` dan `MainLayout.vue`: default title/description, canonical fallback, OG tags, Twitter card, robots, default image, schema `Organization` + `WebSite`.

### Page SEO

Setiap route publik dapat mengirim `seo.title`, `seo.description`, `seo.canonical`, `seo.image`, `seo.type`, dan `schemas`. Schema yang dipakai antara lain: `Organization`, `WebSite`, `WebPage`, `CollectionPage`, `ItemList`, `Service`, `Article`, `FAQPage`, `BreadcrumbList`.

## Sitemap & Robots

`GET /sitemap.xml` dan `GET /robots.txt` didefinisikan di **akhir** `routes/web.php` (setelah seluruh `$xxxProducts` dan `$articles` terdefinisi — sebelumnya kedua route ini nonaktif/di-comment karena bergantung pada variabel yang belum ada di titik file tempat mereka semula ditulis).

Sitemap menggabungkan empat sumber:

1. **`$staticPages`** — halaman statis yang sudah dikonfirmasi render konten benar: `/`, `/layanan`, `/artikel`, `/panduan-kbli`, `/konversi-kbli`, `/kebijakan-cookie`, `/kebijakan-privasi`, `/syarat-ketentuan`, `/simulasi-akta`, `/faq`, `/kerjasama`, `/minta-penawaran` (12 path)
2. **`$sitemapCustomServices`** — hasil filter `$customServices` yang membuang service tanpa halaman Vue yang berfungsi (lihat "Utang Teknis")
3. **`Service::query()->get()`** — halaman database-driven `/layanan/{slug}`
4. **`$allServiceProducts`** — gabungan seluruh 26 koleksi produk (`array_merge($foundingProducts, $kantorPerwakilanProducts, ...)`), menghasilkan seluruh URL `/{service}/{id}`

`robots.txt` mengizinkan semua crawler dan mengarahkan ke `sitemap.xml`.

## Welcome Banner

Fitur promosi full-screen yang muncul sekali per sesi browser, dikontrol dari server (bukan hardcode di frontend):

- **`config/welcome-banner.php`** — `enabled` (bool), `start_date`, `end_date` (format `Y-m-d`, keduanya opsional/open-ended), semuanya dibaca dari `.env` (`WELCOME_BANNER_ENABLED`, `WELCOME_BANNER_START_DATE`, `WELCOME_BANNER_END_DATE`)
- **`HandleInertiaRequests.php`** — menghitung `active = enabled && now() dalam rentang [start_date, end_date]` (pakai `Carbon`, mengikuti `config('app.timezone')` = UTC) dan membagikannya sebagai `page.props.welcomeBanner.active`
- **`resources/js/Components/WelcomeBanner.vue`** — hanya tampil jika `welcomeBanner.active` bernilai true **dan** belum pernah ditampilkan di sesi browser ini (`sessionStorage`). Gambar (`/images/welcome/welcome-banner.jpeg`) memakai `object-contain` (tidak terpotong), seluruh gambar bisa diklik untuk redirect ke WhatsApp (`useWhatsapp` composable), dan ada tombol tutup terpisah.

## UI/UX Architecture

- satu `MainLayout` global, section-based page composition
- Tailwind utility classes untuk responsive design
- warna utama merah/primary (`#9e1f16`), warna secondary dark grey
- CTA kuat ke konsultasi dan WhatsApp (lihat `useWhatsapp` di bawah)
- desain mobile-first

### `useWhatsapp` composable

`resources/js/Composables/useWhatsapp.js` — satu sumber kebenaran untuk seluruh link WhatsApp di project:

- `PHONES` — daftar nomor per "agent" (`default`, `sales`, `cs`, `akta`, `perizinan`, `imigrasi`, `pajak`, `visa`, `virtual_office`, `digital`)
- `MESSAGES` — template pesan pre-filled per agent
- `waLink(service, options)` — fungsi murni (bisa dipanggil langsung tanpa hook), dipakai di tempat yang butuh link sekali pakai (mis. tombol CTA VIP di `Home.vue`, `FooterCTA` di `MintaPenawaran.vue`)
- `useWhatsapp(agent)` → `{ buildWhatsappLink(service, options) }`, dipakai di hampir semua `Show.vue` dan `WelcomeBanner.vue`

### `FooterCTA` component

`resources/js/Components/FooterCTA.vue` — banner CTA generik ("butuh bantuan lebih lanjut?") yang ditaruh di akhir hampir seluruh `Index.vue`/`Show.vue` per-service serta `MintaPenawaran.vue`. Props: `title`, `description`, `button-text`, `whatsapp-link` (link dibangun lewat `useWhatsapp`/`waLink` dengan agent & pesan yang disesuaikan per service, bukan nomor/teks hardcoded).

### Pola Form Publik (Kontak, Minta Penawaran, Kerjasama)

Tiga form interaktif (`Home.vue` bagian kontak, `MintaPenawaran.vue`, `Kerjasama.vue`) berbagi pola yang sama — lihat detail lengkap di [Mail / Notification Layer](#6-mail--notification-layer): validasi email/WhatsApp client+server yang identik, honeypot anti-spam (bukan reCAPTCHA), rate limiting, dan submit yang mengirim email ke tim (bukan mem-bypass ke WhatsApp), kecuali form kontak di `Home.vue` yang **sekaligus** membuka WhatsApp di tab baru (dua saluran notifikasi paralel) sementara `MintaPenawaran.vue` dan `Kerjasama.vue` hanya mengirim email.

## Rekap: Halaman, Fitur, Kategori & Layanan

Angka di bawah dihitung langsung dari kode saat ini (`routes/web.php`, `resources/js/Pages`, `resources/js/i18n/locales`), bukan estimasi — dipakai juga untuk mengoreksi beberapa angka lama di dokumen ini yang sudah tidak akurat (mis. jumlah layanan custom sebelumnya tertulis 25, faktanya 26).

### Halaman (Pages)

| Kelompok | Jumlah file `.vue` | Detail |
| --- | --- | --- |
| Layanan custom (`Pages/Services/<Nama>/`) | 26 folder → 50 file (`Index.vue` + `Show.vue` masing-masing, kecuali 2 folder) | 24 folder punya `Index.vue` + `Show.vue`; **`Penerjemah`** dan **`UjiTuntasHukum`** hanya punya `Show.vue` (tanpa halaman listing) |
| Layanan database-driven | 2 file | `Services/Index.vue` (`/layanan`), `Services/Show.vue` (`/layanan/{slug}`, via `App\Models\Service`) |
| Halaman umum & konten | 10 file | `Home.vue`, `Faq.vue`, `Kerjasama.vue`, `MintaPenawaran.vue`, `SimulasiAkta.vue`, `CookiePolicy.vue`, `PrivacyPolicy.vue`, `TermCondition.vue`, `Articles/{Index,Show}.vue` |
| Tools / alat bantu | 2 file | `PanduanKBLI/Index.vue`, `KonversiKBLI/Index.vue` (Index-only, tidak ada halaman detail) |
| Auth/Profile (Breeze, tidak jadi fokus aktif) | 10 file | scaffold bawaan, lihat [Ringkasan](#ringkasan) |
| **Orphan — tidak dirender route manapun** ⚠️ | 2 file | `Kbli.vue`, `About.vue` — tidak ada `Inertia::render('Kbli'\|'About', ...)` di `routes/web.php`; kandidat dihapus atau baru "setengah jadi" |
| **Total file di `Pages/`** | **76 file** | 66 di luar Auth/Profile, 64 di antaranya benar-benar punya route aktif |

Catatan: `TermCondition.vue` dipakai ulang oleh **2 route berbeda** (`/syarat-ketentuan` dan `/penawaran-khusus`, yang terakhir bahkan terdaftar **dua kali** di `routes/web.php`) — kontennya generik (daftar layanan), bukan konten Syarat & Ketentuan sungguhan (lihat [Utang Teknis](#utang-teknis--hal-yang-perlu-diperhatikan)).

### Fitur Utama

| Fitur | Implementasi |
| --- | --- |
| UI trilingual (`id`/`en`/`zh`) | `vue-i18n`, lihat [i18n Layer](#3-i18n-layer-trilingual-content) |
| SEO + JSON-LD per halaman | `seo`/`schemas` props dari tiap route + `MainLayout.vue` |
| Sitemap & robots otomatis | `GET /sitemap.xml`, `GET /robots.txt`, digabung dari 4 sumber data |
| Welcome banner terjadwal | `config/welcome-banner.php` + `WelcomeBanner.vue` |
| 3 formulir publik + notifikasi email | Kontak (`Home.vue`), Minta Penawaran, Kerjasama — lihat [Mail / Notification Layer](#6-mail--notification-layer) |
| Anti-spam honeypot + rate limiting | `throttle:5,1` di 3 route form, field `website` tersembunyi |
| Katalog layanan terpusat (dropdown Minta Penawaran) | 12 kategori / 26 grup layanan / 87 item, dipakai ulang sebagai autotext di Kerjasama |
| Generator & pengecek nama PT | `ModalGenerateName.vue`, `ModalCheckName.vue` (via `useModals.js`) |
| Simulasi Akta Pendirian (generate PDF) | `SimulasiAkta.vue` + `useAktaPdf.js` (`jsPDF`) |
| Panduan & Konversi KBLI | `PanduanKBLI/Index.vue`, `KonversiKBLI/Index.vue` |
| Artikel/blog | `Articles/{Index,Show}.vue`, data dari `public/data/articles.json` |
| CTA WhatsApp terpusat | `useWhatsapp.js` (10 "agent"), dipakai di hampir semua halaman layanan + `FooterCTA.vue` |
| Mega menu navigasi layanan | `AppHeader.vue`, data `services/mega-menu.js` |

### Kategori Layanan

Ada **dua sistem kategorisasi berbeda**, untuk tujuan berbeda — jangan disamakan:

1. **Mega menu navigasi** (`resources/js/i18n/locales/{id,en,zh}/services/mega-menu.js`, dipakai `AppHeader.vue`) — untuk browsing/discovery:
   - **9 kategori** → **19 grup layanan** → **63 item leaf** + **5 tools** (Cek Nama PT, Panduan KBLI, Konversi KBLI, Simulasi Akta, Generator Nama)
2. **Dropdown "Minta Penawaran"** (`minta-penawaran.js`, dipakai juga sebagai sumber autotext di `Kerjasama.vue`) — untuk kalkulasi estimasi biaya per item:
   - **12 kategori** → **26 grup layanan** → **87 item detail**, tiap item punya `harga` (angka, atau `null` = "Hubungi Kami") yang diambil langsung dari `public/data/foundingProducts*.json`

### Layanan (Services)

**26 layanan custom** terdaftar di `$customServices` (`routes/web.php`), masing-masing dengan komponen sendiri di `Pages/Services/<Nama>/`:

Badan Usaha, Kantor Perwakilan, Penyusunan & Peninjauan Perjanjian, Retainer/Berlangganan, Izin Tinggal Terbatas, Izin Tinggal Tetap, Badan Usaha Luar Negeri, One Single Submission, Kewajiban Pelaporan Perusahaan, Legalisasi Kedutaan, Kekayaan Intelektual, Penerjemah, Uji Tuntas Hukum, Perizinan Lainnya, Perizinan Berusaha, Notaris Virtual & Akta, Restrukturisasi Perseroan Terbatas, Penutupan Badan Usaha, Keimigrasian WNI & WNA, Sertifikasi Badan Usaha, Visa Mancanegara, Visa Indonesia, Virtual Office, Digital Marketing, Naturalisasi, Perpajakan & Pembukuan.

Ditambah **1 layanan database-driven** generik (`/layanan/{slug}`, model `App\Models\Service`).

> ⚠️ **Koreksi dari versi dokumen sebelumnya:** `Perizinan Dasar` **tidak lagi** memiliki route (`/perizinan-dasar` sudah tidak terdaftar di `routes/web.php`, dan entrinya sudah tidak ada di `$customServices`). File data `public/data/foundingProductsPerizinanDasar.json` masih ada di disk tapi sekarang **orphan** (tidak dibaca route manapun). Catatan lama tentang "route ada tapi komponen belum dibuat" sudah tidak berlaku — hapus file JSON-nya atau bangun kembali route+komponennya kalau layanan ini masih relevan.

Ditambah halaman umum: FAQ, Kerjasama (mitra referral), Minta Penawaran, Artikel, Panduan KBLI, Konversi KBLI, Simulasi Akta (generate PDF via `useAktaPdf.js`), Kebijakan Cookie, Kebijakan Privasi.

### Total Rekap

| Item | Total |
| --- | --- |
| Bahasa (i18n) | 3 (`id`, `en`, `zh`) |
| Halaman aktif (punya route) | 64 file `.vue` (di luar Breeze) |
| Halaman orphan (tanpa route) | 2 (`Kbli.vue`, `About.vue`) |
| Layanan custom (`$customServices`) | 26 |
| Layanan database-driven | 1 |
| Total route `GET` | 45 |
| Total route `POST` (form + mail) | 3 (`/kontak`, `/minta-penawaran`, `/kerjasama`) |
| Kategori mega menu (navigasi) | 9 kategori / 19 grup / 63 item |
| Kategori Minta Penawaran (kalkulasi biaya) | 12 kategori / 26 grup / 87 item |
| Agent WhatsApp (`useWhatsapp.js`) | 10 |
| Mailable (notifikasi email) | 3 |
| File data produk JSON (`public/data/foundingProducts*.json`) | 26 aktif dipakai (+ 1 orphan `PerizinanDasar`) |

## Struktur Folder yang Relevan

```text
app/
  Http/Middleware/
    HandleInertiaRequests.php
  Mail/
    ContactFormSubmitted.php
    QuoteRequestSubmitted.php
    PartnerReferralSubmitted.php
  Models/
    Service.php

config/
  welcome-banner.php
  mail.php               # + key custom `contact_recipient` (env MAIL_CONTACT_RECIPIENT)

resources/
  js/
    i18n/
      index.js
      locales/{id,en,zh}/
        common.js, home.js, faq.js, kerjasama.js, minta-penawaran.js, index.js
        services/*.js   (satu per service Index.vue)
    Composables/
      useWhatsapp.js
      useLocale.js
      useAktaPdf.js
      useModals.js
    Components/
      AppHeader.vue
      AppFooter.vue
      WelcomeBanner.vue
      FooterCTA.vue
      InputError.vue
      ...
    Layouts/
      MainLayout.vue
    Pages/
      Home.vue, Faq.vue, Kerjasama.vue, MintaPenawaran.vue, ...
      Services/
        Index.vue, Show.vue           # /layanan, /layanan/{slug} (database-driven)
        <Nama>/{Index,Show}.vue       # 25 folder, satu per service custom

routes/
  web.php

resources/views/
  app.blade.php
  sitemap.blade.php
  emails/
    contact-form.blade.php
    quote-request.blade.php
    partner-referral.blade.php

public/
  data/
    foundingProducts*.json   (25 file, satu per service, struktur {id,en,zh})
    articles.json
  images/welcome/welcome-banner.jpeg
```

## Utang Teknis / Hal yang Perlu Diperhatikan

- **`public/data/foundingProductsPerizinanDasar.json` jadi orphan.** Route `/perizinan-dasar`, `/perizinan-dasar/{id}` dan entrinya di `$customServices` sudah tidak ada di `routes/web.php`, tapi file JSON-nya masih ada di disk dan tidak dibaca route manapun. Hapus filenya kalau layanan ini memang tidak jadi dilanjutkan, atau bangun kembali route + `Services/PerizinanDasar/{Index,Show}.vue` kalau masih relevan.
- **`Kbli.vue` dan `About.vue` di `resources/js/Pages/` adalah file orphan** — tidak ada `Inertia::render('Kbli', ...)` atau `Inertia::render('About', ...)` di `routes/web.php` mana pun. Kemungkinan sisa halaman yang belum selesai diintegrasikan atau sudah digantikan (`PanduanKBLI/Index.vue` tampaknya jadi pengganti `Kbli.vue`). Hapus kalau memang tidak dipakai, atau selesaikan route-nya kalau masih direncanakan.
- **Route `/penawaran-khusus` terdaftar dua kali** (`routes/web.php`), dengan komentar `// TENTANG-KAMI` di atas duplikatnya — kemungkinan besar halaman "Tentang Kami" yang gagal diubah path-nya saat copy-paste. `/tentang-kami` sendiri saat ini tidak terdaftar sebagai route aktif.
- **`app()->getLocale()` (server) tidak sinkron dengan locale pilihan user (client).** Lihat catatan di bagian [i18n Layer](#3-i18n-layer-trilingual-content) di atas.
- Beberapa route (`/syarat-ketentuan`, `/penawaran-khusus`) masih merender `TermCondition.vue`, komponen generik yang sebenarnya didesain sebagai halaman daftar layanan, bukan konten Syarat & Ketentuan — kontennya tidak sepenuhnya sesuai dengan tujuan halaman.
- SSR **enabled by default** di config Inertia (`ssr.enabled` default `true`) dan bundle-nya (`resources/js/ssr.js` → `bootstrap/ssr/`) berhasil dibuild, tapi tidak ada proses `php artisan inertia:start-ssr` yang disupervisi di repo ini — perlu ditambahkan di deployment (systemd/supervisor/Procfile) kalau SSR ingin benar-benar jalan, jika tidak Inertia diam-diam fallback ke CSR.
- **`Mail::send()` di ketiga route form (`/kontak`, `/minta-penawaran`, `/kerjasama`) berjalan sinkron** — Mailable tidak implement `ShouldQueue`, jadi request user menunggu sampai email selesai dikirim (atau gagal) sebelum dapat response. Aman selama `MAIL_MAILER=log` (dev), tapi begitu SMTP production dipasang, latency/SMTP outage akan langsung terasa oleh user. Jadikan queued job (`implements ShouldQueue`) + `QUEUE_CONNECTION` yang jalan (bukan `sync`) sebelum go-live.
- `MAIL_MAILER=log` di `.env` saat ini — email form tidak benar-benar terkirim ke `MAIL_CONTACT_RECIPIENT`, hanya masuk ke `storage/logs/laravel.log`. Perlu SMTP/API driver (Mailgun, SES, dsb.) sebelum production.

## Rekomendasi Evolusi Selanjutnya

- putuskan nasib `Perizinan Dasar` (bangun ulang route + `Index.vue`/`Show.vue` lalu masukkan ke sitemap, atau hapus `foundingProductsPerizinanDasar.json` kalau tidak dilanjutkan) dan bersihkan file orphan `Kbli.vue`/`About.vue`
- sinkronkan locale pilihan user (client) ke server (mis. cookie yang dibaca sebelum `HandleInertiaRequests`) supaya SEO title/description ikut berubah per bahasa
- pisahkan `/penawaran-khusus` duplikat menjadi halaman `/tentang-kami` yang sebenarnya
- pindahkan data produk (`public/data/*.json`) ke database/CMS agar lebih mudah diubah tanpa deploy
- pecah `routes/web.php` (>3300 baris) ke controller/service layer per domain
- ubah 3 `Mailable` form jadi queued (`ShouldQueue`) + konfigurasi SMTP production, supaya submit form tidak blocking dan email benar-benar terkirim
- tambahkan supervisor/systemd unit untuk menjalankan `php artisan inertia:start-ssr` di production supaya SSR yang sudah enabled-by-default benar-benar terpakai
