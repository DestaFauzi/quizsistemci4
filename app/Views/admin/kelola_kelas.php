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
                <th>Created By</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kelas as $item): ?>
                <tr>
                    <td><?= esc($item['nama_kelas']) ?></td>
                    <td><?= esc($item['nama_guru']) ?></td>
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
