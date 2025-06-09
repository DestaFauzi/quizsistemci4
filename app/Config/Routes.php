<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
// Routes untuk Auth
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');
$routes->get('logout', 'AuthController::logout');

// Routes untuk Admin
$routes->get('admin/dashboard', 'AdminController::dashboard');
$routes->get('/admin/kelolaKelas', 'AdminController::kelolaKelas');
$routes->get('/admin/kelolaMateri', 'AdminController::kelolaMateri');
$routes->get('/admin/kelolaQuiz', 'AdminController::kelolaQuiz');
$routes->get('/admin/kelolaPengguna', 'AdminController::kelolaPengguna');
$routes->get('/lihatmateri/(:num)', 'AdminController::lihatMateri/$1');
// Routes untuk edit materi
$routes->get('/admin/editMateri/(:num)', 'AdminController::editMateri/$1');

// Routes untuk menghapus materi, quiz, dan pengguna
$routes->get('/admin/hapusMateri/(:num)', 'AdminController::hapusMateri/$1');
$routes->get('/admin/hapusQuiz/(:num)', 'AdminController::hapusQuiz/$1');
$routes->get('/admin/hapusPengguna/(:num)', 'AdminController::hapusPengguna/$1');

// ROUTES GURU
// Routes untuk menuju dashboard guru
$routes->get('guru/dashboard', 'GuruController::dashboard');
// Routes untuk membuat kelas
$routes->get('guru/createClass', 'GuruController::createClass');
$routes->post('guru/saveClass', 'GuruController::saveClass');
// Route untuk melihat semua kelas
$routes->get('guru/viewClasses', 'GuruController::viewClasses');
// Route untuk edit status kelas
$routes->get('guru/editStatus/(:num)', 'GuruController::editStatus/$1');
$routes->post('guru/updateStatus/(:num)', 'GuruController::updateStatus/$1');
// Route untuk tambah materi
$routes->get('guru/addMateri/(:num)', 'GuruController::addMateri/$1');
$routes->post('guru/saveMateri', 'GuruController::saveMateri');
// Route untuk tambah quiz
$routes->get('guru/addQuiz/(:num)', 'GuruController::addQuiz/$1');
$routes->post('guru/saveQuiz', 'GuruController::saveQuiz');
// Route untuk halaman detail kelas
$routes->get('guru/detailKelas/(:num)', 'GuruController::detailKelas/$1');
// Route untuk melihat soal quiz
$routes->get('guru/viewQuiz/(:num)', 'GuruController::viewQuiz/$1');
// Route untuk upload materi
$routes->post('guru/uploadMateri', 'GuruController::uploadMateri');
// // Route untuk menambah quiz
// $routes->get('guru/addQuiz/(:segment)', 'GuruController::addQuiz/$1');
// $routes->post('guru/saveQuiz', 'GuruController::saveQuiz');
// Route untuk melihat semua quiz
$routes->get('guru/viewQuiz/(:segment)', 'GuruController::viewQuiz/$1');
// // Route untuk upload quiz
// $routes->get('guru/addQuiz/(:segment)', 'GuruController::addQuiz/$1');
// $routes->post('guru/saveQuiz', 'GuruController::saveQuiz');
// Route untuk menambah soal
$routes->get('guru/addSoal/(:segment)', 'GuruController::addSoal/$1');
$routes->post('guru/saveSoal', 'GuruController::saveSoal');
// Route untuk melihat quiz dan soal
$routes->get('guru/viewQuiz/(:segment)', 'GuruController::viewQuiz/$1');
//Hapus Materi & Quiz
$routes->get('guru/hapusMateri/(:num)', 'GuruController::hapusMateri/$1');
$routes->get('guru/hapusQuiz/(:num)', 'GuruController::hapusQuiz/$1');
// Hapus Soal
$routes->get('guru/hapusSoal/(:num)', 'GuruController::hapusSoal/$1');
// Menampilkan form edit soal berdasarkan id soal
$routes->get('guru/editSoal/(:num)', 'GuruController::editSoal/$1');
// Update soal
$routes->post('guru/updateSoal', 'GuruController::updateSoal');


//ROUTES MURID
$routes->get('murid/dashboard', 'MuridController::dashboard');
$routes->get('murid/semuaKelas', 'MuridController::semuaKelas');
$routes->get('murid/kelasDalamProses', 'MuridController::kelasDalamProses');
$routes->get('murid/kelasSelesai', 'MuridController::kelasSelesai');
$routes->get('murid/koleksiBadge', 'MuridController::koleksiBadge');
$routes->get('murid/detailKelas/(:num)', 'MuridController::detailKelas/$1');

// Routes untuk akses kelas, materi, quiz, dan leaderboard
$routes->get('murid/masukKelas/(:num)', 'MuridController::masukKelas/$1');
$routes->get('murid/lanjutkanKelas/(:num)', 'MuridController::lanjutkanKelas/$1');
$routes->get('murid/aksesMateri/(:segment)/(:segment)', 'MuridController::aksesMateri/$1/$2');
$routes->get('murid/aksesQuiz/(:num)/(:num)', 'MuridController::aksesQuiz/$1/$2');
$routes->post('murid/submitQuiz/(:segment)/(:segment)', 'MuridController::submitQuiz/$1/$2');

//routes selesaikan materi
$routes->post('/murid/selesaikanMateri/(:segment)/(:segment)', 'MuridController::selesaikanMateri/$1/$2');

$routes->get('murid/leaderboard/(:num)', 'MuridController::leaderboard/$1');
$routes->get('murid/leaderboard/(:segment)', 'MuridController::leaderboard/$1');


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