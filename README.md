# 📋 Website Artikel - Portal Informasi Dinamis

Website Artikel ini adalah portal berita/informasi dinamis berbasis **Laravel 11**, **Tailwind CSS v4**, dan **MySQL** yang memiliki tampilan modern, responsif, serta mendukung skema warna **Light/Dark Mode**. 

Aplikasi ini dibagi menjadi 2 area akses utama:
- **Halaman Publik**: Beranda (Hero Banner + Teks Pengumuman), Daftar Artikel (Fitur Pencarian + Filter Kategori), dan Halaman Tentang.
- **Halaman Admin**: Halaman khusus untuk **Admin Artikel** (menulis tulisan) dan **Super Admin** (kontrol penuh tema, warna, layout, kustomisasi logo, kelola user, kategori, dan log aktivitas).

---

## 🛠️ Struktur Teknologi & Stack
- **Framework**: Laravel 12 (PHP 8.3+)
- **Styling**: Tailwind CSS v4 (menggunakan Dynamic Browser CDN)
- **Database**: MySQL (Terintegrasi ke local MAMP/XAMPP host)
- **Runtime Environment**: Pendekatan ganda:
  - **Local Host** (menggunakan PHP MAMP)
  - **Containerized** (menggunakan Podman Desktop & `podman-compose`)

---

## ⚙️ Persyaratan Awal (Prerequisites)
Sebelum menjalankan aplikasi, pastikan Anda telah menginstal komponen berikut di Mac Anda:
1. **MAMP** atau **MySQL Server** lokal berjalan di port default `3306`.
2. **PHP 8.3+** (sudah tersedia di MAMP `/Applications/MAMP/bin/php/php8.3.30/bin/php`).
3. **Podman Desktop** & `podman-compose` (jika ingin menjalankan aplikasi di dalam container).
4. **Composer** (untuk mengelola pustaka PHP Laravel).

---

## 🚀 Langkah Instalasi & Setup Database

Lakukan langkah-langkah berikut di terminal proyek Anda (`/Applications/MAMP/htdocs/web-artikel`):

### 1. Inisialisasi Environment
Salin file konfigurasi environment dari `.env.example` ke `.env`:
```bash
cp .env.example .env
```

### 2. Konfigurasi Database di `.env`
Buka file `.env` dan pastikan konfigurasi MySQL disesuaikan dengan database MAMP lokal Anda. Secara default, MAMP menggunakan password `root`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_artikel
DB_USERNAME=root
DB_PASSWORD=root
```
*(Catatan: Buat database kosong bernama `web_artikel` di MySQL local Anda sebelum melangkah ke tahap berikutnya).*

### 3. Instalasi Dependensi PHP
Instal library Laravel menggunakan PHP 8.3 dari MAMP:
```bash
/Applications/MAMP/bin/php/php8.3.30/bin/php /Applications/MAMP/bin/php/composer install
```

### 4. Membuat Kunci Enkripsi Aplikasi (App Key)
Hasilkan kunci enkripsi aplikasi Laravel Anda:
```bash
/Applications/MAMP/bin/php/php8.3.30/bin/php artisan key:generate
```

---

## 💻 Cara Menjalankan Aplikasi

Terdapat dua metode untuk menjalankan aplikasi ini sesuai dengan preferensi Anda:

### Metode A: Menjalankan Menggunakan Podman (Containerized PHP)
Dalam metode ini, PHP Apache berjalan di dalam container Podman, sedangkan database MySQL tetap menggunakan database lokal Anda pada host (`localhost:3306`).

1. **Konfigurasi Environment untuk Container**:
   Buka file `.env` di host, lalu ubah target `DB_HOST` agar mengarah ke host komputer Anda melalui gateway DNS internal container:
   ```env
   DB_HOST=host.docker.internal
   ```
2. **Build & Jalankan Container**:
   Jalankan container PHP Apache menggunakan `podman-compose`:
   ```bash
   podman-compose down && podman-compose up -d --build
   ```
3. **Jalankan Migrasi & Seeder Database (dari dalam container)**:
   Buat tabel database dan masukkan akun uji coba default dari dalam container:
   ```bash
   podman exec web_artikel_app php artisan migrate:fresh --seed
   ```
4. **Hubungkan Folder Storage**:
   Buat tautan simbolik folder penyimpanan agar gambar cover dapat diakses secara publik:
   ```bash
   podman exec web_artikel_app php artisan storage:link --force
   ```
5. **Akses Aplikasi**:
   - Website Publik: [http://localhost:8000](http://localhost:8000)
   - Login Admin: [http://localhost:8000/admin/login](http://localhost:8000/admin/login)

---

### Metode B: Menjalankan Menggunakan Local PHP MAMP (Tanpa Container)
Jika Anda tidak ingin menggunakan container, Anda dapat meluncurkan server langsung dari PHP MAMP host.

1. **Konfigurasi Environment Lokal**:
   Pastikan `DB_HOST` di `.env` mengarah ke loopback lokal:
   ```env
   DB_HOST=127.0.0.1
   ```
2. **Jalankan Migrasi & Seeder**:
   Eksekusi migrasi database langsung menggunakan PHP lokal:
   ```bash
   /Applications/MAMP/bin/php/php8.3.30/bin/php artisan migrate:fresh --seed
   ```
3. **Hubungkan Folder Storage**:
   ```bash
   /Applications/MAMP/bin/php/php8.3.30/bin/php artisan storage:link
   ```
4. **Jalankan Server Development**:
   Jalankan server bawaan Laravel:
   ```bash
   /Applications/MAMP/bin/php/php8.3.30/bin/php artisan serve
   ```
5. **Akses Aplikasi**:
   - Website Publik: [http://127.0.0.1:8000](http://127.0.0.1:8000)
   - Login Admin: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## 🔑 Kredensial Akun Default (Seeded)

Gunakan akun berikut untuk login ke halaman administrator:

| Role Pengguna | Username | Password | Tautan Redirect Setelah Login |
|---|---|---|---|
| **Super Admin** | `superadmin` | `superadmin123` | `/admin/super` (Statistik + Manajemen Penuh) |
| **Admin Artikel** | `admin1` | `admin123` | `/admin/artikel` (Kelola Artikel Anda) |

---

## 💡 Fitur Kustomisasi Khusus (Super Admin)

Super Admin dapat melakukan perubahan tampilan secara dinamis melalui halaman **Pengaturan Website** (`/admin/super/settings`):
- **Warna Utama & Sekunder**: Mengubah warna gradasi teks hero, latar belakang banner pengumuman, tombol, dan link aktif secara langsung.
- **Font & Typography**: Mengubah jenis tulisan seluruh situs ke Instrument Sans, Inter, Roboto, Poppins, atau Playfair Display secara realtime.
- **Layout Kolom**: Mengubah jumlah kolom grid artikel halaman publik menjadi 1 kolom (list vertikal), 2 kolom, 3 kolom, atau 4 kolom.
- **Live Logo**: Mengunggah file logo yang akan langsung menggantikan tulisan teks judul website di header publik maupun dashboard admin.
- **SEO & Footer**: Mengatur teks copyright, menyusun deskripsi meta situs untuk Google, serta mengaktifkan/menonaktifkan banner pengumuman di atas header.
