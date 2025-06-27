# Sistem Manajemen Booking Lapangan

Sebuah aplikasi web yang dibangun dengan Laravel untuk manajemen jadwal dan booking lapangan. Aplikasi ini memiliki fitur unggulan berupa tampilan jadwal yang dinamis dan interaktif, memungkinkan admin untuk melihat dan mengelola slot waktu yang tersedia dan yang sudah dibooking dengan mudah.

![Screenshot Jadwal Booking](path/to/your/screenshot.png)
*(Jangan lupa ganti `path/to/your/screenshot.png` dengan screenshot asli tampilan aplikasi lu!)*

---

## ✨ Fitur Utama

-   **Tampilan Jadwal Interaktif**: Visualisasi jadwal booking per hari dengan tampilan per jam yang jelas dan mudah dibaca.
-   **Navigasi Tanggal**: Dilengkapi *date picker* untuk berpindah antar tanggal dengan cepat.
-   **Status Slot Booking**: Perbedaan warna yang jelas antara slot yang sudah terisi dan slot yang masih kosong.
-   **Grouping Durasi Booking**: Booking dengan durasi lebih dari satu jam akan secara otomatis digabungkan (`rowspan`) menjadi satu blok visual yang solid.
-   **Booking Per Jam di Slot Kosong (Nested Row Simulation)**: Fitur paling canggih! Jika ada slot kosong dengan durasi panjang (misal, 3 jam), slot tersebut akan dibagi menjadi beberapa "baris virtual". Admin bisa langsung klik untuk membuat booking baru pada jam spesifik di dalam slot kosong tersebut. Implementasi ini menggunakan **CSS Grid** untuk menciptakan layout yang kompleks di dalam sel tabel.
-   **Desain Modern & Responsif**: Dibangun dengan Tailwind CSS untuk memastikan tampilan yang bersih, modern, dan berfungsi baik di berbagai ukuran layar.

---

## 🛠️ Teknologi yang Digunakan

-   **Backend**: PHP 8.1+, Laravel 10+
-   **Frontend**: Blade, Tailwind CSS, JavaScript
-   **Database**: MySQL / MariaDB
-   **Library Pendukung**:
    -   `Carbon`: Untuk manipulasi tanggal dan waktu.
    -   `Font Awesome`: Untuk ikonografi.

---

## 🚀 Instalasi & Setup

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal:

1.  **Clone repository ini:**
    ```bash
    git clone [https://github.com/your-username/your-repo-name.git](https://github.com/your-username/your-repo-name.git)
    cd your-repo-name
    ```
    *(Ganti URL dengan URL repository GitHub lu)*

2.  **Install dependency PHP via Composer:**
    ```bash
    composer install
    ```

3.  **Buat file environment:**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database:**
    Buka file `.env` dan sesuaikan konfigurasi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_lu
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan migrasi dan seeder database:**
    Perintah ini akan membuat struktur tabel dan mengisi data awal (jika ada seeder).
    ```bash
    php artisan migrate --seed
    ```

7.  **Install dependency Node.js dan compile aset:**
    ```bash
    npm install
    npm run dev
    ```

8.  **Jalankan server development:**
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

---

## 🏗️ Struktur Kode Kunci

Logika utama untuk render jadwal interaktif berada di:
`resources/views/backend/dashboard.blade.php`

-   **`$bookingMatrix`**: Array PHP yang disiapkan di Controller untuk memetakan setiap slot waktu dengan data booking dan durasinya.
-   **`$skipMatrix`**: Digunakan untuk melompati render sel `<td>` yang sudah "dimakan" oleh `rowspan` dari booking sebelumnya.
-   **CSS Grid (`grid grid-rows-{n}`)**: Digunakan pada slot kosong (`<td>`) untuk menciptakan "baris virtual" yang memungkinkan booking per jam, yang merupakan solusi dari tantangan `rowspan` di dalam `rowspan`.

---

## 📄 Lisensi

Proyek ini berada di bawah [Lisensi MIT](LICENSE.md).