-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 31, 2026 at 02:13 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventtiket_db3267`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Seminar IT', 'seminar-it', '2026-07-15 18:20:52', '2026-07-15 18:20:52'),
(2, 'Workshop', 'workshop', '2026-07-15 18:20:52', '2026-07-15 18:20:52'),
(3, 'Entertainment', 'entertainment', '2026-07-15 18:20:52', '2026-07-15 18:20:52'),
(4, 'Hiburan', 'hiburan', '2026-07-26 00:54:02', '2026-07-26 00:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `partner_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `stock` int NOT NULL,
  `poster_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `category_id`, `partner_id`, `title`, `description`, `date`, `location`, `price`, `stock`, `poster_path`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'AI Conference 2026', 'Belajar AI terbaru.', '2026-10-22 10:00:00', 'Auditorium', 75000, 99, 'posters/5VnWmueTznoYvaf4ApgesfWb4mRErIghwhEBglow.jpg', '2026-07-15 18:20:52', '2026-07-30 18:35:17'),
(2, 1, 1, 'Cyber Security Talk', 'Keamanan digital modern.', '2026-06-05 13:00:00', 'Lab 1', 50000, 80, 'posters/y4hqLC4RLlDB4PaMlTjckiXGVyyGCJ3boxIyaY15.jpg', '2026-07-15 18:20:52', '2026-07-26 01:16:29'),
(3, 2, 1, 'UI/UX Masterclass', 'Belajar UI UX.', '2026-08-12 09:00:00', 'Lab Design', 60000, 50, 'posters/kewMxfAU0Et9qQh5XhpGK8v7tyvkS4LGcL6F1Z5E.jpg', '2026-07-15 18:20:52', '2026-07-26 01:23:08'),
(4, 2, 3, 'Laravel Bootcamp', 'Belajar Laravel.', '2026-08-09 09:00:00', 'Lab Programming', 100000, 39, 'posters/q6P3GYYPTcmU0qFLeEmFX4X99DvihwzwaD7gmsqY.jpg', '2026-07-15 18:20:52', '2026-07-26 01:23:56'),
(5, 3, 2, 'E-Sport Tournament', 'Kompetisi Game.', '2026-08-20 18:00:00', 'Hall', 30000, 184, 'posters/E2faa5v8LAWEpv2cg2pqcqEr3iXEZbjUQeaBaBVB.jpg', '2026-07-15 18:20:52', '2026-07-26 01:24:46'),
(6, 4, 2, 'Valorant Competion', 'Pertandingan Valorant, Terbuka untuk Umum', '2026-06-20 19:00:00', 'Lapangan', 120000, 300, 'posters/ROnQ7172gHQG70J4CHyC4cJELRryQFw3Oi1yONQT.jpg', '2026-07-15 18:20:52', '2026-07-26 01:26:47'),
(7, 3, 3, 'Dies Natalis HIMASI', 'Perayaan Ulang Tahun HIMASI yang dimeriahkan dengan lomba lomba untuk seluruh mahasiswa Sistem Informasi Universitas Amikom Yogyakarta', '2026-07-27 09:29:00', 'Citra 2', 0, 98, 'posters/25M9svQtF8Apq23h08ELqQa2g6hjIpnOTUKF2qg1.jpg', '2026-07-26 00:51:03', '2026-07-29 01:20:20'),
(8, 2, 4, 'Beauty & Personal Branding Workshop', 'Beauty & Personal Branding Workshop merupakan pelatihan yang menggabungkan pengembangan citra diri, etika profesional, dan personal grooming. Peserta akan mempelajari cara membangun personal branding yang kuat melalui media sosial profesional, teknik komunikasi, serta penampilan yang sesuai untuk dunia kerja. Workshop juga dilengkapi dengan beauty class dan grooming session dari brand-brand Paragon.', '2026-07-31 12:00:00', 'Cinema Amikom Yogyakarta', 0, 152, 'posters/zKLP5uqq3FaVEFgt6H8p7Uq0bVWSu9GWk3MPaG30.jpg', '2026-07-26 05:43:45', '2026-07-30 18:44:06'),
(9, 3, 4, 'Content Creator Challenge', 'Content Creator Challenge merupakan kompetisi pembuatan konten digital yang bertujuan mengembangkan kreativitas mahasiswa dalam menghasilkan konten edukatif dan inspiratif. Peserta dapat membuat video pendek, reels, maupun konten media sosial bertema beauty, self-development, sustainability, atau gaya hidup sehat sesuai dengan nilai-nilai yang diusung Paragon.', '2026-07-29 20:45:00', 'Pakuwon Mall Jogja', 150000, 78, 'posters/kRWEBK5OqiaR2jlNbo5MYfOjx8KFbRB2uuletC3y.jpg', '2026-07-26 05:54:17', '2026-07-29 01:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatans`
--

CREATE TABLE `jabatans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatans`
--

INSERT INTO `jabatans` (`id`, `name`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Wakil', 'admin', '2026-07-15 18:34:56', '2026-07-15 18:35:10', 'admin'),
(2, 'Sekretaris', 'admin', '2026-07-15 18:40:27', '2026-07-15 18:40:41', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_30_100405_create_categories_table', 1),
(5, '2026_03_30_100406_create_events_table', 1),
(6, '2026_03_30_100406_create_transactions_table', 1),
(7, '2026_05_21_085038_create_partners_table', 1),
(8, '2026_07_16_002916_create_jabatans_table', 1),
(9, '2026_07_16_002925_create_penguruses_table', 1),
(10, '2026_07_24_102807_add_google_columns_to_users_table', 2),
(11, '2026_07_24_113320_create_reviews_table', 3),
(12, '2026_07_24_114154_add_user_id_to_transactions_table', 3),
(13, '2026_07_24_120000_add_multi_tenant_columns', 4),
(14, '2026_07_26_045532_add_partner_id_to_users_table', 5),
(15, '2026_07_26_045807_add_description_to_partners', 6),
(16, '2026_07_29_073738_add_reply_to_reviews_table', 6),
(17, '2026_07_29_142307_create_partner_registrations_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `logo_url`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Universitas Amikom Yogyakarta', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXzAOh5RU1VRgDxIzxvrpAIqy3Mp6xMfGqD9TyrvQBot_HiZkWVG9MoZ8&s=10', NULL, '2026-07-24 06:29:33', '2026-07-24 23:29:07'),
(2, 'PT. Bank Central Asia', 'https://images.seeklogo.com/logo-png/23/1/bca-bank-logo-png_seeklogo-232742.png', NULL, '2026-07-24 06:32:39', '2026-07-24 23:30:01'),
(3, 'HIMASI', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlI_fhJZkxmpRaXlBxy4mHdyB_DXIAYqlpUfD0OgypuYiUHbAdpQxRazzu&s=10', 'Himpunan Mahasiswa Sistem Informasi Universitas Amikom Yogyakarta', '2026-07-25 23:22:35', '2026-07-25 23:22:35'),
(4, 'PT. PARAGON', 'https://assets-a1.kompasiana.com/items/album/2025/06/22/paragon-6857a62aed6415524902f1c3.jpg', 'perusahaan manufaktur dan distributor kosmetik nasional terbesar di Indonesia', '2026-07-26 05:35:13', '2026-07-26 05:35:13'),
(5, 'Google Indonesia', 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/800px-Google_2015_logo.svg.png', 'perusahaan teknologi raksasa asal Amerika Serikat yang terkenal sebagai mesin pencari internet terbesar di dunia', '2026-07-29 21:46:58', '2026-07-29 21:46:58'),
(6, 'Tokopedia', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/Tokopedia_2014_logo.svg/800px-Tokopedia_2014_logo.svg.png', 'platform jual beli online', '2026-07-30 18:46:15', '2026-07-30 18:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `partner_registrations`
--

CREATE TABLE `partner_registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partner_registrations`
--

INSERT INTO `partner_registrations` (`id`, `organization_name`, `organization_type`, `logo`, `email`, `phone`, `address`, `description`, `proposal`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
(1, 'Google Indonesia', 'Perusahaan', 'partner-logo/UpIBffYzKudJymI4cNircCixHkUG3QvZqqRhNPZI.jpg', 'google@gmail.com', '087658645326', 'Pacific Century Place Tower Level 45, SCBD Lot 10, Jalan Jenderal Sudirman Nomor 53, Senayan, Kebayoran Baru, Jakarta Selatan 12190', 'perusahaan teknologi raksasa asal Amerika Serikat yang terkenal sebagai mesin pencari internet terbesar di dunia', 'partner-proposal/HtcyLJxKYYYOcGDSneorMqHIPmIsj24PHvvuERY1.pdf', 'approved', NULL, '2026-07-29 21:46:11', '2026-07-29 21:46:58'),
(2, 'Tokopedia', 'Perusahaan', 'partner-logo/aeTLX0P49KIzcd3iFr40DGPaFcVDQ4CurBD8t5kA.png', 'tokopedia@gmail', '087659764657', 'Jl.Tokopedia', 'platform jual beli online', 'partner-proposal/1997wPGL3j2l8L5JUG6gqv1N1jOpNEhpv6zhIKGU.pdf', 'approved', NULL, '2026-07-30 18:39:50', '2026-07-30 18:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id` bigint UNSIGNED NOT NULL,
  `jabatan_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` decimal(15,2) NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id`, `jabatan_id`, `name`, `description`, `salary`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 'ketua', 'Wakil', 9000000.00, 'admin', '2026-07-15 18:39:57', '2026-07-15 18:40:15', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `partner_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `event_id`, `partner_id`, `user_id`, `rating`, `review`, `reply`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, 7, 3, 2, 5, 'keren', NULL, NULL, '2026-07-29 01:21:09', '2026-07-29 01:21:09'),
(2, 8, 4, 1, 5, 'seru banget acaranyaaa', NULL, NULL, '2026-07-29 01:49:02', '2026-07-29 01:49:02'),
(3, 8, 4, 2, 5, 'keren dan seru, ditunggu acara selanjutnyaa', NULL, NULL, '2026-07-29 01:52:38', '2026-07-29 01:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bD2tWcEkCWBKqF3UShXslvqaVgFUABOxOvmuqcFg', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJmOEhRMFJ3WFVUcEpac254V2VNWHd6UzNRUVhoZ0M3cmFBNXd0bDVDIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhcnRuZXJcL3RyYW5zYWN0aW9ucyIsInJvdXRlIjoicGFydG5lci50cmFuc2FjdGlvbnMuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjZ9', 1785462544),
('xgakaZ8zNohGITcSQqHHiFPjOfojDo25l8zR4mdO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4T0xUejBlYzNKYkU1UVhSUVhUc1RtclA1Rk44MlZybXljdlpDdVNVIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=', 1785387717);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `event_id`, `user_id`, `order_id`, `customer_name`, `customer_email`, `customer_phone`, `total_price`, `status`, `snap_token`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 'TRX-1784896067-OGLMq', 'nada', 'anindya.nadaa0@students.amikom.ac.id', '087706739385', 105000, 'success', '764dd891-adee-414b-8a27-2e85f5cccd66', '2026-07-24 05:27:47', '2026-07-24 05:29:58'),
(2, 7, 2, 'TRX-1785068841-qrQWW', 'ANINDYA NADA F.', 'anindya.nadaa0@students.amikom.ac.id', '087706739389', 10000, 'success', 'a59a3235-0118-4a8a-8ae7-5d18db0f2e88', '2026-07-26 05:27:21', '2026-07-26 05:28:06'),
(3, 8, 1, 'TRX-1785070985-bm79p', 'Marcellinus', 'acel@gmail.com', '08786723451', 0, 'success', NULL, '2026-07-26 06:03:05', '2026-07-26 06:03:05'),
(4, 9, 6, 'TRX-1785308668-gY0nV', 'kamala', 'kamala@gmail.com', '08787656124', 155000, 'success', '4ef921cb-1881-49f7-be0e-2fa5a3d77bb2', '2026-07-29 00:04:28', '2026-07-29 00:05:20'),
(5, 7, NULL, 'TRX-1785311424-7WvZS', 'miya', 'miya@gmail.com', '085781923736', 0, 'success', NULL, '2026-07-29 00:50:24', '2026-07-29 00:50:24'),
(6, 9, 2, 'TRX-1785312699-bZxrt', 'ANINDYA NADA', 'anindya.nadaa0@students.amikom.ac.id', '087654321876', 155000, 'success', '830f613b-de94-4049-b0f0-6b308c049b60', '2026-07-29 01:11:39', '2026-07-29 01:12:20'),
(7, 8, 2, 'TRX-1785313732-4qPt9', 'ANINDYA NADA F.', 'anindya.nadaa0@students.amikom.ac.id', '0879765423', 0, 'success', NULL, '2026-07-29 01:28:52', '2026-07-29 01:28:52'),
(8, 1, 2, 'TRX-1785461671-9WMM0', '3267_ANINDYA NADA F.', 'anindya.nadaa0@students.amikom.ac.id', '087689665437', 80000, 'success', '4baf5f4e-86e7-4a89-abbb-a544b77e26e9', '2026-07-30 18:34:31', '2026-07-30 18:35:17'),
(9, 8, NULL, 'TRX-1785462246-3wDlT', 'anin', 'anin@gmail.com', '089876577789', 0, 'success', NULL, '2026-07-30 18:44:06', '2026-07-30 18:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `partner_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `avatar`, `email_verified_at`, `password`, `role`, `partner_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Amikom', 'admin@amikom.ac.id', NULL, NULL, NULL, '$2y$12$y2Dl8ZIg.kXHbxy76gnCM.MbXVSvfHQlDasli3CB.nTiTroGmqxU.', 'admin', NULL, NULL, '2026-07-15 18:20:52', '2026-07-15 18:20:52'),
(2, '3267_ANINDYA NADA F.', 'anindya.nadaa0@students.amikom.ac.id', '109033070632594830857', 'https://lh3.googleusercontent.com/a/ACg8ocIwQ5YBLxvl1604-HTS0nhhQC07wRdYOD5tkWDkrc97tYPlYA=s96-c', NULL, '$2y$12$U3NuVfTP2IwkQQgMjerLBulYV3m79ZsHpjYHkZhl0DysRQNToWRH2', 'user', NULL, NULL, '2026-07-24 04:12:41', '2026-07-24 04:12:41'),
(3, 'HIMASI', 'himasi@gmail.com', NULL, NULL, NULL, '$2y$12$Xfg9Mzu.lkSr0yX6YYI7curjUY102N0zjeBf4RGm15NNFybcoW9DW', 'partner', 3, NULL, '2026-07-25 23:22:35', '2026-07-25 23:22:35'),
(4, 'PT. Bank Central Asia', 'bca@gmail.com', NULL, NULL, NULL, '$2y$12$n9fhRuhGPbbjdCYtRQaLU.Yz.jX4G4/5oBRk3vxk/Q09UlTWixkI6', 'partner', 2, NULL, '2026-07-25 23:24:03', '2026-07-25 23:24:03'),
(5, 'Universitas Amikom Yogyakarta', 'amikom@gmail.com', NULL, NULL, NULL, '$2y$12$o7QMLM9dNhSguS54THzMdOggaio.HsCHrNDptzGpSBczIQbTTi99C', 'partner', 1, NULL, '2026-07-25 23:24:39', '2026-07-25 23:24:39'),
(6, 'PT. PARAGON', 'paragon@gmail.com', NULL, NULL, NULL, '$2y$12$OOK0/V.JAMPDkpo.h4smMONCAZujy0wrQhK2rhZc5U2c.mm..UGfm', 'partner', 4, NULL, '2026-07-26 05:35:14', '2026-07-26 05:35:14'),
(7, 'Google Indonesia', 'google@gmail.com', NULL, NULL, NULL, '$2y$12$ZwGtGRZSSrTyXdKz/O.g8uRTWqGlk4ZjPF19kW1jAExN2i.KiPBYe', 'partner', 5, NULL, '2026-07-29 21:48:49', '2026-07-29 21:48:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_category_id_foreign` (`category_id`),
  ADD KEY `events_partner_id_foreign` (`partner_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jabatans`
--
ALTER TABLE `jabatans`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_registrations`
--
ALTER TABLE `partner_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengurus_jabatan_id_foreign` (`jabatan_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_event_id_foreign` (`event_id`),
  ADD KEY `reviews_partner_id_foreign` (`partner_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_order_id_unique` (`order_id`),
  ADD KEY `transactions_event_id_foreign` (`event_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD KEY `users_partner_id_foreign` (`partner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatans`
--
ALTER TABLE `jabatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partner_registrations`
--
ALTER TABLE `partner_registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD CONSTRAINT `pengurus_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
