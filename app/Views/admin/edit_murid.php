<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Murid</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Data Murid</h2>

    <form action="<?= site_url('updateMurid/' . $murid['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group mb-3">
            <label for="nama_murid">Nama Murid</label>
            <input type="text" class="form-control" name="nama_murid" value="<?= esc($murid['nama_murid']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="nis">NIS</label>
            <input type="text" class="form-control" name="nis" value="<?= esc($murid['nis']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" rows="3" required><?= esc($murid['alamat']) ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="jurusan">Jurusan</label>
            <input type="text" class="form-control" name="jurusan" value="<?= esc($murid['jurusan']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" name="kelas" value="<?= esc($murid['kelas']) ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('admin/kelolaPengguna') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
