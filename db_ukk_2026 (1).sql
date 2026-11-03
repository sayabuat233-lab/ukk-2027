-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Nov 2026 pada 06.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ukk_2026`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '19800101201002', 'Wawan Kurniawan, S.Pd.I', 'guru1@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(2, '19800101201003', 'Ai Nuryaidah, S.Pd', 'guru2@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(3, '19800101201004', 'Maya Permata Endah, S.Pd', 'guru3@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(4, '19800101201005', 'Dody Jaenudin, S.Pd.', 'guru4@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(5, '19800101201006', 'Dedi Kardiman, S.Pd', 'guru5@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(6, '19800101201007', 'Uca Musa Yusenda, S.Pd', 'guru6@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(7, '19800101201008', 'Drs. Ahmad Nur Mukhlis', 'guru7@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(8, '19800101201009', 'Drs. Heri', 'guru8@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(9, '19800101201010', 'Asep Bastaman', 'guru9@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(10, '19800101201011', 'H. Encep Maemun, S.T., M.Pd', 'guru10@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(11, '19800101201012', 'Opik', 'guru11@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(12, '19800101201013', 'Ida Farida, S.Pd', 'guru12@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(13, '19800101201014', 'Idah Mahmudah, S.Pd', 'guru13@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(14, '19800101201015', 'Drs. Muhamad Ali', 'guru14@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(15, '19800101201016', 'Helmi Ali Akbar, S.Pd.I', 'guru15@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(16, '19800101201017', 'Syeni Suswarini, S.Pd', 'guru16@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(17, '19800101201018', 'Wiwid Yulianti, S.Pd', 'guru17@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(18, '19800101201019', 'Ansor Muhajir, S.T', 'guru18@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(19, '19800101201020', 'Ogi Gaosun Gias, S.Pd.I', 'guru19@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(20, '19800101201021', 'Sandi Mulyana, S.Pd', 'guru20@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(21, '19800101201022', 'Erna Suryani, S.Pd', 'guru21@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(22, '19800101201023', 'Ai Wahidah, S.Ag', 'guru22@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(23, '19800101201024', 'Chandra Aditya Yusup, S.Pd', 'guru23@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(24, '19800101201025', 'Arif Kusmawan, S.Pd', 'guru24@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(25, NULL, 'Asep Taufiq Hidayat, S.Kom', 'guru25@gmail.com', 1, NULL, NULL, NULL),
(26, '19800101201027', 'Rendy Ichsan Kusumah, S.T', 'guru26@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(27, '19800101201028', 'Feri Rahmawan, S.Pd', 'guru27@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(28, '19800101201029', 'Ari Sandriana, S.Kom', 'guru28@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(29, '19800101201030', 'Yaneu Nurdian, S.Pd, M.Pd', 'guru29@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(30, '19800101201031', 'Ucu Muhammad Khoer N, S.Pd', 'guru30@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(31, '19800101201032', 'Mira Dwi Rahmawati, S.Ag', 'guru31@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(32, '19800101201033', 'Aldi Maulana, S.Pd', 'guru32@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(33, '19800101201034', 'Eli Rosliah, S.Pd', 'guru33@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(34, '19800101201035', 'Isni Nur Fitriani, S.Pd', 'guru34@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(35, '19800101201036', 'Aanisah Putri Nur Aini, S.Pd', 'guru35@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(36, '19800101201037', 'Yusi Luthfiani, S.Sos.I', 'guru36@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(37, '19800101201038', 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'guru37@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(38, '19800101201039', 'Yusrin Noer Sabrina, S.Pd', 'guru38@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(39, '19800101201040', 'Senny Indayani, S.Pd', 'guru39@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(40, '19800101201041', 'Ilma Amalia, S.Pd', 'guru40@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(41, '19800101201042', 'Alvira Sofwatunnisa, S.Pd', 'guru41@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(42, '19800101201043', 'Risna Andriyani, S.Pd', 'guru42@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(43, '19800101201044', 'Dra. Tintin Noorhayati', 'guru43@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(44, '19800101201045', 'Rizkia Fahira, S.Pd', 'guru44@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(45, '19800101201046', 'Frasetio', 'guru45@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(46, '19800101201047', 'Ratnaningsih Hati Aeni, S.Pd.', 'guru46@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(47, '19800101201048', 'Dheny Darajatul Hasani, S.Pd.', 'guru47@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(48, '19800101201049', 'Fahrullah, S.Pd', 'guru48@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(49, '19800101201050', 'Aan Andriana, S.T', 'guru49@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(50, '19800101201051', 'Fitri Fauziah, S.T', 'guru50@gmail.com', 1, NULL, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(51, NULL, 'Nida Aulia, S.Pd', 'guru51@gmail.com', 1, NULL, NULL, NULL),
(52, NULL, 'Sri Nurrizki Putri Krisnadi, S.Pd', 'guru52@gmail.com', 1, NULL, NULL, NULL),
(53, NULL, 'Riesy Putri Navia, S.Kom', 'guru53@gmail.com', 1, NULL, NULL, NULL),
(54, NULL, 'Rurry Febriani Maryadi, S.Pd', 'guru54@gmail.com', 1, NULL, NULL, NULL),
(55, NULL, 'Irvan Rizal, S.Pd', 'guru55@gmail.com', 1, NULL, NULL, NULL),
(56, '444444444444444444', 'Ari', 'ari@gmail.com', 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tingkat` varchar(20) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'X TKR 1', 'X', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(2, 'X TKR 2', 'X', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(3, 'X TKR 3', 'X', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(4, 'X TKR 4', 'X', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(5, 'X TKR 5', 'X', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(6, 'X TSM 1', 'X', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(7, 'X TSM 2', 'X', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(8, 'X TSM 3', 'X', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(9, 'X RPL 1', 'X', 'RPL', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(10, 'X RPL 2', 'X', 'RPL', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(11, 'X TKJ 1', 'X', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(12, 'X TKJ 2', 'X', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(13, 'X TKJ 3', 'X', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(14, 'X BD', 'X', 'BD', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(15, 'XI TKR 1', 'XI', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(16, 'XI TKR 2', 'XI', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(17, 'XI TKR 3', 'XI', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(18, 'XI TSM 1', 'XI', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(19, 'XI TSM 2', 'XI', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(20, 'XI RPL', 'XI', 'RPL', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(21, 'XI TKJ 1', 'XI', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(22, 'XI TKJ 2', 'XI', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(23, 'XI BD', 'XI', 'BD', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(24, 'XII TKR 1', 'XII', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(25, 'XII TKR 2', 'XII', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(26, 'XII TKR 3', 'XII', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(27, 'XII TKR 4', 'XII', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(28, 'XII TKR 5', 'XII', 'TKR', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(29, 'XII TSM 1', 'XII', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(30, 'XII TSM 2', 'XII', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(31, 'XII TSM 3', 'XII', 'TSM', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(32, 'XII RPL 1', 'XII', 'RPL', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(33, 'XII RPL 2', 'XII', 'RPL', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(34, 'XII TKJ 1', 'XII', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(35, 'XII TKJ 2', 'XII', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(36, 'XII TKJ 3', 'XII', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(37, 'XII TKJ 4', 'XII', 'TKJ', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(38, 'XII BD', 'XII', 'BD', 1, '2026-11-03 04:34:42', '2026-11-03 04:34:42'),
(51, 'XII RPL 5', 'XII', 'RPL', 1, '2026-11-03 04:57:34', '2026-11-03 04:57:34'),
(53, 'XI RPL 1', 'X', 'RPL', 1, '2026-11-03 05:12:16', '2026-11-03 05:12:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `poin` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 12, 'PLG-001', 'Terlambat Masuk Sekolah (Tipe 1)', 10, 'Deskripsi detail pelanggaran Terlambat Masuk Sekolah (Tipe 1)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(2, 41, 'PLG-002', 'Tidak Pakai Seragam Sesuai Jadwal (Tipe 2)', 20, 'Deskripsi detail pelanggaran Tidak Pakai Seragam Sesuai Jadwal (Tipe 2)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(3, 18, 'PLG-003', 'Rambut Panjang / Tidak Rapi (Tipe 3)', 15, 'Deskripsi detail pelanggaran Rambut Panjang / Tidak Rapi (Tipe 3)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(4, 9, 'PLG-004', 'Membawa HP saat Pelajaran Tanpa Izin (Tipe 4)', 30, 'Deskripsi detail pelanggaran Membawa HP saat Pelajaran Tanpa Izin (Tipe 4)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(5, 34, 'PLG-005', 'Atribut Seragam Tidak Lengkap (Tipe 5)', 25, 'Deskripsi detail pelanggaran Atribut Seragam Tidak Lengkap (Tipe 5)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(6, 11, 'PLG-006', 'Membawa Rokok / Merokok (Tipe 6)', 55, 'Deskripsi detail pelanggaran Membawa Rokok / Merokok (Tipe 6)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(7, 3, 'PLG-007', 'Mebolos Sekolah / Cabut (Tipe 7)', 35, 'Deskripsi detail pelanggaran Mebolos Sekolah / Cabut (Tipe 7)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(8, 22, 'PLG-008', 'Membuat Kegaduhan di Kelas (Tipe 8)', 25, 'Deskripsi detail pelanggaran Membuat Kegaduhan di Kelas (Tipe 8)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(9, 39, 'PLG-009', 'Mencoret Dinding / Meja (Tipe 9)', 35, 'Deskripsi detail pelanggaran Mencoret Dinding / Meja (Tipe 9)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(10, 5, 'PLG-010', 'Tawuran (Tipe 10)', 100, 'Deskripsi detail pelanggaran Tawuran (Tipe 10)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(11, 44, 'PLG-011', 'Terlambat Masuk Sekolah (Tipe 11)', 10, 'Deskripsi detail pelanggaran Terlambat Masuk Sekolah (Tipe 11)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(12, 18, 'PLG-012', 'Tidak Pakai Seragam Sesuai Jadwal (Tipe 12)', 20, 'Deskripsi detail pelanggaran Tidak Pakai Seragam Sesuai Jadwal (Tipe 12)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(13, 27, 'PLG-013', 'Rambut Panjang / Tidak Rapi (Tipe 13)', 15, 'Deskripsi detail pelanggaran Rambut Panjang / Tidak Rapi (Tipe 13)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(14, 48, 'PLG-014', 'Membawa HP saat Pelajaran Tanpa Izin (Tipe 14)', 30, 'Deskripsi detail pelanggaran Membawa HP saat Pelajaran Tanpa Izin (Tipe 14)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(15, 30, 'PLG-015', 'Atribut Seragam Tidak Lengkap (Tipe 15)', 25, 'Deskripsi detail pelanggaran Atribut Seragam Tidak Lengkap (Tipe 15)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(16, 2, 'PLG-016', 'Membawa Rokok / Merokok (Tipe 16)', 55, 'Deskripsi detail pelanggaran Membawa Rokok / Merokok (Tipe 16)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(17, 37, 'PLG-017', 'Mebolos Sekolah / Cabut (Tipe 17)', 35, 'Deskripsi detail pelanggaran Mebolos Sekolah / Cabut (Tipe 17)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(18, 14, 'PLG-018', 'Membuat Kegaduhan di Kelas (Tipe 18)', 25, 'Deskripsi detail pelanggaran Membuat Kegaduhan di Kelas (Tipe 18)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(19, 29, 'PLG-019', 'Mencoret Dinding / Meja (Tipe 19)', 35, 'Deskripsi detail pelanggaran Mencoret Dinding / Meja (Tipe 19)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(20, 1, 'PLG-020', 'Tawuran (Tipe 20)', 100, 'Deskripsi detail pelanggaran Tawuran (Tipe 20)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(21, 15, 'PLG-021', 'Terlambat Masuk Sekolah (Tipe 21)', 10, 'Deskripsi detail pelanggaran Terlambat Masuk Sekolah (Tipe 21)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(22, 19, 'PLG-022', 'Tidak Pakai Seragam Sesuai Jadwal (Tipe 22)', 20, 'Deskripsi detail pelanggaran Tidak Pakai Seragam Sesuai Jadwal (Tipe 22)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(23, 21, 'PLG-023', 'Rambut Panjang / Tidak Rapi (Tipe 23)', 15, 'Deskripsi detail pelanggaran Rambut Panjang / Tidak Rapi (Tipe 23)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(24, 2, 'PLG-024', 'Membawa HP saat Pelajaran Tanpa Izin (Tipe 24)', 30, 'Deskripsi detail pelanggaran Membawa HP saat Pelajaran Tanpa Izin (Tipe 24)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(25, 4, 'PLG-025', 'Atribut Seragam Tidak Lengkap (Tipe 25)', 25, 'Deskripsi detail pelanggaran Atribut Seragam Tidak Lengkap (Tipe 25)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(26, 42, 'PLG-026', 'Membawa Rokok / Merokok (Tipe 26)', 55, 'Deskripsi detail pelanggaran Membawa Rokok / Merokok (Tipe 26)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(27, 26, 'PLG-027', 'Mebolos Sekolah / Cabut (Tipe 27)', 35, 'Deskripsi detail pelanggaran Mebolos Sekolah / Cabut (Tipe 27)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(28, 47, 'PLG-028', 'Membuat Kegaduhan di Kelas (Tipe 28)', 25, 'Deskripsi detail pelanggaran Membuat Kegaduhan di Kelas (Tipe 28)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(29, 33, 'PLG-029', 'Mencoret Dinding / Meja (Tipe 29)', 35, 'Deskripsi detail pelanggaran Mencoret Dinding / Meja (Tipe 29)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(30, 25, 'PLG-030', 'Tawuran (Tipe 30)', 100, 'Deskripsi detail pelanggaran Tawuran (Tipe 30)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(31, 38, 'PLG-031', 'Terlambat Masuk Sekolah (Tipe 31)', 10, 'Deskripsi detail pelanggaran Terlambat Masuk Sekolah (Tipe 31)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(32, 17, 'PLG-032', 'Tidak Pakai Seragam Sesuai Jadwal (Tipe 32)', 20, 'Deskripsi detail pelanggaran Tidak Pakai Seragam Sesuai Jadwal (Tipe 32)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(33, 40, 'PLG-033', 'Rambut Panjang / Tidak Rapi (Tipe 33)', 15, 'Deskripsi detail pelanggaran Rambut Panjang / Tidak Rapi (Tipe 33)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(34, 16, 'PLG-034', 'Membawa HP saat Pelajaran Tanpa Izin (Tipe 34)', 30, 'Deskripsi detail pelanggaran Membawa HP saat Pelajaran Tanpa Izin (Tipe 34)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(35, 12, 'PLG-035', 'Atribut Seragam Tidak Lengkap (Tipe 35)', 25, 'Deskripsi detail pelanggaran Atribut Seragam Tidak Lengkap (Tipe 35)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(36, 28, 'PLG-036', 'Membawa Rokok / Merokok (Tipe 36)', 55, 'Deskripsi detail pelanggaran Membawa Rokok / Merokok (Tipe 36)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(37, 24, 'PLG-037', 'Mebolos Sekolah / Cabut (Tipe 37)', 35, 'Deskripsi detail pelanggaran Mebolos Sekolah / Cabut (Tipe 37)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(38, 20, 'PLG-038', 'Membuat Kegaduhan di Kelas (Tipe 38)', 25, 'Deskripsi detail pelanggaran Membuat Kegaduhan di Kelas (Tipe 38)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(39, 45, 'PLG-039', 'Mencoret Dinding / Meja (Tipe 39)', 35, 'Deskripsi detail pelanggaran Mencoret Dinding / Meja (Tipe 39)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(40, 10, 'PLG-040', 'Tawuran (Tipe 40)', 100, 'Deskripsi detail pelanggaran Tawuran (Tipe 40)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(41, 13, 'PLG-041', 'Terlambat Masuk Sekolah (Tipe 41)', 10, 'Deskripsi detail pelanggaran Terlambat Masuk Sekolah (Tipe 41)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(42, 6, 'PLG-042', 'Tidak Pakai Seragam Sesuai Jadwal (Tipe 42)', 20, 'Deskripsi detail pelanggaran Tidak Pakai Seragam Sesuai Jadwal (Tipe 42)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(43, 31, 'PLG-043', 'Rambut Panjang / Tidak Rapi (Tipe 43)', 15, 'Deskripsi detail pelanggaran Rambut Panjang / Tidak Rapi (Tipe 43)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(44, 49, 'PLG-044', 'Membawa HP saat Pelajaran Tanpa Izin (Tipe 44)', 30, 'Deskripsi detail pelanggaran Membawa HP saat Pelajaran Tanpa Izin (Tipe 44)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(45, 50, 'PLG-045', 'Atribut Seragam Tidak Lengkap (Tipe 45)', 25, 'Deskripsi detail pelanggaran Atribut Seragam Tidak Lengkap (Tipe 45)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(46, 7, 'PLG-046', 'Membawa Rokok / Merokok (Tipe 46)', 55, 'Deskripsi detail pelanggaran Membawa Rokok / Merokok (Tipe 46)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(47, 36, 'PLG-047', 'Mebolos Sekolah / Cabut (Tipe 47)', 35, 'Deskripsi detail pelanggaran Mebolos Sekolah / Cabut (Tipe 47)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(48, 23, 'PLG-048', 'Membuat Kegaduhan di Kelas (Tipe 48)', 25, 'Deskripsi detail pelanggaran Membuat Kegaduhan di Kelas (Tipe 48)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(49, 32, 'PLG-049', 'Mencoret Dinding / Meja (Tipe 49)', 35, 'Deskripsi detail pelanggaran Mencoret Dinding / Meja (Tipe 49)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(50, 43, 'PLG-050', 'Tawuran (Tipe 50)', 100, 'Deskripsi detail pelanggaran Tawuran (Tipe 50)', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan Waktu - Tingkat 1', 'Kategori pelanggaran terkait kedisiplinan waktu - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(2, 'Kerapihan Berpakaian - Tingkat 1', 'Kategori pelanggaran terkait kerapihan berpakaian - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(3, 'Sikap dan Perilaku - Tingkat 1', 'Kategori pelanggaran terkait sikap dan perilaku - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(4, 'Kehadiran - Tingkat 1', 'Kategori pelanggaran terkait kehadiran - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(5, 'Ketertiban Belajar - Tingkat 1', 'Kategori pelanggaran terkait ketertiban belajar - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(6, 'Penggunaan Barang Terlarang - Tingkat 1', 'Kategori pelanggaran terkait penggunaan barang terlarang - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(7, 'Fasilitas Sekolah - Tingkat 1', 'Kategori pelanggaran terkait fasilitas sekolah - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(8, 'Kesusilaan - Tingkat 1', 'Kategori pelanggaran terkait kesusilaan - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(9, 'Kerajinan - Tingkat 1', 'Kategori pelanggaran terkait kerajinan - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(10, 'Lain-lain - Tingkat 1', 'Kategori pelanggaran terkait lain-lain - tingkat 1', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(11, 'Kedisiplinan Waktu - Tingkat 2', 'Kategori pelanggaran terkait kedisiplinan waktu - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(12, 'Kerapihan Berpakaian - Tingkat 2', 'Kategori pelanggaran terkait kerapihan berpakaian - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(13, 'Sikap dan Perilaku - Tingkat 2', 'Kategori pelanggaran terkait sikap dan perilaku - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(14, 'Kehadiran - Tingkat 2', 'Kategori pelanggaran terkait kehadiran - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(15, 'Ketertiban Belajar - Tingkat 2', 'Kategori pelanggaran terkait ketertiban belajar - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(16, 'Penggunaan Barang Terlarang - Tingkat 2', 'Kategori pelanggaran terkait penggunaan barang terlarang - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(17, 'Fasilitas Sekolah - Tingkat 2', 'Kategori pelanggaran terkait fasilitas sekolah - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(18, 'Kesusilaan - Tingkat 2', 'Kategori pelanggaran terkait kesusilaan - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(19, 'Kerajinan - Tingkat 2', 'Kategori pelanggaran terkait kerajinan - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(20, 'Lain-lain - Tingkat 2', 'Kategori pelanggaran terkait lain-lain - tingkat 2', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(21, 'Kedisiplinan Waktu - Tingkat 3', 'Kategori pelanggaran terkait kedisiplinan waktu - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(22, 'Kerapihan Berpakaian - Tingkat 3', 'Kategori pelanggaran terkait kerapihan berpakaian - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(23, 'Sikap dan Perilaku - Tingkat 3', 'Kategori pelanggaran terkait sikap dan perilaku - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(24, 'Kehadiran - Tingkat 3', 'Kategori pelanggaran terkait kehadiran - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(25, 'Ketertiban Belajar - Tingkat 3', 'Kategori pelanggaran terkait ketertiban belajar - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(26, 'Penggunaan Barang Terlarang - Tingkat 3', 'Kategori pelanggaran terkait penggunaan barang terlarang - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(27, 'Fasilitas Sekolah - Tingkat 3', 'Kategori pelanggaran terkait fasilitas sekolah - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(28, 'Kesusilaan - Tingkat 3', 'Kategori pelanggaran terkait kesusilaan - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(29, 'Kerajinan - Tingkat 3', 'Kategori pelanggaran terkait kerajinan - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(30, 'Lain-lain - Tingkat 3', 'Kategori pelanggaran terkait lain-lain - tingkat 3', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(31, 'Kedisiplinan Waktu - Tingkat 4', 'Kategori pelanggaran terkait kedisiplinan waktu - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(32, 'Kerapihan Berpakaian - Tingkat 4', 'Kategori pelanggaran terkait kerapihan berpakaian - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(33, 'Sikap dan Perilaku - Tingkat 4', 'Kategori pelanggaran terkait sikap dan perilaku - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(34, 'Kehadiran - Tingkat 4', 'Kategori pelanggaran terkait kehadiran - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(35, 'Ketertiban Belajar - Tingkat 4', 'Kategori pelanggaran terkait ketertiban belajar - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(36, 'Penggunaan Barang Terlarang - Tingkat 4', 'Kategori pelanggaran terkait penggunaan barang terlarang - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(37, 'Fasilitas Sekolah - Tingkat 4', 'Kategori pelanggaran terkait fasilitas sekolah - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(38, 'Kesusilaan - Tingkat 4', 'Kategori pelanggaran terkait kesusilaan - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(39, 'Kerajinan - Tingkat 4', 'Kategori pelanggaran terkait kerajinan - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(40, 'Lain-lain - Tingkat 4', 'Kategori pelanggaran terkait lain-lain - tingkat 4', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(41, 'Kedisiplinan Waktu - Tingkat 5', 'Kategori pelanggaran terkait kedisiplinan waktu - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(42, 'Kerapihan Berpakaian - Tingkat 5', 'Kategori pelanggaran terkait kerapihan berpakaian - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(43, 'Sikap dan Perilaku - Tingkat 5', 'Kategori pelanggaran terkait sikap dan perilaku - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(44, 'Kehadiran - Tingkat 5', 'Kategori pelanggaran terkait kehadiran - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(45, 'Ketertiban Belajar - Tingkat 5', 'Kategori pelanggaran terkait ketertiban belajar - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(46, 'Penggunaan Barang Terlarang - Tingkat 5', 'Kategori pelanggaran terkait penggunaan barang terlarang - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(47, 'Fasilitas Sekolah - Tingkat 5', 'Kategori pelanggaran terkait fasilitas sekolah - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(48, 'Kesusilaan - Tingkat 5', 'Kategori pelanggaran terkait kesusilaan - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(49, 'Kerajinan - Tingkat 5', 'Kategori pelanggaran terkait kerajinan - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56'),
(50, 'Lain-lain - Tingkat 5', 'Kategori pelanggaran terkait lain-lain - tingkat 5', 1, '2026-09-23 02:31:56', '2026-09-23 02:31:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nama_siswa` varchar(150) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `nama_kelas` varchar(100) DEFAULT NULL,
  `pelanggaran_id` int(11) NOT NULL,
  `nama_pelanggaran` varchar(150) DEFAULT NULL,
  `pelanggaran_kategori_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `nama_guru` varchar(150) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `poin` int(11) DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '102410544', '0085000001', 'ADITTIA NUR LANTIP', 'L', '2008-01-10', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(2, '102410545', '0085000002', 'AGNIA ROSYA NOERILLAH', 'P', '2008-02-12', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(3, '102410546', '0085000003', 'ANISA AMIRULLA', 'P', '2008-03-15', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(4, '102410547', '0085000004', 'ARADEA KANDI', 'L', '2008-04-20', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(5, '102410548', '0085000005', 'ARFA DIESA OKMALELIZA', 'P', '2008-05-22', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(6, '102410549', '0085000006', 'FITRI NUR SYIAMI', 'P', '2008-06-05', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(7, '102410550', '0085000007', 'JUNITA PUTRI NUR RAHMAN', 'P', '2008-05-12', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(8, '102410551', '0085000008', 'MOHAMMAD ATALARIK ALI SYAHBANA', 'L', '2008-07-11', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(9, '102410552', '0085000009', 'MUHAMAD FAHRIL FAHRUROZI', 'L', '2008-08-14', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(10, '102410750', '0085000010', 'MUHAMMAD ADNAN SYAEFUL ISLAMI', 'L', '2008-09-03', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(11, '102410553', '0085000011', 'MUHAMMAD ZAHRU AQILA FIKRI', 'L', '2008-10-19', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(12, '102410554', '0085000012', 'NADIA ZULFA SORAYA', 'P', '2008-11-25', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(13, '102410555', '0085000013', 'NAZRIL ILHAM', 'L', '2008-12-01', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(14, '102410556', '0085000014', 'PUSPITA DEWI', 'P', '2008-01-18', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(15, '102410558', '0085000015', 'RAKHA MUHAMMAD HAYKAL', 'L', '2008-02-28', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(16, '102410559', '0085000016', 'RANI MEILANI', 'P', '2008-05-09', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(17, '102410560', '0085000017', 'REIHAN MUZAKI', 'L', '2008-04-12', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(18, '19800101201018', '0085000018', 'RESA JULIANSAH', 'L', '2008-07-29', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(19, '102410562', '0085000019', 'RIZKI PERMATA SUGIANTO', 'L', '2008-08-19', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(20, '102410563', '0085000020', 'SAHIRA FIRAJ', 'P', '2008-03-30', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(21, '102410564', '0085000021', 'SENDI MARDIAN', 'L', '2008-06-15', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(22, '102410755', '0085000022', 'SHAHAIDAN NIZZAR', 'L', '2008-09-10', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(23, '102410565', '0085000023', 'SHERLY SATRIANI', 'P', '2008-10-04', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(24, '102410566', '0085000024', 'SOFI NURJANAH', 'P', '2008-11-11', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(25, '102410567', '0085000025', 'SURAIYA SALSABILA AZZAHRA', 'P', '2008-12-20', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38'),
(26, '102410568', '0085000026', 'TONI ANTONIO', 'L', '2008-02-14', 'Tasikmalaya', 1, '2026-11-03 04:27:38', '2026-11-03 04:27:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2026/2027', '2026-07-15', '2027-06-20', 1, '2026-11-03 05:13:18', '2026-11-03 05:13:18'),
(2, '2027/2028', '2027-07-15', '2028-06-20', 0, '2026-11-03 05:13:18', '2026-11-03 05:13:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Administrator Utama', 'admin@gmail.com', NULL, '$2y$10$qR6iU7X2E4rYI6J1Jp7Nne9G9N0oV3v4L3mZ2a1bC5dE6fG7h8i9j', NULL, 'admin', NULL, NULL),
(2, 'Guru Pengajar', 'guru@gmail.com', NULL, '$2y$10$qR6iU7X2E4rYI6J1Jp7Nne9G9N0oV3v4L3mZ2a1bC5dE6fG7h8i9j', NULL, 'guru', NULL, NULL),
(3, 'Ari', 'ari@gmail.com', NULL, '$2y$10$tiX0jNimh8c5K9vQDN.37OfulYvK7X00AYWx/Z2Kyw.HtzVxNHxLK', NULL, 'guru', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_guru_user` (`user_id`);

--
-- Indeks untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ks_siswa` (`siswa_id`),
  ADD KEY `fk_ks_tahun_ajaran` (`tahun_ajaran_id`),
  ADD KEY `fk_ks_kelas` (`kelas_id`);

--
-- Indeks untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pelanggaran_kategori` (`pelanggaran_kategori_id`);

--
-- Indeks untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ps_tahun_ajaran` (`tahun_ajaran_id`),
  ADD KEY `fk_ps_siswa` (`siswa_id`),
  ADD KEY `fk_ps_kelas` (`kelas_id`),
  ADD KEY `fk_ps_pelanggaran` (`pelanggaran_id`),
  ADD KEY `fk_ps_pelanggaran_kategori` (`pelanggaran_kategori_id`),
  ADD KEY `fk_ps_guru` (`guru_id`);

--
-- Indeks untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wk_tahun_ajaran` (`tahun_ajaran_id`),
  ADD KEY `fk_wk_kelas` (`kelas_id`),
  ADD KEY `fk_wk_guru` (`guru_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD CONSTRAINT `fk_guru_user` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `fk_ks_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`),
  ADD CONSTRAINT `fk_ks_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`),
  ADD CONSTRAINT `fk_ks_tahun_ajaran` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`);

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `fk_pelanggaran_kategori` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`);

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `fk_ps_guru` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`),
  ADD CONSTRAINT `fk_ps_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`),
  ADD CONSTRAINT `fk_ps_pelanggaran` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`),
  ADD CONSTRAINT `fk_ps_pelanggaran_kategori` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`),
  ADD CONSTRAINT `fk_ps_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`),
  ADD CONSTRAINT `fk_ps_tahun_ajaran` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`);

--
-- Ketidakleluasaan untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `fk_wk_guru` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`),
  ADD CONSTRAINT `fk_wk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`),
  ADD CONSTRAINT `fk_wk_tahun_ajaran` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
