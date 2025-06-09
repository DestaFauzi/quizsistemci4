<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\QuizModel;
use App\Models\SoalModel;
use App\Models\KelasSiswaModel;

class GuruController extends Controller
{
    // Fungsi untuk dashboard guru
    public function dashboard()
    {
        // Memeriksa apakah user memiliki role guru (role_id == 2)
        if (session()->get('role_id') != 2) {
            return redirect()->to('/');
        }

        return view('guru/dashboard');
    }

    // Fungsi untuk membuat kelas, materi, dan quiz
    // Menampilkan form untuk membuat kelas
    public function createClass()
    {
        return view('guru/create_class');
    }

    // Menyimpan data kelas ke dalam database
    public function saveClass()
    {
        $kelasModel = new KelasModel();

        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'jumlah_level' => $this->request->getPost('jumlah_level'),
            'guru_id' => session()->get('user_id'),
        ];

        // Simpan data kelas
        $kelasModel->save($data);

        return redirect()->to('/guru/dashboard')->with('success', 'Kelas berhasil dibuat!');
    }
    // Menampilkan semua kelas yang dibuat oleh guru
    public function viewClasses()
    {
        $kelasModel = new KelasModel();

        // Mengambil semua kelas yang dibuat oleh guru yang sedang login
        $kelas = $kelasModel->where('guru_id', session()->get('user_id'))->findAll();

        return view('guru/view_classes', ['kelas' => $kelas]);
    }

    public function editStatus($id)
    {
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($id);

        // Mengambil status yang ada
        $statusOptions = ['aktif', 'non_aktif'];

        return view('guru/edit_status', ['kelas' => $kelas, 'statusOptions' => $statusOptions]);
    }

    // Fungsi untuk menyimpan perubahan status kelas
    public function updateStatus($id)
    {
        $kelasModel = new KelasModel();

        $data = [
            'status' => $this->request->getPost('status')
        ];

        $kelasModel->update($id, $data);

        return redirect()->to('/guru/viewClasses')->with('success', 'Status kelas berhasil diperbarui!');
    }

    // Fungsi untuk menambah materi ke kelas
    public function addMateri($kelas_id)
    {
        $kelasModel = new KelasModel();

        // Ambil data kelas berdasarkan ID
        $kelas = $kelasModel->find($kelas_id);

        // Pastikan data kelas ditemukan
        if (!$kelas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelas tidak ditemukan.');
        }

        // Kirim data kelas ke view
        return view('guru/add_materi', [
            'kelas' => $kelas  // Mengirimkan data kelas ke view
        ]);
    }

    // Fungsi untuk menyimpan materi
    public function saveMateri()
    {
        // Logika untuk menyimpan materi
        // ...
        return redirect()->to('/guru/viewClasses')->with('success', 'Materi berhasil ditambahkan!');
    }

    // Fungsi untuk menambah quiz ke kelas
    public function addQuiz($kelas_id)
    {
        return view('guru/add_quiz', [
            'kelas_id' => $kelas_id,
        ]);
    }

    // Fungsi untuk menyimpan quiz
    public function saveQuiz()
    {
        $quizModel = new QuizModel();

        // Menyimpan data quiz
        $quizData = [
            'kelas_id' => $this->request->getPost('kelas_id'),
            'judul_quiz' => $this->request->getPost('judul_quiz'),
            'jumlah_soal' => $this->request->getPost('jumlah_soal'),
            'level' => $this->request->getPost('level'),
            'waktu' => $this->request->getPost('waktu')
        ];

        // cari apakah ada quiz dengan level yang sama
        $availQuiz = $quizModel->where('kelas_id', $quizData['kelas_id'])->where('level', $quizData['level'])->first();

        if ($availQuiz) {
            return redirect()->to('/guru/addQuiz/' . $quizData['kelas_id'])->withInput()->with('error', 'Quiz dengan level ' . $quizData['level'] . ' sudah ada!');
        }

        // Menyimpan data quiz ke database
        $quizModel->save($quizData);

        // Ambil ID quiz yang baru saja disimpan
        $quiz_id = $quizModel->getInsertID();

        // Mengarahkan ke halaman untuk menambahkan soal
        return redirect()->to('/guru/addSoal/' . $quiz_id)->with('success', 'Quiz berhasil ditambahkan! Sekarang tambahkan soal untuk quiz ini.');
    }

    public function detailKelas($id)
    {
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();
        $kelasSiswaModel = new KelasSiswaModel();

        // Ambil data kelas berdasarkan id
        $kelas = $kelasModel->find($id);

        // Ambil materi dan quiz untuk kelas tersebut
        $materi = $materiModel->where('kelas_id', $id)->findAll();
        $quiz = $quizModel->where('kelas_id', $id)->findAll();

        // Ambil status kelas murid jika ada
        $muridId = session()->get('user_id');
        $status = $kelasSiswaModel->where('kelas_id', $id)->where('murid_id', $muridId)->first();

        // Kirim data kelas dan status ke view
        return view('guru/detail_kelas', [
            'kelas' => $kelas,
            'materi' => $materi,
            'quiz' => $quiz,
            'status' => $status
        ]);
    }


    public function viewQuiz($quiz_id)
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();

        // Ambil data quiz berdasarkan quiz_id
        $quiz = $quizModel->find($quiz_id);

        // Ambil soal yang terkait dengan quiz ini
        $soal = $soalModel->where('quiz_id', $quiz_id)->findAll();

        // Kirim data quiz dan soal ke view
        return view('guru/view_quiz', [
            'quiz' => $quiz,
            'soal' => $soal
        ]);
    }

    // Fungsi untuk menampilkan form tambah soal
    public function addSoal($quiz_id)
    {
        $quizModel = new QuizModel();
        $quiz = $quizModel->find($quiz_id);

        if (!$quiz) {
            return redirect()->to('/guru/quiz')->with('error', 'Quiz tidak ditemukan.');
        }

        // Ambil jumlah soal yang dibolehkan
        $jumlah_soal = $quiz['jumlah_soal'];

        return view('guru/add_soal', [
            'quiz_id' => $quiz_id,
            'jumlah_soal' => $jumlah_soal
        ]);
    }

    // Menyimpan soal baru
    public function saveSoal()
    {
        $soalModel = new SoalModel();

        $quiz_id = $this->request->getPost('quiz_id');
        $jumlah_soal = (int)$this->request->getPost('jumlah_soal');

        if (!$quiz_id || !$jumlah_soal) {
            return redirect()->back()->with('error', 'Data tidak lengkap.');
        }

        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $data = [
                'quiz_id'        => $quiz_id,
                'soal'           => $this->request->getPost("soal_$i"),
                'jawaban_a'      => $this->request->getPost("jawaban_a_$i"),
                'jawaban_b'      => $this->request->getPost("jawaban_b_$i"),
                'jawaban_c'      => $this->request->getPost("jawaban_c_$i"),
                'jawaban_d'      => $this->request->getPost("jawaban_d_$i"),
                'jawaban_benar'  => $this->request->getPost("jawaban_benar_$i"),
                'poin'           => (int)$this->request->getPost("poin_$i"),
            ];

            if (!$soalModel->save($data)) {
                return redirect()->back()->with('error', 'Gagal menyimpan soal ke-' . $i);
            }
        }

        return redirect()->to("/guru/viewQuiz/$quiz_id")->with('success', 'Soal berhasil ditambahkan.');
    }

    // Menampilkan form edit soal
    public function editSoal($quiz_id)
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();

        // Ambil quiz
        $quiz = $quizModel->find($quiz_id);
        if (!$quiz) {
            return redirect()->back()->with('error', 'Quiz tidak ditemukan.');
        }

        // Ambil semua soal yang terkait quiz_id
        $soalList = $soalModel->where('quiz_id', $quiz_id)->findAll();

        $jumlahSoal = $quiz['jumlah_soal'];

        return view('guru/edit_soal', [
            'soalList' => $soalList,
            'quiz_id' => $quiz_id,
            'jumlah_soal' => $jumlahSoal
        ]);
    }

    // Menyimpan hasil edit soal
    public function updateSoal()
    {
        $soalModel = new SoalModel();

        $quiz_id = $this->request->getPost('quiz_id');
        $soal_ids = $this->request->getPost('soal_id');
        $soals = $this->request->getPost('soal');
        $jawaban_a = $this->request->getPost('jawaban_a');
        $jawaban_b = $this->request->getPost('jawaban_b');
        $jawaban_c = $this->request->getPost('jawaban_c');
        $jawaban_d = $this->request->getPost('jawaban_d');
        $jawaban_benar = $this->request->getPost('jawaban_benar');
        $poin = $this->request->getPost('poin');

        for ($i = 0; $i < count($soal_ids); $i++) {
            $data = [
                'id'             => $soal_ids[$i],
                'quiz_id'        => $quiz_id,
                'soal'           => $soals[$i],
                'jawaban_a'      => $jawaban_a[$i],
                'jawaban_b'      => $jawaban_b[$i],
                'jawaban_c'      => $jawaban_c[$i],
                'jawaban_d'      => $jawaban_d[$i],
                'jawaban_benar'  => $jawaban_benar[$i],
                'poin'           => (int)$poin[$i],
            ];

            $soalModel->save($data);
        }

        return redirect()->to("/guru/viewQuiz/$quiz_id")->with('success', 'Semua soal berhasil diperbarui.');
    }

    public function hapusSoal($id)
    {
        $soalModel = new SoalModel();

        // Cari soal berdasarkan ID
        $soal = $soalModel->find($id);

        // Pastikan soal ditemukan
        if ($soal) {
            // Hapus soal dari database
            $soalModel->delete($id);

            // Redirect kembali ke halaman view quiz dengan pesan sukses
            return redirect()->to('/guru/viewQuiz/' . $soal['quiz_id'])->with('success', 'Soal berhasil dihapus!');
        }

        return redirect()->to('/guru/viewQuiz/' . $soal['quiz_id'])->with('error', 'Soal tidak ditemukan!');
    }



    public function uploadMateri()
    {
        // Mendapatkan file yang diupload dari form
        $file = $this->request->getFile('file_materi');

        if ($file->isValid() && !$file->hasMoved()) {
            // Menentukan nama file dan folder penyimpanan
            $fileName = $file->getName();

            // Menentukan path folder berdasarkan kelas_id
            $kelasId = $this->request->getPost('kelas_id');
            $directory = ROOTPATH . 'public/uploads/materi/kelas_' . $kelasId . '/';

            // Membuat direktori jika belum ada
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);  // Membuat folder dengan permission yang tepat
            }

            // Memindahkan file ke direktori yang telah ditentukan
            $file->move($directory, $fileName);

            // Menyimpan data materi ke dalam database
            $materiModel = new MateriModel();
            $materiData = [
                'kelas_id' => $kelasId,
                'judul' => $this->request->getPost('judul'),
                'file_name' => $fileName,
                'file_path' => 'uploads/materi/kelas_' . $kelasId . '/' . $fileName,  // Path relatif
                'level' => (int) $this->request->getPost('level')  // Menyimpan level sebagai integer
            ];

            $materiModel->save($materiData);

            return redirect()->to('/guru/viewClasses')->with('success', 'Materi berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    // Fungsi untuk menghapus materi
    public function hapusMateri($id)
    {
        $materiModel = new MateriModel();

        // Cari materi berdasarkan ID
        $materi = $materiModel->find($id);

        // Pastikan materi ditemukan
        if ($materi) {
            // Hapus file fisik jika diperlukan (misalnya, di direktori uploads)
            if (file_exists(ROOTPATH . 'public/' . $materi['file_path'])) {
                unlink(ROOTPATH . 'public/' . $materi['file_path']);
            }

            // Hapus materi dari database
            $materiModel->delete($id);

            // Redirect kembali ke halaman detail kelas dengan pesan sukses
            return redirect()->to('/guru/detailKelas/' . $materi['kelas_id'])->with('success', 'Materi berhasil dihapus!');
        }

        return redirect()->to('/guru/detailKelas/' . $materi['kelas_id'])->with('error', 'Materi tidak ditemukan!');
    }
    public function hapusQuiz($id)
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();  // Model untuk tabel soal

        // Cari quiz berdasarkan ID
        $quiz = $quizModel->find($id);

        // Pastikan quiz ditemukan
        if ($quiz) {
            // Hapus semua soal yang terkait dengan quiz ini
            $soalModel->where('quiz_id', $id)->delete(); // Menghapus soal yang terkait dengan quiz

            // Hapus quiz dari database
            $quizModel->delete($id);

            // Redirect kembali ke halaman detail kelas dengan pesan sukses
            return redirect()->to('/guru/detailKelas/' . $quiz['kelas_id'])->with('success', 'Quiz berhasil dihapus!');
        }

        return redirect()->to('/guru/detailKelas/' . $quiz['kelas_id'])->with('error', 'Quiz tidak ditemukan!');
    }
}
