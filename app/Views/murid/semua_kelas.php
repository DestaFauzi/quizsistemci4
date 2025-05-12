<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Kelas - BahasaKita</title>
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
            --warning: #f0ad4e;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .header h1 {
            font-size: 2rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .header h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--accent);
            border-radius: 2px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.7rem 1.2rem;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .back-btn i {
            margin-right: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 2rem;
        }

        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .class-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .class-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            position: relative;
        }

        .class-header h2 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .class-body {
            padding: 1.5rem;
        }

        .class-description {
            color: var(--gray);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .class-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .class-status {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .status-active {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }

        .status-inactive {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger);
        }

        .detail-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.8rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .detail-btn:hover {
            background-color: var(--secondary);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .detail-btn i {
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1.5rem;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .classes-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Semua Kelas</h1>
            <a href="/murid/dashboard" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <?php if (empty($kelas)): ?>
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h3>Belum ada kelas yang tersedia</h3>
                <p>Saat ini tidak ada kelas yang dapat ditampilkan. Silakan coba lagi nanti.</p>
            </div>
        <?php else: ?>
            <div class="classes-grid">
                <?php foreach ($kelas as $item): ?>
                    <div class="class-card">
                        <div class="class-header">
                            <h2><?= esc($item['nama_kelas']) ?></h2>
                        </div>
                        <div class="class-body">
                            <p class="class-description"><?= esc($item['deskripsi']) ?></p>

                            <div class="class-meta">
                                <span class="class-status status-<?= esc($item['status'] === 'aktif' ? 'active' : 'inactive') ?>">
                                    <?= esc($item['status']) ?>
                                </span>
                            </div>

                            <a href="<?= base_url('murid/detailKelas/' . $item['id']) ?>" class="detail-btn">
                                Lihat Detail Kelas <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>