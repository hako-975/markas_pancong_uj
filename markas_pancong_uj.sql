-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2023 pada 16.20
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
(1, 2, 1, 20000, '6287808675313-ZyoFu'),
(2, 1, 1, 17000, '6287808675313-6YWAR');

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
(1, 'Ayam Penyet + Nasi', 17000, 'makanan', '6471963aacce74bd435cfadb8f7084b8114bfb0e22cc6.jpg'),
(2, 'Ayam Bakar + Nasi', 20000, 'makanan', '6471967dda33620-17-24-images.jpg'),
(3, 'Es Good Day', 6000, 'minuman', '647197692b0b799818e5d5694095ad2cc4ffe7ac31dbc.jpg'),
(4, 'Es Tea Jus', 3000, 'minuman', '64719798e1645bf37569d387b597a9fb0a90c552ceacd.jpg'),
(5, 'Mie Tektek Kuah', 15000, 'makanan', '647197d19d54e07-17-26-images_image_repair_1684801276750.jpg'),
(6, 'Mie Goreng', 15000, 'makanan', '647197de42de2MTXX_MH20230523_071859037_image_repair_1684801259041.jpg'),
(7, 'Pancong Coklat Keju', 13000, 'makanan', '64719818efa8cIMG_20230522_134124.jpg'),
(8, 'Pancong Strawberry Susu', 10000, 'makanan', '6471982ad5ae9IMG_20230522_134013.jpg'),
(9, 'Pancong Tiramisu', 13000, 'makanan', '6471984353cddIMG_20230522_133937.jpg'),
(10, 'Pancong Choco Crunchy', 13000, 'makanan', '6471986239feaIMG_20230522_134311.jpg'),
(11, 'Pancong Oreo', 13000, 'makanan', '647198707cf54IMG_20230522_134320.jpg'),
(12, 'Kopi Hangat', 4000, 'minuman', '647198811c59ePicsart_23-05-25_17-59-43-844.jpg'),
(13, 'Nutrisari', 5000, 'minuman', '64719892da40cPicsart_23-05-25_18-00-13-482.jpg');

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
  `id_user` int(11) DEFAULT NULL,
  `status_notif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`kode_pesanan`, `nama_pemesan`, `no_telp_pemesan`, `alamat_pemesan`, `tanggal_pesanan`, `total_pembayaran`, `status_pesanan`, `id_user`, `status_notif`) VALUES
('6287808675313-6YWAR', 'Andri Firman Saputra', '6287808675313', 'Jl. AMD Babakan Pocis No. 88 RT04/RW02', '2023-05-30 09:37:31', 17000, 'proses', NULL, 0),
('6287808675313-ZyoFu', 'Andri Firman Saputra', '6287808675313', 'Jl. AMD Babakan Pocis No. 88', '2023-05-27 12:53:49', 20000, 'selesai', 1, 0);

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
(1, 'User Berhasil login!', '2023-05-27 12:33:03', 1),
(2, 'Menu Berhasil ditambahkan!', '2023-05-27 12:33:47', 1),
(3, 'Menu Berhasil ditambahkan!', '2023-05-27 12:34:53', 1),
(4, 'Menu Ayam Penyet + Nasi Berhasil ditambahkan!', '2023-05-27 12:37:04', 1),
(5, 'Menu Ayam Penyet + Nasi Berhasil ditambahkan!', '2023-05-27 12:37:12', 1),
(6, 'Menu Es Good Day Berhasil ditambahkan!', '2023-05-27 12:38:49', 1),
(7, 'Menu Es Tea Jus Berhasil ditambahkan!', '2023-05-27 12:39:36', 1),
(8, 'Menu Mie Tektek Kuah Berhasil ditambahkan!', '2023-05-27 12:40:33', 1),
(9, 'Menu Mie Goreng Berhasil ditambahkan!', '2023-05-27 12:40:46', 1),
(10, 'Menu Pancong Coklat Keju Berhasil ditambahkan!', '2023-05-27 12:41:44', 1),
(11, 'Menu Pancong Strawberry Susu Berhasil ditambahkan!', '2023-05-27 12:42:02', 1),
(12, 'Menu Pancong Tiramisu Berhasil ditambahkan!', '2023-05-27 12:42:27', 1),
(13, 'Menu Pancong Choco Crunchy Berhasil ditambahkan!', '2023-05-27 12:42:58', 1),
(14, 'Menu Pancong Oreo Berhasil ditambahkan!', '2023-05-27 12:43:12', 1),
(15, 'Menu Kopi Hangat Berhasil ditambahkan!', '2023-05-27 12:43:29', 1),
(16, 'Menu Nutrisari Berhasil ditambahkan!', '2023-05-27 12:43:46', 1),
(17, 'Mencetak Laporan!', '2023-05-27 12:52:45', 1),
(18, 'Status Pesanan Berhasil diubah! dengan kode pesanan 6287808675313-ZyoFu', '2023-05-27 12:54:12', 1),
(19, 'Status Pesanan Berhasil diubah! dengan kode pesanan 6287808675313-ZyoFu', '2023-05-27 12:54:43', 1),
(20, 'Status Pesanan Berhasil diubah! dengan kode pesanan 6287808675313-ZyoFu', '2023-05-27 12:54:47', 1),
(21, 'Mencetak Laporan!', '2023-05-27 12:54:59', 1),
(22, 'Mencetak Laporan!', '2023-05-27 12:56:32', 1),
(23, 'User Berhasil login!', '2023-05-30 09:35:39', 1);

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
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
