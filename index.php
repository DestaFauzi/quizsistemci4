<?php

// Mengatur path ke folder aplikasi CodeIgniter
$applicationPath = __DIR__ . '/app'; // Path ke folder app
$systemPath = __DIR__ . '/vendor/codeigniter4/framework/system'; // Path ke folder system jika Anda menggunakan composer

// Mendefinisikan BASEPATH dan APPPATH
define('BASEPATH', $systemPath . '/');
define('APPPATH', $applicationPath . '/');

// Memuat file utama CodeIgniter
require_once BASEPATH . 'core/CodeIgniter.php';