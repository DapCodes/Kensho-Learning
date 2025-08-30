# 🎯 Dexa - Computer Based Test (CBT)

<div align="center">
  <p>
    <strong>Sistem ujian online yang aman, transparan, dan anti-kecurangan</strong>
  </p>
  
  ![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
  ![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
  ![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
  
  [🌐 **Live Demo**](https://kensho-learning.smkassalaambandung.sch.id/) • [📚 **Dokumentasi**](#) • [🐛 **Report Bug**](#)
</div>

---

## 📖 Tentang Dexa

**Dexa** adalah aplikasi ujian online (Computer Based Test) berbasis web yang dibangun menggunakan **Laravel 12** dan **Bootstrap 5**. Aplikasi ini hadir sebagai solusi untuk mengatasi berbagai masalah dalam sistem ujian digital modern.

### 🎯 Mengapa Dexa?

Di era modernisasi, ujian berbasis website atau aplikasi justru membuka banyak sekali celah kecurangan. Mulai dari:

-   🤖 Penggunaan alat bantu otomatis
-   🔄 Perpindahan tab untuk mencari jawaban
-   ⚖️ Manipulasi dalam proses penilaian

**Dexa** hadir untuk memperbaiki permasalahan tersebut dengan menghadirkan sistem ujian yang lebih:

-   🔒 **Aman** - Sistem deteksi kecurangan canggih
-   👁️ **Transparan** - Log aktivitas lengkap
-   ⚡ **Cepat** - Proses evaluasi otomatis
-   ✅ **Jujur** - Hasil ujian terpercaya

---

## ✨ Fitur Utama

### 🛡️ Keamanan & Anti-Kecurangan

-   **Deteksi Kecurangan Instan** - Monitoring aktivitas peserta secara real-time
-   **Log Aktivitas Lengkap** - Pencatatan tab switch count dan perilaku mencurigakan
-   **Peringatan Dini** - Notifikasi otomatis untuk pengawas ujian

### 📋 Manajemen Ujian Fleksibel

-   **Pembuatan Soal Beragam** - Mendukung berbagai tipe soal (pilihan ganda, essay, dll)
-   **Pengaturan Waktu & Jadwal** - Kontrol penuh atas durasi dan jadwal ujian
-   **Bank Soal Terorganisir** - Sistem kategorisasi dan penyimpanan soal yang rapi

---

## 🛠️ Teknologi

| Teknologi         | Versi | Deskripsi                          |
| ----------------- | ----- | ---------------------------------- |
| **Laravel**       | 12    | Framework PHP modern untuk backend |
| **Bootstrap**     | 5     | Framework CSS untuk UI responsif   |
| **MySQL/MariaDB** | -     | Database management system         |

---

## 🚀 Instalasi & Setup

### Prasyarat

Pastikan sistem Anda memiliki:

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL/MariaDB

### Langkah Instalasi

1. **Clone Repository**

    ```bash
    git clone https://github.com/DapCodes/Kensho-Learning.git
    cd Kensho-Learning
    ```

2. **Install Dependencies**

    ```bash
    # Install PHP dependencies
    composer install

    # Install Node.js dependencies & build assets
    npm install && npm run dev
    ```

3. **Konfigurasi Environment**

    ```bash
    # Buat file environment
    cp .env.example .env

    # Generate application key
    php artisan key:generate
    ```

4. **Konfigurasi Database**

    Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=dexa_cbt
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Setup Database**

    ```bash
    # Jalankan migrasi dan seeder
    php artisan migrate --seed
    ```

6. **Jalankan Aplikasi**

    ```bash
    # Start development server
    php artisan serve
    ```

    Aplikasi akan tersedia di `http://localhost:8000`

---

## 📱 Demo

🌐 **Live Demo:** [https://kensho-learning.smkassalaambandung.sch.id/](https://kensho-learning.smkassalaambandung.sch.id/)

> **Catatan:** Demo ini adalah versi production yang sudah berjalan dan dapat digunakan untuk testing fitur-fitur Dexa.

---

## 🤝 Kontribusi

Kami menyambut kontribusi dari komunitas! Berikut cara berkontribusi:

1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add some amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 📞 Dukungan

Jika Anda mengalami masalah atau memiliki pertanyaan:

-   🐛 [Laporkan Bug](https://github.com/DapCodes/Kensho-Learning/issues)
-   💬 [Diskusi](https://github.com/DapCodes/Kensho-Learning/discussions)
-   📧 Email: support@dexa-cbt.com

---

<div align="center">
  <p>
    Dibuat dengan ❤️ oleh Tim Dexa<br>
    © 2024 Dexa CBT. All rights reserved.
  </p>
</div>
