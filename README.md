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
   ```bash[
   composer install
4. **Setting Database**
   ```bash[
   cp .env.example .env

   \.env
   ```bash[
   database.default.hostname = localhost
   database.default.database = nama_database
   database.default.username = username
   database.default.password = password
   database.default.DBDriver = MySQLi

6. **Migrasi Database**
   ```bash[
   php spark migrate
   php spark db:seed
   
8. **Jalankan Server**
   ```bash[
   php spark serve
