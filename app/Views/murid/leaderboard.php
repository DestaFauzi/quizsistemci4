<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>

<body>
    <h1>Leaderboard Quiz</h1>
    <h2><?= esc($leaderboard['nama_kelas']) ?></h2>

    <?php if (empty($leaderboard['data_murid'])): ?>
        <p>Belum ada data leaderboard untuk quiz ini.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Posisi</th>
                    <th>Nama Murid</th>
                    <th>Skor Materi</th>
                    <th>Skor Quiz</th>
                    <th>Point Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; ?>
                <?php foreach ($leaderboard['data_murid'] as $item): ?>
                    <tr>
                        <td><?= $rank++ ?></td>
                        <td><?= esc($item['username']) ?></td>
                        <td><?= esc($item['total_score_materi']) ?></td>
                        <td><?= esc($item['total_score_quiz']) ?></td>
                        <td><?= esc($item['total_point']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="/murid/dashboard">
        <button>Kembali ke Dashboard</button>
    </a>
</body>

</html>