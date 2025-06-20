<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        .edit-button,
.delete-button {
    display: inline-block;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 500;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.edit-button {
    background-color: #3498db;
}

.edit-button:hover {
    background-color: #2980b9;
}

.delete-button {
    background-color: #e74c3c;
}

.delete-button:hover {
    background-color: #c0392b;
}
        



    </style>
</head>

<body>
<div class="container mt-5">
    <h2>Kelola Materi</h2>
    
    <div class="button-container">
        <a href="/admin/dashboard" class="back-button">Kembali ke Dashboard</a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>


    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Materi</th>
                <th>Kelas</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($materi) && count($materi) > 0): ?>
            <?php $no = 1; foreach($materi as $m): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($m['judul']); ?></td>
                <td><?= esc($m['nama_kelas']) ?></td>

                <td>
                    <?php if($m['file_path']): ?>
                        <a href="<?= base_url($m['file_path']) ?>" target="_blank" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Lihat</a>
                    <?php else: ?>
                        Tidak ada file
                    <?php endif; ?>
                </td>
               <td>
    <a href="<?= base_url('admin/editMateri/'.$m['id']); ?>" class="edit-button">
        <i class="fas fa-edit"></i> Edit
    </a>
    <a href="<?= base_url('admin/materi/hapus/'.$m['id']); ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus materi ini?')">
        <i class="fas fa-trash"></i> Hapus
    </a>
</td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Belum ada materi.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>
