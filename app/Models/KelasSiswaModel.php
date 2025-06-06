<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasSiswaModel extends Model
{
    protected $table = 'kelas_siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kelas_id', 'murid_id', 'status', 'status_materi', 'status_quiz', 'created_at', 'updated_at','level',];
    protected $useTimestamps = true;

    // Menambahkan fungsi untuk mendapatkan kelas berdasarkan murid
    public function getKelasByMurid($murid_id)
    {
        return $this->where('murid_id', $murid_id)->findAll();
    }

    // Menambahkan fungsi untuk update status kelas murid
    public function updateStatusKelas($murid_id, $kelas_id, $status)
    {
        return $this->where('murid_id', $murid_id)
            ->where('kelas_id', $kelas_id)
            ->set(['status' => $status])
            ->update();
    }

    // Fungsi untuk update status materi
    public function updateStatusMateri($murid_id, $kelas_id, $status_materi)
    {
        return $this->where('murid_id', $murid_id)
            ->where('kelas_id', $kelas_id)
            ->set(['status_materi' => $status_materi])
            ->update();
    }

    // Fungsi untuk update status quiz
    public function updateStatusQuiz($murid_id, $kelas_id, $status_quiz)
    {
        return $this->where('murid_id', $murid_id)
            ->where('kelas_id', $kelas_id)
            ->set(['status_quiz' => $status_quiz])
            ->update();
    }
}
