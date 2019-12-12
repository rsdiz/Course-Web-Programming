-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2019 at 07:50 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rosyid`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `nim` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `divisi` enum('Divisi Media','Divisi SDM','Divisi Keilmuan','Divisi Humas') NOT NULL,
  `jenis_kelamin` enum('Perempuan','Laki-Laki') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nim`, `nama`, `divisi`, `jenis_kelamin`) VALUES
(8, '5180411122', 'Rosyid', 'Divisi Media', 'Laki-Laki'),
(9, '5180411123', 'Yogi', 'Divisi Keilmuan', 'Laki-Laki'),
(10, '5170411373', 'Jody', 'Divisi Keilmuan', 'Laki-Laki'),
(11, '5180411194', 'Tarto', 'Divisi SDM', 'Laki-Laki'),
(12, '5180411021', 'Dimas', 'Divisi Humas', 'Laki-Laki'),
(13, '5180411006', 'Risma', 'Divisi Humas', 'Perempuan'),
(14, '5180411029', 'Erika', 'Divisi Media', 'Perempuan'),
(15, '5180411113', 'Nathan', 'Divisi Media', 'Laki-Laki');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
