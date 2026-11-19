# Dokumen Audit Website PT. Indogreen Technology And Management
**Dokumen:** `docs/00-audit.md`  
**Fase:** Fase 0 — Discovery & Audit  
**Tanggal Audit:** 19 November 2026  
**Target:** Website Publik [https://indogreen.id](https://indogreen.id)  
**Status:** Selesai (Baseline untuk Revamp)

---

## 1. Ringkasan Eksekutif (Executive Summary)

Audit komprehensif terhadap website publik resmi PT. Indogreen Technology And Management (`https://indogreen.id`) dilakukan untuk menetapkan baseline teknis, mengidentifikasi kelemahan kritis, menginventarisasi konten, serta merancang arsitektur baru.

### Temuan Utama:
1. **Performa & Core Web Vitals Buruk pada Mobile:**
   - Skor Lighthouse Mobile: **Performance 42/100**, **Accessibility 61/100**, **Best Practices 73/100**, **SEO 91/100**.
   - Largest Contentful Paint (LCP) mencapai **7,7 detik** dan Total Blocking Time (TBT) **1.590 ms**, jauh melampaui batas aman Google Web Vitals (ambang batas LCP baik < 2,5 detik).
2. **Kelemahan Kritis Konten: Spesifikasi Teknis Terjebak dalam Gambar:**
   - Seluruh detail spesifikasi teknis produk PJU dan sistem PLTS disimpan hanya dalam format gambar cetak brosur/flyer berukuran A4 (2480 × 3508 piksel, rata-rata 1,4 MB – 1,8 MB per lembar).
   - Tidak ada teks HTML atau tabel spesifikasi yang dapat dibaca oleh pembaca layar (screen reader), mesin pencari (SEO), atau pengguna mobile tanpa zoom manual yang menyulitkan.
3. **Kerapuhan Arsitektur Routing & Tautan Rusak (Broken Links):**
   - Halaman footer mengarah ke berkas template statis bawaan (`about-us-one.html` dan `contact-one.html`) yang menghasilkan status **404 Not Found**.
   - Tautan navigasi internal memiliki bug URL encoding dengan spasi mentah (misalnya `https://indogreen.id/solusi/1/PLTS ON-GRID`).
   - Halaman `/produk/1` hingga `/produk/4` hanya menampilkan daftar produk PJU yang sama secara redundan tanpa menampilkan kategori PLTS Residential, SHS, maupun Aksesoris Kelistrikan.
4. **Keamanan & Infrastruktur Server Ketinggalan Zaman:**
   - Server produksi lama menjalankan **Apache** dengan **PHP 7.4.33** (versi yang telah mencapai End-of-Life / EOL resmi sejak 28 November 2022 dan tidak menerima patch keamanan).
   - Ditemukan **Mixed Content** serius: skrip jQuery dimuat melalui protokol tidak aman `http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js` di dalam halaman HTTPS.
   - Tidak memiliki header keamanan esensial (`Content-Security-Policy`, `Strict-Transport-Security`, `X-Frame-Options`, `X-Content-Type-Options`).
5. **Ketiadaan Berkas SEO Dasar:**
   - `/robots.txt` berstatus **404 Not Found**.
   - `/sitemap.xml` berstatus **404 Not Found**.
   - Seluruh halaman tidak memiliki `meta description` (`<meta name="description" content="">`).

---

## 2. Metodologi Audit & Crawl

Audit dilakukan menggunakan alat otomatis dan inspeksi langsung protokol jaringan:
- **Crawl Engine:** Skrip kustom berbasis Python 3 (`urllib`, SSL context, HTML parser) yang menelusuri seluruh tautan internal, sub-halaman produk (`/produk/x/y`), solusi (`/solusi/x`), header, dan footer.
- **Audit Core Web Vitals:** Google Lighthouse CLI v13.6.0 dijalankan dengan mesin headless Google Chrome, preset emulasi Mobile (Nexus 5X / Moto G4 network throttling).
- **Inspeksi Keamanan & Header:** `curl` dengan inspeksi header HTTP/2, OpenSSL client untuk verifikasi sertifikat SSL.
- **Inspeksi Aset Media:** Ekstraksi dimensi biner biner (binary header unpacking) dan ukuran berkas langsung dari server asal.

---

## 3. Matriks Hasil Crawl URL Publik Eksisting

Total 258 URL ditelusuri dari struktur website lama. Berikut adalah pemetaan URL utama dan kondisi riil di server:

| URL Eksisting | Status HTTP | Title Tag | Meta Description | H1 Tag | Status & Catatan |
|---|---|---|---|---|---|
| `https://indogreen.id/` | `200 OK` | `INDOGREEN - SOLAR ENERGY COMPANY` | *(Kosong)* | `Green Energy`, `Energy and Power` | Beranda aktif. Mixed content HTTP jQuery. |
| `https://indogreen.id/produk` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Katalog produk umum. H1 hilang (hanya ada H2 & H3). |
| `https://indogreen.id/produk/1` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Menampilkan daftar PJU (Helios, Jupiter, Mars, AIO Mars). |
| `https://indogreen.id/produk/1/1` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Detail PJU TIO - Helios Series (gambar flyer A4). |
| `https://indogreen.id/produk/1/2` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Detail PJU TIO - Mars Series (gambar flyer A4). |
| `https://indogreen.id/produk/1/3` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Detail PJU TIO - Jupiter Series (gambar flyer A4). |
| `https://indogreen.id/produk/1/4` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Detail PJU AIO - Mars Series (gambar flyer A4). |
| `https://indogreen.id/produk/1/5` s/d `/1/9` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Slot dummy kosong; menampilkan tautan gambar rusak `img/produk/`. |
| `https://indogreen.id/produk/2` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Duplikat persis `/produk/1` (tidak ada konten PLTS Residential). |
| `https://indogreen.id/produk/3` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Duplikat persis `/produk/1` (tidak ada konten Solar Home System). |
| `https://indogreen.id/produk/4` | `200 OK` | `PRODUK INDOGREEN` | *(Kosong)* | *(Tidak ada H1)* | Duplikat persis `/produk/1` (tidak ada konten Aksesoris Kelistrikan). |
| `https://indogreen.id/solusi` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Daftar 5 kategori solusi. Tautan internal mengandung spasi mentah. |
| `https://indogreen.id/solusi/1` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Solusi PLTS On-Grid (gambar diagram A4). |
| `https://indogreen.id/solusi/2` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Solusi PLTS On-Grid Hybrid (gambar diagram A4). |
| `https://indogreen.id/solusi/3` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Solusi PLTS Off-Grid (gambar diagram A4). Typo di H3: `PLTS OF-GRID`. |
| `https://indogreen.id/solusi/4` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Solusi PLTS Off-Grid Hybrid (gambar A4). Typo di H3: `PLTS OF-GRID HYBRID`. |
| `https://indogreen.id/solusi/5` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Solusi Backup Power / UPS (gambar diagram A4). |
| `https://indogreen.id/solusi/6` s/d `/6/9` | `200 OK` | `SOLUSI LISTRIK PERUMAHAN` | *(Kosong)* | *(Tidak ada H1)* | Slot dummy kosong; menampilkan gambar rusak `img/solusi/`. |
| `https://indogreen.id/about-us-one.html` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | **Broken link footer** ("About"). |
| `https://indogreen.id/contact-one.html` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | **Broken link footer** ("Contact Us"). |
| `https://indogreen.id/tentang-kami` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | Belum pernah dibuat pada CMS lama. |
| `https://indogreen.id/kontak` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | Belum pernah dibuat (menu Kontak di navbar hanya anchor `#` ke beranda). |
| `https://indogreen.id/kebijakan-privasi` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | Tautan footer "Privacy & Policy" hanya berupa dummy anchor `href="#"`. |
| `https://indogreen.id/robots.txt` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | Tidak ada instruksi perayap mesin pencari. |
| `https://indogreen.id/sitemap.xml` | `404 Not Found` | *(Halaman 404 Apache)* | — | `Not Found` | Tidak ada peta situs XML terdaftar. |

---

## 4. Audit Teknis Mendalam

### 4.1 Skor Lighthouse Mobile

Hasil audit Lighthouse CLI v13.6.0 terhadap halaman utama `https://indogreen.id/`:

| Kategori Audit | Skor | Status | Catatan Evaluasi |
|---|---|---|---|
| **Performance** | **42 / 100** | 🔴 Kritis | Terhambat oleh script pemblokir render, CSS tidak terpakai, dan LCP lambat. |
| **Accessibility** | **61 / 100** | 🟠 Butuh Perbaikan | Viewport melarang zoom, kontras warna rendah, link tanpa nama, landmark hilang. |
| **Best Practices** | **73 / 100** | 🟡 Cukup | Ditemukan mixed content HTTP insecure request dan error konsol browser. |
| **SEO** | **91 / 100** | 🟢 Baik | Skor tinggi karena dasar HTML, namun meta description kosong & tautan tanpa anchor teks. |

### 4.2 Core Web Vitals & Metrik Performa

- **First Contentful Paint (FCP):** `2.1 s` (Kuning — ambang batas baik ≤ 1.8 s)
- **Largest Contentful Paint (LCP):** `7.7 s` (Merah — ambang batas baik ≤ 2.5 s)
  - *Akar masalah:* Gambar latar hero `bg-I-1.jpg?a=2` dan CSS carousel besar dimuat terlambat, terhalang oleh skrip eksternal synchronous.
- **Total Blocking Time (TBT):** `1,590 ms` (Merah — ambang batas baik ≤ 200 ms)
  - *Akar masalah:* Eksekusi jQuery 1.11.1, bootstrap.min.js, slick, owl carousel, dan skrip animasi memonopoli main-thread selama 3,4 detik.
- **Speed Index:** `5.9 s` (Merah — ambang batas baik ≤ 3.4 s)
- **Cumulative Layout Shift (CLS):** `0` (Hijau — stabil secara visual saat pertama memuat).
- **Render-Blocking Resources:** `bootstrap.min.css`, `styles.css`, `energy.css`, `navigation.css`, `animate.min.css`, dan pustaka jQuery menyebabkan penundaan awal ~990 ms.

### 4.3 Keamanan HTTP & Respons Header

Hasil inspeksi header respons HTTP/2:
```http
HTTP/2 200 
x-powered-by: PHP/7.4.33
vary: Accept-Encoding
content-type: text/html; charset=UTF-8
date: Thu, 19 Nov 2026 09:33:24 GMT
server: Apache
```

**Evaluasi Keamanan:**
1. **Eksposur Versi PHP:** Header `X-Powered-By: PHP/7.4.33` aktif membocorkan versi runtime ke publik. Versi ini sudah EOL dan memiliki puluhan CVE yang diketahui publik.
2. **Ketiadaan HSTS (`Strict-Transport-Security`):** Membuka celah serangan *SSL-stripping* dan *man-in-the-middle* (MitM).
3. **Ketiadaan Proteksi Frame (`X-Frame-Options` / CSP `frame-ancestors`):** Rentan terhadap eksploitasi *Clickjacking*.
4. **Ketiadaan Proteksi MIME (`X-Content-Type-Options: nosniff`):** Berisiko eksekusi skrip berbahaya via MIME confusion.
5. **Ketiadaan Kebijakan Perujuk (`Referrer-Policy`):** Membocorkan URL lengkap ke pihak ketiga saat pengguna mengeklik tautan eksternal.

### 4.4 HTTPS, Sertifikat SSL & Mixed Content

- **Sertifikat SSL:**
  - Penerbit (CA): `Let's Encrypt` (YR1)
  - Masa Berlaku: 6 November 2026 s/d 4 Februari 2027
  - Subject Alternative Names (SAN): `indogreen.id`, `www.indogreen.id`, `webmail.indogreen.id`, `cpanel.indogreen.id` (Tipikal cPanel AutoSSL).
- **Temuan Mixed Content (Insecure Resource):**
  - Pada baris 21 berkas HTML terdapat pemanggilan skrip HTTP mentah:
    ```html
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
    ```
  - Peramban modern (Chrome, Firefox, Safari) secara otomatis memblokir skrip ini atau menampilkan peringatan "Not Secure" / gembok merah di bilah alamat karena konten aktif tak terenkripsi.

### 4.5 Mobile Viewport & Aksesibilitas

- **Konfigurasi Viewport:**
  ```html
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  ```
  - Atribut `maximum-scale=1` secara sengaja menonaktifkan fitur cubit-untuk-memperbesar (pinch-to-zoom) pada peramban ponsel pintar.
  - Ini merupakan pelanggaran panduan aksesibilitas WCAG 2.1 (Success Criterion 1.4.4 Resize Text) dan menyebabkan kegagalan audit Lighthouse Accessibility.
- **Touch Target (Area Ketuk):**
  - Tautan media sosial di bagian atas dan bawah tidak memiliki padding cukup (< 44 × 44 piksel) dan tidak memiliki label teks alternatif (`aria-label` kosong).

### 4.6 Struktur Heading & Semantik HTML

- **Halaman Beranda:** Memiliki 2 elemen `<h1>` (`Green Energy` dan `Energy and Power` di dalam slider carousel). Tidak ada H1 yang merepresentasikan entitas bisnis PT. Indogreen Technology And Management.
- **Halaman Katalog & Detail:**
  - Tidak memiliki elemen `<h1>` sama sekali (`0` tag H1 ditemukan).
  - Judul halaman menggunakan `<h2>PRODUK</h2>`, kemudian langsung melompat ke `<h3>`, dan melompat ke `<h6>` di bagian footer. Pelanggaran urutan hierarki heading (*non-sequential descending heading order*).
- **Semantik Landmark:**
  - Tidak menggunakan tag HTML5 semantik modern (`<main>`, `<header>`, `<nav>`, `<footer>`). Seluruh dokumen dibungkus menggunakan generic `<div>` (misal `<div class="main-header">`, `<div class="footer">`).

---

## 5. Ringkasan Temuan Link Rusak (Broken Links)

1. `https://indogreen.id/about-us-one.html` — Status 404 Not Found (diakses dari footer).
2. `https://indogreen.id/contact-one.html` — Status 404 Not Found (diakses dari footer).
3. `https://indogreen.id/solusi/1/PLTS ON-GRID` — URL internal dengan spasi tanpa encoding `%20`.
4. `https://indogreen.id/solusi/2/PLTS ON-GRID HYBRID` — URL internal dengan spasi.
5. `https://indogreen.id/solusi/3/PLTS OFF-GRID` — URL internal dengan spasi.
6. `https://indogreen.id/solusi/4/PLTS OFF-GRID HYBRID` — URL internal dengan spasi.
7. `https://indogreen.id/solusi/5/BACKUP POWER` — URL internal dengan spasi.
8. `https://indogreen.id/img/produk/` — Gambar rusak pada slot produk dummy ke-5 ke atas.
9. `https://indogreen.id/img/solusi/` — Gambar rusak pada slot solusi dummy ke-6 ke atas.
10. `https://indogreen.id/#` — Dummy link pada "Privacy & Policy".

---

## 6. Baseline Lingkungan Server & Kondisi Riil Saat Ini

Berdasarkan inventarisasi lingkungan pengembangan dan server yang tersedia saat ini:

### 6.1 Status Lingkungan Saat Ini:
- **Server OS:** Ubuntu 24.04 LTS (Noble Numbat).
- **PHP Runtime:** PHP 8.4 terdeteksi (versi modern, performa tinggi, JIT compiler aktif).
- **Node.js Runtime:** Node.js v24.22.1 dan NPM 12.2.2 terpasang.
- **Dependency Manager:** Composer 2.8 terpasang.
- **Web Server:** Nginx belum terpasang / belum aktif.
- **Containerization:** Docker **TIDAK** digunakan (deploy bare-metal langsung ke host OS).
- **Database Server:** Server MySQL 8 belum terpasang (hanya terdeteksi program klien MariaDB 10.4 di sistem).
- **Lingkungan Jaringan:** Hanya lingkungan lokal (Local-only environment). Belum ada domain staging publik, belum ada sertifikat SSL publik, dan belum ada CAPTCHA.

### 6.2 Keputusan Arsitektur yang Telah Ditetapkan (Locked Decisions):
1. **Backend Framework:** Laravel 11/12 dengan mode API JSON murni + CMS Admin Filament v3.
2. **Hak Akses & Otorisasi:** Menggunakan paket resmi `spatie/laravel-permission` (Role-Based Access Control).
3. **Database Engine:** MySQL 8.0 (InnoDB, utf8mb4, collation `utf8mb4_unicode_ci`).
4. **Frontend Architecture:** SvelteKit (Svelte 5 Runes) + Tailwind CSS v3/v4 dengan Server-Side Rendering (SSR) untuk performa dan SEO maksimal.
5. **Ikonografi:** Pustaka ikon Lucide Icons atau Font Awesome 6 Free (menghindari ketergantungan lisensi komersial Pro, kecuali lisensi resmi disediakan perusahaan).
6. **Strategi Deployment:** Bare-metal Ubuntu 24.04 tanpa Docker:
   - Web server Nginx sebagai reverse proxy.
   - PHP-FPM 8.4 untuk melayani permintaan backend Laravel.
   - Node.js 24 dikelola sebagai service `systemd` untuk melayani frontend SvelteKit SSR.
   - Laravel Queue Worker dikelola langsung melalui unit service `systemd` (tanpa Supervisor).
7. **Desain & UI Tokens:** Mengacu mutlak pada `docs/DESIGN.md` (Green `#00b100`, Inter typography, radius 2px `rounded.sm`, corner square motif).

---

## 7. Daftar Keputusan Terbuka (Open Decisions), Rekomendasi, & Status

| No | Keputusan Terbuka | Pilihan Opsi | Rekomendasi Teknis | Status | Alasan & Dampak |
|---|---|---|---|---|---|
| **D-01** | Database Engine Host | Opsi A: Pasang MySQL Server 8.0 murni.<br>Opsi B: Gunakan MariaDB 10.4 yang sudah ada kliennya. | **Opsi A (MySQL 8.0)** | Menunggu Eksekusi Fase 1 | Stack resmi mensyaratkan MySQL 8. Filament dan Laravel 11 memiliki optimasi native untuk MySQL 8 (JSON expressions, generated columns). MariaDB 10.4 sudah EOL sejak Juni 2024. |
| **D-02** | Web Server & Reverse Proxy Setup | Opsi A: Nginx upstream ke PHP-FPM + Node SSR.<br>Opsi B: Caddy dengan auto-HTTPS. | **Opsi A (Nginx)** | Ditetapkan | Sesuai arsitektur non-Docker yang diminta. Konfigurasi Nginx terbukti stabil untuk menangani static asset caching dan reverse proxy ganda ke port SvelteKit dan socket PHP-FPM. |
| **D-03** | Penanganan Spam Formulir Kontak | Opsi A: Honeypot field + rate limiting Laravel.<br>Opsi B: Google reCAPTCHA / Cloudflare Turnstile. | **Opsi A (Honeypot + Throttling)** | Ditetapkan untuk fase lokal | Batasan fase lokal: *tanpa CAPTCHA*. Implementasi Spatie Honeypot atau input tersembunyi + rate limit 5 req/menit per IP aman dan ramah privasi. Opsi B dapat dievaluasi saat go-live jika spam tinggi. |
| **D-04** | Penyimpanan Berkas & Media (Datasheet/Gambar) | Opsi A: Penyimpanan lokal (`storage/app/public`) dengan symlink.<br>Opsi B: Cloud Object Storage (S3 / R2 / Wasabi). | **Opsi A (Lokal Disk)** untuk tahap awal | Rekomendasi Aset Lokal | Jumlah aset media PT. Indogreen tergolong ringkas (< 500 MB). Disk NVMe lokal server Ubuntu 24.04 lebih dari cukup dan menghilangkan biaya pihak ketiga. |
| **D-05** | Layanan Pengiriman Email (SMTP Relay) | Opsi A: SMTP Server cPanel hosting lama.<br>Opsi B: Layanan Transaksional Khusus (Resend, Mailgun, Brevo). | **Opsi B (Layanan Transaksional)** saat go-live | Terbuka (Memerlukan Input Perusahaan) | Menggunakan cPanel hosting bersama untuk mengirim email kontak berisiko tinggi masuk ke folder spam. Diperlukan akun relay transaksional profesional. |
| **D-06** | Integrasi WhatsApp Contact | Opsi A: Direct deep-link API WhatsApp (`https://wa.me/62...`).<br>Opsi B: Widget chat floating interaktif. | **Opsi A (Direct WhatsApp URL)** | Rekomendasi Desain | Sesuai prinsip `DESIGN.md`: tanpa widget mengambang yang menutupi konten, gunakan CTA tombol resmi di header dan halaman kontak dengan pesan pra-isi (*pre-filled message*). |

---

## 8. Kesimpulan & Langkah Menuju Fase 1

Fase 0 telah berhasil memetakan seluruh kelemahan, aset riil, dan arsitektur website lama PT. Indogreen Technology And Management. Data audit ini menjadi dasar penyusunan Arsitektur Informasi Baru (`docs/01-ia-sitemap.md`) dan Rencana Migrasi Konten (`docs/06-content-migration.md`). Seluruh prasyarat telah terpenuhi untuk melangkah ke tahap implementasi basis data dan backend.
