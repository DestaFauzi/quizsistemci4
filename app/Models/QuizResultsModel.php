<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizResultsModel extends Model
{
    protected $table = 'quiz_results'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['quiz_id', 'murid_id', 'score', 'max_score', 'kelas_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true; // Menggunakan created_at dan updated_at

    public function whereMurid($murid_id)
    {
        return $this->where('murid_id', $murid_id);
    }

    public function whereQuiz($quizId)
    {
        return $this->where('quiz_id', $quizId);
    }

    public function whereQuizIn(array $quizIds)
    {
        return $this->whereIn('quiz_id', $quizIds);
    }

    // Mendapatkan leaderboard berdasarkan quiz_id
    public function getLeaderboard($quizId)
    {
        return $this->select('quiz_results.*, users.username')
            ->join('users', 'users.id = quiz_results.murid_id')
            ->where('quiz_results.quiz_id', $quizId)  // Mengambil leaderboard berdasarkan quiz_id
            ->orderBy('quiz_results.score', 'DESC')    // Mengurutkan berdasarkan skor tertinggi
            ->findAll();
    }
}
