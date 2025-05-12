<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-button {
            background-color: #f44336;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #e53935;
        }
    </style>
</head>

<body>
    <h1>Tambah Materi untuk Kelas: <?= esc($kelas['nama_kelas']) ?></h1>

    <!-- Form untuk mengunggah materi -->
    <form action="<?= site_url('guru/uploadMateri') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="kelas_id" value="<?= esc($kelas['id']) ?>">

        <label for="judul">Judul Materi:</label>
        <input type="text" name="judul" id="judul" required>

        <label for="file_materi">File Materi (PDF):</label>
        <input type="file" name="file_materi" id="file_materi" accept="application/pdf" required>

        <label for="level">Level:</label>
        <input type="number" name="level" id="level" required>

        <button type="submit">Unggah Materi</button>
    </form>

    <a href="/guru/viewClasses">
        <button class="back-button">Kembali ke Daftar Kelas</button>
    </a>
</body>

</html>