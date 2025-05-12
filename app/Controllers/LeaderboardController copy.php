<?php

namespace App\Controllers;

use App\Models\QuizResultsModel;
use App\Models\UserModel; // Mengambil data murid

class LeaderboardController extends BaseController
{
    // Menampilkan leaderboard berdasarkan quiz
    public function showLeaderboard($quizId)
    {
        // Ambil data leaderboard berdasarkan quiz_id
        $quizResultsModel = new QuizResultsModel();
        $results = $quizResultsModel->getLeaderboard($quizId);  // Mendapatkan data leaderboard

        // Kirim data leaderboard ke view
        return view('murid/leaderboard', ['leaderboard' => $results]);
    }
}
