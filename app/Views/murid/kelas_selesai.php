<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Telah Selesai</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f9fafb;
            --success-color: #10b981;
            --text-color: #1f2937;
            --light-gray: #e5e7eb;
            --dark-gray: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--dark-gray);
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 60px 40px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--light-gray);
            margin-bottom: 20px;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: var(--dark-gray);
            margin-bottom: 25px;
        }

        .classes-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .class-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .completed-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--success-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .class-card h2 {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-right: 80px;
        }

        .class-description {
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .materials-section,
        .quizzes-section {
            margin: 25px 0;
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
        }

        .item-list {
            list-style: none;
        }

        .item-card {
            background-color: var(--secondary-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-color);
        }

        .item-title {
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .item-title i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .item-meta {
            display: flex;
            margin: 8px 0;
            font-size: 0.85rem;
        }

        .item-level {
            background-color: #e0e7ff;
            color: var(--primary-color);
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
            margin-right: 10px;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-top: 8px;
            transition: color 0.3s ease;
        }

        .action-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        .action-link i {
            margin-right: 5px;
            font-size: 0.9rem;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
        }

        .btn-container {
            text-align: center;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .classes-container {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 2rem;
            }

            .class-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Kelas Telah Selesai</h1>
            <p class="subtitle">Lihat kembali pencapaian pembelajaran Anda</p>
        </header>

        <?php if (empty($kelasList)): ?>
            <div class="empty-state">
                <i class="fas fa-trophy"></i>
                <p>Anda belum menyelesaikan kelas apapun</p>
                <a href="/murid/semuaKelas" class="btn btn-primary">Jelajahi Kelas</a>
            </div>
        <?php else: ?>
            <div class="classes-container">
                <?php foreach ($kelasList as $kelas): ?>
                    <div class="class-card">
                        <span class="completed-badge">Selesai</span>
                        <h2><?= esc($kelas['nama_kelas']) ?></h2>
                        <p class="class-description"><?= esc($kelas['deskripsi']) ?></p>

                        <div class="materials-section">
                            <h3 class="section-title"><i class="fas fa-book-open"></i> Materi</h3>
                            <ul class="item-list">
                                <?php foreach ($kelas['materi'] as $item): ?>
                                    <li class="item-card">
                                        <h4 class="item-title"><i class="fas fa-file-alt"></i> <?= esc($item['judul']) ?></h4>
                                        <div class="item-meta">
                                            <span class="item-level">Level: <?= esc($item['level']) ?></span>
                                        </div>
                                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="action-link">
                                            <i class="fas fa-external-link-alt"></i> Lihat Materi
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="quizzes-section">
                            <h3 class="section-title"><i class="fas fa-question-circle"></i> Quiz</h3>
                            <ul class="item-list">
                                <?php foreach ($kelas['quiz'] as $item): ?>
                                    <li class="item-card">
                                        <h4 class="item-title"><i class="fas fa-clipboard-check"></i> <?= esc($item['judul_quiz']) ?></h4>
                                        <div class="item-meta">
                                            <span class="item-level">Level: <?= esc($item['level']) ?></span>
                                        </div>
                                        <a href="<?= base_url('murid/viewQuiz/' . esc($item['id'])) ?>" class="action-link">
                                            <i class="fas fa-eye"></i> Lihat Soal Quiz
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="btn-container">
            <a href="/murid/dashboard" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>