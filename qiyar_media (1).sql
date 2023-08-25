-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Agu 2023 pada 08.04
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.1

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
-- Struktur dari tabel `data_advertiser`
--

CREATE TABLE `data_advertiser` (
  `id_advertiser` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `nama_advertiser` varchar(50) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `jumlah_pengiriman` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_advertiser`
--

INSERT INTO `data_advertiser` (`id_advertiser`, `tanggal_pembelian`, `nama_advertiser`, `nama_produk`, `jumlah_pengiriman`, `total_harga`) VALUES
(1, '2023-08-01', 'Zaka', 'Sempak Elektrik', 100, 15000000),
(2, '2023-08-10', 'Harsono', 'Sarung Totol', 100, 19900000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran`
--

CREATE TABLE `lamaran` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_advertiser`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengeluaran_advertiser`
--

INSERT INTO `pengeluaran_advertiser` (`id_pengeluaran`, `tanggal`, `waktu`, `nama_advertiser`, `bank_tujuan`, `jumlah`, `keterangan`, `total`) VALUES
(1, '2023-08-02', '11:27:58', 'Zaka', 'BRI', 50000, 'CONTOH', 50000),
(2, '0000-00-00', '11:12:00', 'Zaka', '512512', 51251515, 'DSADWQ', 51251),
(3, '0000-00-00', '11:13:00', 'Dwi', 'CONTOH3', 2147483647, 'FQWFQW', 5125125),
(4, '2023-08-25', '11:17:00', 'Dwiki', '4412', 5215125, '51251', 51251);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(20) NOT NULL,
  `stock` int(20) NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `stock`, `harga`) VALUES
(1, 'Sempak Elektrik', 300, 150000),
(2, 'Sarung Totol', 350, 199000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Amel', 'amel@gmail.com', 'amel', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_advertiser`
--
ALTER TABLE `data_advertiser`
  ADD PRIMARY KEY (`id_advertiser`);

--
-- Indeks untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengeluaran_advertiser`
--
ALTER TABLE `pengeluaran_advertiser`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_advertiser`
--
ALTER TABLE `data_advertiser`
  MODIFY `id_advertiser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_advertiser`
--
ALTER TABLE `pengeluaran_advertiser`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
