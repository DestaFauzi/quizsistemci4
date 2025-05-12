<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kelas</title>
</head>

<body>
    <h1>Buat Kelas Baru</h1>

    <form action="/guru/saveClass" method="POST">
        <label for="nama_kelas">Nama Kelas:</label>
        <input type="text" name="nama_kelas" id="nama_kelas" required><br>

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" rows="4" required></textarea><br>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="aktif">Aktif</option>
            <option value="non_aktif">Non-Aktif</option>
        </select><br>

        <button type="submit">Buat Kelas</button>
    </form>
</body>

</html>