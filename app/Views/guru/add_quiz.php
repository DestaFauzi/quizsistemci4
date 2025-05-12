<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Quiz</title>
</head>

<body>
    <h1>Tambah Quiz ke Kelas: <?= esc($kelas_id) ?></h1>

    <!-- Form untuk menambah quiz -->
    <form action="<?= site_url('/guru/saveQuiz') ?>" method="POST">
        <input type="hidden" name="kelas_id" value="<?= esc($kelas_id) ?>">

        <label for="judul_quiz">Judul Quiz:</label><br>
        <input type="text" name="judul_quiz" id="judul_quiz" required><br><br>

        <label for="jumlah_soal">Jumlah Soal:</label><br>
        <input type="number" name="jumlah_soal" id="jumlah_soal" required><br><br>

        <label for="waktu">Waktu (menit):</label><br>
        <input type="number" name="waktu" id="waktu" required><br><br>

        <label for="level">Level :</label><br>
        <input type="number" name="level" id="level" min="1" required><br><br>

        <button type="submit">Simpan Quiz</button>
    </form>

    <a href="/guru/viewClasses">
        <button>Kembali ke Daftar Kelas</button>
    </a>
</body>

</html>