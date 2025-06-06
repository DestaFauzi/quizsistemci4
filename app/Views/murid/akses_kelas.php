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
            position: relative;
            display: inline-block;
        }

        .class-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
        }

        .class-description {
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 800px;
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
            border-left-color: var(--primary);
            transform: translateX(5px);
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
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
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
        }

        .locked-message i {
            margin-right: 0.5rem;
            color: var(--warning);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .continue-btn {
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

        .continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .continue-btn i {
            margin-left: 0.5rem;
        }

        .back-btn {
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

        .back-btn:hover {
            background-color: #f8f9fa;
            border-color: var(--primary);
        }

        .back-btn i {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="class-title"><?= esc($kelas['nama_kelas']) ?></h1>
            <p class="class-description"><?= esc($kelas['deskripsi']) ?></p>
            <p class="class-description">
                <strong>Jumlah Level:</strong> <?= esc($kelas['jumlah_level']) ?>
        </div>

        <div class="content-section">
            <div class="section-card">
                <div class="section-header">
                    <h2><i class="fas fa-book"></i> Materi Pembelajaran</h2>
                </div>

                <div class="material-list">
                    <?php foreach ($materi as $item): ?>
                        <div class="item-card">
                            <div class="item-header">
                                <span class="item-title"><?= esc($item['judul']) ?></span>
                                <span class="item-level">Level <?= esc($item['level']) ?></span>
                            </div>

                            <div class="item-action">
                                <?php if ($item['level'] > 1 && $status_materi_level_1 == 'selesai'): ?>
                                    <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="view-btn">
                                        <i class="fas fa-eye"></i> Lihat Materi
                                    </a>
                                    <form action="/murid/selesaikanMateri/<?= esc($kelas['id']) ?>/<?= esc($item['id']) ?>" method="post" style="display: inline;">
                                        <button type="submit" class="done-btn">
                                            <i class="fas fa-check-circle"></i> Selesai Baca
                                        </button>
                                    </form>
                                <?php elseif ($item['level'] == 1): ?>
                                    <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="view-btn">
                                        <i class="fas fa-eye"></i> Lihat Materi
                                    </a>
                                    <form action="<?= site_url("murid/selesaikanMateri/{$kelas['id']}/{$item['id']}") ?>" method="post" style="display: inline;">
                                        <button type="submit" class="done-btn">
                                            <i class="fas fa-check-circle"></i> Selesai Baca
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <p class="locked-message">
                                        <i class="fas fa-lock"></i> Level <?= esc($item['level']) ?> akan terbuka setelah menyelesaikan level sebelumnya
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <h2><i class="fas fa-question-circle"></i> Quiz & Evaluasi</h2>
                </div>

                <div class="quiz-list">
                    <?php
                    $quizSelesai = [];
                    foreach ($quiz as $item) {
                        $quizSelesai[$item['level']] = (isset($item['status_quiz']) && $item['status_quiz'] == 'selesai');
                    }
                    ?>
                    <?php foreach ($quiz as $item): ?>
                        <div class="item-card">
                            <div class="item-header">
                                <span class="item-title"><?= esc($item['judul_quiz']) ?></span>
                                <span class="item-level">Level <?= esc($item['level']) ?></span>
                            </div>

                            <div class="item-action">
                                <?php
                                $level = $item['level'];
                                $prevLevel = $level - 1;
                                $isSelesai = isset($item['status_quiz']) && $item['status_quiz'] == 'selesai';
                                $prevSelesai = ($level == 1) ? true : (!empty($quizSelesai[$prevLevel]));
                                ?>
                                <?php if ($isSelesai): ?>
                                    <button class="done-btn" disabled>
                                        <i class="fas fa-check-circle"></i> Quiz ini selesai
                                    </button>
                                <?php elseif ($prevSelesai): ?>
                                    <a href="<?= base_url('/murid/aksesQuiz/' . esc($item['id'])) ?>" class="view-btn">
                                        <i class="fas fa-play"></i> Kerjakan Quiz
                                    </a>
                                <?php else: ?>
                                    <p class="locked-message">
                                        <i class="fas fa-lock"></i> Quiz level <?= esc($item['level']) ?> akan terbuka setelah menyelesaikan level sebelumnya
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="/murid/dashboard" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>