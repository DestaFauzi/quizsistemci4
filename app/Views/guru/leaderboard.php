<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard Kelas: <?= esc($leaderboard['nama_kelas']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #007bff;
            --secondary-gray: #6c757d;
            --light-gray: #f4f7f6;
            --white: #ffffff;
            --text-dark: #333;
            --text-medium: #555;
            --text-light: #666;
            --border-light: #eee;
            --hover-bg: #e9e9e9;
            --success-green: #28a745;
            --danger-red: #721c24;
            --danger-bg: #f8d7da;
            --danger-border: #f5c6cb;
            --box-shadow-light: 0 4px 12px rgba(0, 0, 0, 0.06);
            --box-shadow-medium: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            margin: 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--box-shadow-medium);
            width: 100%;
            max-width: 1100px;
            margin-bottom: 30px;
            box-sizing: border-box;
        }

        h1 {
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 35px;
            font-size: 2.5em;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .leaderboard-table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: var(--box-shadow-light);
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 0;
        }

        .leaderboard-table th,
        .leaderboard-table td {
            border: none;
            padding: 15px 20px;
            text-align: left;
            font-size: 0.95em;
        }

        .leaderboard-table th {
            background-color: var(--primary-blue);
            color: var(--white);
            font-weight: 600;
            text-transform: capitalize;
            padding: 18px 20px;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .leaderboard-table thead tr:first-child th:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .leaderboard-table thead tr:first-child th:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }


        .leaderboard-table tbody tr {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .leaderboard-table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .leaderboard-table td:first-child {
            border-bottom-left-radius: 8px;
            border-top-left-radius: 8px;
        }

        .leaderboard-table td:last-child {
            border-bottom-right-radius: 8px;
            border-top-right-radius: 8px;
        }


        .leaderboard-table td.rank {
            text-align: center;
            font-weight: 600;
            color: var(--text-medium);
            width: 80px;
        }

        .leaderboard-table td.total-score {
            font-weight: 700;
            color: var(--success-green);
            font-size: 1.1em;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: var(--text-light);
            font-style: italic;
            font-size: 1.1em;
            background-color: #fefefe;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: fit-content;
            margin: 30px auto 0;
            padding: 12px 25px;
            background-color: var(--secondary-gray);
            color: var(--white);
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 600;
            font-size: 1em;
            letter-spacing: 0.2px;
        }

        .back-button:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .back-button:active {
            transform: translateY(0);
        }

        .alert {
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert-danger {
            background-color: var(--danger-bg);
            color: var(--danger-red);
            border: 1px solid var(--danger-border);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .pagination li {
            list-style: none;
            margin: 0 6px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 10px 15px;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            text-decoration: none;
            color: var(--primary-blue);
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            font-weight: 500;
        }

        .pagination li a:hover {
            background-color: var(--primary-blue);
            color: var(--white);
            border-color: var(--primary-blue);
        }

        .pagination li.active span {
            background-color: var(--primary-blue);
            color: var(--white);
            border-color: var(--primary-blue);
            font-weight: 600;
        }

        .pagination li.disabled span {
            color: #b0b0b0;
            cursor: not-allowed;
            background-color: #f0f0f0;
            border-color: #eee;
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px;
                margin-bottom: 25px;
            }

            h1 {
                font-size: 2em;
                margin-bottom: 30px;
            }

            .leaderboard-table th,
            .leaderboard-table td {
                padding: 10px 12px;
                font-size: 0.9em;
            }

            .leaderboard-table td.rank {
                width: 60px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8em;
                margin-bottom: 20px;
            }

            .no-data {
                padding: 20px;
                font-size: 1em;
            }

            .back-button {
                padding: 10px 20px;
                font-size: 0.9em;
            }

            .pagination li {
                margin: 0 3px;
            }

            .pagination li a,
            .pagination li span {
                padding: 6px 10px;
                font-size: 0.85em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Leaderboard Kelas: <?= esc($leaderboard['nama_kelas']) ?></h1>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if ($hasStudents) : ?>
            <?php if (!empty($leaderboard['data_murid'])) : ?>
                <div class="leaderboard-table-container">
                    <table class="leaderboard-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Username</th>
                                <th>Total Poin Materi</th>
                                <th>Total Poin Quiz</th>
                                <th>Total Keseluruhan Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $itemsPerPage = $pager->getPerPage() > 0 ? $pager->getPerPage() : 10;
                            $startRank = (($currentPage - 1) * $itemsPerPage) + 1;

                            foreach ($leaderboard['data_murid'] as $index => $murid) :
                            ?>
                                <tr>
                                    <td class="rank"><?= $startRank + $index ?></td>
                                    <td><?= esc($murid['username']) ?></td>
                                    <td><?= esc($murid['total_score_materi']) ?></td>
                                    <td><?= esc($murid['total_score_quiz']) ?></td>
                                    <td class="total-score"><?= esc($murid['total_point']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    <?= $pager->links() ?>
                </div>

            <?php else : ?>
                <p class="no-data">Belum ada aktivitas materi atau kuis untuk kelas ini. Ajak murid Anda untuk mulai belajar!</p>
            <?php endif; ?>
        <?php else : ?>
            <p class="no-data">Belum ada murid yang terdaftar di kelas ini. Daftarkan murid untuk melihat leaderboard!</p>
        <?php endif; ?>

        <a href="<?= site_url('guru/detailKelas/' . esc($kelasId)) ?>" class="back-button">
            Kembali ke Detail Kelas
        </a>
    </div>
</body>

</html>