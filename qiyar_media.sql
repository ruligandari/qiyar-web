-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2023 at 05:19 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qiyar_media`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_advertiser`
--

CREATE TABLE `data_advertiser` (
  `id_advertiser` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `nama_advertiser` varchar(50) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `jumlah_pengiriman` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_advertiser`
--

INSERT INTO `data_advertiser` (`id_advertiser`, `tanggal_pembelian`, `nama_advertiser`, `nama_produk`, `jumlah_pengiriman`, `total_harga`) VALUES
(1, '2023-08-01', 'Zaka', 'Sempak Elektrik', 100, 15000000),
(2, '2023-08-10', 'Harsono', 'Sarung Totol', 100, 19900000);

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_advertiser`
--

CREATE TABLE `pengeluaran_advertiser` (
  `id_pengeluaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `nama_advertiser` varchar(255) NOT NULL,
  `bank_tujuan` varchar(255) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `total` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengeluaran_advertiser`
--

INSERT INTO `pengeluaran_advertiser` (`id_pengeluaran`, `tanggal`, `waktu`, `nama_advertiser`, `bank_tujuan`, `jumlah`, `keterangan`, `total`) VALUES
(1, '2023-08-02', '11:27:58', 'Zaka', 'LINE BANK', 60000000, 'Sonia', 50000),
(4, '2023-08-25', '11:17:00', 'Dwiki', 'BCA', 10000000, 'SONIA', 51251),
(5, '2023-08-25', '15:50:00', 'Zaka', 'BRI', 25000000, 'Sonia', 0),
(6, '2023-08-25', '19:59:00', 'Harsono', 'BRI', 2000000, 'Sonia', 0),
(7, '2023-08-25', '23:20:00', 'Harsono', 'BRI', 20000000, 'Sonia', 0),
(8, '2023-08-25', '23:23:00', 'Dwi', 'BRI', 60000000, 'Sonia', 0),
(9, '2023-08-25', '23:24:00', 'Dwi', 'BRI', 60000000, 'Sonia\r\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(20) NOT NULL,
  `stock` int(20) NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `stock`, `harga`) VALUES
(3, 'Kaos Kaki', 3000, 139000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Amel', 'amel@gmail.com', 'amel', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_advertiser`
--
ALTER TABLE `data_advertiser`
  ADD PRIMARY KEY (`id_advertiser`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran_advertiser`
--
ALTER TABLE `pengeluaran_advertiser`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_advertiser`
--
ALTER TABLE `data_advertiser`
  MODIFY `id_advertiser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengeluaran_advertiser`
--
ALTER TABLE `pengeluaran_advertiser`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
