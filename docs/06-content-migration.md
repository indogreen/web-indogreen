# Rencana Migrasi Konten, Inventaris Aset & Peta Pengalihan 301
**Dokumen:** `docs/06-content-migration.md`  
**Proyek:** Revamp Website PT. Indogreen Technology And Management  
**Fase:** Fase 0 — Discovery & Audit  
**Status:** Panduan Eksekusi Migrasi Konten & Pengalihan URL

---

## 1. Tujuan Dokumen

Dokumen ini memetakan seluruh aset teks, media gambar, struktur data, dan tautan dari website eksisting `indogreen.id` ke dalam arsitektur baru berbasis SvelteKit dan Laravel Filament. Dokumen ini memastikan:
1. Tidak ada konten bisnis berharga yang hilang selama proses transisi.
2. Setiap URL lama yang terindeks di mesin pencari memiliki aturan pengalihan permanen (HTTP 301 Redirect) yang tepat atau keputusan penghapusan yang terdokumentasi.
3. Seluruh aset fisik, materi hukum, dan spesifikasi produk yang wajib disediakan oleh pemangku kepentingan (*stakeholders*) PT. Indogreen terdaftar secara terperinci.
4. Mencegah fabrikasi data bisnis dengan menetapkan penanda `TODO-CONTENT`.

---

## 2. Inventaris Konten Halaman Eksisting

Berikut adalah inventaris teks asli yang diekstraksi langsung dari perayapan situs:

### 2.1 Identitas & Informasi Kontak Perusahaan
- **Nama Resmi:** PT. INDOGREEN TECHNOLOGY AND MANAGEMENT
- **Tagline Lama:** *SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan*
- **Deskripsi Korporat Resmi:**
  > "PT. INDOGREEN TECHNOLOGY AND MANAGEMENT adalah perusahaan yang bergerak dalam pembangunan dan pengembangan Energi Baru dan Terbarukan (EBT) di Indonesia. Kami secara khusus menyediakan produk dan system dengan kualitas terbaik dan memberikan layanan purna jual yang berorientasi pada kepuasan konsumen."
- **Kantor Utama (Head Office):**
  - Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Bogor Barat, Kota Bogor, Jawa Barat 16113
  - Telepon Kantor: `+62-251-7541749` (atau `0251-7541749`)
  - Email Dukungan: `support@indogreen.id`
- **Kantor Perwakilan (Representative Office):**
  - Gedung Gandaria 8, Lantai 9, Gandaria City, Jalan Sultan Iskandar Muda, Kebayoran Lama, Jakarta Selatan 12240
- **Kanal Media Sosial Terdaftar:**
  - Facebook: `https://facebook.com/IndogreenMarketing`
  - Instagram: `https://www.instagram.com/indogreen_solar`
  - YouTube: `https://youtube.com/playlist?list=PLWVVoZic9QLqikef7Rcrt9PlGgA4drenx`

### 2.2 Inventaris Kategori Produk
1. **Lampu PJU (Penerangan Jalan Umum Tenaga Surya):**
   - Sub-kategori 1: *PJU Two In One (TIO)* — Seri Helios, Jupiter, Mars.
   - Sub-kategori 2: *PJU All In One (AIO)* — Seri AIO Mars.
2. **PLTS Residential:** Kategori tercantum di beranda, namun halaman detail tidak berisi konten unik pada website lama.
3. **Solar Home System (SHS):** Kategori tercantum di beranda, namun halaman detail tidak berisi konten unik pada website lama.
4. **Aksesoris Kelistrikan:** Kategori tercantum di beranda, namun halaman detail tidak berisi konten unik pada website lama.

### 2.3 Inventaris Kategori Solusi EBT
1. **PLTS On-Grid:** Sistem pembangkit surya tersinkronisasi jaringan PLN.
2. **PLTS On-Grid Hybrid:** Sistem tersinkronisasi jaringan PLN dengan cadangan baterai.
3. **PLTS Off-Grid:** Sistem surya mandiri independen tanpa jaringan PLN.
4. **PLTS Off-Grid Hybrid:** Sistem surya mandiri dikombinasikan dengan sumber pembangkit sekunder.
5. **Backup Power / UPS:** Sistem catu daya darurat bertenaga surya/baterai.

---

## 3. Inventaris Aset Media Gambar Eksisting

Berikut adalah seluruh berkas gambar yang ditemukan di server produksi `https://indogreen.id` beserta dimensi piksel, ukuran berkas, dan evaluasi teknisnya:

| No | URL Berkas Asal | Format | Dimensi (Px) | Ukuran (KB) | Penggunaan di Halaman Lama | Evaluasi Teknis & Kualitas |
|---|---|---|---|---|---|---|
| 1 | `img/indogreen/logo-indogreen-d.png` | PNG | 319 × 94 | 12.58 KB | Logo pada Navbar Atas | Resolusi raster rendah; buram di layar Retina/HiDPI. Wajib diganti SVG. |
| 2 | `img/indogreen/logo-indogreen-b.png?i=1` | PNG | 319 × 94 | 12.78 KB | Logo pada Footer | Resolusi raster rendah; latar transparan. Wajib diganti SVG. |
| 3 | `img/indogreen/bg-I-1.jpg?a=2` | JPEG | 1401 × 750 | 119.01 KB | Latar Belakang Hero Beranda | Gambar stok generik ladang panel surya. Kualitas sedang. |
| 4 | `img/master/innovate-2.png` | PNG | 128 × 128 | 51.22 KB | Ikon Ilustrasi Beranda | Ikon raster kecil dengan ukuran berkas relatif berat untuk 128px. |
| 5 | `img/produk/TIO-Hilios.jpg` | JPEG | 2480 × 3508 | 1,432.09 KB | Flyer Detail PJU TIO Helios | Flyer cetak A4 (300 DPI). Tidak ramah mobile, pemborosan bandwidth. |
| 6 | `img/produk/TIO-Jupiter.jpg` | JPEG | 2480 × 3508 | 1,633.45 KB | Flyer Detail PJU TIO Jupiter | Flyer cetak A4 (300 DPI). Teks spesifikasi terkunci di gambar. |
| 7 | `img/produk/TIO-Mars.jpg` | JPEG | 2480 × 3508 | 1,500.15 KB | Flyer Detail PJU TIO Mars | Flyer cetak A4 (300 DPI). Teks spesifikasi terkunci di gambar. |
| 8 | `img/produk/AIO-MARS.jpg` | JPEG | 2480 × 3508 | 1,537.31 KB | Flyer Detail PJU AIO Mars | Flyer cetak A4 (300 DPI). Teks spesifikasi terkunci di gambar. |
| 9 | `img/solusi/OnGrid.jpg` | JPEG | 2480 × 3508 | 1,824.79 KB | Diagram Solusi PLTS On-Grid | Flyer cetak A4 (300 DPI). Diagram sistem terkunci di gambar. |
| 10 | `img/solusi/OnGrid-Hybrid.jpg` | JPEG | 2480 × 3508 | 1,863.57 KB | Diagram PLTS On-Grid Hybrid | Flyer cetak A4 (300 DPI). Diagram sistem terkunci di gambar. |
| 11 | `img/solusi/OffGrid.jpg` | JPEG | 2480 × 3508 | 1,795.64 KB | Diagram Solusi PLTS Off-Grid | Flyer cetak A4 (300 DPI). Diagram sistem terkunci di gambar. |
| 12 | `img/solusi/OffGrid-Hybrid.jpg` | JPEG | 2480 × 3508 | 1,860.55 KB | Diagram PLTS Off-Grid Hybrid | Flyer cetak A4 (300 DPI). Diagram sistem terkunci di gambar. |
| 13 | `img/solusi/Backup Power.jpg` | JPEG | 2480 × 3508 | 1,646.50 KB | Diagram Solusi Backup Power | Flyer cetak A4 (300 DPI). Nama berkas mengandung spasi mentah. |
| 14 | `img/produk/` | — | 0 × 0 | 0 KB | Slot Dummy Produk 5+ | **URL Rusak** (direktori terbuka / 404). Dihapus di situs baru. |
| 15 | `img/solusi/` | — | 0 × 0 | 0 KB | Slot Dummy Solusi 6+ | **URL Rusak** (direktori terbuka / 404). Dihapus di situs baru. |

---

## 4. Temuan Kritis: Spesifikasi Teknis yang Terjebak dalam Gambar

### Masalah:
Sembilan (9) aset flyer di atas (`TIO-Hilios.jpg`, `TIO-Jupiter.jpg`, `TIO-Mars.jpg`, `AIO-MARS.jpg`, `OnGrid.jpg`, `OnGrid-Hybrid.jpg`, `OffGrid.jpg`, `OffGrid-Hybrid.jpg`, `Backup Power.jpg`) merupakan lembaran brosur berukuran cetak A4 (2480 × 3508 piksel).

Informasi penting yang saat ini **HANYA** berupa gambar dan tidak ada teks HTML-nya meliputi:
1. **Spesifikasi Lampu PJU:**
   - Model daya lampu (misal: 30W, 40W, 60W, 80W, 100W, 120W).
   - Efisiensi fluks cahaya (lumen per watt).
   - Tipe sel panel surya (Monocrystalline / Polycrystalline) dan kapasitasnya.
   - Tipe baterai (Lithium Ferro Phosphate / LiFePO4), kapasitas tegangan (V), dan arus (Ah).
   - Rating ingress protection (IP65 / IP66) dan sertifikasi proteksi petir/tegangan.
   - Ketinggian tiang yang disarankan dan radius sebaran cahaya.
2. **Diagram Skematik & Alur Arsitektur Solusi PLTS:**
   - Aliran arus listrik DC dari modul PV ke Inverter dan Baterai.
   - Aliran sinkronisasi AC ke Beban Rumah Tangga dan KWH Meter Ekspor-Impor PLN.
   - Komponen proteksi sistem (DC Disconnect, AC Breaker, Surge Protection Device).

### Solusi Transformasi untuk Revamp:
- **Teks HTML Semantik:** Data spesifikasi akan diekstraksi ke dalam basis data tabel `product_specifications` dan disajikan dalam tabel HTML responsif.
- **Unduhan PDF:** Lembaran brosur A4 tersebut diubah menjadi berkas dokumen PDF teknis yang dapat diunduh melalui tombol CTA resmi (`resource-card`), bukan ditampilkan sebagai gambar latar halaman yang berat.
- **Diagram Sistem Vektor:** Diagram skematik solusi akan dirender ulang dalam bentuk ilustrasi SVG atau gambar WebP berbobot ringan (< 150 KB).

---

## 5. Tabel Peta Pengalihan Permanen (301 Redirect Map)

Aturan pengalihan 301 (*Permanent Redirect*) wajib diterapkan di tingkat web server Nginx guna menjaga reputasi SEO, mencegah tautan rusak dari perayap lama, dan memastikan pengguna lama dialihkan ke halaman yang relevan:

| No | URL Asal Eksisting | Kode HTTP | Target URL Baru | Alasan Teknis & Bisnis |
|---|---|---|---|---|
| 1 | `https://indogreen.id/` | `200` | `/` | Tetap menjadi beranda utama. |
| 2 | `https://indogreen.id/produk` | `301` | `/produk` | Normalisasi trailing slash & kanonikalisasi. |
| 3 | `https://indogreen.id/produk/` | `301` | `/produk` | Normalisasi trailing slash. |
| 4 | `https://indogreen.id/produk/1` | `301` | `/produk/pju-tenaga-surya` | Pengalihan kategori PJU ke slug semantik baru. |
| 5 | `https://indogreen.id/produk/1/` | `301` | `/produk/pju-tenaga-surya` | Pengalihan kategori PJU dengan trailing slash. |
| 6 | `https://indogreen.id/produk/1/1` | `301` | `/produk/pju-tenaga-surya/pju-two-in-one-helios-series` | Detail produk PJU Helios Two-in-One. |
| 7 | `https://indogreen.id/produk/1/1/` | `301` | `/produk/pju-tenaga-surya/pju-two-in-one-helios-series` | Normalisasi trailing slash. |
| 8 | `https://indogreen.id/produk/1/2` | `301` | `/produk/pju-tenaga-surya/pju-two-in-one-mars-series` | Detail produk PJU Mars Two-in-One. |
| 9 | `https://indogreen.id/produk/1/2/` | `301` | `/produk/pju-tenaga-surya/pju-two-in-one-mars-series` | Normalisasi trailing slash. |
| 10 | `https://indogreen.id/produk/1/3` | `301` | `/produk/pju-tenaga-surya/pju-two-in-one-jupiter-series` | Detail produk PJU Jupiter Two-in-One. |
| 11 | `https://indogreen.id/produk/1/3/` | `301` | `/produk/pju-tenaga-surya/pju-two-in-one-jupiter-series` | Normalisasi trailing slash. |
| 12 | `https://indogreen.id/produk/1/4` | `301` | `/produk/pju-tenaga-surya/pju-all-in-one-mars-series` | Detail produk PJU Mars All-in-One. |
| 13 | `https://indogreen.id/produk/1/4/` | `301` | `/produk/pju-tenaga-surya/pju-all-in-one-mars-series` | Normalisasi trailing slash. |
| 14 | `https://indogreen.id/produk/1/5` s/d `/1/9` | `301` | `/produk/pju-tenaga-surya` | Slot dummy kosong dialihkan ke katalog kategori PJU. |
| 15 | `https://indogreen.id/produk/2` | `301` | `/produk/plts-residential` | Pengalihan kategori PLTS Residensial. |
| 16 | `https://indogreen.id/produk/2/*` | `301` | `/produk/plts-residential` | Sub-halaman numerik lama dialihkan ke kategori. |
| 17 | `https://indogreen.id/produk/3` | `301` | `/produk/solar-home-system` | Pengalihan kategori Solar Home System (SHS). |
| 18 | `https://indogreen.id/produk/3/*` | `301` | `/produk/solar-home-system` | Sub-halaman numerik lama dialihkan ke kategori SHS. |
| 19 | `https://indogreen.id/produk/4` | `301` | `/produk/aksesoris-kelistrikan` | Pengalihan kategori Aksesoris Kelistrikan. |
| 20 | `https://indogreen.id/produk/4/*` | `301` | `/produk/aksesoris-kelistrikan` | Sub-halaman numerik lama dialihkan ke kategori. |
| 21 | `https://indogreen.id/produk/5` s/d `/9` | `301` | `/produk` | Kategori dummy di luar batas dialihkan ke katalog produk utama. |
| 22 | `https://indogreen.id/solusi` | `301` | `/solusi` | Normalisasi & kanonikalisasi. |
| 23 | `https://indogreen.id/solusi/` | `301` | `/solusi` | Normalisasi trailing slash. |
| 24 | `https://indogreen.id/solusi/0/` | `301` | `/produk/plts-residential` | Link anomali dari beranda lama dialihkan ke PLTS Residential. |
| 25 | `https://indogreen.id/solusi/1` | `301` | `/solusi/plts-on-grid` | Detail solusi PLTS On-Grid. |
| 26 | `https://indogreen.id/solusi/1/` | `301` | `/solusi/plts-on-grid` | Normalisasi trailing slash. |
| 27 | `https://indogreen.id/solusi/1/PLTS*` | `301` | `/solusi/plts-on-grid` | Pengalihan anomali URL berspasi lama ke slug baru. |
| 28 | `https://indogreen.id/solusi/2` | `301` | `/solusi/plts-on-grid-hybrid` | Detail solusi PLTS On-Grid Hybrid. |
| 29 | `https://indogreen.id/solusi/2/` | `301` | `/solusi/plts-on-grid-hybrid` | Normalisasi trailing slash. |
| 30 | `https://indogreen.id/solusi/2/PLTS*` | `301` | `/solusi/plts-on-grid-hybrid` | Pengalihan anomali URL berspasi lama ke slug baru. |
| 31 | `https://indogreen.id/solusi/3` | `301` | `/solusi/plts-off-grid` | Detail solusi PLTS Off-Grid Mandiri. |
| 32 | `https://indogreen.id/solusi/3/` | `301` | `/solusi/plts-off-grid` | Normalisasi trailing slash. |
| 33 | `https://indogreen.id/solusi/3/PLTS*` | `301` | `/solusi/plts-off-grid` | Pengalihan anomali URL berspasi lama ke slug baru. |
| 34 | `https://indogreen.id/solusi/4` | `301` | `/solusi/plts-off-grid-hybrid` | Detail solusi PLTS Off-Grid Hybrid. |
| 35 | `https://indogreen.id/solusi/4/` | `301` | `/solusi/plts-off-grid-hybrid` | Normalisasi trailing slash. |
| 36 | `https://indogreen.id/solusi/4/PLTS*` | `301` | `/solusi/plts-off-grid-hybrid` | Pengalihan anomali URL berspasi lama ke slug baru. |
| 37 | `https://indogreen.id/solusi/5` | `301` | `/solusi/backup-power-ups` | Detail solusi Backup Power / UPS. |
| 38 | `https://indogreen.id/solusi/5/` | `301` | `/solusi/backup-power-ups` | Normalisasi trailing slash. |
| 39 | `https://indogreen.id/solusi/5/BACKUP*` | `301` | `/solusi/backup-power-ups` | Pengalihan anomali URL berspasi lama ke slug baru. |
| 40 | `https://indogreen.id/solusi/6` s/d `/9` | `301` | `/solusi` | Slot dummy kosong dialihkan ke katalog solusi utama. |
| 41 | `https://indogreen.id/about-us-one.html` | `301` | `/tentang-kami` | **Memperbaiki broken link 404 lama** menuju halaman Tentang Kami baru. |
| 42 | `https://indogreen.id/contact-one.html` | `301` | `/kontak` | **Memperbaiki broken link 404 lama** menuju halaman Kontak baru. |
| 43 | `https://indogreen.id/about` | `301` | `/tentang-kami` | Pengalihan variasi URL umum. |
| 44 | `https://indogreen.id/contact` | `301` | `/kontak` | Pengalihan variasi URL umum. |
| 45 | `https://indogreen.id/*/about-us-one.html` | `301` | `/tentang-kami` | Mengatasi tautan relatif rusak pada sub-direktori lama. |
| 46 | `https://indogreen.id/*/contact-one.html` | `301` | `/kontak` | Mengatasi tautan relatif rusak pada sub-direktori lama. |
| 47 | `https://indogreen.id/img/produk/` | `410 Gone` | *(Dihapus)* | URL aset direktori rusak dinonaktifkan permanen. |
| 48 | `https://indogreen.id/img/solusi/` | `410 Gone` | *(Dihapus)* | URL aset direktori rusak dinonaktifkan permanen. |

---

## 6. Daftar Aset & Konten yang Wajib Diminta ke Klien

Mengacu pada ketentuan desain `docs/DESIGN.md` dan kebutuhan fungsional sistem, berikut adalah daftar aset resmi yang **wajib disediakan oleh manajemen PT. Indogreen Technology And Management**:

| No | Kategori Kebutuhan | Format yang Diminta | Spesifikasi Teknis Sesuai DESIGN.md | Berkas Dummy Sementara | Status / Penanda |
|---|---|---|---|---|---|
| 1 | **Logo Resmi Perusahaan** | Vektor `.SVG` (atau `.AI` master) | Logo vektor INDOGREEN lockup: brand green `#00b100`, accent yellow `#ffff00`, dan putih, dengan kurva pill khas. Versi latar terang dan latar gelap. | `docs/dummy-assets/logo-indogreen.svg` | `TODO-CONTENT: LOGO-VECTOR` |
| 2 | **Fotografi Hero Chapter** | Gambar `.JPG` / `.PNG` (min. 2560 × 1440 px) | Foto instalasi riil proyek EBT (solar panel farm, rooftop PLTS, atau teknisi di lapangan) dengan rasio 16:9 untuk desktop dan 4:5 untuk mobile. | `docs/dummy-assets/hero-placeholder.svg` | `TODO-CONTENT: HERO-PHOTOS` |
| 3 | **Fotografi Produk Riil** | Gambar `.JPG` / `.PNG` (min. 1200 × 1200 px) | Foto produk fisik tiang/lampu PJU (Helios, Jupiter, Mars, AIO Mars) berlatar transparan atau studio bersih dengan rasio 1:1. | `docs/dummy-assets/product-pju-placeholder.svg` | `TODO-CONTENT: PRODUCT-PHOTOS` |
| 4 | **Dokumen Datasheet Resmi** | Dokumen `.PDF` (maks. 5 MB per berkas) | Brosur lembar spesifikasi teknis lengkap yang dapat diunduh klien/kontraktor untuk setiap seri produk PJU dan solusi PLTS. | `docs/dummy-assets/datasheet-sample.md` | `TODO-CONTENT: PRODUCT-DATASHEETS` |
| 5 | **Teks Profil "Tentang Kami"** | Dokumen Teks (`.DOCX` / Markdown) | Teks narasi resmi sejarah perusahaan, visi, misi, legalitas korporat (NIB/Akta), susunan manajemen/direksi, dan kredensial proyek. | `docs/dummy-assets/about-us-draft.md` | `TODO-CONTENT: ABOUT-US-COPY` |
| 6 | **Nomor WhatsApp Bisnis Resmi** | Nomor Telepon Internasional (+62...) | Nomor WhatsApp khusus layanan pelanggan / sales engineering yang aktif menerima pesan konsultasi. | `docs/dummy-assets/whatsapp-contact.md` | `TODO-CONTENT: WHATSAPP-HOTLINE` |
| 7 | **Koordinat & Peta Lokasi Kantor** | Titik Koordinat GPS / Link Google Maps | Titik koordinat presisi (Latitude, Longitude) untuk: 1) Kantor Pusat Bogor (Ruko Yasmin), 2) Kantor Perwakilan Gandaria 8 Jakarta. | `docs/dummy-assets/geo-coordinates.md` | `TODO-CONTENT: GEO-COORDINATES` |
| 8 | **Teks Kebijakan Privasi Resmi** | Dokumen Hukum (`.DOCX` / Teks) | Klausul kebijakan perlindungan data pribadi pengunjung dan perlakuan data formulir konsultasi sesuai regulasi UU PDP Indonesia. | `docs/dummy-assets/privacy-policy-draft.md` | `TODO-CONTENT: PRIVACY-POLICY` |
| 9 | **Verifikasi Data Statistik Kredensial** | Angka Terverifikasi & Bukti Proyek | Angka riil yang dapat dipertanggungjawabkan untuk komponen `callout-stat` di beranda (misal: "X+ kWp Terpasang", "Y+ Titik PJU", "Z+ Tahun Garansi"). Dilarang mengarang angka bisnis. | `docs/dummy-assets/callout-stats-draft.md` | `TODO-CONTENT: STATS-VERIFICATION` |

---

## 7. Kebijakan Placeholder Konten (`TODO-CONTENT`)

Selama fase pengembangan dan migrasi, kode sumber dan basis data **DILARANG** menggunakan data fiktif atau klaim bisnis yang tidak berdasar. Seluruh data yang belum diserahkan secara resmi oleh PT. Indogreen wajib menggunakan format penanda standar:

Contoh:
- `TODO-CONTENT: Menunggu verifikasi nomor WhatsApp resmi PT. Indogreen`
- `TODO-CONTENT: Menunggu angka resmi total kapasitas terpasang (kWp)`
- `TODO-CONTENT: Menunggu naskah legalitas Kebijakan Privasi dari konsultan hukum/manajemen`

Dengan demikian, tim pengembang dan klien memiliki batas kebenaran data yang jelas dan transparan hingga saat peluncuran publik (*go-live*).
