<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizAnswersModel extends Model
{
    protected $table = 'quiz_answers'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['quiz_id', 'murid_id', 'soal_id', 'jawaban_pilih', 'is_correct', 'kelas_id', 'created_at', 'updated_at'];

    protected $useTimestamps = true; // Menggunakan created_at dan updated_at
}
