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

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class MuridController extends Controller
{
    private $muridId;

    /**
     * Untuk validasi role sebelum akses halaman
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // jika belum login atau rolenya bukan murid
        if (!session()->has('role_id') || session()->get('role_id') != 3) {
            redirect()->to(site_url('/login'))->send();
            exit;
        }
    }

    public function __construct()
    {
        $this->muridId = session()->get('user_id');
    }

    /**
     * Untuk melihat dashboard murid
     */
    public function dashboard()
    {
        return view('murid/dashboard');
    }

    /**
     * Untuk melihat semua kelas
     */
    public function semuaKelas()
    {
        // Ambil semua kelas dari tabel kelas yang memiliki status 'aktif'
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->getAllKelasAktif(); // Filter hanya kelas dengan status aktif

        // Ambil status kelas untuk murid yang sedang login
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = $this->muridId;
        $statusKelas = $kelasSiswaModel->getAllKelasByMurid($muridId);

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

    /**
     * Untuk melihat kelas dalam proses
     */
    public function kelasDalamProses()
    {
        // Ambil kelas yang sedang dalam proses untuk murid yang sedang login
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = $this->muridId;

        // Ambil langsung data kelas yang statusnya 'proses'
        $kelasList = $kelasSiswaModel
            ->select('kelas.*, kelas_siswa.id AS kelas_siswa_id')
            ->join('kelas', 'kelas.id = kelas_siswa.kelas_id')
            ->where('kelas_siswa.murid_id', $muridId)
            ->where('kelas_siswa.status', 'proses')
            ->findAll();

        // Ambil materi dan quiz untuk masing-masing kelas
        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();
        $quizModel = new QuizModel();
        $quizResultModel = new QuizResultsModel();

        foreach ($kelasList as &$kelas) {
            $kelasId = $kelas['id'];

            // Ambil semua materi dan quiz
            $allMateri = $materiModel->whereKelas($kelasId)->findAll();
            $allQuiz = $quizModel->whereKelas($kelasId)->findAll();

            $totalMateri = count($allMateri);
            $totalQuiz = count($allQuiz);

            // Hitung materi yang diselesaikan oleh murid
            $selesaiMateri = $materiSiswaModel
                ->whereMurid($muridId)
                ->whereMateriIn(array_column($allMateri, 'id'))
                ->whereStatus('selesai')
                ->countAllResults();

            // Hitung quiz yang diselesaikan oleh murid
            $selesaiQuiz = $quizResultModel
                ->whereMurid($muridId)
                ->whereQuizIn(array_column($allQuiz, 'id'))
                ->countAllResults();

            // Hitung total progress
            $totalItem = $totalMateri + $totalQuiz;
            $totalItemSelesai = $selesaiMateri + $selesaiQuiz;
            $persen = $totalItem > 0 ? round(($totalItemSelesai / $totalItem) * 100) : 0;

            $kelas['materi'] = $allMateri;
            $kelas['quiz'] = $allQuiz;
            $kelas['progress'] = [
                'materi_selesai' => $selesaiMateri,
                'total_materi' => $totalMateri,
                'quiz_selesai' => $selesaiQuiz,
                'total_quiz' => $totalQuiz,
                'persen' => $persen
            ];
        }

        // Kirim data kelas, materi, dan quiz ke view
        return view('murid/kelas_dalam_proses', ['kelasList' => $kelasList]);
    }

    /**
     * Untuk melihat kelas selesai
     */
    public function kelasSelesai()
    {
        $kelasModel = new KelasModel();
        $kelasSiswaModel = new KelasSiswaModel();
        $muridId = $this->muridId;

        // Ambil semua kelas yang sudah selesai untuk murid
        $kelasSelesai = $kelasSiswaModel
            ->whereMurid($muridId)
            ->whereStatus('selesai')
            ->whereStatusMateri('selesai')
            ->whereStatusQuiz('selesai')
            ->findAll();

        $kelasList = [];

        foreach ($kelasSelesai as $kelasSiswa) {
            // Ambil data kelas dan materi serta quiz yang terkait
            $kelas = $kelasModel->find($kelasSiswa['kelas_id']);
            $materiModel = new MateriModel();
            $quizModel = new QuizModel();
            $quizResultsModel = new QuizResultsModel();

            $materi = $materiModel->whereKelas($kelasSiswa['kelas_id'])->findAll();
            $quiz = $quizModel->whereKelas($kelasSiswa['kelas_id'])->findAll();
            $quizWithScore = [];

            foreach ($quiz as $q) {
                $result = $quizResultsModel
                    ->whereQuiz($q['id'])
                    ->whereMurid($muridId)
                    ->first();

                $q['score'] = $result['score'] ?? null;
                $q['max_score'] = $result['max_score'] ?? null;

                $quizWithScore[] = $q;
            }

            // Menambahkan data kelas beserta materi dan quiz
            $kelasList[] = [
                'nama_kelas' => $kelas['nama_kelas'],
                'kelas_id' => $kelas['id'],
                'deskripsi' => $kelas['deskripsi'],
                'materi' => $materi,
                'quiz' => $quizWithScore
            ];
        }

        return view('murid/kelas_selesai', ['kelasList' => $kelasList]);
    }

    /**
     * Untuk melihat koleksi badge
     */
    public function koleksiBadge()
    {
        // Ambil semua badge yang telah didapatkan murid
        $badgeModel = new BadgeModel();
        $badge = $badgeModel->getBadgesByMurid($this->muridId);

        return view('murid/koleksi_badge', ['badges' => $badge]);
    }

    /**
     * Untuk memberikan badge kepada murid
     */
    public function addBadge($kelas_id, $type = 'class_completed')
    {
        $badgeModel = new BadgeModel();
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($kelas_id);

        $badgeData = [
            'murid_id' => $this->muridId,
            'badge_name' => "Kelas Selesai: " . $kelas['nama_kelas'],
            'badge_type' => $type,
            'date_earned' => date('Y-m-d H:i:s'),
        ];
        $badgeModel->addBadge($badgeData);
    }

    /**
     * Untuk melihat detail kelas
     */
    public function detailKelas($kelas_id)
    {
        // Load models
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();
        $kelasSiswaModel = new KelasSiswaModel();
        $quizResultsModel = new QuizResultsModel();

        // Dapatkan ID user dari session
        $userId = $this->muridId;

        // Validasi kelas
        $kelas = $kelasModel->find($kelas_id);
        if (!$kelas) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Kelas tidak ditemukan');
        }

        // Cek status siswa di kelas ini
        $kelasSiswa = $kelasSiswaModel
            ->whereMuridKelas($userId, $kelas_id)
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
        $materi = $materiModel->getAllByKelasByOrdered($kelas_id, 'level', 'asc');

        $quiz = $quizModel->whereKelas($kelas_id)
            ->orderBy('level', 'asc')
            ->findAll();

        // Validasi akses materi dan quiz berdasarkan level
        $canEnroll = false;
        $filteredMateri = [];
        $filteredQuiz = [];

        if (!empty($materi)) {
            $canEnroll = true;

            $materiSiswaModel = new MateriSiswaModel();
            foreach ($materi as $m) {
                if ($status['status'] == 'belum_dimulai') {
                    $m['can_access'] = false;
                    $m['is_completed'] = false;
                } elseif ($m['level'] <= $status['level_materi']) {
                    $m['can_access'] = true;

                    // cek materi yang terakhir udh selesai atau belum
                    $materiSiswa = $materiSiswaModel
                        ->whereMurid($userId)
                        ->whereMateri($m['id'])
                        ->orderBy('created_at', 'desc')
                        ->first();

                    $m['is_completed'] = ($materiSiswa && $materiSiswa['status'] === 'selesai');
                } else {
                    $m['can_access'] = false;
                    $m['is_completed'] = false;
                }

                $filteredMateri[] = $m;
            }
        }

        if (!empty($quiz)) {
            $canEnroll = true;

            foreach ($quiz as $q) {
                if ($status['status'] == 'belum_dimulai') {
                    $q['can_access'] = false;
                    $q['is_completed'] = false;
                    $q['score'] = null;
                    $q['max_score'] = 0;
                } else {
                    // Cek apakah quiz ini sudah diselesaikan
                    $quizResult = $quizResultsModel
                        ->whereMurid($userId)
                        ->whereQuiz($q['id'])
                        ->first();

                    $q['is_completed'] = $quizResult !== null;
                    $q['score'] = $quizResult['score'] ?? null;
                    $q['max_score'] = $quizResult['max_score'] ?? 0;

                    // Validasi pastikan semua materi dengan level <= quiz sudah selesai
                    $requiredMateri = $materiModel
                        ->whereKelas($kelas['id'])
                        ->whereLevel($q['level'], '<=')
                        ->findAll();

                    $semuaMateriSelesai = true;
                    foreach ($requiredMateri as $materi) {
                        $materiSiswa = $materiSiswaModel
                            ->whereMurid($userId)
                            ->whereMateri($materi['id'])
                            ->where('status', 'selesai')
                            ->first();

                        if (!$materiSiswa) {
                            $semuaMateriSelesai = false;
                            break;
                        }
                    }

                    // Validasi quiz sebelumnya apakah sudah selesai
                    $quizSebelumnya = $quizResultsModel
                        ->whereMurid($userId)
                        ->join('quiz', 'quiz.id = quiz_results.quiz_id')
                        ->where('quiz.kelas_id', $kelas['id'])
                        ->where('quiz.level <=', $q['level'] - 1)
                        ->first();

                    $quizSebelumnyaSelesai = ($q['level'] == 1) || $quizSebelumnya !== null;

                    $q['can_access'] = $semuaMateriSelesai && $quizSebelumnyaSelesai;
                }

                $filteredQuiz[] = $q;
            }
        }

        // Mendapatkan URL untuk button lanjutkan belajar
        $lanjutkanBelajarUrl = '#';

        if ($status['status'] == 'proses') {
            $nextMaterialIdToAccess = null;

            foreach ($filteredMateri as $m) {
                if ($m['can_access'] && !$m['is_completed']) {
                    $nextMaterialIdToAccess = $m['id'];
                    break;
                }
            }

            if ($nextMaterialIdToAccess !== null) {
                $lanjutkanBelajarUrl = site_url("murid/aksesMateri/{$kelas['id']}/{$nextMaterialIdToAccess}");
            }
        }

        // Data untuk view
        $data = [
            'kelas' => $kelas,
            'canEnroll' => $canEnroll,
            'materi' => $filteredMateri,
            'quiz' => $filteredQuiz,
            'status' => $status,
            'lanjutkanBelajarUrl' => $lanjutkanBelajarUrl
        ];

        return view('murid/detail_kelas', $data);
    }

    /**
     * Untuk enroll kelas
     */
    public function masukKelas($id)
    {
        $kelasSiswaModel = new KelasSiswaModel();
        $userId = $this->muridId;

        // Cek apakah sudah terdaftar di kelas
        $existing = $kelasSiswaModel
            ->whereMuridKelas($userId, $id)
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

        return redirect()->to(site_url("murid/detailKelas/$id"));
    }

    /**
     * Untuk review kelas setelah selesai
     */
    public function reviewKelas($kelas_id)
    {
        // Load models
        $kelasModel = new KelasModel();
        $kelasSiswaModel = new KelasSiswaModel();
        $materiSiswaModel = new MateriSiswaModel();
        $quizResultModel = new QuizResultsModel();

        // Dapatkan ID user dari session
        $userId = $this->muridId;

        // validasi kelas
        $kelas = $kelasModel->find($kelas_id);
        if (!$kelas) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Kelas tidak ditemukan');
        }

        // cek status siswa di kelas ini
        $kelasSiswa = $kelasSiswaModel
            ->whereMuridKelas($userId, $kelas_id)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->to(site_url('murid/semuaKelas'))->with('error', 'Anda tidak terdaftar di kelas ini');
        }

        if ($kelasSiswa['status'] !== 'selesai') {
            return redirect()->to(site_url("murid/detailKelas/$kelas_id"))->with('error', 'Kelas belum diselesaikan');
        }

        // ambil data materi dari foreign key materi siswa
        $materi = $materiSiswaModel
            ->select('materi_siswa.*, materi.point')
            ->join('materi', 'materi.id = materi_siswa.materi_id')
            ->where('materi_siswa.murid_id', $userId)
            ->where('materi.kelas_id', $kelas_id)
            ->findAll();

        // hitung total poin dan materi dari materi
        $totalMateriScore = array_sum(array_column($materi, 'point'));
        $jumlahMateri = count($materi);

        // ambil hasil kuis
        $quizResult = $quizResultModel->whereMurid($userId)->where('kelas_id', $kelas_id)->findAll();

        // hitung total quiz
        $jumlahQuiz = count($quizResult);

        // mendapatkan total score dan max_score
        $totalQuizScore = 0;
        $totalMaxScore = 0;
        foreach ($quizResult as $quiz) {
            $totalQuizScore += $quiz['score'];
            $totalMaxScore += $quiz['max_score'];
        }

        $data = [
            'kelas' => $kelas,
            'rangkuman' => [
                'tanggal_ambil' => $kelasSiswa['created_at'],
                'total_materi_score' => $totalMateriScore,
                'total_quiz_score' => $totalQuizScore,
                'total_max_quiz_score' => $totalMaxScore,
                'jumlah_materi' => $jumlahMateri,
                'jumlah_quiz' => $jumlahQuiz,
                'tanggal_selesai' => $kelasSiswa['updated_at'],
            ],
        ];

        return view('murid/review_kelas', $data);
    }

    /**
     * Untuk akses materi
     */
    public function aksesMateri($kelasId, $materiId)
    {
        $muridId = $this->muridId;

        $kelasSiswaModel = new KelasSiswaModel();
        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();

        $materi = $materiModel->find($materiId);
        if (!$materi) {
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Materi tidak ditemukan.');
        }

        $kelasSiswa = $kelasSiswaModel
            ->whereMuridKelas($muridId, $kelasId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Anda tidak terdaftar di kelas ini.');
        }

        if ($materi['level'] > 1) {
            $prevMateri = $materiModel
                ->whereKelas($kelasId)
                ->whereLevel($materi['level'] - 1)
                ->first();

            if ($prevMateri) {
                $prevProgress = $materiSiswaModel
                    ->whereMurid($muridId)
                    ->whereMateri($prevMateri['id'])
                    ->whereStatus('selesai')
                    ->first();

                if (!$prevProgress) {
                    return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Selesaikan materi sebelumnya terlebih dahulu.');
                }
            }
        }

        // cek apakah sudah ada data di materi_siswa
        $existing = $materiSiswaModel
            ->whereMurid($muridId)
            ->whereMateri($materiId)
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

    /**
     * Untuk menyelesaikan materi
     */
    public function selesaikanMateri($kelasId, $materiId)
    {
        $muridId = $this->muridId;

        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();

        // cek materinya ada atau tidak
        $materi = $materiModel->find($materiId);
        if (!$materi) {
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Materi tidak ditemukan.');
        }

        // cek apakah user terdaftar di kelas
        $kelasSiswaModel = new KelasSiswaModel();
        $kelasSiswa = $kelasSiswaModel
            ->whereMuridKelas($muridId, $kelasId)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Anda tidak terdaftar dalam kelas ini.');
        }

        // update status materi ini menjadi selesai
        $materiSiswa = $materiSiswaModel
            ->whereMurid($muridId)
            ->whereMateri($materiId)
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
            ->whereKelas($kelasId)
            ->whereLevel($nextLevel)
            ->first();

        if ($nextMateri) {
            // cek apakah siswa sudah punya data untuk next materi
            $existingNext = $materiSiswaModel
                ->whereMurid($muridId)
                ->whereMateri($nextMateri['id'])
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
                ->whereMuridKelas($muridId, $kelasId)
                ->first();

            if ($kelasSiswa) {
                $updateData = [
                    'status_materi' => 'selesai',
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Jika status_quiz sudah selesai juga → update status kelas jadi selesai
                if ($kelasSiswa['status_quiz'] === 'selesai') {
                    $updateData['status'] = 'selesai';

                    $this->addBadge($kelasId);
                }

                $kelasSiswaModel
                    ->update($kelasSiswa['id'], $updateData);
            }
        }


        return redirect()->to("/murid/detailKelas/{$kelasId}")->with('success', 'Materi berhasil diselesaikan!');
    }

    /**
     * Untuk akses quiz
     */
    public function aksesQuiz($kelasId, $quizId): \CodeIgniter\HTTP\RedirectResponse|string
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();
        $kelasModel = new KelasModel();

        $muridId = $this->muridId;

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

        // Jika level > 1, pastikan kuis level sebelumnya sudah selesai
        $quizResultModel = new QuizResultsModel();
        if ((int)$quiz['level'] > 1) {
            $prevLevel = $quiz['level'] - 1;

            $prevQuiz = $quizModel
                ->whereKelas($kelasId)
                ->whereLevel($prevLevel)
                ->first();

            if ($prevQuiz) {
                $prevResult = $quizResultModel
                    ->whereMurid($muridId)
                    ->whereQuiz($prevQuiz['id'])
                    ->first();

                if (!$prevResult) {
                    return redirect()->to(site_url("murid/detailKelas/$kelasId"))
                        ->with('error', 'Selesaikan kuis level sebelumnya terlebih dahulu.');
                }
            } else {
                // Kalau kuis level sebelumnya tidak ditemukan di database (bisa aja level quiznya skip)
                return redirect()->to(site_url("murid/detailKelas/$kelasId"))
                    ->with('error', 'Kuis level sebelumnya belum tersedia.');
            }
        }

        // cek quiz sudah selesai atau belum
        $quizResult = $quizResultModel
            ->whereQuiz($quizId)
            ->whereMurid($muridId)
            ->first();

        if ($quizResult) {
            return redirect()->to(site_url("murid/detailKelas/$kelasId"))
                ->with('error', 'Anda sudah menyelesaikan quiz ini.');
        }

        // Validasi apakah materi level sebelumnya sudah diakses
        $materiSiswaModel = new MateriSiswaModel();
        $materiModel = new MateriModel();

        $requiredMateri = $materiModel
            ->whereKelas($kelas['id'])
            ->whereLevel($quiz['level'], '<=') // semua materi sebelum quiz ini
            ->orderBy('level', 'asc')
            ->findAll();

        foreach ($requiredMateri as $materi) {
            $materiSiswa = $materiSiswaModel
                ->whereMurid($muridId)
                ->whereMateri($materi['id'])
                ->whereStatus('selesai')
                ->first();

            if (!$materiSiswa) {
                return redirect()->to(site_url("murid/detailKelas/$kelasId"))->with('error', 'Anda harus menyelesaikan semua materi sebelumnya untuk mengakses quiz ini.');
            }
        }

        // Ambil soal quiz
        $soals = $soalModel->whereQuiz($quizId)->findAll();

        return view('murid/akses_quiz', ['quiz' => $quiz, 'soals' => $soals, 'kelasId' => $kelas['id']]);
    }

    /**
     * Untuk submit quiz
     */
    public function submitQuiz($kelasId, $quizId)
    {
        $kelasModel = new KelasModel();
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();
        $quizAnswersModel = new QuizAnswersModel();
        $quizResultsModel = new QuizResultsModel();
        $kelasSiswaModel = new KelasSiswaModel();

        $userId = $this->muridId;

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
        $jawaban = $this->request->getPost('jawaban_pilih') ?? [];
        $soalQuiz = $soalModel->whereQuiz($quizId)->findAll();
        $score = 0;
        $maxScore = 0;

        foreach ($soalQuiz as $soal) {
            $maxScore += $soal['poin'];

            $jawabanPilih = null;
            $isCorrect = false;

            if (isset($jawaban[$soal['id']])) {
                $jawabanPilih = $jawaban[$soal['id']];
                $isCorrect = $jawabanPilih == $soal['jawaban_benar'];
                if ($isCorrect) {
                    $score += $soal['poin'];
                }
            }

            // Simpan jawaban murid ke tabel quiz_answers
            $quizAnswersModel->insert([
                'quiz_id'        => $quizId,
                'murid_id'       => $userId,
                'kelas_id'       => $kelasId,
                'soal_id'        => $soal['id'],
                'jawaban_pilih'  => $jawabanPilih,
                'is_correct'     => $isCorrect,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
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
        $kelasSiswa = $kelasSiswaModel
            ->whereMuridKelas($userId, $kelasId)
            ->first();

        if ($kelasSiswa) {
            // Cek quiz lanjutan
            $nextQuiz = $quizModel
                ->whereKelas($kelasId)
                ->whereLevel($quiz['level'], '>')
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
                    $this->addBadge($kelasId);
                }

                $kelasSiswaModel->update($kelasSiswa['id'], $updateData);
            }
        }

        return redirect()->to("/murid/detailKelas/$kelasId")->with('success', "Quiz berhasil diselesaikan! Skor: $score");
    }

    // fungsi helper
    /**
     * Untuk menentukan level dan status materi untuk user dalam kelas
     */
    private function determineStatusAndLevelMateri($muridId, $kelasId)
    {
        $materiModel = new MateriModel();
        $materiSiswaModel = new MateriSiswaModel();

        $materiList = $materiModel
            ->whereKelas($kelasId)
            ->orderBy('level', 'asc')
            ->findAll();

        if (empty($materiList)) {
            // Jika materi di kelas ini kosong, maka level materi adalah 1 dan status materi adalah belum dibaca
            return [
                'level_materi' => 1,
                'status_materi' => 'belum_diakses'
            ];
        }

        foreach ($materiList as $materi) {
            $materiSiswa = $materiSiswaModel
                ->whereMurid($muridId)
                ->whereMateri($materi['id'])
                ->first();

            if (!$materiSiswa) {
                // Jika materi belum dibaca, maka level materi adalah level materi ini dan status materi adalah belum dibaca
                return [
                    'level_materi' => $materi['level'],
                    'status_materi' => 'belum_diakses'
                ];
            }

            if ($materiSiswa['status'] !== 'selesai') {
                // Jika materi sudah dibuka tapi belum selesai, maka level materi adalah level materi ini dan status materi adalah status materi_siswa
                return [
                    'level_materi' => $materi['level'],
                    'status_materi' => $materiSiswa['status']
                ];
            }
        }

        // Jika semua materi sudah ada di materi_siswa dengan semua status selesai, maka level materi adalah level terakhir dan status materi adalah selesai
        $lastLevel = end($materiList)['level'];

        return [
            'level_materi' => $lastLevel,
            'status_materi' => 'selesai'
        ];
    }

    /**
     * Untuk menentukan level quiz yang sedang dikerjakan user
     */
    private function determineCurrentLevelQuiz($userId, $kelasId)
    {
        $quizModel = new QuizModel();
        $quizResultsModel = new QuizResultsModel();

        // Dapatkan semua quiz di kelas ini diurutkan berdasarkan level
        $allQuizzes = $quizModel->whereKelas($kelasId)
            ->orderBy('level', 'asc')
            ->findAll();

        $currentLevel = 1;

        foreach ($allQuizzes as $quiz) {
            // Cek apakah user sudah menyelesaikan quiz di level ini
            $result = $quizResultsModel
                ->whereMurid($userId)
                ->whereQuiz($quiz['id'])
                ->first();

            if ($result) {
                $currentLevel = $quiz['level'] + 1;
            } else {
                break;
            }
        }

        return $currentLevel;
    }
}
