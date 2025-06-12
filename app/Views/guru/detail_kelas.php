<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas: <?= esc($kelas['nama_kelas']) ?> | Sistem Pembelajaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --secondary: #f9fafb;
            --text: #1f2937;
            --text-light: #6b7280;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --warning-light: rgb(253, 184, 65);
            --info: #0ea5e9;
            --info-light: #38bdf8;
            --danger: #ef4444;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --card-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            color: var(--text);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 30px;
        }

        .header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        h1 {
            color: var(--primary);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .class-description {
            color: var(--text-light);
            font-size: 16px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 22px;
            color: var(--primary);
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-empty {
            text-align: center;
            padding: 30px;
            background-color: #f9fafb;
            border-radius: 8px;
            color: var(--text-light);
            margin-bottom: 30px;
        }

        .card-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .card {
            background: var(--white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .card-detail {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .card-detail i {
            margin-right: 10px;
            color: var(--text-light);
            width: 20px;
            text-align: center;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
        }

        .btn-info {
            background-color: var(--info);
            color: var(--white);
        }

        .btn-info:hover {
            background-color: var(--info-light);
        }

        .btn-warning {
            background-color: var(--warning);
            color: var(--black);
        }

        .btn-warning:hover {
            background-color: var(--warning-light);
        }

        .btn-danger {
            background-color: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: var(--text);
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .footer-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }

        .level-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            background-color: #e0e7ff;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Detail Kelas: <?= esc($kelas['nama_kelas']) ?></h1>
            <p class="class-description"><strong>Deskripsi:</strong> <?= esc($kelas['deskripsi']) ?></p>
            <p class="class-description"><strong>Status:</strong>
                <?php if ($kelas['status'] == 'aktif'): ?>
                    <span style="color: var(--success);">Aktif</span>
                <?php else: ?>
                    <span style="color: var(--warning);">Non-Aktif</span>
                <?php endif; ?>
            </p>
            <p class="class-description"><strong>Jumlah Level:</strong> <?= esc($kelas['jumlah_level']) ?></p>
        </div>

        <h2><i class="fas fa-book-open"></i> Materi Pembelajaran</h2>
        <?php if (empty($materi)): ?>
            <div class="section-empty">
                <i class="fas fa-book" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p>Belum ada materi untuk kelas ini.</p>
            </div>
        <?php else: ?>
            <div class="card-list">
                <?php foreach ($materi as $item): ?>
                    <div class="card">
                        <h3 class="card-title"><?= esc($item['judul']) ?></h3>
                        <div class="card-detail">
                        </div>
                        <div class="card-detail">
                            <i class="fas fa-chart-line"></i>
                            <span>Level: <span class="level-badge"><?= esc($item['level']) ?></span></span>
                            <span style="margin-left: 10px;">Point: <?= esc($item['point']) ?></span>
                        </div>
                        <div class="card-actions">
                            <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="<?= site_url('guru/materi/' . esc($item['id']) . '/murid') ?>" class="btn btn-info">
                                <i class="fas fa-users"></i> List Murid
                            </a>
                            <a href="<?= site_url('guru/editMateri/' . esc($item['id'])) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="<?= site_url('guru/hapusMateri/' . esc($item['id'])) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h2><i class="fas fa-question-circle"></i> Quiz & Evaluasi</h2>
        <?php if (empty($quiz)): ?>
            <div class="section-empty">
                <i class="fas fa-clipboard-list" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p>Belum ada quiz untuk kelas ini.</p>
            </div>
        <?php else: ?>
            <div class="card-list">
                <?php foreach ($quiz as $item): ?>
                    <div class="card">
                        <h3 class="card-title"><?= esc($item['judul_quiz']) ?></h3>
                        <div class="card-detail">
                            <i class="fas fa-list-ol"></i>
                            <span>Jumlah Soal: <?= esc($item['jumlah_soal']) ?></span>
                            <span style="margin-left: 10px;">Level: <span class="level-badge"><?= esc($item['level']) ?></span></span>
                        </div>
                        <div class="card-detail">
                            <i class="fas fa-clock"></i>
                            <span>Waktu Pengerjaan: <?= esc($item['waktu']) ?> menit</span>
                        </div>
                        <div class="card-actions">
                            <a href="<?= base_url('guru/viewQuiz/' . esc($item['id'])) ?>" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Quiz
                            </a>
                            <a href="<?= site_url('guru/hapusQuiz/' . esc($item['id'])) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus quiz ini?')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="footer-actions">
            <a href="/guru/viewClasses" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelas
            </a>
        </div>
    </div>
</body>

</html>