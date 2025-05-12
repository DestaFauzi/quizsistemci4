<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminController extends Controller
{
    // Fungsi untuk dashboard admin
    public function dashboard()
    {
        // Memeriksa apakah user memiliki role admin (role_id == 1)
        if (session()->get('role_id') != 1) {
            return redirect()->to('/');
        }

        return view('admin/dashboard');
    }
}
