-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 01 Okt 2024 pada 12.54
-- Versi server: 8.0.30
-- Versi PHP: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poi_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `bar` char(13) NOT NULL DEFAULT '',
  `nama` varchar(50) NOT NULL,
  `kategori` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'lainnya'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`bar`, `nama`, `kategori`) VALUES
('711844130128', 'Abc Tomat 275ml', 'Saos'),
('8991002125025', 'Kapal Api 200ml', 'Minuman'),
('8992759170580', 'Tissue Jolly 250s', 'Tisu Muka'),
('8996001600269', 'Le Minerale 600ml', 'Minuman'),
('8999999585297', 'Sunlight Lime 370ml', 'Sabun Pencuci');

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `id` int NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `toko`
--

INSERT INTO `toko` (`id`, `nama`, `alamat`, `lat`, `lng`) VALUES
(1, 'Alfamart', 'Jl.Sepakat', -0.04183445144272559, 109.32028965224141),
(2, 'Indomaret', 'Jl.Perdana', -0.04520722723041784, 109.36358881291396),
(3, 'Alfamidi', 'Jl.Purnama', -0.05623711446160067, 109.3372446919995),
(4, 'IndoStore', 'Jl.AhmadYani', -0.05623711446160067, 109.3372446919995);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `prod_id` bigint DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `toko_id` int DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `jumlah` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `prod_id`, `harga`, `toko_id`, `tgl`, `jumlah`) VALUES
(2, 8996001600269, 2500, 2, '2024-10-01 10:28:01', 1),
(3, 8992759170580, 8000, 3, '2024-10-01 10:56:58', 1),
(4, 8996001600269, 4000, 4, '2024-10-01 12:29:34', 1),
(5, 711844130128, 10500, 1, '2024-10-01 12:33:53', 1),
(6, 711844130128, 10000, 2, '2024-10-01 12:34:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`bar`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
