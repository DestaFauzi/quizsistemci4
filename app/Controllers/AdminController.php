<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\QuizModel;
use App\Models\UserModel;
use App\Models\SoalModel;
use App\Models\DetailGuru;
use App\Models\DetailMurid;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    // Fungsi untuk dashboard admin
    // Fungsi untuk dashboard admin
    public function dashboard()
    {
        // Memeriksa apakah user memiliki role admin (role_id == 1)
        if (session()->get('role_id') != 1) {
            return redirect()->to('/');
        }

        // Model untuk mengambil data jumlah kelas, materi, quiz, dan user
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();
        $quizModel = new QuizModel();
        $userModel = new UserModel();

        // Menghitung jumlah kelas
        $kelasCount = $kelasModel->countAll();

        // Menghitung jumlah materi
        $materiCount = $materiModel->countAll();

        // Menghitung jumlah quiz
        $quizCount = $quizModel->countAll();

        // Menghitung jumlah murid (role_id = 3 untuk murid)
        $userCount = $userModel->where('role_id', 3)->countAllResults();

        // Menghitung jumlah guru (role_id = 2 untuk guru)
        $guruCount = $userModel->where('role_id', 2)->countAllResults();

        // Mengirim data ke view untuk ditampilkan di dashboard
        return view('admin/dashboard', [
            'kelasCount' => $kelasCount,
            'materiCount' => $materiCount,
            'quizCount' => $quizCount,
            'userCount' => $userCount
        ]);
    }




    
    // Fungsi untuk mengelola kelas
    public function kelolaKelas()
    {
        $kelasModel = new KelasModel();

        $kelas = $kelasModel->findAll();
        $data['kelas'] = $kelasModel
            ->select('kelas.*, guru.nama_guru')
            ->join('detail_guru AS guru', 'guru.user_id = kelas.guru_id', 'left') 
            ->findAll();

        return view('admin/kelola_kelas', $data);
    }

    // Fungsi untuk mengelola materi
    public function kelolaMateri()
    {
        $materiModel = new MateriModel();
        $materi = $materiModel->findAll();
         $data['materi'] = $materiModel
        ->select('materi.*, kelas.nama_kelas')
        ->join('kelas', 'kelas.id = materi.kelas_id')
        ->findAll();

        return view('admin/kelola_materi', $data);
    }
    // Fungsi untuk edit materi berdasarkan ID
    public function editMateri($id)
    {
        $materiModel = new MateriModel();
        $materi = $materiModel->find($id);

        if (!$materi) {
            return redirect()->to('/admin/kelolaMateri')->with('error', 'Materi tidak ditemukan!');
        }

        return view('admin/edit_materi', ['materi' => $materi]);
    }

    // Fungsi untuk mengelola quiz
    public function kelolaQuiz()
    {
        $quizModel = new QuizModel();
        $quiz = $quizModel->findAll();

        $data['quiz'] = $quizModel
        ->select('quiz.*, kelas.nama_kelas') // ambil kolom nama_kelas
        ->join('kelas', 'kelas.id = quiz.kelas_id') // join dengan tabel kelas
        ->findAll();

        return view('admin/kelola_quiz', $data);
    }

    // Fungsi untuk mengelola pengguna (users)
public function kelolaPengguna()
{
    $userModel  = new \App\Models\UserModel();
    $guruModel  = new \App\Models\DetailGuru();
    $muridModel = new \App\Models\DetailMurid();

    $users = $userModel->findAll();

    $pengguna = [];

    foreach ($users as $user) {
        $userData = $user; // copy semua data user

        // Tambahkan detail berdasarkan role
        if ($user['role_id'] == 2) { // Guru
            $detail = $guruModel->where('user_id', $user['id'])->first();
        } elseif ($user['role_id'] == 3) { // Murid
            $detail = $muridModel->where('user_id', $user['id'])->first();
        } else {
            $detail = null;
        }

        $userData['detail'] = $detail;
        $pengguna[] = $userData;
    }

    return view('admin/kelola_pengguna', ['pengguna' => $pengguna]);
}

public function hapusPengguna($id)
{
    $userModel   = new \App\Models\UserModel();
    $guruModel   = new \App\Models\DetailGuru();
    $muridModel  = new \App\Models\DetailMurid();

    // Ambil data user
    $user = $userModel->find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
    }

    // Hapus detail guru atau murid sesuai role_id
    if ($user['role_id'] == 2) {
        // Guru
        $guruModel->where('user_id', $id)->delete();
    } elseif ($user['role_id'] == 3) {
        // Murid
        $muridModel->where('user_id', $id)->delete();
    }

    // Hapus user utama
    $userModel->delete($id);

    return redirect()->to('/admin/kelolaPengguna')->with('success', 'Data pengguna berhasil dihapus.');
}



    // Fungsi untuk menghapus materi
    public function hapusMateri($id)
    {
        $materiModel = new MateriModel();

        $materi = $materiModel->find($id);

        if ($materi) {
            // Hapus file fisik jika diperlukan
            if (file_exists(ROOTPATH . 'public/' . $materi['file_path'])) {
                unlink(ROOTPATH . 'public/' . $materi['file_path']);
            }

            // Hapus materi dari database
            $materiModel->delete($id);
            return redirect()->to('/admin/kelolaMateri')->with('success', 'Materi berhasil dihapus!');
        }

        return redirect()->to('/admin/kelolaMateri')->with('error', 'Materi tidak ditemukan!');
    }

    // Fungsi untuk menghapus quiz
    public function hapusQuiz($id)
    {
        $quizModel = new QuizModel();
        $soalModel = new SoalModel();

        $quiz = $quizModel->find($id);

        if ($quiz) {
            // Hapus semua soal yang terkait dengan quiz ini
            $soalModel->where('quiz_id', $id)->delete();

            // Hapus quiz dari database
            $quizModel->delete($id);
            return redirect()->to('/admin/kelolaQuiz')->with('success', 'Quiz berhasil dihapus!');
        }

        return redirect()->to('/admin/kelolaQuiz')->with('error', 'Quiz tidak ditemukan!');
    }

    // Fungsi untuk menghapus pengguna (user)
    // public function hapusPengguna($id)
    // {
    //     $userModel = new UserModel();
    //     $user = $userModel->find($id);

    //     if ($user) {
    //         // Hapus pengguna dari database
    //         $userModel->delete($id);
    //         return redirect()->to('/admin/kelolaPengguna')->with('success', 'Pengguna berhasil dihapus!');
    //     }

    //     return redirect()->to('/admin/kelolaPengguna')->with('error', 'Pengguna tidak ditemukan!');
    // }

    //FUNGSI UNTUK EDIT GURU

public function editGuru($id)
{
    $model = new DetailGuru();
    $data['guru'] = $model->where('user_id', $id)->first();

    if (!$data['guru']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Data guru dengan ID $id tidak ditemukan.");
    }

    return view('admin/edit_guru', $data);
}

public function editMurid($id)
{
    $model = new DetailMurid();
    $data['murid'] = $model->where('user_id', $id)->first();

    if (!$data['murid']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Data murid dengan ID $id tidak ditemukan.");
    }

    return view('admin/edit_murid', $data);
}

public function updateGuru($id)
{
    $model = new DetailGuru();

    $data = [
        'nama_guru' => $this->request->getPost('nama_guru'),
        'nip'       => $this->request->getPost('nip'),
        'alamat'    => $this->request->getPost('alamat'),
    ];

    $model->where('id', $id)->set($data)->update();

    return redirect()->to('/admin/kelolaPengguna')->with('success', 'Data guru berhasil diperbarui.');
}


public function updateMurid($id)
{
    $model = new DetailMurid();

    $data = [
        'nama_murid' => $this->request->getPost('nama_murid'),
        'nis'        => $this->request->getPost('nis'),
        'alamat'     => $this->request->getPost('alamat'),
        'jurusan'    => $this->request->getPost('jurusan'),
        'kelas'      => $this->request->getPost('kelas'),
    ];

    $model->where('id', $id)->set($data)->update();

    return redirect()->to('/admin/kelolaPengguna')->with('success', 'Data murid berhasil diperbarui.');
}
}