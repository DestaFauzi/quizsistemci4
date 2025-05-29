<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e4fc;
            --danger: #f72585;
            --light-gray: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .edit-materi-card {
            max-width: 800px;
            margin: 2rem auto;
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary);
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .card-title {
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .file-upload-area {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background-color: var(--light-gray);
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }
        
        .file-upload-area:hover {
            border-color: var(--primary);
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .current-file {
            background-color: var(--light-gray);
            border-left: 4px solid var(--primary);
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1rem;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .file-icon {
            font-size: 1.75rem;
            color: var(--primary);
        }
        
        .btn-submit {
            background-color: var(--primary);
            padding: 10px 24px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            background-color: #3a56d4;
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .alert-danger {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Edit Materi Card -->
        <div class="card edit-materi-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-edit"></i>
                    Edit Materi
                </h2>
            </div>
            
            <div class="card-body p-4">
                <form action="<?= base_url('/admin/updateMateri/' . $materi['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <!-- Judul Materi -->
                    <div class="mb-4">
                        <label for="judul" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control" id="judul" name="judul" 
                               value="<?= esc($materi['judul']) ?>" required
                               placeholder="Masukkan judul materi">
                    </div>
                    
                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="form-label">File Materi (Opsional)</label>
                        
                        <div class="file-upload-area" onclick="document.getElementById('file').click()">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-3" style="color: var(--primary);"></i>
                            <h5>Seret file ke sini atau klik untuk mengunggah</h5>
                            <p class="text-muted">Format: PDF, DOC, PPT, JPG, PNG (Maks. 5MB)</p>
                            <input type="file" class="d-none" id="file" name="file">
                        </div>
                        
                        <!-- Current File Display -->
                        <?php if ($materi['file_path']): ?>
                            <div class="current-file">
                                <div class="file-info">
                                    <i class="fas fa-file-alt file-icon"></i>
                                    <div>
                                        <h6 class="mb-1">File Saat Ini</h6>
                                        <a href="<?= base_url($materi['file_path']) ?>" target="_blank" class="text-decoration-none">
                                            <?= esc($materi['file_name']) ?>
                                        </a>
                                        <div class="text-muted small mt-1">
                                            <span class="badge bg-primary me-2">
                                                <?= strtoupper(pathinfo($materi['file_name'], PATHINFO_EXTENSION)) ?>
                                            </span>
                                            <a href="<?= base_url($materi['file_path']) ?>" download class="text-decoration-none">
                                                <i class="fas fa-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-5">
                        <a href="<?= base_url('/admin/kelolaMateri') ?>" class="btn btn-outline-secondary btn-cancel">
                            <i class="fas fa-arrow-left me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-save me-2"></i> Update Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File upload interaction
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
            const uploadArea = document.querySelector('.file-upload-area');
            
            if(e.target.files.length > 0) {
                uploadArea.innerHTML = `
                    <i class="fas fa-file-upload fa-2x mb-3" style="color: var(--primary);"></i>
                    <h5>${fileName}</h5>
                    <p class="text-muted">Klik untuk mengubah file</p>
                `;
            }
        });
    </script>
</body>
</html>