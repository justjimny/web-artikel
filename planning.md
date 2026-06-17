# 📋 Planning Website Artikel

---

## 1. Gambaran Umum

Website artikel dengan dua akses utama:
- **URL Publik** → untuk pengunjung umum
- **URL Admin** → untuk admin artikel & super admin

---

## 2. Struktur Halaman Publik

### Navigation Bar (semua halaman)
- Logo di kiri atas (dapat diganti oleh super admin secara realtime)
- Menu navigasi: **Beranda** | **Artikel** | **Tentang**

---

### 2.1 Halaman Beranda (`/`)
- Sekilas pengenalan website (hero section / intro singkat)
- Preview beberapa artikel terbaru (thumbnail + judul)
- Tombol **"Lihat Artikel"** → mengarah ke halaman Artikel

---

### 2.2 Halaman Artikel (`/artikel`)
- Menampilkan **semua artikel** secara lengkap
- Fitur: grid/list artikel, pencarian, filter kategori (opsional)
- Setiap artikel menampilkan:
  - Foto artikel
  - Judul & narasi/deskripsi
  - Nama yang mempublikasikan artikel

---

### 2.3 Halaman Tentang (`/tentang`)
- Profil dan sejarah website/organisasi
- Gambar pendukung (foto tim, gedung, dll.)

---

### 2.4 Footer (semua halaman)
- Informasi singkat tentang website
- Link media sosial:
  - Instagram
  - TikTok
  - YouTube
- (Dapat diedit oleh super admin)

---

## 3. Sistem Admin

### 3.1 URL Admin
| Akses | URL |
|---|---|
| Halaman Login Admin | `/admin/login` |
| Dashboard Admin Artikel | `/admin/artikel` |
| Dashboard Super Admin | `/admin/super` |

Login menggunakan **username & password** masing-masing, namun melalui **satu halaman login yang sama**. Sistem akan mengarahkan ke dashboard sesuai role secara otomatis setelah login berhasil.

---

### 3.2 Admin Artikel

**Akses:** CRUD Artikel

#### Form Upload Artikel
| Field | Keterangan |
|---|---|
| Nama Publisher | Nama admin yang mempublikasikan artikel |
| Foto Artikel | Upload file gambar |
| Narasi / Deskripsi | Konten teks artikel |

#### Fitur:
- **Create** → Upload artikel baru (foto + narasi + nama publisher)
- **Read** → Melihat daftar artikel yang sudah diupload
- **Update** → Mengedit artikel (foto, narasi, nama publisher)
- **Delete** → Menghapus artikel

> Catatan: Setiap admin artikel memiliki username & password berbeda. Nama publisher diisi manual di form saat upload agar fleksibel (bukan otomatis dari akun login).

---

### 3.3 Super Admin

**Akses:** Semua akses admin artikel + kontrol penuh website

#### Manajemen Artikel
- Semua fitur CRUD seperti admin artikel
- Melihat seluruh artikel dari semua admin

#### Manajemen Pengguna Admin
- Melihat daftar semua akun admin artikel
- Membuat akun admin artikel baru
- Mengubah username/password admin artikel
- Menonaktifkan/menghapus akun admin artikel

#### Manajemen Logo
- Mengganti logo website secara **realtime** (upload gambar baru langsung terlihat di website)

#### Manajemen Template & Tampilan
- Mengubah **warna utama** (primary color, secondary color, background)
- Mengubah **font** website
- Mengubah **layout** halaman (misalnya: jumlah kolom artikel)
- Preview perubahan sebelum disimpan (opsional)

#### Manajemen Footer
- Mengubah teks informasi singkat di footer
- Mengubah link media sosial (Instagram, TikTok, YouTube)
- Menambah/menghapus platform media sosial

#### Fitur Tambahan (Rekomendasi)
- **Log Aktivitas** → Melihat riwayat aktivitas semua admin (siapa upload apa, kapan)
- **Manajemen Kategori Artikel** → Membuat, mengubah, menghapus kategori artikel
- **Banner/Pengumuman** → Mengatur teks pengumuman di halaman beranda
- **SEO Setting** → Mengatur meta title, meta description per halaman
- **Backup Data** → Ekspor data artikel ke format CSV/Excel

---

## 4. Alur Sistem (Flow)

```
Pengunjung
  └── Akses URL Publik
        ├── Beranda → lihat sekilas → klik "Lihat Artikel"
        ├── Artikel → lihat semua artikel
        └── Tentang → lihat profil & sejarah

Admin
  └── Akses /admin/login
        ├── Login sebagai Admin Artikel
        │     └── Dashboard → CRUD Artikel
        └── Login sebagai Super Admin
              └── Dashboard → CRUD Artikel + Manajemen Penuh
```

---

## 5. Struktur Teknologi (Rekomendasi)

| Komponen | Pilihan Teknologi |
|---|---|
| Frontend | Blade |
| Backend | Laravel |
| Database | MySQL |
| Storage Gambar | Local Storage |
| Autentikasi | Session-based |
| Styling | Bootstrap |

---

## 6. Checklist Pengembangan

### Fase 1 – Setup & Halaman Publik
- [ ] Setup project & repository
- [ ] Buat layout dasar (navbar, footer)
- [ ] Halaman Beranda
- [ ] Halaman Artikel
- [ ] Halaman Tentang

### Fase 2 – Sistem Admin
- [ ] Halaman login admin (satu URL, dua role)
- [ ] Dashboard admin artikel (CRUD artikel)
- [ ] Dashboard super admin (semua fitur)
- [ ] Upload & manajemen gambar

### Fase 3 – Fitur Super Admin Lanjutan
- [ ] Ganti logo realtime
- [ ] Pengaturan template & warna
- [ ] Edit footer
- [ ] Manajemen akun admin artikel
- [ ] Log aktivitas

### Fase 4 – Fitur Tambahan & Finishing
- [ ] Manajemen kategori artikel
- [ ] Banner/pengumuman
- [ ] SEO setting
- [ ] Testing & bug fixing
- [ ] Deploy ke server

---

*Planning ini dapat diperbarui sesuai kebutuhan pengembangan.*
