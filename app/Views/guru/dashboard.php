<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BahasaKita - Dashboard Buku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #3a86ff;
            --secondary: #2667cc;
            --accent: #8338ec;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #06d6a0;
            --warning: #ffbe0b;
            --danger: #ef476f;
            --card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f0f2f5;
            color: var(--dark);
        }

        /* Layout Grid */
        .dashboard-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(160deg, var(--primary), var(--secondary));
            padding: 2rem 1.5rem;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .sidebar-header img {
            width: 42px;
            margin-right: 12px;
        }

        .sidebar-header h2 {
            color: white;
            font-size: 1.4rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.2rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-item i {
            font-size: 1.1rem;
            width: 24px;
            margin-right: 12px;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .nav-item.active {
            font-weight: 500;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar-footer {
            position: absolute;
            bottom: 2rem;
            left: 1.5rem;
            right: 1.5rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.85rem 1.2rem;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .logout-btn i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            padding: 2.5rem;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .page-title h1 {
            font-size: 1.8rem;
            color: var(--dark);
            font-weight: 600;
        }

        .page-title p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .user-info h4 {
            font-weight: 500;
            margin-bottom: 0.2rem;
        }

        .user-info p {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Book Dashboard */
        .book-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .stat-card.books::before {
            background-color: var(--primary);
        }

        .stat-card.categories::before {
            background-color: var(--success);
        }

        .stat-card.authors::before {
            background-color: var(--accent);
        }

        .stat-card.popular::before {
            background-color: var(--warning);
        }

        .stat-card .stat-icon {
            font-size: 1.8rem;
            color: white;
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-card.books .stat-icon {
            background: linear-gradient(135deg, var(--primary), #5a9cff);
        }

        .stat-card.categories .stat-icon {
            background: linear-gradient(135deg, var(--success), #2ce0b6);
        }

        .stat-card.authors .stat-icon {
            background: linear-gradient(135deg, var(--accent), #9a5ff1);
        }

        .stat-card.popular .stat-icon {
            background: linear-gradient(135deg, var(--warning), #ffcb47);
        }

        .stat-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
            color: var(--dark);
        }

        .stat-card p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Book Sections */
        .book-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .section-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: var(--dark);
        }

        .section-header a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.5rem;
        }

        .book-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .book-cover {
            height: 200px;
            background-color: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            position: relative;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-info {
            padding: 1rem;
        }

        .book-title {
            font-weight: 500;
            margin-bottom: 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            color: #6c757d;
            font-size: 0.8rem;
            margin-bottom: 0.8rem;
        }

        .book-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .book-rating {
            color: var(--warning);
            font-size: 0.9rem;
        }

        .book-rating i {
            margin-right: 2px;
        }

        .book-category {
            background-color: #e9ecef;
            color: #495057;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 50px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-container {
                grid-template-columns: 80px 1fr;
            }

            .sidebar-header h2,
            .nav-item span,
            .logout-btn span {
                display: none;
            }

            .sidebar-header {
                justify-content: center;
            }

            .nav-item {
                justify-content: center;
                padding: 0.85rem 0;
            }

            .nav-item i {
                margin-right: 0;
            }

            .logout-btn {
                justify-content: center;
                padding: 0.85rem 0;
            }

            .logout-btn i {
                margin-right: 0;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .user-profile {
                width: 100%;
                justify-content: space-between;
                padding-top: 1rem;
                border-top: 1px solid #e9ecef;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>BahasaKita</h2>
            </div>

            <nav class="nav-menu">
                <a href="#" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <a href="viewClasses" class="nav-item">
                    <i class="fas fa-list"></i>
                    <span>Lihat Semua Kelas</span>
                </a>
                <a href="createClass" class="nav-item">
                    <i class="fas fa-user-edit"></i>
                    <span>Buat Kelas</span>
                </a>

                <div class="sidebar-footer">
                    <a href="/logout">
                        <button class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </a>
                </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>Dashboard Buku</h1>
                    <p>Kelola koleksi buku BahasaKita Anda</p>
                </div>

                <div class="user-profile">
                    <div class="user-info">
                        <h4>Guru</h4>
                    </div>
                </div>
            </div>

            <!-- Book Statistics -->
            <div class="book-stats">
                <div class="stat-card categories">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3><?= $totalKelas; ?></h3>
                    <p>Banyak Kelas</p>
                </div>

                <div class="stat-card books">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3><?= $totalMateri; ?></h3>
                    <p>Total Materi</p>
                </div>



                <div class="stat-card authors">
                    <div class="stat-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h3><?= $totalQuiz; ?></h3>
                    <p>Jumlah Quiz</p>
                </div>
            </div>
        </main>
    </div>
</body>

</html>