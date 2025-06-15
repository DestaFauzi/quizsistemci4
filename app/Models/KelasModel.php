<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'nama_kelas', 'deskripsi', 'status', 'guru_id', 'jumlah_level'];

    public function getAllKelasAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }
}
