-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2026 at 03:13 AM
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
-- Database: `db_latihan_pbo_trpl1a_gilangrinakitwisnuadhityasumirat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tiket` int NOT NULL,
  `nama_film` varchar(255) NOT NULL,
  `jadwal_tayang` datetime NOT NULL,
  `jumlah_kursi` int NOT NULL,
  `harga_dasar_tiket` decimal(10,2) NOT NULL,
  `jenis_studio` enum('Regular','IMAX','Velvet') NOT NULL,
  `tipe_audio` varchar(50) DEFAULT NULL,
  `lokasi_baris` varchar(10) DEFAULT NULL,
  `kacamata_3d_id` varchar(50) DEFAULT NULL,
  `efek_gerak_fitur` varchar(100) DEFAULT NULL,
  `bantal_selimut_pack` varchar(50) DEFAULT NULL,
  `layanan_sub_butler` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tiket`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3d_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_sub_butler`) VALUES
(1, 'Avengers: Endgame', '2026-06-15 13:00:00', 150, 40000.00, 'Regular', 'Dolby Digital 5.1', 'A', NULL, NULL, NULL, NULL),
(2, 'Avengers: Endgame', '2026-06-15 16:00:00', 150, 40000.00, 'Regular', 'Dolby Digital 5.1', 'B', NULL, NULL, NULL, NULL),
(3, 'Siksa Kubur', '2026-06-15 14:00:00', 120, 35000.00, 'Regular', 'Stereo', 'C', NULL, NULL, NULL, NULL),
(4, 'Siksa Kubur', '2026-06-15 19:00:00', 120, 35000.00, 'Regular', 'Stereo', 'D', NULL, NULL, NULL, NULL),
(5, 'Agak Laen', '2026-06-16 12:00:00', 150, 40000.00, 'Regular', 'Dolby Digital 5.1', 'E', NULL, NULL, NULL, NULL),
(6, 'Agak Laen', '2026-06-16 15:00:00', 150, 40000.00, 'Regular', 'Dolby Digital 5.1', 'F', NULL, NULL, NULL, NULL),
(7, 'Agak Laen', '2026-06-16 18:00:00', 150, 45000.00, 'Regular', 'Dolby Digital 5.1', 'G', NULL, NULL, NULL, NULL),
(8, 'Avatar 3', '2026-06-15 10:00:00', 300, 75000.00, 'IMAX', 'IMAX 12-Channel', 'H', '3D-IMAX-001', '4D Motion Seat', NULL, NULL),
(9, 'Avatar 3', '2026-06-15 13:30:00', 300, 75000.00, 'IMAX', 'IMAX 12-Channel', 'I', '3D-IMAX-002', '4D Motion Seat', NULL, NULL),
(10, 'Interstellar Re-release', '2026-06-15 17:00:00', 250, 80000.00, 'IMAX', 'IMAX 6-Channel', 'J', NULL, 'Standard Vibration', NULL, NULL),
(11, 'Interstellar Re-release', '2026-06-15 20:30:00', 250, 80000.00, 'IMAX', 'IMAX 6-Channel', 'K', NULL, 'Standard Vibration', NULL, NULL),
(12, 'Dune: Part Three', '2026-06-16 11:00:00', 300, 75000.00, 'IMAX', 'IMAX 12-Channel', 'L', '3D-IMAX-003', 'Subwoofer Seat', NULL, NULL),
(13, 'Dune: Part Three', '2026-06-16 14:30:00', 300, 75000.00, 'IMAX', 'IMAX 12-Channel', 'M', '3D-IMAX-004', 'Subwoofer Seat', NULL, NULL),
(14, 'Dune: Part Three', '2026-06-16 19:00:00', 300, 85000.00, 'IMAX', 'IMAX 12-Channel', 'N', '3D-IMAX-005', 'Subwoofer Seat', NULL, NULL),
(15, 'The Batman 2', '2026-06-15 12:00:00', 40, 150000.00, 'Velvet', 'Dolby Atmos', 'VIP-1', NULL, NULL, 'Premium Pack A', 'Personal Butler Tom'),
(16, 'The Batman 2', '2026-06-15 15:30:00', 40, 150000.00, 'Velvet', 'Dolby Atmos', 'VIP-2', NULL, NULL, 'Premium Pack A', 'Personal Butler Tom'),
(17, 'Inception', '2026-06-15 19:00:00', 30, 175000.00, 'Velvet', 'Dolby Atmos', 'VIP-3', NULL, NULL, 'Luxury Pack Gold', 'Personal Butler Sara'),
(18, 'Inception', '2026-06-15 22:15:00', 30, 175000.00, 'Velvet', 'Dolby Atmos', 'VIP-4', NULL, NULL, 'Luxury Pack Gold', 'Personal Butler Sara'),
(19, 'Gladiator II', '2026-06-16 13:00:00', 40, 150000.00, 'Velvet', 'Dolby Atmos', 'VIP-5', NULL, NULL, 'Premium Pack B', 'Personal Butler Alex'),
(20, 'Gladiator II', '2026-06-16 16:30:00', 40, 150000.00, 'Velvet', 'Dolby Atmos', 'VIP-6', NULL, NULL, 'Premium Pack B', 'Personal Butler Alex');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
