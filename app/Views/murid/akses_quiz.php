<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($quiz['judul_quiz']) ?> | BahasaKita</title>
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

        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .quiz-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .quiz-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
        }

        .quiz-title {
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .quiz-meta {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
            color: var(--gray);
        }

        .quiz-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timer-container {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 3px 10px rgba(67, 97, 238, 0.2);
        }

        .timer {
            font-size: 1.2rem;
        }

        .quiz-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .question-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .question-card:hover {
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-left-color: var(--primary);
        }

        .question-text {
            font-weight: 500;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .options-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }

        .option-label {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1rem;
            background-color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #e0e0e0;
        }

        .option-label:hover {
            border-color: var(--primary);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .option-radio {
            transform: scale(1.2);
        }

        .submit-btn {
            align-self: center;
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .time-warning {
            color: var(--danger);
            font-weight: 500;
            text-align: center;
            margin-top: 1rem;
            display: none;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .quiz-container {
                padding: 1.5rem;
            }

            .quiz-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="quiz-container">
        <div class="quiz-header">
            <h1 class="quiz-title"><?= esc($quiz['judul_quiz']) ?></h1>
            <div class="quiz-meta">
                <span><i class="fas fa-layer-group"></i> Level <?= esc($quiz['level']) ?></span>
                <span><i class="fas fa-question-circle"></i> <?= count($soals) ?> Soal</span>
                <span><i class="fas fa-clock"></i> <?= esc($quiz['waktu']) ?> Menit</span>
            </div>
            <div class="timer-container">
                <i class="fas fa-stopwatch"></i>
                <span class="timer" id="countdown"><?= esc($quiz['waktu']) ?>:00</span>
            </div>
            <p class="time-warning" id="time-warning">Waktu hampir habis! Segera selesaikan quiz.</p>
        </div>

        <form action="<?= base_url('murid/submitQuiz/' . $kelasId . '/' . $quiz['id']) ?>" method="post">
            <?= csrf_field() ?>

            <?php foreach ($soals as $index => $soal): ?>
                <div class="question-card">
                    <p class="question-text"><?= ($index + 1) ?>. <?= esc($soal['soal']) ?></p>
                    <div class="options-container">
                        <label class="option-label">
                            <input type="radio" class="option-radio" name="jawaban_<?= esc($soal['id']) ?>" value="A">
                            <span><?= esc($soal['jawaban_a']) ?></span>
                        </label>
                        <label class="option-label">
                            <input type="radio" class="option-radio" name="jawaban_<?= esc($soal['id']) ?>" value="B">
                            <span><?= esc($soal['jawaban_b']) ?></span>
                        </label>
                        <label class="option-label">
                            <input type="radio" class="option-radio" name="jawaban_<?= esc($soal['id']) ?>" value="C">
                            <span><?= esc($soal['jawaban_c']) ?></span>
                        </label>
                        <label class="option-label">
                            <input type="radio" class="option-radio" name="jawaban_<?= esc($soal['id']) ?>" value="D">
                            <span><?= esc($soal['jawaban_d']) ?></span>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i> Submit Quiz
            </button>
        </form>
    </div>

    <script>
        // Countdown timer functionality
        document.addEventListener('DOMContentLoaded', function() {
            const durationInMinutes = <?= esc($quiz['waktu']) ?>;
            let timeLeft = durationInMinutes * 60; // Convert to seconds
            const countdownElement = document.getElementById('countdown');
            const timeWarningElement = document.getElementById('time-warning');
            const quizForm = document.getElementById('quizForm');

            // Update the countdown every second
            const countdownInterval = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;

                // Add leading zero to seconds if needed
                seconds = seconds < 10 ? '0' + seconds : seconds;

                countdownElement.textContent = `${minutes}:${seconds}`;

                // Show warning when 2 minutes left
                if (timeLeft <= 120) {
                    timeWarningElement.style.display = 'block';
                    countdownElement.style.color = 'var(--danger)';
                }

                // If time runs out, submit the form
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    countdownElement.textContent = "Waktu habis!";
                    quizForm.submit();
                }

                timeLeft--;
            }, 1000);

            // Prevent form submission on Enter key
            quizForm.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });

            // Show confirmation before leaving the page
            window.addEventListener('beforeunload', function(e) {
                if (timeLeft > 0) {
                    e.preventDefault();
                    e.returnValue = 'Anda memiliki quiz yang sedang berjalan. Yakin ingin meninggalkan halaman?';
                }
            });
        });
    </script>
</body>

</html>