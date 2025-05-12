<?php

namespace App\Controllers;

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
        // Ambil data kelas berdasarkan ID
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($kelas_id);

        // Ambil data materi dan quiz untuk kelas
        $materiModel = new MateriModel();
        $materi = $materiModel->where('kelas_id', $kelas_id)->findAll();

        $quizModel = new QuizModel();
        $quiz = $quizModel->where('kelas_id', $kelas_id)->findAll();

        // Ambil status kelas untuk murid yang sedang login
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');
        $statusKelas = $kelasSiswaModel->where('murid_id', $muridId)
            ->where('kelas_id', $kelas_id)
            ->first();

        // Jika murid belum terdaftar dalam kelas, buat record baru
        if (!$statusKelas) {
            // Set status awal kelas menjadi 'belum dimulai'
            $kelasSiswaModel->save([
                'kelas_id' => $kelas_id,
                'murid_id' => $muridId,
                'status' => 'belum_dimulai',
                'status_materi' => 'belum_diakses',
                'status_quiz' => 'belum_dikerjakan',
            ]);
            $statusKelas = [
                'status' => 'belum_dimulai',
                'status_materi' => 'belum_diakses',
                'status_quiz' => 'belum_dikerjakan',
            ];
        }

        return view('murid/detail_kelas', [
            'kelas' => $kelas,
            'materi' => $materi,
            'quiz' => $quiz,
            'status' => $statusKelas
        ]);
    }

    public function masukKelas($kelas_id)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');

        // Periksa apakah murid sudah terdaftar dalam kelas ini
        $kelasSiswa = $kelasSiswaModel->where('murid_id', $muridId)
            ->where('kelas_id', $kelas_id)
            ->first();

        if (!$kelasSiswa) {
            // Jika belum, buat record baru dengan status 'proses'
            $kelasSiswaModel->save([
                'kelas_id' => $kelas_id,
                'murid_id' => $muridId,
                'status' => 'proses',
                'status_materi' => 'belum_diakses',
                'status_quiz' => 'belum_dikerjakan',
            ]);
        } else {
            // Update status menjadi 'proses' jika sudah terdaftar
            $kelasSiswaModel->update($kelasSiswa['id'], [
                'status' => 'proses',
                'status_materi' => 'belum_diakses',
                'status_quiz' => 'belum_dikerjakan',
            ]);
        }

        // Redirect ke halaman detail kelas
        return redirect()->to('/murid/detailKelas/' . $kelas_id);
    }
    // Fungsi untuk melanjutkan kelas
    public function lanjutkanKelas($kelasId)
    {
        // Update status kelas menjadi 'dalam proses' jika murid sudah mulai kelas
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = session()->get('user_id');

        // Periksa apakah kelas sudah dimulai oleh murid
        $status = $kelasSiswaModel->where('murid_id', $muridId)
            ->where('kelas_id', $kelasId)
            ->first();

        if ($status) {
            // Jika statusnya belum dimulai, update ke status 'dalam proses'
            $kelasSiswaModel->update($status['id'], ['status' => 'dalam proses']);
            return redirect()->to("/murid/aksesKelas/{$kelasId}")->with('success', 'Kelas telah dimulai.');
        }

        return redirect()->to("/murid/aksesKelas/{$kelasId}")->with('error', 'Kelas belum dimulai.');
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
        $kelasSiswaModel = new KelasSiswaModel();
        $materiModel = new MateriModel();
        $quizResultsModel = new QuizResultsModel();
        $muridId = session()->get('user_id');
        $materi = $materiModel->find($materiId);

        // Validasi apakah level sebelumnya sudah dikerjakan
        $prevLevel = $materi['level'] - 1;
        $completedQuiz = $quizResultsModel->where('murid_id', $muridId)
            ->where('kelas_id', $kelasId)
            ->where('level', $prevLevel)
            ->first();

        if ($prevLevel > 0 && !$completedQuiz) {
            return redirect()->back()->with('error', 'Anda harus menyelesaikan quiz di level sebelumnya.');
        }

        // Update status materi menjadi selesai
        $kelasSiswa = $kelasSiswaModel->where('kelas_id', $kelasId)
            ->where('murid_id', $muridId)
            ->first();

        if ($kelasSiswa) {
            // Update status materi ke 'selesai'
            $kelasSiswaModel->update($kelasSiswa['id'], ['status_materi' => 'selesai']);

            // Periksa level berikutnya
            $nextLevel = $materi['level'] + 1;
            $nextMateri = $materiModel->where('kelas_id', $kelasId)
                ->where('level', $nextLevel)
                ->first();
            if ($nextMateri) {
                // Jika ada materi level berikutnya, set statusnya menjadi 'belum_diakses'
                $kelasSiswaModel->update($kelasSiswa['id'], ['status_materi' => 'belum_diakses']);
            }
        }

        return redirect()->to("/murid/aksesKelas/{$kelasId}")->with('success', 'Materi berhasil diakses!');
    }


    public function submitQuiz($quizId)
    {
        $quizResultsModel = new QuizResultsModel();
        $quizAnswersModel = new QuizAnswersModel();
        $soalModel = new SoalModel();

        $soals = $soalModel->where('quiz_id', $quizId)->findAll();
        $score = 0;

        $muridId = session()->get('user_id');
        $kelasId = $this->request->getPost('kelas_id');  // Mengambil kelas_id dari form
        $quizModel = new QuizModel();
        $quiz = $quizModel->find($quizId);

        // Iterasi soal dan simpan jawaban
        foreach ($soals as $soal) {
            $jawaban = $this->request->getPost('jawaban_' . $soal['id']);
            $isCorrect = ($jawaban == $soal['jawaban_benar']) ? 1 : 0;
            $score += $isCorrect * $soal['poin'];

            $quizAnswersModel->insert([
                'quiz_id' => $quizId,
                'murid_id' => $muridId,
                'soal_id' => $soal['id'],
                'jawaban_pilih' => $jawaban,
                'is_correct' => $isCorrect
            ]);
        }

        $quizResultsModel->insert([
            'quiz_id' => $quizId,
            'murid_id' => $muridId,
            'score' => $score
        ]);

        // Update status quiz menjadi selesai
        $kelasSiswaModel = new KelasSiswaModel();
        $kelasSiswa = $kelasSiswaModel->where('murid_id', $muridId)
            ->where('kelas_id', $kelasId)
            ->first();

        $kelasSiswaModel->update($kelasSiswa['id'], ['status_quiz' => 'selesai']);

        return redirect()->to("/murid/aksesKelas/{$kelasId}")->with('success', 'Quiz berhasil diselesaikan! Skor Anda: ' . $score);
    }


    public function aksesQuiz($quizId)
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();
        $kelasSiswaModel = new KelasSiswaModel();

        $muridId = session()->get('user_id');
        $quiz = $quizModel->find($quizId);
        $kelasId = $quiz['kelas_id'];
        $level = $quiz['level'];

        // Validasi apakah materi level sebelumnya sudah diakses
        $materiModel = new MateriModel();
        $prevMateri = $materiModel->where('kelas_id', $kelasId)
            ->where('level', $level - 1)
            ->first();

        $kelasSiswa = $kelasSiswaModel->where('kelas_id', $kelasId)
            ->where('murid_id', $muridId)
            ->first();

        if ($prevMateri && $kelasSiswa['status_materi'] != 'selesai') {
            return redirect()->back()->with('error', 'Anda harus menyelesaikan materi level sebelumnya.');
        }

        // Ambil soal quiz
        $soals = $soalModel->where('quiz_id', $quizId)->findAll();

        return view('murid/akses_quiz', ['quiz' => $quiz, 'soals' => $soals, 'kelasId' => $kelasId]);
    }


    public function kelasMasuk()
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();

        $muridId = session()->get('user_id');  // Mendapatkan ID murid yang sedang login

        // Mendapatkan kelas yang sudah dimasuki oleh murid
        $kelasSiswa = $kelasSiswaModel->where('murid_id', $muridId)->findAll();

        // Mendapatkan data kelas
        $kelasList = [];
        foreach ($kelasSiswa as $kelas) {
            $kelasData = $kelasModel->find($kelas['kelas_id']);
            if ($kelasData) {
                $kelasData['materi'] = $materiModel->where('kelas_id', $kelasData['id'])->orderBy('level')->findAll();
                $kelasData['quiz'] = $quizModel->where('kelas_id', $kelasData['id'])->orderBy('level')->findAll();
                $kelasList[] = $kelasData;
            }
        }

        return view('murid/kelas_masuk', ['kelasList' => $kelasList]);
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
