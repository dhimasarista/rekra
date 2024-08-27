-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 01:11 PM
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
-- Database: `rekra_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calon`
--

CREATE TABLE `calon` (
  `id` char(36) NOT NULL,
  `code` int(11) NOT NULL,
  `calon_name` varchar(255) NOT NULL,
  `wakil_name` varchar(255) NOT NULL,
  `level` enum('provinsi','kabkota') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jumlah_suara`
--

CREATE TABLE `jumlah_suara` (
  `id` char(36) NOT NULL,
  `amount` int(11) NOT NULL,
  `note` text NOT NULL,
  `tps_id` char(36) NOT NULL,
  `calon_id` char(36) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kabkota`
--

CREATE TABLE `kabkota` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `provinsi_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kabkota`
--

INSERT INTO `kabkota` (`id`, `name`, `provinsi_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2101, 'karimun', 21, NULL, NULL, NULL),
(2102, 'bintan', 21, NULL, NULL, NULL),
(2103, 'natuna', 21, NULL, NULL, NULL),
(2104, 'lingga', 21, NULL, NULL, NULL),
(2105, 'kepulauan anambas', 21, NULL, NULL, NULL),
(2171, 'kota batam', 21, NULL, NULL, NULL),
(2172, 'kota tanjungpinang', 21, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `kabkota_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `name`, `kabkota_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
('019122cb-2a69-71c5-9704-65598c10f344', 'batam kota', 2171, NULL, '2024-08-06 02:16:16', NULL),
('019122cb-2a6a-7248-bd69-16bfd164bf04', 'lubuk baja', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd1a53743', 'bengkong', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd1b106ff', 'batu ampar', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd2357773', 'nongsa', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd30a857d', 'sei beduk', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd348dc86', 'bulang', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd43c9cf9', 'galang', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd4d85f36', 'sagulung', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd4f4305b', 'batu aji', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd59d8480', 'sekupang', 2171, NULL, NULL, NULL),
('019122cb-2a6a-7248-bd69-16bfd68a0aef', 'belakang padang', 2171, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `kecamatan_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `name`, `kecamatan_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01912378-f02b-736b-ae9c-05ba0dbee75d', 'belian', '019122cb-2a69-71c5-9704-65598c10f344', NULL, NULL, NULL),
('0191237a-d705-73e9-ba24-3387ce66e684', 'baloi permai', '019122cb-2a69-71c5-9704-65598c10f344', NULL, '2024-08-10 00:57:29', NULL),
('0191237a-d707-70d9-8924-4a06813d5aa0', 'sukajadi', '019122cb-2a69-71c5-9704-65598c10f344', NULL, NULL, NULL),
('0191237a-d707-70d9-8924-4a0681a6ce14', 'sungai panas', '019122cb-2a69-71c5-9704-65598c10f344', NULL, NULL, NULL),
('0191237a-d707-70d9-8924-4a0681d0d7a0', 'taman baloi', '019122cb-2a69-71c5-9704-65598c10f344', NULL, NULL, NULL),
('0191237a-d707-70d9-8924-4a0682889f69', 'teluk tering', '019122cb-2a69-71c5-9704-65598c10f344', NULL, NULL, NULL),
('019124eb-1b81-725d-82ff-c81c7daacaca', 'baloi indah', '019122cb-2a6a-7248-bd69-16bfd164bf04', NULL, NULL, NULL),
('019124eb-1b82-708b-8e77-093b7a68abd8', 'batu selicin', '019122cb-2a6a-7248-bd69-16bfd164bf04', NULL, NULL, NULL),
('019124eb-1b82-708b-8e77-093b7aba0b21', 'kampung pelita', '019122cb-2a6a-7248-bd69-16bfd164bf04', NULL, NULL, NULL),
('019124eb-1b82-708b-8e77-093b7b0fab68', 'lubuk baja kota', '019122cb-2a6a-7248-bd69-16bfd164bf04', NULL, NULL, NULL),
('019124eb-1b82-708b-8e77-093b7b4a8bc9', 'tanjung uma', '019122cb-2a6a-7248-bd69-16bfd164bf04', NULL, NULL, NULL),
('019124eb-cbae-7142-bd5c-f7f8d608f6f0', 'bengkong indah', '019122cb-2a6a-7248-bd69-16bfd1a53743', NULL, NULL, NULL),
('019124eb-cbaf-71be-a33a-6d3faa1a2c36', 'bengkong laut', '019122cb-2a6a-7248-bd69-16bfd1a53743', NULL, NULL, NULL),
('019124eb-cbaf-71be-a33a-6d3fab04cde1', 'sadai', '019122cb-2a6a-7248-bd69-16bfd1a53743', NULL, NULL, NULL),
('019124eb-cbaf-71be-a33a-6d3fab1d4801', 'tanjung buntung', '019122cb-2a6a-7248-bd69-16bfd1a53743', NULL, NULL, NULL),
('019124ec-8a51-7084-9938-8ab0de9f784c', 'batu merah', '019122cb-2a6a-7248-bd69-16bfd1b106ff', NULL, NULL, NULL),
('019124ec-8a52-72d4-b9fe-5e1f8feb3bbc', 'kampung seraya', '019122cb-2a6a-7248-bd69-16bfd1b106ff', NULL, NULL, NULL),
('019124ec-8a52-72d4-b9fe-5e1f9002867a', 'sungai jodoh', '019122cb-2a6a-7248-bd69-16bfd1b106ff', NULL, NULL, NULL),
('019124ec-8a52-72d4-b9fe-5e1f910141a1', 'tanjung sengkuang', '019122cb-2a6a-7248-bd69-16bfd1b106ff', NULL, NULL, NULL),
('019124ed-1a24-70c3-b5db-0c6144baab66', 'kasu', '019122cb-2a6a-7248-bd69-16bfd68a0aef', NULL, NULL, NULL),
('019124ed-1a25-72ab-8ad7-e7a9fdbeda07', 'pecong', '019122cb-2a6a-7248-bd69-16bfd68a0aef', NULL, NULL, NULL),
('019124ed-1a25-72ab-8ad7-e7a9fe65a066', 'pemping', '019122cb-2a6a-7248-bd69-16bfd68a0aef', NULL, NULL, NULL),
('019124ed-1a25-72ab-8ad7-e7a9ff1983db', 'pulau terong', '019122cb-2a6a-7248-bd69-16bfd68a0aef', NULL, NULL, NULL),
('019124ed-1a25-72ab-8ad7-e7a9ff4d69e5', 'sekanak raya', '019122cb-2a6a-7248-bd69-16bfd68a0aef', NULL, NULL, NULL),
('019124ed-1a25-72ab-8ad7-e7a9ffbea5a2', 'tanjung sari', '019122cb-2a6a-7248-bd69-16bfd68a0aef', NULL, NULL, NULL),
('019124ee-160e-7122-82ee-c697710f317c', 'batu legong', '019122cb-2a6a-7248-bd69-16bfd348dc86', NULL, NULL, NULL),
('019124ee-1610-7157-a561-83943a8132ab', 'bulang lintang', '019122cb-2a6a-7248-bd69-16bfd348dc86', NULL, NULL, NULL),
('019124ee-1610-7157-a561-83943a8cc68f', 'pantai gelam', '019122cb-2a6a-7248-bd69-16bfd348dc86', NULL, NULL, NULL),
('019124ee-1610-7157-a561-83943aff3d6f', 'pulau buluh', '019122cb-2a6a-7248-bd69-16bfd348dc86', NULL, NULL, NULL),
('019124ee-1610-7157-a561-83943b571d39', 'setokok', '019122cb-2a6a-7248-bd69-16bfd348dc86', NULL, NULL, NULL),
('019124ee-1610-7157-a561-83943beefc6d', 'temoyong', '019122cb-2a6a-7248-bd69-16bfd348dc86', NULL, NULL, NULL),
('019124ee-c629-73b4-a237-5cf2862d184b', 'air raja', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f424fef66d43', 'galang baru', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f424ff65c270', 'karas', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f4250011a85e', 'pulau abang', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f4250110ae81', 'rempang cate', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f42501d146f2', 'sembulang', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f42502047dbb', 'sijantung', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ee-c62a-719b-979b-f4250216c4c1', 'subang mas', '019122cb-2a6a-7248-bd69-16bfd43c9cf9', NULL, NULL, NULL),
('019124ef-3f14-7223-a0b9-fd7e9077f80b', 'batu besar', '019122cb-2a6a-7248-bd69-16bfd2357773', NULL, NULL, NULL),
('019124ef-3f15-72f5-8ce1-2022ed9265e4', 'kabil', '019122cb-2a6a-7248-bd69-16bfd2357773', NULL, NULL, NULL),
('019124ef-3f15-72f5-8ce1-2022edd021ce', 'ngenang', '019122cb-2a6a-7248-bd69-16bfd2357773', NULL, NULL, NULL),
('019124ef-3f15-72f5-8ce1-2022ee0680b6', 'sambau', '019122cb-2a6a-7248-bd69-16bfd2357773', NULL, NULL, NULL),
('019124f0-23af-7142-a287-d5e173c3733f', 'bukit tempayan', '019122cb-2a6a-7248-bd69-16bfd4f4305b', NULL, NULL, NULL),
('019124f0-23b0-70e9-8650-a5975288f4a3', 'buliang', '019122cb-2a6a-7248-bd69-16bfd4f4305b', NULL, NULL, NULL),
('019124f0-23b0-70e9-8650-a59753654947', 'kibing', '019122cb-2a6a-7248-bd69-16bfd4f4305b', NULL, NULL, NULL),
('019124f0-23b0-70e9-8650-a5975407824b', 'tanjung uncang', '019122cb-2a6a-7248-bd69-16bfd4f4305b', NULL, NULL, NULL),
('019124f1-8b14-7295-98fb-1558bac8e39a', 'sagulung kota', '019122cb-2a6a-7248-bd69-16bfd4d85f36', NULL, NULL, NULL),
('019124f1-8b15-71cb-ac41-9aa87c1b81fe', 'sungai binti', '019122cb-2a6a-7248-bd69-16bfd4d85f36', NULL, NULL, NULL),
('019124f1-8b15-71cb-ac41-9aa87c4b0a5d', 'sungai langkai', '019122cb-2a6a-7248-bd69-16bfd4d85f36', NULL, NULL, NULL),
('019124f1-8b15-71cb-ac41-9aa87c6b097e', 'sungai lekop', '019122cb-2a6a-7248-bd69-16bfd4d85f36', NULL, NULL, NULL),
('019124f1-8b15-71cb-ac41-9aa87c79845d', 'sungai pelunggut', '019122cb-2a6a-7248-bd69-16bfd4d85f36', NULL, NULL, NULL),
('019124f1-8b15-71cb-ac41-9aa87ca601ec', 'tembesi', '019122cb-2a6a-7248-bd69-16bfd4d85f36', NULL, NULL, NULL),
('019124f2-1db8-737e-9644-4c4fda944ede', 'duriangkang', '019122cb-2a6a-7248-bd69-16bfd30a857d', NULL, NULL, NULL),
('019124f2-1db9-70b2-a8cc-458e6b4fb020', 'mangsang', '019122cb-2a6a-7248-bd69-16bfd30a857d', NULL, NULL, NULL),
('019124f2-1db9-70b2-a8cc-458e6b774424', 'muka kuning', '019122cb-2a6a-7248-bd69-16bfd30a857d', NULL, NULL, NULL),
('019124f2-1db9-70b2-a8cc-458e6bbb7327', 'tanjung piayu', '019122cb-2a6a-7248-bd69-16bfd30a857d', NULL, NULL, NULL),
('019124f2-d805-72ac-8901-075062ca3e20', 'patam lestari', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL),
('019124f2-d808-731b-b947-d88a045a176f', 'sungai harapan', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL),
('019124f2-d809-7344-9d0f-0348394a8d4a', 'tanjung pinggir', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL),
('019124f2-d809-7344-9d0f-03483a1b36f2', 'tanjung riau', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL),
('019124f2-d809-7344-9d0f-03483a2a6963', 'tiban baru', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL),
('019124f2-d809-7344-9d0f-03483a3e58aa', 'tiban indah', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL),
('019124f2-d809-7344-9d0f-03483a61b69b', 'tiban lama', '019122cb-2a6a-7248-bd69-16bfd59d8480', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_histories`
--

CREATE TABLE `login_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_histories`
--

INSERT INTO `login_histories` (`id`, `user_id`, `username`, `login_at`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, '019122c9-7133-7388-89d2-885cf38e7ca3', 'masterdev', '2024-08-25 04:10:59', '127.0.0.1', '2024-08-25 04:10:59', '2024-08-25 04:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(81, '0001_01_01_000001_create_cache_table', 1),
(82, '0001_01_01_000002_create_jobs_table', 1),
(83, '2024_07_20_044213_create_provinsi_table', 1),
(84, '2024_07_20_044611_create_kabkota_table', 1),
(85, '2024_07_20_045056_create_users_table', 1),
(86, '2024_07_21_180930_create_calons_table', 1),
(87, '2024_07_21_184532_create_kecamatans_table', 1),
(88, '2024_07_21_185306_create_kelurahans_table', 1),
(89, '2024_07_21_185344_create_tps_table', 1),
(90, '2024_07_21_185345_create_jumlah_suaras_table', 1),
(91, '2024_08_24_150808_create_login_histories_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, 'kepulauan riau', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tps`
--

CREATE TABLE `tps` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `kelurahan_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tps`
-
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `code` int(11) NOT NULL,
  `level` enum('master','provinsi','kabkota') NOT NULL DEFAULT 'kabkota',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `calon_calon_name_unique` (`calon_name`),
  ADD UNIQUE KEY `calon_wakil_name_unique` (`wakil_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jumlah_suara`
--
ALTER TABLE `jumlah_suara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jumlah_suara_tps_id_foreign` (`tps_id`),
  ADD KEY `jumlah_suara_calon_id_foreign` (`calon_id`);

--
-- Indexes for table `kabkota`
--
ALTER TABLE `kabkota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kabkota_name_unique` (`name`),
  ADD KEY `kabkota_provinsi_id_foreign` (`provinsi_id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kecamatan_name_unique` (`name`),
  ADD KEY `kecamatan_kabkota_id_foreign` (`kabkota_id`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelurahan_name_unique` (`name`),
  ADD KEY `kelurahan_kecamatan_id_foreign` (`kecamatan_id`);

--
-- Indexes for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provinsi_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tps`
--
ALTER TABLE `tps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tps_kelurahan_id_foreign` (`kelurahan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kabkota`
--
ALTER TABLE `kabkota`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2173;

--
-- AUTO_INCREMENT for table `login_histories`
--
ALTER TABLE `login_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jumlah_suara`
--
ALTER TABLE `jumlah_suara`
  ADD CONSTRAINT `jumlah_suara_calon_id_foreign` FOREIGN KEY (`calon_id`) REFERENCES `calon` (`id`),
  ADD CONSTRAINT `jumlah_suara_tps_id_foreign` FOREIGN KEY (`tps_id`) REFERENCES `tps` (`id`);

--
-- Constraints for table `kabkota`
--
ALTER TABLE `kabkota`
  ADD CONSTRAINT `kabkota_provinsi_id_foreign` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsi` (`id`);

--
-- Constraints for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD CONSTRAINT `kecamatan_kabkota_id_foreign` FOREIGN KEY (`kabkota_id`) REFERENCES `kabkota` (`id`);

--
-- Constraints for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`);

--
-- Constraints for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD CONSTRAINT `login_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tps`
--
ALTER TABLE `tps`
  ADD CONSTRAINT `tps_kelurahan_id_foreign` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
