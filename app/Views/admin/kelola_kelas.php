<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4361ee;
            color: white;
        }

        button {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #c0392b;
        }

        .button-container {
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4361ee;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: #3b50c5;
        }
    </style>
</head>

<body>
    <h1>Kelola Kelas</h1>
    <div class="button-container">
        <a href="/admin/dashboard" class="back-button">Kembali ke Dashboard</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kelas as $item): ?>
                <tr>
                    <td><?= esc($item['nama_kelas']) ?></td>
                    <td><?= esc($item['deskripsi']) ?></td>
                    <td><?= esc($item['status']) ?></td>
                    <td>
                        <a href="/admin/hapusKelas/<?= esc($item['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                            <button>Hapus Kelas</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>


kelola_materi.php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4361ee;
            color: white;
        }

        button {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #c0392b;
        }

        .button-container {
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4361ee;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: #3b50c5;
        }
    </style>
</head>

<body>
    <h1>Kelola Materi</h1>
    <div class="button-container">
        <a href="/admin/dashboard" class="back-button">Kembali ke Dashboard</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Judul Materi</th>
                <th>Level</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materi as $item): ?>
                <tr>
                    <td><?= esc($item['judul']) ?></td>
                    <td><?= esc($item['level']) ?></td>
                    <td><?= esc($item['kelas_id']) ?></td>
                    <td>
                        <a href="/admin/hapusMateri/<?= esc($item['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                            <button>Hapus Materi</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>



kelola_pengguna.php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4361ee;
            color: white;
        }

        button {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #c0392b;
        }

        .button-container {
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4361ee;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: #3b50c5;
        }
    </style>
</head>

<body>
    <h1>Kelola Pengguna</h1>
    <div class="button-container">
        <a href="/admin/dashboard" class="back-button">Kembali ke Dashboard</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= esc($user['username']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['role_id']) ?></td>
                    <td>
                        <a href="/admin/hapusUser/<?= esc($user['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                            <button>Hapus Pengguna</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>


kelola_quiz.php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Quiz</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4361ee;
            color: white;
        }

        button {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #c0392b;
        }

        .button-container {
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4361ee;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: #3b50c5;
        }
    </style>
</head>

<body>
    <h1>Kelola Quiz</h1>
    <div class="button-container">
        <a href="/admin/dashboard" class="back-button">Kembali ke Dashboard</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Judul Quiz</th>
                <th>Level</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quiz as $item): ?>
                <tr>
                    <td><?= esc($item['judul_quiz']) ?></td>
                    <td><?= esc($item['level']) ?></td>
                    <td><?= esc($item['kelas_id']) ?></td>
                    <td>
                        <a href="/admin/hapusQuiz/<?= esc($item['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus quiz ini?')">
                            <button>Hapus Quiz</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>