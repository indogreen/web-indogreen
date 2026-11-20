# Arsitektur Sistem & Infrastruktur
**Dokumen:** `docs/02-architecture.md`  
**Proyek:** Revamp Website PT. Indogreen Technology And Management  
**Fase:** Fase 1 — Fondasi Monorepo & Dokumen Arsitektur  
**Status:** Ditetapkan sebagai Pedoman Arsitektur Teknis

---

## 1. Gambaran Umum Arsitektur

Website resmi PT. Indogreen Technology And Management dibangun menggunakan pendekatan **Monorepo Decoupled Architecture**:
- **Frontend:** SvelteKit (Svelte 5 Runes) dengan Server-Side Rendering (SSR) untuk menjamin kecepatan muat, kepatuhan Core Web Vitals, dan visibilitas SEO maksimal.
- **Backend:** Laravel 11/12 yang beroperasi murni sebagai penyedia REST API JSON untuk publik dan panel CMS administratif berbasis Filament v3.
- **Infrastruktur:** Sistem berjalan langsung (*bare-metal*) di atas sistem operasi **Ubuntu 24.04 LTS TANPA DOCKER**, dimediasi oleh Nginx sebagai web server utama dan reverse proxy.

---

## 2. Diagram Alir Permintaan (Request Lifecycle)

```mermaid
flowchart TD
    Client["Browser / Client"] -->|HTTPS :443| Nginx["Nginx Reverse Proxy\n(Port 80/443, SSL, Cache, Rate Limit)"]
    
    subgraph Frontend_Layer ["Frontend Layer (SvelteKit SSR)"]
        Nginx -->|Proxy Pass :3000\nRoute: /, /produk/*, /solusi/*| NodeService["Node.js 24 Service\n(systemd: indogreen-frontend.service)"]
        NodeService -->|Server-Side Rendered HTML + CSS| Nginx
    end

    subgraph Backend_Layer ["Backend Layer (Laravel 11/12)"]
        NodeService -->|Internal Fetch API\nJSON Request :8000 / Socket| FPM["PHP-FPM 8.4\n(Laravel Core / API Controller)"]
        Nginx -->|Direct Admin / API\nRoute: /admin/*, /api/*| FPM
        FPM -->|Filament Admin Panel UI| Nginx
    end

    subgraph Persistence_Layer ["Data & Storage Layer"]
        FPM -->|TCP :3306| MySQL["MySQL Server 8.0\n(InnoDB, utf8mb4)"]
        FPM -->|Storage Symlink\n/public/storage| LocalDisk["Local NVMe Storage\n(Aset Media, Datasheet PDF)"]
    end

    subgraph Background_Workers ["Background Services (systemd)"]
        QueueWorker["Laravel Queue Worker\n(systemd: indogreen-queue.service)"] -->|Process Email/Tasks| FPM
    end
```

---

## 3. Pembagian Tanggung Jawab (Separation of Concerns)

| Komponen | Peran & Tanggung Jawab Utama | Batasan & Aturan |
|---|---|---|
| **Nginx Web Server** | - Terminasi SSL/TLS (HTTPS) & HSTS.<br>- Reverse proxy ke SvelteKit Node service (`127.0.0.1:3000`).<br>- Reverse proxy / FastCGI pass ke Laravel PHP-FPM (`unix:/run/php/php8.4-fpm.sock`).<br>- Pengiriman langsung aset statis publik (`/static`, `/storage`).<br>- Gzip/Brotli compression & HTTP Security Headers. | Dilarang memproses logika bisnis; hanya menangani lalu lintas jaringan dan routing gateway. |
| **SvelteKit (Frontend)** | - Server-Side Rendering (SSR) halaman publik untuk SEO.<br>- Implementasi sistem desain resmi `docs/DESIGN.md` (Green `#00b100`, Inter, 2px radius).<br>- Pengambilan data dari Laravel API melalui server load functions.<br>- Validasi formulir interaktif di sisi klien (kontak & konsultasi). | Tidak mengakses basis data secara langsung; seluruh data diperoleh via Laravel JSON API. |
| **Laravel API (Backend)** | - Penyedia RESTful JSON API publik terproteksi sanitasi.<br>- Panel administrasi konten via Filament CMS v3.<br>- Manajemen peran dan izin via `spatie/laravel-permission`.<br>- Pemrosesan antrean tugas latar belakang (*Queue Worker*).<br>- Validasi data tingkat akhir dan pengiriman notifikasi email. | Tidak merender Blade template untuk tampilan publik; Blade hanya digunakan untuk Filament CMS admin. |
| **MySQL 8.0** | - Penyimpanan relasional terstruktur (ACID compliant).<br>- Indeks pencarian produk, kategori, solusi, dan penawaran.<br>- Integritas data referensial (Foreign Keys & Constraints). | Hanya dapat diakses dari `127.0.0.1` (dilarang membuka akses publik remote MySQL). |

---

## 4. Strategi Caching

1. **Aset Statis (Static Asset Caching):**
   - Berkas build SvelteKit (`/_app/immutable/*`) disetel dengan header `Cache-Control: public, max-age=31536000, immutable`.
   - Berkas media publik (`/storage/*`) disetel dengan `Cache-Control: public, max-age=2592000` (30 hari).
2. **SvelteKit SSR Caching:**
   - Halaman publik yang jarang berubah (katalog produk, solusi, tentang kami) menggunakan strategi `Cache-Control: s-maxage=600, stale-while-revalidate=86400` di tingkat Nginx/Edge.
3. **Backend Query Caching:**
   - Data konfigurasi perusahaan (`company_settings`) dan daftar kategori disimpan di dalam Laravel Cache driver untuk meminimalkan beban baca basis data. Cache otomatis dibersihkan saat admin melakukan pembaruan di Filament CMS.

---

## 5. Strategi Penanganan Error (Error Handling & Resilience)

1. **Format Respons Error API Terstandarisasi:**
   Seluruh kegagalan API Laravel mengembalikan struktur JSON konsisten:
   ```json
   {
     "success": false,
     "message": "Pesan deskripsi kesalahan berbahasa Indonesia",
     "error_code": "RESOURCE_NOT_FOUND",
     "errors": {}
   }
   ```
2. **Error Validasi Form (HTTP 422 Unprocessable Entity):**
   ```json
   {
     "success": false,
     "message": "Data yang dikirimkan tidak valid.",
     "error_code": "VALIDATION_ERROR",
     "errors": {
       "email": ["Format email tidak valid."],
       "phone_whatsapp": ["Nomor WhatsApp wajib diisi."]
     }
   }
   ```
3. **Frontend Error Boundaries:**
   - SvelteKit mengimplementasikan `+error.svelte` khusus yang mengikuti sistem desain `docs/DESIGN.md` untuk menampilkan pesan kesalahan 404 (Halaman Tidak Ditemukan) dan 500 (Gangguan Server) secara profesional tanpa mengekspos jejak teknis (*stack trace*) ke publik.

---

## 6. Keamanan & Pengerasan Sistem (Security Hardening)

1. **HTTP Security Headers di Tingkat Nginx:**
   ```nginx
   add_header X-Frame-Options "SAMEORIGIN" always;
   add_header X-Content-Type-Options "nosniff" always;
   add_header Referrer-Policy "strict-origin-when-cross-origin" always;
   add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
   add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https:; connect-src 'self';" always;
   ```
2. **Proteksi Anti-Spam Formulir Publik (Tanpa CAPTCHA):**
   - **Honeypot:** Penambahan field tersembunyi `website_url` yang tidak boleh diisi manusia. Jika terisi oleh bot otomatis, request langsung ditolak dengan kode 200 palsu atau 422.
   - **Throttling:** Pembatasan frekuensi pengiriman formulir kontak maksimal 5 request per 10 menit per IP address via middleware Laravel.
3. **Penyembunyian Jejak Server:**
   - Menonaktifkan header `server_tokens off;` di Nginx.
   - Menonaktifkan header `expose_php = Off` di berkas `php.ini`.

---

## 7. Keputusan Arsitektur & Justifikasi Teknis Paket Backend (Fase 2)

Paket-paket yang dipasang pada aplikasi backend `backend/` dibatasi hanya pada pustaka inti yang esensial:

1. **`spatie/laravel-permission` (v8.x):**
   - *Alasan:* Mengelola Role-Based Access Control (RBAC) secara deklaratif melalui tabel polimorfik relasional (`roles`, `permissions`, `model_has_roles`). Menjaga tabel `users` tetap bersih tanpa kolom role kaku dan memfasilitasi audit otorisasi yang fleksibel.
2. **`spatie/laravel-medialibrary` (v11.x):**
   - *Alasan:* Menangani asosiasi media berkas (gambar hero desktop/mobile, galeri produk, flyer diagram solusi, dan berkas datasheet PDF) ke model Eloquent. Menyediakan konversi otomatis gambar ke format WebP (thumb 200px, card 600px, hero 1920px), pembatasan MIME type ketat, serta penyimpanan atribut alt text melalui custom properties.
3. **`laravel/pint` (v1.x - Dev):**
   - *Alasan:* Penyeragaman gaya penulisan kode PHP berbasis standar Laravel/PSR-12 secara otomatis dan deterministik dalam CI quality gate.
4. **`larastan/larastan` (v3.x - Dev):**
   - *Alasan:* Ekstensi PHPStan khusus framework Laravel untuk analisis kode statis tingkat 5, mendeteksi potensi bug tipe data, query Eloquent invalid, dan null pointer sebelum kode dieksekusi.
5. **`pestphp/pest` & `pestphp/pest-plugin-laravel` (v4.x - Dev):**
   - *Alasan:* Framework pengujian modern dengan sintaks deklaratif yang ringkas dan ekspresif untuk menguji relasi model, scope, slug, factory, otorisasi RBAC, dan idempotensi seeder secara komprehensif.
6. **Trait Kustom `HasSlug` (Tanpa Paket Eksternal Tambahan):**
   - *Alasan:* Menghindari dependensi paket slug eksternal yang membengkakkan codebase. Menggunakan `Illuminate\Support\Str::slug` di dalam trait internal `app/Models/Traits/HasSlug.php`. Trait ini menjamin slug otomatis dibuat saat entitas diciptakan, menangani tabrakan nama dengan suffix unik numerik (`-1`, `-2`), dan secara tegas **TIDAK mengubah slug saat nama entitas diedit** guna menjamin stabilitas URL dan reputasi SEO.
7. **`filament/filament` (v5.x):**
   - *Alasan:* Panel administrasi TALL stack modern yang terintegrasi secara native dengan Laravel 13, Livewire v4, dan Spatie Permission. Mengizinkan staf non-teknis mengelola seluruh konten (Hero slides, Kategori, Produk dengan repeater spesifikasi, Solusi, Halaman, Kantor, Inquiry, Pengguna, Peran, dan Pengaturan Situs) dengan pengamanan hak akses `access-admin` melalui `User::canAccessPanel()`, perlindungan terhadap penghapusan admin terakhir, serta sanitasi HTML otomatis tanpa memerlukan plugin pihak ketiga tambahan.
8. **Deploy Tanpa Docker:**
   - *Alasan:* Menghilangkan overhead virtualisasi kontainer pada server Ubuntu 24.04. Seluruh proses dikelola langsung oleh init system bawaan Linux (`systemd`), menghasilkan konsumsi RAM yang jauh lebih hemat (< 1 GB) dan latensi I/O disk yang optimal.

---

## 8. Arsitektur Frontend SvelteKit, Komunikasi Data & SEO (Fase 6)

### 8.1 Server-Only API Client & Proxy Endpoint
Untuk menjamin keamanan arsitektur decoupled dan perlindungan integritas endpoint backend:
1. **Server-Only API Client (`src/lib/server/api.ts`):**
   - Beroperasi secara ketat di sisi server Node.js SvelteKit menggunakan variabel lingkungan privat `API_BASE_URL` (dari `$app/env/private`).
   - Browser pengguna **dilarang keras** memanggil REST API Laravel secara langsung guna mencegah kebocoran endpoint internal, CORS vulnerabilities, dan ekspos data mentah yang tidak difilter.
   - Mengimplementasikan HTTP client bertipe menggunakan native `fetch`, timeout terkonfigurasi (default 10 detik via `AbortController`), penanganan terstruktur untuk kode status HTTP (404, 422, 429, 500, 503, 504), dan kelas error kustom `ApiClientError`.
   - Dilengkapi data fallback `DEFAULT_SITE_SETTINGS` yang komprehensif untuk menjamin bilah navigasi dan footer tetap dapat beroperasi secara anggun (*graceful degradation*) meskipun koneksi API backend sedang terganggu atau dalam masa pemeliharaan.
2. **SvelteKit Server Inquiry Proxy (`src/routes/api/inquiries/+server.ts`):**
   - Bertindak sebagai reverse proxy yang menerima pengiriman formulir kontak dari sisi browser klien.
   - Melakukan validasi awal pada field wajib (`full_name`, `email`, `subject`, `message_content`, `consent`), memverifikasi field honeypot anti-spam (`website_url`), dan meneruskan payload ke endpoint REST API Laravel `/inquiries`.
   - Mengembalikan status HTTP dan pesan kesalahan validasi terstruktur (422) secara simetris ke antarmuka klien.

### 8.2 Server Hooks (`src/hooks.server.ts`)
Setiap request yang melewati SvelteKit ditangani melalui interceptor server-side terpadu:
1. **Security Headers Dasar:**
   - Menambahkan header `X-Frame-Options: SAMEORIGIN` (mencegah serangan clickjacking).
   - Menambahkan header `X-Content-Type-Options: nosniff` (mencegah MIME type sniffing).
   - Menambahkan header `Referrer-Policy: strict-origin-when-cross-origin`.
   - Menambahkan header `Permissions-Policy: camera=(), microphone=(), geolocation=()`.
2. **Penanganan Error Terpusat (`handleError`):**
   - Menangkap kesalahan rendering server yang tidak tertangani, mencatatnya ke konsol server dengan timestamp ISO, dan mengembalikan pesan kesalahan berbahasa Indonesia yang aman tanpa membocorkan rincian teknis (*stack trace*) ke klien publik.
3. **Kerangka 301 Redirect Map:**
   - Menyediakan kerangka pengalihan URL permanen berbasis tabel lookup untuk memigrasikan URL lama website WordPress ke rute baru monorepo (diisi secara lengkap pada Fase 9).
4. **Header Caching Aset Statis:**
   - Menyetel `Cache-Control: public, max-age=31536000, immutable` untuk seluruh aset yang disajikan dari path `/_app/immutable/`.

### 8.3 Kerangka Layout & Hirarki Navigasi Global
1. **`+layout.server.ts`:**
   - Memuat data konfigurasi situs (`SiteSettings`) melalui `api.getSettings(fetch)` saat inisialisasi layout dasar sehingga informasi kontak, alamat kantor, dan media sosial selalu tersedia di seluruh halaman.
2. **Komponen Navigasi:**
   - **`UtilityBar` (32px):** Berlatar hitam (`surface-dark`) di puncak viewport, menampilkan telepon, email, jam operasional, dan ikon media sosial.
   - **`PrimaryNav` (64px):** Berlatar hitam (`surface-dark`), memuat logo resmi INDOGREEN di sisi kiri, menu navigasi utama (Beranda, Produk, Solusi, Tentang Kami, Kontak) dengan indikator aktif (`aria-current="page"`), tombol pencarian modal, tombol hamburger mobile, dan satu tombol CTA hijau solid tunggal (*Single Green CTA Rule*) "Hubungi Kami". Memiliki pendeteksi scroll yang menerapkan bayangan sticky token `0 0 5px 0 rgba(0,0,0,0.3)` secara halus.
   - **`MobileDrawer`:** Laci navigasi geser dari kanan untuk layar ponsel (< 768px), dilengkapi focus trap keyboard, pendengar tombol `Escape`, atribut aksesibilitas `aria-expanded`, serta penguncian gulir body (*scroll lock*).
   - **`Breadcrumb` (48px):** Navigasi remah roti berlatar abu-abu muda (`surface-soft`) dengan teks uppercase `caption-md` dan pemisah chevron mute.
   - **`SubNav` (56px):** Navigasi tingkat kedua berlatar `surface-soft`, mendukung scroll horizontal pada tablet dan dropdown select natif pada perangkat mobile.
   - **`Footer`:** Footer enterprise berlatar hitam (`surface-dark`) dengan garis pembagi bi-color atas (hijau brand dan abu-abu kuat), 4 kolom navigasi (Produk, Solusi, Perusahaan, Kontak) yang beralih menjadi akordeon keyboard-accessible pada layar mobile, formulir buletin EBT, dan sub-footer legal dengan tahun otomatis dan nama resmi `PT. Indogreen Technology And Management`.
3. **Komponen SEO & Metadata (`SeoHead.svelte`):**
   - Menghasilkan template title konsisten `%s | INDOGREEN`, meta deskripsi, URL kanonikal, OpenGraph (og:title, og:description, og:image, og:url, og:type), kartu Twitter (summary_large_image), instruksi crawler robots, dan slot skrip Schema.org JSON-LD, dengan fallback otomatis ke metadata SEO yang dikembalikan oleh API Laravel.

---

## 9. Panduan Pengembangan Lokal (Local Development)

### 8.1 Prasyarat Perangkat Lunak
- **Sistem Operasi:** macOS / Ubuntu 24.04 Linux
- **PHP:** `^8.4` (Ekstensi wajib: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `xml`, `zip`, `intl`)
- **Composer:** `^2.8`
- **Node.js:** `^24.0.0` (LTS) & NPM `^10.0.0` (Gunakan `.nvmrc`)
- **Basis Data:** MySQL Server 8.0 terpasang lokal (*native*)

> [!WARNING]
> **Status Mesin Host Saat Ini:**  
> Pada mesin host saat ini, server MySQL 8.0 belum terpasang (hanya terdeteksi program klien MariaDB 10.4). Sebelum menjalankan backend, pasang server MySQL 8.0 native terlebih dahulu:
> - **Ubuntu 24.04:** `sudo apt update && sudo apt install mysql-server -y`
> - **macOS (Homebrew):** `brew install mysql && brew services start mysql`

### 8.2 Konfigurasi Database Lokal
Jalankan perintah SQL berikut di terminal MySQL (`mysql -u root -p`):
```sql
CREATE DATABASE indogreen_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'indogreen_user'@'localhost' IDENTIFIED BY 'indogreen_secret123';
GRANT ALL PRIVILEGES ON indogreen_db.* TO 'indogreen_user'@'localhost';
FLUSH PRIVILEGES;
```

### 8.3 Alokasi Port Lokal
- **Frontend SvelteKit (Dev SSR):** `http://localhost:3000`
- **Backend Laravel API & Filament:** `http://localhost:8000`
- **MySQL Database Server:** `127.0.0.1:3306`
- **Mailpit Web UI (Opsional Mail Testing):** `http://localhost:8025` (SMTP port `1025`)

### 8.4 Penanganan Pengiriman Email di Lokal
Untuk pengujian formulir kontak di lingkungan lokal tanpa koneksi SMTP publik:
- **Pilihan 1 (Default):** Setel `MAIL_MAILER=log` pada `backend/.env`. Seluruh isi email notifikasi akan dicatat ke berkas log `backend/storage/logs/laravel.log`.
- **Pilihan 2 (Mailpit Biner Standalone):** Unduh biner Mailpit tanpa Docker:
  ```bash
  # Menjalankan mailpit lokal
  mailpit
  ```
  Lalu setel `MAIL_MAILER=smtp`, `MAIL_HOST=127.0.0.1`, `MAIL_PORT=1025` pada `backend/.env`.

---

## 10. Ringkasan Deployment Server (Merujuk ke Fase 12)

Pada tahap produksi di server Ubuntu 24.04:
1. **Nginx:** Dikonfigurasi dengan file `deploy/nginx/indogreen.conf` yang mengarahkan root domain ke socket PHP-FPM dan proxy ke port Node 3000.
2. **Node.js SvelteKit:** Dikelola oleh unit systemd `deploy/systemd/indogreen-frontend.service`.
3. **Queue Worker Laravel:** Dikelola oleh unit systemd `deploy/systemd/indogreen-queue.service`.
4. **Skrip Otomasi Deployment:** Berkas `deploy/deploy.sh` akan mengeksekusi git pull, composer install, artisan migrate, npm build, dan reload service systemd secara atomik.
