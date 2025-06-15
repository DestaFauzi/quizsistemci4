<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalModel extends Model
{
    protected $table            = 'soal';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'quiz_id',
        'soal',
        'jawaban_a',
        'jawaban_b',
        'jawaban_c',
        'jawaban_d',
        'jawaban_benar',
        'poin',
        'waktu',
    ];

    public function whereQuiz($quizId)
    {
        return $this->where('quiz_id', $quizId);
    }
}
