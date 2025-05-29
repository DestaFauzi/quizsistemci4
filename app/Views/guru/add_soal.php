<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal untuk Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .question-card {
            border-left: 4px solid #0d6efd;
            padding: 20px;
            margin-bottom: 25px;
            background-color: #f8faff;
            border-radius: 5px;
        }
        .question-number {
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <h1>Tambah Soal untuk Quiz</h1>

                    <!-- Form untuk menambah soal -->
                    <form action="<?= site_url('/guru/saveSoal') ?>" method="POST">
                        <input type="hidden" name="quiz_id" value="<?= esc($quiz_id) ?>">
                        <input type="hidden" name="jumlah_soal" value="<?= esc($jumlah_soal) ?>">

                        <?php for ($i = 1; $i <= $jumlah_soal; $i++): ?>
                        <div class="question-card">
                            <div class="question-number">Soal <?= $i ?></div>
                            
                            <div class="mb-3">
                                <label for="soal_<?= $i ?>" class="form-label">Pertanyaan:</label>
                                <textarea class="form-control" name="soal_<?= $i ?>" id="soal_<?= $i ?>" rows="3" required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jawaban_a_<?= $i ?>" class="form-label">Jawaban A:</label>
                                    <input type="text" class="form-control" name="jawaban_a_<?= $i ?>" id="jawaban_a_<?= $i ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jawaban_b_<?= $i ?>" class="form-label">Jawaban B:</label>
                                    <input type="text" class="form-control" name="jawaban_b_<?= $i ?>" id="jawaban_b_<?= $i ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jawaban_c_<?= $i ?>" class="form-label">Jawaban C:</label>
                                    <input type="text" class="form-control" name="jawaban_c_<?= $i ?>" id="jawaban_c_<?= $i ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jawaban_d_<?= $i ?>" class="form-label">Jawaban D:</label>
                                    <input type="text" class="form-control" name="jawaban_d_<?= $i ?>" id="jawaban_d_<?= $i ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jawaban_benar_<?= $i ?>" class="form-label">Jawaban Benar:</label>
                                    <select class="form-select" name="jawaban_benar_<?= $i ?>" id="jawaban_benar_<?= $i ?>" required>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                        <option value="d">D</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="poin_<?= $i ?>" class="form-label">Poin:</label>
                                    <input type="number" class="form-control" name="poin_<?= $i ?>" id="poin_<?= $i ?>" required>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/guru/viewClasses" class="btn btn-secondary me-md-2">
                                Kembali ke Daftar Kelas
                            </a>
                            <button type="submit" class="btn btn-primary">Simpan Soal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>