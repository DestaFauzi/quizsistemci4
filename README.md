# LMS BahasaKita

LMS BahasaKita adalah sistem manajemen pembelajaran yang dirancang untuk memfasilitasi proses belajar mengajar. Proyek ini dibangun menggunakan CodeIgniter 4.

## Fitur

- Manajemen pengguna (admin, guru, siswa)
- Pengelolaan materi pembelajaran
- Penilaian dan umpan balik
- Fitur Leaderboard

## Prerequisites

Sebelum memulai, pastikan Anda memiliki:

- [PHP](https://www.php.net/) versi 7.3 atau lebih baru
- [Composer](https://getcomposer.org/) untuk mengelola dependensi
- [MySQL](https://www.mysql.com/) untuk basis data

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal LMS BahasaKita:

1. **Clone repositori**

   ```bash[
   https://github.com/DestaFauzi/quizsistemci4
   cd quizsistemci4
2. **Install Composer**
   composer install
3. **Setting Database**
   cp .env.example .env

   \.env
   database.default.hostname = localhost
   database.default.database = nama_database
   database.default.username = username
   database.default.password = password
   database.default.DBDriver = MySQLi

4. **Migrasi Database**
   php spark migrate
   
6. **Jalankan Server**
   php spark serve
