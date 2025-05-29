<style>
    /* General Styling */
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
        background-color: #f8f9fc;
        font-family: 'Nunito', sans-serif;
        color: var(--dark-color);
    }
    
    /* Card Styling */
    .card {
        border: none;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        border-radius: calc(0.35rem - 1px) calc(0.35rem - 1px) 0 0;
        padding: 1rem 1.35rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
    }
    
    .card-body {
        padding: 1.5rem;
        flex: 1 1 auto;
    }
    
    /* Table Styling */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #4a4a4a;
        border-collapse: collapse;
    }
    
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #e3e6f0;
        background-color: var(--light-color);
        color: var(--dark-color);
        font-weight: 600;
        padding: 0.75rem;
        text-transform: uppercase;
        font-size: 0.65rem;
        letter-spacing: 0.5px;
    }
    
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    /* Badge Styling */
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    
    .badge-success {
        background-color: var(--success-color);
        color: white;
    }
    
    .badge-info {
        background-color: var(--info-color);
        color: white;
    }
    
    /* Button Styling */
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        line-height: 1.5;
        border-radius: 0.35rem;
        transition: all 0.15s ease;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
        line-height: 1.5;
    }
    
    .btn-light {
        color: #212529;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }
    
    .btn-light:hover {
        background-color: #e2e6ea;
        border-color: #dae0e5;
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-outline-primary:hover {
        color: #fff;
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-outline-success {
        color: var(--success-color);
        border-color: var(--success-color);
    }
    
    .btn-outline-success:hover {
        color: #fff;
        background-color: var(--success-color);
        border-color: var(--success-color);
    }
    
    .btn-warning {
        color: #212529;
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }
    
    .btn-warning:hover {
        background-color: #e0b12a;
        border-color: #d9aa28;
    }
    
    .btn-danger {
        color: #fff;
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }
    
    .btn-danger:hover {
        background-color: #d62c1a;
        border-color: #ca2a19;
    }
    
    /* Button Group */
    .btn-group {
        display: inline-flex;
        vertical-align: middle;
    }
    
    .btn-group .btn {
        position: relative;
        flex: 1 1 auto;
    }
    
    .btn-group .btn:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    
    .btn-group .btn:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        margin-left: -1px;
    }
    
    /* Password Field */
    .password-mask {
        font-family: monospace;
        letter-spacing: 2px;
    }
    
    .password-plain {
        font-family: monospace;
        word-break: break-all;
    }
    
    /* Text Styling */
    .text-monospace {
        font-family: monospace;
    }
    
    .small {
        font-size: 80%;
        font-weight: 400;
    }
    
    .text-muted {
        color: #858796 !important;
    }
    
    /* Utility Classes */
    .mt-1 {
        margin-top: 0.25rem !important;
    }
    
    .ml-2 {
        margin-left: 0.5rem !important;
    }
    
    .d-flex {
        display: flex !important;
    }
    
    .align-items-center {
        align-items: center !important;
    }
    
    .justify-content-between {
        justify-content: space-between !important;
    }
    
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .font-weight-bold {
        font-weight: 600 !important;
    }
    
    .text-center {
        text-align: center !important;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            border: 0;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
        }
        
        .btn-group .btn {
            margin: 0.1rem 0;
            border-radius: 0.35rem !important;
        }
    }
</style>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
        <h3 class="m-0 font-weight-bold">Daftar Pengguna</h6>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
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
                    <?php
                    $no = 1;
                    foreach ($users as $user):
                        if ($user['role_id'] === '2' || $user['role_id'] === '3'):
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="password-mask" id="mask-<?= $user['id']; ?>">••••••••</span>
                                <span class="password-plain text-monospace small" id="plain-<?= $user['id']; ?>" style="display:none;">
                                    <?= htmlspecialchars(password_verify('dummy', $user['password']) ? 'Password terenkripsi' : $user['password']); ?>
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-secondary ml-2" onclick="togglePassword(<?= $user['id']; ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <?php if ($user['role_id'] === '2'): ?>
                                <span class="badge badge-success">Guru</span>
                            <?php elseif ($user['role_id'] === '3'): ?>
                                <span class="badge badge-info">Murid</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['role_id'] === '2' && !empty($user['detail_guru'])): ?>
                                <a href="<?= site_url('admin/detail_guru/'.$user['id']); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-user-tie"></i> Detail Guru
                                </a>
                            <?php elseif ($user['role_id'] === '3' && !empty($user['detail_murid'])): ?>
                                <a href="<?= site_url('admin/detail_murid/'.$user['id']); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-user-graduate"></i> Detail Murid
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada detail</span>
                                <div class="mt-1">
                                    <?php if ($user['role_id'] === '2'): ?>
                                        <a href="<?= site_url('admin/tambah_detail_guru/'.$user['id']); ?>" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-plus-circle"></i> Tambah Detail
                                        </a>
                                    <?php elseif ($user['role_id'] === '3'): ?>
                                        <a href="<?= site_url('admin/tambah_detail_murid/'.$user['id']); ?>" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-plus-circle"></i> Tambah Detail
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <?php if ($user['role_id'] === '2'): ?>
                                    <a href="<?= site_url('admin/edit_guru/'.$user['id']); ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit">Edit</i>
                                    </a>
                                <?php elseif ($user['role_id'] === '3'): ?>
                                    <a href="<?= site_url('admin/edit_murid/'.$user['id']); ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit">Edit</i>
                                    </a>
                                <?php endif; ?>
                                
                                <button class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete('<?= $user['id']; ?>')">
                                    <i class="fas fa-trash-alt">Hapus</i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function togglePassword(id) {
        var mask = document.getElementById('mask-' + id);
        var plain = document.getElementById('plain-' + id);
        var btn = event.currentTarget;
        
        if (mask.style.display === 'none') {
            mask.style.display = '';
            plain.style.display = 'none';
            btn.innerHTML = '<i class="fas fa-eye"></i>';
        } else {
            mask.style.display = 'none';
            plain.style.display = '';
            btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        }
    }
    
    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            window.location.href = '<?= site_url('admin/hapus_pengguna/'); ?>' + userId;
        }
    }
</script>