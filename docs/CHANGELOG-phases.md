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

---

## [Fase 4] — Backend: REST API Publik, Sanitasi & Anti-Spam (20 November 2026)

### Deskripsi:
Mengimplementasikan seluruh endpoint RESTful JSON API v1 publik (`/api/v1/*`) di `backend/` untuk melayani kebutuhan frontend SvelteKit secara decoupled. Menyediakan amplop respons terstandarisasi, kontrol CORS ketat (`FRONTEND_URL`, metode `GET`, `POST`, `OPTIONS`), pengikatan model observer untuk caching berversi (`content_version`), header `Cache-Control` & negosiasi `ETag` (HTTP 304 Not Modified), penanganan error konsisten (404, 422, 429, 500), pengiriman formulir inquiry dengan proteksi honeypot, rate limiting (5 req/menit/IP), anonimisasi `ip_hash`, serta notifikasi email queued Mailable.

### Berkas yang Dibuat / Diperbarui:
- `backend/routes/api.php`: Pendaftaran 17 rute publik ber-prefix `v1` (`home`, `settings`/`company`, `product-categories` & `{slug}`, `products` & `{category_slug}/{product_slug}` & `{slug}`, `solutions` & `{slug}`, `pages/{slug}`, `search`, `sitemap-entries`, `inquiries`, `health`).
- `backend/bootstrap/app.php`: Pendaftaran rute API, middleware `ApiCacheMiddleware`, dan handler pengecualian kustom (404, 422, 429, 500) yang mengembalikan amplop JSON baku.
- `backend/config/cors.php`: Pembatasan CORS eksplisit ke `FRONTEND_URL` hanya untuk metode `GET`, `POST`, `OPTIONS`, `HEAD`.
- `backend/config/app.php`: Penambahan konfigurasi `frontend_url` dan `admin_email`.
- `backend/database/migrations/2026_11_20_010000_update_inquiries_table_for_phase4.php`: Migrasi aditif membuat `phone_whatsapp` nullable, menambahkan `ip_hash` (VARCHAR 64), dan `consent` (BOOLEAN).
- `backend/app/Models/Inquiry.php`: Penambahan atribut `ip_hash` dan `consent` pada `$fillable` dan `$casts`.
- `backend/database/factories/InquiryFactory.php`: Pembaruan factory dengan data `ip_hash` dan `consent`.
- `backend/app/Support/MediaUrlHelper.php`: Helper URL media absolut yang menangani varian WebP (`thumb`, `card`, `hero`), fallback disk publik, dan properti `alt`.
- `backend/app/Http/Resources/`: Kumpulan API Resource terstandarisasi (`HeroSlideResource`, `CategoryResource`, `ProductListResource`, `ProductDetailResource`, `SolutionListResource`, `SolutionDetailResource`, `PageResource`, `OfficeResource`, `SiteSettingResource`).
- `backend/app/Services/ContentCacheService.php`: Layanan manajemen caching berbasis versi konten terpusat.
- `backend/app/Observers/ContentVersionObserver.php`: Model observer yang secara reaktif melakukan bump versi `content_version` saat entitas konten dibuat, diperbarui, atau dihapus.
- `backend/app/Providers/AppServiceProvider.php`: Pendaftaran `ContentVersionObserver` untuk 8 model konten dan definisi rate limiter `inquiries` (5 req/menit).
- `backend/app/Http/Middleware/ApiCacheMiddleware.php`: Middleware HTTP caching untuk GET requests dengan `Cache-Control`, `ETag`, dan negosiasi `304 Not Modified`.
- `backend/app/Http/Requests/StoreInquiryRequest.php`: Form Request inquiry dengan validasi lengkap, alias input, batasan panjang pesan 2000 karakter, dan deteksi honeypot `website_url`.
- `backend/app/Mail/InquiryReceivedMail.php` & `backend/resources/views/emails/inquiry-received.blade.php`: Queued Mailable notifikasi inquiry untuk tim sales engineering.
- `backend/app/Http/Controllers/Api/`: Controller tipis berbasis `BaseApiController` (`HomeController`, `SettingController`, `CategoryController`, `ProductController`, `SolutionController`, `PageController`, `SearchController`, `SitemapController`, `InquiryController`, `HealthController`).
- `backend/tests/Feature/Api/`: 10 berkas pengujian Pest komprehensif (`HomeApiTest`, `SettingApiTest`, `CategoryApiTest`, `ProductApiTest`, `SolutionApiTest`, `PageApiTest`, `SearchApiTest`, `SitemapApiTest`, `InquiryApiTest`, `HealthApiTest`, `CacheAndEtagTest`, `BenchmarkPerformanceTest`).
- `docs/04-api-contract.md`: Pembaruan spesifikasi kontrak API v1 lengkap dengan contoh respons aktual seluruh endpoint dan tabel benchmark latensi.
- `docs/03-data-model.md`: Pembaruan skema tabel `inquiries` mencatat kolom `ip_hash` dan `consent`.
- `docs/CHANGELOG-phases.md`: Pencatatan log kemajuan pekerjaan Fase 4.

### Status Quality Gate:
- [x] Seluruh endpoint publik `/api/v1` terimplementasi sesuai kontrak di `docs/04-api-contract.md`.
- [x] API Resource menyajikan URL media absolut dengan varian ukuran dan teks alt; data hanya yang bertatus `is_active`.
- [x] Endpoint `POST /inquiries` memvalidasi input, honeypot anti-spam, throttle 5 req/menit, anonimisasi `ip_hash`, dan queue email.
- [x] Sistem caching respons GET beroperasi dengan kunci versi (`content_version`), `ETag`, dan respon `304 Not Modified`.
- [x] Respons error konsisten pada status 404, 422, 429, dan 500 tanpa kebocoran stack trace.
- [x] Kebijakan CORS dibatasi ke `FRONTEND_URL` hanya untuk metode GET dan POST.
- [x] 69 tes Pest hijau (100% lulus, 373 assertions).
- [x] Analisis statis Larastan level 5 bersih (0 error).
- [x] Pemeriksaan gaya kode Laravel Pint bersih (0 error).
- [x] Benchmark latensi lokal p95 terukur di bawah 7 ms (jauh melampaui target < 200 ms).
- [x] Dokumentasi `docs/04-api-contract.md`, `docs/03-data-model.md`, dan `docs/CHANGELOG-phases.md` tersinkronisasi penuh.

---

## [Fase 5] — Frontend: Fondasi, Token Desain, Komponen UI (20 November 2026)

### Deskripsi:
Menginisialisasi aplikasi SvelteKit (Svelte 5 runes, TypeScript mode strict) di direktori `frontend/` menggunakan `@sveltejs/adapter-node`, Tailwind CSS v4, ESLint, Prettier, `svelte-check`, Vitest, dan `@testing-library/svelte`. Menerjemahkan seluruh token desain dari `docs/DESIGN.md` dan `docs/05-design-decisions.md` ke dalam `src/lib/styles/tokens.css` (warna, 18 skala tipografi `display-xl` hingga `utility-xs`, spasi berorientasi grid 8px, batas radius 2px, breakpoint responsif, container 1280px). Mengintegrasikan font mandiri Inter 400 & 700 (@fontsource/inter) dengan `font-display: swap` dan fallback Arial. Membangun 14 komponen UI atomik & molekuler di `src/lib/components/ui/` bebas dari nilai heksadesimal atau piksel lepas (*zero loose hex/px*). Menyediakan rute panduan gaya dev-only `/styleguide` yang memblokir akses di produksi (HTTP 404), menulis 10 berkas pengujian komponen Vitest (37 pengujian, 100% lulus), dan mengaktifkan build check serta verifikasi CI frontend.

### Berkas yang Dibuat / Diperbarui:
- `frontend/`: Inisialisasi struktur proyek SvelteKit lengkap (`package.json`, `package-lock.json`, `tsconfig.json`, `vite.config.ts`, `eslint.config.js`, `prettier.config.js`, `.npmrc`, `.gitignore`, `.prettierignore`, `README.md`).
- `frontend/src/lib/styles/tokens.css`: Definisi variabel CSS `:root`, tema Tailwind (`@theme`), 18 kelas utilitas skala tipografi (`.type-display-xl` s.d. `.type-utility-xs`), spasi grid (`--spacing-*`), radius (`--radius-sm: 2px`), breakpoint responsif, kelas utilitas container (`.container-max`), padding seksi responsif (`.section-padding`), dan indikator fokus aksesibilitas (`.focus-ring`).
- `frontend/src/lib/components/ui/types.ts`: Definisi antarmuka dan tipe data TypeScript untuk seluruh komponen UI, varian tombol, tone seksi, posisi ornamen brand, dan model tab.
- `frontend/src/lib/components/ui/`:
  - `Icon.svelte`: Komponen ikon SVG berbasis pustaka modular `@lucide/svelte` dengan ketebalan goresan 2px seragam.
  - `Button.svelte`: Tombol CTA dan tautan navigasi dengan 4 varian (`primary`, `outline`, `outline-on-dark`, `ghost-link`), 3 ukuran (`sm`, `md`, `lg`), tinggi sentuh minimal 44px, teks tombol hijau hitam pekat (`#000000`), dan radius sudut 2px.
  - `TextInput.svelte`: Input teks 44px dengan radius 2px, cincin fokus aksesibilitas WCAG, state error dengan atribut ARIA (`aria-invalid`, `aria-describedby`, `role="alert"`).
  - `Textarea.svelte`: Area teks multi-baris tinggi minimal 120px dengan penanganan error dan cincin fokus.
  - `Select.svelte`: Dropdown pilihan asli dengan ikon chevron-down, penanganan error, dan cincin fokus.
  - `Badge.svelte`: Lencana status geometris dengan tipografi `caption-md` kapital dan radius 2px.
  - `PillTabs.svelte`: Kontrol tab tersegmentasi beradius 2px (bukan pill/oval), navigasi panah keyboard, dan atribut aksesibilitas WAI-ARIA `role="tablist"` / `role="tab"`.
  - `CornerSquare.svelte`: Motif ornamen sudut khas INDOGREEN 12 × 12 piksel berwarna hijau solid di sudut kiri atas atau kanan bawah.
  - `ProductCard.svelte`: Kartu katalog produk dengan batas hairline 1px datar, ornamen sudut hijau di kiri atas, tanpa drop-shadow, dan batas fokus hover hijau.
  - `FeatureCard.svelte`: Kartu fitur layanan dengan ikon 24px hijau, batas hairline datar, dan tipografi rapi.
  - `ResourceCard.svelte`: Kartu unduhan dokumen/datasheet dengan lencana tipe file, ornamen sudut, dan tautan aksi berpanah.
  - `CalloutStat.svelte`: Blok angka metrik `display-lg` hijau dengan label keterangan di bawahnya.
  - `Container.svelte`: Pembungkus tata letak horizontal responsif dengan lebar maksimal 1280px.
  - `Section.svelte`: Pembungkus seksi halaman dengan 3 pilihan tone warna (`light`, `dark`, `soft`) dan padding vertikal responsif (64px desktop / 48px tablet / 32px mobile).
- `frontend/src/lib/components/ui/index.ts` & `frontend/src/lib/index.ts`: Ekspor publik barrel untuk seluruh komponen dan tipe data UI.
- `frontend/src/routes/+layout.svelte`: Shell tata letak global yang mengimpor `tokens.css` dan font Inter.
- `frontend/src/routes/+page.svelte`: Halaman beranda pengembangan yang mengarahkan pengembang ke rute `/styleguide`.
- `frontend/src/routes/styleguide/+page.server.ts`: Penjaga rute dev-only yang memicu HTTP 404 saat `!dev` di lingkungan produksi.
- `frontend/src/routes/styleguide/+page.svelte`: Halaman showcase panduan gaya interaktif komprehensif yang menampilkan logo resmi INDOGREEN, seluruh palet warna, 18 tingkatan tipografi, tombol di atas kanvas terang dan gelap, input formulir, badge, tabs, kartu-kartu, callout statistik, dan pratinjau komponen Footer.
- `frontend/src/lib/components/ui/Footer.svelte`: Komponen bab penutup halaman enterprise dengan aksen garis bi-color, 3 kolom tautan teknis hijau, formulir buletin, ikon sosial media, dan sub-footer legal dengan logo resmi perusahaan.
- `frontend/static/indogreen.png`: Favicon dan logo resmi perusahaan yang digunakan secara langsung tanpa pembungkus latar belakang buatan. Seluruh berkas favicon SVG dan PNG dummy telah dihapus sesuai instruksi.
- `frontend/src/lib/components/ui/`: 11 berkas pengujian Vitest (`Button.test.ts`, `TextInput.test.ts`, `Textarea.test.ts`, `Select.test.ts`, `Badge.test.ts`, `PillTabs.test.ts`, `CornerSquare.test.ts`, `Cards.test.ts`, `Layout.test.ts`, `Icon.test.ts`, `Footer.test.ts`) mencakup 41 test case.
- `.github/workflows/ci.yml`: Pembaruan komentar pengaktifan Fase 5 dan penambahan langkah verifikasi `Build Check` (`npm run build`) pada job `frontend-ci`.
- `docs/05-design-decisions.md`: Penambahan seksi 3.5 mendokumentasikan arsitektur footer enterprise, lockup logo terlindungi, dan resolusi kontras mode gelap.
- `docs/CHANGELOG-phases.md`: Pencatatan log kemajuan pekerjaan Fase 5.

### Status Quality Gate:
- [x] SvelteKit (Svelte 5, TypeScript strict) terpasang di `frontend/` dengan `@sveltejs/adapter-node` dan Tailwind CSS v4.
- [x] Front matter `DESIGN.md` diterjemahkan secara presisi ke `src/lib/styles/tokens.css` (warna, 18 skala tipografi, spasi 8px, radius 2px, container 1280px).
- [x] Self-hosted font Inter 400 & 700 aktif dengan `font-display: swap` dan fallback Arial.
- [x] Ikonografi terstandarisasi via pustaka Lucide Icons (`@lucide/svelte`) melalui komponen `Icon.svelte`.
- [x] 15 komponen UI atomik & molekuler dibangun dan diekspor di `src/lib/components/ui/` (termasuk `Footer.svelte`).
- [x] Nol warna heksadesimal lepas atau ukuran piksel lepas di seluruh komponen UI (`src/lib/components/ui/`).
- [x] Tidak ada drop-shadow pada kartu (hanya batas hairline 1px datar).
- [x] Tidak ada radius di atas 2px (`rounded-sm`) pada tombol, kartu, input, maupun tabs (tidak ada pill button).
- [x] Teks pada tombol hijau primer (`Button` variant `primary`) berwarna hitam pekat (`#000000`).
- [x] Aksen kuning hanya diaplikasikan pada permukaan gelap dan tidak pernah sebagai warna isian CTA.
- [x] Rute dev-only `/styleguide` selesai dan otomatis mengembalikan HTTP 404 pada build produksi.
- [x] Logo resmi `indogreen.png` terintegrasi langsung tanpa wadah latar belakang dan ditetapkan sebagai favicon resmi.
- [x] Resolusi kontras mode terang dan gelap tuntas dengan `@custom-variant dark (&:where(.dark, .dark *));`: tab inaktif dan badge default di mode terang tampil kontras (latar abu-abu muda & teks gelap) tanpa terdistorsi oleh preferensi tema gelap tingkat OS. Tab aktif pada mode gelap menggunakan `dark:bg-on-dark dark:text-on-primary` (kontras 21:1).
- [x] Seluruh 41 tes unit komponen Vitest lulus hijau (100%).
- [x] Pemeriksaan tipe `npm run check` (svelte-check) bersih (0 error, 0 warning).
- [x] Pemeriksaan linter `npm run lint` (ESLint & Prettier) bersih (0 error, 0 warning).
- [x] Build produksi SSR `npm run build` sukses tanpa galat.
- [x] Job CI frontend di GitHub Actions diperbarui dan siap dieksekusi.
- [x] Tombol pratinjau Mode Gelap/Terang aktif di `/styleguide`, eliminasi efek garis ganda (*zero double border*), dan penyempurnaan kartu spesimen tombol, formulir, tabs, dan badge sesuai spesifikasi CAD.
- [x] Seluruh dokumentasi tersinkronisasi.

---

## [Fase 6] — Frontend: Layout, Navigasi, SEO, API Client (20 November 2026)

### Deskripsi:
Membangun kerangka tata letak global (*global shell*), sistem navigasi multi-tingkat responsif, fondasi SEO dan metadata, API client server-only, proxy endpoint formulir inquiry, hooks server dengan security headers terpusat, halaman penanganan error 404/500 berbasis CAD, serta seluruh placeholder rute navigasi publik. Memangkas margin kosong aset logo resmi `indogreen.png` secara lossless dengan rasio aspek terjaga, menulis pengujian unit Vitest komprehensif (16 berkas pengujian, 72 pengujian, 100% hijau), dan memverifikasi kesiapan build produksi SSR.

### Berkas yang Dibuat / Diperbarui:
- `frontend/src/lib/server/api.ts`: API client server-only yang menggunakan variabel lingkungan privat `API_BASE_URL` (dari `$app/env/private`). Mengimplementasikan fetch bertipe, timeout otomatis via `AbortController`, penanganan terstruktur untuk kode status HTTP (404, 422, 429, 500, 503, 504) melalui kelas `ApiClientError`, query string serializer, dan fallback default `DEFAULT_SITE_SETTINGS` untuk ketahanan terhadap downtime backend.
- `frontend/src/lib/types/`: Definisi tipe data TypeScript lengkap untuk komunikasi data (`api.ts`, `settings.ts`, `product.ts`, `solution.ts`, `home.ts`, `page.ts`, `inquiry.ts`, `search.ts`, `seo.ts`, dan barrel export `index.ts`).
- `frontend/src/routes/api/inquiries/+server.ts`: Endpoint proxy server SvelteKit untuk pengiriman formulir inquiry publik, melindungi API backend dari pemanggilan langsung browser, melakukan validasi dasar field wajib, menyaring field honeypot anti-spam (`website_url`), dan mencerminkan kode error serta error validasi ke klien.
- `frontend/src/routes/+layout.server.ts`: Server load function yang memuat data pengaturan situs (`SiteSettings`) via `api.getSettings(fetch)` untuk dikonsumsi bilah utilitas dan footer.
- `frontend/src/lib/components/layout/`:
  - `Logo.svelte`: Komponen logo responsif yang menggunakan aset `static/indogreen.png` hasil pemangkasan margin, dengan alt text semantik dan pembungkus tautan beranda.
  - `UtilityBar.svelte`: Bilah informasi atas berketinggian 32px (`bg-surface-dark`) yang menampilkan nomor telepon resmi, email, jam layanan operasional, dan tautan media sosial dari data settings.
  - `PrimaryNav.svelte`: Bilah navigasi utama berketinggian 64px (`bg-surface-dark`) memuat logo INDOGREEN di kiri, menu navigasi utama (Beranda, Produk, Solusi, Tentang Kami, Kontak) dengan penanda aktif `aria-current="page"`, tombol pencarian modal, tombol hamburger mobile, dan satu tombol CTA hijau solid tunggal (*Single Green CTA Rule*) "Hubungi Kami". Memiliki pendeteksi scroll yang menerapkan bayangan sticky token `0 0 5px 0 rgba(0,0,0,0.3)`.
  - `MobileDrawer.svelte`: Laci navigasi geser dari kanan untuk layar ponsel (< 768px), dilengkapi focus trap keyboard, penutup tombol `Escape`, atribut aksesibilitas `aria-expanded`, penguncian gulir body (*scroll lock*), dan target sentuh minimal 52px.
  - `Breadcrumb.svelte`: Navigasi remah roti berketinggian 48px berlatar `surface-soft`, tipografi uppercase `caption-md`, dan pemisah chevron warna mute.
  - `SubNav.svelte`: Navigasi tingkat kedua berketinggian 56px berlatar `surface-soft`, mendukung scroll horizontal pada tablet dan dropdown select natif pada perangkat mobile.
  - `Footer.svelte`: Footer enterprise multi-kolom berlatar hitam (`surface-dark`), 4 kolom navigasi (Produk, Solusi, Perusahaan, Kontak) yang beralih menjadi akordeon keyboard-accessible pada layar mobile, formulir buletin EBT, dan sub-footer legal dengan penanggalan dinamis serta identitas resmi `PT. Indogreen Technology And Management`.
  - `SeoHead.svelte`: Komponen manajemen metadata SEO dengan template title `%s | INDOGREEN`, meta deskripsi, canonical URL, OpenGraph (og:title, og:description, og:image, og:url, og:type), kartu Twitter (summary_large_image), instruksi crawler robots, dan slot skrip Schema.org JSON-LD dengan fallback otomatis ke metadata API.
  - `index.ts`: Barrel export untuk seluruh komponen layout.
- `frontend/src/hooks.server.ts`: Interceptor server-side terpadu dengan HTTP security headers dasar (`X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy`), penanganan error terpusat (`handleError`), kerangka 301 redirect map untuk migrasi URL lama, dan header caching aset statis immutable.
- `frontend/src/app.html`: Konfigurasi shell HTML dengan atribut `lang="id"`, meta viewport tanpa `maximum-scale` untuk aksesibilitas zoom peramban, dan favicon yang menunjuk langsung ke logo resmi `static/indogreen.png`.
- `frontend/src/routes/+layout.svelte`: Shell tata letak global yang menggabungkan `UtilityBar`, `PrimaryNav`, slot konten, dan `Footer`.
- `frontend/src/routes/+error.svelte`: Halaman penanganan kesalahan 404 dan 500 berbasis sistem desain CAD dengan ornamen `CornerSquare` hijau, penjelasan berbahasa Indonesia yang bersahabat, dan tombol navigasi kembali ke beranda atau katalog produk.
- `frontend/src/routes/`: Seluruh placeholder rute publik bertanda `TODO-CONTENT`:
  - `+page.svelte` (Beranda)
  - `produk/+page.svelte` (Katalog Produk)
  - `produk/[category]/+page.svelte` (Kategori Produk)
  - `produk/[category]/[slug]/+page.svelte` (Detail Produk)
  - `solusi/+page.svelte` (Katalog Solusi)
  - `solusi/[slug]/+page.svelte` (Detail Solusi)
  - `tentang-kami/+page.svelte` (Tentang Kami)
  - `kontak/+page.svelte` (Kontak)
  - `kebijakan-privasi/+page.svelte` (Kebijakan Privasi)
  - `pencarian/+page.svelte` (Pencarian)
- `frontend/static/indogreen.png`: Dipangkas secara lossless dari 861 × 371 px menjadi 809 × 233 px menggunakan utilitas biner gambar macOS `sips` (memotong 51px ruang kosong atas, 88px ruang kosong bawah, 27px ruang kosong kiri) dengan rasio aspek (~3.47:1) dan warna yang sepenuhnya dipertahankan.
- `frontend/src/env.d.ts`: Deklarasi tipe ambient untuk `$app/env/private` dan `$env/dynamic/private`.
- `frontend/vite.config.ts`: Konfigurasi resolve alias untuk `$lib` guna menjamin kompatibilitas modul pada runner Vitest dan SvelteKit 3.
- `frontend/src/lib/server/api.test.ts`: 9 pengujian unit API client (GET, POST, query parameters, penanganan 404, 422, 429, 500, timeout 504, dan fallback settings default).
- `frontend/src/lib/components/layout/Navigation.test.ts`: 7 pengujian navigasi (desktop nav, active state `aria-current="page"`, tombol search modal, single green CTA, hamburger drawer toggle, focus trap, Escape key listener, scroll lock).
- `frontend/src/lib/components/layout/Footer.test.ts`: 6 pengujian footer (4 kolom navigasi, mobile accordion toggle via keyboard, newsletter form, settings data binding, socials, auto year).
- `frontend/src/lib/components/layout/LayoutComponents.test.ts`: 5 pengujian komponen pendukung (Breadcrumb formatting, SubNav desktop horizontal / mobile select, SeoHead meta tags & API fallback).
- `frontend/src/routes/api/inquiries/+server.test.ts`: 3 pengujian proxy endpoint (422 validasi input kosong, 201 sukses penerusan ke backend, 429 rate limiting backend mirroring).
- `docs/05-design-decisions.md`: Penambahan seksi 3.6 mendokumentasikan pemangkasan margin logo PNG dan pencatatan permintaan resmi master vektor SVG ke pihak klien.
- `docs/02-architecture.md`: Penambahan seksi 8 menjelaskan arsitektur Frontend SvelteKit SSR, server-only API client, inquiry proxy, hooks security headers, dan struktur layout navigasi global.
- `docs/CHANGELOG-phases.md`: Pencatatan log kemajuan pekerjaan Fase 6.

### Status Quality Gate:
- [x] API client server-only `src/lib/server/api.ts` aktif dengan timeout, penanganan kode 404/422/429/5xx, dan tipe data TypeScript lengkap di `src/lib/types/`.
- [x] Browser tidak memanggil API Laravel langsung; pengiriman inquiry melewati proxy endpoint SvelteKit `/api/inquiries`.
- [x] `+layout.server.ts` memuat data `settings` untuk UtilityBar dan Footer dengan fallback offline yang aman.
- [x] Komponen layout lengkap: `UtilityBar`, `PrimaryNav`, `MobileDrawer`, `Breadcrumb`, `SubNav`, `Footer`.
- [x] Navigasi desktop dan drawer mobile teruji aksesibilitas keyboard (focus trap, Esc key, aria-expanded, scroll lock).
- [x] Komponen `Logo` menggunakan aset logo INDOGREEN yang dipangkas tanpa mengubah proporsi atau warna; permintaan SVG dicatat di `docs/05-design-decisions.md`.
- [x] Komponen `SeoHead` menghasilkan template `%s | INDOGREEN`, canonical, og:*, twitter:*, robots, dan slot JSON-LD.
- [x] `hooks.server.ts` menerapkan security headers, penanganan error terpusat, kerangka 301 redirect map, dan cache headers.
- [x] `+error.svelte` merender pesan 404 dan 500 sesuai spesifikasi CAD `DESIGN.md`.
- [x] Placeholder untuk seluruh route terbuka dan dapat dinavigasi.
- [x] `app.html` tervalidasi: `lang="id"`, viewport tanpa `maximum-scale`, favicon logo resmi.
- [x] Maksimal satu CTA hijau solid per viewport di seluruh halaman layout.
- [x] Tanpa drop-shadow kecuali bayangan sticky nav saat scroll (`0 0 5px 0 rgba(0,0,0,0.3)`).
- [x] Tanpa pustaka UI atau animasi pihak ketiga tambahan.
- [x] `npm run check` (svelte-check) bersih: 0 error, 0 warning.
- [x] `npm run lint` (Prettier & ESLint) bersih: 0 error, 0 warning.
- [x] `npm test` (Vitest) 100% hijau: 16 test files passed, 72 tests passed.
- [x] `npm run build` sukses membuat bundle SSR Node tanpa error.

---

## [Fase 7] — Frontend: Beranda, Produk, Solusi (21 November 2026)

### Deskripsi:
Membangun halaman inti situs website resmi PT. Indogreen Technology And Management yang meliputi Beranda (`/`), Katalog Produk (`/produk`), Kategori Produk (`/produk/[kategori]`), Detail Lembar Data Produk (`/produk/[kategori]/[slug]`), Katalog Solusi EBT (`/solusi`), dan Detail Solusi Rekayasa (`/solusi/[slug]`). Mengintegrasikan seluruh komponen atomik dan molekuler dari Fase 5 dan 6 dengan kepatuhan penuh terhadap `docs/DESIGN.md` (ritme dark/light 64px tanpa pembatas dekoratif, batas radius 2px, font Inter, satu H1 semantik, gambar eksplisit width/height dengan art direction 16:9 desktop ke 4:5 mobile via `<picture>`, eager hero, lazy rest). Menerapkan filter PillTabs server-rendered dengan state URL (`?kategori=`), paginasi produk, penanganan galeri produk interaktif, tabel spesifikasi teknis baris selang-seling, tombol unduh datasheet, CTA 'Minta Penawaran' ke `/kontak?produk=slug`, skema Schema.org JSON-LD (Product tanpa harga dan BreadcrumbList), serta pengujian unit dan load function dengan 18 berkas pengujian (90 test cases, 100% lulus hijau).

### Berkas yang Dibuat / Diperbarui:
- `frontend/src/routes/+page.server.ts`: Server load function beranda yang memuat data teragregasi dari `api.getHome(fetch)` dengan penanganan error dan fallback data terstruktur yang aman terhadap downtime backend.
- `frontend/src/routes/+page.svelte`: Halaman beranda inti yang menyusun:
  1. `hero-card-dark`: Copy di sepertiga kiri, headline `display-xl` dengan kata kunci kuning (`text-accent-yellow`), satu CTA primary dan outline-on-dark, ornamen `CornerSquare` 16px, background `<picture>` dengan art direction 16:9 desktop ke 4:5 mobile, dan carousel mandiri tanpa dependensi luar (kontrol keyboard panah/home/end dan tombol jeda/lanjut saat >1 slide aktif; statis bila 1 slide).
  2. Seksi Profil Perusahaan (`Section tone="light"`): Narasi komitmen EBT perusahaan dan 3 pilar rekayasa (PJU Mandiri, PLTS Residensial, Layanan Purna Jual) dengan tombol ke `/tentang-kami`.
  3. Grid Kategori Produk 4-up (`Section tone="soft"`): Kartu `ProductCard` untuk masing-masing kategori produk dengan tautan ke halaman kategori.
  4. Seksi Solusi Rekayasa EBT (`Section tone="light"`): Kartu `FeatureCard` dengan ornamen sudut hijau dan tautan ke detail arsitektur solusi.
  5. Seksi Statistik: Dilewati secara ketat (*skipped*) karena belum ada data riil dari CMS, mencegah fabrikasi angka bisnis.
  6. `cta-strip-dark`: Ajakan bertindak dengan headline `heading-xl` dan tombol primary mengarah ke `/kontak`.
- `frontend/src/routes/produk/+page.server.ts`: Server load function katalog produk yang membaca parameter query `kategori` dan `page`, memanggil `api.getProducts()` dan `api.getCategories()`.
- `frontend/src/routes/produk/+page.svelte`: Halaman katalog produk dengan `PillTabs` kategori ber-state URL (`?kategori=`), grid `ProductCard` (4-up desktop, 3-up 1024px, 2-up tablet, 1-up mobile), paginasi dinamis yang mempertahankan filter kategori, dan empty state ramah pengguna.
- `frontend/src/routes/produk/[category]/+page.server.ts`: Server load function kategori yang mengambil data kategori dan produk via `api.getCategory()`, memicu HTTP 404 jika kategori tidak ditemukan.
- `frontend/src/routes/produk/[category]/+page.svelte`: Halaman kategori produk dengan breadcrumb 3-tingkat, navigasi `SubNav`, header kategori dengan badge jumlah produk, grid `ProductCard`, dan Schema.org BreadcrumbList.
- `frontend/src/routes/produk/[category]/[slug]/+page.server.ts`: Server load function detail produk yang mengambil data produk via `api.getProduct()` dan produk terkait dalam kategori yang sama, memicu HTTP 404 jika slug tidak valid.
- `frontend/src/routes/produk/[category]/[slug]/+page.svelte`: Halaman lembar data teknis produk komprehensif memuat:
  1. Breadcrumb 4-tingkat dan metadata SEO spesifik.
  2. Galeri produk interaktif (gambar utama rasio aspek terjaga, thumbnail navigasi keyboard).
  3. Ringkasan produk dengan single `H1`, badge status/seri, dan deskripsi singkat.
  4. Aksi utama: CTA 'Minta Penawaran' ke `/kontak?produk=slug` dan tombol unduh datasheet PDF (`button-outline`).
  5. Bagian fitur dan deskripsi lengkap dari CMS.
  6. Tabel spesifikasi teknis bergaris hairline dengan baris selang-seling `surface-soft` yang dikelompokkan berdasarkan grup parameter.
  7. Grid produk terkait (up to 4 produk).
  8. Schema.org JSON-LD `Product` (tanpa field harga/offers jika tidak tersedia) dan `BreadcrumbList`.
- `frontend/src/routes/solusi/+page.server.ts`: Server load function yang memuat daftar solusi EBT via `api.getSolutions()`.
- `frontend/src/routes/solusi/+page.svelte`: Halaman katalog solusi dengan single `H1`, `SubNav`, grid `FeatureCard` (3-up desktop, 2-up tablet, 1-up mobile) berornamen sudut hijau, tahapan metodologi EPC, dan CTA strip ke `/kontak`.
- `frontend/src/routes/solusi/[slug]/+page.server.ts`: Server load function detail solusi yang mengambil data via `api.getSolution(slug)`, memicu HTTP 404 jika slug tidak ditemukan.
- `frontend/src/routes/solusi/[slug]/+page.svelte`: Halaman detail rekayasa sistem memuat badge tipe sistem, single `H1`, diagram alur arsitektur, penjelasan prinsip kerja sistem, daftar manfaat dengan ikon centang hijau, daftar bill of materials (BOM), produk terkait, dan CTA konsultasi ke `/kontak?solusi=slug`.
- `frontend/src/lib/components/ui/types.ts` & `frontend/src/lib/components/ui/Icon.svelte`: Penambahan nama ikon Lucide `play`, `pause`, `home`, `cpu`, `truck`, `package-open`.
- `frontend/static/images/`: Penambahan aset SVG placeholder terstandarisasi (`hero-placeholder.svg`, `hero-mobile-placeholder.svg` rasio 4:5, `product-pju-placeholder.svg`).
- `frontend/src/routes/page-loaders.test.ts`: 11 pengujian unit untuk seluruh server load function (keberhasilan pemuatan data, penanganan error 404, fallback downtime API, dan filter kategori query string).
- `frontend/src/routes/pages.test.ts`: 7 pengujian integrasi rendering komponen halaman beranda, katalog, detail produk, dan solusi.
- `docs/CHANGELOG-phases.md`: Pencatatan log kemajuan pekerjaan Fase 7.

### Status Quality Gate:
- [x] Beranda (`/`): `hero-card-dark` dengan art direction `<picture>` (16:9 desktop ke 4:5 mobile), copy di sepertiga kiri, kata kunci kuning pada headline, tombol CTA primary tunggal dan outline-on-dark, carousel mandiri (kontrol keyboard dan tombol jeda); seksi profil perusahaan; grid kategori 4-up; seksi solusi; callout-stat dilewati karena data riil CMS belum tersedia; cta-strip-dark menuju `/kontak`.
- [x] Ritme dark/light bergantian dengan jarak vertikal 64px (`section-padding`) tanpa pembatas dekoratif.
- [x] `/produk`: `PillTabs` kategori dengan state URL (`?kategori=`) yang server-rendered dan dapat dibagikan, grid 4-up `ProductCard`, paginasi ber-state, dan empty state.
- [x] `/produk/[kategori]` & `/produk/[kategori]/[slug]`: breadcrumb semantik; galeri dengan gambar utama dan thumbnail; ringkasan; fitur; tabel spesifikasi teknis hairline dengan baris selang-seling `surface-soft`; tombol unduh datasheet; CTA 'Minta Penawaran' ke `/kontak?produk=slug`; produk terkait; JSON-LD Product (tanpa harga) dan BreadcrumbList.
- [x] `/solusi` & `/solusi/[slug]`: daftar solusi (`FeatureCard`), detail dengan penjelasan arsitektur, manfaat, daftar komponen, produk terkait, dan CTA.
- [x] SEO setiap halaman menggunakan `SeoHead` dengan title unik (`%s | INDOGREEN`), deskripsi dari CMS, dan satu `H1` semantik per halaman.
- [x] Gambar: dimensi eksplisit `width` dan `height`, `loading="lazy"` kecuali hero (`loading="eager"` dan `fetchpriority="high"`), art direction responsif.
- [x] State loading, error, dan empty jelas; kegagalan API ditangani secara terstruktur dan tidak membuat aplikasi crash.
- [x] Seluruh 18 berkas pengujian Vitest (90 test cases) lulus hijau (100%).
- [x] Seluruh 69 pengujian Pest backend lulus hijau (100%, 505 assertions).
- [x] Pemeriksaan tipe `npm run check` (svelte-check) bersih: 0 error, 0 warning.
- [x] Pemeriksaan gaya kode dan linter `npm run lint` bersih: 0 error, 0 warning.
- [x] Build produksi SSR `npm run build` sukses tanpa galat.

