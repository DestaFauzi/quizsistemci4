<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table            = 'quiz';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'kelas_id', 'judul_quiz', 'jumlah_soal', 'waktu', 'level', 'status', 'created_at', 'updated_at'];

    public function whereKelas($kelas_id)
    {
        return $this->where('kelas_id', $kelas_id);
    }

    public function whereLevel($level, $opt = '')
    {
        return $this->where("level $opt", $level);
    }
}
