<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Murid Kelas: <?= esc($kelas['nama_kelas']) ?></title>
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
            --danger-red: #dc3545;
            /* Adjusted for alert */
            --danger-bg: #f8d7da;
            --danger-border: #f5c6cb;
            --warning-orange: #ffc107;
            /* For "Belum Dimulai" status */
            --info-blue: #17a2b8;
            /* For "Sedang Proses" status */
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
            /* Reusing class name for styling consistency */
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: var(--box-shadow-light);
            margin-top: 20px;
        }

        .leaderboard-table {
            /* Reusing class name for styling consistency */
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
            margin-bottom: 10px;
            /* Space between rows */
            display: table-row;
        }

        .leaderboard-table tbody tr:not(:last-child) {
            margin-bottom: 10px;
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
            text-align: center;
        }

        .alert-danger {
            background-color: var(--danger-bg);
            color: var(--danger-red);
            border: 1px solid var(--danger-border);
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: .35em .65em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .badge-success {
            background-color: var(--success-green);
            color: white;
        }

        .badge-primary {
            background-color: var(--primary-blue);
            color: white;
        }

        .badge-warning {
            background-color: var(--warning-orange);
            color: var(--text-dark);
        }

        .badge-secondary {
            background-color: var(--secondary-gray);
            color: white;
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

            .pagination-links ul {
                justify-content: center;
                gap: 5px;
            }

            .pagination-links li a,
            .pagination-links li span {
                padding: 8px 12px;
                font-size: 0.85em;
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

            .pagination-links li a,
            .pagination-links li span {
                padding: 6px 10px;
                font-size: 0.8em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Daftar Murid Kelas: <?= esc($kelas['nama_kelas']) ?></h1>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($muridList)) : ?>
            <p class="no-data">Belum ada murid yang bergabung ke kelas ini.</p>
        <?php else : ?>
            <div class="leaderboard-table-container">
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Username Murid</th>
                            <th>Email Murid</th>
                            <th>Status Bergabung</th>
                            <th>Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Menghitung nomor urut awal untuk halaman saat ini
                        $perPage = $pager->getPerPage(); // Ambil jumlah item per halaman dari objek pager
                        $currentPage = $pager->getCurrentPage(); // Ambil halaman saat ini
                        $no = 1 + ($currentPage - 1) * $perPage;
                        ?>
                        <?php foreach ($muridList as $murid) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($murid['username']) ?></td>
                                <td><?= esc($murid['email']) ?></td>
                                <td>
                                    <?php
                                    // Sesuaikan status yang ingin ditampilkan
                                    if ($murid['status'] == 'selesai') {
                                        echo '<span class="badge badge-success">Selesai Kelas</span>';
                                    } elseif ($murid['status'] == 'proses') {
                                        echo '<span class="badge badge-primary">Sedang Proses</span>';
                                    } elseif ($murid['status'] == 'belum_dimulai') {
                                        echo '<span class="badge badge-warning">Belum Dimulai</span>';
                                    } else {
                                        echo '<span class="badge badge-secondary">' . esc($murid['status']) . '</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= esc(date('d F Y H:i', strtotime($murid['tanggal_join']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <div class="pagination-container">
                <?= $pager->links() ?>
            </div>

        <?php endif; ?>

        <a href="<?= site_url('guru/viewClasses') ?>" class="back-button">
            Kembali ke Daftar Kelas
        </a>
    </div>
</body>

</html>