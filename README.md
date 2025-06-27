# 🏟️ Sistem Booking Lapangan Olahraga

Sebuah aplikasi web canggih yang dibangun dengan Laravel untuk mempermudah manajemen dan proses booking lapangan olahraga seperti futsal, badminton, dan lainnya.

![Screenshot Aplikasi]()

---

## ✨ Fitur Utama

Aplikasi ini dibagi menjadi dua bagian utama dengan fitur-fitur yang lengkap:

### **Backend (Untuk Admin/Pengelola)**
* **Dashboard Visual:** Tampilan jadwal grid interaktif yang menunjukkan status booking semua lapangan secara real-time.
* **Manajemen Booking:** Admin dapat menambah, mengubah status (Selesai/Batal), dan menghapus data booking dengan mudah.
* **Manajemen Lapangan (CRUD):** Fitur lengkap untuk mengelola data master lapangan, termasuk nama, jenis, harga, dan foto.
* **Validasi Anti-Bentrok:** Sistem cerdas untuk mencegah *double booking* pada jam dan lapangan yang sama.
* **Laporan Pendapatan:** Fitur untuk mencetak laporan pendapatan berdasarkan rentang tanggal yang dipilih.
* **Autentikasi Aman:** Sistem login yang aman untuk memastikan hanya admin yang bisa mengakses backend.

### **Frontend (Untuk Pelanggan)**
* **Jadwal Live:** Pelanggan bisa melihat ketersediaan lapangan secara langsung tanpa perlu bertanya.
* **Form Booking Sederhana:** Alur pemesanan yang mudah, pelanggan tinggal pilih lapangan, tanggal, dan jam yang masih kosong.

---

## 🚀 Teknologi yang Digunakan

Proyek ini dibangun menggunakan teknologi modern dan terpercaya:

* **Backend:** Laravel 10
* **Frontend:** Blade Templates & Bootstrap 5
* **Database:** MySQL
* **Build Tool:** Vite

---

## 🛠️ Cara Instalasi & Setup

Ikuti langkah-langkah ini untuk menjalankan proyek di komputer lokal.

1.  **Clone repository ini:**
    ```bash
    git clone https://github.com/Zivalez/sistem-booking-lapangan.git
    ```

2.  **Masuk ke direktori proyek:**
    ```bash
    cd sistem-booking-lapangan
    ```

3.  **Install semua dependency PHP:**
    ```bash
    composer install
    ```

4.  **Copy file `.env.example` menjadi `.env`:**
    ```bash
    cp .env.example .env
    ```

5.  **Generate application key baru:**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi database di file `.env`:**
    Buka file `.env` dan sesuaikan bagian `DB_` dengan pengaturan database lokal.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=booking_lapangan
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Jalankan migrasi dan seeder:**
    Perintah ini akan membuat semua tabel dan mengisi data awal (akun admin & data lapangan).
    ```bash
    php artisan migrate --seed
    ```

8.  **Install dependency JavaScript:**
    ```bash
    npm install
    ```

9.  **Jalankan Vite (untuk kompilasi aset):**
    Buka satu terminal baru dan biarkan ini berjalan.
    ```bash
    npm run dev
    ```

10. **Jalankan server development Laravel:**
    Buka terminal lain dan jalankan ini.
    ```bash
    php artisan serve
    ```

11. **Buka aplikasi!**
    Akses `http://127.0.0.1:8000` di browser.
    * **Login Admin:**
        * Email: `admin@lapangan.com`
        * Password: `password123`