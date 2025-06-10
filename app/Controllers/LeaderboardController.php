<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\KelasSiswaModel;
use App\Models\MateriSiswaModel;
use App\Models\QuizResultsModel;
use CodeIgniter\Controller;

class LeaderboardController extends Controller
{
    public function showLeaderboard($kelasId)
    {

        $muridId = session()->get("user_id");

        $materiSiswaModel = new MateriSiswaModel();
        $quizResultModel = new QuizResultsModel();
        $kelasModel = new KelasModel();
        $kelasSiswaModel = new KelasSiswaModel();

        // validasi kelas
        $kelas = $kelasModel->find($kelasId);
        if (!$kelas) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Kelas tidak ditemukan');
        }

        // cek status siswa di kelas ini
        $kelasSiswa = $kelasSiswaModel
            ->whereMuridKelas($muridId, $kelasId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Anda tidak terdaftar di kelas ini');
        }

        $allMuridData = $kelasSiswaModel
            ->whereKelas($kelasId)
            ->select('users.id, users.username')
            ->join('users', 'users.id = kelas_siswa.murid_id')
            ->findAll();

        $muridIdList = array_column($allMuridData, 'id');

        $materi = $materiSiswaModel
            ->select('materi_siswa.*, materi.point')
            ->join('materi', 'materi.id = materi_siswa.materi_id')
            ->whereIn('materi_siswa.murid_id', $muridIdList) // Ambil semua materi berdasarkan daftar murid_id
            ->where('materi.kelas_id', $kelasId)
            ->findAll();

        $groupedData = [];

        // Mapping id
        $usernameMap = array_column($allMuridData, 'username', 'id');

        foreach ($materi as $entry) {
            $muridId = $entry['murid_id'];

            if (!isset($groupedData[$muridId])) {
                $groupedData[$muridId] = [
                    'murid_id' => $muridId,
                    'username' => $usernameMap[$muridId] ?? 'Unknown',
                    'total_score_materi' => 0,
                    'total_score_quiz' => 0,
                    'total_point' => 0
                ];
            }

            $groupedData[$muridId]['total_score_materi'] += $entry['point'];
            $groupedData[$muridId]['total_point'] += $entry['point'];
        }

        $quizResults = $quizResultModel
            ->where('kelas_id', $kelasId)
            ->findAll();

        foreach ($quizResults as $quiz) {
            $muridId = $quiz['murid_id'];

            if (!isset($groupedData[$muridId])) {
                $groupedData[$muridId] = [
                    'murid_id' => $muridId,
                    'username' => $usernameMap[$muridId] ?? 'Unknown',
                    'total_score_materi' => 0,
                    'total_score_quiz' => 0,
                    'total_point' => 0
                ];
            }

            $groupedData[$muridId]['total_score_quiz'] += $quiz['score'];
            $groupedData[$muridId]['total_point'] += $quiz['score'];
        }

        $leaderboard = [
            'nama_kelas' => $kelas['nama_kelas'] ?? 'Unknown',
            'data_siswa' => array_values($groupedData)
        ];

        // Kirim data leaderboard ke view
        return view('murid/leaderboard', ['leaderboard' => $leaderboard]);
    }
}
