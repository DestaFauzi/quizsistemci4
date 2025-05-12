<?php

namespace App\Controllers;

use App\Models\QuizResultsModel;
use CodeIgniter\Controller;

class LeaderboardController extends Controller
{
    public function showLeaderboard($quizId)
    {
        $quizResultsModel = new QuizResultsModel();
        $results = $quizResultsModel->where('quiz_id', $quizId)
            ->orderBy('score', 'DESC')
            ->findAll();

        return view('murid/leaderboard', ['leaderboard' => $results]);
    }
}
