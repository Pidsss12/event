# 📅 EventHub — Premium Event & Digital Ticket Management Platform

**EventHub** adalah platform manajemen informasi event dan ticketing digital terlengkap yang dirancang menggunakan arsitektur modern Laravel. Dilengkapi dengan antarmuka pengguna (UI) premium bernuansa gelap dan *glassmorphism*, integrasi peta interaktif (OpenStreetMap), serta sistem pembayaran e-wallet terintegrasi dengan persetujuan admin.

---

## ✨ Fitur Utama

### 👤 Customer (User) Portal
- **Dashboard Premium & Modern**: Tampilan dashboard interaktif untuk memantau saldo, riwayat transaksi/booking tiket, dan event terdaftar.
- **Top-up E-Wallet Terintegrasi**: Mengajukan top-up saldo secara instan dengan mengunggah bukti pembayaran untuk diverifikasi oleh admin.
- **Peta Interaktif (OpenStreetMap)**: Menelusuri lokasi pelaksanaan event secara langsung melalui peta interaktif.
- **Pencarian & Filter Kategori**: Mempermudah pencarian event terdekat berdasarkan judul maupun kategori (Music, Conference, Art, dll).
- **Simulasi Pembelian & E-Ticket**: Proses checkout tiket mudah (Silver, Gold, Platinum VIP) dan mendapatkan e-ticket berformat PDF yang bisa diunduh.

### 👑 Admin Management
- **Dashboard Statistik & Ringkasan**: Grafik penjualan total, total event aktif, jumlah user terdaftar, dan log transaksi terbaru.
- **Manajemen Event & Kategori (CRUD)**: Kontrol penuh untuk membuat, memperbarui, dan menghapus data event beserta alokasi kapasitas tiket.
- **Approval Top-up Pengguna**: Halaman verifikasi bukti transfer e-wallet pengguna untuk menyetujui atau menolak pengisian saldo secara real-time.
- **Manajemen Transaksi & Booking**: Meninjau status pembayaran tiket (pending/paid/cancelled) serta membatalkan transaksi bermasalah.
- **Manajemen Role User**: Mengontrol hak akses pengguna untuk diangkat sebagai Admin atau dikembalikan menjadi Customer biasa.

---

## 🛠️ Tech Stack & Dependencies

Platform ini dikembangkan menggunakan teknologi mutakhir:
- **Core Framework**: Laravel 11.x (PHP 8.3+)
- **Database**: MySQL / MariaDB
- **User Interface**: HTML5, Vanilla CSS3 (Custom Glassmorphic Premium Stylesheet), Alpine.js, Lucide Icons
- **Peta Interaktif**: OpenStreetMap & Leaflet.js
- **Laporan PDF**: Dompdf (Laravel PDF generator)
- **Asset Bundler**: Vite (npm dev server)

---

## 🚀 Panduan Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project ini secara lokal di komputer Anda:

### 1. Clone & Buka Folder Project
```bash
git clone https://github.com/Pidsss12/event.git
cd event
```

### 2. Instalasi Dependensi (Backend & Frontend)
```bash
# Install PHP dependencies via Composer
composer install

# Install JS dependencies via NPM
npm install
```

### 3. Konfigurasi Lingkungan (.env)
Salin file `.env.example` menjadi `.env`, lalu konfigurasikan koneksi database Anda:
```bash
cp .env.example .env
```
Sesuaikan bagian database berikut pada file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Key & Jalankan Migrasi Database beserta Seeders
```bash
# Generate aplikasi key
php artisan key:generate

# Jalankan migrasi database dan seeders awal (opsional)
php artisan migrate --seed
```

### 5. Jalankan Local Server
Buka dua terminal terpisah dan jalankan perintah berikut:

- **Terminal 1 (Laravel Dev Server)**:
  ```bash
  php artisan serve
  ```
- **Terminal 2 (Vite Assets Server)**:
  ```bash
  npm run dev
  ```

Buka browser Anda dan akses `http://127.0.0.1:8000`.

---

## 🔒 Informasi Kredensial Awal (Seeder)
Jika Anda menggunakan `--seed` saat migrasi database, berikut akun default yang siap digunakan:

- **Admin Account**:
  - Email: `admin@gmail.com`
  - Password: `password`
- **Customer Account**:
  - Email: `user@gmail.com`
  - Password: `password`
