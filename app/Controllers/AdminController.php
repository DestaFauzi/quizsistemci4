<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\QuizModel;
use App\Models\UserModel;
use App\Models\SoalModel;
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
        return view('admin/kelola_kelas', ['kelas' => $kelas]);
    }

    // Fungsi untuk mengelola materi
    public function kelolaMateri()
    {
        $materiModel = new MateriModel();
        $materi = $materiModel->findAll();
        return view('admin/kelola_materi', ['materi' => $materi]);
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
        return view('admin/kelola_quiz', ['quiz' => $quiz]);
    }

    // Fungsi untuk mengelola pengguna (users)
    public function kelolaPengguna()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        return view('admin/kelola_pengguna', ['users' => $users]);
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
    public function hapusPengguna($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user) {
            // Hapus pengguna dari database
            $userModel->delete($id);
            return redirect()->to('/admin/kelolaPengguna')->with('success', 'Pengguna berhasil dihapus!');
        }

        return redirect()->to('/admin/kelolaPengguna')->with('error', 'Pengguna tidak ditemukan!');
    }
}