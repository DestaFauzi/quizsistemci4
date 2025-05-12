<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user_id', $user['id']);
            session()->set('role_id', $user['role_id']);
            return $this->redirectBasedOnRole($user['role_id']);
        } else {
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Redirect berdasarkan role pengguna
    public function redirectBasedOnRole($role_id)
    {
        switch ($role_id) {
            case 1: // Admin
                return redirect()->to('/admin/dashboard');
            case 2: // Guru
                return redirect()->to('/guru/dashboard');
            case 3: // Murid
                return redirect()->to('/murid/dashboard');
            default:
                return redirect()->to('/');
        }
    }

    // Fungsi untuk memeriksa role
    public function checkRole($role)
    {
        if (session()->get('role_id') != $role) {
            return redirect()->to('/');
        }
    }
}
