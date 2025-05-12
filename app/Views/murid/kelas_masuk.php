<h1><?= esc($kelas['nama_kelas']) ?></h1>
<p><strong>Deskripsi:</strong> <?= esc($kelas['deskripsi']) ?></p>

<h3>Materi:</h3>
<ul>
    <?php foreach ($materi as $item): ?>
        <li>
            <strong><?= esc($item['judul']) ?> - Level <?= esc($item['level']) ?></strong>
            <!-- Tampilkan materi hanya jika statusnya sudah selesai -->
            <?php if ($item['level'] == 1 || ($item['level'] > 1 && $status_materi == 'selesai')): ?>
                <a href="<?= base_url($item['file_path']) ?>" target="_blank">Lihat Materi</a>
            <?php else: ?>
                <p>Anda harus menyelesaikan level sebelumnya terlebih dahulu.</p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<h3>Quiz:</h3>
<ul>
    <?php foreach ($quiz as $item): ?>
        <li>
            <strong><?= esc($item['judul_quiz']) ?> - Level <?= esc($item['level']) ?></strong>
            <!-- Tampilkan quiz hanya jika statusnya sudah selesai -->
            <?php if ($item['level'] == 1 || ($item['level'] > 1 && $status_quiz == 'selesai')): ?>
                <a href="<?= base_url('murid/aksesQuiz/' . esc($item['id'])) ?>">Kerjakan Quiz</a>
            <?php else: ?>
                <p>Anda harus menyelesaikan quiz level sebelumnya terlebih dahulu.</p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>