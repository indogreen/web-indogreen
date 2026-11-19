# Pedoman Agen Pengembangan Monorepo (AGENTS.md)
**Proyek:** Revamp Website Resmi PT. Indogreen Technology And Management  
**URL Produksi:** https://indogreen.id  
**Repositori:** Monorepo (`backend/`, `frontend/`, `docs/`, `deploy/`)

File ini adalah **instruksi repository-level** yang mengikat seluruh AI coding assistant (termasuk **Antigravity, Qoder, Claude Code, Codex, OpenClaw, dan Hermes**) yang bekerja di repositori ini. Baca file ini secara menyeluruh sebelum mengerjakan task apapun.

---

## 1. Blok Konteks Global Proyek

PT. Indogreen Technology And Management adalah perusahaan di bidang pembangunan dan pengembangan Energi Baru dan Terbarukan (EBT) di Indonesia, dengan fokus utama pada:
- **Lampu Penerangan Jalan Umum (PJU) Tenaga Surya:** Sistem Two-In-One (TIO) dan All-In-One (AIO) untuk seri Helios, Jupiter, dan Mars.
- **Pembangkit Listrik Tenaga Surya (PLTS) Residensial & Rooftop:** Sistem atap surya hemat daya mandiri.
- **Solar Home System (SHS):** Paket elektrifikasi surya pedesaan dan daerah terpencil / 3T.
- **Aksesoris & Komponen Kelistrikan:** Inverter, Baterai LiFePO4, Solar Charge Controller (MPPT), Mounting Bracket PV.
- **Rekayasa Sistem PLTS:** On-Grid, On-Grid Hybrid, Off-Grid, Off-Grid Hybrid, dan Backup Power / UPS.

### Batasan Arsitektur & Teknologi:
- **Backend:** Laravel 11/12 (API JSON murni + CMS Filament v3).
- **Otorisasi & Hak Akses:** Paket `spatie/laravel-permission` (Role-Based Access Control, **tanpa** kolom role di tabel `users`).
- **Basis Data:** MySQL 8.0 (InnoDB, `utf8mb4_unicode_ci`).
- **Frontend:** SvelteKit (Svelte 5 Runes) + Tailwind CSS (Server-Side Rendering / SSR).
- **Ikonografi:** Lucide Icons (utama) atau Font Awesome 6 Free (fallback). Dilarang mengasumsikan Font Awesome Pro kecuali lisensi diserahkan.
- **Infrastruktur Produksi:** Ubuntu 24.04 LTS **TANPA DOCKER** (Nginx sebagai reverse proxy, PHP-FPM 8.4, Node.js 24 sebagai systemd service, Laravel Queue Worker dikelola via systemd tanpa Supervisor).
- **Lingkungan Saat Ini:** Lingkungan lokal murni (*local-only*), tanpa domain publik, tanpa staging terpisah, tanpa CAPTCHA.
- **Sumber Kebenaran Desain:** `docs/DESIGN.md` (Design system resmi) dan logo INDOGREEN. Dilarang membuat token desain baru atau menyimpang tanpa alasan teknis yang dicatat di `docs/05-design-decisions.md`.
- **Bahasa & Konten:**
  - Teks antarmuka (UI) berbahasa Indonesia.
  - Kode program, penamaan berkas, git commit, dan identifier berbahasa Inggris.
  - **Dilarang keras mengarang data bisnis** (angka klaim, daya, kapasitas, statistik). Gunakan placeholder bertanda `TODO-CONTENT`.

---

## 2. Sumber Kebenaran (Source of Truth Hierarchy)

Sebelum melakukan perubahan, pahami hierarki kepercayaan berikut:
1. **Source Code Aktual:** Kebenaran utama untuk perilaku (*behavior*) aplikasi saat ini.
2. **`docs/DESIGN.md`:** Kebenaran mutlak (*frozen specification*) untuk semua keputusan visual, token warna, tipografi, dan geometri antarmuka.
3. **`docs/05-design-decisions.md`:** Catatan resmi deviasi teknis desain yang disetujui (Lucide icons, utility bar B2B, focus ring WCAG, form/modal gaps).
4. **Dokumentasi Arsitektur di `docs/`:**
   - `docs/02-architecture.md`: Alur sistem, komunikasi Nginx-Node-PHP-MySQL, dan panduan lokal setup.
   - `docs/03-data-model.md`: Skema tabel MySQL, relasi, indeks, dan aturan slug unik.
   - `docs/04-api-contract.md`: Kontrak REST API v1, parameter, struktur respons, dan format error 422.
   - `docs/06-content-migration.md`: Peta pengalihan 301, inventaris konten/media, dan tautan aset dummy.
   - `docs/01-ia-sitemap.md` & `docs/00-audit.md`: Arsitektur informasi dan data audit awal.
5. **`.env.example`:** Hanya memuat nama variabel dan placeholder aman. **Dilarang mengekspos nilai rahasia (*secret*).**

> **Aturan Diskrepansi:** Jika dokumentasi dan kode sumber berbeda, **percaya kode sumber dulu**, lalu perbarui dokumentasi yang relevan dalam task yang sama.

---

## 3. Struktur Repositori Monorepo

```text
web-indogreen/
├── .agents/
│   └── skills/             # Pustaka skill universal (laravel, vite, security, git, tdd)
├── .github/
│   └── workflows/          # Konfigurasi pipeline CI (GitHub Actions ci.yml)
├── backend/                # Aplikasi Laravel (API JSON + Filament CMS)
│   ├── .env.example        # Template konfigurasi environment backend
│   └── .gitkeep
├── frontend/               # Aplikasi SvelteKit (Svelte 5, Tailwind CSS, SSR)
│   ├── .env.example        # Template konfigurasi environment frontend
│   └── .gitkeep
├── docs/                   # Dokumentasi resmi arsitektur, audit, dan IA
│   ├── dummy-assets/       # 9 Aset placeholder sementara bertanda TODO-CONTENT
│   ├── 00-audit.md         # Hasil audit website lama & Core Web Vitals
│   ├── 01-ia-sitemap.md    # Arsitektur informasi, sitemap semantik, ERD
│   ├── 02-architecture.md  # Arsitektur sistem, aliran data, Nginx & deployment
│   ├── 03-data-model.md    # Desain skema basis data MySQL & relasi
│   ├── 04-api-contract.md  # Spesifikasi kontrak API REST JSON
│   ├── 05-design-decisions.md # Keputusan desain, deviasi, & resolusi gap
│   ├── 06-content-migration.md# Peta redirect 301 & inventaris aset
│   ├── CHANGELOG-phases.md # Log kemajuan pekerjaan per fase
│   └── DESIGN.md           # Sumber kebenaran sistem desain resmi
├── deploy/                 # Konfigurasi Nginx, unit systemd, skrip deployment
│   └── .gitkeep
├── .editorconfig           # Standarisasi format indentasi dan berkas
├── .gitignore              # Pengecualian berkas git monorepo
├── .nvmrc                  # Pin versi Node.js (v24)
├── AGENTS.md               # Pedoman operasi utama seluruh AI agent
├── CLAUDE.md               # Pointer ke AGENTS.md
└── DESIGN.md               # Salinan root sistem desain resmi
```

---

## 4. Alur Kerja Wajib (Required Workflow)

### 4.1 Sebelum Mengubah Berkas
1. Jalankan `git status --short` untuk memetakan kondisi repositori.
2. Baca berkas kode yang relevan — dilarang menebak struktur atau perilaku kode.
3. Baca dokumentasi terkait di `docs/` menggunakan tabel **Documentation Contract** (Seksi 7).
4. Dilarang menebak skema basis data — periksa `database/migrations/` dan `docs/03-data-model.md`.
5. Jika task menyentuh UI/tampilan: baca `docs/DESIGN.md` dan seksi **Design Contract** (Seksi 6).

### 4.2 Saat Mengubah Berkas
- Ikuti pola kode dan konvensi arsitektur yang sudah ada di repositori.
- Jangan ubah rute (*routes*) yang sudah ada kecuali diminta eksplisit oleh user.
- Jangan menambah *dependency* baru tanpa alasan kuat dan persetujuan user.
- Jangan hapus kode atau berkas yang tidak terkait dengan task.
- Jangan mengubah migration lama yang sudah berjalan — buat migration baru jika perlu modifikasi skema.
- Jangan membuat commit Git secara otomatis kecuali user meminta secara eksplisit.
- Pastikan seluruh placeholder data bisnis menggunakan penanda `TODO-CONTENT`.

### 4.3 Sebelum Memberikan Tanggapan Akhir (*Final Response*)
1. Periksa tabel **Documentation Contract** — pastikan file di `docs/` yang terdampak telah diperbarui.
2. Jalankan validasi pengujian (lint, type-check, test) yang relevan.
3. Pisahkan antara kegagalan dari perubahan baru vs *debt* lama yang sudah ada.
4. Siapkan **Suggested Conventional Commit Message** lengkap dengan subjek dan body teknis dalam Bahasa Inggris.

---

## 5. Standar Penulisan Kode (Coding Standards)

### 5.1 Backend (Laravel 11/12)
- **Service Layer Pattern:** Seluruh logika bisnis (*business logic*) ditempatkan di `app/Services/`, bukan di controller. Controller hanya bertanggung jawab menerima request dan mengembalikan response.
- **Form Request Validation:** Seluruh validasi input menggunakan Form Request terpisah (`app/Http/Requests/`).
- **API Resource:** Seluruh respons JSON ditransformasi menggunakan API Resource (`app/Http/Resources/`) untuk menjamin amplop data terstandarisasi.
- **Model Eloquent:** Gunakan `$fillable` atau atribut mass-assignment eksplisit, definisikan relasi dengan tipe kembalian (*return type*) yang jelas.
- **Database Transactions:** Gunakan `DB::transaction()` untuk setiap alur kerja yang melibatkan penulisan ke lebih dari satu tabel.
- **Role-Based Access Control:** Gunakan `spatie/laravel-permission` melalui middleware atau authorize policy. **Dilarang menambahkan kolom role di tabel `users`**.
- **Anti-Spam & Keamanan:** Terapkan field honeypot tersembunyi dan *rate limiting* (throttling) pada endpoint publik formulir inquiry.

### 5.2 Frontend (SvelteKit 5)
- **Svelte 5 Runes:** Gunakan sintaks runes modern: `$state`, `$derived`, `$effect`, `$props`.
- **Modular API / Service Layer:** Panggilan API diisolasi pada `src/lib/services/` atau `src/lib/api/` — dilarang melakukan raw fetch langsung di dalam komponen UI.
- **TypeScript Strictness:** Seluruh tipe data didefinisikan pada `src/lib/types/`. Hindari penggunaan `any`.
- **Bahasa & Lokalisasi:** Seluruh teks UI yang dilihat pengguna wajib menggunakan **Bahasa Indonesia**. Format mata uang menggunakan **Rupiah (Rp)**, format tanggal bahasa Indonesia.
- **Kepatuhan Desain:** Seluruh komponen wajib mengonsumsi token warna, tipografi, dan spasi dari Tailwind yang disinkronkan dengan `docs/DESIGN.md`.

---

## 6. Kontrak Desain Antarmuka (Design Contract & UI Checklist)

**WAJIB dipatuhi sebelum menyentuh berkas UI apapun.**  
Sistem desain mengacu mutlak pada `docs/DESIGN.md` dan `docs/05-design-decisions.md`:

### 6.1 Token Kunci Desain:
- **Warna Brand:** INDOGREEN Green (`#00b100`) untuk CTA utama, active tab/state, dan motif corner square. Teks di atas warna ini wajib warna hitam (`#000000`).
- **Aksen Sekunder:** Accent Yellow (`#ffff00`) hanya sebagai highlight teks/eyebrow pada kanvas gelap (`surface-dark`). Dilarang digunakan sebagai background tombol CTA.
- **Kanvas Permukaan:** Dua mode bergantian — Kanvas Hitam (`#000000`) untuk hero/footer/primary nav; Kanvas Putih (`#ffffff`) untuk badan halaman.
- **Geometri Sudut (Border Radius):** **Wajib `rounded.sm` (2px)** untuk seluruh tombol, kartu, input, dan badge. **Dilarang memakai `rounded-full` (pill) atau `rounded-xl`** pada tombol/kartu (kecuali logo/avatar lingkaran).
- **Tipografi:** Font **Inter** (Regular 400 dan Bold 700). Tidak ada varian serif, monospace, atau display font lainnya.
- **Elevasi & Shadow:** **FLAT.** Dilarang menambahkan soft drop shadow pada kartu/permukaan. Pemisah visual mengandalkan garis hairline 1px solid (`#cccccc` pada canvas, `#5e5e5e` pada dark surface).
- **Motif Khas:** Sematkan `{component.corner-square}` (kotak solid hijau 12 × 12 px) di salah satu sudut kartu sumber daya atau produk.

### 6.2 Checklist Sebelum Submit Perubahan UI:
- [ ] Tombol CTA utama menggunakan hijau `#00b100`, teks hitam, dan radius 2px (`rounded.sm`).
- [ ] Tidak ada drop shadow berlebih pada kartu (default state: flat dengan border hairline).
- [ ] Menggunakan font Inter tanpa font pengganti yang tidak sah.
- [ ] Warna menggunakan token CSS/Tailwind yang valid, bukan sembarang nilai heksadesimal baru.
- [ ] Indikator fokus aksesibilitas (*focus ring*) 2px outline offset `#00b100` berfungsi pada navigasi keyboard.
- [ ] Responsif teruji: breakpoint mobile `< 640px` (drawer menu, single column) dan desktop `> 1024px`.
- [ ] Seluruh target ketuk (*touch targets*) berukuran minimal 44 × 44 piksel.
- [ ] Seluruh angka statistik atau klaim bisnis yang belum terverifikasi bertanda `TODO-CONTENT`.
- [ ] Teks antarmuka sepenuhnya berbahasa Indonesia yang baik dan profesional.

---

## 7. Kontrak Pembaruan Dokumentasi (Documentation Contract)

Setiap task **wajib melewati dokumentasi gate** ini. Jika area berikut mengalami perubahan, dokumen terkait wajib diperiksa dan diperbarui dalam task yang sama:

| Area Perubahan | Dokumen yang Wajib Dicek & Diperbarui |
|---|---|
| API endpoint baru, parameter, atau perubahan payload | `docs/04-api-contract.md` |
| Skema basis data, migration baru, tabel, atau kolom | `docs/03-data-model.md` |
| Alur arsitektur, Nginx, deployment, atau alur data | `docs/02-architecture.md` |
| Deviasi desain, penambahan komponen baru, atau gap UI | `docs/05-design-decisions.md` |
| Aset baru, konten teks, flyer, atau aturan redirect 301 | `docs/06-content-migration.md` |
| Peta situs, rute halaman baru, atau hierarki navigasi | `docs/01-ia-sitemap.md` |
| Baseline audit, temuan keamanan, atau hasil benchmark | `docs/00-audit.md` |
| Environment variable baru (`.env.example`) | `docs/02-architecture.md` & `.env.example` terkait |
| Penyelesaian fase pekerjaan atau milestone | `docs/CHANGELOG-phases.md` |

> Jika suatu task tidak memerlukan pembaruan dokumen di atas, seksi *Documentation Updated* pada laporan akhir **wajib menyebutkan alasannya secara eksplisit**.

---

## 8. Batasan Wewenang Agen (Scope Guard)

Tabel berikut membatasi apa yang boleh dikerjakan agen secara mandiri versus tindakan yang membutuhkan persetujuan manusia:

| Tindakan Operasional | Status Wewenang |
|---|---|
| Membaca, menganalisis, dan mencari file di workspace | ✅ **Mandiri** |
| Menulis/mengubah kode frontend (Svelte, Tailwind, TypeScript) | ✅ **Mandiri** |
| Menulis/mengubah kode backend (Service, Controller, Request, Resource) | ✅ **Mandiri** |
| Membuat file migration database baru (additive) | ✅ **Mandiri** (wajib catat di `docs/03-data-model.md`) |
| Memperbarui dokumen arsitektur di `docs/` | ✅ **Mandiri** |
| Menambah *dependency* baru (`composer require` / `npm install <pkg>`) | ❌ **Butuh Konfirmasi Eksplisit** |
| Mengubah atau me-rollback migration lama yang sudah berjalan | ❌ **Butuh Konfirmasi Eksplisit** |
| Menghapus file atau folder struktural | ❌ **Butuh Konfirmasi Eksplisit** |
| Mengubah konfigurasi rute global yang sudah disepakati di IA | ❌ **Butuh Konfirmasi Eksplisit** |
| Mengekspos kredensial atau nilai rahasia di file `.env` aktual | 🛑 **Dilarang Keras** |
| Menjalankan perintah destruktif (`migrate:fresh`, `DROP TABLE`, `rm -rf`) | 🛑 **Dilarang Keras** |
| Mengarang data bisnis, klaim daya, atau angka proyek tanpa `TODO-CONTENT` | 🛑 **Dilarang Keras** |
| Mengubah isi dokumen acuan `DESIGN.md` | 🛑 **Dilarang Keras** |
| Membuat commit Git otomatis tanpa instruksi user | 🛑 **Dilarang Keras** |

---

## 9. Standar Pesan Commit (Commit Message Contract)

Setiap akhir pekerjaan wajib menyertakan usulan pesan commit (**Suggested Conventional Commit**) dalam **Bahasa Inggris** dengan format:

```text
<type>(<scope>): <short imperative description in English>

<Explain the technical change in concrete terms>
<Mention files changed, migrations, API updates, or docs when relevant>
```

### Tipe yang Diizinkan:
- `feat`: Penambahan fitur baru aplikasi atau endpoint.
- `fix`: Perbaikan bug, tautan rusak, atau regresi logic.
- `docs`: Pembaruan atau penambahan dokumentasi/manual agen.
- `refactor`: Restrukturisasi kode tanpa mengubah fungsionalitas.
- `test`: Penambahan unit, feature, atau E2E test.
- `chore`: Konfigurasi tooling, dependensi, linter, gitignore.
- `perf`: Optimasi performa dan Core Web Vitals.

### Scope yang Diizinkan:
`foundation`, `backend`, `frontend`, `api`, `cms`, `auth`, `database`, `products`, `solutions`, `inquiries`, `design`, `deploy`, `docs`.

### Contoh yang Valid:
```text
feat(api): implement product catalog endpoint with category filter

Add ProductService and ProductApiController to serve paginated product records.
Include ProductResource transformation and category slug filtering.

Updated: docs/04-api-contract.md (verified response envelope).
```

---

## 10. Struktur Laporan Akhir Tugas (Final Response Contract)

Setiap penyelesaian tugas **harus ditutup** dengan struktur pelaporan terstandarisasi berikut:

```markdown
## Summary
[Ringkasan teknis apa yang dikerjakan dan mengapa]

## Files Changed
- path/to/file — [deskripsi singkat perubahan]

## Validation
- [Hasil eksekusi linter, build check, typecheck, atau test suite]

## Documentation Updated
- docs/xxx.md — [apa yang diperbarui dan mengapa]
- atau: "Tidak ada dokumentasi yang perlu diperbarui karena [alasan teknis]."

## Suggested Commit
```text
type(scope): summary in English

Detailed technical body...
```

## Human Action Items / Open Decisions
- [Hal yang butuh keputusan, input aset riil, atau eksekusi manual oleh manusia]
```

---

## 11. Integrasi Pustaka Skill Agen (`.agents/skills/`)

Repositori ini memuat pustaka skill agenik lokal pada direktori `.agents/skills/`. Agen yang bekerja pada task terkait **wajib membaca dan menerapkan panduan skill** yang relevan:
- **`laravel-patterns`**: Panduan implementasi Service Layer, Form Request, dan Resource API.
- **`laravel-security`**: Praktik pengerasan otentikasi, otorisasi Spatie, sanitasi XSS, CSRF, dan Eloquent safety.
- **`laravel-tdd`**: Metodologi penulisan unit dan feature test berbasis PHPUnit/Pest.
- **`laravel-verification`**: Loop verifikasi backend (linting Pint, static analysis, security scan).
- **`vite-patterns`**: Panduan konfigurasi bundling Vite, HMR, dan SSR pada frontend.
- **`database-migrations`**: Praktik aman migrasi database MySQL (additive, indexed, reversible).
- **`security-review`**: Checklist keamanan endpoint publik, mitigasi spam formulir, dan sanitasi payload.
- **`conventional-commit-review`**: Standardisasi format commit pesan Git.

---

_Dokumen ini adalah pedoman hidup (living document). Perbarui jika terdapat perubahan arsitektur, konvensi baru, atau keputusan penting yang disepakati bersama user._
