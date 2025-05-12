<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi</title>
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
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus {
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Materi untuk Kelas: <?= esc($kelas['nama_kelas']) ?></h1>

        <div class="form-container">
            <!-- Form untuk mengunggah materi -->
            <form action="<?= site_url('guru/uploadMateri') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="kelas_id" value="<?= esc($kelas['id']) ?>">

                <div class="form-group">
                    <label for="judul">Judul Materi:</label>
                    <input type="text" name="judul" id="judul" required>
                </div>

                <div class="form-group">
                    <label for="file_materi">File Materi (PDF):</label>
                    <div class="file-input-container">
                        <div class="file-input-button">
                            <span id="file-label">Pilih File PDF</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <input type="file" name="file_materi" id="file_materi" class="file-input" accept="application/pdf" required onchange="updateFileName(this)">
                    </div>
                    <div id="file-name" class="file-name"></div>
                </div>

                <div class="form-group">
                    <label for="level">Level:</label>
                    <input type="number" name="level" id="level" min="1" required>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="button button-primary">Unggah Materi</button>
                    <a href="/guru/viewClasses" class="button button-secondary">Kembali ke Daftar Kelas</a>
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
                fileNameContainer.textContent = `File terpilih: ${fileName}`;
                fileLabel.textContent = "Ubah File";
            } else {
                fileNameContainer.textContent = '';
                fileLabel.textContent = 'Pilih File PDF';
            }
        }
    </script>
</body>

</html>