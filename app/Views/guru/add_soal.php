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

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <h1>Tambah Soal untuk Quiz</h1>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php $errors = session()->getFlashdata('errors'); ?>

                    <form action="<?= site_url('/guru/saveSoal') ?>" method="POST">
                        <input type="hidden" name="quiz_id" value="<?= esc($quiz_id) ?>">
                        <input type="hidden" name="jumlah_soal" value="<?= esc($jumlah_soal) ?>">

                        <?php for ($i = 1; $i <= $jumlah_soal; $i++): ?>
                            <div class="question-card">
                                <div class="question-number">Soal <?= $i ?></div>

                                <div class="mb-3">
                                    <label for="soal_<?= $i ?>" class="form-label">Pertanyaan:</label>
                                    <textarea class="form-control <?= isset($errors['soal_' . $i]) ? 'is-invalid' : '' ?>" name="soal_<?= $i ?>" id="soal_<?= $i ?>" rows="3" required><?= old('soal_' . $i) ?></textarea>
                                    <?php if (isset($errors['soal_' . $i])): ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['soal_' . $i] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jawaban_a_<?= $i ?>" class="form-label">Jawaban A:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_a_' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_a_<?= $i ?>" id="jawaban_a_<?= $i ?>" value="<?= old('jawaban_a_' . $i) ?>" required>
                                        <?php if (isset($errors['jawaban_a_' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_a_' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jawaban_b_<?= $i ?>" class="form-label">Jawaban B:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_b_' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_b_<?= $i ?>" id="jawaban_b_<?= $i ?>" value="<?= old('jawaban_b_' . $i) ?>" required>
                                        <?php if (isset($errors['jawaban_b_' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_b_' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jawaban_c_<?= $i ?>" class="form-label">Jawaban C:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_c_' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_c_<?= $i ?>" id="jawaban_c_<?= $i ?>" value="<?= old('jawaban_c_' . $i) ?>" required>
                                        <?php if (isset($errors['jawaban_c_' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_c_' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jawaban_d_<?= $i ?>" class="form-label">Jawaban D:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_d_' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_d_<?= $i ?>" id="jawaban_d_<?= $i ?>" value="<?= old('jawaban_d_' . $i) ?>" required>
                                        <?php if (isset($errors['jawaban_d_' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_d_' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jawaban_benar_<?= $i ?>" class="form-label">Jawaban Benar:</label>
                                        <select class="form-select <?= isset($errors['jawaban_benar_' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_benar_<?= $i ?>" id="jawaban_benar_<?= $i ?>" required>
                                            <option value="a" <?= old('jawaban_benar_' . $i) === 'a' ? 'selected' : '' ?>>A</option>
                                            <option value="b" <?= old('jawaban_benar_' . $i) === 'b' ? 'selected' : '' ?>>B</option>
                                            <option value="c" <?= old('jawaban_benar_' . $i) === 'c' ? 'selected' : '' ?>>C</option>
                                            <option value="d" <?= old('jawaban_benar_' . $i) === 'd' ? 'selected' : '' ?>>D</option>
                                        </select>
                                        <?php if (isset($errors['jawaban_benar_' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_benar_' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="poin_<?= $i ?>" class="form-label">Poin:</label>
                                        <input type="number" class="form-control <?= isset($errors['poin_' . $i]) ? 'is-invalid' : '' ?>" name="poin_<?= $i ?>" id="poin_<?= $i ?>" value="<?= old('poin_' . $i) ?>" required>
                                        <?php if (isset($errors['poin_' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['poin_' . $i] ?>
                                            </div>
                                        <?php endif; ?>
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
</body>

</html>