<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Kelas - Kelas Sastra Jepang</title>
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
    <style>
        .review-section {
            margin-top: 2rem;
        }

        .review-summary {
            background-color: var(--light);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .summary-title {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-label {
            font-weight: 500;
            color: var(--dark);
        }

        .summary-value {
            color: var(--gray);
        }

        .button-container {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }

        .back-button,
        .all-classes-button {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .back-button:hover,
        .all-classes-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .button-icon {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="class-title"><?= esc($kelas['nama_kelas']); ?></h1>
            <p class="class-description"><?= esc($kelas['deskripsi']); ?></p>
        </div>

        <div class="review-section">
            <div class="review-summary">
                <h2 class="summary-title">Ringkasan Kelas</h2>
                <div class="summary-item">
                    <span class="summary-label">Total Materi Score:</span>
                    <span class="summary-value"><?= esc($rangkuman['total_materi_score']); ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Quiz Score:</span>
                    <span class="summary-value"><?= esc($rangkuman['total_quiz_score']); ?> / <?= esc($rangkuman['total_max_quiz_score']); ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Jumlah Materi:</span>
                    <span class="summary-value"><?= esc($rangkuman['jumlah_materi']); ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Jumlah Quiz:</span>
                    <span class="summary-value"><?= esc($rangkuman['jumlah_quiz']); ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Tanggal Ambil Kelas:</span>
                    <span
                        class="summary-value"
                        data-datetime="<?= esc($rangkuman['tanggal_ambil']); ?>"></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Tanggal Selesai Kelas:</span>
                    <span
                        class="summary-value"
                        data-datetime="<?= esc($rangkuman['tanggal_selesai']); ?>"></span>
                </div>

            </div>
        </div>

        <div class="button-container">
            <a href="<?= site_url('murid/detailKelas/' . $kelas['id']); ?>" class="back-button"><i class="fas fa-arrow-left button-icon"></i> Kembali ke Halaman Kelas</a>
            <a href="<?= site_url('murid/semuaKelas'); ?>" class="all-classes-button"><i class="fas fa-home button-icon"></i> Lihat Semua Kelas</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // pilih semua .summary-value yang punya data-datetime
            document.querySelectorAll('.summary-value[data-datetime]')
                .forEach(el => {
                    const raw = el.dataset.datetime;
                    if (!raw) return;

                    // ubah spasi menjadi 'T' supaya menjadi format ISO
                    const iso = raw.replace(' ', 'T');
                    const d = new Date(iso);

                    // format tanggal ke Indonesia: "10 Juni 2025"
                    const fmt = new Intl.DateTimeFormat('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

                    el.textContent = fmt.format(d);
                });
        });
    </script>

</body>

</html>