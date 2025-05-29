CREATE TABLE  `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.roles: ~6 rows (approximately)
INSERT IGNORE INTO `roles` (`id`, `role_name`) VALUES
	(1, 'admin'),
	(2, 'guru'),
	(3, 'murid'),
	(4, 'admin'),
	(5, 'guru'),
	(6, 'murid');

CREATE TABLE  `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping structure for table lmsci.badge
CREATE TABLE `badge` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `murid_id` int unsigned NOT NULL,
  `badge_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_earned` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `badge_murid_id_foreign` (`murid_id`),
  CONSTRAINT `badge_murid_id_foreign` FOREIGN KEY (`murid_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table lmsci.kelas
CREATE TABLE `kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','non_aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'non_aktif',
  `guru_id` int unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_guru_id_foreign` (`guru_id`),
  CONSTRAINT `kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.kelas: ~6 rows (approximately)
INSERT IGNORE INTO `kelas` (`id`, `nama_kelas`, `deskripsi`, `status`, `guru_id`, `created_at`, `updated_at`) VALUES
	(1, 'Kelas Sastra Jepang', 'Kelas Sastra Jepang adalah kelas', 'aktif', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Kelas Bahasa Inggris', 'Kelas Bahasa Inggris Adalah kelas ..', 'non_aktif', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'kelas sastra mesin', 'kelas', 'non_aktif', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, 'Kelas Bahasa Inggris', 'kelas', 'aktif', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, 'KelasX', 'kelasx', 'aktif', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 'Kelas 9 SMK', 'ini kelas', 'aktif', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- Dumping structure for table lmsci.kelas_siswa
CREATE TABLE `kelas_siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `murid_id` int unsigned NOT NULL,
  `status` enum('belum_dimulai','proses','selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'belum_dimulai',
  `status_materi` enum('belum_diakses','selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'belum_diakses',
  `status_quiz` enum('belum_dikerjakan','selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'belum_dikerjakan',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_siswa_kelas_id_foreign` (`kelas_id`),
  KEY `kelas_siswa_murid_id_foreign` (`murid_id`),
  CONSTRAINT `kelas_siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kelas_siswa_murid_id_foreign` FOREIGN KEY (`murid_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.kelas_siswa: ~4 rows (approximately)
INSERT IGNORE INTO `kelas_siswa` (`id`, `kelas_id`, `murid_id`, `status`, `status_materi`, `status_quiz`, `created_at`, `updated_at`) VALUES
	(6, 5, 3, '', 'belum_diakses', 'belum_dikerjakan', '2025-05-06 15:31:22', '2025-05-06 18:16:09'),
	(7, 4, 3, '', 'belum_diakses', 'belum_dikerjakan', '2025-05-06 17:20:29', '2025-05-06 18:15:09'),
	(8, 3, 3, '', 'belum_diakses', 'belum_dikerjakan', '2025-05-06 19:11:40', '2025-05-06 19:11:40'),
	(9, 6, 3, '', 'belum_diakses', 'belum_dikerjakan', '2025-05-09 04:29:37', '2025-05-09 04:29:37');

-- Dumping structure for table lmsci.materi
CREATE TABLE  `materi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `level` int unsigned DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `materi_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `materi_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.materi: ~15 rows (approximately)
INSERT IGNORE INTO `materi` (`id`, `kelas_id`, `judul`, `file_name`, `file_path`, `level`, `created_at`, `updated_at`) VALUES
	(5, 1, 'Materi 1 Sastra Jepang', 'Formulir pengajuan magang 2025 wesclic.pdf', 'uploads/materi/kelas_1/Formulir pengajuan magang 2025 wesclic.pdf', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 1, 'Materi 2', 'Sistem Informasi Quiz.pdf', 'uploads/materi/kelas_1/Sistem Informasi Quiz.pdf', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(7, 3, 'Materi 1', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_3/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(8, 3, 'Materi 2', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_3/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(9, 3, 'Materi 3', 'Modul Ruang Lingkup Digital Marketing.pdf', 'uploads/materi/kelas_3/Modul Ruang Lingkup Digital Marketing.pdf', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(10, 3, 'Materi 4', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_3/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(12, 3, 'Materi 5', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_3/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(13, 4, 'Materi 1', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_4/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(14, 4, 'Materi 2', 'Modul Ruang Lingkup Digital Marketing.pdf', 'uploads/materi/kelas_4/Modul Ruang Lingkup Digital Marketing.pdf', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(15, 4, 'Materi 3', 'MODUL RUANG LINGKUP DIGITAL MARKETING SLIDE.pdf', 'uploads/materi/kelas_4/MODUL RUANG LINGKUP DIGITAL MARKETING SLIDE.pdf', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(16, 5, 'Materi 1', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_5/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(17, 5, 'Materi 2', 'MODUL RUANG LINGKUP DIGITAL MARKETING SLIDE.pdf', 'uploads/materi/kelas_5/MODUL RUANG LINGKUP DIGITAL MARKETING SLIDE.pdf', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(18, 5, 'Materi 3', 'Modul Ruang Lingkup Digital Marketing.pdf', 'uploads/materi/kelas_5/Modul Ruang Lingkup Digital Marketing.pdf', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(19, 6, 'Materi 1', 'Faktor Merokok Dikalang Remaja Saat Ini.pdf', 'uploads/materi/kelas_6/Faktor Merokok Dikalang Remaja Saat Ini.pdf', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(20, 6, 'Materi 2', 'Formulir pengajuan magang 2025 wesclic.pdf', 'uploads/materi/kelas_6/Formulir pengajuan magang 2025 wesclic.pdf', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- Dumping structure for table lmsci.migrations
CREATE TABLE  `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.migrations: ~13 rows (approximately)
INSERT IGNORE INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2025-05-05-104956', 'App\\Database\\Migrations\\CreateRolesTable', 'default', 'App', 1746443320, 1),
	(2, '2025-05-05-105004', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1746443320, 1),
	(3, '2025-05-05-111216', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1746443711, 2),
	(4, '2025-05-05-113754', 'App\\Database\\Migrations\\CreateMateriTable', 'default', 'App', 1746445830, 3),
	(5, '2025-05-05-113833', 'App\\Database\\Migrations\\CreateQuizTable', 'default', 'App', 1746445830, 3),
	(6, '2025-05-05-113914', 'App\\Database\\Migrations\\CreateSoalTable', 'default', 'App', 1746445830, 3),
	(7, '2025-05-05-155830', 'App\\Database\\Migrations\\AddLevelToQuiz', 'default', 'App', 1746460765, 4),
	(8, '2025-05-05-162041', 'App\\Database\\Migrations\\RemoveWaktuFromSoal', 'default', 'App', 1746462055, 5),
	(9, '2025-05-05-164450', 'App\\Database\\Migrations\\UpdateLevelColumnInMateriTable', 'default', 'App', 1746463507, 6),
	(10, '2025-05-05-165635', 'App\\Database\\Migrations\\CreateKelasSiswaTable', 'default', 'App', 1746464270, 7),
	(11, '2025-05-05-165640', 'App\\Database\\Migrations\\CreateBadgesTable', 'default', 'App', 1746464270, 7),
	(12, '2025-05-06-112116', 'App\\Database\\Migrations\\CreateQuizAnswersTable', 'default', 'App', 1746530867, 8),
	(13, '2025-05-06-112123', 'App\\Database\\Migrations\\CreateQuizResultsTable', 'default', 'App', 1746530867, 8);

-- Dumping structure for table lmsci.quiz
CREATE TABLE  `quiz` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `judul_quiz` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_soal` int unsigned NOT NULL,
  `waktu` int NOT NULL,
  `level` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `quiz_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.quiz: ~16 rows (approximately)
INSERT IGNORE INTO `quiz` (`id`, `kelas_id`, `judul_quiz`, `jumlah_soal`, `waktu`, `level`, `created_at`, `updated_at`) VALUES
	(14, 1, 'Quiz Level 1', 2, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(15, 1, 'Quiz level 2', 2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(16, 3, 'Quiz 1', 2, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(17, 3, 'Quiz 2', 2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(18, 3, 'Quiz 3', 2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(19, 3, 'Quiz 4', 2, 10, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(20, 3, 'Quiz 5', 2, 10, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(21, 3, 'Quiz 6', 2, 2, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(22, 3, 'Final Quiz', 3, 10, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(23, 4, 'Quiz 1', 2, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(24, 4, 'Quiz 2', 2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(25, 5, 'Quiz 1', 2, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(26, 5, 'Quiz 2', 2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(27, 5, 'Quiz 3', 2, 2, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(28, 6, 'Quiz 1', 2, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(29, 6, 'Quiz 2', 2, 3, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- Dumping structure for table lmsci.quiz_answers
CREATE TABLE  `quiz_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `murid_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `soal_id` int NOT NULL,
  `jawaban_pilih` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.quiz_answers: ~20 rows (approximately)
INSERT IGNORE INTO `quiz_answers` (`id`, `quiz_id`, `murid_id`, `kelas_id`, `soal_id`, `jawaban_pilih`, `is_correct`, `created_at`, `updated_at`) VALUES
	(1, 16, 3, 0, 23, 'A', 0, '2025-05-06 11:33:17', '2025-05-06 11:33:17'),
	(2, 16, 3, 0, 24, 'A', 0, '2025-05-06 11:33:17', '2025-05-06 11:33:17'),
	(3, 16, 3, 0, 23, 'A', 0, '2025-05-06 11:36:05', '2025-05-06 11:36:05'),
	(4, 16, 3, 0, 24, 'A', 0, '2025-05-06 11:36:05', '2025-05-06 11:36:05'),
	(5, 16, 3, 0, 23, 'A', 0, '2025-05-06 11:38:52', '2025-05-06 11:38:52'),
	(6, 16, 3, 0, 24, 'A', 0, '2025-05-06 11:38:52', '2025-05-06 11:38:52'),
	(7, 16, 3, 0, 23, 'A', 0, '2025-05-06 11:39:23', '2025-05-06 11:39:23'),
	(8, 16, 3, 0, 24, 'B', 0, '2025-05-06 11:39:23', '2025-05-06 11:39:23'),
	(9, 23, 3, 0, 38, 'A', 0, '2025-05-06 12:10:48', '2025-05-06 12:10:48'),
	(10, 23, 3, 0, 39, 'A', 0, '2025-05-06 12:10:48', '2025-05-06 12:10:48'),
	(11, 23, 3, 0, 38, 'A', 0, '2025-05-06 12:11:47', '2025-05-06 12:11:47'),
	(12, 23, 3, 0, 39, 'A', 0, '2025-05-06 12:11:47', '2025-05-06 12:11:47'),
	(13, 23, 3, 0, 38, 'A', 0, '2025-05-06 12:12:17', '2025-05-06 12:12:17'),
	(14, 23, 3, 0, 39, 'A', 0, '2025-05-06 12:12:17', '2025-05-06 12:12:17'),
	(15, 23, 3, 0, 38, 'A', 0, '2025-05-06 12:13:13', '2025-05-06 12:13:13'),
	(16, 23, 3, 0, 39, 'A', 0, '2025-05-06 12:13:13', '2025-05-06 12:13:13'),
	(17, 23, 3, 0, 38, 'A', 0, '2025-05-06 12:15:05', '2025-05-06 12:15:05'),
	(18, 23, 3, 0, 39, 'B', 0, '2025-05-06 12:15:05', '2025-05-06 12:15:05'),
	(19, 23, 3, 0, 38, 'B', 0, '2025-05-06 12:19:44', '2025-05-06 12:19:44'),
	(20, 23, 3, 0, 39, 'A', 0, '2025-05-06 12:19:44', '2025-05-06 12:19:44');

-- Dumping structure for table lmsci.quiz_results
CREATE TABLE  `quiz_results` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `murid_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `score` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.quiz_results: ~10 rows (approximately)
INSERT IGNORE INTO `quiz_results` (`id`, `quiz_id`, `murid_id`, `kelas_id`, `score`, `created_at`, `updated_at`) VALUES
	(1, 16, 3, 0, 0, '2025-05-06 11:33:17', '2025-05-06 11:33:17'),
	(2, 16, 3, 0, 0, '2025-05-06 11:36:05', '2025-05-06 11:36:05'),
	(3, 16, 3, 0, 0, '2025-05-06 11:38:52', '2025-05-06 11:38:52'),
	(4, 16, 3, 0, 0, '2025-05-06 11:39:24', '2025-05-06 11:39:24'),
	(5, 23, 3, 0, 0, '2025-05-06 12:10:48', '2025-05-06 12:10:48'),
	(6, 23, 3, 0, 0, '2025-05-06 12:11:47', '2025-05-06 12:11:47'),
	(7, 23, 3, 0, 0, '2025-05-06 12:12:17', '2025-05-06 12:12:17'),
	(8, 23, 3, 0, 0, '2025-05-06 12:13:13', '2025-05-06 12:13:13'),
	(9, 23, 3, 0, 0, '2025-05-06 12:15:05', '2025-05-06 12:15:05'),
	(10, 23, 3, 0, 0, '2025-05-06 12:19:44', '2025-05-06 12:19:44');

-- Dumping structure for table lmsci.roles


-- Dumping structure for table lmsci.soal
CREATE TABLE  `soal` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int unsigned NOT NULL,
  `soal` text COLLATE utf8mb4_general_ci NOT NULL,
  `jawaban_a` text COLLATE utf8mb4_general_ci NOT NULL,
  `jawaban_b` text COLLATE utf8mb4_general_ci NOT NULL,
  `jawaban_c` text COLLATE utf8mb4_general_ci NOT NULL,
  `jawaban_d` text COLLATE utf8mb4_general_ci NOT NULL,
  `jawaban_benar` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `poin` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `soal_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `soal_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table lmsci.soal: ~35 rows (approximately)
INSERT IGNORE INTO `soal` (`id`, `quiz_id`, `soal`, `jawaban_a`, `jawaban_b`, `jawaban_c`, `jawaban_d`, `jawaban_benar`, `poin`, `created_at`, `updated_at`) VALUES
	(19, 14, 'oko', 'j', 'hj', 'jj', 'jj', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(20, 14, 'nn', 'j', 'm', 'jk', 'kk', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(21, 15, 'm', 'mm', 'mm', 'm', 'm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(22, 15, 'mkmk', 'km', 'km', 'mk', 'km', 'b', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(23, 16, 'aks', 'kmk', 'mkm', 'km', 'kkm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(24, 16, 'kkk', 'kmm', 'kmk', 'km', 'kmk', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(25, 17, 'lmm', 'll', 'll,', 'l,l', ',lmknkjn', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(26, 17, 'knkk', 'nkn', 'knk', 'nkk', 'nk', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(27, 18, 'kmlml', 'lmlm', 'lmlm', 'lmm', 'lm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(28, 18, 'kmk', 'mm', 'knk', 'nkn', 'knkkn', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(29, 19, 'kkmknlknkln', 'lnjn', 'jkn', 'jnjn', 'jn', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(30, 19, 'n knknkn', 'kiojoj', 'jojjn', 'klnohioh', 'oin ijio', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(31, 20, 'lmll', 'mklm', 'mkm', 'kmm', 'm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(32, 20, 'nnkio', 'hohoh', 'oo', 'ooh', 'oh', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(33, 21, 'mojoj', 'ojoijo', 'j', 'oj', 'oij', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(34, 21, 'jjojojo', 'joj', 'oj', 'ojo', 'jo', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(35, 22, 'kjjop', 'jjoj', 'jpojp', 'ojpoj', 'ppj', 'a', 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(36, 22, 'jooi', 'hoh', 'ih', 'oh', 'oh', 'a', 35, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(37, 22, 'nknkskajioj', 'ojoij', 'ug', 'hi', 'j', 'a', 35, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(38, 23, 'kkm', 'koj', 'joij', 'oj', 'oj', 'a', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(39, 23, 'ojj', 'jooj', 'oj', 'j', 'oj', 'a', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(40, 24, 'kslkk', 'kk', 'kkkp', ';k', 'kllk', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(41, 24, 'lllm', 'll', 'lm', 'ml', 'lm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(42, 24, 'kslkk', 'kk', 'kkkp', ';k', 'kllk', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(43, 24, 'lllm', 'll', 'lm', 'ml', 'lm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(44, 25, 'ihuihihih', 'ihi', 'ih', 'ih', 'ooo', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(45, 25, 'kkm', 'kmmk', 'mkmk', 'mk', 'kkmk', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(46, 26, 'wsa', 'ojo', 'ojo', 'o', 'oj', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(47, 26, 'km', 'k', 'llmlm', 'm', 'm', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(48, 27, 'k', 'kk', 'kk', 'kk', 'k', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(49, 27, 'kk', 'kkk', 'kk', 'lll', 'll', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(50, 28, 'jsaoj', 'oij', 'j', 'oj', 'jo', 'b', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(51, 28, 'kjskjasj', 'ojojoj', 'oj', 'jo', 'jo', 'a', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(52, 29, 'okoko', 'oooj', 'jnk', 'kknk', 'knk', 'a', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(53, 29, 'mljbkds', 'knl', 'nln', 'lln', 'nkn', 'c', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- Dumping structure for table lmsci.users

-- Dumping data for table lmsci.users: ~3 rows (approximately)
INSERT IGNORE INTO `users` (`id`, `username`, `email`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 'adminuser', 'admin@example.com', '$2y$10$ca76lqTJeqhsFRdUMJWh2uIO0Gb9TYde3JP30i7/Ov3oY3qdOuvKK', 1, '2025-05-05 11:08:55', '2025-05-05 11:08:55'),
	(2, 'guruuser', 'guru@example.com', '$2y$10$D2mL09ypU4Y9BVv8eWTte.sguELn4Tlx0AxJs5txtCGVdQmsYbEAa', 2, '2025-05-05 11:08:55', '2025-05-05 11:08:55'),
	(3, 'muriduser', 'murid@example.com', '$2y$10$WPjEoWNqi2qv2sRKLh/oT.F6PWZLdg7bh51NH0TzKMSo/.iASJHC2', 3, '2025-05-05 11:08:55', '2025-05-05 11:08:55');
