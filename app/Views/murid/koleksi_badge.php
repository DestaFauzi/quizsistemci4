<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Badge - BahasaKita</title>
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
            --gold: #ffd700;
            --silver: #c0c0c0;
            --bronze: #cd7f32;
            --purple: #9c27b0;
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
            min-height: 100vh;
            padding: 2rem;
            background-image: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(76, 201, 240, 0.05) 100%);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header {
            text-align: left;
        }

        .header h1 {
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            background-color: #f8f9fa;
            color: var(--danger);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: 1px solid #e9ecef;
            height: fit-content;
        }

        .logout-btn:hover {
            background-color: var(--danger);
            color: white;
        }

        .logout-btn i {
            margin-right: 0.5rem;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            background-color: var(--light);
            color: var(--dark);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: 1px solid #e9ecef;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            background-color: #e9ecef;
        }

        .back-btn i {
            margin-right: 0.5rem;
        }

        .badge-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .badge-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .badge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .badge-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
        }

        /* Badge tier colors */
        .badge-gold {
            background: linear-gradient(135deg, var(--gold), #daa520);
            box-shadow: 0 0 0 5px rgba(255, 215, 0, 0.2);
        }

        .badge-silver {
            background: linear-gradient(135deg, var(--silver), #a8a8a8);
            box-shadow: 0 0 0 5px rgba(192, 192, 192, 0.2);
        }

        .badge-bronze {
            background: linear-gradient(135deg, var(--bronze), #b87333);
            box-shadow: 0 0 0 5px rgba(205, 127, 50, 0.2);
        }

        .badge-blue {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 0 0 5px rgba(67, 97, 238, 0.2);
        }

        .badge-purple {
            background: linear-gradient(135deg, var(--purple), #7b1fa2);
            box-shadow: 0 0 0 5px rgba(156, 39, 176, 0.2);
        }

        .badge-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .badge-tier {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .tier-gold {
            background-color: rgba(255, 215, 0, 0.2);
            color: #b8860b;
        }

        .tier-silver {
            background-color: rgba(192, 192, 192, 0.2);
            color: #808080;
        }

        .tier-bronze {
            background-color: rgba(205, 127, 50, 0.2);
            color: #8b4513;
        }

        .tier-blue {
            background-color: rgba(67, 97, 238, 0.2);
            color: var(--secondary);
        }

        .tier-purple {
            background-color: rgba(156, 39, 176, 0.2);
            color: var(--purple);
        }

        .badge-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .badge-date {
            font-size: 0.8rem;
            color: #adb5bd;
            margin-top: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 3rem;
            color: #e9ecef;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .earn-badge-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background-color: var(--primary);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .earn-badge-btn:hover {
            background-color: var(--secondary);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .earn-badge-btn i {
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1.5rem;
            }

            .header-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .badge-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-container">
            <div class="header">
                <h1>Koleksi Badge</h1>
                <p>Pencapaian dan prestasi Anda dalam pembelajaran</p>
            </div>
            <a href="/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <a href="/murid/dashboard" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <?php if (empty($badge)): ?>
            <div class="empty-state">
                <i class="fas fa-trophy"></i>
                <h3>Anda Belum Memiliki Badge</h3>
                <p>Ikuti kelas dan selesaikan tantangan untuk mendapatkan badge pertama Anda!</p>
                <a href="/murid/semuaKelas" class="earn-badge-btn">
                    Mulai Belajar <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="badge-container">
                <!-- Badge 1 - Gold Tier -->
                <div class="badge-card">
                    <div class="badge-icon badge-gold">
                        <i class="fas fa-crown"></i>
                    </div>
                    <span class="badge-tier tier-gold">Gold</span>
                    <h3>Master Bahasa</h3>
                    <p class="badge-description">Menyelesaikan semua level dengan nilai sempurna</p>
                    <p class="badge-date">Diperoleh: 15 Mei 2023</p>
                </div>

                <!-- Badge 2 - Silver Tier -->
                <div class="badge-card">
                    <div class="badge-icon badge-silver">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="badge-tier tier-silver">Silver</span>
                    <h3>Ahli Kosakata</h3>
                    <p class="badge-description">Menguasai lebih dari 500 kosakata baru</p>
                    <p class="badge-date">Diperoleh: 2 April 2023</p>
                </div>

                <!-- Badge 3 - Bronze Tier -->
                <div class="badge-card">
                    <div class="badge-icon badge-bronze">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="badge-tier tier-bronze">Bronze</span>
                    <h3>Pembaca Cepat</h3>
                    <p class="badge-description">Menyelesaikan 10 materi membaca dalam waktu singkat</p>
                    <p class="badge-date">Diperoleh: 10 Maret 2023</p>
                </div>

                <!-- Badge 4 - Blue Tier -->
                <div class="badge-card">
                    <div class="badge-icon badge-blue">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span class="badge-tier tier-blue">Spesial</span>
                    <h3>Pembelajar Aktif</h3>
                    <p class="badge-description">Login dan belajar selama 30 hari berturut-turut</p>
                    <p class="badge-date">Diperoleh: 28 Februari 2023</p>
                </div>

                <!-- Badge 5 - Purple Tier -->
                <div class="badge-card">
                    <div class="badge-icon badge-purple">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="badge-tier tier-purple">Komunitas</span>
                    <h3>Kontributor Top</h3>
                    <p class="badge-description">Membantu 10 siswa lain dalam forum diskusi</p>
                    <p class="badge-date">Diperoleh: 15 Februari 2023</p>
                </div>

                <!-- Badge 6 - Gold Tier -->
                <div class="badge-card">
                    <div class="badge-icon badge-gold">
                        <i class="fas fa-medal"></i>
                    </div>
                    <span class="badge-tier tier-gold">Gold</span>
                    <h3>Juara Quiz</h3>
                    <p class="badge-description">Mendapatkan nilai tertinggi dalam quiz bulanan</p>
                    <p class="badge-date">Diperoleh: 31 Januari 2023</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>