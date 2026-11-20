# Keputusan Desain & Resolusi Kesenjangan (Design Decisions & Known Gaps)
**Dokumen:** `docs/05-design-decisions.md`  
**Proyek:** Revamp Website PT. Indogreen Technology And Management  
**Fase:** Fase 1 — Fondasi Monorepo & Dokumen Arsitektur  
**Status:** Ditetapkan sebagai Catatan Resmi Penyesuaian Teknis `docs/DESIGN.md`

---

## 1. Pendahuluan

Dokumen `docs/DESIGN.md` adalah sumber kebenaran tunggal (*single source of truth*) untuk seluruh sistem visual PT. Indogreen Technology And Management. Dokumen `docs/05-design-decisions.md` ini mencatat secara formal setiap deviasi teknis yang disetujui, penyesuaian fungsional, dan resolusi atas kesenjangan desain (*Known Gaps*) yang belum tercakup dalam dokumen desain asli.

---

## 2. Deviasi dari `DESIGN.md` & Justifikasi Teknis

### 2.1 Ikonografi: Adopsi Lucide Icons & Font Awesome 6 Free
- **Ketentuan `DESIGN.md` (Baris 368):**
  > "Font Awesome 6 Pro and Font Awesome 6 Sharp are used exclusively for iconography..."
- **Deviasi yang Diputuskan:**
  Menggunakan **Lucide Icons** sebagai pustaka ikon visual utama, dengan opsi cadangan **Font Awesome 6 Free**.
- **Alasan Teknis & Bisnis:**
  1. **Ketiadaan Lisensi Berbayar:** Font Awesome 6 Pro / Sharp memerlukan lisensi komersial dan token otentikasi npm privat. Repositori ini tidak memuat lisensi komersial pihak ketiga.
  2. **Performa & Tree-Shaking SvelteKit:** Pustaka Lucide Icons berbasis komponen SVG modular yang secara native mendukung *tree-shaking* di SvelteKit. Hanya ikon yang benar-benar digunakan yang disertakan ke dalam bundle produksi (ukuran aset < 5 KB vs webfont Font Awesome > 150 KB).
  3. **Konsistensi Visual:** Ikon Lucide memiliki ketebalan goresan (*stroke width*) 2px dan sudut geometris presisi yang selaras dengan filosofi sudut 2px (`rounded.sm`) `DESIGN.md`.

---

### 2.2 Penyesuaian Komponen Utility Bar
- **Ketentuan `DESIGN.md` (Baris 542–545):**
  > "Right-aligned cluster: locale selector / 'Login' / 'Account'. Always present at the very top of the page."
- **Deviasi yang Diputuskan:**
  Menghilangkan tautan konsumen *"Login"* dan *"Account"* dari bilah utilitas publik.
- **Alasan Teknis & Fungsional:**
  1. **Model Bisnis B2B:** Website PT. Indogreen adalah portal informasi rekayasa B2B, katalog pengadaan, dan konsultasi tender. Perusahaan tidak mengoperasikan portal keanggotaan retail pengguna (*consumer login portal*).
  2. **Pemisahan Jalur Administrasi:** Panel CMS staf internal beroperasi di `/admin` melalui Filament CMS yang terisolasi dengan pengamanan ganda, bukan tautan login akun konsumen umum.
  3. **Optimalisasi Ruang Navigasi:** Sisi kanan bilah utilitas dialokasikan untuk informasi operasional bernilai tinggi bagi calon mitra:
     - Jam Layanan: `Senin - Jumat 08.30 - 17.00 WIB`
     - Hotline Cepat WhatsApp: Direct link ke nomor resmi
     - Email Dukungan Teknis: `support@indogreen.id`

---

### 2.3 Standarisasi Indikator Aksesibilitas Fokus (Focus States)
- **Ketentuan `DESIGN.md` (Baris 496):**
  > "Focused: same surface, border becomes 2px solid {colors.primary} — the green border is the only focus signal in the system."
- **Deviasi yang Diputuskan:**
  Menerapkan cincin fokus aksesibilitas `outline: 2px solid #00b100; outline-offset: 2px;` secara ketat pada pseudoclass `:focus-visible` (keyboard focus), sementara pada keadaan diam (*resting/idle state*) seluruh tombol, kartu, dan input menggunakan `outline: none` untuk mencegah efek garis ganda (*double border*). Pada elemen formulir (`input`, `textarea`, `select`), transisi fokus diwujudkan melalui perubahan border dari 1px hairline (`#cccccc`) menjadi 2px solid primer (`#00b100`).
- **Alasan Teknis Aksesibilitas (WCAG 2.1 AA):**
  1. Pada beberapa peramban dan perangkat layar sentuh dengan kontras dinamis tinggi, perubahan border 1px ke 2px tanpa outline offset gagal memenuhi kriteria ambang batas persepsi kontras visual WCAG SC 2.4.7 (*Focus Visible*) dan SC 1.4.11 (*Non-text Contrast*).
  2. Menjamin pengguna keyboard navigasi tab dapat melihat cincin fokus (*focus ring*) secara jelas baik di atas kanvas hitam (`surface-dark`) maupun kanvas putih (`canvas`), tanpa merusak estetika visual saat elemen tidak aktif.

---

## 3. Resolusi Kesenjangan Desain Asli (Known Gaps Resolution)

Bagian *Known Gaps* pada `DESIGN.md` (Baris 636–642) mengidentifikasi beberapa area yang belum dispesifikasi. Berikut adalah aturan implementasi resmi untuk menutup celah tersebut:

### 3.1 Styling Komponen Formulir Lengkap (Form Field Styling)
`DESIGN.md` hanya mendokumentasikan inline search dan text input sederhana. Untuk formulir konsultasi/penawaran di `/kontak`:

1. **Textarea (`textarea-input`):**
   - Background: `{colors.canvas}` (`#ffffff`)
   - Text: `{colors.ink}` (`#000000`)
   - Border: 1px solid `{colors.hairline}` (`#cccccc`)
   - Radius: `{rounded.sm}` (2px)
   - Padding: 12px 16px
   - Min Height: 120px
   - Typography: `{typography.body-md}`
   - State Focus: Border 2px solid `{colors.primary}` (`#00b100`) + offset outline 2px.
2. **Select Dropdown (`select-input`):**
   - Menggunakan style yang identik dengan `text-input`, dilengkapi glif chevron bawah (Lucide `chevron-down`) berwarna `{colors.mute}` (`#757575`) di sisi kanan.
3. **Pesan Validasi Error Form:**
   - Teks pesan error dirender tepat di bawah field yang bermasalah menggunakan `{typography.caption-sm}` berwarna `{colors.error}` (`#e52020`).
   - Border input yang bermasalah berubah menjadi 1.5px solid `{colors.error}`.
4. **Checkbox Persetujuan Privasi:**
   - Kotak checkbox kustom 18 × 18 piksel dengan radius 2px (`rounded.sm`), border 1.5px solid `{colors.hairline-strong}`.
   - Saat dicentang (*checked*): Background `{colors.primary}` (`#00b100`) dengan ikon centang putih.

---

### 3.2 Modal / Dialog Spesifikasi & Pratinjau
Jika diperlukan modal interaktif (misal: pratinjau datasheet atau konfirmasi sukses pengiriman formulir):
- **Backdrop Overlay:** `rgba(0, 0, 0, 0.75)` dengan efek pemblokir scroll pada body.
- **Wadah Modal (Modal Container):**
  - Background: `{colors.canvas}` (`#ffffff`)
  - Border: 1px solid `{colors.hairline}` (`#cccccc`)
  - Radius: `{rounded.sm}` (2px)
  - Padding: 32px
  - Ornamen: Sematkan `{component.corner-square}` 12px hijau di sudut kiri atas wadah modal.
  - Header: `{typography.heading-xl}`
  - Tombol Tutup: Glif silang (Lucide `x`) di kanan atas dengan area ketuk minimal 44 × 44 px.

---

### 3.3 Tata Letak Navigasi Mobile (Mobile Drawer Navigation)
Untuk layar di bawah breakpoint tablet (lebar < 768px):
- **Bilah Header Mobile:** Tinggi 64px, warna latar `#000000`, memuat ikon menu hamburger di kiri, logo INDOGREEN di tengah, dan tombol CTA singkat di kanan.
- **Drawer Menu:**
  - Meluncur dari sisi kanan (*slide-over drawer*) dengan lebar 85% layar (maks. 360px).
  - Background: `{colors.surface-dark}` (`#000000`).
  - Tautan Navigasi: Disajikan vertikal berurutan dengan `{typography.body-strong}` berwarna putih, tinggi baris 52px per link untuk menjamin target ketuk ramah jempol (*touch target* > 44px).
  - Tombol CTA: Tombol hijau penuh (`button-primary`) di bagian bawah drawer mengarahkan ke formulir kontak.

---

### 3.4 Pedoman Mikro-Interaksi Hover (Hover State Guidelines)
`DESIGN.md` menyatakan tidak ada dokumentasi hover state untuk mempertahankan karakter rekayasa CAD yang kaku. Namun untuk peramban desktop modern, diterapkan aturan mikro-interaksi halus:
- **`button-primary`:** Hover menurunkan sedikit saturasi opasitas ke 92% (tanpa animasi translasi / transform scale).
- **`button-outline`:** Hover memberikan warna latar tipis `{colors.surface-soft}` (`#f7f7f7`) tanpa mengubah border hijau.
- **`product-card` & `resource-card`:** Hover mengubah border hairline dari `#cccccc` menjadi border tegas `#00b100` (tanpa shadow/elevasi mengambang).
- **Tautan Teks Inline:** Hover memicu garis bawah (*underline*) aktif.

---

### 3.5 Arsitektur Footer Komprehensif, Logo Lockup & Resolusi Kontras Mode Gelap
Berdasarkan referensi visual arsitektur enterprise dan aset logo resmi perusahaan:
1. **Garis Aksen Bi-Color Atas:**
   - Garis pemisah 2px di atas footer: sepertiga kiri berwarna hijau brand `{colors.primary}` (`#00b100`), dua pertiga kanan berwarna abu-abu kuat `{colors.hairline-strong}` (`#5e5e5e`).
2. **Bab Utama Footer (`bg-surface-dark` #000000):**
   - 3 kolom tautan informasi: `Company Information`, `News and Events`, `Popular Links` dengan teks tautan warna hijau brand `{colors.primary}` yang berubah menjadi hijau muda `{colors.accent-green-pale}` saat hover.
   - Baris langganan buletin EBT dengan ikon surat hijau, headline tebal, dan tombol CTA `Subscribe` hijau (`Button` primary).
   - Ikon media sosial resmi (Facebook, Instagram, LinkedIn, X, YouTube) berukuran ketuk minimal 44 × 44 px.
3. **Sub-Footer Legal & Logo Protected Lockup:**
   - Bilah legal bawah menggunakan kanvas dengan batas atas hairline 1px.
   - Mengingat logo resmi INDOGREEN (`static/indogreen.png`) memiliki tipografi tagline putih (*"SOLAR ENERGY COMPANY"*), penayangan logo di atas kanvas terang dibungkus oleh wadah kontras terlindungi (*protected lockup badge*) berlatar `{colors.surface-dark}` (`#000000`) dengan border tipis `{colors.hairline-strong}/40` untuk mempertahankan rasio kontras tinggi tanpa mendistorsi warna identitas brand.
4. **Resolusi Kontras Mode Gelap (Dark Mode Contrast Audit):**
   - Komponen `PillTabs` pada state aktif dikonfigurasi dengan `dark:bg-on-dark dark:text-on-primary` sehingga di atas kanvas gelap aktif dirender sebagai blok putih dengan teks hitam solid (rasio kontras 21:1), mengeliminasi diskrepansi teks putih di atas latar putih (*white-on-white*).
   - Komponen `Badge` varian outline dan default dilengkapi token `dark:border-hairline-strong` dan `dark:bg-surface-elevated` agar tetap terbaca tegas di atas kanvas gelap.
   - Token `--color-stone` dan `--color-mute` pada mode gelap ditingkatkan ke `#898989` dan `#a3a3a3` untuk menjamin keterbacaan placeholder dan metadata teks melampaui standar WCAG AA (rasio kontras > 6:1).
