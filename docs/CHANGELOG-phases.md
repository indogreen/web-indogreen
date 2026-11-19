# Log Perubahan Antar-Fase (Phase Changelog)
**Proyek:** Revamp Website PT. Indogreen Technology And Management  
**Repositori:** Monorepo (`backend/`, `frontend/`, `docs/`, `deploy/`)

---

## [Fase 0] — Discovery & Audit (19 November 2026)

### Deskripsi:
Fase fondasi awal untuk memverifikasi dan mengaudit kondisi riil website produksi `https://indogreen.id`, menginventarisasi seluruh konten dan aset media, menetapkan Arsitektur Informasi (IA) dan Peta Situs baru, serta menyusun daftar keputusan teknis. Tidak ada kode aplikasi (Laravel/SvelteKit) yang dibuat pada fase ini.

### Berkas yang Dibuat / Diperbarui:
- `docs/DESIGN.md`: Tersinkronisasi di direktori dokumentasi sebagai sumber kebenaran desain resmi (*design system single source of truth*).
- `docs/00-audit.md`: Dokumen audit teknis komprehensif, hasil perayapan 258 URL, metrik Core Web Vitals Lighthouse Mobile, evaluasi header keamanan HTTP, verifikasi sertifikat SSL, analisis lingkungan server lokal Ubuntu 24.04, serta matriks keputusan arsitektur.
- `docs/01-ia-sitemap.md`: Dokumen Arsitektur Informasi dan Peta Situs baru, blueprint navigasi global 4-tingkat sesuai `DESIGN.md`, pemodelan relasi basis data (ERD), dan struktur otorisasi peran (RBAC Spatie).
- `docs/06-content-migration.md`: Dokumen inventaris konten dan 15 aset media riil, analisis spesifikasi flyer A4, tabel peta pengalihan permanen (301 Redirect Map) 48 aturan, dan daftar 9 aset wajib yang diminta ke klien bertanda `TODO-CONTENT`.
- `docs/CHANGELOG-phases.md`: Inisialisasi berkas log perubahan antar-fase proyek.

### Temuan Kunci:
1. **Audit Performa Mobile Rendah:** Skor Lighthouse Performance 42/100, LCP 7,7 detik, dan TBT 1.590 ms akibat skrip pemblokir render sinkronus dan ketiadaan optimasi aset gambar.
2. **Kerapuhan Arsitektur Eksisting:** Halaman footer mengarah ke berkas template bawaan yang 404 (`about-us-one.html`, `contact-one.html`), URL internal mengandung spasi mentah, dan tidak ada berkas `robots.txt` maupun `sitemap.xml`.
3. **Data Terjebak dalam Gambar Flyer A4:** Seluruh spesifikasi teknis PJU dan diagram solusi tersimpan dalam berkas JPEG brosur cetak 2480 × 3508 piksel (bobot 1,4 MB – 1,8 MB per halaman).
4. **Keamanan & Runtime:** Server lama menggunakan PHP 7.4.33 (EOL) dengan Apache dan memiliki celah mixed content skrip jQuery HTTP.

### Status Quality Gate:
- [x] Crawl seluruh URL publik selesai dan terdata di `docs/00-audit.md`.
- [x] Audit Lighthouse Mobile, Core Web Vitals, dan header keamanan selesai dan dicatat.
- [x] Inventaris konten dan media terperinci lengkap dengan dimensi dan ukuran berkas di `docs/06-content-migration.md`.
- [x] Spesifikasi penting dalam format gambar ditandai untuk ditransformasi ke tabel HTML.
- [x] Peta situs semantik baru difinalisasi di `docs/01-ia-sitemap.md`.
- [x] Seluruh URL lama dipetakan ke URL baru (atau diberi status dihapus) dalam tabel redirect 301.
- [x] Keputusan arsitektur ditetapkan & keputusan terbuka diberi rekomendasi teknis.
- [x] Seluruh placeholder konten menggunakan penanda `TODO-CONTENT`.
- [x] Tidak ada modifikasi kode aplikasi atau perubahan ke server lama.


---

## [Fase 1] — Fondasi Monorepo & Dokumen Arsitektur (19 November 2026)

### Deskripsi:
Menyiapkan kerangka repositori monorepo, dokumen arsitektur teknis menyeluruh, desain skema basis data, spesifikasi kontrak REST API, keputusan dan resolusi kesenjangan desain, aset dummy terstandarisasi, berkas konfigurasi lingkungan, pedoman agen (`AGENTS.md`), dan pipeline CI tanpa menulis kode fitur aplikasi.

### Berkas yang Dibuat / Diperbarui:
- `backend/.gitkeep`, `frontend/.gitkeep`, `deploy/.gitkeep`, `.github/workflows/.gitkeep`: Inisialisasi struktur direktori monorepo.
- `AGENTS.md`: Pedoman operasional AI agent menyeluruh yang menggabungkan standar enterprise terbaik (Source of Truth hierarchy, Required Workflow pre/post, Laravel & SvelteKit coding standards, Design Contract UI checklist, Documentation Contract matrix, Scope Guard wewenang mandiri vs konfirmasi, Conventional Commits, Final Response Contract, dan integrasi skill `.agents/skills/`).
- `CLAUDE.md`: Pointer ringkas menuju `AGENTS.md`.
- `docs/02-architecture.md`: Dokumentasi arsitektur sistem (Browser → Nginx → SvelteKit SSR Node 24 → Laravel API PHP-FPM 8.4 → MySQL 8.0), pembagian tanggung jawab, strategi caching & error handling, pengerasan keamanan, panduan setup lokal dari nol, dan ringkasan deployment Fase 12.
- `docs/03-data-model.md`: Draf skema relasional 8 tabel entitas (`users`, `categories`, `products`, `product_specifications`, `solutions`, `inquiries`, `company_settings`, serta Spatie permissions), aturan slug unik, dan strategi seeding awal.
- `docs/04-api-contract.md`: Spesifikasi kontrak RESTful JSON API v1 (8 endpoint publik, format response envelope, format error 422 terperinci, dan health check).
- `docs/05-design-decisions.md`: Catatan resmi deviasi teknis dari `DESIGN.md` (adopsi Lucide Icons/Font Awesome Free, utilitas bar B2B tanpa login konsumen, focus ring aksesibilitas WCAG), serta resolusi kesenjangan form field, modal, mobile navigation drawer, dan mikro-interaksi hover.
- `docs/dummy-assets/*`: Penyediaan 9 berkas dummy placeholder (`logo-indogreen.svg`, `hero-placeholder.svg`, `product-pju-placeholder.svg`, `datasheet-sample.md`, `about-us-draft.md`, `whatsapp-contact.md`, `geo-coordinates.md`, `privacy-policy-draft.md`, `callout-stats-draft.md`) bertanda `TODO-CONTENT`.
- `backend/.env.example` & `frontend/.env.example`: Kerangka konfigurasi lingkungan aman tanpa kredensial rahasia.
- `.nvmrc`: Pin versi Node.js v24 LTS.
- `.editorconfig`: Standarisasi format indentasi dan berkas monorepo.
- `.gitignore`: Pengecualian berkas Laravel, SvelteKit, IDE, OS, dan deploy.
- `.github/workflows/ci.yml`: Pipeline otomatisasi GitHub Actions dengan quality gate pemeriksaan dokumen dan kerangka job backend & frontend.
- `docs/06-content-migration.md`: Diperbarui untuk menautkan 9 aset wajib ke berkas dummy sementara di `docs/dummy-assets/`.

### Status Quality Gate:
- [x] Struktur monorepo `backend/`, `frontend/`, `docs/`, `deploy/`, `.github/workflows/` terbuat.
- [x] Salinan `docs/DESIGN.md` identik dengan `DESIGN.md`.
- [x] `AGENTS.md` lengkap dan mandiri untuk agen baru memulai Fase 2; `CLAUDE.md` sebagai pointer.
- [x] Dokumen `02-architecture.md`, `03-data-model.md`, `04-api-contract.md`, `05-design-decisions.md` lengkap dan konsisten.
- [x] 9 aset dummy telah dibuat dan ditautkan dalam dokumentasi.
- [x] `.env.example` backend & frontend bebas dari rahasia; `.nvmrc` disetel ke 24.
- [x] `.editorconfig`, `.gitignore`, dan CI workflow siap pakai.
- [x] Tanpa instalasi Laravel/SvelteKit, tanpa Docker/kontainer apa pun.
