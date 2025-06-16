<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas: <?= esc($kelas['nama_kelas']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --danger: #dc3545;
            /* Tambahkan warna danger untuk pesan error */
            --border-radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input[type="text"],
        input[type="number"],
        /* Ubah type="text" menjadi type="number" untuk jumlah_level */
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        /* Tambahkan focus untuk number input */
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .button-group {
            /* Ubah dari button tunggal menjadi grup untuk tombol */
            display: flex;
            justify-content: flex-end;
            /* Posisikan tombol ke kanan */
            gap: 15px;
            /* Jarak antar tombol */
            margin-top: 20px;
        }

        .button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            /* Untuk tombol yang berupa link */
            display: inline-block;
            /* Untuk tombol yang berupa link */
            text-align: center;
        }

        .button:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .button-secondary {
            background-color: #6c757d;
            /* Warna abu-abu untuk tombol sekunder/batal */
        }

        .button-secondary:hover {
            background-color: #5a6268;
        }

        /* Alert styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: var(--danger);
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
                /* Tumpuk tombol di layar kecil */
                gap: 10px;
            }

            .button {
                width: 100%;
                /* Tombol memenuhi lebar di layar kecil */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Kelas: <?= esc($kelas['nama_kelas']) ?></h1> <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('guru/updateClass/' . esc($kelas['id'])) ?>" method="POST"> <input type="hidden" name="id" value="<?= esc($kelas['id']) ?>">
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" required placeholder="Masukkan nama kelas"
                    value="<?= old('nama_kelas', $kelas['nama_kelas']) ?>"> <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_kelas'])) : ?>
                    <span class="error-message"><?= esc(session()->getFlashdata('errors')['nama_kelas']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required placeholder="Tambahkan deskripsi kelas"><?= old('deskripsi', $kelas['deskripsi']) ?></textarea> <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['deskripsi'])) : ?>
                    <span class="error-message"><?= esc(session()->getFlashdata('errors')['deskripsi']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="jumlah_level">Jumlah Level</label>
                <input type="number" name="jumlah_level" id="jumlah_level" min="1" required placeholder="Masukkan Jumlah Level"
                    value="<?= old('jumlah_level', $kelas['jumlah_level']) ?>"> <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['jumlah_level'])) : ?>
                    <span class="error-message"><?= esc(session()->getFlashdata('errors')['jumlah_level']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="aktif" <?= old('status', $kelas['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="non_aktif" <?= old('status', $kelas['status']) == 'non_aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['status'])) : ?>
                    <span class="error-message"><?= esc(session()->getFlashdata('errors')['status']) ?></span>
                <?php endif; ?>
            </div>

            <div class="button-group"> <button type="submit" class="button">Simpan Perubahan</button> <a href="<?= site_url('guru/viewClasses') ?>" class="button button-secondary">Batal</a> </div>
        </form>
    </div>
</body>

</html>