<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - <?= esc($kelas['nama_kelas']) ?> | BahasaKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
            --warning: #ffbe0b;
            --danger: #d9534f;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            padding: 2rem;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 2.5rem;
        }

        .class-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .class-description {
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .status-not-started {
            background-color: rgba(108, 117, 125, 0.1);
            color: var(--gray);
        }

        .status-in-progress {
            background-color: rgba(255, 190, 11, 0.1);
            color: var(--warning);
        }

        .status-completed {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }

        .content-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 768px) {
            .content-section {
                grid-template-columns: 1fr;
            }
        }

        .section-card {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #eee;
        }

        .section-header h2 {
            font-size: 1.4rem;
            color: var(--dark);
            display: flex;
            align-items: center;
        }

        .section-header h2 i {
            margin-right: 0.8rem;
            color: var(--primary);
        }

        .flash-alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-top: -20px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            font-weight: 500;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .flash-alert i {
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        .flash-success {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .flash-danger {
            background-color: rgba(217, 83, 79, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .material-list,
        .quiz-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .item-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .item-card:hover {
            background-color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .item-title {
            font-weight: 500;
            color: var(--dark);
        }

        .item-level {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .item-action {
            margin-top: 0.8rem;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .view-btn:hover {
            background-color: var(--secondary);
            box-shadow: 0 3px 10px rgba(67, 97, 238, 0.2);
        }

        .view-btn i {
            margin-right: 0.5rem;
        }

        .done-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: var(--success);
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .done-btn:hover {
            background-color: #3fa037;
            box-shadow: 0 3px 10px rgba(75, 181, 67, 0.2);
        }

        .done-btn i {
            margin-right: 0.5rem;
        }

        .locked-message {
            color: var(--gray);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 6px;
        }

        .locked-message i {
            margin-right: 0.5rem;
            color: var(--warning);
        }

        .completed-message {
            color: var(--success);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem;
            background-color: rgba(75, 181, 67, 0.1);
            border-radius: 6px;
        }

        .completed-message i {
            margin-right: 0.5rem;
        }

        .completed-message .score {
            font-weight: 600;
            margin-left: 1rem;
            white-space: nowrap;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .primary-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .primary-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .primary-btn i {
            margin-left: 0.5rem;
        }

        .secondary-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background-color: white;
            color: var(--primary);
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .secondary-btn:hover {
            background-color: #f8f9fa;
            border-color: var(--primary);
        }

        .secondary-btn i {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="class-title"><?= esc($kelas['nama_kelas']) ?></h1>
            <p class="class-description"><?= esc($kelas['deskripsi']) ?></p>

            <?php if ($status['status'] == 'belum_dimulai'): ?>
                <span class="status-badge status-not-started">
                    <i class="fas fa-hourglass-start"></i> Belum Dimulai
                </span>
            <?php elseif ($status['status'] == 'proses'): ?>
                <span class="status-badge status-in-progress">
                    <i class="fas fa-spinner"></i> Dalam Proses (Level <?= $status['level_materi'] ?>)
                </span>
            <?php else: ?>
                <span class="status-badge status-completed">
                    <i class="fas fa-check-circle"></i> Selesai
                </span>
            <?php endif; ?>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="flash-alert flash-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="flash-alert flash-success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="content-section">
            <div class="section-card">
                <div class="section-header">
                    <h2><i class="fas fa-book"></i> Materi Pembelajaran</h2>
                </div>

                <div class="material-list">
                    <?php if (empty($materi)): ?>
                        <p style="color: var(--gray);">Belum ada materi untuk kelas ini.</p>
                    <?php else: ?>
                        <?php foreach ($materi as $item): ?>
                            <div class="item-card">
                                <div class="item-header">
                                    <span class="item-title"><?= esc($item['judul']) ?></span>
                                    <span class="item-level">Level <?= esc($item['level']) ?></span>
                                </div>

                                <div class="item-action">
                                    <?php if (!$item['can_access']): ?>
                                        <p class="locked-message">
                                            <i class="fas fa-lock"></i>
                                            <?= ($status['status'] == 'belum_dimulai')
                                                ? 'Mulai kelas untuk mengakses materi'
                                                : 'Selesaikan level ' . ($item['level'] - 1) . ' terlebih dahulu' ?>
                                        </p>
                                    <?php else: ?>
                                        <a href="<?= site_url("murid/aksesMateri/{$kelas['id']}/{$item['id']}") ?>" target="_blank" class="view-btn">
                                            <i class="fas fa-eye"></i> Lihat Materi Ini
                                        </a>

                                        <?php if (!$item['is_completed'] && $status['status_materi'] == 'sedang_dibaca'): ?>
                                            <form action="<?= site_url("murid/selesaikanMateri/{$kelas['id']}/{$item['id']}") ?>" method="post" style="display: inline;">
                                                <button type="submit" class="done-btn">
                                                    <i class="fas fa-check-circle"></i> Selesaikan Bacaan
                                                </button>
                                            </form>
                                        <?php elseif ($item['is_completed'] || $status['status_materi'] == 'selesai'): ?>
                                            <span class="done-btn">
                                                <i class="fas fa-check"></i> Sudah Dibaca
                                            </span>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <h2><i class="fas fa-question-circle"></i> Quiz & Evaluasi</h2>
                </div>

                <div class="quiz-list">
                    <?php if (empty($quiz)): ?>
                        <p style="color: var(--gray);">Belum ada quiz untuk kelas ini.</p>
                    <?php else: ?>
                        <?php foreach ($quiz as $item): ?>
                            <div class="item-card">
                                <div class="item-header">
                                    <span class="item-title"><?= esc($item['judul_quiz']) ?></span>
                                    <span class="item-level">Level <?= esc($item['level']) ?></span>
                                </div>

                                <div class="item-action">
                                    <?php if ($status['status'] == 'belum_dimulai'): ?>
                                        <p class="locked-message">
                                            <i class="fas fa-lock"></i> Mulai kelas untuk mengakses quiz
                                        </p>
                                    <?php elseif ($item['can_access']): ?>
                                        <?php if ($item['is_completed']): ?>
                                            <p class="completed-message">
                                                <span>
                                                    <i class="fas fa-check-circle"></i> Quiz ini sudah selesai
                                                </span>
                                                <span class="score">
                                                    <?= $item['score']; ?>/<?= $item['max_score']; ?>
                                                </span>
                                            </p>

                                        <?php else: ?>
                                            <a href="<?= site_url("/murid/aksesQuiz/{$kelas['id']}/{$item['id']}") ?>" class="view-btn">
                                                <i class="fas fa-play"></i> Kerjakan Quiz
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="locked-message">
                                            <i class="fas fa-lock"></i> Selesaikan semua materi hingga level <?= $item['level'] ?> terlebih dahulu
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <?php if ($status['status'] == 'belum_dimulai'): ?>
                <a href="<?= site_url('murid/masukKelas/' . $kelas['id']) ?>" class="primary-btn">
                    Mulai Belajar <i class="fas fa-arrow-right"></i>
                </a>
            <?php elseif ($status['status'] == 'proses'): ?>
                <a href="<?= site_url('murid/lanjutkanKelas/' . $kelas['id']) ?>" class="primary-btn">
                    Lanjutkan Belajar <i class="fas fa-arrow-right"></i>
                </a>
            <?php elseif ($status['status'] == 'selesai'): ?>
                <a href="<?= site_url('murid/reviewKelas/' . $kelas['id']) ?>" class="primary-btn">
                    <i class="fas fa-redo"></i> Review Kelas
                </a>
            <?php endif; ?>

            <a href="/murid/semuaKelas" class="secondary-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Semua Kelas
            </a>
        </div>
    </div>
</body>

</html>