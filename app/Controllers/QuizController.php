<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\QuizModel;
use App\Models\SoalModel;
use App\Models\QuizResultsModel;
use App\Models\QuizAnswersModel;

class QuizController extends BaseController
{
    // Menampilkan quiz untuk murid
    public function viewQuiz($quizId)
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();

        // Fetch the quiz data
        $quiz = $quizModel->find($quizId);

        // Fetch the soal data for this quiz
        $soals = $soalModel->where('quiz_id', $quizId)->findAll();

        // Pass both quiz and soal to the view
        return view('murid/view_quiz', [
            'quiz' => $quiz,
            'soals' => $soals
        ]);
    }

    // Menyimpan jawaban quiz murid
    public function submitQuiz($quizId)
    {
        $quizAnswersModel = new QuizAnswersModel();
        $quizResultsModel = new QuizResultsModel();
        $soalModel = new SoalModel();

        $soals = $soalModel->where('quiz_id', $quizId)->findAll(); // Mendapatkan semua soal untuk quiz ini
        $score = 0; // Nilai awal skor murid

        $muridId = session()->get('user_id');  // Mendapatkan ID murid yang sedang login

        // Iterasi melalui soal dan simpan jawaban murid
        foreach ($soals as $soal) {
            $jawaban = $this->request->getPost('jawaban_' . $soal['id']); // Mengambil jawaban dari form

            // Cek apakah jawaban benar
            $isCorrect = ($jawaban == $soal['jawaban_benar']) ? 1 : 0;

            // Tambahkan poin ke skor jika benar
            $score += $isCorrect * $soal['poin'];

            // Simpan jawaban ke tabel quiz_answers
            $quizAnswersModel->insert([
                'quiz_id' => $quizId,
                'murid_id' => $muridId,
                'soal_id' => $soal['id'],
                'jawaban_pilih' => $jawaban,
                'is_correct' => $isCorrect
            ]);
        }

        // Simpan hasil ke tabel quiz_results
        $quizResultsModel->insert([
            'quiz_id' => $quizId,
            'murid_id' => $muridId,
            'score' => $score
        ]);

        return redirect()->to('/murid/aksesKelas')->with('success', 'Quiz berhasil diselesaikan! Skor Anda: ' . $score);
    }
    public function updateLeaderboard($kelasId)
    {
        $quizResultsModel = new QuizResultsModel();
        $results = $quizResultsModel->where('kelas_id', $kelasId)->orderBy('score', 'DESC')->findAll();

        return view('murid/leaderboard', ['results' => $results]);
    }
}
