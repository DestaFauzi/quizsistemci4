<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table            = 'materi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['kelas_id', 'judul','nama_kelas', 'file_name', 'file_path', 'level', 'point'];

    public function getMateriByKelas($kelas_id)
    {
        return $this->where('kelas_id', $kelas_id)->findAll();
    }

    public function whereKelas($kelas_id)
    {
        return $this->where('kelas_id', $kelas_id);
    }

    public function whereLevel($level, $opt = '')
    {
        return $this->where("level $opt", $level);
    }

    public function getAllByKelasByOrdered($kelas_id, $orderBy, $sortAs = 'asc'): array
    {
        return $this->whereKelas($kelas_id)
            ->orderBy($orderBy, $sortAs)
            ->findAll();
    }
}
