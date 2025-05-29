<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Edit Materi</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/admin/updateMateri/' . $materi['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label for="judul" class="form-label fw-bold">Judul Materi</label>
                <input type="text" class="form-control form-control-lg" id="judul" name="judul" 
                       value="<?= esc($materi['judul']) ?>" required
                       placeholder="Masukkan judul materi">
                <div class="form-text">Judul yang jelas akan membantu siswa memahami konten</div>
            </div>
            
            <div class="mb-4">
                <label for="file" class="form-label fw-bold">File Materi</label>
                <div class="file-upload-wrapper">
                    <input type="file" class="form-control" id="file" name="file" 
                           data-max-file-size="5MB"
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png">
                    <div class="form-text">Format: PDF, DOC, PPT, JPG, PNG (Maks. 5MB)</div>
                    
                    <?php if ($materi['file_path']): ?>
                    <div class="current-file mt-3 p-3 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt text-primary fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-1">File Saat Ini</h6>
                                <a href="<?= base_url($materi['file_path']) ?>" target="_blank" class="text-decoration-none">
                                    <?= esc($materi['file_name']) ?>
                                </a>
                                <div class="text-muted small mt-1">
                                    <span class="badge bg-info">
                                        <?= pathinfo($materi['file_name'], PATHINFO_EXTENSION) ?>
                                    </span>
                                    <span class="ms-2">
                                        <i class="fas fa-download"></i> 
                                        <a href="<?= base_url($materi['file_path']) ?>" download class="text-decoration-none">
                                            Unduh
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-5">
                <a href="<?= base_url('/admin/kelolaMateri') ?>" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }
    
    .form-control-lg {
        font-size: 1.1rem;
    }
    
    .current-file {
        border-left: 4px solid #4361ee;
    }
    
    .file-upload-wrapper {
        position: relative;
    }
    
    .file-upload-wrapper input[type="file"] {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        cursor: pointer;
    }
    
    .file-upload-wrapper .form-control {
        position: relative;
        z-index: 1;
        background: #f8f9fa;
        padding: 1.5rem 1rem;
        text-align: center;
        border: 2px dashed #dee2e6;
    }
    
    .file-upload-wrapper .form-control:hover {
        border-color: #4361ee;
        background: #f0f4ff;
    }
    
    .btn {
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-primary {
        background-color: #4361ee;
        border-color: #4361ee;
    }
    
    .btn-primary:hover {
        background-color: #3a56d4;
        border-color: #3a56d4;
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    // File upload preview
    document.getElementById('file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file...';
        const nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>