-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 20 Des 2020 pada 04.56
-- Versi server: 5.6.38
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_buku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_buku`
--

CREATE TABLE `tb_buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(155) NOT NULL,
  `pengarang` varchar(155) NOT NULL,
  `penerbit` varchar(155) NOT NULL,
  `keterangan` text NOT NULL,
  `genre` text NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `tanggal_post` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_buku`
--

INSERT INTO `tb_buku` (`id`, `judul`, `pengarang`, `penerbit`, `keterangan`, `genre`, `tanggal_terbit`, `tanggal_post`, `gambar`) VALUES
(6, 'Naruto', 'Masashi Kishimoto', 'Sueisha', 'Naruto adalah sebuah serial manga karya Masashi Kishimoto yang diadaptasi menjadi serial anime. Manga Naruto bercerita seputar kehidupan tokoh utamanya, Naruto Uzumaki, seorang ninja yang hiperaktif, periang, dan ambisius yang ingin mewujudkan keinginannya untuk mendapatkan gelar Hokage, pemimpin dan ninja terkuat di desanya. Serial ini didasarkan pada komik one-shot oleh Kishimoto yang diterbitkan dalam edisi Akamaru Jump pada Agustus 1997.', 'fantasi', '1997-08-09', '18 Dec 2020', 'created_by_candradwicahyo_2020_5fdb898854d83.jpg'),
(9, 'One Piece', 'Eiichiro Oda', 'Sueisha', 'One Piece (bahasa Jepang: ワンピース Hepburn: Wan Pīsu) adalah sebuah seri manga Jepang yang ditulis dan diilustrasikan oleh Eiichiro Oda. Manga ini telah dimuat di majalah Weekly Shōnen Jump milik Shueisha sejak tanggal 22 Juli 1997, dan telah dibundel menjadi 91 volume tankōbon. Ceritanya mengisahkan petualangan Monkey D. Luffy, seorang anak laki-laki yang memiliki kemampuan tubuh elastis seperti karet setelah memakan Buah Iblis secara tidak disengaja. Dengan kru bajak lautnya, yang dinamakan Bajak Laut Topi Jerami, Luffy menjelajahi Grand Line untuk mencari harta karun terbesar di dunia yang dikenal sebagai &quot;One Piece&quot; dalam rangka untuk menjadi Raja Bajak Laut yang berikutnya.', 'petualang', '1997-07-22', '18 Dec 2020', 'created_by_candradwicahyo_2020_5fdccf5092fa3.jpg'),
(10, 'One Punch Man', 'One', 'Sueisha', 'One-Punch Man ( ワンパンマン Wanpanman) adalah sebuah serial manga Jepang yang menceritakan seorang superhero yang bernama Saitama. One-Punch Man dibuat oleh seorang penulis yang asal jepang dengan nama samaran ONE[1] yang mulai diterbitkan pada awal tahun 2009[2]. Serial ini segera menjadi viral sehingga mampu melampaui 7,9 juta hits pada bulan Juni 2012[3]. One-Punch Man merupakan kontraksi wanpanchi (&quot;One-Punch&quot;) yang artinya satu pukulan[4].Sebuah remake manga digital dari seri ini, yang diilustrasikan oleh Yusuke Murata, mulai dipublikasikan di situs Web Komedi Langsung Jumpa Shueisha pada tahun 2012[2]. Bab-bab tersebut dikumpulkan secara berkala dan dicetak ke dalam volume tankōbon, dengan dua belas dirilis pada tanggal 2 Desember 2016. Viz Media memiliki lisensi remake untuk serialisasi bahasa Inggris di majalah digital Weekly Shonen Jump.[2].', 'aksi', '2009-07-22', '18 Dec 2020', 'created_by_candradwicahyo_2020_5fdcd00cefeb9.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(155) NOT NULL,
  `tahun_kelahiran` int(4) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `nama`, `tahun_kelahiran`, `email`, `password`, `gambar`) VALUES
(1, 'candra dwi cahyo', 2004, 'candradwicahyo18@gmail.com', 'candra', 'created_by_candradwicahyo_2020_5fde7e1c868f0.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_buku`
--
ALTER TABLE `tb_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
