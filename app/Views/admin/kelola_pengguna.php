<style>
    :root {
        --primary-color: #4e73df;
        --primary-hover: #2e59d9;
        --success-color: #1cc88a;
        --info-color: #36b9cc;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --light-color: #f8f9fc;
        --dark-color: #5a5c69;
    }

    body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

    .card {
        border: none;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
    }

    .card-header {
        padding: 1rem 1.35rem;
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: calc(0.35rem - 1px) calc(0.35rem - 1px) 0 0;
    }

    .card-body {
        padding: 1.5rem;
        flex: 1 1 auto;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #4a4a4a;
        border-collapse: collapse;
    }

    .table thead th {
        background-color: var(--light-color);
        color: var(--dark-color);
        font-weight: 600;
        padding: 0.75rem;
        font-size: 0.65rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e3e6f0;
        text-transform: uppercase;
    }

    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
        color: white;
    }

    .badge-success { background-color: var(--success-color); }
    .badge-info { background-color: var(--info-color); }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        border-radius: 0.35rem;
        transition: all 0.15s ease;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }

    .btn-light { background-color: #f8f9fa; color: #212529; }
    .btn-light:hover { background-color: #e2e6ea; }

    .btn-outline-secondary { color: #6c757d; border-color: #6c757d; }
    .btn-outline-secondary:hover { color: white; background-color: #6c757d; }

    .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
    .btn-outline-primary:hover { color: white; background-color: var(--primary-color); }

    .btn-outline-success { color: var(--success-color); border-color: var(--success-color); }
    .btn-outline-success:hover { color: white; background-color: var(--success-color); }

    .btn-warning { background-color: var(--warning-color); color: #212529; }
    .btn-warning:hover { background-color: #e0b12a; }

    .btn-danger { background-color: var(--danger-color); color: white; }
    .btn-danger:hover { background-color: #d62c1a; }

    .btn-group { display: inline-flex; }
    .btn-group .btn:not(:last-child) { border-top-right-radius: 0; border-bottom-right-radius: 0; }
    .btn-group .btn:not(:first-child) { border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; }

    .password-mask { font-family: monospace; letter-spacing: 2px; }
    .password-plain { font-family: monospace; word-break: break-all; }

    .text-muted { color: #858796 !important; }
    .text-center { text-align: center !important; }
    .font-weight-bold { font-weight: 600 !important; }

    .table-responsive { overflow-x: auto; width: 100%; }

    .back-button {
        padding: 10px 20px;
        background-color: #4361ee;
        color: white;
        border-radius: 5px;
        font-weight: 500;
        text-decoration: none;
    }

    .back-button:hover { background-color: #3b50c5; }

    @media (max-width: 768px) {
        .btn-group { flex-direction: column; }
        .btn-group .btn { border-radius: 0.35rem !important; margin: 0.1rem 0; }
    }

    .edit-button,
.delete-button {
    display: inline-block;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 500;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.edit-button {
    background-color: #3498db;
}

.edit-button:hover {
    background-color: #2980b9;
}

</style>

        
<body>
    <h1>Kelola Pengguna</h1>
        <a href="/admin/dashboard" class="back-button">Kembali ke Dashboard</a>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Detail</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
<tbody>
    <?php $no = 1; foreach ($pengguna as $user): ?>
        <?php if ($user['role_id'] == 2 || $user['role_id'] == 3): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['email']) ?></td>
            <td>
                <div class="d-flex align-items-center">
                    <span id="mask-<?= $user['id']; ?>" class="password-mask">••••••••</span>
                    <span id="plain-<?= $user['id']; ?>" class="password-plain text-monospace small" style="display:none;">
                        <?= esc($user['password']) ?>
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-secondary ml-2" onclick="togglePassword(<?= $user['id']; ?>)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
            <td>
                <?php if ($user['role_id'] == 2): ?>
                    <span class="badge badge-success">Guru</span>
                <?php elseif ($user['role_id'] == 3): ?>
                    <span class="badge badge-info">Murid</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($user['detail'])): ?>
                    <?php if ($user['role_id'] == 2): ?>
                        <?= esc($user['detail']['nama_guru']) ?><br>
                        <small class="text-muted">NIP: <?= esc($user['detail']['nip']) ?></small>
                    <?php elseif ($user['role_id'] == 3): ?>
                        <?= esc($user['detail']['nama_murid']) ?><br>
                        <small class="text-muted">NIS: <?= esc($user['detail']['nis']) ?></small><br>
                        <small><?= esc($user['detail']['kelas']) ?> - <?= esc($user['detail']['jurusan']) ?></small>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="text-muted">Tidak ada detail</span>
                    <div class="mt-1">
                        <?php if ($user['role_id'] == 2): ?>
                            <a href="<?= site_url('admin/tambah_detail_guru/'.$user['id']); ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus-circle"></i> Tambah Detail
                            </a>
                        <?php elseif ($user['role_id'] == 3): ?>
                            <a href="<?= site_url('admin/tambah_detail_murid/'.$user['id']); ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus-circle"></i> Tambah Detail
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <div class="btn-group" role="group">
                    <?php if ($user['role_id'] == 2): ?>
                        <a href="/editGuru/<?= $user['id']; ?>" class="edit-button" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    <?php elseif ($user['role_id'] == 3): ?>
                        <a href="/editMurid/<?= $user['id']; ?>" class="edit-button" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    <?php endif; ?>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $user['id']; ?>')" title="Hapus">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </td>
        </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</tbody>

            </table>
        </div>
    </div>
</div>

</body>
<script>
    function togglePassword(id) {
        const mask = document.getElementById('mask-' + id);
        const plain = document.getElementById('plain-' + id);
        const btn = event.currentTarget;

        const showingPlain = mask.style.display === 'none';
        mask.style.display = showingPlain ? '' : 'none';
        plain.style.display = showingPlain ? 'none' : '';
        btn.innerHTML = `<i class="fas ${showingPlain ? 'fa-eye' : 'fa-eye-slash'}"></i>`;
    }

    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            window.location.href = '<?= site_url('hapusPengguna/'); ?>' + userId;
        }
    }
</script>
