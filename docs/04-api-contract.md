# Spesifikasi Kontrak API (API Contract)
**Dokumen:** `docs/04-api-contract.md`  
**Proyek:** Revamp Website PT. Indogreen Technology And Management  
**Fase:** Fase 1 — Fondasi Monorepo & Dokumen Arsitektur  
**Status:** Draf Standarisasi RESTful JSON API v1

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

---

## 2. Kode Status HTTP & Kode Kesalahan

| Kode HTTP | Status | Arti Teknis | Contoh `error_code` |
|---|---|---|---|
| **200 OK** | Sukses | Permintaan berhasil diambil atau diperbarui | — |
| **201 Created** | Sukses | Sumber daya baru berhasil dibuat (misal: formulir inquiry) | — |
| **400 Bad Request** | Klien Error | Parameter permintaan tidak memenuhi format dasar | `INVALID_REQUEST_SYNTAX` |
| **404 Not Found** | Klien Error | Entitas produk, kategori, atau solusi tidak ditemukan | `RESOURCE_NOT_FOUND` |
| **422 Unprocessable**| Klien Error | Validasi data formulir gagal | `VALIDATION_ERROR` |
| **429 Too Many Req** | Klien Error | Melebihi batas ambang frekuensi kirim (Rate limit) | `RATE_LIMIT_EXCEEDED` |
| **500 Server Error** | Server Error| Terjadi kesalahan internal pada backend | `INTERNAL_SERVER_ERROR` |

---

## 3. Rincian Endpoint Publik

### 3.1 Profil Perusahaan & Kontak Global
- **Metode:** `GET`
- **Endpoint:** `/api/v1/company`
- **Deskripsi:** Mengambil informasi umum perusahaan, kontak kantor Bogor & Jakarta, tautan sosial media, dan jam operasional untuk komponen `utility-bar` dan `footer-section`.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Data profil perusahaan berhasil diambil.",
  "data": {
    "company_name": "PT. INDOGREEN TECHNOLOGY AND MANAGEMENT",
    "tagline": "Energi Bersih untuk Masa Depan Berkelanjutan",
    "email": "support@indogreen.id",
    "phone": "+62-251-7541749",
    "whatsapp_hotline": "+62-812-0000-0000",
    "working_hours": "Senin - Jumat 08.30 - 17.00 WIB",
    "offices": [
      {
        "type": "Head Office",
        "name": "Kantor Pusat Bogor",
        "address": "Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Bogor Barat, Kota Bogor, Jawa Barat 16113",
        "phone": "+62-251-7541749",
        "coordinates": {
          "lat": -6.5583,
          "lng": 106.7725
        }
      },
      {
        "type": "Representative Office",
        "name": "Kantor Perwakilan Jakarta",
        "address": "Gedung Gandaria 8 Lantai 9, Gandaria City, Jl. Sultan Iskandar Muda, Kebayoran Lama, Jakarta Selatan 12240",
        "phone": "+62-251-7541749",
        "coordinates": {
          "lat": -6.2444,
          "lng": 106.7836
        }
      }
    ],
    "social_links": {
      "facebook": "https://facebook.com/IndogreenMarketing",
      "instagram": "https://www.instagram.com/indogreen_solar",
      "youtube": "https://youtube.com/playlist?list=PLWVVoZic9QLqikef7Rcrt9PlGgA4drenx"
    }
  }
}
```

---

### 3.2 Daftar Kategori Produk
- **Metode:** `GET`
- **Endpoint:** `/api/v1/categories`
- **Deskripsi:** Mengambil seluruh kategori produk aktif untuk navigasi header dan filter `sub-nav-strip`.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Daftar kategori berhasil diambil.",
  "data": [
    {
      "id": 1,
      "name": "PJU Tenaga Surya",
      "slug": "pju-tenaga-surya",
      "description": "Lampu penerangan jalan umum mandiri bertenaga surya sistem Two-in-One dan All-in-One.",
      "icon_name": "sun-dim",
      "products_count": 4
    },
    {
      "id": 2,
      "name": "PLTS Residensial",
      "slug": "plts-residential",
      "description": "Pembangkit listrik tenaga surya atap (rooftop) untuk hunian perumahan.",
      "icon_name": "home",
      "products_count": 0
    }
  ]
}
```

---

### 3.3 Katalog Produk
- **Metode:** `GET`
- **Endpoint:** `/api/v1/products`
- **Parameter Permintaan (Query Params):**
  - `category` *(opsional, string)*: Filter berdasarkan slug kategori (misal: `pju-tenaga-surya`).
  - `featured` *(opsional, boolean)*: Setel `1` untuk mengambil produk unggulan beranda.
  - `search` *(opsional, string)*: Pencarian nama seri produk.
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
      "model_series": "TIO-HELIOS",
      "badge_tag": "POPULAR",
      "short_description": "Lampu PJU surya Two-In-One efisiensi tinggi dengan baterai LiFePO4 dan modul terpisah.",
      "featured_image_url": "https://indogreen.id/storage/products/tio-helios.webp",
      "datasheet_url": "https://indogreen.id/storage/datasheets/datasheet-tio-helios.pdf"
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

### 3.4 Detail Produk Teknis
- **Metode:** `GET`
- **Endpoint:** `/api/v1/products/{category_slug}/{product_slug}`
- **Deskripsi:** Mengambil detail lengkap spesifikasi produk teknis, galeri gambar, dan berkas datasheet PDF.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Detail produk berhasil diambil.",
  "data": {
    "id": 1,
    "name": "PJU Two-In-One Helios Series",
    "slug": "pju-two-in-one-helios-series",
    "category": {
      "name": "PJU Tenaga Surya",
      "slug": "pju-tenaga-surya"
    },
    "model_series": "TIO-HELIOS",
    "badge_tag": "TIO",
    "short_description": "Lampu PJU surya Two-In-One efisiensi tinggi dengan baterai LiFePO4 dan modul terpisah.",
    "full_description": "PJU Tenaga Surya Helios Series Two-in-One dirancang untuk jalan arteri, jalan kawasan industri, dan jalan perumahan. Menggunakan chip LED berefisiensi tinggi dengan kontrol cerdas peredupan otomatis untuk menghemat energi sepanjang malam.",
    "featured_image_url": "https://indogreen.id/storage/products/tio-helios.webp",
    "datasheet_pdf_url": "https://indogreen.id/storage/datasheets/datasheet-tio-helios.pdf",
    "specifications_grouped": {
      "Optikal & Elektrikal": [
        {"key": "Daya Lampu", "value": "60 / 80 / 100 / 120", "unit": "Watt"},
        {"key": "Fluks Cahaya", "value": "160 - 180", "unit": "lm/W"},
        {"key": "Temperatur Warna", "value": "5700 - 6500", "unit": "Kelvin"}
      ],
      "Sistem Penyimpan & Panel": [
        {"key": "Tipe Panel Surya", "value": "Monocrystalline", "unit": null},
        {"key": "Kapasitas Panel", "value": "100 - 180", "unit": "Wp"},
        {"key": "Tipe Baterai", "value": "LiFePO4", "unit": null},
        {"key": "Kapasitas Baterai", "value": "12.8V / 40 - 80", "unit": "Ah"}
      ],
      "Mekanikal & Proteksi": [
        {"key": "Tingkat Proteksi", "value": "IP66", "unit": null},
        {"key": "Tinggi Tiang Rekomendasi", "value": "7 - 9", "unit": "Meter"}
      ]
    }
  }
}
```

---

### 3.5 Daftar & Detail Solusi Rekayasa EBT
- **Daftar Solusi:** `GET /api/v1/solutions`
- **Detail Solusi:** `GET /api/v1/solutions/{slug}`

**Contoh Respons Detail Solusi (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Detail solusi berhasil diambil.",
  "data": {
    "id": 1,
    "name": "PLTS On-Grid System",
    "slug": "plts-on-grid",
    "system_type": "On-Grid",
    "summary": "Sistem PLTS tersambung jaringan PLN untuk memangkas tagihan listrik harian melalui skema net-metering.",
    "system_architecture": "Modul fotovoltaik surya menghasilkan arus searah (DC) yang dikonversi oleh grid-tie inverter menjadi arus bolak-balik (AC) sinkron dengan tegangan jaringan PLN.",
    "included_components": [
      "Solar PV Modules Monocrystalline Tier-1",
      "Grid-Tie Inverter dengan Efisiensi > 98%",
      "Smart Metering & Monitoring System",
      "Kombiner Box DC/AC & Surge Protection Device (SPD)"
    ],
    "benefits": [
      "Menghemat hingga 60-80% tagihan listrik bulanan",
      "Investasi minim perawatan tanpa baterai",
      "Pengurangan jejak karbon korporat (ESG compliance)"
    ],
    "diagram_image_url": "https://indogreen.id/storage/solutions/on-grid-diagram.svg"
  }
}
```

---

### 3.6 Pengiriman Formulir Kontak / Permohonan Konsultasi
- **Metode:** `POST`
- **Endpoint:** `/api/v1/inquiries`
- **Headers:** `Content-Type: application/json`, `Accept: application/json`
- **Payload Request:**
  ```json
  {
    "full_name": "Ir. Budi Santoso",
    "email": "budi.santoso@perusahaan.co.id",
    "phone_whatsapp": "081234567890",
    "company_organization": "PT. Rekayasa Surya Abadi",
    "product_id": 1,
    "solution_id": null,
    "subject": "Permohonan Penawaran PJU Surya Proyek Jalan Tol",
    "message_content": "Kami membutuhkan penawaran 150 unit PJU Two-In-One kapasitas 80W untuk proyek jalan tol seksi 3.",
    "website_url": ""
  }
  ```
  *(Catatan: Field `website_url` adalah honeypot anti-spam. Wajib dikosongkan oleh browser manusia).*

**Respons Sukses (HTTP 201 Created):**
```json
{
  "success": true,
  "message": "Permohonan konsultasi Anda berhasil dikirimkan. Tim sales engineering PT. Indogreen akan segera menghubungi Anda.",
  "data": {
    "inquiry_id": 1024,
    "received_at": "2026-11-19T17:15:00Z"
  }
}
```

---

## 4. Format Respons Validasi Gagal (HTTP 422 Unprocessable Entity)

Jika data masukan yang dikirimkan klien tidak memenuhi aturan validasi Laravel FormRequest, backend akan mengembalikan format baku berikut:

```json
{
  "success": false,
  "message": "Data yang dikirimkan tidak valid. Silakan periksa kembali isian formulir Anda.",
  "error_code": "VALIDATION_ERROR",
  "errors": {
    "full_name": [
      "Nama lengkap wajib diisi."
    ],
    "email": [
      "Format alamat email tidak valid."
    ],
    "phone_whatsapp": [
      "Nomor kontak WhatsApp wajib diisi.",
      "Nomor kontak harus berupa format nomor telepon yang valid."
    ],
    "message_content": [
      "Pesan kebutuhan teknis minimal berisi 10 karakter."
    ]
  }
}
```

---

## 5. Health Check Endpoint
- **Metode:** `GET`
- **Endpoint:** `/api/v1/health`
- **Deskripsi:** Endpoint pengawasan uptime untuk memantau status server, konektivitas database MySQL, dan disk storage.

**Contoh Respons (HTTP 200 OK):**
```json
{
  "success": true,
  "status": "UP",
  "timestamp": "2026-11-19T17:15:00Z",
  "services": {
    "database": "CONNECTED",
    "storage": "WRITABLE"
  }
}
```
