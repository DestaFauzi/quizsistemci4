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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1rem;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: var(--secondary);
        }

        .back-btn i {
            margin-right: 0.5rem;
        }

        .classes-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .classes-table {
            width: 100%;
            border-collapse: collapse;
        }

        .classes-table thead {
            background-color: var(--primary);
            color: white;
        }

        .classes-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 500;
        }

        .classes-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .classes-table tr:last-child td {
            border-bottom: none;
        }

        .status {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-aktif {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }

        .status-non_aktif {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 0.5rem 0.8rem;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .action-btn i {
            margin-right: 0.3rem;
            font-size: 0.8rem;
        }

        .edit-btn {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .edit-btn:hover {
            background-color: rgba(67, 97, 238, 0.2);
        }

        .detail-btn {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--accent);
        }

        .detail-btn:hover {
            background-color: rgba(76, 201, 240, 0.2);
        }

        .materi-btn {
            background-color: rgba(75, 181, 67, 0.1);
            color: var(--success);
        }

        .materi-btn:hover {
            background-color: rgba(75, 181, 67, 0.2);
        }

        .quiz-btn {
            background-color: rgba(240, 173, 78, 0.1);
            color: var(--warning);
        }

        .quiz-btn:hover {
            background-color: rgba(240, 173, 78, 0.2);
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        .empty-state p {
            margin-bottom: 1rem;
        }

        .create-btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .create-btn:hover {
            background-color: var(--secondary);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .classes-table thead {
                display: none;
            }

            .classes-table tr {
                display: block;
                margin-bottom: 1rem;
                border-bottom: 1px solid #eee;
            }

            .classes-table td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: none;
            }

            .classes-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: calc(50% - 1rem);
                padding-right: 1rem;
                font-weight: 500;
                text-align: left;
                color: var(--primary);
            }

            .action-buttons {
                justify-content: flex-end;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Daftar Kelas Anda</h1>
            <a href="/guru/dashboard" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="classes-container">
            <?php if (empty($kelas)): ?>
                <div class="empty-state">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <p>Anda belum memiliki kelas</p>
                    <a href="/guru/createClass" class="create-btn">
                        <i class="fas fa-plus"></i> Buat Kelas Baru
                    </a>
                </div>
            <?php else: ?>
                <table class="classes-table">
                    <thead>
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelas as $kelasItem): ?>
                            <tr>
                                <td data-label="Nama Kelas">
                                    <strong><?= esc($kelasItem['nama_kelas']) ?></strong>
                                </td>
                                <td data-label="Deskripsi">
                                    <?= esc($kelasItem['deskripsi']) ?>
                                </td>
                                <td data-label="Status">
                                    <span class="status status-<?= esc($kelasItem['status']) ?>">
                                        <?= esc($kelasItem['status']) ?>
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="/guru/editClass/<?= $kelasItem['id'] ?>" class="action-btn edit-btn">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="/guru/detailKelas/<?= $kelasItem['id'] ?>" class="action-btn detail-btn">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="/guru/addMateri/<?= $kelasItem['id'] ?>" class="action-btn materi-btn">
                                            <i class="fas fa-book"></i> Materi
                                        </a>
                                        <a href="/guru/addQuiz/<?= $kelasItem['id'] ?>" class="action-btn quiz-btn">
                                            <i class="fas fa-question-circle"></i> Quiz
                                        </a>
                                        <a href="/guru/viewLeaderboard/<?= $kelasItem['id'] ?>" class="action-btn leaderboard-btn">
                                            <i class="fas fa-trophy"></i> Leaderboard
                                        </a>
                                        <a href="/guru/viewlistmurid/<?= $kelasItem['id'] ?>" class="action-btn list-btn">
                                            <i class="fas fa-users"></i> List Murid
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>