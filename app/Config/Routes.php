<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');

// ROUTES AUTH
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');
$routes->get('logout', 'AuthController::logout');

// ROUTES ADMIN
$routes->group('admin', function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');

    // Kelola data
    $routes->get('kelolaKelas', 'AdminController::kelolaKelas');
    $routes->get('kelolaMateri', 'AdminController::kelolaMateri');
    $routes->get('kelolaQuiz', 'AdminController::kelolaQuiz');
    $routes->get('kelolaPengguna', 'AdminController::kelolaPengguna');

    // Materi
    $routes->get('editMateri/(:num)', 'AdminController::editMateri/$1');
    $routes->get('hapusMateri/(:num)', 'AdminController::hapusMateri/$1');

    // Quiz
    $routes->get('hapusQuiz/(:num)', 'AdminController::hapusQuiz/$1');

    // Pengguna
    $routes->get('hapusPengguna/(:num)', 'AdminController::hapusPengguna/$1');
});
$routes->get('/lihatmateri/(:num)', 'AdminController::lihatMateri/$1');


// ROUTES GURU
$routes->group('guru', function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'GuruController::dashboard');

    // Kelas
    $routes->get('createClass', 'GuruController::createClass');
    $routes->post('saveClass', 'GuruController::saveClass');
    $routes->get('viewClasses', 'GuruController::viewClasses');
    $routes->get('editStatus/(:num)', 'GuruController::editStatus/$1');
    $routes->post('updateStatus/(:num)', 'GuruController::updateStatus/$1');
    $routes->get('detailKelas/(:num)', 'GuruController::detailKelas/$1');

    // Materi
    $routes->get('addMateri/(:num)', 'GuruController::addMateri/$1');
    $routes->post('saveMateri', 'GuruController::saveMateri');
    $routes->post('uploadMateri', 'GuruController::uploadMateri');
    $routes->get('hapusMateri/(:num)', 'GuruController::hapusMateri/$1');
    $routes->get('editMateri/(:num)', 'GuruController::editMateri/$1');
    $routes->post('updateMateri/(:num)', 'GuruController::updateMateri/$1');

    // Quiz
    $routes->get('addQuiz/(:num)', 'GuruController::addQuiz/$1');
    $routes->post('saveQuiz', 'GuruController::saveQuiz');
    $routes->get('viewQuiz/(:segment)', 'GuruController::viewQuiz/$1');
    $routes->get('hapusQuiz/(:num)', 'GuruController::hapusQuiz/$1');

    // Soal
    $routes->get('addSoal/(:segment)', 'GuruController::addSoal/$1');
    $routes->post('saveSoal', 'GuruController::saveSoal');
    $routes->get('hapusSoal/(:num)', 'GuruController::hapusSoal/$1');
    $routes->get('editSoal/(:num)', 'GuruController::editSoal/$1');
    $routes->post('updateSoal', 'GuruController::updateSoal');
});



/// ROUTES MURID
$routes->group('murid', function ($routes) {
    // Dashboard & Navigasi Kelas
    $routes->get('dashboard', 'MuridController::dashboard');
    $routes->get('semuaKelas', 'MuridController::semuaKelas');
    $routes->get('kelasDalamProses', 'MuridController::kelasDalamProses');
    $routes->get('kelasSelesai', 'MuridController::kelasSelesai');
    $routes->get('koleksiBadge', 'MuridController::koleksiBadge');
    $routes->get('detailKelas/(:num)', 'MuridController::detailKelas/$1');

    // Akses Kelas, Materi, Quiz
    $routes->get('masukKelas/(:num)', 'MuridController::masukKelas/$1');
    $routes->get('lanjutkanKelas/(:num)', 'MuridController::lanjutkanKelas/$1');
    $routes->get('aksesMateri/(:segment)/(:segment)', 'MuridController::aksesMateri/$1/$2');
    $routes->get('aksesQuiz/(:num)/(:num)', 'MuridController::aksesQuiz/$1/$2');
    $routes->post('submitQuiz/(:segment)/(:segment)', 'MuridController::submitQuiz/$1/$2');
    $routes->post('selesaikanMateri/(:segment)/(:segment)', 'MuridController::selesaikanMateri/$1/$2');

    // Leaderboard
    $routes->get('leaderboard/(:num)', 'MuridController::leaderboard/$1');
    // $routes->get('leaderboard/(:segment)', 'MuridController::leaderboard/$1');
});



// Routes untuk menuju dashboard murid
// $routes->get('murid/selesaiKelas/(:num)', 'MuridController::selesaiKelas/$1');
// $routes->get('/murid/kelasSelesai', 'MuridController::kelasSelesai');
// $routes->get('/murid/quiz/(:num)', 'QuizController::viewQuiz/$1');  // Melihat quiz // Mengirim jawaban

// $routes->get('/murid/selesaikanKelas/(:num)', 'MuridController::selesaikanKelas/$1');
// $routes->get('/murid/aksesKelas/(:segment)', 'MuridController::aksesKelas/$1');
// $routes->get('/murid/aksesQuiz/(:segment)', 'MuridController::aksesQuiz/$1');
// $routes->post('/murid/submitQuiz/(:segment)', 'MuridController::submitQuiz/$1');

// Routes untuk akses kelas, materi, quiz, dan leaderboard
// $routes->get('/murid/aksesKelas/(:segment)', 'MuridController::aksesKelas/$1');