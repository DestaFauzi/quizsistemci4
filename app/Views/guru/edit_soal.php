<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal untuk Quiz</title>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            max-width: 900px;
            /* Equivalent to col-lg-10 roughly */
            margin-left: auto;
            margin-right: auto;
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
            display: block;
            /* Make labels block-level for better spacing */
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            /* Include padding and border in the element's total width and height */
            margin-bottom: 15px;
            /* Spacing between form controls */
        }

        textarea.form-control {
            resize: vertical;
            /* Allow vertical resizing for textareas */
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 15px;
            background-color: white;
            /* Ensure select has a background */
        }

        .btn-primary {
            background-color: #0d6efd;
            color: white;
            border: 1px solid #0d6efd;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            /* For anchor tags styled as buttons */
            display: inline-block;
            /* Allow spacing between buttons */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: 1px solid #6c757d;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        /* Flexbox for button group equivalent to d-grid gap-2 d-md-flex justify-content-md-end */
        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            /* Space between buttons */
            margin-top: 20px;
        }

        /* Custom styles for validation errors */
        .is-invalid {
            border-color: #dc3545;
            /* Red border for invalid input */
        }

        .invalid-feedback {
            color: #dc3545;
            /* Red text for error messages */
            font-size: 0.875em;
            /* Smaller font size */
            margin-top: -10px;
            /* Adjust spacing */
            margin-bottom: 10px;
            display: block;
            /* Ensure it takes up space */
        }

        /* Basic grid for form rows */
        .row {
            display: flex;
            flex-wrap: wrap;
            /* Allow items to wrap to the next line */
            margin-left: -10px;
            /* Compensate for column padding */
            margin-right: -10px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            /* Take 50% width */
            max-width: 50%;
            padding-left: 10px;
            padding-right: 10px;
            box-sizing: border-box;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="form-container">
                <h1>Tambah Soal untuk Quiz</h1>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php $errors = session()->getFlashdata('errors'); ?>

                <form action="<?= site_url('guru/updateSoal') ?>" method="POST">
                    <input type="hidden" name="quiz_id" value="<?= esc($quiz_id) ?>">
                    <input type="hidden" name="jumlah_soal" value="<?= esc($jumlah_soal) ?>">

                    <?php for ($i = 0; $i < $jumlah_soal; $i++):
                        $soal = $soalList[$i] ?? ['id' => '', 'soal' => '', 'jawaban_a' => '', 'jawaban_b' => '', 'jawaban_c' => '', 'jawaban_d' => '', 'jawaban_benar' => '', 'poin' => ''];
                        // Use old() for input values in case of validation errors, fall back to $soal data
                        $old_soal_text = old('soal')[$i] ?? esc($soal['soal']);
                        $old_jawaban_a = old('jawaban_a')[$i] ?? esc($soal['jawaban_a']);
                        $old_jawaban_b = old('jawaban_b')[$i] ?? esc($soal['jawaban_b']);
                        $old_jawaban_c = old('jawaban_c')[$i] ?? esc($soal['jawaban_c']);
                        $old_jawaban_d = old('jawaban_d')[$i] ?? esc($soal['jawaban_d']);
                        $old_jawaban_benar = old('jawaban_benar')[$i] ?? esc($soal['jawaban_benar']);
                        $old_poin = old('poin')[$i] ?? esc($soal['poin']);
                    ?>
                        <div class="question-card">
                            <div class="question-number">Soal <?= $i + 1 ?></div>

                            <input type="hidden" name="soal_id[]" value="<?= esc($soal['id']) ?>">

                            <div class="form-group">
                                <label for="soal_<?= $i ?>" class="form-label">Pertanyaan:</label>
                                <textarea class="form-control <?= isset($errors['soal.' . $i]) ? 'is-invalid' : '' ?>" name="soal[]" id="soal_<?= $i ?>" rows="3" required><?= $old_soal_text ?></textarea>
                                <?php if (isset($errors['soal.' . $i])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['soal.' . $i] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jawaban_a_<?= $i ?>" class="form-label">Jawaban A:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_a.' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_a[]" id="jawaban_a_<?= $i ?>" value="<?= $old_jawaban_a ?>" required>
                                        <?php if (isset($errors['jawaban_a.' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_a.' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jawaban_b_<?= $i ?>" class="form-label">Jawaban B:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_b.' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_b[]" id="jawaban_b_<?= $i ?>" value="<?= $old_jawaban_b ?>" required>
                                        <?php if (isset($errors['jawaban_b.' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_b.' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jawaban_c_<?= $i ?>" class="form-label">Jawaban C:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_c.' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_c[]" id="jawaban_c_<?= $i ?>" value="<?= $old_jawaban_c ?>" required>
                                        <?php if (isset($errors['jawaban_c.' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_c.' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jawaban_d_<?= $i ?>" class="form-label">Jawaban D:</label>
                                        <input type="text" class="form-control <?= isset($errors['jawaban_d.' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_d[]" id="jawaban_d_<?= $i ?>" value="<?= $old_jawaban_d ?>" required>
                                        <?php if (isset($errors['jawaban_d.' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_d.' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jawaban_benar_<?= $i ?>" class="form-label">Jawaban Benar:</label>
                                        <select class="form-select <?= isset($errors['jawaban_benar.' . $i]) ? 'is-invalid' : '' ?>" name="jawaban_benar[]" id="jawaban_benar_<?= $i ?>" required>
                                            <option value="a" <?= $old_jawaban_benar === 'a' ? 'selected' : '' ?>>A</option>
                                            <option value="b" <?= $old_jawaban_benar === 'b' ? 'selected' : '' ?>>B</option>
                                            <option value="c" <?= $old_jawaban_benar === 'c' ? 'selected' : '' ?>>C</option>
                                            <option value="d" <?= $old_jawaban_benar === 'd' ? 'selected' : '' ?>>D</option>
                                        </select>
                                        <?php if (isset($errors['jawaban_benar.' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['jawaban_benar.' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="poin_<?= $i ?>" class="form-label">Poin:</label>
                                        <input type="number" class="form-control <?= isset($errors['poin.' . $i]) ? 'is-invalid' : '' ?>" name="poin[]" id="poin_<?= $i ?>" value="<?= $old_poin ?>" required>
                                        <?php if (isset($errors['poin.' . $i])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['poin.' . $i] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <div class="button-group">
                        <a href="/guru/viewClasses" class="btn-secondary">Kembali ke Daftar Kelas</a>
                        <button type="submit" class="btn-primary">Simpan Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>