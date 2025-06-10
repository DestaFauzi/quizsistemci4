<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\KelasSiswaModel;
use App\Models\MateriSiswaModel;
use App\Models\QuizResultsModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class LeaderboardController extends Controller
{
    protected function validationPage($muridId, $kelasId)
    {
        $kelasModel = new KelasModel();
        $kelasSiswaModel = new KelasSiswaModel();

        $kelas = $kelasModel->find($kelasId);
        if (!$kelas) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Kelas tidak ditemukan.');
        }

        $kelasSiswa = $kelasSiswaModel
            ->where('murid_id', $muridId)
            ->where('kelas_id', $kelasId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Anda tidak terdaftar di kelas ini.');
        }

        return true;
    }

    public function showLeaderboard($kelasId)
    {
        $userId = session()->get("user_id");

        $materiSiswaModel = new MateriSiswaModel();
        $quizResultModel = new QuizResultsModel();
        $kelasModel = new KelasModel();
        $kelasSiswaModel = new KelasSiswaModel();
        $userModel = new UserModel();

        $user = $userModel
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->find($userId);

        if (!$user) {
            return redirect()->to('/')->with('error', 'Pengguna tidak ditemukan atau sesi berakhir.');
        }

        $userRoleName = $user['role_name'];

        if ($userRoleName === 'murid') {
            $validationResult = $this->validationPage($userId, $kelasId);
            if ($validationResult !== true) {
                return $validationResult;
            }
        } elseif ($userRoleName === 'guru') {
            $kelas = $kelasModel->find($kelasId);
            if (!$kelas) {
                return redirect()->to(site_url('guru/viewClasses'))->with('error', 'Kelas tidak ditemukan.');
            }
        } else {
            return redirect()->to('/')->with('error', 'Akses ditolak. Peran pengguna tidak diizinkan.');
        }

        $allMuridData = $kelasSiswaModel
            ->where('kelas_id', $kelasId)
            ->select('users.id, users.username')
            ->join('users', 'users.id = kelas_siswa.murid_id')
            ->findAll();

        $muridIdList = array_column($allMuridData, 'id');
        // $usernameMap = array_column($allMuridData, 'username', 'id');

        $groupedData = [];

        foreach ($allMuridData as $murid) {
            $groupedData[$murid['id']] = [
                'murid_id'           => $murid['id'],
                'username'           => $murid['username'],
                'total_score_materi' => 0,
                'total_score_quiz'   => 0,
                'total_point'        => 0
            ];
        }

        if (!empty($muridIdList)) {
            $materi = $materiSiswaModel
                ->select('materi_siswa.murid_id, materi.point')
                ->join('materi', 'materi.id = materi_siswa.materi_id')
                ->whereIn('materi_siswa.murid_id', $muridIdList)
                ->where('materi.kelas_id', $kelasId)
                ->findAll();

            foreach ($materi as $entry) {
                $currentMuridId = $entry['murid_id'];
                if (isset($groupedData[$currentMuridId])) {
                    $groupedData[$currentMuridId]['total_score_materi'] += (int)$entry['point'];
                    $groupedData[$currentMuridId]['total_point'] += (int)$entry['point'];
                }
            }
        }

        $quizResults = $quizResultModel
            ->where('kelas_id', $kelasId)
            ->findAll();

        foreach ($quizResults as $quiz) {
            $currentMuridId = $quiz['murid_id'];
            if (isset($groupedData[$currentMuridId])) {
                $groupedData[$currentMuridId]['total_score_quiz'] += (int)$quiz['score'];
                $groupedData[$currentMuridId]['total_point'] += (int)$quiz['score'];
            }
        }

        $leaderboardData = array_values($groupedData);
        usort($leaderboardData, function ($a, $b) {
            return $b['total_point'] <=> $a['total_point'];
        });

        $rank = 1;
        $prevScore = -1;
        foreach ($leaderboardData as $key => &$entry) {
            if ($entry['total_point'] < $prevScore) {
                $rank++;
            }
            $entry['rank'] = $rank;
            $prevScore = $entry['total_point'];
        }
        unset($entry);

        $currentUserRank = null;
        if ($userRoleName === 'murid') {
            foreach ($leaderboardData as $entry) {
                if ($entry['murid_id'] == $userId) {
                    $currentUserRank = $entry['rank'];
                    break;
                }
            }
        }

        $pager = service('pager');
        $perPage = 10;

        $page = $this->request->getVar('page') ?? 1;

        $offset = ($page - 1) * $perPage;

        $paginatedLeaderboardData = array_slice($leaderboardData, $offset, $perPage);

        $pager->makeLinks($page, $perPage, count($leaderboardData));

        $kelasName = $kelasModel->select('nama_kelas')->find($kelasId)['nama_kelas'] ?? 'Nama Kelas Tidak Diketahui';

        $hasStudents = !empty($allMuridData);

        $data = [
            'leaderboard' => [
                'nama_kelas' => $kelasName,
                'data_murid' => $paginatedLeaderboardData,
            ],
            'pager'           => $pager,
            'currentPage'     => $page,
            'totalItems'      => count($leaderboardData),
            'hasStudents'     => $hasStudents,
            'kelasId'         => $kelasId,
            'currentUserRank' => $currentUserRank,
            'userRole'        => $userRoleName
        ];

        if ($userRoleName === 'guru') {
            return view('guru/leaderboard', $data);
        } elseif ($userRoleName === 'murid') {
            return view('murid/leaderboard', $data);
        }
        return redirect()->to('/')->with('error', 'Peran pengguna tidak dikenali.');
    }
}
