-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2024 at 03:23 PM
-- Server version: 8.0.35-0ubuntu0.23.04.1
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemManajemenInventaris`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `namakategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori`, `namakategori`) VALUES
('K001', 'Elektronik'),
('K002', 'Pakaian'),
('K003', 'Makanan dan Minuman'),
('K004', 'Peralatan Rumah Tangga'),
('K005', 'Bahan Baku');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `attempt_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengelolaan_Barang`
--

CREATE TABLE `pengelolaan_Barang` (
  `id` int NOT NULL,
  `nama` varchar(191) NOT NULL,
  `kategori` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` text NOT NULL,
  `jumlah_stok` varchar(32) NOT NULL,
  `harga` varchar(191) NOT NULL,
  `pemasok` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengelolaan_Barang`
--

INSERT INTO `pengelolaan_Barang` (`id`, `nama`, `kategori`, `deskripsi`, `jumlah_stok`, `harga`, `pemasok`) VALUES
(3, 'ASWD', 'K002', 'WAS', '321', '321321', 'AWDSA'),
(4, 'aw', 'K001', 'qw', '123', '21321', 'wa'),
(5, 'wad', 'K003', 'WEDA', '1231', '213213', 'WADSA'),
(6, 'wad', 'K003', 'wadas', '213', '213', 'wad'),
(7, 'aw', 'K003', 'wa', '123', '21321', 'waaw'),
(8, 'NABATI', 'K003', 'SNack', '123', '123', 'aw');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `verify_token` varchar(50) NOT NULL,
  `secret_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `verify_token`, `secret_key`, `role`, `created_at`) VALUES
(23, 'Admin Inventaris', 'admin@admin.com', '$2y$10$1WsvSWsvx/kT4HdJrEJZDOhSBwEH1kTRIJN8m4L/71d0liDaVZRBa', '812345678', '124b45713ed1bf0cce1f03d6fc0e3934', 'l6sw3g67fm2ktojgxa6nocmtlq', '', '2024-08-03 02:18:29'),
(34, 'HAFIZD', 'hafizd@gmail.com', '$2y$10$lNjwb9uGYAs1KNXHyWIFE.bWZJX8f6yT2LT70SvVnfJRbaQmZ3E2q', '0812345678999', '0bf635ee63805ad2f8d0d8f25006f513', 'qtu5ykjfqsllqgvtjmqm3sl2e4', '', '2024-08-05 01:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `users_role`
--

CREATE TABLE `users_role` (
  `role` varchar(11) NOT NULL,
  `roles` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_role`
--

INSERT INTO `users_role` (`role`, `roles`) VALUES
('RO01', 'User'),
('RO02', 'Adminstartion');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengelolaan_Barang`
--
ALTER TABLE `pengelolaan_Barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pengelolaan_Barang`
--
ALTER TABLE `pengelolaan_Barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengelolaan_Barang`
--
ALTER TABLE `pengelolaan_Barang`
  ADD CONSTRAINT `pengelolaan_Barang_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
