<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Murid - BahasaKita</title>
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
            --card-bg: #ffffff;
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

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
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

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .dashboard-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
        }

        .dashboard-card h2 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .dashboard-card p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background-color: var(--primary);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .dashboard-btn:hover {
            background-color: var(--secondary);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .dashboard-btn i {
            margin-left: 0.5rem;
        }

        .logout-container {
            text-align: center;
            margin-top: 3rem;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background-color: #f8f9fa;
            color: var(--danger);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: 1px solid #e9ecef;
        }

        .logout-btn:hover {
            background-color: var(--danger);
            color: white;
        }

        .logout-btn i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Dashboard Murid</h1>
            <p>Selamat datang di portal pembelajaran BahasaKita</p>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h2>Semua Kelas</h2>
                <p>Jelajahi semua kelas yang tersedia untuk pembelajaran bahasa</p>
                <a href="/murid/semuaKelas" class="dashboard-btn">
                    Lihat Kelas <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background: linear-gradient(135deg, var(--warning), #ff9e1b);">
                    <i class="fas fa-spinner"></i>
                </div>
                <h2>Kelas Dalam Proses</h2>
                <p>Lihat kelas yang sedang Anda ikuti dan dalam proses pembelajaran</p>
                <a href="/murid/kelasDalamProses" class="dashboard-btn">
                    Lihat Proses <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background: linear-gradient(135deg, var(--success), #3aa874);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Kelas Selesai</h2>
                <p>Review kelas yang telah Anda selesaikan beserta pencapaiannya</p>
                <a href="/murid/kelasSelesai" class="dashboard-btn">
                    Lihat Hasil <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background: linear-gradient(135deg, var(--accent), #3ab7dd);">
                    <i class="fas fa-trophy"></i>
                </div>
                <h2>Koleksi Badge</h2>
                <p>Lihat semua badge pencapaian yang telah Anda kumpulkan</p>
                <a href="/murid/koleksiBadge" class="dashboard-btn">
                    Lihat Badge <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="logout-container">
            <a href="/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</body>

</html>