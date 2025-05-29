<?php

// Mengatur path ke folder aplikasi CodeIgniter
$applicationPath = __DIR__ . '/app'; // Path ke folder app

// Mendefinisikan APPPATH
define('APPPATH', $applicationPath . '/');

// Memuat file utama CodeIgniter
require_once APPPATH . 'Config/CodeIgniter.php';