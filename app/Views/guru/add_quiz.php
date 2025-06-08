<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Quiz | Sistem Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: var(--primary);
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .btn {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-danger {
            background-color: #e63946;
        }

        .btn-danger:hover {
            background-color: #c1121f;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .info-badge {
            background-color: #e9ecef;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .info-badge i {
            margin-right: 10px;
            color: var(--primary);
        }

        .flash-alert {
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            font-weight: 500;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .flash-alert i {
            margin-right: 10px;
        }

        .flash-danger {
            background-color: rgba(217, 83, 79, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-plus-circle"></i> Tambah Quiz Baru</h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            <span>Anda menambahkan quiz untuk Kelas: <strong><?= esc($kelas_id) ?></strong></span>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="flash-alert flash-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('/guru/saveQuiz') ?>" method="POST">
            <input type="hidden" name="kelas_id" value="<?= esc($kelas_id) ?>">

            <div class="form-group">
                <label for="judul_quiz"><i class="fas fa-heading"></i> Judul Quiz</label>
                <input type="text" name="judul_quiz" id="judul_quiz" placeholder="Masukkan judul quiz" required value="<?= old('judul_quiz') ?>">
            </div>

            <div class="form-group">
                <label for="jumlah_soal"><i class="fas fa-list-ol"></i> Jumlah Soal</label>
                <input type="number" name="jumlah_soal" id="jumlah_soal" min="1" placeholder="Jumlah soal dalam quiz" required value="<?= old('jumlah_soal') ?>">
            </div>

            <div class="form-group">
                <label for="waktu"><i class="fas fa-clock"></i> Waktu Pengerjaan (menit)</label>
                <input type="number" name="waktu" id="waktu" min="1" placeholder="Durasi quiz dalam menit" required value="<?= old('waktu') ?>">
            </div>

            <div class="form-group">
                <label for="level">Level :</label><br>
                <input type="number" name="level" id="level" min="1" required value="<?= old('level') ?>"><br><br>
            </div>

            <div class="action-buttons">
                <a href="/guru/viewClasses" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Simpan Quiz
                </button>
            </div>
        </form>
    </div>
</body>

</html>