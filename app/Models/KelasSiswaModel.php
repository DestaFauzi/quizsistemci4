<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasSiswaModel extends Model
{
    protected $table = 'kelas_siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kelas_id', 'murid_id', 'status', 'status_materi', 'status_quiz', 'created_at', 'updated_at', 'level',];
    protected $useTimestamps = true;

    /**
     * Filter data berdasarkan ID kelas
     *
     * @param int $kelas_id ID kelas yang diinginkan
     * @return static
     */
    public function whereKelas($kelas_id)
    {
        return $this->where('kelas_id', $kelas_id);
    }

    public function whereMurid($murid_id)
    {
        return $this->where('murid_id', $murid_id);
    }

    public function whereMuridKelas($murid_id, $kelas_id): self
    {
        return $this->whereMurid($murid_id)->whereKelas($kelas_id);
    }

    public function whereStatus(string $status)
    {
        return $this->where('status', $status);
    }

    public function whereStatusMateri(string $statusMateri)
    {
        return $this->where('status_materi', $statusMateri);
    }

    public function whereStatusQuiz(string $statusQuiz)
    {
        return $this->where('status_quiz', $statusQuiz);
    }

    public function getAllKelasByMurid($murid_id)
    {
        return $this->whereMurid($murid_id)->findAll();
    }

    // Menambahkan fungsi untuk update status kelas murid
    public function updateStatusKelas($murid_id, $kelas_id, $status): bool
    {
        return $this->whereMuridKelas($murid_id, $kelas_id)
            ->set(['status' => $status])
            ->update();
    }

    // Fungsi untuk update status materi
    public function updateStatusMateri($murid_id, $kelas_id, $status_materi): bool
    {
        return $this->whereMuridKelas($murid_id, $kelas_id)
            ->set(['status_materi' => $status_materi])
            ->update();
    }

    // Fungsi untuk update status quiz
    public function updateStatusQuiz($murid_id, $kelas_id, $status_quiz): bool
    {
        return $this->whereMuridKelas($murid_id, $kelas_id)
            ->set(['status_quiz' => $status_quiz])
            ->update();
    }
}
