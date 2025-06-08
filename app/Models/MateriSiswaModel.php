<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriSiswaModel extends Model
{
    protected $table            = 'materi_siswa';
    protected $primaryKey       = 'id'; // Primary key

    protected $allowedFields = ['materi_id', 'murid_id', 'status', 'created_at', 'updated_at'];
    protected $useAutoIncrement = true; // Menggunakan auto increment untuk primary key
    protected $returnType = 'array'; // Mengembalikan hasil sebagai array
    protected $useTimestamps = true; // Menggunakan created_at dan updated_at
}
