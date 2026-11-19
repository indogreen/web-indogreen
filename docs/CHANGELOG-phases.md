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

---

## [Fase 2] — Backend: Fondasi Laravel, Skema Data, Peran & Izin (19 November 2026)

### Deskripsi:
Menginstal proyek Laravel 13 di direktori `backend/`, mengonfigurasi basis data MySQL lokal, sistem berkas media Spatie, otorisasi RBAC Spatie, model Eloquent beserta relasi dan casting, trait kustom `HasSlug`, `HasActiveScope`, dan `HasSortOrderScope`, enum PHP `InquiryStatus` dan `OfficeType`, seeder idempotent lengkap, 23 pengujian otomatis berbasis Pest, analisis statis Larastan, pemeriksaan gaya kode Laravel Pint, serta pengaktifan job CI backend di GitHub Actions.

### Berkas yang Dibuat / Diperbarui:
- `backend/`: Inisialisasi proyek Laravel 13 lengkap (`app/`, `config/`, `database/`, `routes/`, `tests/`, `composer.json`, `composer.lock`).
- `backend/.env.example` & `backend/.env`: Konfigurasi timezone `Asia/Jakarta`, locale `id`, fallback `en`, faker `id_ID`, DB MySQL `indogreen_db`, mail driver log/mailpit, APP_URL, FRONTEND_URL, dan kredensial admin default.
- `backend/app/Enums/InquiryStatus.php` & `backend/app/Enums/OfficeType.php`: Enum PHP dengan label multibahasa Indonesia.
- `backend/app/Models/Traits/`: Trait `HasSlug` (auto-slug unik & URL stabil saat diedit), `HasActiveScope` (`scopeActive`), dan `HasSortOrderScope` (`scopeOrdered`).
- `backend/app/Models/`: Model `User` (dengan `HasRoles`), `Category`, `Product`, `ProductSpecification`, `Solution`, `Inquiry`, dan `CompanySetting`.
- `backend/database/migrations/`: Migrasi 11 tabel (`users`, `cache`, `jobs`, `media`, `permission_tables`, `categories`, `products`, `product_specifications`, `solutions`, `inquiries`, `company_settings`) lengkap dengan indeks komposit, indeks unik slug, dan foreign key cascade/set null.
- `backend/database/factories/`: Factory untuk seluruh 7 model dengan data pengujian representatif.
- `backend/database/seeders/`: `RolePermissionSeeder` (idempotent, 8 permissions, role `admin` & `editor`), `AdminUserSeeder` (kredensial dari env), `CategorySeeder` (4 kategori dari docs/06), `ProductSeeder` (4 PJU seri dengan spesifikasi teknis), `SolutionSeeder` (5 solusi EBT), `CompanySettingSeeder`, dan `DatabaseSeeder`.
- `backend/tests/Feature/`: 5 berkas pengujian Pest (`ModelRelationTest`, `ScopeAndSlugTest`, `FactoryTest`, `RolePermissionTest`, `DatabaseSeederTest`, `MediaLibraryTest`) mencakup 23 test case dengan 84 assertion.
- `backend/phpstan.neon`: Konfigurasi Larastan level 5 dengan eksekusi stabil.
- `backend/phpunit.xml`: Penambahan `APP_KEY` khusus testing environment untuk menjamin kestabilan runner tanpa dependensi berkas host.
- `.github/workflows/ci.yml`: Aktivasi penuh job `backend-ci` (penyalinan `.env` otomatis, `key:generate`, Pint style check, Larastan static analysis, dan Pest test suite).
- `docs/02-architecture.md`: Penjelasan alasan pemilihan setiap paket dan trait slug kustom di seksi 7.
- `docs/03-data-model.md`: Dokumentasi matriks peran-izin default, konfigurasi koleksi dan konversi Spatie Media Library, serta rincian enum PHP.
- `docs/CHANGELOG-phases.md`: Pencatatan log kemajuan pekerjaan Fase 2.

### Status Quality Gate:
- [x] Laravel 13 terpasang di `backend/` dengan timezone `Asia/Jakarta` dan locale `id`.
- [x] Paket minimal terpasang (`spatie/laravel-medialibrary`, `spatie/laravel-permission`, `laravel/pint`, `larastan`, `pestphp/pest`).
- [x] Trait `HasSlug` menghasilkan slug unik dan stabil (tidak berubah saat nama diedit).
- [x] Seluruh skema migrasi tabel, relasi, cast, dan factory dari `docs/03-data-model.md` telah dibuat.
- [x] Tabel `users` bersih tanpa kolom `role`; peran dikelola Spatie RBAC.
- [x] Konfigurasi Media Library (`category_image`, `product_gallery`, `product_datasheet`, `solution_image`, `hero_desktop`, `hero_mobile`) dengan konversi WebP dan batasan MIME type.
- [x] Enum PHP `InquiryStatus` dan `OfficeType` terdefinisi dan di-cast pada model.
- [x] `RolePermissionSeeder` idempotent dan mereset cache permission (8 izin, peran admin & editor).
- [x] Seeder minimal sukses mengeksekusi `migrate:fresh --seed` tanpa error.
- [x] Seluruh 23 tes Pest hijau (100% lulus).
- [x] Analisis statis Larastan level 5 bersih (0 error).
- [x] Pemeriksaan gaya kode Laravel Pint bersih (0 error).
- [x] CI workflow GitHub Actions terkonfigurasi untuk backend.
- [x] Dokumentasi `docs/02-architecture.md` dan `docs/03-data-model.md` tersinkronisasi penuh.

---

## [Fase 3] — Backend: Admin CMS (Filament) (19 November 2026)

### Deskripsi:
Menginstal Filament CMS (v5.x kompatibel dengan Laravel 13) di direktori `backend/`, mengonfigurasi panel administratif di rute `/admin` yang diproteksi secara ketat oleh izin `access-admin` melalui `User::canAccessPanel()`, membuat 9 resource Filament lengkap (`HeroSlide`, `ProductCategory`, `Product`, `Solution`, `Page`, `Office`, `Inquiry`, `User`, `Role`), membuat halaman pengaturan situs terdedikasi (`ManageSiteSettings`), mengonfigurasi policy berbasis Spatie permission dengan perlindungan admin terakhir, menerapkan sanitasi HTML otomatis saat simpan pada atribut rich text, serta menambahkan pengujian Pest (total 48 test case, 177 assertion) yang seluruhnya lulus hijau.

### Berkas yang Dibuat / Diperbarui:
- `backend/composer.json` & `backend/composer.lock`: Menambahkan dependensi `filament/filament` (v5.x).
- `backend/app/Providers/Filament/AdminPanelProvider.php`: Konfigurasi panel default `/admin` dengan autentikasi session, penemuan otomatis resources/pages/widgets, dan tema default Filament tanpa modifikasi token desain situs publik.
- `backend/app/Models/User.php`: Mengimplementasikan antarmuka `FilamentUser` dan metode `canAccessPanel(Panel $panel): bool` memeriksa `can('access-admin')`.
- `backend/database/migrations/2026_11_19_230000_create_phase3_cms_tables.php`: Migrasi aditif tabel `hero_slides`, `pages`, `offices`, `site_settings`, pivot `product_solution`, serta kolom `seo_title` (60) dan `seo_description` (160) pada `products` dan `solutions`.
- `backend/app/Models/`: Model baru `HeroSlide`, `Page`, `Office`, `SiteSetting` beserta mutator sanitasi HTML dan relasi many-to-many `Product::solutions()` dan `Solution::products()`.
- `backend/app/Services/HtmlSanitizerService.php`: Layanan sanitasi HTML yang secara agresif membersihkan blok `<script>`, `<style>`, event handler JavaScript (`onclick`, `onload`, dll.), dan skema `javascript:`, serta membatasi elemen hanya pada tag aman yang diizinkan (*whitelist*).
- `backend/app/Policies/`: Policy otorisasi Spatie (`CategoryPolicy`, `ProductPolicy`, `SolutionPolicy`, `HeroSlidePolicy`, `PagePolicy`, `OfficePolicy` terikat `content.manage`; `InquiryPolicy` terikat `inquiries.view`, `inquiries.update`, `inquiries.delete`; `UserPolicy` terikat `users.manage` dengan perlindungan admin terakhir; `RolePolicy` terikat `roles.manage` dengan perlindungan larangan menghapus peran `admin`).
- `backend/app/Providers/AppServiceProvider.php`: Pendaftaran eksplisit `Gate::policy(Role::class, RolePolicy::class)`.
- `backend/app/Filament/Resources/`:
  - `HeroSlides/`: Form judul, subjudul, tombol CTA, upload gambar desktop & mobile (Maks 2MB, WebP/JPG/PNG), status aktif, dan tabel *reorderable*.
  - `Categories/`: Form nama, slug unik stabil, deskripsi, ikon Lucide, urutan, status aktif, dan tabel reorderable.
  - `Products/`: Form berstruktur 5 Tab (Umum, Spesifikasi teknis dengan Repeater parameter/nilai/satuan terurut, Fitur dengan RichEditor dan Ringkasan, Media dengan gambar utama dan datasheet PDF, SEO dengan indikator batas 60 dan 160 karakter).
  - `Solutions/`: Form nama, tipe sistem EBT, relasi multi-select ke produk, ringkasan, arsitektur sistem RichEditor, TagsInput komponen & keuntungan, diagram gambar, SEO, dan tabel penayangan.
  - `Pages/`: Form judul, slug unik stabil, RichEditor konten tersanitasi, SEO, dan status aktif.
  - `Offices/`: Form nama kantor, dropdown enum `OfficeType`, alamat fisik, telepon, email, embed peta Google Maps, urutan, dan status aktif.
  - `Inquiries/`: Form hanya-baca untuk seluruh data pengirim (nama, perusahaan, email, telp, pesan, produk/solusi terkait) dengan hak edit terbatas pada `status` dan `internal_notes`. Pembuatan manual dinonaktifkan (`canCreate => false`).
  - `Users/`: Form akun staf dan penetapan peran (Role) dengan aturan validasi khusus pencegah pencabutan peran dari admin terakhir.
  - `Roles/`: Form nama peran dan CheckboxList seluruh izin Spatie dengan penguncian nama peran `admin`.
- `backend/app/Filament/Pages/ManageSiteSettings.php`: Halaman pengaturan situs tunggal terikat izin `settings.manage` untuk identitas PT Indogreen, tagline, telepon, email, WhatsApp, alamat kantor, dan media sosial.
- `backend/database/factories/`: Factory untuk `HeroSlide`, `Page`, `Office`, dan `SiteSetting`.
- `backend/database/seeders/SiteSettingSeeder.php`: Seeder data profil perusahaan resmi dan kantor cabang, terintegrasi ke `DatabaseSeeder`.
- `backend/tests/Feature/Filament/`: 5 berkas pengujian Pest baru (`AdminPanelAccessTest`, `ResourcePolicyTest`, `LastAdminProtectionTest`, `HtmlSanitizationTest`, `CrudSmokeTest`).
- `.github/workflows/ci.yml`: Penambahan opsi `--memory-limit=1G` pada langkah Larastan untuk performa analisis statis optimal di lingkungan CI runner.
- `docs/02-architecture.md`: Pembaruan justifikasi pustaka Filament CMS v5.x di seksi 7.
- `docs/03-data-model.md`: Penambahan seksi 3.11 mendokumentasikan skema tabel ekstensi CMS dan kolom SEO.
- `docs/CHANGELOG-phases.md`: Pencatatan log kemajuan pekerjaan Fase 3.

### Status Quality Gate:
- [x] Filament CMS terpasang di `backend/` dengan panel `/admin` aktif.
- [x] Akses panel dibatasi hanya untuk pemegang izin `access-admin` via `User::canAccessPanel()`.
- [x] 9 resource Filament terimplementasi lengkap dengan navigasi dan translasi Bahasa Indonesia.
- [x] Halaman pengaturan situs `ManageSiteSettings` dibatasi izin `settings.manage`.
- [x] Policy seluruh resource menggunakan `$user->can()` sesuai matriks Spatie RBAC.
- [x] Perlindungan admin terakhir: peran `admin` tidak bisa dihapus, admin terakhir tidak bisa dihapus atau dicabut perannya.
- [x] Validasi form: slug unik stabil, SEO title (max 60), SEO desc (max 160), batas MIME dan ukuran upload media.
- [x] Sanitasi HTML whitelist tag otomatis aktif pada atribut rich text model saat simpan.
- [x] Tema default Filament dipertahankan (tanpa menerapkan design system situs publik pada panel CMS).
- [x] Seluruh 48 tes Pest hijau (100% lulus, 177 assertion).
- [x] Analisis statis Larastan level 5 bersih (0 error).
- [x] Pemeriksaan gaya kode Laravel Pint bersih (0 error).
- [x] Dokumentasi `docs/02-architecture.md`, `docs/03-data-model.md`, dan `docs/CHANGELOG-phases.md` tersinkronisasi penuh.
