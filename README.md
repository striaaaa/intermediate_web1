# 🌿 Portal Sekretaris & Sistem Informasi Geografis (GIS)
**Koperasi Konsumen Desa Peduli Buruh Migran Indramayu (Migrant CARE)**

Aplikasi berbasis **Laravel 12** & **Filament v5** yang mengintegrasikan **Portal Administrasi Sekretaris Koperasi** (dengan desain Bento UI *Plus Jakarta Sans* & *Emerald Theme*) serta **Sistem Informasi Geografis (GIS) Interaktif** menggunakan **Leaflet.js & OpenStreetMap** untuk pemetaan jaringan Kantor Operasional, Posko Layanan DESBUMI, dan Rumah Aman Buruh Migran di wilayah **Indramayu** dan **DKI Jakarta**.

---

## 🔐 Akun Login Admin / Sekretaris (Filament Panel)

Gunakan kredensial berikut untuk masuk ke dalam Portal Sekretaris:

| Field | Kredensial |
| :--- | :--- |
| **URL Login** | `http://127.0.0.1:8000/admin/login` *(atau port server yang aktif, misal `:5555`)* |
| **Email** | `satriasahrul2@gmail.com` |
| **Password** | `12345678` |
| **Role / Jabatan** | Sekretaris Koperasi |

---

## 🧭 Daftar Routing & URL untuk Pengecekan Fitur

Berikut adalah daftar route/halaman yang dapat langsung diakses untuk menguji seluruh fitur praktikum dan pengembangan proyek:

### 1. Halaman Utama & Peta GIS Publik/Interaktif
| Method | Route / Path | Contoh URL Lokal | Keterangan Fitur |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | `http://127.0.0.1:8000/` | Otomatis mengarahkan (*redirect*) ke Dashboard Portal Sekretaris (`/admin`) |
| `GET` | `/peta` | `http://127.0.0.1:8000/peta` | **Halaman Utama Peta GIS Interaktif**: Menampilkan sebaran Kantor & Posko Migrant CARE (Indramayu & Jakarta), Filter Wilayah, Pencarian Lokasi, Poligon Area Dampingan, fitur **🎯 Posko Terdekat (Rumus Haversine)**, serta mode **📍 + Tambah via Pin-Point Langsung** |
| `GET` | `/peta?lat={lat}&lng={lng}` | `http://127.0.0.1:8000/peta?lat=-6.4633&lng=108.4528` | Membuka peta dan langsung memfokuskan kamera serta popup ke titik koordinat kantor/posko tertentu |
| `POST` | `/peta` | `http://127.0.0.1:8000/peta` | Endpoint penyimpanan titik lokasi baru secara langsung dari mode **Pin-Point** pada halaman `/peta` |

### 2. Halaman Panel Pengurus / Sekretaris (Filament v5)
| Method | Route / Path | Contoh URL Lokal | Keterangan Fitur |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin/login` | `http://127.0.0.1:8000/admin/login` | Halaman autentikasi pengurus (Sekretaris) |
| `GET` | `/admin` | `http://127.0.0.1:8000/admin` | **Bento Dashboard Eksekutif Sekretaris**: Ringkasan Simpanan Pokok, Pratinjau Peta GIS Live, Status Verifikasi Berkas KTP, Avatar Stack Anggota, & Tabel Antrean Terbaru |
| `GET` | `/admin/members` | `http://127.0.0.1:8000/admin/members` | **Verifikasi & Buku Anggota Koperasi**: Daftar calon anggota & anggota sah, filter status verifikasi, aksi cepat *Setujui Berkas (Sekretaris)* dan *Aktivasi Lunas* |
| `GET` | `/admin/members/create` | `http://127.0.0.1:8000/admin/members/create` | Form input pendaftaran calon anggota baru (validasi NIK 16 digit sesuai KTP) |
| `GET` | `/admin/members/{id}/edit` | `http://127.0.0.1:8000/admin/members/1/edit` | Halaman pemeriksaan & pembaruan status verifikasi berkas anggota |
| `GET` | `/admin/branches` | `http://127.0.0.1:8000/admin/branches` | **Manajemen Kantor & Posko GIS**: Tabel direktori titik lokasi Migrant CARE beserta tombol aksi cepat **Lihat GIS** |
| `GET` | `/admin/branches/create` | `http://127.0.0.1:8000/admin/branches/create` | **Form Tambah Lokasi dengan Interactive Pin-Point Map Picker**: Klik titik di peta atau cari nama desa/jalan $\rightarrow$ `Latitude`, `Longitude`, dan `Alamat Lengkap` terisi secara otomatis (*Reverse Geocoding*) |
| `GET` | `/admin/branches/{id}/edit` | `http://127.0.0.1:8000/admin/branches/1/edit` | Edit data kantor/posko dan geser titik pin koordinat langsung di atas peta |

---

## ✨ Fitur Unggulan

1. **Interactive GIS Pin-Point Picker (Auto-Fill Latitude, Longitude & Alamat)**
   * Tersedia di halaman `/admin/branches/create`, `/admin/branches/{id}/edit`, maupun langsung di `/peta`.
   * Cukup klik titik mana saja di peta atau geser marker, maka nilai **Latitude**, **Longitude**, dan **Alamat Lengkap Jalan/Desa** (melalui *OpenStreetMap Nominatim Reverse Geocoding*) otomatis terisi tanpa perlu mengetik manual.
2. **Pemetaan Nyata Jaringan Migrant CARE (Indramayu & DKI Jakarta)**
   * **Kantor Operasional Koperasi Indramayu** — Karangampel, Indramayu (`-6.4633000, 108.4528000`)
   * **Sekretariat Nasional Migrant CARE Jakarta** — Pancoran, Jakarta Selatan (`-6.2514000, 106.8315000`)
   * **Posko Layanan & Advokasi DESBUMI Juntinyuat** — Desa Juntinyuat, Indramayu (`-6.3980000, 108.4350000`)
   * **Posko Perlindungan Komunitas PMI Krangkeng** — Krangkeng, Indramayu (`-6.5120000, 108.5020000`)
   * **Rumah Aman & Konseling PMI Rawajati** — Kalibata, Jakarta Selatan (`-6.2580000, 106.8550000`)
3. **Pencarian Posko Terdekat (Haversine Geolocation)**
   * Menghitung jarak garis lurus di permukaan bumi dari titik GPS pengguna ke seluruh kantor/posko dan menyorot titik terdekat secara otomatis.
4. **Desain Bento UI & Floating Pill Navigation**
   * Selaras dengan desain Dashboard Pengurus utama menggunakan tipografi *Plus Jakarta Sans*, warna zamrud `#09A46E`, dan tata letak Bento Grid.

---

## ⚙️ Cara Instalasi & Menjalankan di Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/striaaaa/intermediate_web1.git
   cd intermediate_web1
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (`.env`)**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan konfigurasi database PostgreSQL/MySQL pada file `.env`.

4. **Jalankan Migrasi & Seeder (Termasuk Akun Admin & Data GIS Migrant CARE)**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://127.0.0.1:8000/admin` atau `http://127.0.0.1:8000/peta`.
