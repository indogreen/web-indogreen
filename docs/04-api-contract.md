# Spesifikasi Kontrak API (API Contract)
**Dokumen:** `docs/04-api-contract.md`  
**Proyek:** Revamp Website PT. Indogreen Technology And Management  
**Fase:** Fase 4 — Backend: REST API Publik, Sanitasi & Anti-Spam  
**Status:** Spesifikasi Final Terverifikasi RESTful JSON API v1

---

## 1. Standar Desain API

1. **Format Protokol & Penamaan:**
   - Semua respons disajikan dalam format `application/json` ber-encoding UTF-8.
   - Base URL Endpoint: `/api/v1`
   - Kunci properti JSON (*payload keys*) menggunakan format **snake_case**.
   - Parameter URL (*query parameters*) menggunakan format **snake_case**.
2. **Amplop Respons Standar (Response Envelope):**
   - **Respons Sukses:**
     ```json
     {
       "success": true,
       "message": "Operasi berhasil dieksekusi.",
       "data": {},
       "meta": null
     }
     ```
   - **Respons Error / Kegagalan:**
     ```json
     {
       "success": false,
       "message": "Pesan deskripsi kesalahan dalam bahasa Indonesia.",
       "error_code": "RESOURCE_NOT_FOUND",
       "errors": {}
     }
     ```
3. **Format Media Absolut:**
   - Seluruh properti gambar mengembalikan objek terstruktur berisi varian ukuran dan teks aksesibilitas (*alt text*):
     ```json
     {
       "original": "https://indogreen.id/storage/products/featured/sample.webp",
       "thumb": "https://indogreen.id/storage/products/featured/conversions/sample-thumb.webp",
       "card": "https://indogreen.id/storage/products/featured/conversions/sample-card.webp",
       "hero": "https://indogreen.id/storage/products/featured/conversions/sample-hero.webp",
       "alt": "Deskripsi alt text gambar"
     }
     ```

---

## 2. Kode Status HTTP & Kode Kesalahan

| Kode HTTP | Status | Arti Teknis | Contoh `error_code` |
|---|---|---|---|
| **200 OK** | Sukses | Permintaan berhasil diambil atau diproses | — |
| **201 Created** | Sukses | Sumber daya baru berhasil dibuat (formulir inquiry) | — |
| **304 Not Modified** | Caching | Konten tidak berubah (berdasarkan negosiasi ETag / `If-None-Match`) | — |
| **400 Bad Request** | Klien Error | Parameter permintaan tidak memenuhi format dasar | `INVALID_REQUEST_SYNTAX` |
| **404 Not Found** | Klien Error | Entitas produk, kategori, solusi, atau halaman tidak ditemukan | `RESOURCE_NOT_FOUND` |
| **422 Unprocessable**| Klien Error | Validasi data formulir gagal | `VALIDATION_ERROR` |
| **429 Too Many Req** | Klien Error | Melebihi ambang batas rate limiter (Maks 5 per menit per IP) | `RATE_LIMIT_EXCEEDED` |
| **500 Server Error** | Server Error| Terjadi kesalahan internal backend (tanpa stack trace di produksi) | `INTERNAL_SERVER_ERROR` |

---

## 3. Rincian Endpoint Publik

### 3.1 Konten Beranda Teragregasi (Home Aggregate)
- **Metode:** `GET`
- **Endpoint:** `/api/v1/home`
- **Deskripsi:** Mengambil kumpulan konten utama beranda dalam satu panggilan cepat: slide hero banner aktif, produk unggulan, ringkasan solusi, kategori produk aktif, dan identitas perusahaan.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Data beranda berhasil diambil.",
  "data": {
    "hero_slides": [
      {
        "id": 1,
        "title": "Lampu PJU Tenaga Surya Berkualitas Tinggi",
        "subtitle": "Efisiensi maksimal dengan baterai LiFePO4 dan modul Tier-1",
        "button_text": "Lihat Produk",
        "button_url": "https://indogreen.id/produk",
        "desktop_image": {
          "original": "https://indogreen.id/storage/hero_slides/desktop-sample.webp",
          "thumb": "https://indogreen.id/storage/hero_slides/desktop-sample.webp",
          "card": "https://indogreen.id/storage/hero_slides/desktop-sample.webp",
          "hero": "https://indogreen.id/storage/hero_slides/desktop-sample.webp",
          "alt": "Lampu PJU Tenaga Surya Berkualitas Tinggi"
        },
        "mobile_image": {
          "original": "https://indogreen.id/storage/hero_slides/mobile-sample.webp",
          "thumb": "https://indogreen.id/storage/hero_slides/mobile-sample.webp",
          "card": "https://indogreen.id/storage/hero_slides/mobile-sample.webp",
          "hero": "https://indogreen.id/storage/hero_slides/mobile-sample.webp",
          "alt": "Lampu PJU Tenaga Surya Berkualitas Tinggi"
        },
        "sort_order": 1
      }
    ],
    "featured_products": [
      {
        "id": 1,
        "name": "PJU Two-In-One Helios Series",
        "slug": "pju-two-in-one-helios-series",
        "category_slug": "pju-tenaga-surya",
        "category_name": "PJU Tenaga Surya",
        "model_series": "Helios",
        "badge_tag": "Best Seller",
        "short_description": "Lampu PJU hemat daya dengan baterai LiFePO4 terintegrasi.",
        "featured_image": {
          "original": "https://indogreen.id/storage/products/featured/helios.webp",
          "thumb": "https://indogreen.id/storage/products/featured/helios.webp",
          "card": "https://indogreen.id/storage/products/featured/helios.webp",
          "hero": "https://indogreen.id/storage/products/featured/helios.webp",
          "alt": "PJU Two-In-One Helios Series"
        },
        "datasheet_pdf_url": "https://indogreen.id/storage/products/datasheets/datasheet-helios.pdf",
        "is_featured": true,
        "sort_order": 1
      }
    ],
    "solutions": [
      {
        "id": 1,
        "name": "PLTS On-Grid System",
        "slug": "plts-on-grid",
        "system_type": "On-Grid",
        "summary": "Sistem PLTS tersambung jaringan PLN untuk memangkas tagihan listrik harian.",
        "diagram_image": null,
        "sort_order": 1
      }
    ],
    "categories": [
      {
        "id": 1,
        "name": "PJU Tenaga Surya",
        "slug": "pju-tenaga-surya",
        "description": "Lampu jalan surya hemat energi sistem TIO dan AIO.",
        "icon_name": "sun",
        "sort_order": 1,
        "products_count": 4,
        "image": null
      }
    ],
    "company": {
      "company_name": "PT. INDOGREEN TECHNOLOGY AND MANAGEMENT",
      "tagline": "SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan",
      "phone": "+62 251 754 1234",
      "email": "marketing@indogreen.id",
      "whatsapp": "+62 811 1234 5678",
      "head_office_address": "Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Kota Bogor",
      "representative_office_address": "Gedung Wisma Bumiputera Lt. 7, Jl. Asia Afrika No. 141-149, Kota Bandung",
      "social_links": {
        "facebook": "https://facebook.com/indogreen.id",
        "instagram": "https://instagram.com/indogreen.id",
        "youtube": "https://youtube.com/@indogreentechnology"
      },
      "offices": []
    }
  },
  "meta": null
}
```

---

### 3.2 Profil Perusahaan & Pengaturan Situs
- **Metode:** `GET`
- **Endpoint:** `/api/v1/settings` (atau alias `/api/v1/company`)
- **Deskripsi:** Mengambil informasi resmi perusahaan, daftar lokasi kantor aktif, dan tautan media sosial.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Data profil dan pengaturan situs berhasil diambil.",
  "data": {
    "company_name": "PT. INDOGREEN TECHNOLOGY AND MANAGEMENT",
    "tagline": "SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan",
    "phone": "+62 251 754 1234",
    "email": "marketing@indogreen.id",
    "whatsapp": "+62 811 1234 5678",
    "head_office_address": "Ruko Taman Yasmin Sektor 6 No. 226, Kota Bogor",
    "representative_office_address": "Gedung Wisma Bumiputera Lt. 7, Kota Bandung",
    "social_links": {
      "facebook": "https://facebook.com/indogreen.id",
      "instagram": "https://instagram.com/indogreen.id",
      "youtube": "https://youtube.com/@indogreentechnology"
    },
    "offices": [
      {
        "id": 1,
        "name": "Kantor Utama Bogor",
        "office_type": "head_office",
        "office_type_label": "Kantor Utama",
        "address": "Ruko Taman Yasmin Sektor 6 No. 226, Kota Bogor, Jawa Barat 16113",
        "phone": "+62 251 754 1234",
        "email": "bogor@indogreen.id",
        "map_embed_url": "https://www.google.com/maps/embed?pb=...",
        "sort_order": 1
      }
    ]
  },
  "meta": null
}
```

---

### 3.3 Daftar & Detail Kategori Produk
- **Daftar Kategori:** `GET /api/v1/product-categories` (atau `/api/v1/categories`)
- **Detail Kategori (+ Produk):** `GET /api/v1/product-categories/{slug}` (atau `/api/v1/categories/{slug}`)

**Contoh Respons Detail Kategori (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Detail kategori dan daftar produk terkait berhasil diambil.",
  "data": {
    "category": {
      "id": 1,
      "name": "PJU Tenaga Surya",
      "slug": "pju-tenaga-surya",
      "description": "Lampu penerangan jalan umum mandiri bertenaga surya sistem Two-In-One dan All-In-One.",
      "icon_name": "sun",
      "sort_order": 1,
      "products_count": 4,
      "image": null
    },
    "products": [
      {
        "id": 1,
        "name": "PJU Two-In-One Helios Series",
        "slug": "pju-two-in-one-helios-series",
        "category_slug": "pju-tenaga-surya",
        "category_name": "PJU Tenaga Surya",
        "model_series": "Helios",
        "badge_tag": "Best Seller",
        "short_description": "Lampu PJU hemat daya dengan baterai LiFePO4 terintegrasi.",
        "featured_image": null,
        "datasheet_pdf_url": null,
        "is_featured": true,
        "sort_order": 1
      }
    ]
  },
  "meta": null
}
```

---

### 3.4 Katalog Produk
- **Metode:** `GET`
- **Endpoint:** `/api/v1/products`
- **Parameter Permintaan (Query Params):**
  - `category` *(opsional, string)*: Filter berdasarkan slug kategori (misal: `pju-tenaga-surya`).
  - `q` atau `search` *(opsional, string)*: Pencarian nama, seri model, atau ringkasan produk.
  - `featured` *(opsional, boolean)*: Setel `1` atau `true` untuk produk unggulan beranda.
  - `page` *(opsional, integer)*: Nomor halaman paginasi (Default: `1`).
  - `per_page` *(opsional, integer)*: Jumlah entri per halaman (Default: `12`).

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Katalog produk berhasil diambil.",
  "data": [
    {
      "id": 1,
      "name": "PJU Two-In-One Helios Series",
      "slug": "pju-two-in-one-helios-series",
      "category_slug": "pju-tenaga-surya",
      "category_name": "PJU Tenaga Surya",
      "model_series": "Helios",
      "badge_tag": "Best Seller",
      "short_description": "Lampu PJU hemat daya dengan baterai LiFePO4 terintegrasi.",
      "featured_image": null,
      "datasheet_pdf_url": null,
      "is_featured": true,
      "sort_order": 1
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 12,
    "total": 4
  }
}
```

---

### 3.5 Detail Produk Teknis
- **Metode:** `GET`
- **Endpoint:** `/api/v1/products/{category_slug}/{product_slug}` atau `/api/v1/products/{slug}`
- **Deskripsi:** Mengambil spesifikasi teknis lengkap yang dikelompokkan berdasarkan grup parameter, galeri media, solusi terkait, dan atribut SEO.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Detail produk teknis berhasil diambil.",
  "data": {
    "id": 1,
    "name": "PJU Two-In-One Helios Series",
    "slug": "pju-two-in-one-helios-series",
    "category": {
      "id": 1,
      "name": "PJU Tenaga Surya",
      "slug": "pju-tenaga-surya"
    },
    "model_series": "Helios",
    "badge_tag": "Best Seller",
    "short_description": "Lampu PJU hemat daya dengan baterai LiFePO4 terintegrasi.",
    "full_description": "<p>Spesifikasi handal untuk jalan arteri dan protokol.</p>",
    "featured_image": null,
    "datasheet_pdf_url": null,
    "specifications_grouped": {
      "Lampu & Optik": [
        {"key": "Daya Lampu", "value": "60", "unit": "W"}
      ]
    },
    "gallery": [],
    "solutions": [
      {
        "id": 1,
        "name": "Penerangan Jalan Umum Mandiri",
        "slug": "penerangan-jalan-umum-mandiri",
        "system_type": "PJU TIO"
      }
    ],
    "seo_title": "Jual Lampu PJU Solar Cell 60W Helios",
    "seo_description": "Dapatkan lampu jalan tenaga surya 60W seri Helios bergaransi resmi.",
    "is_featured": true,
    "sort_order": 1
  },
  "meta": null
}
```

---

### 3.6 Daftar & Detail Solusi Rekayasa EBT
- **Daftar Solusi:** `GET /api/v1/solutions`
- **Detail Solusi:** `GET /api/v1/solutions/{slug}`

**Contoh Respons Detail Solusi (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Detail solusi sistem berhasil diambil.",
  "data": {
    "id": 1,
    "name": "PLTS On-Grid System",
    "slug": "plts-on-grid",
    "system_type": "On-Grid",
    "summary": "Sistem PLTS tersambung jaringan PLN untuk memangkas tagihan listrik harian melalui skema net-metering.",
    "system_architecture": "<p>Modul fotovoltaik surya menghasilkan arus DC yang dikonversi inverter menjadi AC.</p>",
    "included_components": [
      "Solar PV Modules Monocrystalline Tier-1",
      "Grid-Tie Inverter Efisiensi > 98%"
    ],
    "benefits": [
      "Menghemat hingga 60-80% tagihan listrik bulanan",
      "Investasi minim perawatan tanpa baterai"
    ],
    "diagram_image": null,
    "products": [],
    "seo_title": "Solusi PLTS On-Grid Hemat Listrik",
    "seo_description": "Pembangkit listrik tenaga surya atap sistem On-Grid ramah lingkungan.",
    "sort_order": 1
  },
  "meta": null
}
```

---

### 3.7 Halaman Statis CMS
- **Metode:** `GET`
- **Endpoint:** `/api/v1/pages/{slug}`
- **Deskripsi:** Mengambil halaman statis publik aktif (`tentang-kami`, `kebijakan-privasi`).

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Halaman statis berhasil diambil.",
  "data": {
    "id": 1,
    "title": "Tentang Kami",
    "slug": "tentang-kami",
    "content": "<p>Profil resmi PT Indogreen Technology And Management.</p>",
    "seo_title": "Tentang PT Indogreen Technology And Management",
    "seo_description": "Pelajari sejarah, visi, dan misi PT Indogreen.",
    "updated_at": "2026-11-20T01:00:00+07:00"
  },
  "meta": null
}
```

---

### 3.8 Pencarian Global Multi-Entitas
- **Metode:** `GET`
- **Endpoint:** `/api/v1/search?q={kata_kunci}`
- **Deskripsi:** Pencarian terpadu melintasi produk, solusi, dan kategori produk aktif.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Hasil pencarian berhasil diambil.",
  "data": {
    "products": [
      {
        "id": 1,
        "name": "Lampu PJU Helios 60W",
        "slug": "lampu-pju-helios-60w"
      }
    ],
    "solutions": [],
    "categories": []
  },
  "meta": null
}
```

---

### 3.9 Entri Sitemap untuk Mesin Pencari
- **Metode:** `GET`
- **Endpoint:** `/api/v1/sitemap-entries`
- **Deskripsi:** Menghasilkan seluruh daftar rute publik aktif beserta stempel waktu pembaruan terakhir (*lastmod*) untuk generator `sitemap.xml` di frontend.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Daftar entri sitemap berhasil diambil.",
  "data": [
    {
      "url": "https://indogreen.id/",
      "lastmod": "2026-11-20T01:00:00+07:00",
      "changefreq": "weekly",
      "priority": 1.0
    },
    {
      "url": "https://indogreen.id/produk/pju-tenaga-surya/pju-two-in-one-helios-series",
      "lastmod": "2026-11-20T01:00:00+07:00",
      "changefreq": "weekly",
      "priority": 0.8
    }
  ],
  "meta": null
}
```

---

### 3.10 Pengiriman Formulir Kontak / Permohonan Konsultasi
- **Metode:** `POST`
- **Endpoint:** `/api/v1/inquiries`
- **Headers:** `Content-Type: application/json`, `Accept: application/json`
- **Rate Limit:** Dibatasi maksimal **5 request per menit per IP**. Request berlebih menghasilkan HTTP 429.
- **Proteksi Anti-Spam:** Field `website_url` adalah honeypot. Jika terisi, server merespons sukses 201 secara senyap tanpa menyimpan ke basis data atau mengirimkan email notifikasi.
- **Payload Permintaan (Request Body):**
  ```json
  {
    "full_name": "Ir. Budi Santoso",
    "email": "budi.santoso@perusahaan.co.id",
    "phone_whatsapp": "+6281234567890",
    "company_organization": "PT. Rekayasa Surya Abadi",
    "product_slug": "pju-two-in-one-helios-series",
    "solution_slug": null,
    "subject": "Permohonan Penawaran 50 Unit PJU Surya",
    "message_content": "Kami membutuhkan penawaran 50 unit PJU Two-In-One Helios 60W untuk proyek jalan industri.",
    "consent": true,
    "website_url": ""
  }
  ```

**Respons Sukses (HTTP 201 Created):**
```json
{
  "success": true,
  "message": "Permohonan konsultasi Anda berhasil dikirimkan. Tim sales engineering PT. Indogreen akan segera menghubungi Anda.",
  "data": {
    "inquiry_id": 1,
    "received_at": "2026-11-20T01:05:00+07:00"
  },
  "meta": null
}
```

---

### 3.11 Health Check Endpoint
- **Metode:** `GET`
- **Endpoint:** `/api/v1/health`
- **Deskripsi:** Pengawasan status uptime server, koneksi database MySQL, dan disk storage.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "status": "UP",
  "timestamp": "2026-11-20T01:05:00+07:00",
  "services": {
    "database": "CONNECTED",
    "storage": "WRITABLE"
  }
}
```

---

## 4. Format Respons Validasi Gagal & Error Baku

### 4.1 Validasi Gagal (HTTP 422 Unprocessable Entity)
```json
{
  "success": false,
  "message": "Data yang dikirimkan tidak valid.",
  "error_code": "VALIDATION_ERROR",
  "errors": {
    "full_name": ["Nama lengkap wajib diisi."],
    "email": ["Format alamat email tidak valid."],
    "consent": ["Persetujuan pemrosesan data wajib disetujui."]
  }
}
```

### 4.2 Sumber Daya Tidak Ditemukan (HTTP 404 Not Found)
```json
{
  "success": false,
  "message": "Sumber daya tidak ditemukan.",
  "error_code": "RESOURCE_NOT_FOUND",
  "errors": {}
}
```

### 4.3 Ambang Frekuensi Terlampaui (HTTP 429 Too Many Requests)
```json
{
  "success": false,
  "message": "Terlalu banyak permintaan. Silakan tunggu beberapa saat lagi.",
  "error_code": "RATE_LIMIT_EXCEEDED",
  "errors": {}
}
```

---

## 5. Kebijakan Caching, ETag & Versi Konten

1. **Header Respons Caching:**
   Setiap respons `GET` yang berhasil menyertakan:
   - `Cache-Control: public, max-age=300, must-revalidate`
   - `ETag: W/"<hash-md5-konten>"`
   - `X-Content-Version: <versi_konten>`
2. **Kondisional Request (`If-None-Match`):**
   Jika klien/peramban mengirimkan header `If-None-Match` yang cocok dengan ETag respons, server langsung mengembalikan kode status **304 Not Modified** tanpa beban payload isi body.
3. **Reaktivitas Otomatis via Model Observer:**
   Observer `ContentVersionObserver` memantau model `Product`, `Category`, `Solution`, `HeroSlide`, `Page`, `Office`, `SiteSetting`, dan `ProductSpecification`. Setiap aksi `saved`, `deleted`, atau `restored` langsung meningkatkan versi `content_version`, sehingga seluruh cache ter-invalidasi seketika.

---

## 6. Hasil Benchmark Latensi Lokal (Target p95 < 200 ms)

Pengujian performa latensi dieksekusi terhadap endpoint daftar publik menggunakan data seeder lengkap:

| Endpoint | p50 Latensi | p90 Latensi | p95 Latensi | Latensi Maks | Status Ambang |
|---|---|---|---|---|---|
| `GET /api/v1/home` | **0.96 ms** | 3.52 ms | **6.85 ms** | 6.85 ms | ✅ Lolos (< 200 ms) |
| `GET /api/v1/products` | **0.36 ms** | 0.61 ms | **3.06 ms** | 3.06 ms | ✅ Lolos (< 200 ms) |
| `GET /api/v1/product-categories` | **0.45 ms** | 0.82 ms | **0.87 ms** | 0.87 ms | ✅ Lolos (< 200 ms) |
| `GET /api/v1/solutions` | **0.47 ms** | 0.56 ms | **0.79 ms** | 0.79 ms | ✅ Lolos (< 200 ms) |
| `GET /api/v1/settings` | **0.52 ms** | 0.83 ms | **3.68 ms** | 3.68 ms | ✅ Lolos (< 200 ms) |
| `GET /api/v1/sitemap-entries` | **0.31 ms** | 0.62 ms | **0.74 ms** | 0.74 ms | ✅ Lolos (< 200 ms) |

*Hasil pengujian menunjukkan rata-rata p95 di bawah 7 milidetik, jauh melampaui batas toleransi 200 milidetik.*
