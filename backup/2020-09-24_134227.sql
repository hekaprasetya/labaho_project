DROP TABLE tbl_disposisi;

CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(10) NOT NULL AUTO_INCREMENT,
  `tujuan` varchar(250) NOT NULL,
  `isi_disposisi` mediumtext NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `sifat1` varchar(100) NOT NULL,
  `batas_waktu` date NOT NULL,
  `catatan` varchar(250) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_disposisi`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

INSERT INTO tbl_disposisi VALUES("12","","","diterima","diterima","0000-00-00","","0","0");
INSERT INTO tbl_disposisi VALUES("13","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("14","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("15","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("16","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("17","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("18","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("19","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("20","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("21","","","Diterima","Diterima","0000-00-00","","0","1");
INSERT INTO tbl_disposisi VALUES("26","","","Belum Dibaca","Diterima","0000-00-00","","4","1");
INSERT INTO tbl_disposisi VALUES("27","","","Diterima","Diterima","0000-00-00","","5","1");
INSERT INTO tbl_disposisi VALUES("28","","","Diterima","Diterima","0000-00-00","","6","1");
INSERT INTO tbl_disposisi VALUES("29","","","Diterima","Diterima","0000-00-00","","8","1");
INSERT INTO tbl_disposisi VALUES("30","","","Diterima","Diterima","0000-00-00","","11","1");
INSERT INTO tbl_disposisi VALUES("31","","","Diterima","Diterima","0000-00-00","","13","1");
INSERT INTO tbl_disposisi VALUES("37","","","Belum Dibaca","Belum Dibaca","0000-00-00","","27","1");
INSERT INTO tbl_disposisi VALUES("38","","","Belum Dibaca","Belum Dibaca","0000-00-00","","29","1");
INSERT INTO tbl_disposisi VALUES("39","","","Belum Dibaca","Belum Dibaca","0000-00-00","","34","1");
INSERT INTO tbl_disposisi VALUES("41","","","Diterima","Diterima","0000-00-00","","35","1");
INSERT INTO tbl_disposisi VALUES("42","","","Diterima","Belum Dibaca","0000-00-00","","36","2");
INSERT INTO tbl_disposisi VALUES("43","","","Diterima","Diterima","0000-00-00","","39","1");



DROP TABLE tbl_instansi;

CREATE TABLE `tbl_instansi` (
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
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_instansi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_instansi VALUES("1","P M K","SIMARTEK","Terakreditasi A","Sistem Informasi Marketing Teknik","PT Graha Pena Jawa Pos","-","https://grahapenajawapos.com","marketing@grahapenajawapos.com","logo.png","1");



DROP TABLE tbl_klasifikasi;

CREATE TABLE `tbl_klasifikasi` (
  `id_klasifikasi` int(5) NOT NULL AUTO_INCREMENT,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `uraian` mediumtext NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_klasifikasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE tbl_sett;

CREATE TABLE `tbl_sett` (
  `id_sett` tinyint(1) NOT NULL,
  `surat_masuk` tinyint(2) NOT NULL,
  `surat_keluar` tinyint(2) NOT NULL,
  `referensi` tinyint(2) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_sett`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_sett VALUES("1","5","10","10","2");



DROP TABLE tbl_surat_keluar;

CREATE TABLE `tbl_surat_keluar` (
  `id_surat` int(10) NOT NULL AUTO_INCREMENT,
  `no_agenda` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_catat` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE tbl_surat_masuk;

CREATE TABLE `tbl_surat_masuk` (
  `id_surat` int(10) NOT NULL AUTO_INCREMENT,
  `no_agenda` varchar(100) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `asal_surat` varchar(250) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `indeks` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` date NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

INSERT INTO tbl_surat_masuk VALUES("20","PMK/2020-08/0001","asdasd","tetett","asdasd","FM.MRK.003","asd","2020-08-31","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("21","PMK/2020-08/0002","Kabag.Teknik","GP.utama-4-R04","asdasd","FM.MRK.003","tesasdasdasd","2020-08-15","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("22","PMK/2020-08/0003","kabag.teknik/facility","asd","asdasd","FM.MRK.003","aasd","2020-08-15","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("23","PMK/2020-08/0004","kabag.teknik/facility/scr","asdasdasd","asdasd","FM.MRK.003","asd","2020-08-08","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("24","PMK/2020-08/0005","kabag.teknik/facility/scr","asdasd","asdasd","FM.MRK.003","asdasd","2020-08-31","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("25","PMK/2020-08/0006","kabag.teknik/facility/scr","asdasdasd","sadasd","FM.MRK.003","asdasd","2020-08-14","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("27","PMK/2020-08/0008","Teknik-Scr-Facility","GP.extension-4-infomedia","General Ruangan ","FM.MRK.003","PT Infomedia","2020-08-31","0000-00-00","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("28","12","asdasqwe","asdas","asdqw","asd","qweasd","2020-09-11","2020-09-01","8577-640px-Telkom_Indonesia_2002.png","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("29","PMK/2020-09/0009","asdq12","asdasdasd","asdasd","asdasd","asdqw","2020-09-14","2020-09-01","1247-640px-Telkom_Indonesia_2002.png","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("30","PMK/2020-09/0010","zxcas","asdxc","zxcxz","FM.MRK.003","asdas","2020-09-03","2020-09-01","6494-1200px-Google__G__Logo.svg.png","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("31","PMK/2020-09/0011","sadaswqee","asdwqeqw","asdqwweqwe","FM.MRK.003","asdqweqwe","2020-09-05","2020-09-01","8248-640px-Telkom_Indonesia_2002.png","2020-09-01","1");
INSERT INTO tbl_surat_masuk VALUES("32","PMK/2020-09/0012","zxcasd","asdzxc","zxczxca","FM.MRK.003","asdasd","2020-09-05","2020-09-01","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("33","PMK/2020-09/0013","qweqwe","qweqweqwe","qweqweqwe","FM.MRK.003","qweqweqwe","0000-00-00","2020-09-01","","0000-00-00","1");
INSERT INTO tbl_surat_masuk VALUES("34","PMK/2020-09/0014","llllll","llllll","lllll","FM.MRK.003","llll","2020-09-12","2020-09-01","","2020-09-26","1");
INSERT INTO tbl_surat_masuk VALUES("35","PMK/2020-09/0015","tytyty","tytytyty","tytytyty","FM.MRK.003","tytyty","2020-09-12","2020-09-01","2206-773374-amazing-google-logo-wallpapers-1080x1920-hd-1080p.jpg","2020-09-26","2");
INSERT INTO tbl_surat_masuk VALUES("36","PMK/2020-09/0016","KabagFacility-KabagTeknik","Gp Utama-3-303","BOngkar pasang","FM.MRK.003","PT Makmur adi jaya","2020-09-18","2020-09-14","","2020-09-25","2");
INSERT INTO tbl_surat_masuk VALUES("38","PMK/2020-09/0017","asdasdasd","asdasdasd","asdasdas","FM.MRK.003","asdasdasd","2020-09-18","2020-09-22","","2020-09-25","2");
INSERT INTO tbl_surat_masuk VALUES("39","PMK/2020-09/0018","asdsad","asdasd","asdasd","FM.MRK.003","asdasd","2020-09-11","2020-09-22","","2020-09-25","2");
INSERT INTO tbl_surat_masuk VALUES("40","PMK/2020-09/0019","rererer","rererer","ererer","FM.MRK.003","erer","2020-09-17","2020-09-24","","2020-09-26","2");



DROP TABLE tbl_user;

CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user VALUES("1","hendra","a04cca766a885687e33bc6b114230ee9","Hendra Eka Prasetya","-","1");
INSERT INTO tbl_user VALUES("2","gea88","856ce1a9faec4429ace6f1aa84139c81","adrine gladia","35744","3");
INSERT INTO tbl_user VALUES("3","farida","41a6a36598a0acd0d0c3aac95edc7b35","farida aryani","32222","2");



