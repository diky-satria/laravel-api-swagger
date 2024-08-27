-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 10:19 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laranext_auth_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'BACKEND DEVELOPER', NULL, NULL),
(2, 'FRONTEND DEVELOPER', NULL, NULL),
(3, 'UI/UX DESIGNER', NULL, NULL),
(4, 'FULLSTACK DEVELOPER', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_04_12_083235_create_divisions_table', 1),
(2, '2024_04_12_083717_create_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `division_id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'Diky', 'diky@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', '2024-04-13 00:42:11', '2024-04-13 00:42:11'),
(2, 1, 'Ayu', 'ayu@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', '2024-04-13 00:47:32', '2024-04-13 00:47:32'),
(3, 1, 'soleh', 'soleh@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(4, 2, 'dwi', 'dwi@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(5, 1, 'kaiz', 'kaiz@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(6, 2, 'arif', 'arif@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(7, 1, 'anas', 'anas@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(8, 2, 'sarmin', 'sarmin@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(9, 2, 'hilman', 'hilman@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(10, 2, 'mualim', 'mualim@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(11, 3, 'nanang', 'nanang@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(12, 4, 'luthfi', 'luthfi@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(13, 3, 'fudin', 'fudin@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(14, 3, 'fajar', 'fajar@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(15, 2, 'denny', 'denny@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(16, 1, 'anwar', 'anwar@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(17, 4, 'bayu', 'bayu@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(18, 4, 'qusay', 'qusay@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(19, 2, 'arbi', 'arbi@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(20, 3, 'wahyu', 'wahyu@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(21, 2, 'neti', 'neti@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL),
(22, 4, 'oval', 'oval@gmail.com', '$2y$10$h.syWBlnm832j4zSizMFiukfSMVJ1SskSghaR7csh163RRDp6IUl6', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_division_id_foreign` (`division_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
