<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal untuk Quiz</title>
</head>

<body>
    <h1>Tambah Soal untuk Quiz ID: <?= esc($quiz_id) ?></h1>

    <!-- Form untuk menambah soal -->
    <form action="<?= site_url('/guru/saveSoal') ?>" method="POST">
        <input type="hidden" name="quiz_id" value="<?= esc($quiz_id) ?>">
        <input type="hidden" name="jumlah_soal" value="<?= esc($jumlah_soal) ?>">

        <?php for ($i = 1; $i <= $jumlah_soal; $i++): ?>
            <h3>Soal <?= $i ?>:</h3>
            <label for="soal_<?= $i ?>">Soal <?= $i ?>:</label><br>
            <input type="text" name="soal_<?= $i ?>" id="soal_<?= $i ?>" required><br><br>

            <label for="jawaban_a_<?= $i ?>">Jawaban A:</label><br>
            <input type="text" name="jawaban_a_<?= $i ?>" id="jawaban_a_<?= $i ?>" required><br><br>

            <label for="jawaban_b_<?= $i ?>">Jawaban B:</label><br>
            <input type="text" name="jawaban_b_<?= $i ?>" id="jawaban_b_<?= $i ?>" required><br><br>

            <label for="jawaban_c_<?= $i ?>">Jawaban C:</label><br>
            <input type="text" name="jawaban_c_<?= $i ?>" id="jawaban_c_<?= $i ?>" required><br><br>

            <label for="jawaban_d_<?= $i ?>">Jawaban D:</label><br>
            <input type="text" name="jawaban_d_<?= $i ?>" id="jawaban_d_<?= $i ?>" required><br><br>

            <label for="jawaban_benar_<?= $i ?>">Jawaban Benar:</label><br>
            <select name="jawaban_benar_<?= $i ?>" id="jawaban_benar_<?= $i ?>" required>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
            </select><br><br>

            <label for="poin_<?= $i ?>">Poin:</label><br>
            <input type="number" name="poin_<?= $i ?>" id="poin_<?= $i ?>" required><br><br>
        <?php endfor; ?>

        <button type="submit">Simpan Soal</button>
    </form>

    <a href="/guru/viewClasses">
        <button>Kembali ke Daftar Kelas</button>
    </a>
</body>

</html>