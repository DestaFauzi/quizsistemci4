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
                    <td><?= esc($item['nama_kelas']) ?></td>
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