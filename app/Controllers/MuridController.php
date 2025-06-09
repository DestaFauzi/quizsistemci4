<?php

namespace App\Controllers;

use App\Models\MateriSiswaModel;
use CodeIgniter\Controller;
use App\Models\KelasModel;
use App\Models\KelasSiswaModel;
use App\Models\BadgeModel;
use App\Models\MateriModel;
use App\Models\QuizModel;
use App\Models\QuizAnswersModel;
use App\Models\QuizResultsModel;
use App\Models\SoalModel;

class MuridController extends Controller
{
    // Fungsi untuk dashboard murid
    public function dashboard()
    {
        // Memeriksa apakah user memiliki role guru (role_id == 2)
        if (session()->get('role_id') != 3) {
            return redirect()->to('/');
        }

        return view('murid/dashboard');
    }

    public function semuaKelas()
    {
        // Ambil semua kelas dari tabel kelas yang memiliki status 'aktif'
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->where('status', 'aktif')->findAll(); // Filter hanya kelas dengan status aktif

        // Ambil status kelas untuk murid yang sedang login
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');
        $statusKelas = $kelasSiswaModel->where('murid_id', $muridId)->findAll();

        // Gabungkan data kelas dan status kelas murid
        foreach ($kelas as &$item) {
            $item['status_murid'] = 'belum dimulai';  // Default status kelas

            // Periksa status kelas dari tabel kelas_siswa
            foreach ($statusKelas as $status) {
                if ($status['kelas_id'] == $item['id']) {
                    $item['status_murid'] = $status['status']; // Menetapkan status kelas untuk murid
                    break;
                }
            }
        }

        // Kirim data kelas aktif ke view
        return view('murid/semua_kelas', ['kelas' => $kelas]);
    }

    public function kelasDalamProses()
    {
        // Ambil kelas yang sedang dalam proses untuk murid yang sedang login
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');

        // Dapatkan kelas yang statusnya 'proses' untuk murid
        $kelasSiswa = $kelasSiswaModel->where('murid_id', $muridId)
            ->where('status', 'proses')
            ->findAll();

        // Ambil data kelas
        $kelasModel = new KelasModel();
        $kelasList = [];
        foreach ($kelasSiswa as $kelas) {
            $kelasList[] = $kelasModel->find($kelas['kelas_id']);
        }

        // Ambil materi dan quiz untuk masing-masing kelas
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();
        foreach ($kelasList as &$kelas) {
            $kelas['materi'] = $materiModel->where('kelas_id', $kelas['id'])->orderBy('level', 'ASC')->findAll();
            $kelas['quiz'] = $quizModel->where('kelas_id', $kelas['id'])->orderBy('level', 'ASC')->findAll();
        }

        // Kirim data kelas, materi, dan quiz ke view
        return view('murid/kelas_dalam_proses', ['kelasList' => $kelasList]);
    }

    public function kelasSelesai()
    {
        $kelasModel = new KelasModel();
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');

        // Ambil semua kelas yang sudah selesai untuk murid
        $kelasSelesai = $kelasSiswaModel->where('murid_id', $muridId)
            ->where('status', 'selesai')
            ->findAll();

        $kelasList = [];

        foreach ($kelasSelesai as $kelasSiswa) {
            // Ambil data kelas dan materi serta quiz yang terkait
            $kelas = $kelasModel->find($kelasSiswa['kelas_id']);
            $materiModel = new MateriModel();
            $quizModel = new QuizModel();

            $materi = $materiModel->where('kelas_id', $kelasSiswa['kelas_id'])->findAll();
            $quiz = $quizModel->where('kelas_id', $kelasSiswa['kelas_id'])->findAll();

            // Menambahkan data kelas beserta materi dan quiz
            $kelasList[] = [
                'nama_kelas' => $kelas['nama_kelas'],
                'deskripsi' => $kelas['deskripsi'],
                'materi' => $materi,
                'quiz' => $quiz
            ];
        }

        return view('murid/kelas_selesai', ['kelasList' => $kelasList]);
    }


    public function koleksiBadge()
    {
        // Ambil semua badge yang telah didapatkan murid
        $badgeModel = new BadgeModel();
        $badge = $badgeModel->where('murid_id', session()->get('user_id'))->findAll();

        return view('murid/koleksi_badge', ['badge' => $badge]);
    }

    // Fungsi untuk menyelesaikan kelas
    public function selesaikanKelas($kelasId)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');

        // Update status kelas menjadi 'selesai'
        $kelasSiswaModel->where('murid_id', $muridId)
            ->where('kelas_id', $kelasId)
            ->update(['status' => 'selesai']);

        return redirect()->to("/murid/aksesKelas/{$kelasId}")->with('success', 'Kelas berhasil diselesaikan!');
    }

    // Fungsi untuk menandai status kelas sebagai selesai
    public function selesaiKelas($kelas_id)
    {
        $kelasSiswaModel = new KelasSiswaModel();

        // Update status kelas menjadi selesai
        $kelasSiswaModel->updateStatusKelas(session()->get('user_id'), $kelas_id, 'selesai');

        // Cek jika semua materi dan quiz sudah selesai
        $this->markMateriAndQuizAsCompleted($kelas_id);

        // Berikan badge kepada murid
        $this->addBadge($kelas_id);

        return redirect()->to('/murid/dashboard')->with('success', 'Kelas selesai! Anda mendapatkan badge.');
    }

    // Fungsi untuk menandai status materi dan quiz sebagai selesai
    public function markMateriAndQuizAsCompleted($kelas_id)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $kelasSiswaModel->updateStatusMateri(session()->get('user_id'), $kelas_id, 'selesai');
        $kelasSiswaModel->updateStatusQuiz(session()->get('user_id'), $kelas_id, 'selesai');
    }

    // Fungsi untuk memberikan badge kepada murid
    public function addBadge($kelas_id)
    {
        $badgeModel = new BadgeModel();
        $badgeData = [
            'murid_id' => session()->get('user_id'),
            'badge_name' => 'Kelas Selesai: ' . $kelas_id,  // Badge berdasarkan nama kelas
            'date_earned' => date('Y-m-d H:i:s'),
        ];
        $badgeModel->addBadge($badgeData);
    }

    public function detailKelas($kelas_id)
    {
        // Load models
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();
        $kelasSiswaModel = new KelasSiswaModel();
        $quizResultsModel = new QuizResultsModel();

        // Dapatkan ID user dari session
        $userId = session()->get('user_id');

        // Validasi kelas
        $kelas = $kelasModel->find($kelas_id);
        if (!$kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan');
        }

        // Cek status siswa di kelas ini
        $kelasSiswa = $kelasSiswaModel->where('kelas_id', $kelas_id)
            ->where('murid_id', $userId)
            ->first();

        // Default status jika belum terdaftar
        $status = [
            'status' => 'belum_dimulai',
            'status_materi' => 'belum_diakses',
            'status_quiz' => 'belum_dikerjakan',
            'level_materi' => 1,
            'level_quiz' => 1
        ];

        // Jika sudah terdaftar, update status
        if ($kelasSiswa) {
            $statusMateriInfo = $this->determineStatusAndLevelMateri($userId, $kelas_id);

            $status = [
                'status' => $kelasSiswa['status'],
                'status_materi' => $statusMateriInfo['status_materi'],
                'status_quiz' => $kelasSiswa['status_quiz'],
                'level_materi' => $statusMateriInfo['level_materi'],
                'level_quiz' => $this->determineCurrentLevelQuiz($userId, $kelas_id)
            ];
        }

        // Dapatkan materi dan quiz untuk kelas ini
        $materi = $materiModel->where('kelas_id', $kelas_id)
            ->orderBy('level', 'asc')
            ->findAll();

        $quiz = $quizModel->where('kelas_id', $kelas_id)
            ->orderBy('level', 'asc')
            ->findAll();

        // Validasi akses materi dan quiz berdasarkan level
        $filteredMateri = [];
        $filteredQuiz = [];

        $materiSiswaModel = new MateriSiswaModel();
        foreach ($materi as $m) {
            if ($status['status'] == 'belum_dimulai') {
                $m['can_access'] = false;
                $m['is_completed'] = false;
            } elseif ($m['level'] <= $status['level_materi']) {
                $m['can_access'] = true;

                // cek materi yang terakhir udh selesai atau belum
                $materiSiswa = $materiSiswaModel
                    ->where('murid_id', $userId)
                    ->where('materi_id', $m['id'])
                    ->orderBy('created_at', 'desc')
                    ->first();

                $m['is_completed'] = ($materiSiswa && $materiSiswa['status'] === 'selesai');
            } else {
                $m['can_access'] = false;
                $m['is_completed'] = false;
            }

            $filteredMateri[] = $m;
        }

        foreach ($quiz as $q) {
            if ($status['status'] == 'belum_dimulai') {
                $q['can_access'] = false;
                $q['is_completed'] = false;
                $q['score'] = null;
                $q['max_score'] = 0;
            } else {
                // Cek apakah quiz ini sudah diselesaikan
                $quizResult = $quizResultsModel
                    ->where('murid_id', $userId)
                    ->where('quiz_id', $q['id'])
                    ->first();

                $q['is_completed'] = $quizResult !== null;
                $q['score'] = $quizResult['score'] ?? null;
                $q['max_score'] = $quizResult['max_score'] ?? 0;

                // Validasi pastikan semua materi dengan level <= quiz sudah selesai
                $requiredMateri = $materiModel
                    ->where('kelas_id', $kelas['id'])
                    ->where('level <=', $q['level'])
                    ->findAll();

                $semuaMateriSelesai = true;
                foreach ($requiredMateri as $materi) {
                    $materiSiswa = $materiSiswaModel
                        ->where('murid_id', $userId)
                        ->where('materi_id', $materi['id'])
                        ->where('status', 'selesai')
                        ->first();

                    if (!$materiSiswa) {
                        $semuaMateriSelesai = false;
                        break;
                    }
                }

                // Validasi quiz sebelumnya (level - 1) apakah sudah selesai
                $quizSebelumnya = $quizResultsModel
                    ->where('murid_id', $userId)
                    ->join('quiz', 'quiz.id = quiz_results.quiz_id')
                    ->where('quiz.kelas_id', $kelas['id'])
                    ->where('quiz.level', $q['level'] - 1)
                    ->first();

                $quizSebelumnyaSelesai = ($q['level'] == 1) || $quizSebelumnya !== null;

                $q['can_access'] = $semuaMateriSelesai && $quizSebelumnyaSelesai;
            }

            $filteredQuiz[] = $q;
        }

        // Data untuk view
        $data = [
            'kelas' => $kelas,
            'materi' => $filteredMateri,
            'quiz' => $filteredQuiz,
            'status' => $status
        ];

        return view('murid/detail_kelas', $data);
    }

    private function determineStatusAndLevelMateri($muridId, $kelasId)
    {
        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();

        $materiList = $materiModel
            ->where('kelas_id', $kelasId)
            ->orderBy('level', 'asc')
            ->findAll();

        if (empty($materiList)) {
            return [
                'level_materi' => 1,
                'status_materi' => 'belum_diakses'
            ];
        }

        foreach ($materiList as $materi) {
            $materiSiswa = $materiSiswaModel
                ->where('materi_id', $materi['id'])
                ->where('murid_id', $muridId)
                ->first();

            if (!$materiSiswa) {
                // Ini materi baru yg belum dibaca
                return [
                    'level_materi' => $materi['level'],
                    'status_materi' => 'belum_diakses'
                ];
            }

            if ($materiSiswa['status'] !== 'selesai') {
                // Sudah dibuka tapi belum selesai
                return [
                    'level_materi' => $materi['level'],
                    'status_materi' => $materiSiswa['status']
                ];
            }
        }

        // semua materi sudah ada di materi_siswa dengan semua status selesai
        // level aktif nextnya tetap di level terakhir (karena materi sudah habis)
        $lastLevel = end($materiList)['level'];

        return [
            'level_materi' => $lastLevel,
            'status_materi' => 'selesai'
        ];
    }

    private function determineCurrentLevelQuiz($userId, $kelasId)
    {
        $quizModel = new QuizModel();
        $quizResultsModel = new QuizResultsModel();

        // Dapatkan semua quiz di kelas ini diurutkan berdasarkan level
        $allQuizzes = $quizModel->where('kelas_id', $kelasId)
            ->orderBy('level', 'asc')
            ->findAll();

        $currentLevel = 1;

        foreach ($allQuizzes as $quiz) {
            // Cek apakah user sudah menyelesaikan quiz di level ini
            $result = $quizResultsModel->where('murid_id', $userId)
                ->where('quiz_id', $quiz['id'])
                ->first();

            if ($result) {
                $currentLevel = $quiz['level'] + 1;
            } else {
                break;
            }
        }

        return $currentLevel;
    }

    protected function getQuizLevelSiswa($muridId, $kelasId)
    {
        $quizModel = new QuizModel();
        $quizResultsModel = new QuizResultsModel();

        // Ambil semua quiz untuk kelas ini
        $quizList = $quizModel->where('kelas_id', $kelasId)->findAll();
        $quizIdToLevel = [];
        foreach ($quizList as $q) {
            $quizIdToLevel[$q['id']] = $q['level'];
        }

        // Ambil hasil quiz yang telah dikerjakan
        $results = $quizResultsModel->where('murid_id', $muridId)->findAll();

        $maxLevel = 0;
        foreach ($results as $result) {
            if (isset($quizIdToLevel[$result['quiz_id']])) {
                $level = $quizIdToLevel[$result['quiz_id']];
                if ($level > $maxLevel) {
                    $maxLevel = $level;
                }
            }
        }

        return $maxLevel + 1; // level selanjutnya yang bisa diakses
    }

    public function masukKelas($id)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $userId = session()->get('user_id');

        // Cek apakah sudah terdaftar di kelas
        $existing = $kelasSiswaModel->where('kelas_id', $id)
            ->where('murid_id', $userId)
            ->first();

        if (!$existing) {
            // Daftarkan siswa ke kelas
            $data = [
                'kelas_id' => $id,
                'murid_id' => $userId,
                'status' => 'proses',
                'status_materi' => 'belum_diakses',
                'status_quiz' => 'belum_dikerjakan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $kelasSiswaModel->insert($data);
        } else {
            // Update status jika sudah terdaftar tapi belum mulai
            if ($existing['status'] == 'belum_dimulai') {
                $kelasSiswaModel->update($existing['id'], [
                    'status' => 'proses',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to("/murid/detailKelas/$id");
    }

    public function selesaikanMateri($kelasId, $materiId)
    {
        $muridId = session()->get('user_id');

        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();

        // cek materinya ada atau tidak
        $materi = $materiModel->find($materiId);
        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan.');
        }

        // cek apakah user terdaftar di kelas
        $kelasSiswaModel = new KelasSiswaModel();
        $kelasSiswa = $kelasSiswaModel
            ->where('kelas_id', $kelasId)
            ->where('murid_id', $muridId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar dalam kelas ini.');
        }

        // update status materi ini menjadi selesai
        $materiSiswa = $materiSiswaModel
            ->where('materi_id', $materiId)
            ->where('murid_id', $muridId)
            ->first();

        if ($materiSiswa) {
            $materiSiswaModel->update($materiSiswa['id'], ['status' => 'selesai']);
        } else {
            $materiSiswaModel->save([
                'materi_id' => $materiId,
                'murid_id' => $muridId,
                'status' => 'selesai',
            ]);
        }

        // cek materi level berikutnya
        $nextLevel = $materi['level'] + 1;
        $nextMateri = $materiModel
            ->where('kelas_id', $kelasId)
            ->where('level', $nextLevel)
            ->first();

        if ($nextMateri) {
            // cek apakah siswa sudah punya data untuk next materi
            $existingNext = $materiSiswaModel
                ->where('materi_id', $nextMateri['id'])
                ->where('murid_id', $muridId)
                ->first();

            if (!$existingNext) {
                // tambahkan status belum_diakses untuk materi selanjutnya
                $materiSiswaModel->save([
                    'materi_id' => $nextMateri['id'],
                    'murid_id' => $muridId,
                    'status' => 'belum_diakses',
                ]);
            }
        } else {
            $kelasSiswa = $kelasSiswaModel
                ->where('kelas_id', $kelasId)
                ->where('murid_id', $muridId)
                ->first();

            if ($kelasSiswa) {
                $updateData = [
                    'status_materi' => 'selesai',
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Jika status_quiz sudah selesai juga → update status kelas jadi selesai
                if ($kelasSiswa['status_quiz'] === 'selesai') {
                    $updateData['status'] = 'selesai';
                }

                $kelasSiswaModel
                    ->update($kelasSiswa['id'], $updateData);
            }
        }


        return redirect()->to("/murid/detailKelas/{$kelasId}")->with('success', 'Materi berhasil diselesaikan!');
    }

    // public function masukKelas($id)
    // {
    //     $kelasSiswaModel = new KelasSiswaModel();
    //     $userId = session()->get('user_id');

    //     // Cek apakah sudah terdaftar di kelas
    //     $existing = $kelasSiswaModel->where('kelas_id', $id)
    //         ->where('murid_id', $userId)
    //         ->first();

    //     if (!$existing) {
    //         // Daftarkan siswa ke kelas
    //         $data = [
    //             'kelas_id' => $id,
    //             'murid_id' => $userId,
    //             'status' => 'proses',
    //             'status_materi' => 'belum_diakses',
    //             'status_quiz' => 'belum_dikerjakan',
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s')
    //         ];
    //         $kelasSiswaModel->insert($data);
    //     } else {
    //         // Update status jika sudah terdaftar tapi belum mulai
    //         if ($existing['status'] == 'belum_dimulai') {
    //             $kelasSiswaModel->update($existing['id'], [
    //                 'status' => 'proses',
    //                 'updated_at' => date('Y-m-d H:i:s')
    //             ]);
    //         }
    //     }

    //     return redirect()->to("/murid/lanjutkanKelas/$id");
    // }
    // public function masukKelas($kelas_id)
    // {
    //     $kelasSiswaModel = new KelasSiswaModel();
    //     $muridId = session()->get('user_id');

    //     // Periksa apakah murid sudah terdaftar dalam kelas ini
    //     $kelasSiswa = $kelasSiswaModel->where('murid_id', $muridId)
    //         ->where('kelas_id', $kelas_id)
    //         ->first();

    //     if (!$kelasSiswa) {
    //         // Jika belum, buat record baru dengan status 'proses'
    //         $kelasSiswaModel->save([
    //             'kelas_id' => $kelas_id,
    //             'murid_id' => $muridId,
    //             'status' => 'proses',
    //             'status_materi' => 'belum_diakses',
    //             'status_quiz' => 'belum_dikerjakan',
    //         ]);
    //     } else {
    //         // Update status menjadi 'proses' jika sudah terdaftar
    //         $kelasSiswaModel->update($kelasSiswa['id'], [
    //             'status' => 'proses',
    //             'status_materi' => 'belum_diakses',
    //             'status_quiz' => 'belum_dikerjakan',
    //         ]);
    //     }

    //     // Redirect ke halaman detail kelas
    //     return redirect()->to('/murid/detailKelas/' . $kelas_id);
    // }
    // Fungsi untuk melanjutkan kelas



    public function lanjutkanKelas($kelasId)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $userId = session()->get('user_id');

        // Cek apakah murid sudah terdaftar di kelas ini
        $kelasSiswa = $kelasSiswaModel->where('kelas_id', $kelasId)
            ->where('murid_id', $userId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Cek status kelas
        if ($kelasSiswa['status'] == 'selesai') {
            return redirect()->to("/murid/aksesKelas/{$kelasId}")->with('info', 'Anda sudah menyelesaikan kelas ini.');
        }

        // Redirect ke halaman akses kelas
        return redirect()->to("/murid/aksesKelas/{$kelasId}");
    }

    public function aksesKelas($kelasId)
    {
        // Ambil data kelas berdasarkan kelasId
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($kelasId);

        // Ambil status kelas murid
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');
        $statusKelas = $kelasSiswaModel->where('kelas_id', $kelasId)
            ->where('murid_id', $muridId)
            ->first();

        // Ambil materi dan quiz yang terkait dengan kelas
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();

        $materi = $materiModel->where('kelas_id', $kelasId)->findAll();
        $quiz = $quizModel->where('kelas_id', $kelasId)->findAll();

        // Cek status level (belum bisa akses level lebih tinggi tanpa menyelesaikan level sebelumnya)
        $status_materi_level_1 = $this->cekStatusLevel('materi', $muridId, $kelasId, 1);
        $status_quiz_level_1 = $this->cekStatusLevel('quiz', $muridId, $kelasId, 1);
        // Jika murid belum terdaftar di kelas, redirect ke halaman masuk kelas
        if (!$statusKelas) {
            return redirect()->to("/murid/masukKelas/{$kelasId}")->with('error', 'Anda belum terdaftar di kelas ini.');
        }
        // Jika murid sudah menyelesaikan kelas, redirect ke halaman detail kelas
        if ($statusKelas['status'] == 'selesai') {
            return redirect()->to("/murid/detailKelas/{$kelasId}")->with('info', 'Anda sudah menyelesaikan kelas ini.');
        }
        // Jika murid belum memulai kelas, set status awal
        if ($statusKelas['status'] == 'belum_dimulai') {
            $kelasSiswaModel->update($statusKelas['id'], [
                'status' => 'proses',
                'status_materi' => 'belum_diakses',
                'status_quiz' => 'belum_dikerjakan',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        // Jika murid sudah memulai kelas, pastikan statusnya 'proses'
        elseif ($statusKelas['status'] != 'proses') {
            $kelasSiswaModel->update($statusKelas['id'], [
                'status' => 'proses',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        // Kirim data ke view
        return view('murid/akses_kelas', [
            'kelas' => $kelas,
            'materi' => $materi,
            'quiz' => $quiz,
            'status_materi_level_1' => $status_materi_level_1,
            'status_quiz_level_1' => $status_quiz_level_1
        ]);
    }

    // Fungsi untuk mengecek status materi atau quiz untuk level tertentu
    private function cekStatusLevel($type, $muridId, $kelasId, $level)
    {
        // Model yang digunakan untuk materi dan quiz
        $model = ($type === 'materi') ? new MateriModel() : new QuizModel();

        // Cari materi atau quiz berdasarkan level dan kelas
        $data = $model->where('kelas_id', $kelasId)
            ->where('level', $level)
            ->first();

        if ($data) {
            // Periksa status untuk materi atau quiz yang bersangkutan
            $kelasSiswaModel = new KelasSiswaModel();
            $status = $kelasSiswaModel->where('murid_id', $muridId)
                ->where('kelas_id', $kelasId)
                ->first();

            return $status['status'] === 'selesai' ? 'selesai' : 'belum selesai';
        }

        return 'belum selesai';
    }

    private function checkLevelStatus($muridId, $kelas_id, $level, $type)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $status = $kelasSiswaModel->where('murid_id', $muridId)->where('kelas_id', $kelas_id)->first();

        // Implement the logic to check if the user has completed the material or quiz at the specific level.
        // Return true if completed, false if not.

        return true;  // Just as a placeholder for now
    }

    // Fungsi untuk menyelesaikan dan submit quiz

    public function aksesMateri($kelasId, $materiId)
    {
        $muridId = session()->get('user_id');

        $kelasSiswaModel = new KelasSiswaModel();
        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();

        $materi = $materiModel->find($materiId);
        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan.');
        }

        $kelasSiswa = $kelasSiswaModel
            ->where('kelas_id', $kelasId)
            ->where('murid_id', $muridId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar di kelas ini.');
        }

        if ($materi['level'] > 1) {
            $prevMateri = $materiModel
                ->where('kelas_id', $kelasId)
                ->where('level', $materi['level'] - 1)
                ->first();

            if ($prevMateri) {
                $prevProgress = $materiSiswaModel
                    ->where('materi_id', $prevMateri['id'])
                    ->where('murid_id', $muridId)
                    ->where('status', 'selesai')
                    ->first();

                if (!$prevProgress) {
                    return redirect()->back()->with('error', 'Selesaikan materi sebelumnya terlebih dahulu.');
                }
            }
        }

        // cek apakah sudah ada data di materi_siswa
        $existing = $materiSiswaModel
            ->where('materi_id', $materiId)
            ->where('murid_id', $muridId)
            ->first();

        if (!$existing) {
            // jika belum ada, buat baru dengan status 'sedang_dibaca'
            $materiSiswaModel->save([
                'materi_id' => $materiId,
                'murid_id' => $muridId,
                'status' => 'sedang_dibaca',
            ]);
        } elseif ($existing['status'] === 'belum_diakses') {
            // jika ada tapi status masih 'belum_diakses', update ke 'sedang_dibaca'
            $materiSiswaModel->update($existing['id'], ['status' => 'sedang_dibaca']);
        }

        // redirect ke file_path (lihat materi)
        return redirect()->to(base_url($materi['file_path']));
    }

    // public function submitQuiz($kelasId, $quizId)
    // {
    //     $quizModel = new QuizModel();
    //     $soalModel = new SoalModel();
    //     $quizResultsModel = new QuizResultsModel();
    //     $kelasSiswaModel = new KelasSiswaModel();

    //     $userId = session()->get('user_id');
    //     $quiz = $quizModel->find($quizId);

    //     // Validasi
    //     if (!$quiz || $quiz['kelas_id'] != $kelasId) {
    //         return redirect()->back()->with('error', 'Quiz tidak valid');
    //     }

    //     // Proses jawaban quiz
    //     $jawaban = $this->request->getPost('jawaban');
    //     $soalQuiz = $soalModel->where('quiz_id', $quizId)->findAll();

    //     $score = 0;
    //     foreach ($soalQuiz as $soal) {
    //         if (isset($jawaban[$soal['id']])) {
    //             if ($jawaban[$soal['id']] == $soal['jawaban_benar']) {
    //                 $score += $soal['poin'];
    //             }
    //         }
    //     }

    //     // Simpan hasil quiz
    //     $quizResultsModel->insert([
    //         'quiz_id' => $quizId,
    //         'murid_id' => $userId,
    //         'kelas_id' => $kelasId,
    //         'score' => $score,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s')
    //     ]);

    //     // Jika quiz level 1, update status_quiz
    //     if ($quiz['level'] == 1) {
    //         $kelasSiswaModel->where('kelas_id', $kelasId)
    //             ->where('murid_id', $userId)
    //             ->set([
    //                 'status_quiz' => 'selesai',
    //                 'updated_at' => date('Y-m-d H:i:s')
    //             ])
    //             ->update();
    //     }

    //     // Cek apakah ini quiz terakhir untuk naik level
    //     $this->checkLevelCompletion($userId, $kelasId);

    //     return redirect()->to("/murid/detailKelas/$kelasId")
    //         ->with('success', 'Quiz berhasil diselesaikan! Skor: ' . $score);
    // }


    /**
     * Menangani akses ke halaman quiz untuk murid
     */
    public function aksesQuiz($kelasId, $quizId): \CodeIgniter\HTTP\RedirectResponse|string
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();
        $kelasModel = new KelasModel();

        $muridId = session()->get('user_id');

        // cek kelas ada atau engga
        $kelas = $kelasModel->find($kelasId);

        if (!$kelas) {
            return redirect()->to(site_url("murid/semuaKelas"))->with('error', 'Kelas tidak ditemukan.');
        }

        $quiz = $quizModel->find($quizId);
        if (!$quiz) {
            // masukin Quizid ngasal
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))
                ->with('error', 'Quiz tidak ditemukan.');
        }

        // Kalau quiz ada, cek quiz itu di kelas yang sama atau bukan
        if ($quiz['kelas_id'] != $kelasId) {
            return redirect()->to(site_url("murid/detailKelas/ $kelasId"))
                ->with('error', 'Quiz tidak sesuai dengan kelas.');
        }

        // cek quiz sudah selesai atau belum
        $quizResultModel = new QuizResultsModel();
        $quizResult = $quizResultModel
            ->where('quiz_id', $quizId)
            ->where('murid_id', $muridId)
            ->first();

        if ($quizResult) {
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))
                ->with('error', 'Anda sudah menyelesaikan quiz ini.');
        }

        // Validasi apakah materi level sebelumnya sudah diakses
        $materiSiswaModel = new MateriSiswaModel();
        $materiModel = new MateriModel();

        $requiredMateri = $materiModel
            ->where('kelas_id', $kelas['id'])
            ->where('level <=', $quiz['level']) // semua materi sebelum quiz ini
            ->orderBy('level', 'asc')
            ->findAll();

        foreach ($requiredMateri as $materi) {
            $materiSiswa = $materiSiswaModel
                ->where('murid_id', $muridId)
                ->where('materi_id', $materi['id'])
                ->where('status', 'selesai')
                ->first();

            if (!$materiSiswa) {
                return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Anda harus menyelesaikan semua materi sebelumnya untuk mengakses quiz ini.');
            }
        }

        // Ambil soal quiz
        $soals = $soalModel->where('quiz_id', $quizId)->findAll();

        return view('murid/akses_quiz', ['quiz' => $quiz, 'soals' => $soals, 'kelasId' => $kelas['id']]);
    }

    // function untuk submit jawaban quiz
    public function submitQuiz($kelasId, $quizId)
    {
        $kelasModel = new KelasModel();
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();
        $quizAnswersModel = new QuizAnswersModel();
        $quizResultsModel = new QuizResultsModel();
        $kelasSiswaModel = new KelasSiswaModel();

        $userId = session()->get('user_id');

        // cek kelas ada atau engga
        $kelas = $kelasModel->find($kelasId);
        if (!$kelas) {
            return redirect()->to(site_url("murid/semuaKelas"))->with('error', 'Kelas tidak ditemukan.');
        }

        $quiz = $quizModel->find($quizId);
        if (!$quiz) {
            // masukin Quizid ngasal
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))
                ->with('error', 'Quiz tidak ditemukan.');
        }

        // Kalau quiz ada, cek quiz itu di kelas yang sama atau bukan
        if ($quiz['kelas_id'] != $kelasId) {
            return redirect()->to(site_url("murid/detailKelas/ $kelasId"))
                ->with('error', 'Quiz tidak sesuai dengan kelas.');
        }

        // Simpan jawaban yang diberikan murid ke tabel quiz_answers
        $jawaban = $this->request->getPost('jawaban_pilih');
        $soalQuiz = $soalModel->where('quiz_id', $quizId)->findAll();
        $score = 0;
        $maxScore = 0;

        foreach ($soalQuiz as $soal) {
            $maxScore += $soal['poin'];
            if (isset($jawaban[$soal['id']])) {
                $isCorrect = false;

                // Cek apakah jawaban benar
                if ($jawaban[$soal['id']] == $soal['jawaban_benar']) {
                    $isCorrect = true;
                    $score += $soal['poin'];
                }

                // Simpan jawaban murid ke tabel quiz_answers
                $quizAnswersModel->insert([
                    'quiz_id' => $quizId,
                    'murid_id' => $userId,
                    'kelas_id' => $kelasId,
                    'soal_id' => $soal['id'],
                    'jawaban_pilih' => $jawaban[$soal['id']],
                    'is_correct' => $isCorrect,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                // Jika jawaban benar, tambahkan poin ke skor
            } else {
                // Jika jawaban tidak ada, berarti murid tidak menjawab soal ini
                // Tidak menambah skor jika tidak ada jawaban    
                $quizAnswersModel->insert([
                    'quiz_id' => $quizId,
                    'murid_id' => $userId,
                    'soal_id' => $soal['id'],
                    'kelas_id' => $kelasId,
                    'jawaban_pilih' => null, // Tidak ada jawaban
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Simpan hasil quiz ke tabel quiz_results
        $quizResultsModel->insert([
            'quiz_id' => $quizId,
            'murid_id' => $userId,
            'kelas_id' => $kelasId,
            'score' => $score,
            'max_score' => $maxScore,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Update status quiz di kelas_siswa menjadi 'selesai' ketika semua quiz telah diselesaikan
        $kelasSiswa = $kelasSiswaModel->where('kelas_id', $kelasId)
            ->where('murid_id', $userId)
            ->first();

        if ($kelasSiswa) {
            // Cek quiz lanjutan
            $nextQuiz = $quizModel
                ->where('kelas_id', $kelasId)
                ->where('level >', $quiz['level'])
                ->first();

            if ($nextQuiz) {
                // Masih ada quiz berikutnya, status quiz dan kelas masih proses
                $kelasSiswaModel->update($kelasSiswa['id'], [
                    'status_quiz' => 'belum_dikerjakan',
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                // Quiz sudah selesai
                $updateData = [
                    'status_quiz' => 'selesai',
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                if ($kelasSiswa['status_materi'] === 'selesai') {
                    // Semua materi & quiz selesai, update status kelas juga jadi selesai
                    $updateData['status'] = 'selesai';
                }

                $kelasSiswaModel->update($kelasSiswa['id'], $updateData);
            }
        }

        return redirect()->to("/murid/detailKelas/$kelasId")->with('success', "Quiz berhasil diselesaikan! Skor: $score");
    }

    // private function checkNextLevel($kelasId, $muridId, $quizId)
    // {
    //     $materiModel = new MateriModel();
    //     $kelasSiswaModel = new KelasSiswaModel();

    //     // Ambil level quiz yang selesai
    //     $quizModel = new QuizModel();
    //     $quiz = $quizModel->find($quizId);
    //     $level = $quiz['level'];

    //     // Cek apakah ada materi di level berikutnya
    //     $nextLevel = $level + 1;
    //     $nextMateri = $materiModel->where('kelas_id', $kelasId)
    //         ->where('level', $nextLevel)
    //         ->first();

    //     if ($nextMateri) {
    //         // Jika ada materi di level berikutnya, set status materi sebagai 'belum diakses'
    //         return true;
    //     }

    //     return false;
    // }
}
