-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2020 at 08:02 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ams_native`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_approve_lpt`
--

CREATE TABLE IF NOT EXISTS `tbl_approve_lpt` (
`id_approve_lpt` int(11) NOT NULL,
  `ttd_spv` varchar(200) NOT NULL,
  `ttd_kabag` varchar(200) NOT NULL,
  `id_lpt` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_approve_lpt`
--

INSERT INTO `tbl_approve_lpt` (`id_approve_lpt`, `ttd_spv`, `ttd_kabag`, `id_lpt`, `id_user`) VALUES
(0, 'Diterima', 'Diterima', 45, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disposisi`
--

CREATE TABLE IF NOT EXISTS `tbl_disposisi` (
`id_disposisi` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `isi_disposisi` mediumtext NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `sifat1` varchar(100) NOT NULL,
  `batas_waktu` date NOT NULL,
  `catatan` varchar(250) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_disposisi`
--

INSERT INTO `tbl_disposisi` (`id_disposisi`, `tujuan`, `isi_disposisi`, `sifat`, `sifat1`, `batas_waktu`, `catatan`, `id_surat`, `id_user`) VALUES
(62, '', '', 'Diterima', 'Diterima', '0000-00-00', '', 83, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instansi`
--

CREATE TABLE IF NOT EXISTS `tbl_instansi` (
  `id_instansi` tinyint(1) NOT NULL,
  `institusi` varchar(150) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `kepsek` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `website` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_instansi`
--

INSERT INTO `tbl_instansi` (`id_instansi`, `institusi`, `nama`, `status`, `alamat`, `kepsek`, `nip`, `website`, `email`, `logo`, `id_user`) VALUES
(1, 'P M K', 'SIMARTEK', 'Terakreditasi A', 'Sistem Informasi Marketing Teknik', 'PT Graha Pena Jawa Pos', '-', 'https://grahapenajawapos.com', 'marketing@grahapenajawapos.com', 'logo.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_klasifikasi`
--

CREATE TABLE IF NOT EXISTS `tbl_klasifikasi` (
`id_klasifikasi` int(5) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `uraian` mediumtext NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lpt`
--

CREATE TABLE IF NOT EXISTS `tbl_lpt` (
`id_lpt` int(11) NOT NULL,
  `no_agenda` varchar(100) NOT NULL,
  `no_form` varchar(200) NOT NULL,
  `tgl_lpt` date NOT NULL,
  `nama_tk` varchar(200) NOT NULL,
  `nama_perusahaan` varchar(200) NOT NULL,
  `peminta` varchar(100) NOT NULL,
  `lokasi_pengerjaan` varchar(200) NOT NULL,
  `jenis_pekerjaan` varchar(300) NOT NULL,
  `nama_material` varchar(500) NOT NULL,
  `pekerjaan` varchar(500) NOT NULL,
  `lama_kerja` varchar(100) NOT NULL,
  `catatan` varchar(300) NOT NULL,
  `verifikator` varchar(200) NOT NULL,
  `tgl_verifikator` date NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lpt`
--

INSERT INTO `tbl_lpt` (`id_lpt`, `no_agenda`, `no_form`, `tgl_lpt`, `nama_tk`, `nama_perusahaan`, `peminta`, `lokasi_pengerjaan`, `jenis_pekerjaan`, `nama_material`, `pekerjaan`, `lama_kerja`, `catatan`, `verifikator`, `tgl_verifikator`, `id_surat`, `id_user`) VALUES
(17, 'LPT/2020-10/0001', 'FM.TNK.004', '2020-10-05', 'Hendra, Samsudin', 'PT Victoria property berjaya', 'Tri Laksono Marketing', 'Gp.Utama/9/906', 'Bongkar Closed', '', 'Penggantian Closed baru', '1 jam', '', '', '0000-00-00', 47, 2),
(19, 'LPT/2020-10/0004', 'FM.TNK.004', '2020-10-14', 'Hendra, Samsudin', 'PT Huawei', 'Tri Laksono Marketing', 'GP.Extension/lt.7', 'Cek Smoke detector yang mati', 'tidak ada', 'Ganti Smoke detector', '1jam', '', 'Gea', '2020-10-30', 55, 2),
(20, 'LPT/2020-10/0004', 'FM.TNK.004', '2020-10-14', 'Hendra, Samsudin', 'PT Nusa Net', 'Tri Laksono Marketing', 'GP.extension 3 30344', 'Instalasi ducting untuk penambahan jalur AC ', '', 'Penambahan SAD', '1 jam', '', 'Gea', '2020-10-16', 59, 2),
(28, 'LPT/2020-11/0013', 'FM.TNK.004', '2020-11-04', 'Hendra, Samsudin', 'Salad Mama Fafa', 'Tri Laksono Marketing', 'Gp utama', 'Bongkar Closed', '', 'Penggantian Closed baru', '1jam', '', 'Gea', '2020-11-28', 68, 5),
(29, 'LPT/2020-11/0013', 'FM.TNK.004', '2020-11-04', 'n', 'n', 'n', 'n', 'n', 'n', 'n', '1jam', 'n', 'n', '2020-11-27', 67, 5),
(30, 'LPT/2020-11/0013', 'FM.TNK.004', '2020-11-04', 't', 't', 't', 't', 't', 't', 't', 't', 't', 't', '2020-11-28', 65, 5),
(31, 'LPT/2020-11/0014', 'FM.TNK.004', '2020-11-10', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', '2020-11-08', 69, 5),
(33, 'LPT/2020-11/0015', 'FM.TNK.004', '2020-11-08', 'k', 'k', 'k', 'k', 'k', 'k', 'k', 'kk', 'k', 'k', '2020-11-07', 70, 5),
(34, 'LPT/2020-11/0015', 'FM.TNK.004', '2020-11-08', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', '2020-11-08', 70, 5),
(35, 'LPT/2020-11/0016', 'FM.TNK.004', '2020-11-08', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', '2020-11-30', 71, 5),
(36, 'LPT/2020-11/0016', 'FM.TNK.004', '2020-11-08', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', '2020-11-30', 66, 5),
(37, 'LPT/2020-11/0016', 'FM.TNK.004', '2020-11-09', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', '2020-11-16', 64, 5),
(38, 'LPT/2020-11/0016', 'FM.TNK.004', '2020-11-09', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', '2020-11-27', 63, 5),
(39, 'LPT/2020-11/0016', 'FM.TNK.004', '2020-11-09', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', '2020-11-09', 56, 5),
(40, 'LPT/2020-11/0016', 'FM.TNK.004', '2020-11-09', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', '2020-11-30', 62, 5),
(41, 'LPT/2020-11/0019', 'FM.TNK.004', '2020-11-09', 'pacul', 'pacul', 'pacul', 'pacul', 'pacul', 'pacul', 'pacul', 'pacul', 'pacul', 'pacul', '2020-11-26', 74, 5),
(42, 'LPT/2020-11/0020', 'FM.TNK.004', '2020-11-09', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', '2020-11-30', 75, 5),
(43, 'LPT/2020-11/0027', 'FM.TNK.004', '2020-11-12', 'Hendra, Markus', 'PT Ini itu', 'Wiwik Marketing', 'Gp utaama', 'blabala', '', 'asdasdasd', '1 jam', '', '', '0000-00-00', 81, 5),
(44, 'LPT/2020-11/0027', 'FM.TNK.004', '2020-11-25', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', '2020-11-30', 82, 9),
(45, 'LPT/2020-11/0001', 'FM.TNK.004', '2020-11-11', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', '2020-11-28', 83, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sett`
--

CREATE TABLE IF NOT EXISTS `tbl_sett` (
  `id_sett` tinyint(1) NOT NULL,
  `surat_masuk` tinyint(2) NOT NULL,
  `surat_keluar` tinyint(2) NOT NULL,
  `referensi` tinyint(2) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sett`
--

INSERT INTO `tbl_sett` (`id_sett`, `surat_masuk`, `surat_keluar`, `referensi`, `id_user`) VALUES
(1, 10, 10, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_keluar`
--

CREATE TABLE IF NOT EXISTS `tbl_surat_keluar` (
`id_surat` int(10) NOT NULL,
  `no_agenda` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_catat` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_masuk`
--

CREATE TABLE IF NOT EXISTS `tbl_surat_masuk` (
`id_surat` int(10) NOT NULL,
  `no_agenda` varchar(100) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `asal_surat` varchar(250) NOT NULL,
  `isi` varchar(1000) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `indeks` varchar(30) NOT NULL,
  `status` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` date NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_surat_masuk`
--

INSERT INTO `tbl_surat_masuk` (`id_surat`, `no_agenda`, `no_surat`, `asal_surat`, `isi`, `kode`, `indeks`, `status`, `tgl_surat`, `tgl_diterima`, `file`, `keterangan`, `id_user`) VALUES
(83, 'PMK/2020-11/0001', 'Kabag.Teknik/Kabag.Facility/SCR', 'GP.Utama-20', 'Teknik : Standarisasi ruangan, HKP : Bersihkan ruangan, Facility : pasang karpet, SCR : Pantau', 'FM.MRK.003', 'PT Graha Pena Jawa Pos', 'Terbit', '2020-11-11', '2020-11-11', '', '2020-11-30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
`id_user` tinyint(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `nama`, `nip`, `admin`) VALUES
(1, 'prima88', '9328d3f1ea4d36d127a6221f48e2392d', 'Prima Brahmana', '-', 1),
(2, 'gea88', '856ce1a9faec4429ace6f1aa84139c81', 'adrine gladia', '35744', 3),
(3, 'wiwik88', 'e8c671a9b8f36cf8b69430e0ec2e1811', 'Wiwik Sunariadi', '-', 1),
(5, 'desi88', '1120edfeeb9c98edb2381776a00b69ef', 'desi suryani', '2222', 2),
(6, 'prima8', 'c335a8218ec0422be2049fbc33465ac5', 'Prima brahmana', '-', 1),
(7, 'mario88', 'a54ec791c0483969ef32aed9541360e3', 'Mario Restu', '1234', 4),
(8, 'arif88', '6f171e9913431a13dee1bafd0ba6fefb', 'Arif Prasetyao', '12345', 4),
(9, 'markus88', '464ffffefb06d2a1aa3f7076562e233b', 'Markus Basah', '126', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_approve_lpt`
--
ALTER TABLE `tbl_approve_lpt`
 ADD PRIMARY KEY (`id_approve_lpt`);

--
-- Indexes for table `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
 ADD PRIMARY KEY (`id_disposisi`);

--
-- Indexes for table `tbl_instansi`
--
ALTER TABLE `tbl_instansi`
 ADD PRIMARY KEY (`id_instansi`);

--
-- Indexes for table `tbl_klasifikasi`
--
ALTER TABLE `tbl_klasifikasi`
 ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indexes for table `tbl_lpt`
--
ALTER TABLE `tbl_lpt`
 ADD PRIMARY KEY (`id_lpt`);

--
-- Indexes for table `tbl_sett`
--
ALTER TABLE `tbl_sett`
 ADD PRIMARY KEY (`id_sett`);

--
-- Indexes for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
 ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
 ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_approve_lpt`
--
ALTER TABLE `tbl_approve_lpt`
MODIFY `id_approve_lpt` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
MODIFY `id_disposisi` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `tbl_klasifikasi`
--
ALTER TABLE `tbl_klasifikasi`
MODIFY `id_klasifikasi` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_lpt`
--
ALTER TABLE `tbl_lpt`
MODIFY `id_lpt` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
MODIFY `id_surat` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
MODIFY `id_surat` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
