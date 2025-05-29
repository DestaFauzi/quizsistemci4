<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e4fc;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--white);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .sidebar-title i {
            margin-right: 10px;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 500;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        h1 i {
            margin-right: 10px;
            color: var(--primary);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 600;
        }

        .stat-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background-color: var(--primary);
        }

        .card-icon {
            font-size: 28px;
            margin-bottom: 15px;
            color: var(--primary);
            background-color: var(--primary-light);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title {
            font-size: 16px;
            font-weight: 500;
            color: var(--gray);
            margin-bottom: 5px;
        }

        .card-body {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .card-footer {
            font-size: 14px;
            color: var(--gray);
            display: flex;
            align-items: center;
        }

        .card-footer i {
            margin-right: 5px;
            font-size: 12px;
            color: var(--success);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.5s ease forwards;
        }

        .card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .card:nth-child(4) {
            animation-delay: 0.4s;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 15px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .stat-box {
                grid-template-columns: 1fr;
            }

            .nav-menu {
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
            }

            .nav-item {
                margin-bottom: 0;
                margin-right: 10px;
                min-width: 150px;
            }

            .nav-link {
                border-left: none;
                border-bottom: 3px solid transparent;
                flex-direction: column;
                align-items: center;
                padding: 10px;
                text-align: center;
            }

            .nav-link:hover, .nav-link.active {
                border-left: none;
                border-bottom-color: var(--primary);
            }

            .nav-link i {
                margin-right: 0;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">
                <i class="fas fa-cog"></i> Menu Admin
            </div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/kelolaKelas" class="nav-link">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Kelola Kelas
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/kelolaMateri" class="nav-link">
                    <i class="fas fa-book-open"></i>
                    Kelola Materi
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/kelolaQuiz" class="nav-link">
                    <i class="fas fa-question-circle"></i>
                    Kelola Quiz
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/kelolaPengguna" class="nav-link">
                    <i class="fas fa-users-cog"></i>
                    Kelola Pengguna
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
            <div class="user-profile">
                <div class="user-avatar">AD</div>
                <span>Admin</span>
            </div>
        </header>

        <div class="stat-box">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="card-title">Total Kelas</div>
                <div class="card-body"><?= esc($kelasCount) ?></div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="card-title">Total Materi</div>
                <div class="card-body"><?= esc($materiCount) ?></div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="card-title">Total Quiz</div>
                <div class="card-body"><?= esc($quizCount) ?></div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-title">Total Murid</div>
                <div class="card-body"><?= esc($userCount) ?></div>
            </div>
        </div>
    </main>
</body>

</html>