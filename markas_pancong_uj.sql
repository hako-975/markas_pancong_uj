-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2023 pada 10.42
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `markas_pancong_uj`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `kode_pesanan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail_pesanan`, `id_menu`, `jumlah`, `subtotal`, `kode_pesanan`) VALUES
(1, 4, 1, 3000, '6287808675313-S8Qr5'),
(2, 4, 1, 3000, '6287808675313-jPY2n'),
(3, 4, 1, 3000, '6287808675313-IPWgz'),
(4, 3, 1, 10000, '087808675313-j4uR1'),
(5, 3, 1, 10000, '6287808675313-IlUtx'),
(6, 2, 1, 20000, '087808675313-SaLy0'),
(7, 2, 1, 20000, '6287808675313-djRk0'),
(8, 3, 2, 20000, '6287808675313-Pmvv4'),
(9, 3, 1, 10000, '6287808675313-bASTD'),
(10, 3, 1, 10000, '6287808675313-hD6rm'),
(11, 3, 1, 10000, '6287808675313-bBrcx'),
(12, 3, 1, 10000, '123-ZE5NO'),
(13, 3, 1, 10000, '123-erwPo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `harga_menu` int(11) NOT NULL,
  `jenis_menu` enum('makanan','minuman') NOT NULL,
  `foto_menu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga_menu`, `jenis_menu`, `foto_menu`) VALUES
(2, 'Pancong Keju', 20000, 'makanan', '640c6d18ee9cePancong.jpeg'),
(3, 'Pancong Cokelat', 10000, 'makanan', '640c6d6e9ac09food-spot-pancong-lumer.jpeg'),
(4, 'teh jus ', 3000, 'minuman', '6412b223dad806412b19f1c4c67866512_cc2058b5-0684-49fc-820c-4fcbb460932d_1781_1781.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `kode_pesanan` varchar(25) NOT NULL,
  `nama_pemesan` varchar(50) NOT NULL,
  `no_telp_pemesan` varchar(20) NOT NULL,
  `alamat_pemesan` text NOT NULL,
  `tanggal_pesanan` datetime NOT NULL,
  `total_pembayaran` int(11) DEFAULT NULL,
  `status_pesanan` enum('proses','dibuat','perjalanan','selesai') NOT NULL DEFAULT 'proses',
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`kode_pesanan`, `nama_pemesan`, `no_telp_pemesan`, `alamat_pemesan`, `tanggal_pesanan`, `total_pembayaran`, `status_pesanan`, `id_user`) VALUES
('087808675313-j4uR1', 'Andri Firman Saputra', '087808675313', 'POCIS', '2023-05-20 14:06:15', 20000, 'selesai', 1),
('087808675313-SaLy0', 'Andri Firman Saputra', '087808675313', 'pocis\r\n', '2023-05-20 18:22:05', 20000, 'selesai', 1),
('123-erwPo', 'asd', '123', 'ad', '2023-05-21 15:07:45', 10000, 'proses', NULL),
('123-ZE5NO', 'asd', '123', 'asd', '2023-05-21 15:06:25', 10000, 'proses', NULL),
('6287808675313-bASTD', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-21 15:04:01', 10000, 'proses', NULL),
('6287808675313-bBrcx', 'Andri Firman Saputra', '6287808675313', 'asd', '2023-05-21 15:06:00', 10000, 'proses', NULL),
('6287808675313-djRk0', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-21 14:53:57', 20000, 'proses', NULL),
('6287808675313-hD6rm', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-21 15:05:13', 10000, 'proses', NULL),
('6287808675313-IlUtx', 'Andri Firman Saputra', '6287808675313', 'Jl. AMD Babakan Pocis', '2023-05-20 14:47:02', 20000, 'perjalanan', 1),
('6287808675313-IPWgz', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-20 00:12:45', 20000, 'perjalanan', 1),
('6287808675313-jPY2n', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-20 00:02:26', 20000, 'proses', NULL),
('6287808675313-Pmvv4', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-21 15:03:00', 20000, 'proses', NULL),
('6287808675313-S8Qr5', 'Andri Firman Saputra', '6287808675313', 'Pocis', '2023-05-19 23:46:41', 20000, 'proses', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `isi_riwayat` text NOT NULL,
  `tanggal_riwayat` datetime NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `isi_riwayat`, `tanggal_riwayat`, `id_user`) VALUES
(1, 'User Berhasil login!', '2023-05-20 18:21:19', 1),
(2, 'Pesanan berhasil ditambahkan!', '2023-05-20 18:22:05', 1),
(3, 'Menu Pesanan berhasil ditambahkan!', '2023-05-20 18:22:10', 1),
(4, 'Status Pesanan Berhasil diubah! dengan kode pesanan 087808675313-SaLy0', '2023-05-20 18:22:51', 1),
(5, 'Status Pesanan Berhasil diubah! dengan kode pesanan 087808675313-SaLy0', '2023-05-20 18:25:26', 1),
(6, 'User Berhasil login!', '2023-05-21 14:23:06', 1),
(7, 'User Berhasil login!', '2023-05-21 15:03:39', 1),
(8, 'User Berhasil login!', '2023-05-21 15:14:17', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '$2y$10$r3.8/f6Dkx5bUj795Dap6.TWL9rTwRNAxvKdIEQ1epiTb4eAFBfmO', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `kode_pesanan` (`kode_pesanan`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`kode_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`kode_pesanan`) REFERENCES `pesanan` (`kode_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
