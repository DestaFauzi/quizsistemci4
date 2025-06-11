<?php

namespace App\Controllers;

use App\Models\MateriSiswaModel;
use CodeIgniter\Controller;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\QuizModel;
use App\Models\SoalModel;
use App\Models\KelasSiswaModel;

class GuruController extends Controller
{
    protected $kelasModel;
    protected $materiModel;
    protected $quizModel;
    protected $soalModel;
    protected $kelasSiswaModel;
    protected $pager;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->materiModel = new MateriModel();
        $this->quizModel = new QuizModel();
        $this->soalModel = new SoalModel();
        $this->kelasSiswaModel = new KelasSiswaModel();
        $this->pager = \Config\Services::pager();
    }

    public function dashboard()
    {
        // Memastikan hanya guru yang dapat mengakses dashboard
        if (session()->get('role_id') != 2) {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('guru/dashboard');
    }

    /* Kelas Management */

    public function createClass()
    {
        return view('guru/create_class');
    }

    public function saveClass()
    {
        // Validasi input
        $rules = [
            'nama_kelas'   => 'required|min_length[3]|max_length[100]',
            'deskripsi'    => 'permit_empty|max_length[500]',
            'status'       => 'required|in_list[aktif,non_aktif]',
            'jumlah_level' => 'required|integer|greater_than[0]',
        ];

        // Memvalidasi input data
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyiapkan data untuk disimpan ke database
        $data = [
            'nama_kelas'   => $this->request->getPost('nama_kelas'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'status'       => $this->request->getPost('status'),
            'jumlah_level' => $this->request->getPost('jumlah_level'),
            'guru_id'      => session()->get('user_id'),
        ];

        // Menyimpan data kelas dan memberikan feedback
        if ($this->kelasModel->save($data)) {
            return redirect()->to('/guru/dashboard')->with('success', 'Kelas berhasil dibuat!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat kelas. Silakan coba lagi.');
        }
    }

    public function viewClasses()
    {
        // Mengambil semua kelas yang dibuat oleh guru yang sedang login
        $kelas = $this->kelasModel->where('guru_id', session()->get('user_id'))->findAll();
        return view('guru/view_classes', ['kelas' => $kelas]);
    }

    public function detailKelas($id)
    {
        // Mengambil detail kelas, materi, quiz, dan status murid terkait
        $kelas = $this->kelasModel->find($id);

        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }

        $materi  = $this->materiModel->where('kelas_id', $id)->findAll();
        $quiz    = $this->quizModel->where('kelas_id', $id)->findAll();
        $muridId = session()->get('user_id');
        $status  = $this->kelasSiswaModel->where('kelas_id', $id)->where('murid_id', $muridId)->first();

        return view('guru/detail_kelas', [
            'kelas'  => $kelas,
            'materi' => $materi,
            'quiz'   => $quiz,
            'status' => $status
        ]);
    }

    public function editClass($kelasId)
    {
        $kelas = $this->kelasModel->find($kelasId);

        // Jika kelas tidak ditemukan, redirect dengan pesan error
        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }

        // Tampilkan view edit_class dan kirim data kelas
        return view('guru/edit_kelas', ['kelas' => $kelas]);
    }

    public function updateClass($kelasId)
    {
        // Temukan kelas yang akan diperbarui untuk memastikan ada
        $kelas = $this->kelasModel->find($kelasId);
        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }

        // Definisikan aturan validasi
        $rules = [
            'nama_kelas'   => 'required|min_length[3]|max_length[255]',
            'deskripsi'    => 'required|min_length[10]|max_length[500]',
            'jumlah_level' => 'required|integer|greater_than[0]',
            'status'       => 'required|in_list[aktif,non_aktif]',
        ];

        // Jalankan validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke halaman edit dengan input lama dan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari formulir
        $data = [
            'id'           => $kelasId,
            'nama_kelas'   => $this->request->getPost('nama_kelas'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'jumlah_level' => (int) $this->request->getPost('jumlah_level'),
            'status'       => $this->request->getPost('status'),
        ];

        // Simpan data ke database
        if ($this->kelasModel->save($data)) {
            return redirect()->to('/guru/detailKelas/' . $kelasId)->with('success', 'Kelas berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui kelas. Silakan coba lagi.');
        }
    }

    /* Materi Management */
    public function addMateri($kelas_id)
    {
        // Menampilkan form tambah materi untuk kelas tertentu
        $kelas = $this->kelasModel->find($kelas_id);

        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }

        return view('guru/add_materi', ['kelas' => $kelas]);
    }
    public function uploadMateri()
    {
        $kelasId = $this->request->getPost('kelas_id');

        // Memverifikasi kelas dan menentukan level maksimal
        $kelas = $this->kelasModel->find($kelasId);

        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }

        $maxLevel = $kelas['jumlah_level'];

        // Aturan validasi untuk upload materi
        $rules = [
            'judul'       => 'required|min_length[3]|max_length[255]',
            'level'       => "required|integer|greater_than[0]|less_than_equal_to[{$maxLevel}]",
            'file_materi' => [
                'uploaded[file_materi]',
                'mime_in[file_materi,application/pdf]',
                'max_size[file_materi,5000]',
            ],
        ];

        // Pesan kustom untuk validasi level materi
        $messages = [
            'level' => [
                'less_than_equal_to' => 'Level materi tidak boleh melebihi jumlah level kelas ({param}).',
            ],
        ];

        // Memvalidasi input dan file
        if (!$this->validate($rules, $messages)) {
            return redirect()->to('/guru/addMateri/' . $kelasId)->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_materi');

        // Memproses upload file dan menyimpan data materi
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName    = $file->getName();
            $directory = ROOTPATH . 'public/uploads/materi/kelas_' . $kelasId . '/';

            // Membuat direktori jika belum ada
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $file->move($directory, $fileName);

            $materiData = [
                'kelas_id'  => $kelasId,
                'judul'     => $this->request->getPost('judul'),
                'file_name' => $fileName,
                'file_path' => 'uploads/materi/kelas_' . $kelasId . '/' . $fileName,
                'level'     => (int) $this->request->getPost('level'),
                'point'     => (int) $this->request->getPost('point'),
            ];

            // Menyimpan data materi ke database
            if ($this->materiModel->save($materiData)) {
                $kelasSiswa = $this->kelasSiswaModel;

                $existing = $kelasSiswa
                    ->whereKelas($kelasId)
                    ->whereStatus('selesai')
                    ->whereStatusMateri('selesai')
                    ->findAll();

                if (!empty($existing)) {
                    $kelasSiswa
                        ->whereKelas($kelasId)
                        ->whereStatus('selesai')
                        ->whereStatusMateri('selesai')
                        ->set([
                            'status' => 'proses',
                            'status_materi' => 'belum_diakses'
                        ])
                        ->update();
                }

                return redirect()->to('/guru/detailKelas/' . $kelasId)->with('success', 'Materi berhasil diunggah!');
            } else {
                // Menghapus file jika gagal menyimpan ke database
                unlink($directory . $fileName);
                return redirect()->to('/guru/addMateri/' . $kelasId)->withInput()->with('error', 'Gagal menyimpan data materi ke database. Silakan coba lagi.');
            }
        }

        return redirect()->to('/guru/addMateri/' . $kelasId)->with('error', 'Gagal mengunggah file. Pastikan file valid dan ukurannya tidak melebihi batas.');
    }

    public function editMateri($materi_id)
    {
        // Menampilkan form edit materi
        $materi = $this->materiModel->find($materi_id);

        if (!$materi) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Materi tidak ditemukan.');
        }

        $kelas = $this->kelasModel->find($materi['kelas_id']);

        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas terkait materi tidak ditemukan.');
        }

        return view('guru/edit_materi', [
            'materi' => $materi,
            'kelas'  => $kelas
        ]);
    }

    public function updateMateri($materi_id)
    {
        // Memperbarui data materi dan mengelola file yang diunggah
        $materi = $this->materiModel->find($materi_id);

        if (!$materi) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Materi tidak ditemukan.');
        }

        $kelasId     = $this->request->getPost('kelas_id');
        $oldFilePath = $this->request->getPost('old_file_path');

        // Ambil data kelas untuk validasi jumlah_level
        $kelas = $this->kelasModel->find($kelasId);
        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas terkait materi tidak ditemukan.');
        }
        $maxLevel = $kelas['jumlah_level'];

        // Aturan validasi untuk update materi
        $rules = [
            'judul'       => 'required|min_length[3]|max_length[255]',
            'level'       => "required|integer|greater_than[0]|less_than_equal_to[{$maxLevel}]",
            'point'        => 'required|integer|greater_than_equal_to[0]',
            'file_materi' => [
                'mime_in[file_materi,application/pdf]',
                'max_size[file_materi,5000]',
            ],
        ];

        // Pesan kesalahan kustom untuk validasi
        $messages = [
            'level' => [
                'less_than_equal_to' => 'Level materi tidak boleh melebihi jumlah level kelas ({param}).',
            ],
            'file_materi' => [
                'uploaded' => 'Anda harus mengunggah file materi.',
                'mime_in'  => 'Format file tidak didukung. Harap unggah PDF, Word, atau gambar.',
                'max_size' => 'Ukuran file melebihi batas (5MB).',
            ],
        ];

        // Memvalidasi input
        if (!$this->validate($rules, $messages)) {
            // Jika validasi gagal, kembalikan ke halaman edit materi dengan input dan error
            return redirect()->to('/guru/editMateri/' . $materi_id)->withInput()->with('errors', $this->validator->getErrors());
        }

        $file     = $this->request->getFile('file_materi');
        $fileName = $materi['file_name'];
        $filePath = $materi['file_path'];

        // Cek apakah ada file baru diunggah dan proses penggantian file
        $isFileNew = false;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $directory = ROOTPATH . 'public/uploads/materi/kelas_' . $kelasId . '/';

            // Hapus file lama jika ada
            if ($oldFilePath && file_exists(ROOTPATH . 'public/' . $oldFilePath)) {
                unlink(ROOTPATH . 'public/' . $oldFilePath);
            }

            // Pindahkan file baru
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            $fileName = $file->getName(); // Dapatkan nama file baru
            $file->move($directory, $fileName);
            $filePath = 'uploads/materi/kelas_' . $kelasId . '/' . $fileName; // Path file baru

            $isFileNew = true;
        }


        $materiData = [
            'id'            => $materi_id,
            'kelas_id'      => $kelasId,
            'judul'         => $this->request->getPost('judul'),
            'file_name'     => $fileName,
            'file_path'     => $filePath,
            'level'         => (int) $this->request->getPost('level'),
            'point'         => (int) $this->request->getPost('point')
        ];

        // Memperbarui data materi di database
        if ($this->materiModel->save($materiData)) {
            if ($isFileNew) {
                $kelasSiswa = $this->kelasSiswaModel;

                $existing = $kelasSiswa
                    ->whereKelas($kelasId)
                    ->whereStatus('selesai')
                    ->whereStatusMateri('selesai')
                    ->findAll();

                if (!empty($existing)) {
                    $kelasSiswa
                        ->whereKelas($kelasId)
                        ->whereStatus('selesai')
                        ->whereStatusMateri('selesai')
                        ->set([
                            'status' => 'proses',
                            'status_materi' => 'belum_diakses'
                        ])
                        ->update();
                }

                $materiSiswa = new MateriSiswaModel();
                $existing = $materiSiswa
                    ->whereMateri($materi_id)
                    ->whereStatus('selesai')
                    ->findAll();

                if (!empty($existing)) {
                    $materiSiswa
                        ->whereMateri($materi_id)
                        ->whereStatus('selesai')
                        ->set([
                            'status' => 'belum_diakses'
                        ])
                        ->update();
                }
            }

            return redirect()->to('/guru/detailKelas/' . $kelasId)->with('success', 'Materi berhasil diperbarui!');
        } else {
            // Jika gagal menyimpan ke DB, dan ada file baru diunggah, hapus file baru tersebut
            if (isset($directory) && isset($fileName) && file_exists($directory . $fileName)) {
                unlink($directory . $fileName);
            }
            return redirect()->to('/guru/editMateri/' . $materi_id)->withInput()->with('error', 'Gagal memperbarui materi. Silakan coba lagi.');
        }
    }

    public function hapusMateri($id)
    {
        // Menghapus materi dan file terkait
        $materi = $this->materiModel->find($id);

        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan!');
        }

        // Hapus file fisik jika ada
        if (file_exists(ROOTPATH . 'public/' . $materi['file_path'])) {
            unlink(ROOTPATH . 'public/' . $materi['file_path']);
        }

        // Menghapus data materi dari database
        if ($this->materiModel->delete($id)) {
            return redirect()->to('/guru/detailKelas/' . $materi['kelas_id'])->with('success', 'Materi berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus materi. Silakan coba lagi.');
        }
    }

    /* Quiz Management */
    public function addQuiz($kelas_id)
    {
        // Menampilkan form tambah quiz untuk kelas tertentu
        $kelas = $this->kelasModel->find($kelas_id);
        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }
        return view('guru/add_quiz', ['kelas' => $kelas]);
    }

    public function saveQuiz()
    {
        // Aturan validasi untuk data quiz
        $rules = [
            'kelas_id'    => 'required|integer',
            'judul_quiz'  => 'required|min_length[3]|max_length[255]',
            'jumlah_soal' => 'required|integer|greater_than[0]',
            'level'       => 'required|integer|greater_than[0]',
            'waktu'       => 'required|integer|greater_than[0]',
        ];

        // Memvalidasi input data
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $quizData = [
            'kelas_id'    => $this->request->getPost('kelas_id'),
            'judul_quiz'  => $this->request->getPost('judul_quiz'),
            'jumlah_soal' => $this->request->getPost('jumlah_soal'),
            'level'       => $this->request->getPost('level'),
            'waktu'       => $this->request->getPost('waktu')
        ];

        // Memeriksa apakah quiz dengan level yang sama sudah ada di kelas ini
        $existingQuiz = $this->quizModel->where('kelas_id', $quizData['kelas_id'])
            ->where('level', $quizData['level'])
            ->first();

        if ($existingQuiz) {
            return redirect()->to('/guru/addQuiz/' . $quizData['kelas_id'])
                ->withInput()
                ->with('error', 'Quiz dengan level ' . $quizData['level'] . ' sudah ada di kelas ini!');
        }

        // Menyimpan data quiz dan memberikan feedback
        if ($this->quizModel->save($quizData)) {
            $kelasSiswa = $this->kelasSiswaModel;
            $existing = $kelasSiswa
                ->whereKelas($quizData['kelas_id'])
                ->whereStatus('selesai')
                ->whereStatusQuiz('selesai')
                ->findAll();

            if ($existing) {
                $kelasSiswa
                    ->whereKelas($quizData['kelas_id'])
                    ->whereStatus('selesai')
                    ->whereStatusQuiz('selesai')
                    ->set([
                        'status' => 'proses',
                        'status_quiz' => 'belum_dikerjakan'
                    ])
                    ->update();
            }

            $quiz_id = $this->quizModel->getInsertID();
            return redirect()->to('/guru/addSoal/' . $quiz_id)->with('success', 'Quiz berhasil ditambahkan! Sekarang tambahkan soal untuk quiz ini.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat quiz. Silakan coba lagi.');
        }
    }

    public function viewQuiz($quiz_id)
    {
        // Menampilkan detail quiz dan soal-soalnya
        $quiz = $this->quizModel->find($quiz_id);

        if (!$quiz) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Quiz tidak ditemukan.');
        }

        $soal = $this->soalModel->where('quiz_id', $quiz_id)->findAll();

        return view('guru/view_quiz', [
            'quiz' => $quiz,
            'soal' => $soal
        ]);
    }

    public function hapusQuiz($id)
    {
        // Menghapus quiz dan semua soal terkait
        $quiz = $this->quizModel->find($id);

        if (!$quiz) {
            return redirect()->back()->with('error', 'Quiz tidak ditemukan!');
        }

        // Hapus semua soal yang terkait dengan kuis ini
        $this->soalModel->where('quiz_id', $id)->delete();

        // Hapus kuis itu sendiri
        if ($this->quizModel->delete($id)) {
            return redirect()->to('/guru/detailKelas/' . $quiz['kelas_id'])->with('success', 'Quiz berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus quiz. Silakan coba lagi.');
        }
    }

    /* Soal Management */
    public function addSoal($quiz_id)
    {
        // Menampilkan form tambah soal untuk quiz tertentu
        $quiz = $this->quizModel->find($quiz_id);

        if (!$quiz) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Quiz tidak ditemukan.');
        }

        return view('guru/add_soal', [
            'quiz_id'     => $quiz_id,
            'jumlah_soal' => $quiz['jumlah_soal']
        ]);
    }

    public function saveSoal()
    {
        $quiz_id     = $this->request->getPost('quiz_id');
        $jumlah_soal = (int)$this->request->getPost('jumlah_soal');

        if (!$quiz_id || !$jumlah_soal) {
            return redirect()->to(site_url('/guru/addSoal/' . $quiz_id))->with('error', 'Data tidak lengkap.');
        }

        // Membuat aturan validasi dinamis berdasarkan jumlah soal
        $rules = [];
        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $rules["soal_$i"]           = 'required|min_length[3]';
            $rules["jawaban_a_$i"]      = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_b_$i"]      = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_c_$i"]      = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_d_$i"]      = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_benar_$i"]  = 'required|in_list[a,b,c,d]';
            $rules["poin_$i"]           = 'required|integer|greater_than[0]';
        }

        // Memvalidasi semua input soal
        if (!$this->validate($rules)) {
            return redirect()->to(site_url('/guru/addSoal/' . $quiz_id))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyimpan setiap soal ke database
        $allSoalSaved = true;
        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $data = [
                'quiz_id'       => $quiz_id,
                'soal'          => $this->request->getPost("soal_$i"),
                'jawaban_a'     => $this->request->getPost("jawaban_a_$i"),
                'jawaban_b'     => $this->request->getPost("jawaban_b_$i"),
                'jawaban_c'     => $this->request->getPost("jawaban_c_$i"),
                'jawaban_d'     => $this->request->getPost("jawaban_d_$i"),
                'jawaban_benar' => $this->request->getPost("jawaban_benar_$i"),
                'poin'          => (int)$this->request->getPost("poin_$i"),
            ];

            if (!$this->soalModel->save($data)) {
                $allSoalSaved = false;
                break;
            }
        }

        // Memberikan feedback berdasarkan hasil penyimpanan soal
        if ($allSoalSaved) {
            return redirect()->to("/guru/viewQuiz/$quiz_id")->with('success', 'Semua soal berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Beberapa soal gagal disimpan. Silakan periksa input Anda.');
        }
    }

    public function editSoal($quiz_id)
    {
        // Menampilkan form edit soal untuk quiz tertentu
        $quiz = $this->quizModel->find($quiz_id);
        if (!$quiz) {
            return redirect()->back()->with('error', 'Quiz tidak ditemukan.');
        }

        $soalList = $this->soalModel->where('quiz_id', $quiz_id)->findAll();

        return view('guru/edit_soal', [
            'soalList'      => $soalList,
            'quiz_id'       => $quiz_id,
            'jumlah_soal' => $quiz['jumlah_soal']
        ]);
    }

    public function updateSoal()
    {
        $quiz_id  = $this->request->getPost('quiz_id');
        $soal_ids = $this->request->getPost('soal_id'); // Array dari ID soal

        if (empty($soal_ids)) {
            return redirect()->to(site_url('/guru/editSoal/' . $quiz_id))->with('error', 'Tidak ada soal yang dipilih untuk diperbarui.');
        }

        // Ambil semua data input sebagai array untuk memudahkan akses
        $inputSoal         = $this->request->getPost('soal');
        $inputJawabanA     = $this->request->getPost('jawaban_a');
        $inputJawabanB     = $this->request->getPost('jawaban_b');
        $inputJawabanC     = $this->request->getPost('jawaban_c');
        $inputJawabanD     = $this->request->getPost('jawaban_d');
        $inputJawabanBenar = $this->request->getPost('jawaban_benar');
        $inputPoin         = $this->request->getPost('poin');

        // Buat aturan validasi untuk setiap elemen array
        $rules = [];
        foreach ($soal_ids as $index => $soalId) {
            $rules["soal.$index"]          = 'required|min_length[3]|max_length[500]';
            $rules["jawaban_a.$index"]     = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_b.$index"]     = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_c.$index"]     = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_d.$index"]     = 'required|min_length[1]|max_length[500]';
            $rules["jawaban_benar.$index"] = 'required|in_list[a,b,c,d]';
            $rules["poin.$index"]          = 'required|integer|greater_than[0]';
        }

        // Memvalidasi semua input soal
        if (!$this->validate($rules)) {
            return redirect()->to(site_url('/guru/editSoal/' . $quiz_id))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Memperbarui setiap soal di database
        $allSoalUpdated = true;
        foreach ($soal_ids as $index => $soalId) {
            $data = [
                'id'            => $soalId,
                'quiz_id'       => $quiz_id,
                'soal'          => $inputSoal[$index],
                'jawaban_a'     => $inputJawabanA[$index],
                'jawaban_b'     => $inputJawabanB[$index],
                'jawaban_c'     => $inputJawabanC[$index],
                'jawaban_d'     => $inputJawabanD[$index],
                'jawaban_benar' => $inputJawabanBenar[$index],
                'poin'          => (int)$inputPoin[$index],
            ];

            if (!$this->soalModel->save($data)) {
                $allSoalUpdated = false;
                error_log('Gagal menyimpan soal ID: ' . $soalId);
                break;
            }
        }

        // Memberikan feedback berdasarkan hasil update soal
        if ($allSoalUpdated) {
            return redirect()->to("/guru/viewQuiz/$quiz_id")->with('success', 'Semua soal berhasil diperbarui.');
        } else {
            return redirect()->to(site_url('/guru/editSoal/' . $quiz_id))->withInput()->with('error', 'Beberapa soal gagal diperbarui. Silakan periksa input Anda atau coba lagi.');
        }
    }

    /**
     * Menghapus soal tertentu dari kuis.
     */
    public function hapusSoal($id)
    {
        // Mencari soal dan menghapusnya
        $soal = $this->soalModel->find($id);

        if (!$soal) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan!');
        }

        $quiz_id = $soal['quiz_id'];

        // Menghapus data soal dari database
        if ($this->soalModel->delete($id)) {
            return redirect()->to('/guru/viewQuiz/' . $quiz_id)->with('success', 'Soal berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus soal. Silakan coba lagi.');
        }
    }

    // LIST MURID
    public function listMurid($kelasId)
    {
        if (session()->get('role_id') != 2) {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $kelas = $this->kelasModel->find($kelasId);

        if (!$kelas) {
            return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
        }

        $perPage = 10;

        $muridList = $this->kelasSiswaModel
            ->select('kelas_siswa.id, kelas_siswa.murid_id, users.username, users.email, kelas_siswa.status, kelas_siswa.created_at as tanggal_join')
            ->join('users', 'users.id = kelas_siswa.murid_id')
            ->where('kelas_siswa.kelas_id', $kelasId)
            ->orderBy('users.username', 'ASC')
            ->paginate($perPage);

        $pager = $this->kelasSiswaModel->pager;

        $data = [
            'title'     => 'Daftar Murid di Kelas ' . $kelas['nama_kelas'],
            'kelas'     => $kelas,
            'muridList' => $muridList,
            'kelasId'   => $kelasId,
            'pager'     => $pager,
        ];

        return view('guru/list_murid', $data);
    }
}


    // public function editStatus($id)
    // {
    //     // Mencari kelas berdasarkan ID
    //     $kelas = $this->kelasModel->find($id);

    //     if (!$kelas) {
    //         return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
    //     }

    //     $statusOptions = ['aktif', 'non_aktif'];
    //     return view('guru/edit_status', [
    //         'kelas'         => $kelas,
    //         'statusOptions' => $statusOptions
    //     ]);
    // }

    // public function updateStatus($id)
    // {
    //     // Aturan validasi untuk status kelas
    //     $rules = [
    //         'status' => 'required|in_list[aktif,non_aktif]',
    //     ];

    //     // Memvalidasi input status
    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Mencari kelas dan memperbarui statusnya
    //     $kelas = $this->kelasModel->find($id);
    //     if (!$kelas) {
    //         return redirect()->to('/guru/viewClasses')->with('error', 'Kelas tidak ditemukan.');
    //     }

    //     $data = ['status' => $this->request->getPost('status')];

    //     // Memperbarui status kelas dan memberikan feedback
    //     if ($this->kelasModel->update($id, $data)) {
    //         return redirect()->to('/guru/viewClasses')->with('success', 'Status kelas berhasil diperbarui!');
    //     } else {
    //         return redirect()->back()->withInput()->with('error', 'Gagal memperbarui status kelas. Silakan coba lagi.');
    //     }
    // }