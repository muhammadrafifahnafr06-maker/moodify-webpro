-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 03:31 PM
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
-- Database: `moodify`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_harian`
--

CREATE TABLE `aktivitas_harian` (
  `id_aktivitas` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `durasi_tidur` int(11) NOT NULL,
  `aktivitas_fisik` varchar(100) NOT NULL,
  `tingkat_stres` enum('Rendah','Sedang','Tinggi') NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktivitas_harian`
--

INSERT INTO `aktivitas_harian` (`id_aktivitas`, `tanggal`, `durasi_tidur`, `aktivitas_fisik`, `tingkat_stres`, `catatan`, `created_at`) VALUES
(1, '2026-09-22', 7, 'berlari', 'Tinggi', 'horeee', '2026-06-17 01:28:47'),
(3, '2026-10-07', 7, 'jalan kaki', 'Sedang', 'halo', '2026-06-17 13:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `kotak_rahasia`
--

CREATE TABLE `kotak_rahasia` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `isi_cerita` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kotak_rahasia`
--

INSERT INTO `kotak_rahasia` (`id_post`, `id_user`, `kategori`, `isi_cerita`, `created_at`) VALUES
(10, 1, 'Depresi', 'aku takut banget', '2026-05-13 03:30:37'),
(12, 1, 'Depresi', 'cape', '2026-05-21 05:54:28'),
(13, 1, 'Anxiety', 'aku cemas karna mau ujian', '2026-06-14 18:35:26'),
(21, 1, 'Anxiety', 'hai kamu kenapa?', '2026-06-16 12:22:55'),
(23, 1, 'Anxiety', 'hai', '2026-06-16 13:04:22'),
(24, 1, 'Anxiety', 'jvfvjfnjgbvg', '2026-06-17 07:51:42'),
(25, 1, 'Anxiety', 'jfbi t4 gbi5t5', '2026-06-17 07:51:55'),
(26, 1, 'Depresi', 'jtjngjjtb', '2026-06-17 07:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `my_diary`
--

CREATE TABLE `my_diary` (
  `id_diary` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi_diary` text NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekomendasi_mood`
--

CREATE TABLE `rekomendasi_mood` (
  `id_rekomendasi` int(11) NOT NULL,
  `mood_target` varchar(50) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi_rekomendasi` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suasana_hati`
--

CREATE TABLE `suasana_hati` (
  `id_mood` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `mood` varchar(30) NOT NULL,
  `motivasi` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suasana_hati`
--

INSERT INTO `suasana_hati` (`id_mood`, `id_user`, `mood`, `motivasi`, `tanggal`) VALUES
(5, 1, 'Tenang', 'Nikmati ketenanganmu. Hari ini adalah kesempatan untuk tumbuh dengan damai 🤍', '2026-06-16'),
(6, 1, 'Gembira', 'Pertahankan senyum itu! Energi positifmu hari ini luar biasa ✨', '2026-06-16'),
(7, 4, 'Tenang', 'Nikmati ketenanganmu. Hari ini adalah kesempatan untuk tumbuh dengan damai 🤍', '2026-06-17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'intan', 'intan@gmail.com', '222', '2026-05-12 16:30:44', 'user'),
(2, 'keyla', 'keyla@moodify.com', '123', '2026-05-21 05:46:54', 'user'),
(3, 'admin', 'admin@moodify.com', '1234', '2026-05-21 04:53:03', 'admin'),
(4, 'rafif', 'rafif@gmail.com', '12345', '2026-06-17 11:23:36', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_harian`
--
ALTER TABLE `aktivitas_harian`
  ADD PRIMARY KEY (`id_aktivitas`);

--
-- Indexes for table `kotak_rahasia`
--
ALTER TABLE `kotak_rahasia`
  ADD PRIMARY KEY (`id_post`);

--
-- Indexes for table `my_diary`
--
ALTER TABLE `my_diary`
  ADD PRIMARY KEY (`id_diary`),
  ADD KEY `fk_diary_user` (`id_user`);

--
-- Indexes for table `rekomendasi_mood`
--
ALTER TABLE `rekomendasi_mood`
  ADD PRIMARY KEY (`id_rekomendasi`);

--
-- Indexes for table `suasana_hati`
--
ALTER TABLE `suasana_hati`
  ADD PRIMARY KEY (`id_mood`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_harian`
--
ALTER TABLE `aktivitas_harian`
  MODIFY `id_aktivitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kotak_rahasia`
--
ALTER TABLE `kotak_rahasia`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `my_diary`
--
ALTER TABLE `my_diary`
  MODIFY `id_diary` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekomendasi_mood`
--
ALTER TABLE `rekomendasi_mood`
  MODIFY `id_rekomendasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suasana_hati`
--
ALTER TABLE `suasana_hati`
  MODIFY `id_mood` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `my_diary`
--
ALTER TABLE `my_diary`
  ADD CONSTRAINT `fk_diary_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
