# Koperasi Peduli Buruh Migran Indramayu (Migrant CARE)

Sistem Manajemen Anggota (Sekretaris) & Pemetaan Lokasi Kantor/Posko berbasis Laravel 12, Filament v5, dan Leaflet GIS.

## Akun Login Admin

- **URL Login**: `http://127.0.0.1:8000/admin/login`
- **Email**: `satriasahrul2@gmail.com`
- **Password**: `12345678`

## Daftar Routing

| Method | Route | Keterangan |
| :--- | :--- | :--- |
| `GET` | `/` | Redirect ke `/admin` |
| `GET` | `/admin/login` | Halaman login admin |
| `GET` | `/admin` | Dashboard utama Sekretaris |
| `GET` | `/admin/members` | Daftar & verifikasi anggota koperasi |
| `GET` | `/admin/members/create` | Tambah anggota baru |
| `GET` | `/admin/members/{id}/edit` | Edit & verifikasi data anggota |
| `GET` | `/admin/branches` | Daftar lokasi kantor & posko |
| `GET` | `/admin/branches/create` | Tambah lokasi kantor/posko (klik titik di peta otomatis isi koordinat & alamat) |
| `GET` | `/admin/branches/{id}/edit` | Edit lokasi kantor/posko |
| `GET` | `/peta` | Halaman peta GIS interaktif (Indramayu & Jakarta) |
| `POST` | `/peta` | Simpan titik lokasi baru langsung dari halaman peta |

## Menjalankan Proyek

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
