-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Bulan Mei 2021 pada 08.35
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_simpel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `indikator_sectors`
--

CREATE TABLE `indikator_sectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `secretariat_id` bigint(20) UNSIGNED NOT NULL,
  `sector_id` tinyint(3) UNSIGNED NOT NULL,
  `evidence` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = memiliki gambar, 0=tidak ada gambar',
  `uraian` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_tindakan` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0=> normal, \\n1 = Tindak Lanjutan, 2 = Tunggakan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `indikator_sectors`
--

INSERT INTO `indikator_sectors` (`id`, `secretariat_id`, `sector_id`, `evidence`, `uraian`, `created_at`, `updated_at`, `status_tindakan`) VALUES
(1615129835110, 16151298351, 10, 0, NULL, '2021-03-07 15:10:35', '2021-03-07 15:10:35', 0),
(1615129835111, 16151298351, 11, 0, NULL, '2021-03-07 15:17:34', '2021-03-07 15:17:34', 0),
(1615129835112, 16151298351, 12, 0, NULL, '2021-03-07 15:22:30', '2021-03-07 15:22:30', 0),
(1615129835113, 16151298351, 13, 0, NULL, '2021-03-07 15:29:44', '2021-03-07 15:29:44', 0),
(1615129835114, 16151298351, 14, 0, NULL, '2021-03-07 15:14:10', '2021-03-07 15:14:10', 0),
(1615129835117, 16151298351, 17, 0, NULL, '2021-03-07 15:39:09', '2021-03-07 15:39:09', 0),
(1615129835118, 16151298351, 18, 0, NULL, '2021-03-07 15:46:34', '2021-03-07 15:46:34', 0),
(1615129835119, 16151298351, 19, 0, NULL, '2021-03-07 15:49:46', '2021-03-07 15:49:46', 0),
(1615129859110, 16151298591, 10, 0, NULL, '2021-03-07 15:10:59', '2021-03-07 15:10:59', 0),
(1615129872110, 16151298721, 10, 0, NULL, '2021-03-07 15:11:13', '2021-03-07 15:11:13', 0),
(1615129872111, 16151298721, 11, 0, NULL, '2021-03-07 15:18:05', '2021-03-07 15:18:05', 0),
(1615129872112, 16151298721, 12, 0, NULL, '2021-03-07 15:22:51', '2021-03-07 15:22:51', 0),
(1615129872113, 16151298721, 13, 0, NULL, '2021-03-07 15:30:05', '2021-03-07 15:30:05', 0),
(1615129891110, 16151298911, 10, 0, NULL, '2021-03-07 15:11:31', '2021-03-07 15:11:31', 0),
(1615129891114, 16151298911, 14, 0, NULL, '2021-03-18 08:18:52', '2021-03-18 08:18:52', 0),
(1615129905110, 16151299051, 10, 0, NULL, '2021-03-07 15:11:45', '2021-03-07 15:11:45', 0),
(1615129937110, 16151299371, 10, 0, NULL, '2021-03-07 15:12:17', '2021-03-07 15:12:17', 0),
(1615129949110, 16151299491, 10, 0, NULL, '2021-03-07 15:12:29', '2021-03-07 15:12:29', 0),
(1615129960119, 16151299601, 19, 0, NULL, '2021-03-07 15:53:51', '2021-03-07 15:53:51', 0),
(1615129971110, 16151299711, 10, 0, NULL, '2021-03-07 15:12:51', '2021-03-07 15:12:51', 0),
(1615129984110, 16151299841, 10, 0, NULL, '2021-03-07 15:13:04', '2021-03-07 15:13:04', 0),
(1615129984111, 16151299841, 11, 0, NULL, '2021-03-07 15:20:32', '2021-03-07 15:20:32', 0),
(1615129984112, 16151299841, 12, 0, NULL, '2021-03-07 15:26:57', '2021-03-07 15:26:57', 0),
(1615129984113, 16151299841, 13, 0, NULL, '2021-03-07 15:31:26', '2021-03-07 15:31:26', 0),
(1615129984114, 16151299841, 14, 0, NULL, '2021-03-07 15:16:21', '2021-03-07 15:16:21', 0),
(1615129984115, 16151299841, 15, 0, NULL, '2021-03-07 15:55:50', '2021-03-07 15:55:50', 0),
(1615129984117, 16151299841, 17, 0, NULL, '2021-03-07 15:45:35', '2021-03-07 15:45:35', 0),
(1615129984118, 16151299841, 18, 0, NULL, '2021-03-07 15:48:32', '2021-03-07 15:48:32', 0),
(1615129984119, 16151299841, 19, 0, NULL, '2021-03-07 15:54:00', '2021-03-07 15:54:00', 0),
(1615129995110, 16151299951, 10, 0, NULL, '2021-03-07 15:13:15', '2021-03-07 15:13:15', 0),
(1615130064114, 16151300641, 14, 0, NULL, '2021-03-07 15:14:24', '2021-03-07 15:14:24', 0),
(1615130077114, 16151300771, 14, 0, NULL, '2021-03-07 15:14:37', '2021-03-07 15:14:37', 0),
(1615130087114, 16151300871, 14, 0, NULL, '2021-03-07 15:14:47', '2021-03-07 15:14:47', 0),
(1615130096114, 16151300961, 14, 0, NULL, '2021-03-07 15:14:56', '2021-03-07 15:14:56', 0),
(1615130096117, 16151300961, 17, 0, NULL, '2021-03-18 08:26:28', '2021-03-18 08:26:28', 0),
(1615130108114, 16151301081, 14, 0, NULL, '2021-03-07 15:15:08', '2021-03-07 15:15:08', 0),
(1615130119114, 16151301191, 14, 0, NULL, '2021-03-07 15:15:19', '2021-03-07 15:15:19', 0),
(1615130131110, 16151301311, 10, 0, NULL, '2021-03-18 08:19:52', '2021-03-18 08:19:52', 0),
(1615130131111, 16151301311, 11, 0, NULL, '2021-03-18 08:19:52', '2021-03-18 08:19:52', 0),
(1615130131112, 16151301311, 12, 0, NULL, '2021-03-18 08:19:52', '2021-03-18 08:19:52', 0),
(1615130131113, 16151301311, 13, 0, NULL, '2021-03-18 08:19:52', '2021-03-18 08:19:52', 0),
(1615130143114, 16151301431, 14, 0, NULL, '2021-03-07 15:15:43', '2021-03-07 15:15:43', 0),
(1615130153114, 16151301531, 14, 0, NULL, '2021-03-07 15:15:53', '2021-03-07 15:15:53', 0),
(1615130314111, 16151303141, 11, 0, NULL, '2021-03-07 15:18:34', '2021-03-07 15:18:34', 0),
(1615130338111, 16151303381, 11, 0, NULL, '2021-03-07 15:18:58', '2021-03-07 15:18:58', 0),
(1615130405111, 16151304051, 11, 0, NULL, '2021-03-07 15:20:05', '2021-03-07 15:20:05', 0),
(1615130422111, 16151304221, 11, 0, NULL, '2021-03-07 15:20:22', '2021-03-07 15:20:22', 0),
(1615130444111, 16151304441, 11, 0, NULL, '2021-03-07 15:20:44', '2021-03-07 15:20:44', 0),
(1615130455111, 16151304551, 11, 0, NULL, '2021-03-07 15:20:55', '2021-03-07 15:20:55', 0),
(1615130467111, 16151304671, 11, 0, NULL, '2021-03-07 15:21:07', '2021-03-07 15:21:07', 0),
(1615130561113, 16151305611, 13, 0, NULL, '2021-03-21 07:44:18', '2021-03-21 07:44:18', 0),
(1615130761112, 16151307611, 12, 0, NULL, '2021-03-21 07:42:06', '2021-03-21 07:42:06', 0),
(1615130780112, 16151307801, 12, 0, NULL, '2021-03-07 15:26:20', '2021-03-07 15:26:20', 0),
(1615130795112, 16151307951, 12, 0, NULL, '2021-03-07 15:26:35', '2021-03-07 15:26:35', 0),
(1615131015114, 16151310151, 14, 0, NULL, '2021-03-21 07:40:13', '2021-03-21 07:40:13', 0),
(1615131559117, 16151315591, 17, 0, NULL, '2021-03-07 15:39:19', '2021-03-07 15:39:19', 0),
(1615131569117, 16151315691, 17, 0, NULL, '2021-03-07 15:39:29', '2021-03-07 15:39:29', 0),
(1615131579117, 16151315791, 17, 0, NULL, '2021-03-07 15:39:39', '2021-03-07 15:39:39', 0),
(1615131591117, 16151315911, 17, 0, NULL, '2021-03-07 15:39:51', '2021-03-07 15:39:51', 0),
(1615131611117, 16151316111, 17, 0, NULL, '2021-03-07 15:40:11', '2021-03-07 15:40:11', 0),
(1615131620117, 16151316201, 17, 0, NULL, '2021-03-07 15:40:20', '2021-03-07 15:40:20', 0),
(1615131630117, 16151316301, 17, 0, NULL, '2021-03-07 15:40:30', '2021-03-07 15:40:30', 0),
(1615131649117, 16151316491, 17, 0, NULL, '2021-03-07 15:40:49', '2021-03-07 15:40:49', 0),
(1615131662117, 16151316621, 17, 0, NULL, '2021-03-07 15:41:02', '2021-03-07 15:41:02', 0),
(1615131673117, 16151316731, 17, 0, NULL, '2021-03-07 15:41:13', '2021-03-07 15:41:13', 0),
(1615131684117, 16151316841, 17, 0, NULL, '2021-03-07 15:41:24', '2021-03-07 15:41:24', 0),
(1615131695117, 16151316951, 17, 0, NULL, '2021-03-07 15:41:35', '2021-03-07 15:41:35', 0),
(1615131706117, 16151317061, 17, 0, NULL, '2021-03-07 15:41:46', '2021-03-07 15:41:46', 0),
(1615131717117, 16151317171, 17, 0, NULL, '2021-03-07 15:41:57', '2021-03-07 15:41:57', 0),
(1615131734117, 16151317341, 17, 0, NULL, '2021-03-07 15:42:14', '2021-03-07 15:42:14', 0),
(1615131750117, 16151317501, 17, 0, NULL, '2021-03-07 15:42:30', '2021-03-07 15:42:30', 0),
(1615131760117, 16151317601, 17, 0, NULL, '2021-03-07 15:42:40', '2021-03-07 15:42:40', 0),
(1615131772117, 16151317721, 17, 0, NULL, '2021-03-07 15:42:52', '2021-03-07 15:42:52', 0),
(1615131783117, 16151317831, 17, 0, NULL, '2021-03-07 15:43:03', '2021-03-07 15:43:03', 0),
(1615131795117, 16151317951, 17, 0, NULL, '2021-03-07 15:43:15', '2021-03-07 15:43:15', 0),
(1615131805117, 16151318051, 17, 0, NULL, '2021-03-07 15:43:25', '2021-03-07 15:43:25', 0),
(1615131821117, 16151318211, 17, 0, NULL, '2021-03-07 15:43:41', '2021-03-07 15:43:41', 0),
(1615131838117, 16151318381, 17, 0, NULL, '2021-03-07 15:43:58', '2021-03-07 15:43:58', 0),
(1615131853117, 16151318531, 17, 0, NULL, '2021-03-07 15:44:13', '2021-03-07 15:44:13', 0),
(1615131866117, 16151318661, 17, 0, NULL, '2021-03-07 15:44:26', '2021-03-07 15:44:26', 0),
(1615131875117, 16151318751, 17, 0, NULL, '2021-03-07 15:44:35', '2021-03-07 15:44:35', 0),
(1615131890117, 16151318901, 17, 0, NULL, '2021-03-07 15:44:50', '2021-03-07 15:44:50', 0),
(1615131900117, 16151319001, 17, 0, NULL, '2021-03-07 15:45:00', '2021-03-07 15:45:00', 0),
(1615131909117, 16151319091, 17, 0, NULL, '2021-03-07 15:45:09', '2021-03-07 15:45:09', 0),
(1615131919117, 16151319191, 17, 0, NULL, '2021-03-07 15:45:19', '2021-03-07 15:45:19', 0),
(1615132016118, 16151320161, 18, 0, 'Penyusunan RKA- KL telah tersedia', '2021-03-07 15:46:56', '2021-03-30 03:39:55', 0),
(1615132046118, 16151320461, 18, 0, NULL, '2021-03-07 15:47:26', '2021-03-07 15:47:26', 0),
(1615132056118, 16151320561, 18, 0, NULL, '2021-03-07 15:47:36', '2021-03-07 15:47:36', 0),
(1615132071117, 16151320711, 17, 0, NULL, '2021-03-21 07:31:59', '2021-03-21 07:31:59', 0),
(1615132081118, 16151320811, 18, 0, NULL, '2021-03-07 15:48:01', '2021-03-07 15:48:01', 0),
(1615132092118, 16151320921, 18, 1, 'Pengisian website telah dilakukan secara berkala yaitu : realisasi anggaran,update profil,', '2021-03-07 15:48:12', '2021-03-08 01:38:48', 0),
(1615132208119, 16151322081, 19, 0, NULL, '2021-03-07 15:50:08', '2021-03-07 15:50:08', 0),
(1615132218119, 16151322181, 19, 0, NULL, '2021-03-07 15:50:18', '2021-03-07 15:50:18', 0),
(1615132239119, 16151322391, 19, 0, NULL, '2021-03-07 15:50:39', '2021-03-07 15:50:39', 0),
(1615132248119, 16151322481, 19, 0, NULL, '2021-03-07 15:50:48', '2021-03-07 15:50:48', 0),
(1615132256119, 16151322561, 19, 0, NULL, '2021-03-07 15:50:56', '2021-03-07 15:50:56', 0),
(1615132268119, 16151322681, 19, 0, NULL, '2021-03-07 15:51:08', '2021-03-07 15:51:08', 0),
(1615132286119, 16151322861, 19, 0, NULL, '2021-03-07 15:51:26', '2021-03-07 15:51:26', 0),
(1615132300119, 16151323001, 19, 0, NULL, '2021-03-07 15:51:40', '2021-03-07 15:51:40', 0),
(1615132313119, 16151323131, 19, 0, NULL, '2021-03-07 15:51:53', '2021-03-07 15:51:53', 0),
(1615132329119, 16151323291, 19, 0, NULL, '2021-03-07 15:52:09', '2021-03-07 15:52:09', 0),
(1615132342119, 16151323421, 19, 0, NULL, '2021-03-07 15:52:22', '2021-03-07 15:52:22', 0),
(1615132353119, 16151323531, 19, 0, NULL, '2021-03-07 15:52:33', '2021-03-07 15:52:33', 0),
(1615132362119, 16151323621, 19, 0, NULL, '2021-03-07 15:52:42', '2021-03-07 15:52:42', 0),
(1615132373119, 16151323731, 19, 0, NULL, '2021-03-07 15:52:53', '2021-03-07 15:52:53', 0),
(1615132388119, 16151323881, 19, 0, NULL, '2021-03-07 15:53:09', '2021-03-07 15:53:09', 0),
(1615132402119, 16151324021, 19, 0, NULL, '2021-03-07 15:53:22', '2021-03-07 15:53:22', 0),
(1615132412119, 16151324121, 19, 0, NULL, '2021-03-07 15:53:32', '2021-03-07 15:53:32', 0),
(1615132487110, 16151324871, 10, 0, NULL, '2021-03-21 07:08:47', '2021-03-21 07:08:47', 0),
(1615132487111, 16151324871, 11, 0, NULL, '2021-03-21 07:08:47', '2021-03-21 07:08:47', 0),
(1615132487112, 16151324871, 12, 0, NULL, '2021-03-21 07:08:47', '2021-03-21 07:08:47', 0),
(1615132487113, 16151324871, 13, 0, NULL, '2021-03-21 07:08:47', '2021-03-21 07:08:47', 0),
(1615132497115, 16151324971, 15, 0, NULL, '2021-03-07 15:54:57', '2021-03-07 15:54:57', 0),
(1615132513115, 16151325131, 15, 0, NULL, '2021-03-07 15:55:13', '2021-03-07 15:55:13', 0),
(1615132526115, 16151325261, 15, 0, NULL, '2021-03-07 15:55:26', '2021-03-07 15:55:26', 0),
(1615132584116, 16151325841, 16, 0, NULL, '2021-03-07 15:56:24', '2021-03-07 15:56:24', 0),
(1615132598116, 16151325981, 16, 0, NULL, '2021-03-07 15:56:38', '2021-03-07 15:56:38', 0),
(1615132630116, 16151326301, 16, 0, NULL, '2021-03-07 15:57:10', '2021-03-07 15:57:10', 0),
(1615132643116, 16151326431, 16, 0, NULL, '2021-03-07 15:57:23', '2021-03-07 15:57:23', 0),
(1615261161318, 16152611613, 18, 1, 'Kamar mandi PTIP kotor dan tidak dibersihkan secara rutin', '2021-03-09 03:39:21', '2021-03-09 03:40:23', 0),
(1616459759310, 16164597593, 10, 0, NULL, '2021-03-23 00:35:59', '2021-03-23 00:35:59', 0),
(1617713062310, 16177130623, 10, 0, NULL, NULL, NULL, 0),
(1617713062311, 16177130623, 11, 0, NULL, NULL, NULL, 0),
(1617713062312, 16177130623, 12, 0, 'Pengelolaan surat masuk/keluar telah dilaksanakan melalui aplikasi PTSP', NULL, '2021-05-03 03:29:45', 0),
(1617713062313, 16177130623, 13, 0, NULL, NULL, NULL, 0),
(1617713062314, 16177130623, 14, 0, NULL, NULL, NULL, 0),
(1617713062317, 16177130623, 17, 0, NULL, NULL, NULL, 0),
(1617713062318, 16177130623, 18, 0, NULL, NULL, NULL, 0),
(1617713062319, 16177130623, 19, 0, NULL, NULL, NULL, 0),
(1617713063310, 16177130633, 10, 0, NULL, NULL, NULL, 0),
(1617713064310, 16177130643, 10, 0, NULL, NULL, NULL, 0),
(1617713064311, 16177130643, 11, 0, NULL, NULL, NULL, 0),
(1617713064312, 16177130643, 12, 0, NULL, NULL, NULL, 0),
(1617713064313, 16177130643, 13, 0, NULL, NULL, NULL, 0),
(1617713065310, 16177130653, 10, 0, NULL, NULL, NULL, 0),
(1617713065314, 16177130653, 14, 0, NULL, NULL, NULL, 0),
(1617713066310, 16177130663, 10, 0, NULL, NULL, NULL, 0),
(1617713067310, 16177130673, 10, 0, NULL, NULL, NULL, 0),
(1617713068310, 16177130683, 10, 0, NULL, NULL, NULL, 0),
(1617713069317, 16177130693, 17, 0, NULL, NULL, NULL, 0),
(1617713070310, 16177130703, 10, 0, NULL, NULL, NULL, 0),
(1617713071310, 16177130713, 10, 0, NULL, NULL, NULL, 0),
(1617713071311, 16177130713, 11, 0, NULL, NULL, NULL, 0),
(1617713071312, 16177130713, 12, 0, NULL, NULL, NULL, 0),
(1617713071313, 16177130713, 13, 0, NULL, NULL, NULL, 0),
(1617713071314, 16177130713, 14, 0, NULL, NULL, NULL, 0),
(1617713071315, 16177130713, 15, 0, NULL, NULL, NULL, 0),
(1617713071317, 16177130713, 17, 0, NULL, NULL, NULL, 0),
(1617713071318, 16177130713, 18, 0, NULL, NULL, NULL, 0),
(1617713071319, 16177130713, 19, 0, NULL, NULL, NULL, 0),
(1617713072310, 16177130723, 10, 0, NULL, NULL, NULL, 0),
(1617713073314, 16177130733, 14, 1, 'prosedur tata kelola arsip  sudah menggunakan aplikasi SIPP, dan penataan arsip sesuai dengan aplikasi SIPP namun belum ada jadwal perawatan arsip setiap bulan nya', NULL, '2021-05-03 06:48:45', 0),
(1617713074314, 16177130743, 14, 1, 'peminjaman arsip telah sesuai dengan prosedur dan diketahui oleh pimpinan', NULL, '2021-05-03 06:52:03', 0),
(1617713075314, 16177130753, 14, 1, 'telah melaksanakan pelaporan perkara dan posbakum setiap bulan kepada Ditjen BAdilum melalui aplikasi', NULL, '2021-05-03 06:21:15', 0),
(1617713076314, 16177130763, 14, 1, 'Telah melakukan monitoring dan evaluasi kinerja posbakum', NULL, '2021-05-03 06:26:52', 0),
(1617713076317, 16177130763, 17, 0, NULL, NULL, NULL, 0),
(1617713077314, 16177130773, 14, 1, 'posbakum telah dilengkapi dengan MoU/SPK, dan pelaporan (lengkap dengan absensi dan buku tamu)', NULL, '2021-05-03 06:37:43', 0),
(1617713078314, 16177130783, 14, 1, 'sudah melakukan monitoring pada informasi dan pengaduan', NULL, '2021-05-03 06:40:09', 0),
(1617713079310, 16177130793, 10, 0, NULL, NULL, NULL, 0),
(1617713079311, 16177130793, 11, 0, NULL, NULL, NULL, 0),
(1617713079312, 16177130793, 12, 0, NULL, NULL, NULL, 0),
(1617713079313, 16177130793, 13, 0, NULL, NULL, NULL, 0),
(1617713080314, 16177130803, 14, 1, 'sudah membuat laporan IKM dan IPK', NULL, '2021-05-03 06:44:31', 0),
(1617713081314, 16177130813, 14, 1, 'sudah membuat statistik perkara bulanan dan tahunan', NULL, '2021-05-03 06:54:03', 0),
(1617713082311, 16177130823, 11, 1, '-	Ada 6 (Enam) Berkas Perkara Banding yang dikirim bulan April 2021 yaitu   Nomor : \r\n1)	128/Pdt.G/2020/PN Kdi. Tanggal 7 April 2021;\r\n2)	100/Pdt.G/2020/PN Kdi. Tanggal 7 April 2021;\r\n3)	103/Pdt.G/2020/PN Kdi. Tanggal 19 April 2021;\r\n4)	108/Pdt.G/2020/PN Kdi. Tanggal 21 April 2021;\r\n5)	97/Pdt.G/2020/PN Kdi. Tanggal 22 April 2021;\r\n6)	124/Pdt.G/2020/PN Kdi. Tanggal 28 April 2021;', NULL, '2021-05-03 05:52:32', 0),
(1617713083311, 16177130833, 11, 1, '-	Ada 1 (Satu) Berkas Kasasi yang sudah dikirim Bulan April 2021 yaitu Nomor : \r\n1)	78/Pdt.G/2020/PN Kdi. Tanggal 29 April 2021', NULL, '2021-05-03 05:56:14', 0),
(1617713084311, 16177130843, 11, 0, NULL, NULL, NULL, 0),
(1617713085311, 16177130853, 11, 0, NULL, NULL, NULL, 0),
(1617713086311, 16177130863, 11, 0, NULL, NULL, NULL, 0),
(1617713087311, 16177130873, 11, 0, NULL, NULL, NULL, 0),
(1617713088311, 16177130883, 11, 0, NULL, NULL, NULL, 0),
(1617713089313, 16177130893, 13, 0, NULL, NULL, NULL, 0),
(1617713090312, 16177130903, 12, 1, 'Penginputan data pada komdanas telah dilakukan secara tertib paling lambat tanggal 5 setiap bulannya', NULL, '2021-05-04 06:05:48', 0),
(1617713091312, 16177130913, 12, 1, 'Laporan permohonan eksekusi pada periode april nihill', NULL, '2021-05-04 06:07:31', 0),
(1617713092312, 16177130923, 12, 1, 'Perkara PHI yang penanganannya melebihi 50 Hari Kerja No. 1 /Pdt.Sus-PHI/2021/ PN Kdi telah dilaporkan ke pimpinan (Wakil Ketua PN Kdi)', NULL, '2021-05-04 06:12:35', 0),
(1617713093314, 16177130933, 14, 0, NULL, NULL, NULL, 0),
(1617713094317, 16177130943, 17, 0, NULL, NULL, NULL, 0),
(1617713095317, 16177130953, 17, 0, NULL, NULL, NULL, 0),
(1617713096317, 16177130963, 17, 0, NULL, NULL, NULL, 0),
(1617713097317, 16177130973, 17, 0, NULL, NULL, NULL, 0),
(1617713098317, 16177130983, 17, 0, NULL, NULL, NULL, 0),
(1617713099317, 16177130993, 17, 0, NULL, NULL, NULL, 0),
(1617713100317, 16177131003, 17, 0, NULL, NULL, NULL, 0),
(1617713101317, 16177131013, 17, 0, 'ya,sudah dilaksanakan pengelolaan rumah dinas serta penunjukan rumah dinas dan pembayaran PBB', NULL, '2021-04-30 06:48:13', 0),
(1617713102317, 16177131023, 17, 0, NULL, NULL, NULL, 0),
(1617713103317, 16177131033, 17, 0, NULL, NULL, NULL, 0),
(1617713104317, 16177131043, 17, 0, 'Jalur evakuasi dan titik kumpul telah tersedia serta peralatan proteksi APAR', NULL, '2021-05-03 03:29:14', 0),
(1617713105317, 16177131053, 17, 0, NULL, NULL, NULL, 0),
(1617713107317, 16177131073, 17, 0, NULL, NULL, NULL, 0),
(1617713108317, 16177131083, 17, 0, NULL, NULL, NULL, 0),
(1617713109317, 16177131093, 17, 0, NULL, NULL, NULL, 0),
(1617713110317, 16177131103, 17, 0, NULL, NULL, NULL, 0),
(1617713111317, 16177131113, 17, 0, NULL, NULL, NULL, 0),
(1617713112317, 16177131123, 17, 0, NULL, NULL, NULL, 0),
(1617713113317, 16177131133, 17, 0, NULL, NULL, NULL, 0),
(1617713114317, 16177131143, 17, 0, NULL, NULL, NULL, 0),
(1617713115317, 16177131153, 17, 0, NULL, NULL, NULL, 0),
(1617713116317, 16177131163, 17, 0, 'SK KPA ,SK Pejabat Pembuat Komitmen,SK bendahara pengeluaran/ bendahara pemegang uang muka ,Bendahara penerima, SK Pembantu Pengelola Keuangan telah diperbaharui TA 2021', NULL, '2021-05-03 02:50:30', 0),
(1617713117317, 16177131173, 17, 0, NULL, NULL, NULL, 0),
(1617713118317, 16177131183, 17, 0, NULL, NULL, NULL, 0),
(1617713119317, 16177131193, 17, 0, NULL, NULL, NULL, 0),
(1617713120317, 16177131203, 17, 0, NULL, NULL, NULL, 0),
(1617713121317, 16177131213, 17, 0, NULL, NULL, NULL, 0),
(1617713122317, 16177131223, 17, 0, NULL, NULL, NULL, 0),
(1617713123318, 16177131233, 18, 1, 'Penyusunan RAB dan TOR TA telah dilaksanakan dan dikirim ke Pengadilan Tinggi Sulawesi Tenggara', NULL, '2021-05-03 04:56:11', 0),
(1617713124318, 16177131243, 18, 1, 'Penyusunan dokumen SAKIP telah dilaksanakan dan dikirim ke Pengadilan Tinggi Sultra,sedangkan pengisian capaian kinerja bulanan telah dilaksanakan melalui aplikasi komdanas', NULL, '2021-05-03 04:57:45', 0),
(1617713125318, 16177131253, 18, 1, 'Perawatan dan Pengelolaan Sistim IT dilakukan secara rutin 4 bulan sekali', NULL, '2021-05-03 04:58:32', 0),
(1617713126317, 16177131263, 17, 0, NULL, NULL, NULL, 0),
(1617713127318, 16177131273, 18, 1, 'Backup data dan sinkronisasi SIPP dilakukuan setiap hari kerja minimal 1x dalam sehari', NULL, '2021-05-03 05:00:35', 0),
(1617713128318, 16177131283, 18, 1, 'Konten-konten pada website telah diperbaharui secara berkala dan terus dilakukukan perbaikan untuk menambah informasi pada website', NULL, '2021-05-03 04:54:58', 0),
(1617713129319, 16177131293, 19, 0, 'Telah dilaksanakan dengan baik sesuai SK KPN Kendari', NULL, '2021-04-30 06:36:08', 0),
(1617713130319, 16177131303, 19, 0, 'Masih ada hakim dan pegawai yang tidak mengisi presensi secara online melalui aplikasi SIKEP', NULL, '2021-04-30 06:38:10', 0),
(1617713131319, 16177131313, 19, 0, NULL, NULL, NULL, 0),
(1617713132319, 16177131323, 19, 0, NULL, NULL, NULL, 0),
(1617713133319, 16177131333, 19, 0, NULL, NULL, NULL, 0),
(1617713134319, 16177131343, 19, 0, NULL, NULL, NULL, 0),
(1617713135319, 16177131353, 19, 0, NULL, NULL, NULL, 0),
(1617713136319, 16177131363, 19, 0, NULL, NULL, NULL, 0),
(1617713137319, 16177131373, 19, 0, NULL, NULL, NULL, 0),
(1617713138319, 16177131383, 19, 0, NULL, NULL, NULL, 0),
(1617713139319, 16177131393, 19, 0, NULL, NULL, NULL, 0),
(1617713140319, 16177131403, 19, 0, NULL, NULL, NULL, 0),
(1617713141319, 16177131413, 19, 0, NULL, NULL, NULL, 0),
(1617713142319, 16177131423, 19, 0, NULL, NULL, NULL, 0),
(1617713143319, 16177131433, 19, 0, NULL, NULL, NULL, 0),
(1617713144319, 16177131443, 19, 0, NULL, NULL, NULL, 0),
(1617713145319, 16177131453, 19, 0, NULL, NULL, NULL, 0),
(1617713146310, 16177131463, 10, 0, NULL, NULL, NULL, 0),
(1617713146311, 16177131463, 11, 0, NULL, NULL, NULL, 0),
(1617713146312, 16177131463, 12, 0, NULL, NULL, NULL, 0),
(1617713146313, 16177131463, 13, 0, NULL, NULL, NULL, 0),
(1617713147315, 16177131473, 15, 0, NULL, NULL, NULL, 0),
(1617713148315, 16177131483, 15, 0, NULL, NULL, NULL, 0),
(1617713149315, 16177131493, 15, 0, NULL, NULL, NULL, 0),
(1617713150316, 16177131503, 16, 0, NULL, NULL, NULL, 0),
(1617713151316, 16177131513, 16, 0, NULL, NULL, NULL, 0),
(1617713152316, 16177131523, 16, 0, NULL, NULL, NULL, 0),
(1617713153316, 16177131533, 16, 0, NULL, NULL, NULL, 0),
(1617713154318, 16177131543, 18, 1, 'Sarana dan Prasarana IT terpelihara dengan baik,dilakukan perawatan secara berkala', NULL, '2021-05-03 04:59:37', 0),
(1617713155310, 16177131553, 10, 0, NULL, NULL, NULL, 0),
(1620092709318, 16200927093, 18, 1, '- Hasil pengecekan SIPP Tgl 30 April 2021 masuk 98 perkara, minutasi 108 pekara dan sisa 151 perkara \r\n- Masih ada Tunggakan pengisian berita acara sidang\r\n- Masih ada berkas perkara yang telah diminutasi tetapi belum diserahkan ke bagian hukum untuk diarsipkan', '2021-05-04 01:45:09', '2021-05-04 02:50:11', 0),
(1620092772318, 16200927723, 18, 1, '- Peringkat SIPP Pengadilan Negeri/PHI/Tipikor Kendari Kelas IA untuk bulan April 2021 adalah 47 dari 182 satker ;\r\n- Peringkat hasil evaluasi SIPP Pengadilan Negeri/PHI/Tipikor Kendari Kelas IA untuk kategori perkara 501 s/d 100 adalah peringkat 3;\r\n- Peringkat 1 untuk pengadilan Negeri dalam wilayah provinsi Sulawesi Tenggara\r\n- total nilai hasil evaluasi SIPP pertanggal 30 April 2021 adalah 934, 19 Poin\r\nTemuan.\r\nMasih ada item hasil penilaian evaluasi SIPP yang belum mendapatkan nilai sempurna', '2021-05-04 01:46:12', '2021-05-04 03:02:16', 0),
(1620092865318, 16200928653, 18, 1, '- Penggunaan aplikasi PTSP bulan April surat masuk 303 dan surat keluar 325\r\n- Penggunaan aplikasi Era Terang periode bulan April adalah sejumlah 4 permohonan\r\n- Penggunaan aplikasi E-Court periode bulan April adalah sejumlah 19 perkara dengan rincian 6 perkara gugatan dan 13 \r\n   perkara permohonan', '2021-05-04 01:47:45', '2021-05-04 04:07:04', 0),
(1620106876318, 16201068763, 18, 0, NULL, '2021-05-04 05:41:16', '2021-05-04 05:41:16', 0),
(1620107014311, 16201070143, 11, 0, NULL, '2021-05-04 05:43:34', '2021-05-04 05:43:34', 0),
(1620107434312, 16201074343, 12, 1, 'Implementasi 5 R telah dilaksanakan dengan baik', '2021-05-04 05:50:35', '2021-05-04 06:09:53', 0),
(1620107458313, 16201074583, 13, 0, NULL, '2021-05-04 05:50:58', '2021-05-04 05:50:58', 0),
(1620107481314, 16201074813, 14, 0, NULL, '2021-05-04 05:51:21', '2021-05-04 05:51:21', 0),
(1620109022312, 16201090223, 12, 0, 'Berkas Perkara Kasasi No. 20 dan 21/Pdt.Sus-PHI/2020/PN Kdi belum bisa dikirim ke MA karena menunggu relaas pemberitahuan penyerahan kontra memori kasasi yang belum dikirim ulang oleh JS PN Makassar', '2021-05-04 06:17:02', '2021-05-04 06:18:57', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_09_24_082734_create_list_animes_table', 1),
(4, '2019_09_24_083632_create_musics_table', 1),
(5, '2019_09_24_084150_create_walpapers_table', 1),
(6, '2021_02_22_100626_create_sectors_table', 2),
(7, '2021_02_22_100706_create_user_levels_table', 2),
(8, '2021_02_22_105649_create_user_level_groups_table', 3),
(10, '2021_02_24_003631_create_secretariats_table', 4),
(13, '2021_03_04_230912_create_indikator_sectors_table', 5),
(14, '2021_03_04_232255_delete_some_column_from_secretariats', 5),
(15, '2021_03_10_073133_add_sector_id_to_secretariats_table', 6),
(16, '2021_03_10_093952_add_foto_id_to_users_table', 6),
(17, '2021_03_13_072707_add_status_tindakan_to_indikator_sectors_table', 6),
(18, '2021_03_15_062614_add_base_color_to_sectors_table', 6),
(19, '2021_03_19_020240_create_performa_sectors_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `performa_sectors`
--

CREATE TABLE `performa_sectors` (
  `periode_bulan` enum('01','02','03','04','05','06','07','08','09','10','11','12') COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_tahun` smallint(5) UNSIGNED NOT NULL,
  `sector_id` tinyint(3) UNSIGNED NOT NULL,
  `total_bidang` smallint(5) UNSIGNED NOT NULL,
  `total_bidang_success` smallint(5) UNSIGNED NOT NULL,
  `total_tindak_lanjut` smallint(5) UNSIGNED NOT NULL,
  `total_tindak_lanjut_success` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `performa_sectors`
--

INSERT INTO `performa_sectors` (`periode_bulan`, `periode_tahun`, `sector_id`, `total_bidang`, `total_bidang_success`, `total_tindak_lanjut`, `total_tindak_lanjut_success`, `created_at`, `updated_at`) VALUES
('03', 2021, 14, 17, 0, 0, 0, NULL, NULL),
('03', 2021, 16, 4, 0, 0, 0, NULL, NULL),
('03', 2021, 19, 18, 0, 0, 0, NULL, NULL),
('03', 2021, 11, 7, 0, 0, 0, NULL, NULL),
('03', 2021, 12, 3, 0, 0, 0, NULL, NULL),
('03', 2021, 10, 9, 0, 0, 0, NULL, NULL),
('03', 2021, 15, 7, 0, 0, 0, NULL, NULL),
('03', 2021, 18, 6, 2, 4, 0, NULL, NULL),
('03', 2021, 13, 2, 0, 0, 0, NULL, NULL),
('03', 2021, 17, 54, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `secretariats`
--

CREATE TABLE `secretariats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `indikator` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_level_id` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `periode_tahun` smallint(5) UNSIGNED NOT NULL,
  `periode_bulan` enum('01','02','03','04','05','06','07','08','09','10','11','12') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `secretariats`
--

INSERT INTO `secretariats` (`id`, `indikator`, `user_level_id`, `created_at`, `updated_at`, `periode_tahun`, `periode_bulan`, `sector_id`) VALUES
(16151298351, 'Pencatatan surat masuk/keluar menggunakan aplikasi dan terdistribusi tepat waktu', 10, '2021-03-07 15:10:35', '2021-03-21 07:33:51', 2021, '03', 17),
(16151298591, 'Pengisian SIPP register pidana,dakwaan,barang bukti terisi lengkap dan tepat waktu', 10, '2021-03-07 15:10:59', '2021-03-21 07:40:55', 2021, '03', 10),
(16151298721, 'Pemberkasan Arsip Perkara yang telah diminutasi  terdapat checlist kelengkapan berkas, court calender dan terjilid rapi', 10, '2021-03-07 15:11:12', '2021-03-21 07:35:09', 2021, '03', 14),
(16151298911, '\"Penyerahan berkas perkara inactive dari Panmud Pidana kepada Panmud Hukum harus dengan Berita Acara Serah Terima Berkas ( dalam jangka waktu 3 hari setelah BHT )\"', 10, '2021-03-07 15:11:31', '2021-03-18 08:18:51', 2021, '03', 10),
(16151299051, 'Pengiriman Berkas Banding ke PT tenggang waktu 14 hari dan telah terinput di SIPP', 10, '2021-03-07 15:11:45', '2021-03-21 07:47:00', 2021, '03', 10),
(16151299371, 'Permohonan kasasi yang telah memenuhi syarat formal selambat lambatnya dalam waktu 14 hari setelah tenggang waktu mengajukan memori kasasi berakhir, berkas kasasi harus sudah dikirim ke Mahkamah Agung (Buku II), telah terinput pada SIPP dan telah menggunakan barcode', 10, '2021-03-07 15:12:17', '2021-03-21 07:51:26', 2021, '03', 10),
(16151299491, 'Pengiriman Berkas Kasasi selambat-lambatnya dalam waktu 30 hari, telah terinput di SIPP dan menggunakan sistem barcode', 10, '2021-03-07 15:12:29', '2021-03-21 07:46:02', 2021, '03', 10),
(16151299601, 'Implementasi 5R (RINGKAS,Rapi,Resik,Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-03-07 15:12:40', '2021-05-04 05:47:52', 2021, '04', 19),
(16151299711, 'Pelaksanaan Diversi telah diinput pada SIPP secara lengkap dan tepat waktu', 10, '2021-03-07 15:12:51', '2021-03-18 08:23:14', 2021, '03', 10),
(16151299841, 'Ketersediaan sarana dan prasarana pendukung telah terpenuhi dan berfungsi dengan baik', 10, '2021-03-07 15:13:04', '2021-03-21 07:26:34', 2021, '03', 17),
(16151299951, 'Perkara pidana yang diselesaikan kurang dari 5 bulan, dan yang melebihi 5 bulan telah dilaporkan kepada pimpinan dan pt', 10, '2021-03-07 15:13:15', '2021-03-21 07:49:54', 2021, '03', 10),
(16151300641, 'Prosedur tata kelola arsip sudah menggunakan aplikasi SIPP, penataan berkas sesuai penataan aplikasi SIPP, dan jadwal perawatan arsip', 10, '2021-03-07 15:14:24', '2021-03-21 07:57:32', 2021, '03', 14),
(16151300771, 'Prosedur Peminjaman Berkas telah tercatat dan diketahui oleh Pimpinan serta memiliki batas waktu peminjaman', 10, '2021-03-07 15:14:37', '2021-03-21 07:55:37', 2021, '03', 14),
(16151300871, 'Melakukan pelaporan perkara dan posbakum setiap bulan kepada DitJen Badilum melalui aplikasi', 10, '2021-03-07 15:14:47', '2021-03-21 07:28:07', 2021, '03', 14),
(16151300961, 'Melakukan monitoring dan evaluasi kinerja posbakum', 10, '2021-03-07 15:14:56', '2021-03-18 08:26:28', 2021, '03', 14),
(16151301081, 'Posbakum telah dilengkapi dengan MoU/SPK, dan pelaporan(lengkap dengan absensi, buku tamu)', 10, '2021-03-07 15:15:08', '2021-03-21 07:52:05', 2021, '03', 14),
(16151301191, 'Telah dilakukan monitoring pada informasi dan pengaduan', 10, '2021-03-07 15:15:19', '2021-03-21 07:54:26', 2021, '03', 14),
(16151301311, '\"Penyerahan berkas perkara inactive dari Panmud Pidana,Perdata,PHI,Tipikor kepada Panmud Hukum harus dengan Berita Acara Serah Terima Berkas ( dalam jangka waktu 3 hari setelah BHT ) dan telah di input pada SIPP\"', 10, '2021-03-07 15:15:31', '2021-03-18 08:19:52', 2021, '03', 14),
(16151301431, 'Telah dibuat laporan IKM dan IPK', 10, '2021-03-07 15:15:43', '2021-03-21 07:54:59', 2021, '03', 14),
(16151301531, 'Telah membuat statistik perkara bulanan dan tahunan', 10, '2021-03-07 15:15:53', '2021-03-21 08:00:53', 2021, '03', 14),
(16151303141, 'Pengiriman Berkas Banding ke PT tenggang waktu 30 hari dan telah terinput di SIPP', 10, '2021-03-07 15:18:34', '2021-03-21 07:46:21', 2021, '03', 11),
(16151303381, 'Pengiriman Berkas PK selambat-lambatnya dalam waktu 30 hari, telah terinput di SIPP dan menggunakan sistem barcode', 10, '2021-03-07 15:18:58', '2021-03-21 07:45:00', 2021, '03', 11),
(16151304051, 'Penginputan data sudah dilakukan secara tertib dan dilaporkan setiap bulan sebelum tanggal 5 pada aplikasi KOMDANAS', 10, '2021-03-07 15:20:05', '2021-03-21 07:46:39', 2021, '03', 11),
(16151304221, 'Surat Kuasa Untuk Membayar (SKUM) telah tercatat dan di beri nomor', 10, '2021-03-07 15:20:22', '2021-03-21 07:56:27', 2021, '03', 11),
(16151304441, 'Perkara yang telah berhasil Mediasi telah dilaporkan ke Badilum dan diinput pada SIPP', 10, '2021-03-07 15:20:44', '2021-03-21 07:50:19', 2021, '03', 11),
(16151304551, 'Penginputan permohonan eksekusi telah dinput di SIPP dan buku register', 10, '2021-03-07 15:20:55', '2021-03-21 07:47:24', 2021, '03', 11),
(16151304671, 'Perkara perdata diselesaikan kurang dari 5 bulan, dan yang melebihi 5 bulan telah dilaporkan kepada pimpinan dan PT', 10, '2021-03-07 15:21:07', '2021-03-21 07:49:27', 2021, '03', 11),
(16151305611, 'Pengisian SIPP register pidana khusus, dakwaan, barang bukti terisi lengkap dan tepat waktu', 10, '2021-03-07 15:22:41', '2021-03-21 07:44:17', 2021, '03', 13),
(16151307611, 'Penginputan data sudah dilakukan secara tertib dan dilaporkan setiap bulan sebelum tanggal 5 pada aplikasi KOMDANAS', 10, '2021-03-07 15:26:01', '2021-03-21 07:42:05', 2021, '03', 12),
(16151307801, 'Penginputan permohonan eksekusi telah diinput di SIPP dan buku register', 10, '2021-03-07 15:26:20', '2021-03-21 07:42:38', 2021, '03', 12),
(16151307951, 'Perkara PHI diselesaikan kurang dari 50 hari kerja, dan yang melebihi telah dilaporkan kepada pimpinan', 10, '2021-03-07 15:26:35', '2021-03-21 07:49:41', 2021, '03', 12),
(16151310151, 'Penyerahan berkas perkara inactive dari Panmud Pidana kepada Panmud Hukum harus dengan Berita Acara Serah Terima Berkas (dalam jangka waktu 3 hari setelah BHT)', 10, '2021-03-07 15:30:15', '2021-03-21 07:40:13', 2021, '03', 13),
(16151315591, 'SK Pengelola BMN dan Laporan inventaris barang milik negara (SIMAK BMN) telah diupdate,dilaksanakan dan dilaporkan', 10, '2021-03-07 15:39:19', '2021-03-21 07:58:44', 2021, '03', 17),
(16151315691, 'Pencatatan Aset  lainnya,SK Tim Penilai dan Pengelola Aset', 10, '2021-03-07 15:39:29', '2021-03-21 07:34:42', 2021, '03', 17),
(16151315791, 'Telah mengisi Laporan Pengawasan dan Pengendalian (WASDAL) BMN pada aplikasi Sistem Informasi Manajemen Aset Negara (SIMAN) dan terdokumentasi dengan baik', 10, '2021-03-07 15:39:39', '2021-03-21 08:00:36', 2021, '03', 17),
(16151315911, 'Penginputan Aset Tetap, Kesesuaian jumlah dan harga barang yang diinput pada SIMAK BMN saat pembelian', 10, '2021-03-07 15:39:51', '2021-03-21 07:37:50', 2021, '03', 17),
(16151316111, 'Penatausahaan Barang Persediaan, Kesesuaian jumlah dan harga barang yang diinput pada aplikasi persediaan saat pembelian, Membuat Stok Opname Fisik setiap bulan', 10, '2021-03-07 15:40:11', '2021-03-21 07:37:18', 2021, '03', 17),
(16151316201, 'Pendistribusian barang tercatat dengan baik', 10, '2021-03-07 15:40:20', '2021-03-21 07:35:23', 2021, '03', 17),
(16151316301, 'Penunjukan Penggunaan Kendaraan Dinas telah sesuai PMK 76/PMK.06/2015 serta perawatan Kendaraan Dinas terdapat kartu kendali,anggaran tidak melebihi sbu, Pembayaran Pajak Kendaraan tepat waktu', 10, '2021-03-07 15:40:30', '2021-03-21 07:40:30', 2021, '03', 17),
(16151316491, 'Pengelolaan Rumah Dinas,Penunjukan Penggunaan Rumah Dinas dan pembayaran PBB', 10, '2021-03-07 15:40:49', '2021-03-21 07:36:07', 2021, '03', 17),
(16151316621, 'Labelisasi barang milik negara telah dilaksanakan dan diupdate', 10, '2021-03-07 15:41:02', '2021-03-21 07:25:30', 2021, '03', 17),
(16151316731, 'Daftar barang ruangan telah diperbaharui', 10, '2021-03-07 15:41:13', '2021-03-21 07:20:48', 2021, '03', 17),
(16151316841, 'Pengaturan lahan parkir kendaraan telah tertata dengan baik, dipisahkan antara karyawan/tamu dan dalam pengawasan petugas keamanan', 10, '2021-03-07 15:41:24', '2021-03-07 15:41:24', 2021, '03', NULL),
(16151316951, 'Tersedianya jalur evakuasi dan titik kumpul serta peralatan proteksi bahaya kebakaran (APAR)', 10, '2021-03-07 15:41:35', '2021-03-18 08:27:05', 2021, '03', 17),
(16151317061, 'Jalan masuk gedung pengadilan (terkait dengan sterilisasi)', 10, '2021-03-07 15:41:46', '2021-03-18 08:21:48', 2021, '03', 17),
(16151317171, 'Tersedianya fasilitas untuk penyandang difabel', 10, '2021-03-07 15:41:57', '2021-03-21 08:00:24', 2021, '03', 17),
(16151317341, '\"Tersedia informasi tentang : \r\n- Visi dan Misi,\r\n- Papan daftar nama hakim, \r\n- Papan daftar nama mediator, \r\n- alur perkara, \r\n- alur pengajuan dan penanganan layanan bantuan hukum, \r\n- gugatan sederhana, dan \r\n- informasi panjar biaya perkara, \"', 10, '2021-03-07 15:42:14', '2021-03-21 07:07:33', 2021, '03', 17),
(16151317501, 'Kebersihan lingkungan pengadilan terjaga dan terawat dengan baik ( Ruang Persidangan,ruang tunggu, ruang tahanan dan Fasilitas umum lainnya)', 10, '2021-03-07 15:42:30', '2021-03-21 07:21:46', 2021, '03', 17),
(16151317601, 'Pemeliharaan sarana dan prasarana pendukung kerja  (perlengkapan persidangan,genset,AC,Maubiler dll)', 10, '2021-03-07 15:42:40', '2021-03-21 07:32:59', 2021, '03', 17),
(16151317721, 'Penempatan CCTV telah sesuai, perawatan dilakukan secara berkala dan berfungsi dengan baik', 10, '2021-03-07 15:42:52', '2021-03-21 07:35:40', 2021, '03', 17),
(16151317831, 'Petugas keamanan telah menerapkan 3S dan menggunakan peralatan keamanan', 10, '2021-03-07 15:43:03', '2021-03-21 07:52:38', 2021, '03', 17),
(16151317951, 'Nilai Kapitalisasi Barang Milik Negara (BMN), Belanja diatas nilai kapitalisasi menggunakan Anggaran Belanja Modal dan diinput ke dalam aplikasi SIMAK', 10, '2021-03-07 15:43:15', '2021-03-18 08:23:43', 2021, '03', 17),
(16151318051, 'Pelaksanaan Perjalanan Dinas sesuai dengan tupoksi dan terdokumentasi dengan baik', 10, '2021-03-07 15:43:25', '2021-03-21 07:31:25', 2021, '03', 19),
(16151318211, 'Implementasi aplikasi SMART', 10, '2021-03-07 15:43:41', '2021-03-18 08:20:54', 2021, '03', 17),
(16151318381, 'Kesesuaian Pengisian Buku-buku keuangan dengan bukti-bukti yang ada\r\na.  Buku kas umum (dilengkapi dengan LPJ/akhir bulan)\r\nb.  Buku bank\r\nc.  Buku bantu (Pengawasan kredit, uang persediaan, SPM dan penyetoran pajak PPH Pasal 21, 22 dan 23)', 10, '2021-03-07 15:43:58', '2021-03-08 02:57:38', 2021, '03', NULL),
(16151318531, '\"SK manajemen pengelolaan keuangan telah diperbaharui : \r\n- SK KPA \r\n-SK Pejabat Pembuat Komitmen\r\n- SK bendahara pengeluaran/ bendahara pemegang uang muka \r\n- Bendahara penerima, \r\n- SK Pembantu Pengelola Keuangan\"', 10, '2021-03-07 15:44:13', '2021-03-21 07:06:54', 2021, '03', 17),
(16151318661, 'Dokumen pertanggung jawaban telah disimpan dan diarsipkan', 10, '2021-03-07 15:44:26', '2021-03-21 07:24:10', 2021, '03', 17),
(16151318751, 'Kesesuaian antara Data dan Barang Persediaan  Dipa 01 dan Dipa 03', 10, '2021-03-07 15:44:35', '2021-03-21 07:24:34', 2021, '03', 17),
(16151318901, 'Prosedur Pendistribusian Barang (Berita Acara Serah Terima Barang dan Tanda Terima Barang)', 10, '2021-03-07 15:44:50', '2021-03-21 07:56:44', 2021, '03', 17),
(16151319001, 'Monitoring uang persediaan di brankas bendahara oleh KPA setiap bulan', 10, '2021-03-07 15:45:00', '2021-03-21 07:27:20', 2021, '03', 17),
(16151319091, 'Satker sudah menginput aplikasi monev PP 39 Tahun 2006 dari Bapenas setiap triwulan', 10, '2021-03-07 15:45:09', '2021-03-21 07:59:36', 2021, '03', 17),
(16151319191, 'Satker telah melakukan Rekon internal antara aplikasi SIMAK, BMN, SAIBA dan KOMDANAS setiap bulannya dengan membuat berita acara Rekon internal (mengetahui : operator SAIBA, operator, SIMAK, BMN dan KPA)', 10, '2021-03-07 15:45:19', '2021-03-21 07:59:52', 2021, '03', 17),
(16151320161, 'Penyusunan RKAK/L telah tersedia RAB,TOR dan data perkara', 10, '2021-03-07 15:46:56', '2021-03-21 07:48:41', 2021, '03', 18),
(16151320461, 'Penyusunan Dokumen SAKIP telah lengkap dan sesuai, serta melibatkan seluruh pimpinan dan seluruh pegawai', 10, '2021-03-07 15:47:26', '2021-03-21 07:47:47', 2021, '03', 18),
(16151320561, 'Perawatan dan Pengelolaan sistem TI di pengadilan telah dilakukan secara rutin dan memiliki kartu kontrol', 10, '2021-03-07 15:47:36', '2021-03-21 07:49:01', 2021, '03', 18),
(16151320711, 'Pelaporan Keuangan satker DIPA 01 dan 03  (berdasarkan PMK no.22/PMK.05/2016) sesuai dengan standard akutansi pemerintah yang berlaku.', 10, '2021-03-07 15:47:51', '2021-03-21 07:31:59', 2021, '03', 17),
(16151320811, 'Kepatuhan Backup data dan sinkronisasi SIPP minimal 1x dalam sehari', 10, '2021-03-07 15:48:01', '2021-03-18 08:33:46', 2021, '03', 18),
(16151320921, 'Standarisasi website pengadilan telah diupdate secara berkala dan dievaluasi', 10, '2021-03-07 15:48:12', '2021-03-21 07:57:49', 2021, '03', 18),
(16151322081, 'Telah dilaksanakan tertib pegawai dalam penggunaan pakaian dinas, atribut tanda pengenal dan jam kerja pegawai', 10, '2021-03-07 15:50:08', '2021-03-21 07:54:42', 2021, '03', 19),
(16151322181, 'Pengisian absensi dilakukan secara manual dan online', 10, '2021-03-07 15:50:18', '2021-03-21 07:44:38', 2021, '03', 19),
(16151322391, 'Izin keluar kantor menggunakan formulir dan telah mendapatkan izin pimpinan serta terarsip dengan baik', 10, '2021-03-07 15:50:39', '2021-03-21 07:21:15', 2021, '03', 19),
(16151322481, 'Peta kekuatan pegawai, rencana kebutuhan pegawai, dan Daftar Urut Kepangkatan telah dimutakhirkan', 10, '2021-03-07 15:50:48', '2021-03-21 07:52:58', 2021, '03', 19),
(16151322561, 'Proses pelaksanaan Baperjakat dan penempatan pegawai sudah sesuai dengan kompetensi', 10, '2021-03-07 15:50:56', '2021-03-21 07:58:22', 2021, '03', 19),
(16151322681, '\"Upaya pengembangan kompetensi telah dilaksanakan berdasarkan TNA,Pengelolaan Kinerja Pegawai, dan Hasil pengelolaan kinerja pegawai\"', 10, '2021-03-07 15:51:08', '2021-03-18 08:25:30', 2021, '03', 19),
(16151322861, 'Pengelolaan arsip kepegawaian telah tersusun dengan sistematis dan termutakhirkan', 10, '2021-03-07 15:51:26', '2021-03-21 07:37:01', 2021, '03', 19),
(16151323001, 'Pengelolaan Data SIKEP telah terinput lengkap  (100 %) dan termutakhirkan', 10, '2021-03-07 15:51:40', '2021-03-21 07:36:40', 2021, '03', 19),
(16151323131, 'Telah dilakukan pemutakhiran data pegawai dan absensi pada aplikasi Komdanas', 10, '2021-03-07 15:51:53', '2021-03-21 07:54:14', 2021, '03', 19),
(16151323291, 'RKP, RKGB dan usul pensiun telah dibuat untuk periode 1 tahun dan telah diinformasikan melalui papan informasi atau monitor', 10, '2021-03-07 15:52:09', '2021-03-21 07:59:00', 2021, '03', 19),
(16151323421, 'Pemberian sanksi dan penghargaan terakomodir dalam sistem promosi dan mutasi serta terdokumentasi dengan baik', 10, '2021-03-07 15:52:22', '2021-03-21 07:32:29', 2021, '03', 19),
(16151323531, 'PKP dan SKP telah dibuat secara berkala dan terdokumentasi dengan baik', 10, '2021-03-07 15:52:33', '2021-03-21 07:52:19', 2021, '03', 19),
(16151323621, 'Prosedur izin (keluar negeri,belajar,tugas belajar dan cuti) sesuai dengan PP No.17 Tahun 2020', 10, '2021-03-07 15:52:42', '2021-03-21 07:55:26', 2021, '03', 19),
(16151323731, 'Penyusunan Keputusan Pimpinan sesuai dengan Peraturan Kepala Arsip Nasional Indonesia No. 2 Tahun 2014 telah sesuai dan terdokumentasi dengan baik', 10, '2021-03-07 15:52:53', '2021-03-21 07:48:19', 2021, '03', 19),
(16151323881, 'Dokumentasi Rapat/ Notulen Rapat telah terdokumentasi dengan baik', 10, '2021-03-07 15:53:08', '2021-03-18 08:25:59', 2021, '03', 19),
(16151324021, '\"Pengelolaan tenaga honorer telah dilakukan evaluasi setiap caturwulan\"', 10, '2021-03-07 15:53:22', '2021-03-21 07:06:36', 2021, '03', 19),
(16151324121, 'Pengisian Laporan Lembar kerja (LLK) telah dilakukan secara rutin dengan menggunakan aplikasi SIMARI yang diverifikasi oleh atasan langsung', 10, '2021-03-07 15:53:32', '2021-03-21 07:43:27', 2021, '03', 19),
(16151324871, '1. Monitoring Berita Acara Sidang sudah selesai 1 hari sebelum hari sidang berikutnya\r\n2. Berita Acara sudah diupload kedalam aplikasi SIPP dan sesuai template\"', 10, '2021-03-07 15:54:47', '2021-03-21 07:08:47', 2021, '03', 15),
(16151324971, 'PP Wajib mengisi penundaan sidang  pada SIPP (paling lambat 1 X 24 Jam), dan melaporkan penundaan sidangnya ke panmud perdata atau pidana', 10, '2021-03-07 15:54:57', '2021-03-21 07:51:52', 2021, '03', 15),
(16151325131, 'Berita Acara sidang selesai maksimal 1 hari  sesudah pengucapan putusan', 10, '2021-03-07 15:55:13', '2021-03-21 07:09:51', 2021, '03', 15),
(16151325261, 'Kesesuaian dokumen-dokumen perkara dengan Template di SIPP', 10, '2021-03-07 15:55:26', '2021-03-21 07:25:04', 2021, '03', 15),
(16151325841, 'Permintaan Delegasi Bantuan Panggilan/Pemberitahuan telah dilakukan melalui SIPP dan data terinput dengan lengkap,bukti biaya pengiriman dikirim bersamaan dengan permintaan bantuan', 10, '2021-03-07 15:56:24', '2021-03-21 07:50:35', 2021, '03', 16),
(16151325981, '1.Pelaksanaan Delegasi Bantuan Panggilan/Pemberitahuan, JS/JSP menyampaikan relaas 2 hari setelah surat tugas \r\n2. Jurusita/Jurusita Pengganti menyampaikan Relaas pemanggilan/pemberitahuan yang telah dilaksanakan pada hari yang sama dengan pelaksanaan kepada koordinator delegasi\r\n3. Jurusita/Jurusita Pengganti mengajukan pencairan anggaran kepada Kasir setelah ada Surat Tugas\r\n4. Jurusita/Jurusita Pengganti slalu memberikan bukti pemanggilan/pemberitahuan kepada Kasir sebagai pertanggungjawaban', 10, '2021-03-07 15:56:38', '2021-03-21 07:09:24', 2021, '03', 16),
(16151326301, '1. Koordinator Delegasi/Jurusita/Jurusita Pengganti melakukan pemindaian/scanning relaas pemanggilan/pemberitahuan \r\n2. Koordinator Delegasi/Jurusita/Jurusita Pengganti mengupload ke aplikasi SIPP pada hari yang sama dengan penyerahan Relaas dari Jurusita/Jurusita Pengganti\r\n 3. Asli Relaas pemanggilan/pemberitahuan dikirimkan paling lama satu hari sejak koordinator menerima relaas dari Jurusita/Jurusita Pengganti\r\n 4.  Koordinator Delegasi/Jurusita/Jurusita Pengganti  melakukan pembaharuan data/informasi pada aplikasi SIPP\"', 10, '2021-03-07 15:57:10', '2021-03-21 07:08:15', 2021, '03', 16),
(16151326431, 'Koordinator Delegasi/Jurusita/Jurusita Pengganti  telah melakukan pembaharuan data/informasi pada aplikasi SIPP (selalu menginput data  sesuai proses)', 10, '2021-03-07 15:57:23', '2021-03-21 07:27:01', 2021, '03', 16),
(16152611613, 'Pemeliharaan sarana dan prasarana PTIP', 10, '2021-03-09 03:39:21', '2021-03-21 07:34:28', 2021, '03', 18),
(16164597593, 'Implementasi 5R (RINGKAS,Rapi,Resik,Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-03-23 00:35:59', '2021-03-23 00:35:59', 2021, '03', 10),
(16177130623, 'Pencatatan surat masuk/keluar menggunakan aplikasi dan terdistribusi tepat waktu', 10, NULL, NULL, 2021, '04', 17),
(16177130633, 'Pengisian SIPP register pidana,dakwaan,barang bukti terisi lengkap dan tepat waktu', 10, NULL, NULL, 2021, '04', 10),
(16177130643, 'Pemberkasan Arsip Perkara yang telah diminutasi  terdapat checlist kelengkapan berkas, court calender dan terjilid rapi', 10, NULL, NULL, 2021, '04', 14),
(16177130653, '\"Penyerahan berkas perkara inactive dari Panmud Pidana kepada Panmud Hukum harus dengan Berita Acara Serah Terima Berkas ( dalam jangka waktu 3 hari setelah BHT )\"', 10, NULL, NULL, 2021, '04', 10),
(16177130663, 'Pengiriman Berkas Banding ke PT tenggang waktu 14 hari dan telah terinput di SIPP', 10, NULL, NULL, 2021, '04', 10),
(16177130673, 'Permohonan kasasi yang telah memenuhi syarat formal selambat lambatnya dalam waktu 14 hari setelah tenggang waktu mengajukan memori kasasi berakhir, berkas kasasi harus sudah dikirim ke Mahkamah Agung (Buku II), telah terinput pada SIPP dan telah menggunakan barcode', 10, NULL, NULL, 2021, '04', 10),
(16177130683, 'Pengiriman Berkas Kasasi selambat-lambatnya dalam waktu 30 hari, telah terinput di SIPP dan menggunakan sistem barcode', 10, NULL, NULL, 2021, '04', 10),
(16177130693, 'Implementasi 5R (RINGKAS,Rapi,Resik,Rawat dan Rajin) telah dilaksanakan dengan baik', 10, NULL, NULL, 2021, '04', 17),
(16177130703, 'Pelaksanaan Diversi telah diinput pada SIPP secara lengkap dan tepat waktu', 10, NULL, NULL, 2021, '04', 10),
(16177130713, 'Ketersediaan sarana dan prasarana pendukung telah terpenuhi dan berfungsi dengan baik', 10, NULL, NULL, 2021, '04', 17),
(16177130723, 'Perkara pidana yang diselesaikan kurang dari 5 bulan, dan yang melebihi 5 bulan telah dilaporkan kepada pimpinan dan pt', 10, NULL, NULL, 2021, '04', 10),
(16177130733, 'Prosedur tata kelola arsip sudah menggunakan aplikasi SIPP, penataan berkas sesuai penataan aplikasi SIPP, dan jadwal perawatan arsip', 10, NULL, NULL, 2021, '04', 14),
(16177130743, 'Prosedur Peminjaman Berkas telah tercatat dan diketahui oleh Pimpinan serta memiliki batas waktu peminjaman', 10, NULL, NULL, 2021, '04', 14),
(16177130753, 'Melakukan pelaporan perkara dan posbakum setiap bulan kepada DitJen Badilum melalui aplikasi', 10, NULL, NULL, 2021, '04', 14),
(16177130763, 'Melakukan monitoring dan evaluasi kinerja posbakum', 10, NULL, NULL, 2021, '04', 14),
(16177130773, 'Posbakum telah dilengkapi dengan MoU/SPK, dan pelaporan(lengkap dengan absensi, buku tamu)', 10, NULL, NULL, 2021, '04', 14),
(16177130783, 'Telah dilakukan monitoring pada informasi dan pengaduan', 10, NULL, NULL, 2021, '04', 14),
(16177130793, '\"Penyerahan berkas perkara inactive dari Panmud Pidana,Perdata,PHI,Tipikor kepada Panmud Hukum harus dengan Berita Acara Serah Terima Berkas ( dalam jangka waktu 3 hari setelah BHT ) dan telah di input pada SIPP\"', 10, NULL, NULL, 2021, '04', 14),
(16177130803, 'Telah dibuat laporan IKM dan IPK', 10, NULL, NULL, 2021, '04', 14),
(16177130813, 'Telah membuat statistik perkara bulanan dan tahunan', 10, NULL, NULL, 2021, '04', 14),
(16177130823, 'Pengiriman Berkas Banding ke PT tenggang waktu 30 hari dan telah terinput di SIPP', 10, NULL, NULL, 2021, '04', 11),
(16177130833, 'Pengiriman Berkas PK selambat-lambatnya dalam waktu 30 hari, telah terinput di SIPP dan menggunakan sistem barcode', 10, NULL, NULL, 2021, '04', 11),
(16177130843, 'Penginputan data sudah dilakukan secara tertib dan dilaporkan setiap bulan sebelum tanggal 5 pada aplikasi KOMDANAS', 10, NULL, NULL, 2021, '04', 11),
(16177130853, 'Surat Kuasa Untuk Membayar (SKUM) telah tercatat dan di beri nomor', 10, NULL, NULL, 2021, '04', 11),
(16177130863, 'Perkara yang telah berhasil Mediasi telah dilaporkan ke Badilum dan diinput pada SIPP', 10, NULL, NULL, 2021, '04', 11),
(16177130873, 'Penginputan permohonan eksekusi telah dinput di SIPP dan buku register', 10, NULL, NULL, 2021, '04', 11),
(16177130883, 'Perkara perdata diselesaikan kurang dari 5 bulan, dan yang melebihi 5 bulan telah dilaporkan kepada pimpinan dan PT', 10, NULL, NULL, 2021, '04', 11),
(16177130893, 'Pengisian SIPP register pidana khusus, dakwaan, barang bukti terisi lengkap dan tepat waktu', 10, NULL, NULL, 2021, '04', 13),
(16177130903, 'Penginputan data sudah dilakukan secara tertib dan dilaporkan setiap bulan sebelum tanggal 5 pada aplikasi KOMDANAS', 10, NULL, NULL, 2021, '04', 12),
(16177130913, 'Penginputan permohonan eksekusi telah diinput di SIPP dan buku register', 10, NULL, NULL, 2021, '04', 12),
(16177130923, 'Perkara PHI diselesaikan kurang dari 50 hari kerja, dan yang melebihi telah dilaporkan kepada pimpinan', 10, NULL, NULL, 2021, '04', 12),
(16177130933, 'Penyerahan berkas perkara inactive dari Panmud Pidana kepada Panmud Hukum harus dengan Berita Acara Serah Terima Berkas (dalam jangka waktu 3 hari setelah BHT)', 10, NULL, NULL, 2021, '04', 13),
(16177130943, 'SK Pengelola BMN dan Laporan inventaris barang milik negara (SIMAK BMN) telah diupdate,dilaksanakan dan dilaporkan', 10, NULL, NULL, 2021, '04', 17),
(16177130953, 'Pencatatan Aset  lainnya,SK Tim Penilai dan Pengelola Aset', 10, NULL, NULL, 2021, '04', 17),
(16177130963, 'Telah mengisi Laporan Pengawasan dan Pengendalian (WASDAL) BMN pada aplikasi Sistem Informasi Manajemen Aset Negara (SIMAN) dan terdokumentasi dengan baik', 10, NULL, NULL, 2021, '04', 17),
(16177130973, 'Penginputan Aset Tetap, Kesesuaian jumlah dan harga barang yang diinput pada SIMAK BMN saat pembelian', 10, NULL, NULL, 2021, '04', 17),
(16177130983, 'Penatausahaan Barang Persediaan, Kesesuaian jumlah dan harga barang yang diinput pada aplikasi persediaan saat pembelian, Membuat Stok Opname Fisik setiap bulan', 10, NULL, NULL, 2021, '04', 17),
(16177130993, 'Pendistribusian barang tercatat dengan baik', 10, NULL, NULL, 2021, '04', 17),
(16177131003, 'Penunjukan Penggunaan Kendaraan Dinas telah sesuai PMK 76/PMK.06/2015 serta perawatan Kendaraan Dinas terdapat kartu kendali,anggaran tidak melebihi sbu, Pembayaran Pajak Kendaraan tepat waktu', 10, NULL, NULL, 2021, '04', 17),
(16177131013, 'Pengelolaan Rumah Dinas,Penunjukan Penggunaan Rumah Dinas dan pembayaran PBB', 10, NULL, NULL, 2021, '04', 17),
(16177131023, 'Labelisasi barang milik negara telah dilaksanakan dan diupdate', 10, NULL, NULL, 2021, '04', 17),
(16177131033, 'Daftar barang ruangan telah diperbaharui', 10, NULL, NULL, 2021, '04', 17),
(16177131043, 'Tersedianya jalur evakuasi dan titik kumpul serta peralatan proteksi bahaya kebakaran (APAR)', 10, NULL, NULL, 2021, '04', 17),
(16177131053, 'Jalan masuk gedung pengadilan (terkait dengan sterilisasi)', 10, NULL, NULL, 2021, '04', 17),
(16177131073, 'Tersedianya fasilitas untuk penyandang difabel', 10, NULL, NULL, 2021, '04', 17),
(16177131083, '\"Tersedia informasi tentang : \r\n- Visi dan Misi,\r\n- Papan daftar nama hakim, \r\n- Papan daftar nama mediator, \r\n- alur perkara, \r\n- alur pengajuan dan penanganan layanan bantuan hukum, \r\n- gugatan sederhana, dan \r\n- informasi panjar biaya perkara, \"', 10, NULL, NULL, 2021, '04', 17),
(16177131093, 'Kebersihan lingkungan pengadilan terjaga dan terawat dengan baik ( Ruang Persidangan,ruang tunggu, ruang tahanan dan Fasilitas umum lainnya)', 10, NULL, NULL, 2021, '04', 17),
(16177131103, 'Pemeliharaan sarana dan prasarana pendukung kerja  (perlengkapan persidangan,genset,AC,Maubiler dll)', 10, NULL, NULL, 2021, '04', 17),
(16177131113, 'Penempatan CCTV telah sesuai, perawatan dilakukan secara berkala dan berfungsi dengan baik', 10, NULL, NULL, 2021, '04', 17),
(16177131123, 'Petugas keamanan telah menerapkan 3S dan menggunakan peralatan keamanan', 10, NULL, NULL, 2021, '04', 17),
(16177131133, 'Nilai Kapitalisasi Barang Milik Negara (BMN), Belanja diatas nilai kapitalisasi menggunakan Anggaran Belanja Modal dan diinput ke dalam aplikasi SIMAK', 10, NULL, NULL, 2021, '04', 17),
(16177131143, 'Pelaksanaan Perjalanan Dinas sesuai dengan tupoksi dan terdokumentasi dengan baik', 10, NULL, NULL, 2021, '04', 19),
(16177131153, 'Implementasi aplikasi SMART', 10, NULL, NULL, 2021, '04', 17),
(16177131163, '\"SK manajemen pengelolaan keuangan telah diperbaharui : \r\n- SK KPA \r\n-SK Pejabat Pembuat Komitmen\r\n- SK bendahara pengeluaran/ bendahara pemegang uang muka \r\n- Bendahara penerima, \r\n- SK Pembantu Pengelola Keuangan\"', 10, NULL, NULL, 2021, '04', 17),
(16177131173, 'Dokumen pertanggung jawaban telah disimpan dan diarsipkan', 10, NULL, NULL, 2021, '04', 17),
(16177131183, 'Kesesuaian antara Data dan Barang Persediaan  Dipa 01 dan Dipa 03', 10, NULL, NULL, 2021, '04', 17),
(16177131193, 'Prosedur Pendistribusian Barang (Berita Acara Serah Terima Barang dan Tanda Terima Barang)', 10, NULL, NULL, 2021, '04', 17),
(16177131203, 'Monitoring uang persediaan di brankas bendahara oleh KPA setiap bulan', 10, NULL, NULL, 2021, '04', 17),
(16177131213, 'Satker sudah menginput aplikasi monev PP 39 Tahun 2006 dari Bapenas setiap triwulan', 10, NULL, NULL, 2021, '04', 17),
(16177131223, 'Satker telah melakukan Rekon internal antara aplikasi SIMAK, BMN, SAIBA dan KOMDANAS setiap bulannya dengan membuat berita acara Rekon internal (mengetahui : operator SAIBA, operator, SIMAK, BMN dan KPA)', 10, NULL, NULL, 2021, '04', 17),
(16177131233, 'Penyusunan RKAK/L telah tersedia RAB,TOR dan data perkara', 10, NULL, NULL, 2021, '04', 18),
(16177131243, 'Penyusunan Dokumen SAKIP telah lengkap dan sesuai, serta melibatkan seluruh pimpinan dan seluruh pegawai', 10, NULL, NULL, 2021, '04', 18),
(16177131253, 'Perawatan dan Pengelolaan sistem TI di pengadilan telah dilakukan secara rutin dan memiliki kartu kontrol', 10, NULL, NULL, 2021, '04', 18),
(16177131263, 'Pelaporan Keuangan satker DIPA 01 dan 03  (berdasarkan PMK no.22/PMK.05/2016) sesuai dengan standard akutansi pemerintah yang berlaku.', 10, NULL, NULL, 2021, '04', 17),
(16177131273, 'Kepatuhan Backup data dan sinkronisasi SIPP minimal 1x dalam sehari', 10, NULL, NULL, 2021, '04', 18),
(16177131283, 'Standarisasi website pengadilan telah diupdate secara berkala dan dievaluasi', 10, NULL, NULL, 2021, '04', 18),
(16177131293, 'Telah dilaksanakan tertib pegawai dalam penggunaan pakaian dinas, atribut tanda pengenal dan jam kerja pegawai', 10, NULL, NULL, 2021, '04', 19),
(16177131303, 'Pengisian absensi dilakukan secara manual dan online', 10, NULL, NULL, 2021, '04', 19),
(16177131313, 'Izin keluar kantor menggunakan formulir dan telah mendapatkan izin pimpinan serta terarsip dengan baik', 10, NULL, NULL, 2021, '04', 19),
(16177131323, 'Peta kekuatan pegawai, rencana kebutuhan pegawai, dan Daftar Urut Kepangkatan telah dimutakhirkan', 10, NULL, NULL, 2021, '04', 19),
(16177131333, 'Proses pelaksanaan Baperjakat dan penempatan pegawai sudah sesuai dengan kompetensi', 10, NULL, NULL, 2021, '04', 19),
(16177131343, '\"Upaya pengembangan kompetensi telah dilaksanakan berdasarkan TNA,Pengelolaan Kinerja Pegawai, dan Hasil pengelolaan kinerja pegawai\"', 10, NULL, NULL, 2021, '04', 19),
(16177131353, 'Pengelolaan arsip kepegawaian telah tersusun dengan sistematis dan termutakhirkan', 10, NULL, NULL, 2021, '04', 19),
(16177131363, 'Pengelolaan Data SIKEP telah terinput lengkap  (100 %) dan termutakhirkan', 10, NULL, NULL, 2021, '04', 19),
(16177131373, 'Telah dilakukan pemutakhiran data pegawai dan absensi pada aplikasi Komdanas', 10, NULL, NULL, 2021, '04', 19),
(16177131383, 'RKP, RKGB dan usul pensiun telah dibuat untuk periode 1 tahun dan telah diinformasikan melalui papan informasi atau monitor', 10, NULL, NULL, 2021, '04', 19),
(16177131393, 'Pemberian sanksi dan penghargaan terakomodir dalam sistem promosi dan mutasi serta terdokumentasi dengan baik', 10, NULL, NULL, 2021, '04', 19),
(16177131403, 'PKP dan SKP telah dibuat secara berkala dan terdokumentasi dengan baik', 10, NULL, NULL, 2021, '04', 19),
(16177131413, 'Prosedur izin (keluar negeri,belajar,tugas belajar dan cuti) sesuai dengan PP No.17 Tahun 2020', 10, NULL, NULL, 2021, '04', 19),
(16177131423, 'Penyusunan Keputusan Pimpinan sesuai dengan Peraturan Kepala Arsip Nasional Indonesia No. 2 Tahun 2014 telah sesuai dan terdokumentasi dengan baik', 10, NULL, NULL, 2021, '04', 19),
(16177131433, 'Dokumentasi Rapat/ Notulen Rapat telah terdokumentasi dengan baik', 10, NULL, NULL, 2021, '04', 19),
(16177131443, '\"Pengelolaan tenaga honorer telah dilakukan evaluasi setiap caturwulan\"', 10, NULL, NULL, 2021, '04', 19),
(16177131453, 'Pengisian Laporan Lembar kerja (LLK) telah dilakukan secara rutin dengan menggunakan aplikasi SIMARI yang diverifikasi oleh atasan langsung', 10, NULL, NULL, 2021, '04', 19),
(16177131463, '1. Monitoring Berita Acara Sidang sudah selesai 1 hari sebelum hari sidang berikutnya\r\n2. Berita Acara sudah diupload kedalam aplikasi SIPP dan sesuai template\"', 10, NULL, NULL, 2021, '04', 15),
(16177131473, 'PP Wajib mengisi penundaan sidang  pada SIPP (paling lambat 1 X 24 Jam), dan melaporkan penundaan sidangnya ke panmud perdata atau pidana', 10, NULL, NULL, 2021, '04', 15),
(16177131483, 'Berita Acara sidang selesai maksimal 1 hari  sesudah pengucapan putusan', 10, NULL, NULL, 2021, '04', 15),
(16177131493, 'Kesesuaian dokumen-dokumen perkara dengan Template di SIPP', 10, NULL, NULL, 2021, '04', 15),
(16177131503, 'Permintaan Delegasi Bantuan Panggilan/Pemberitahuan telah dilakukan melalui SIPP dan data terinput dengan lengkap,bukti biaya pengiriman dikirim bersamaan dengan permintaan bantuan', 10, NULL, NULL, 2021, '04', 16),
(16177131513, '1.Pelaksanaan Delegasi Bantuan Panggilan/Pemberitahuan, JS/JSP menyampaikan relaas 2 hari setelah surat tugas \r\n2. Jurusita/Jurusita Pengganti menyampaikan Relaas pemanggilan/pemberitahuan yang telah dilaksanakan pada hari yang sama dengan pelaksanaan kepada koordinator delegasi\r\n3. Jurusita/Jurusita Pengganti mengajukan pencairan anggaran kepada Kasir setelah ada Surat Tugas\r\n4. Jurusita/Jurusita Pengganti slalu memberikan bukti pemanggilan/pemberitahuan kepada Kasir sebagai pertanggungjawaban', 10, NULL, NULL, 2021, '04', 16),
(16177131523, '1. Koordinator Delegasi/Jurusita/Jurusita Pengganti melakukan pemindaian/scanning relaas pemanggilan/pemberitahuan \r\n2. Koordinator Delegasi/Jurusita/Jurusita Pengganti mengupload ke aplikasi SIPP pada hari yang sama dengan penyerahan Relaas dari Jurusita/Jurusita Pengganti\r\n 3. Asli Relaas pemanggilan/pemberitahuan dikirimkan paling lama satu hari sejak koordinator menerima relaas dari Jurusita/Jurusita Pengganti\r\n 4.  Koordinator Delegasi/Jurusita/Jurusita Pengganti  melakukan pembaharuan data/informasi pada aplikasi SIPP\"', 10, NULL, NULL, 2021, '04', 16),
(16177131533, 'Koordinator Delegasi/Jurusita/Jurusita Pengganti  telah melakukan pembaharuan data/informasi pada aplikasi SIPP (selalu menginput data  sesuai proses)', 10, NULL, NULL, 2021, '04', 16),
(16177131543, 'Pemeliharaan sarana dan prasarana PTIP', 10, NULL, NULL, 2021, '04', 18),
(16177131553, 'Implementasi 5R (RINGKAS,Rapi,Resik,Rawat dan Rajin) telah dilaksanakan dengan baik', 10, NULL, NULL, 2021, '04', 10),
(16200927093, 'Monitoring Performance SIPP', 10, '2021-05-04 01:45:09', '2021-05-04 01:45:09', 2021, '04', 18),
(16200927723, 'Peringkat dan Nilai Evaluasi SIPP', 10, '2021-05-04 01:46:12', '2021-05-04 01:46:12', 2021, '04', 18),
(16200928653, 'Pemanfaatan IT (Aplikasi PTSP,Era Terang,E-Court)', 10, '2021-05-04 01:47:45', '2021-05-04 01:47:45', 2021, '04', 18),
(16201068763, 'Implementasi 5R (RINGKAS, Rapi, Resik, Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-05-04 05:41:16', '2021-05-04 05:41:16', 2021, '04', 18),
(16201070143, 'Implementasi 5R (RINGKAS, Rapi, Resik, Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-05-04 05:43:34', '2021-05-04 05:43:34', 2021, '04', 11),
(16201074343, 'Implementasi 5R (RINGKAS, Rapi, Resik, Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-05-04 05:50:34', '2021-05-04 05:50:34', 2021, '04', 12),
(16201074583, 'Implementasi 5R (RINGKAS, Rapi, Resik, Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-05-04 05:50:58', '2021-05-04 05:50:58', 2021, '04', 13),
(16201074813, 'Implementasi 5R (RINGKAS, Rapi, Resik, Rawat dan Rajin) telah dilaksanakan dengan baik', 10, '2021-05-04 05:51:21', '2021-05-04 05:51:21', 2021, '04', 14),
(16201090223, 'Pengiriman Upaya Hukum Kasasi tidak tepat waktu', 10, '2021-05-04 06:17:02', '2021-05-04 06:17:02', 2021, '04', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sectors`
--

CREATE TABLE `sectors` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggung_jawab` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `base_color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sectors`
--

INSERT INTO `sectors` (`id`, `nama`, `nama_lengkap`, `alias`, `category`, `penanggung_jawab`, `nip`, `created_at`, `updated_at`, `base_color`) VALUES
(10, 'Pidana', 'KEPANITERAAN PIDANA', 'pidana', 'Kepaniteraan', 'ANDI EDDY VIYATA,SH', '197511302001121003', NULL, '2021-03-07 18:49:25', 'ffffff'),
(11, 'Perdata', 'KEPANITERAAN PERDATA', 'perdata', 'Kepaniteraan', 'I MADE SUKANADA', '196611161992121001', NULL, '2021-03-07 19:17:45', 'ffffff'),
(12, 'PHI', 'KEPANITERAAN PENGADILAN HUBUNGAN INDUSTRIA', 'phi', 'Kepaniteraan', 'NURSALAM., S.H', '-', NULL, '2021-03-07 19:18:15', 'ffffff'),
(13, 'TIPIKOR', 'KEPANITERAAN TINDAK PIDANA KORUPSI', 'tipikor', 'Kepaniteraan', 'MULYONO DWI PURWANTO., A.K, S.H, M.Ab, CFE', '-', NULL, '2021-03-07 19:18:50', 'ffffff'),
(14, 'Hukum', 'KEPANITERAAN HUKUM', 'hukum', 'Kepaniteraan', 'KELIK TRIMARGO., S.H, M.H', '197010301996031003', NULL, '2021-03-07 19:19:16', 'ffffff'),
(15, 'PP', '', 'pp', 'Kepaniteraan', 'Drs. H LA ODE MUHAMAD SUDISMAN, S .H., M. H.', '196410071985031003', NULL, '2021-03-07 19:20:27', 'ffffff'),
(16, 'JS/JSP', '', 'js_jsp', 'Kepaniteraan', 'Drs. H LA ODE MUHAMAD SUDISMAN, S .H., M. H.', '196410071985031003', NULL, '2021-03-07 19:21:15', 'ffffff'),
(17, 'UM & KEU', 'UMUM DAN KEUANGAN', 'umum_keuangan', 'Kesekretariatan', 'IRMAWATI ABIDIN., S.H, M.H', '197610132001122003', NULL, '2021-03-07 19:21:53', 'ffffff'),
(18, 'PTIP', 'PERENCANAAN,TEKNOLOGI INFORMASI DAN PELAPORAN ', 'ptip', 'Kesekretariatan', 'MAHARDIAN, S.H', '-', NULL, '2021-03-07 19:22:11', 'ffffff'),
(19, 'KOT', 'KEPEGAWAIAN DAN ORGANISASI TATA LAKSANA', 'kot', 'Kesekretariatan', 'GANDUNG LEDIYANTO., S.P', '-', NULL, '2021-03-07 19:22:30', 'ffffff');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_level_id` tinyint(4) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nip`, `password`, `user_level_id`, `remember_token`, `created_at`, `updated_at`, `foto`) VALUES
(1, 'Muhammad Usgan', 'musgan@gmail.com', NULL, '$2y$10$RBywNHetCGQPXQMDuZZt8uYhIx0LGNAltteGZkquIn8EN4UjYavAC', 1, 'Y3pkDXp9xC0lntQLdqTPCk1tLpVX4CCvGP8mYZ6RuGT8cjAFoILcvtIAxpBA', NULL, '2021-02-23 06:04:14', NULL),
(3, 'Wa Ode Nur Iqamah', '41qo.mah@gmail.com', NULL, '$2y$10$E8Y5/gVKSfu3ZvNTOdjvFurIAv.Sy8NZQGXzVALGDrC97srJhQlc.', 1, 'TynzTPmEVSHMfMca4nuXOmkTXecwQ0MTAG7wUAza0WK9mnBY5CSKaYFjOvBc', '2021-03-02 21:05:44', '2021-03-27 06:20:59', '1616485001_3.jpeg'),
(8, 'I Nyoman Wiguna,SH.,MH', 'wkpn@esimpel.com', '197012201996031002', '$2y$10$5Upm4K1aBdzgazufJ1M6mOXjbn5lX1C1N8HTRXYaS7f7au9tuvrZu', 3, NULL, '2021-03-07 17:06:10', '2021-03-28 18:54:51', NULL),
(11, 'Mahardian,SH', 'Mahardianz99@gmail.com', '-', '$2y$10$k0tFT7dd3rsY8jqKA17bDej0ovME0slz7iNQjROLoYpy303CciBGu', 10, 'IEWQouqqIx8nsugvsotbOUH5z2XwxKcI1B1fuUqZiPnFPmUvyubm92bJRmtq', '2021-03-07 18:35:43', '2021-03-23 01:49:28', '1616489368_11.jpeg'),
(13, 'KELIK TRIMARGO,SH.,MH', 'kelik.trimargo@gmail.com', '197010301996031003', '$2y$10$P.W2llzdiWZ0.k7Xl9xanedq9bpnI891ujYM1.NpqZ.T5XeaUuN8K', 10, 'qMY7vldK2pEIQpKpLec8NlmHJTp2ulytTlCy3kg2SnhcmMnZz4aTKnwjawiS', '2021-03-07 19:24:51', '2021-03-28 18:57:17', '1616489301_13.jpeg'),
(14, 'Irmawati Abidin', 'irma.abidin@gmail.com', '197610132001122003', '$2y$10$Nvpg9MIqa9xBTlTVmk4RFekimyqPAqAg7kQZvZW5DgdQHQ6/hUD7m', 10, 'Tn1gYC4nkLrNryCozlYy7qMvj1lT650Gr2G2U4IjvNii2ReclKWb0dOKvyZz', '2021-03-08 20:45:53', '2021-03-28 20:50:12', '1616989812_14.jpeg'),
(15, 'Rudi Suparmono,SH.,MH', 'rsuparmono@gmail.com', '196805191992121001', '$2y$10$cioiEG9xcuzHxDXTMtb8JO8.8EGB1lq./JWlGQd18DQTB7AJ0FyqS', 2, 'hPvQxovKheYJj387eImk2grl6ZwUlS3iNgDXYFiB4phM8jLsDknnTgrsp4Cq', '2021-03-08 21:10:01', '2021-03-28 20:51:39', '1616489476_15.jpeg'),
(16, 'Andi Eddy', 'Andi.eddy@gmail.com', '197511302001121003', '$2y$10$x0KcnUwuSXZ/nJ/44JPFuesll09.T.cGCJ7uB8bnIAySdQQq3c6Ha', 10, 'k4WQcFw6Pz1UMe6rYUlEI2xPwxg1rqod38te6nryRlp71OcjWj1vDgmj2Oz0', '2021-03-22 17:37:18', '2021-03-28 20:53:01', NULL),
(17, 'Hasrim', 'hasrim@gmail.com', '197304241993031006', '$2y$10$9ZzhIM6hw9.eIrRow4rRkO01B7lHe4JgPLRvPBylXRzMea.qqBj7e', 5, 'IzhL5W95WRdaDheWyObBwuoPuVTJFnp28mLcsAXB65D2Me213sgRdyNnXHI0', '2021-03-22 22:54:16', '2021-03-28 21:05:17', '1616990717_17.jpeg'),
(18, 'Akira Hasbullah Isamu,SE', 'reitei81@gmail.com', '198011182009041002', '$2y$10$tzCw5JtRAZw2fCtUeaX7rO/ZDOX9mtyUCp6c2m7trgLIpLk.su4ai', 4, 'tpytbMAdczsIhq3SGS2KzXjo4hEmVZ3ZdifCYAHKcfFHEKBa2hxXGMZ3d5G6', '2021-03-27 06:24:04', '2021-03-28 20:55:53', '1616982684_18.jpeg'),
(19, 'Wa Aija,SH', 'ija.keu@gmail.com', '196512311992032006', '$2y$10$UifsnzUxUYHgZWYd2YCO6.11nG8orHnGekkDBsb14BxEKp9zEjr6O', 4, 'eA8kOmGJlgTjkcpfDynRBWix4kygQsT5jeET5cUXAMCXYWJudskHjSaOEkST', '2021-03-27 06:36:12', '2021-03-28 20:56:43', '1616982762_19.jpeg'),
(20, 'Wa Ode Nur Iqamah,ST', 'aiko_973@yahoo.com', '198412182009042009', '$2y$10$S6sdGqCLW1Wdgx0551wwI.4dw1aREzi5ZNJA21DjFKS94h98Tc9ie', 4, 'SA3mOTLksXuM9j8mPLJPD3fTe3cigbg1RtqlgAcy9jCBtgWUc0W5dUgSNz9K', '2021-03-28 18:44:55', '2021-03-28 21:13:18', '1616991198_20.jpeg'),
(21, 'MUHAMMAD SAIN., SH, MH', 'sain@gmail.com', '196910241992031001', '$2y$10$76XerbFFd/ak0bINaop22.FPeecN8k5iYCzbZTWlfDfNgRvRRmE.2', 5, 'q2nEhV5C0TdxSX8guCfEMRBEbwQmpTSM0r5Vu2AmRThe9GLYgIzzLX6fyEby', '2021-03-28 20:59:03', '2021-03-28 21:06:25', '1616990785_21.jpeg'),
(22, 'LA ODE SAMNI, SH', 'samni@gmail.com', '196712311990031031', '$2y$10$25p0UkL9haeTPcnH8SFvRuclWAWsflATozrSyEDTPZ8fGycB.kSgK', 5, 'JENhXZLNqKNmiJeg4IqDhsR8pC4NpVdjOqRWRDygkOw1dNLO9UFRpALBf5nS', '2021-03-28 21:00:28', '2021-03-28 21:07:22', '1616990842_22.jpeg'),
(23, 'E N N I, SH', 'enni@gmail.com', '196105111983032006', '$2y$10$HWMCb.8Bj4lxSok6Q2Jlvuo2OLcoEqh9Ch7wAkSeyymD6.WjGXsmO', 5, 'jvDISwaBW5qZoyIOAg0rGK2ozhSAjNK0CiTmOilraRqT3V9Bdhv0Wy8LcIkc', '2021-03-28 21:02:01', '2021-03-28 21:08:12', '1616990892_23.jpeg'),
(24, 'LA ODE TOMBU, SH.', 'tombu@gmail.com', '197312311993031007', '$2y$10$957aDqKfOI4w1Lu8HD1Ze.ICBAb6egoNXSCYOQQB2p9jCKU9zjFaq', 5, 'BNkJOPKA7d6N5WQneXxwztzBPsu4WCbCn5cit2u3Gh9n099QVNy9psJZcKTz', '2021-03-28 21:03:20', '2021-03-28 21:11:01', '1616991061_24.jpeg'),
(25, 'Nursalam,SH', 'nsalam59@gmail.com', '123', '$2y$10$RKmyos/8dhsMCPX8GpGfh.dqynKS4hPXajr6wY5.eFKco.6AybfRS', 10, '9Gq6GPrTV7Moz2FNmTXhnmSQZPSDUPg4NxLugEHBu6wvi1sZM6Hfe5lyx0x7', '2021-04-29 23:14:29', '2021-04-29 23:14:29', NULL),
(26, 'Gandung Lediyanto,SP', 'galediyanto@gmail.com', '-', '$2y$10$GxXqOr6br0PxWQhtMvjM1OeOkf/9ZcI6H3tJp9pwayrKcf7cgfRc6', 10, 'rmEaKLTa1l3XbJov76XIsb7ClxOLvkNOcxEiVCxSJXT915YNo45QsxX2Pk3J', '2021-04-29 23:31:33', '2021-04-29 23:31:33', NULL),
(27, 'Wahyu Bintoro,SH', 'w.bintores@gmail.com', '197608232002121002', '$2y$10$g3.SZjmo955y837MbbPiKuDim/6f9vQehS7xU1KW67L4dQlVW6n9K', 10, 'y4fmacUQe8lRY3WSqJskUz1NaOBf4VFbNXFb4WAsP2K6OQ7RatcuYNPrYgWI', '2021-05-02 22:20:15', '2021-05-02 22:20:15', NULL),
(28, 'Rico Wan Armando,SH', 'Wanarmandorico@gmail.com', '-', '$2y$10$2JmKX9DB9i0ujpQCar29Lu9zkEsvJOnzEcjZuq7jzQ32wdXQDy3XS', 10, NULL, '2021-05-03 19:31:52', '2021-05-03 19:31:52', NULL),
(29, 'I Ketut Pancaria,SH', 'ketutpancaria12@gmail.com', '196412311996031008', '$2y$10$2qHcpcUD0KJr/2z9uWcCK.9Mp1sCCirJnzM.3yz74kYLIDZGl.6Hu', 10, NULL, '2021-05-03 19:33:38', '2021-05-03 19:33:38', NULL),
(30, 'Dr. TITO ELIANDI, S.H., M.H', 'tito.eliandi@gmail.com', '197810042002121002', '$2y$10$sW.H35Gz7H3dWLnVUp/z.enyUHtZV/hX8vE9c0f/wCM/nul1WnRzq', 10, NULL, '2021-05-03 19:36:15', '2021-05-03 19:36:15', NULL),
(31, 'MULYONO DWI PURWANTO, A.K., S.H., M.Ab., CFE', 'mulyono.purwanto@gmail.com', '-', '$2y$10$QeWtB0LLLzeHuHWEAq1sw.Cohtwe2sSUkowXiaSL75/FVXHTf0Q16', 10, NULL, '2021-05-03 19:37:26', '2021-05-03 19:37:26', NULL),
(32, 'I MADE SUKANADA,SH.,MH', 'imadesuknada16@gmail.com', '196611161992121001', '$2y$10$mJoTLBewDQVu4iii9/1/suq7QW9trcaeWqD.jbi6pGheAKU8HIj8u', 10, NULL, '2021-05-03 19:39:17', '2021-05-03 19:39:17', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_levels`
--

CREATE TABLE `user_levels` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_levels`
--

INSERT INTO `user_levels` (`id`, `nama`, `alias`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', NULL, NULL),
(2, 'Ketua Pengadilan Negeri', 'mpn', NULL, NULL),
(3, 'Wakil Ketua Pengadilan Negeri', 'mpn', NULL, NULL),
(4, 'Kasubag', 'kapan', NULL, NULL),
(5, 'Panmud', 'kapan', NULL, NULL),
(10, 'Hawasbid', 'hawasbid', NULL, NULL),
(11, 'APM', 'apm', NULL, NULL),
(12, 'ZI', 'zi', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level_groups`
--

CREATE TABLE `user_level_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_level_id` tinyint(3) UNSIGNED NOT NULL,
  `sector_id` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_level_groups`
--

INSERT INTO `user_level_groups` (`id`, `user_id`, `user_level_id`, `sector_id`, `created_at`, `updated_at`) VALUES
(4, 11, 10, 18, NULL, NULL),
(19, 13, 10, 14, NULL, NULL),
(20, 14, 10, 17, NULL, NULL),
(21, 16, 10, 10, NULL, NULL),
(22, 17, 5, 10, NULL, NULL),
(23, 18, 4, 19, NULL, NULL),
(24, 19, 4, 17, NULL, NULL),
(25, 20, 4, 18, NULL, NULL),
(26, 21, 5, 11, NULL, NULL),
(27, 22, 5, 12, NULL, NULL),
(28, 23, 5, 13, NULL, NULL),
(30, 24, 5, 14, NULL, NULL),
(31, 25, 10, 12, NULL, NULL),
(33, 26, 10, 19, NULL, NULL),
(34, 27, 10, 11, NULL, NULL),
(35, 28, 10, 12, NULL, NULL),
(36, 29, 10, 10, NULL, NULL),
(37, 30, 10, 10, NULL, NULL),
(38, 31, 10, 13, NULL, NULL),
(39, 32, 10, 11, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `indikator_sectors`
--
ALTER TABLE `indikator_sectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indikator_sectors_secretariat_id_foreign` (`secretariat_id`),
  ADD KEY `indikator_sectors_sector_id_foreign` (`sector_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `performa_sectors`
--
ALTER TABLE `performa_sectors`
  ADD KEY `performa_sectors_sector_id_foreign` (`sector_id`);

--
-- Indeks untuk tabel `secretariats`
--
ALTER TABLE `secretariats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `secretariats_user_level_id_foreign` (`user_level_id`),
  ADD KEY `secretariats_sector_id_foreign` (`sector_id`);

--
-- Indeks untuk tabel `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `user_level_id` (`user_level_id`);

--
-- Indeks untuk tabel `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_level_groups`
--
ALTER TABLE `user_level_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level_groups_user_id_foreign` (`user_id`),
  ADD KEY `user_level_groups_user_level_id_foreign` (`user_level_id`),
  ADD KEY `user_level_groups_sector_id_foreign` (`sector_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `user_level_groups`
--
ALTER TABLE `user_level_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `indikator_sectors`
--
ALTER TABLE `indikator_sectors`
  ADD CONSTRAINT `indikator_sectors_secretariat_id_foreign` FOREIGN KEY (`secretariat_id`) REFERENCES `secretariats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `indikator_sectors_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `performa_sectors`
--
ALTER TABLE `performa_sectors`
  ADD CONSTRAINT `performa_sectors_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `secretariats`
--
ALTER TABLE `secretariats`
  ADD CONSTRAINT `secretariats_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `secretariats_user_level_id_foreign` FOREIGN KEY (`user_level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_level_groups`
--
ALTER TABLE `user_level_groups`
  ADD CONSTRAINT `user_level_groups_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_level_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_level_groups_user_level_id_foreign` FOREIGN KEY (`user_level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
