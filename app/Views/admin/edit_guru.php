<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Guru</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Data Guru</h2>

    <form action="<?= site_url('updateGuru/' . $guru['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group mb-3">
            <label for="nama_guru">Nama Guru</label>
            <input type="text" class="form-control" name="nama_guru" value="<?= esc($guru['nama_guru']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" name="nip" value="<?= esc($guru['nip']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" rows="3" required><?= esc($guru['alamat']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('admin/kelolaPengguna') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
