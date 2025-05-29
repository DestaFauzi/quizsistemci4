<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Materi</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
</head>
<body>
<div class="container mt-5">
    <h2>Kelola Materi</h2>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Materi</th>
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
                <td>
                    <?php if($m['file_path']): ?>
                        <a href="<?= base_url($m['file_path']) ?>" target="_blank" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                    <?php else: ?>
                        Tidak ada file
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('admin/editMateri/'.$m['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/materi/hapus/'.$m['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus materi ini?')">Hapus</a>
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
