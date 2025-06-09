<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Dalam Proses</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f9fafb;
            --accent-color: #10b981;
            --text-color: #1f2937;
            --light-gray: #e5e7eb;
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

        .empty-state {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: #6b7280;
        }

        .classes-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .class-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .class-card h2 {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            background-color: #fef3c7;
            color: #92400e;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .progress-container {
            margin: 20px 0;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .progress-bar {
            height: 8px;
            background-color: var(--light-gray);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--accent-color);
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }

        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .back-btn {
            text-align: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .classes-container {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Kelas Dalam Proses</h1>
            <p>Lanjutkan pembelajaran Anda yang tertunda</p>
        </header>

        <?php if (empty($kelasList)): ?>
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <p>Anda tidak memiliki kelas yang sedang dalam proses.</p>
                <a href="/murid/semuaKelas" class="btn btn-secondary" style="margin-top: 20px;">Temukan Kelas Baru</a>
            </div>
        <?php else: ?>
            <div class="classes-container">
                <?php foreach ($kelasList as $kelas): ?>
                    <div class="class-card">
                        <h2><?= esc($kelas['nama_kelas']) ?></h2>
                        <span class="status-badge">Dalam Proses</span>

                        <div class="progress-container">
                            <div class="progress-text">
                                <span>Progress</span>
                                <span><?= $kelas['progress']['persen']; ?>%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= $kelas['progress']['persen']; ?>%"></div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="<?= site_url("murid/detailKelas/{$kelas['id']}") ?>" class="btn btn-primary">Lanjutkan Belajar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="back-btn">
            <a href="/murid/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>