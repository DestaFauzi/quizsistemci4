<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi</title>
    <style>
        :root {
            --primary-color: #4a6bff;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --border-color: #ddd;
            --success-color: #28a745;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: #f5f7ff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 25px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }

        .form-container {
            background: var(--secondary-color);
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-color);
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 16px;
        }

        .button-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .button-primary:hover {
            background-color: #3a5bef;
            transform: translateY(-2px);
        }

        .button-secondary {
            background-color: #6c757d;
            color: white;
        }

        .button-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            justify-content: flex-end;
            /* Align buttons to the right */
        }

        .file-input-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-button {
            border: 1px solid var(--border-color);
            border-radius: 5px;
            padding: 10px 15px;
            background-color: white;
            color: var(--text-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-input-button:hover {
            background-color: #f1f1f1;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-name {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }

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
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Materi untuk Kelas: <?= esc($kelas['nama_kelas']) ?></h1>

        <div class="form-container">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
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

            <form action="<?= site_url('guru/updateMateri/' . esc($materi['id'])) ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="materi_id" value="<?= esc($materi['id']) ?>">
                <input type="hidden" name="kelas_id" value="<?= esc($kelas['id']) ?>">
                <input type="hidden" name="old_file_path" value="<?= esc($materi['file_path']) ?>">

                <div class="form-group">
                    <label for="judul">Judul Materi:</label>
                    <input type="text" name="judul" id="judul" required value="<?= old('judul', $materi['judul']) ?>">
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['judul'])) : ?>
                        <span class="error-message"><?= esc(session()->getFlashdata('errors')['judul']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="file_materi">File Materi (PDF, opsional untuk diubah):</label>
                    <div class="file-input-container">
                        <div class="file-input-button">
                            <span id="file-label">Pilih File PDF Baru</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <input type="file" name="file_materi" id="file_materi" class="file-input" accept="application/pdf" onchange="updateFileName(this)">
                    </div>
                    <div id="file-name" class="file-name">
                        File saat ini: **<?= esc($materi['file_name'] ?? 'N/A') ?>**
                        <?php
                        // Tampilkan nama file jika ada di old input (hanya untuk pesan jika validasi gagal)
                        if (old('file_materi')) {
                            echo "<br>File sebelumnya (gagal diunggah): " . esc(old('file_materi'));
                        }
                        ?>
                    </div>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['file_materi'])) : ?>
                        <span class="error-message"><?= esc(session()->getFlashdata('errors')['file_materi']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="level">Level (Maksimal: <?= esc($kelas['jumlah_level']) ?>):</label>
                    <input type="number" name="level" id="level" min="1" required value="<?= old('level', $materi['level']) ?>">
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['level'])) : ?>
                        <span class="error-message"><?= esc(session()->getFlashdata('errors')['level']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="point">Point:</label>
                    <input type="number" name="point" id="point" min="0" required value="<?= old('point', $materi['point'] ?? 0) ?>"> <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['point'])) : ?>
                        <span class="error-message"><?= esc(session()->getFlashdata('errors')['point']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="button button-primary">Simpan Perubahan</button>
                    <a href="<?= site_url('guru/detailKelas/' . esc($kelas['id'])) ?>" class="button button-secondary">Kembali ke Detail Kelas</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameContainer = document.getElementById('file-name');
            const fileLabel = document.getElementById('file-label');

            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                fileNameContainer.innerHTML = `File terpilih: <strong>${fileName}</strong>`;
                fileLabel.textContent = "Ubah File";
            } else {
                const oldFileName = "<?= esc($materi['file_name'] ?? 'N/A') ?>";
                fileNameContainer.innerHTML = `File saat ini: <strong>${oldFileName}</strong>`;
                fileLabel.textContent = 'Pilih File PDF Baru';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file_materi');
            if (fileInput) {
                updateFileName(fileInput);
            }
        });
    </script>
</body>

</html>