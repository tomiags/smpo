-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_smpo`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_po`
--

CREATE TABLE `approval_po` (
  `id_approval` int(11) UNSIGNED NOT NULL,
  `id_po` int(11) UNSIGNED NOT NULL,
  `status` enum('approve','reject','','') NOT NULL,
  `catatan` text NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval_po`
--

INSERT INTO `approval_po` (`id_approval`, `id_po`, `status`, `catatan`, `created_by`, `created_at`) VALUES
(1, 1, 'reject', 'Testing hanya saja', 1, '2025-12-09 16:28:51'),
(2, 3, 'approve', 'Disetujui', 1, '2025-12-09 16:30:05'),
(3, 4, 'approve', 'Disetujui', 1, '2025-12-09 21:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'super admin'),
(2, 'purchasing', 'purchasing'),
(3, 'finance', 'finance keuangan');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 6),
(2, 2),
(2, 5),
(2, 7),
(2, 8),
(2, 11),
(2, 12),
(3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'admin@smpo.com', 1, '2025-12-04 14:35:32', 1),
(2, '::1', 'admin@smpo.com', 1, '2025-12-04 14:38:25', 1),
(3, '::1', 'admin@smpo.com', 1, '2025-12-04 14:41:51', 1),
(4, '::1', 'admin@smpo.com', 1, '2025-12-04 14:43:09', 1),
(5, '::1', 'admin@smpo.com', 1, '2025-12-04 14:46:02', 1),
(6, '::1', 'admin@smpo.com', 1, '2025-12-04 14:48:28', 1),
(7, '::1', 'admin@smpo.com', 1, '2025-12-04 14:48:34', 1),
(8, '::1', 'admin@smpo.com', 1, '2025-12-04 14:49:29', 1),
(9, '::1', 'admin@smpo.com', 1, '2025-12-04 14:50:48', 1),
(10, '::1', 'admin@smpo.com', 1, '2025-12-04 14:54:30', 1),
(11, '::1', 'admin@smpo.com', 1, '2025-12-04 15:12:13', 1),
(12, '::1', 'admin@smpo.com', 1, '2025-12-04 15:12:43', 1),
(13, '::1', 'admin@smpo.com', 1, '2025-12-04 15:13:06', 1),
(14, '::1', 'admin@smpo.com', 1, '2025-12-04 15:15:59', 1),
(15, '::1', 'admin@smpo.com', 1, '2025-12-04 16:12:57', 1),
(16, '::1', 'admin@smpo.com', 1, '2025-12-04 16:18:44', 1),
(17, '::1', 'aseee', NULL, '2025-12-04 17:41:49', 0),
(18, '::1', 'aseee', NULL, '2025-12-04 17:42:00', 0),
(19, '::1', 'admin@smpo.com', 1, '2025-12-04 17:42:10', 1),
(20, '::1', 'admin@smpo.com', 1, '2025-12-05 13:10:37', 1),
(21, '::1', 'bayuuu', NULL, '2025-12-05 14:28:42', 0),
(22, '::1', 'agung', NULL, '2025-12-05 14:28:58', 0),
(23, '::1', 'admin@smpo.com', 1, '2025-12-05 14:29:04', 1),
(24, '::1', 'adam', NULL, '2025-12-05 14:40:36', 0),
(25, '::1', 'adam', NULL, '2025-12-05 14:40:44', 0),
(26, '::1', 'admin@smpo.com', 1, '2025-12-05 14:40:50', 1),
(27, '::1', 'rae@fsfgsg.vy', 9, '2025-12-05 14:45:05', 1),
(28, '::1', 'admin@smpo.com', 1, '2025-12-05 14:45:27', 1),
(29, '::1', 'rae@fsfgsg.vy', 9, '2025-12-05 14:46:07', 1),
(30, '::1', 'admin@smpo.com', 1, '2025-12-05 14:46:36', 1),
(31, '::1', 'melodi@gmail.com', 11, '2025-12-05 15:04:51', 1),
(32, '::1', 'admin@smpo.com', 1, '2025-12-05 15:05:11', 1),
(33, '::1', 'admin@smpo.com', 1, '2025-12-05 17:16:33', 1),
(34, '::1', 'admin@smpo.com', 1, '2025-12-06 05:43:45', 1),
(35, '::1', 'admin@smpo.com', 1, '2025-12-06 15:59:26', 1),
(36, '::1', 'admin@smpo.com', 1, '2025-12-06 16:00:22', 1),
(37, '::1', 'admin@smpo.com', 1, '2025-12-06 16:02:16', 1),
(38, '::1', 'admin@smpo.com', 1, '2025-12-09 11:03:30', 1),
(39, '::1', 'admin@smpo.com', 1, '2025-12-09 13:30:19', 1),
(40, '::1', 'admin@smpo.com', 1, '2025-12-09 20:42:18', 1),
(41, '::1', 'admin@smpo.com', 1, '2025-12-10 13:01:03', 1),
(42, '::1', 'admin@smpo.com', 1, '2025-12-10 13:36:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` char(100) NOT NULL,
  `nama_barang` text NOT NULL,
  `harga_barang` int(50) DEFAULT 0,
  `stok_barang` int(50) DEFAULT 0,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `harga_barang`, `stok_barang`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('HJA-KLO-12', 'HIJACK 12', 10000, 0, 1, NULL, '2025-12-10 13:09:33', '2025-12-10 13:09:33', NULL),
('HNO-1010', 'CUP PISTON HNO-32217-1010 / CUP PISTON S322171010 HINO', 157000, 0, 1, 1, '2025-12-06 05:49:00', '2025-12-06 05:49:12', NULL),
('LAH-KER-000-4RG', 'LAHER KERONCONG GIGI 4 HINO RG SZ3647-3002 / NEEDLE BEARING GIGI 4 RG HINO SZ364373002', 295000, 0, 1, 1, '2025-12-05 17:39:48', '2025-12-05 17:52:45', NULL),
('LHDQ-JDWAG-18181', 'BAHDGHADGYADAD', 100000, 0, 1, NULL, '2025-12-05 17:40:34', '2025-12-05 17:42:41', '2025-12-05 17:42:41'),
('LHR-AS-PRS-RG', 'LAHER AS PRIS HINO RG S3460-51360 / LAGER ROKOK RG S346051360 (15)', 770000, 0, 1, NULL, '2025-12-06 05:50:33', '2025-12-06 05:50:33', NULL),
('LMAF-12AS', 'LINGUMAS KLOTER 12AS', 50500, 0, 1, NULL, '2025-12-10 13:11:55', '2025-12-10 13:11:55', NULL),
('RIN-SM-185-RG', 'FILTER SOLAR BAWAH R280 23304-JAF40', 1450000, 0, 1, NULL, '2025-12-05 17:53:21', '2025-12-05 17:53:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_departemen` int(11) UNSIGNED NOT NULL,
  `nama_departemen` varchar(250) NOT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_departemen`, `nama_departemen`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KANTOR', 1, 1, '2025-12-05 15:44:44', '2025-12-05 15:45:31', NULL),
(2, 'GUDANG', 1, NULL, '2025-12-05 15:45:43', '2025-12-05 15:45:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_users`
--

CREATE TABLE `detail_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenkel` enum('L','P') DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `no_tlp` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `detail_users`
--

INSERT INTO `detail_users` (`id`, `user_id`, `nama_user`, `jabatan`, `tgl_lahir`, `jenkel`, `tempat_lahir`, `no_tlp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 'Admin', 'admin', '2025-12-02', 'L', 'Cirebon', '0865854745', '2025-12-04 21:17:07', '2025-12-04 21:17:07', NULL),
(8, 8, 'Adam', 'purchasing', '2025-12-03', 'L', 'Cirebon', '08986865', '2025-12-05 21:30:42', '2025-12-05 21:30:42', NULL),
(11, 11, 'Melodi', 'purchasing', '2025-11-30', 'P', 'Cirebon', '0844241121123', '2025-12-05 22:03:07', '2025-12-06 15:37:00', NULL),
(12, 12, 'Andi', 'purchasing', '2025-11-30', 'L', 'Cirebon', '0833313', '2025-12-06 15:35:38', '2025-12-06 15:35:38', NULL),
(13, 13, 'Bayu', 'finance', '2025-11-30', 'L', 'Cirebon', '08888888', '2025-12-06 15:36:18', '2025-12-06 15:36:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'App\\Database\\Migrations\\CreateAuthTables', 'default', 'App', 1764856678, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_bayar` int(11) UNSIGNED NOT NULL,
  `id_transaksi` int(11) UNSIGNED NOT NULL,
  `tgl_bayar` date NOT NULL,
  `metode` enum('cash','transfer','') NOT NULL,
  `jumlah_bayar` int(100) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_bayar`, `id_transaksi`, `tgl_bayar`, `metode`, `jumlah_bayar`, `catatan`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 5, '2025-12-09', 'transfer', 1000000, 'trf ke bank 000000000', 1, NULL, '2025-12-09 22:16:09', '2025-12-09 23:08:07', '2025-12-09 23:08:07'),
(4, 6, '2025-12-09', 'transfer', 1500000, 'tf ke bank Mandiri', 1, NULL, '2025-12-09 23:10:38', '2025-12-10 00:36:48', NULL),
(5, 7, '2025-12-09', 'cash', 1570000, 'lunasssss', 1, NULL, '2025-12-09 23:12:57', '2025-12-10 13:04:08', '2025-12-10 13:04:08'),
(6, 6, '2025-12-09', 'cash', 1000000, 'cash', 1, NULL, '2025-12-09 23:24:36', '2025-12-09 23:24:36', NULL),
(7, 6, '2025-12-09', 'transfer', 557000, 'trf ke bank bca va', 1, NULL, '2025-12-09 23:26:13', '2025-12-10 00:30:07', '2025-12-10 00:30:07'),
(8, 7, '2025-12-10', 'cash', 1570000, 'dibayar lewat kurir', 1, NULL, '2025-12-10 13:05:28', '2025-12-10 13:05:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pool`
--

CREATE TABLE `pool` (
  `kode_pool` char(100) NOT NULL,
  `nama_pool` varchar(250) NOT NULL,
  `lokasi_pool` text NOT NULL,
  `kota_pool` varchar(100) NOT NULL,
  `prov_pool` varchar(100) NOT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pool`
--

INSERT INTO `pool` (`kode_pool`, `nama_pool`, `lokasi_pool`, `kota_pool`, `prov_pool`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('POOL001', 'BHINNEKA SANGKURIANG CIREBON', 'Jl. Cinta Sekali', 'CIREBON', 'JAWA BARAT', 1, NULL, '2025-12-05 13:45:40', '2025-12-05 13:45:40', NULL),
('POOL002', 'BHINNEKA SANGKURIANG SUKABUMI', 'Jl. Rehat sejenak no.12', 'SUKABUMI', 'JAWA BARAT', 1, 1, '2025-12-05 13:46:13', '2025-12-05 13:51:57', NULL),
('POOL003', 'ASEEQ', 'adadadqqqq', 'FAFAF', 'FAFAF', 1, 1, '2025-12-05 17:38:37', '2025-12-05 17:58:11', '2025-12-05 17:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

CREATE TABLE `po_items` (
  `id_po_items` int(11) NOT NULL,
  `id_po` int(11) UNSIGNED NOT NULL,
  `kode_barang` char(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `harga_satuan` int(100) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `po_items`
--

INSERT INTO `po_items` (`id_po_items`, `id_po`, `kode_barang`, `qty`, `harga_satuan`, `subtotal`, `catatan`) VALUES
(15, 1, 'LHR-AS-PRS-RG', 2, 770000, 1540000, 'teeeesss'),
(16, 1, 'LAH-KER-000-4RG', 10, 295000, 2950000, 'yuuuuu'),
(21, 3, 'HNO-1010', 1, 157000, 157000, 'oblo'),
(22, 3, 'LAH-KER-000-4RG', 2, 295000, 590000, ''),
(23, 3, 'LHR-AS-PRS-RG', 3, 770000, 2310000, ''),
(24, 4, 'HNO-1010', 10, 157000, 1570000, 'teeeeeeeeessss'),
(25, 5, 'LAH-KER-000-4RG', 4, 295000, 1180000, ''),
(29, 6, 'LHR-AS-PRS-RG', 10, 770000, 7700000, 'testing note');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id_po` int(11) UNSIGNED NOT NULL,
  `no_po` char(100) DEFAULT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `id_supplier` int(11) UNSIGNED NOT NULL,
  `id_departemen` int(11) UNSIGNED NOT NULL,
  `kode_pool` char(100) NOT NULL,
  `tgl_po` date NOT NULL,
  `status_po` enum('draft','approve','reject','send') NOT NULL DEFAULT 'draft',
  `catatan` text DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id_po`, `no_po`, `id_user`, `id_supplier`, `id_departemen`, `kode_pool`, `tgl_po`, `status_po`, `catatan`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BST-PO-00001', 1, 2, 2, 'POOL001', '2025-12-06', 'reject', NULL, 1, 1, '2025-12-06 07:17:02', '2025-12-09 16:28:51', NULL),
(3, 'BST-PO-00003', 1, 2, 2, 'POOL002', '2025-12-06', 'approve', NULL, 1, 1, '2025-12-06 15:27:12', '2025-12-09 16:30:05', NULL),
(4, 'BST-PO-00004', 1, 4, 2, 'POOL001', '2025-12-09', 'approve', NULL, 1, 1, '2025-12-09 21:03:07', '2025-12-09 21:03:17', NULL),
(5, 'BST-PO-00005', 1, 2, 1, 'POOL001', '2025-12-09', 'send', NULL, 1, 1, '2025-12-09 21:48:49', '2025-12-09 21:48:54', NULL),
(6, 'BST-PO-00006', 1, 2, 2, 'POOL002', '2025-12-09', 'draft', NULL, 1, 1, '2025-12-09 23:21:19', '2025-12-10 13:41:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) UNSIGNED NOT NULL,
  `nama_supplier` varchar(250) NOT NULL,
  `no_tlp` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat_supplier` text NOT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_tlp`, `email`, `alamat_supplier`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'PT. JAYA ABADI', '082122844', 'jayaabadi@gmail.com', 'Jl. Sangkuni Jawa Barat', 1, NULL, '2025-12-05 14:16:03', '2025-12-05 14:16:03', NULL),
(4, 'PT. MENCARI CINTA SEJATI', '02166733113', 'mcs@gmail.com', 'Jl. satu dua tiga Jawa Barat', 1, NULL, '2025-12-06 05:51:56', '2025-12-06 05:51:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) UNSIGNED NOT NULL,
  `id_po` int(11) UNSIGNED NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `total_tagihan` int(100) NOT NULL,
  `status_bayar` enum('belum','lunas','') NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_po`, `tgl_transaksi`, `total_tagihan`, `status_bayar`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 3, '2025-12-09', 3057000, 'belum', 1, NULL, '2025-12-09 22:16:09', '2025-12-09 23:08:07', '2025-12-09 23:08:07'),
(6, 3, '2025-12-09', 3057000, 'belum', 1, NULL, '2025-12-09 23:10:38', '2025-12-10 00:30:07', NULL),
(7, 4, '2025-12-09', 1570000, 'lunas', 1, NULL, '2025-12-09 23:12:57', '2025-12-10 13:05:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@smpo.com', 'admin', '$2y$10$bDw4zdL6zLQuBPlMxM3rFeggSktgXOKNhtvuVlJie2J/35sG3Rxiy', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2025-12-05 15:20:03', NULL),
(8, 'adam@gmail.com', 'adam', '$2y$10$9RSOdBmElvPgxHrxS/VNG.aoiF3R8AGcuMI/7Rvdd4ZJsVKA/LuE2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-12-05 14:30:42', '2025-12-05 14:30:42', NULL),
(11, 'melodi@gmail.com', 'melodi', '$2y$10$5DetNzBUinpr7YtskthYa.6MksSG6I6K5r/Rix791CCcAgkCvCuoW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-12-05 15:03:07', '2025-12-05 15:22:47', NULL),
(12, 'andi@gmail.com', 'andi', '$2y$10$S8KVwhdBCyBs0./8iW/yCu1.up7uM/jpAoVU1DnPqk4bB7I4wRzO2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-12-06 15:35:38', '2025-12-06 15:35:38', NULL),
(13, 'bayu@gmail.com', 'bayu', '$2y$10$6Oau/ww5eZrwiW0YR0imV.XHYAfAfsVbShjxzbNgKyiiB0ZHsZx52', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-12-06 15:36:18', '2025-12-06 15:36:18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_po`
--
ALTER TABLE `approval_po`
  ADD PRIMARY KEY (`id_approval`),
  ADD KEY `FK_PO_Approval` (`id_po`),
  ADD KEY `FK_Approved_By` (`created_by`);

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `FK_Barang_Created` (`created_by`),
  ADD KEY `FK_Barang_Updated` (`updated_by`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_departemen`),
  ADD KEY `FK_Dept_Created` (`created_by`),
  ADD KEY `FK_Dept_Updated` (`updated_by`);

--
-- Indexes for table `detail_users`
--
ALTER TABLE `detail_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_User_Detail` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_bayar`),
  ADD KEY `FK_Byr_Transaksi` (`id_transaksi`),
  ADD KEY `FK_Byr_Created` (`created_by`),
  ADD KEY `FK_Byr_Updated` (`updated_by`);

--
-- Indexes for table `pool`
--
ALTER TABLE `pool`
  ADD PRIMARY KEY (`kode_pool`),
  ADD KEY `FK_Pool_Created` (`created_by`),
  ADD KEY `FK_Pool_Updated` (`updated_by`);

--
-- Indexes for table `po_items`
--
ALTER TABLE `po_items`
  ADD PRIMARY KEY (`id_po_items`),
  ADD KEY `FK_PO_Item` (`id_po`),
  ADD KEY `FK_PO_Barang` (`kode_barang`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id_po`),
  ADD UNIQUE KEY `no_po` (`no_po`),
  ADD KEY `FK_User_PO` (`id_user`),
  ADD KEY `FK_Dept_PO` (`id_departemen`),
  ADD KEY `FK_Pool_PO` (`kode_pool`),
  ADD KEY `FK_Created_PO` (`created_by`),
  ADD KEY `FK_Updated_PO` (`updated_by`),
  ADD KEY `FK_Supplier_PO` (`id_supplier`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD KEY `FK_Supplier_Created` (`created_by`),
  ADD KEY `FK_Supplier_Updated` (`updated_by`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `FK_PO_Transaksi` (`id_po`),
  ADD KEY `FK_Created_Transaksi` (`created_by`),
  ADD KEY `FK_Updated_Transaksi` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_po`
--
ALTER TABLE `approval_po`
  MODIFY `id_approval` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_departemen` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_users`
--
ALTER TABLE `detail_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_bayar` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `po_items`
--
ALTER TABLE `po_items`
  MODIFY `id_po_items` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id_po` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval_po`
--
ALTER TABLE `approval_po`
  ADD CONSTRAINT `FK_Approved_By` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_PO_Approval` FOREIGN KEY (`id_po`) REFERENCES `purchase_order` (`id_po`);

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `FK_Byr_Created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_Byr_Transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `FK_Byr_Updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_Created_Transaksi` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_PO_Transaksi` FOREIGN KEY (`id_po`) REFERENCES `purchase_order` (`id_po`),
  ADD CONSTRAINT `FK_Updated_Transaksi` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
