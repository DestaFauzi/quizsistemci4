<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz</title>
    <style>
        :root {
            --primary-color: #4a6bff;
            --secondary-color: #f8f9fa;
            --danger-color: #dc3545;
            --text-color: #333;
            --border-color: #ddd;
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
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }

        h2 {
            color: var(--primary-color);
            margin-top: 30px;
        }

        .quiz-info {
            background: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .quiz-info p {
            margin: 5px 0;
            flex: 1 1 200px;
        }

        .question-list {
            list-style: none;
            padding: 0;
        }

        .question-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .question-item strong {
            color: var(--primary-color);
        }

        .options {
            margin-left: 20px;
            margin-top: 10px;
        }

        .correct-answer {
            color: #28a745;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .button-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .button-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .button-secondary {
            background-color: #6c757d;
            color: white;
        }

        .button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .no-questions {
            background: var(--secondary-color);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detail Quiz: <?= esc($quiz['judul_quiz']) ?></h1>

        <div class="quiz-info">
            <p><strong>Level:</strong> <?= esc($quiz['level']) ?></p>
            <p><strong>Jumlah Soal:</strong> <?= esc($quiz['jumlah_soal']) ?></p>
            <p><strong>Waktu:</strong> <?= esc($quiz['waktu']) ?> menit</p>
        </div>

        <h2>Soal-Soal Quiz</h2>
        <!-- Button untuk menambah soal -->
        <a href="<?= site_url('guru/editSoal/' . esc($quiz['id'])) ?>">
            <button class="button button-primary">Edit Soal</button>
        </a>
        <?php if (empty($soal)): ?>
            <div class="no-questions">
                <p>Belum ada soal untuk quiz ini.</p>
            </div>
        <?php else: ?>
            <ul class="question-list">
                <?php foreach ($soal as $item): ?>
                    <li class="question-item">
                        <div class="question">
                            <strong>Soal:</strong> <?= esc($item['soal']) ?>
                        </div>
                        <div class="options">
                            <p><strong>A:</strong> <?= esc($item['jawaban_a']) ?></p>
                            <p><strong>B:</strong> <?= esc($item['jawaban_b']) ?></p>
                            <p><strong>C:</strong> <?= esc($item['jawaban_c']) ?></p>
                            <p><strong>D:</strong> <?= esc($item['jawaban_d']) ?></p>
                        </div>
                        <div class="correct-answer">
                            <strong>Jawaban Benar:</strong> <?= esc($item['jawaban_benar']) ?>
                        </div>
                        <p><strong>Poin:</strong> <?= esc($item['poin']) ?></p>

                        <!-- Button untuk menghapus soal -->
                        <a href="<?= site_url('guru/hapusSoal/' . esc($item['id'])) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">
                            <button class="button button-danger">Hapus Soal</button>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="action-buttons">
            <!-- Button untuk kembali ke halaman detail kelas -->
            <a href="/guru/detailKelas/<?= esc($quiz['kelas_id']) ?>">
                <button class="button button-secondary">Kembali ke Detail Kelas</button>
            </a>
        </div>
    </div>
</body>

</html>