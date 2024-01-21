DROP TABLE tbl_approve_lpt;

CREATE TABLE `tbl_approve_lpt` (
  `id_approve_lpt` int(11) NOT NULL AUTO_INCREMENT,
  `ttd_spv` varchar(200) NOT NULL,
  `ttd_kabag` varchar(200) NOT NULL,
  `id_lpt` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_approve_lpt`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO tbl_approve_lpt VALUES("7","Diterima","Diterima","52","7");
INSERT INTO tbl_approve_lpt VALUES("8","Diterima","Diterima","50","7");
INSERT INTO tbl_approve_lpt VALUES("9","Diterima","Diterima","49","7");
INSERT INTO tbl_approve_lpt VALUES("10","Diterima","Diterima","51","7");



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
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

INSERT INTO tbl_disposisi VALUES("67","","","Diterima","Diterima","0000-00-00","","89","6");
INSERT INTO tbl_disposisi VALUES("68","","","Diterima","Diterima","0000-00-00","","90","3");
INSERT INTO tbl_disposisi VALUES("69","","","Diterima","Diterima","0000-00-00","","92","3");
INSERT INTO tbl_disposisi VALUES("70","","","Diterima","Diterima","0000-00-00","","91","3");
INSERT INTO tbl_disposisi VALUES("71","","","Diterima","Diterima","0000-00-00","","94","6");
INSERT INTO tbl_disposisi VALUES("72","","","Diterima","Diterima","0000-00-00","","93","6");
INSERT INTO tbl_disposisi VALUES("73","","","Diterima","Diterima","0000-00-00","","96","3");
INSERT INTO tbl_disposisi VALUES("74","","","Diterima","Diterima","0000-00-00","","95","3");
INSERT INTO tbl_disposisi VALUES("75","","","Diterima","Diterima","0000-00-00","","97","3");
INSERT INTO tbl_disposisi VALUES("76","","","Diterima","Diterima","0000-00-00","","100","6");
INSERT INTO tbl_disposisi VALUES("77","","","Diterima","Diterima","0000-00-00","","99","6");
INSERT INTO tbl_disposisi VALUES("78","","","Diterima","Diterima","0000-00-00","","98","6");
INSERT INTO tbl_disposisi VALUES("79","","","Diterima","Diterima","0000-00-00","","101","3");
INSERT INTO tbl_disposisi VALUES("80","","","Diterima","Diterima","0000-00-00","","102","6");
INSERT INTO tbl_disposisi VALUES("81","","","Diterima","Diterima","0000-00-00","","104","6");
INSERT INTO tbl_disposisi VALUES("82","","","Diterima","Diterima","0000-00-00","","103","6");
INSERT INTO tbl_disposisi VALUES("83","","","Diterima","Diterima","0000-00-00","","105","3");
INSERT INTO tbl_disposisi VALUES("85","","","Diterima","Diterima","0000-00-00","","110","6");
INSERT INTO tbl_disposisi VALUES("87","","","Diterima","Diterima","0000-00-00","","109","6");
INSERT INTO tbl_disposisi VALUES("88","","","Diterima","Diterima","0000-00-00","","108","6");
INSERT INTO tbl_disposisi VALUES("89","","","Diterima","Diterima","0000-00-00","","107","6");
INSERT INTO tbl_disposisi VALUES("90","","","Diterima","Diterima","0000-00-00","","106","6");
INSERT INTO tbl_disposisi VALUES("92","","","Diterima","Diterima","0000-00-00","","111","6");



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

INSERT INTO tbl_instansi VALUES("1","P M K","SMARTECH","Terakreditasi A","Sistem Informasi Marketing Teknik","PT Graha Pena Jawa Pos","-","https://grahapenajawapos.com","marketing@grahapenajawapos.com","logo.png","1");



DROP TABLE tbl_klasifikasi;

CREATE TABLE `tbl_klasifikasi` (
  `id_klasifikasi` int(5) NOT NULL AUTO_INCREMENT,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `uraian` mediumtext NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_klasifikasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE tbl_lpt;

CREATE TABLE `tbl_lpt` (
  `id_lpt` int(11) NOT NULL AUTO_INCREMENT,
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
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_lpt`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

INSERT INTO tbl_lpt VALUES("49","LPT/2020-11/0001","FM.TNK.004","2020-11-18","Hendra Prasetyo","Nusanet","sdri Ghea (TR-GPJP)","Lt 4 R JP Agro","Penarikan kabel UTP","-","Penarikan kabel utp dilakukan dari lt 3 ke lt 4 R JPA baru","-","-","Sdri Ghea","2020-11-19","91","5");
INSERT INTO tbl_lpt VALUES("50","LPT/2020-11/0001","FM.TNK.004","2020-11-18","Hendra Prasetyo","H3I","sdri Ghea (TR-GPJP)","Lt 6 GP Utama","Supervisi Penarikan kabel FO","-","Penarikan kabel FO dr lt 22 ke lt 6 R H3I","-","-","Sdri Ghea","2020-11-19","92","5");
INSERT INTO tbl_lpt VALUES("51","LPT/2020-11/0002","FM.TNK.004","2020-11-19","Aries & team Gondola","PT Satria Darma Pusaka ","sdri Ghea (TR-GPJP)","R 801A","Buka sealant satu unit jendela sisi timur ","2 bh handle jendela","buka jendela yg sebelumnya terkunci (pmk)","-","-","","0000-00-00","89","5");
INSERT INTO tbl_lpt VALUES("52","LPT/2020-11/0003","FM.TNK.004","2020-11-19","Sunardiyanto","JP Koran","sdri Ghea (TR-GPJP)","Ahu lt 5 podium","Menonaktifkan Ahu lt 5 podium no 2","-","Off Ahu lt 5 podium no 2 , dgn tujuan Efisiensi","-","-","Sdri Ghea","2020-11-19","97","5");



DROP TABLE tbl_sett;

CREATE TABLE `tbl_sett` (
  `id_sett` tinyint(1) NOT NULL,
  `surat_masuk` tinyint(2) NOT NULL,
  `surat_keluar` tinyint(2) NOT NULL,
  `referensi` tinyint(2) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_sett`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_sett VALUES("1","50","10","10","2");



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
  `isi` varchar(1000) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `indeks` varchar(30) NOT NULL,
  `status` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` date NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;

INSERT INTO tbl_surat_masuk VALUES("89","PMK/2020-11/0001","Kabag Teknik/SPV Facility ","GP Utama/7/709","Diinformasikan bahwa Gen FM ada permintaan pembukaan sealent jendela
Menurut hasil survey ada 3 jendela yg dapat dibuka.
2 menghadap selatan dan 1 ruang pojok barat-selatan (ruang pak anto), jendela yg menghadap barat

TNK : Dimohon untuk melakukan pembukaan jendela dan memasang handle
HKP : Dimohon untuk menjadwalkan tim gondola untuk melakukan pekerjaan tsb","FM.MRK.003","PT Radio Camar Gen FM","Terbit","2020-11-17","2020-11-17","7494-WhatsApp Image 2020-11-16 at 16.13.53.jpeg","2020-11-20","2");
INSERT INTO tbl_surat_masuk VALUES("90","PMK/2020-11/0002","KEU/LEGAL","Virtual Office","Diinformasikan bahwa PT Austeel Indonesia Metal memperpanjang virtual office 1206.
Periode perpanjangan 2 tahun (5 November 2020 - 4 November 2022)
Biaya sebesar Rp 550.000/bulan exc PPN, atau sebesar Rp 14.520.000/2 tahun inc PPN.

KEU : Dimohon untuk membuat invoice
LEGAL : Dimohon untuk membuat addendum","FM.MRK.003","PT Austeel Indonesia Metal","Terbit","2020-11-17","2020-11-17","","2020-11-17","2");
INSERT INTO tbl_surat_masuk VALUES("91","PMK/2020-11/0003","Kabag Teknik/SPV Facility Up. SCR","GP Utama/4","Diinformasikan bahwa Nusa Net akan melakukan relokasi kabel UTP untuk PT Jawa Pos Radar
Penarikan akan dilakukan dari PT. Jawa Pos Agro lantai 4 ke Rack GP lt.3
Dilakukan hari Rabu, 18 November 2020 Jam 19.00

TNK : Dimohon untuk supervisi
SCR : Mengijinkan dan mengetahui","FM.MRK.003","Nusa Net ","Terbit","2020-11-17","2020-11-17","","2020-11-18","2");
INSERT INTO tbl_surat_masuk VALUES("92","PMK/2020-11/0004","Kabag Teknik/SPV Facility Up. SCR","GP Utama/6","Diinformasikan bahwa H3I akan melakukan penarikan kabel FO dari Lantai 22 ke Lantai 6. Survey sudah dilakukan. Pekerjaan akan dilakukan pada hari Rabu, 18 November 2020 diatas jam 7 malam. TNK : Dimohon untuk supervisi, SCR : Mengetahui dan mengijinkan","FM.MRK.003","PT Hutchison 3 Indonesia","Terbit","2020-11-18","2020-11-18","","2020-11-18","2");
INSERT INTO tbl_surat_masuk VALUES("93","PMK/2020-11/0005","KEU/LEGAL","GP Utama/12/1204","Diinformasikan bahwa PT Airlock Indonesia Jaya Raya memperpanjang sewa, Periode 15 Desember 2020 - 14 Desember 2021, Harga SW = Rp 74.900/m2/bulan ; Harga SC = Rp 85.600/m2/bulan,  Luasan 66 m2. KEU : Dimohon untuk membuat invoice, LGL : DImohon untuk membuat addendum","FM.MRK.003","PT Airlock Indonesia Jaya Raya","Terbit","2020-11-18","2020-11-18","","2020-11-18","2");
INSERT INTO tbl_surat_masuk VALUES("94","PMK/2020-11/0006","KEU/LEGAL","GP Utama/3/306","Diinformasikan bahwa Fatachul Hudi dan Rekan memperpanjang sewa periode 21 November 2020 - 20 November 2021, SW = 75.000/m2 ; SC = 85.000/m2 (harga tetap, cara pembayaran 3 bulanan). KEU : Dimohon untuk membuat invoice, LGL : Dimohon untuk membuat addendum","FM.MRK.003","Fatachul Hudi dan Rekan","Terbit","2020-11-18","2020-11-18","","2020-11-18","2");
INSERT INTO tbl_surat_masuk VALUES("95","PMK/2020-11/0007","Kabag Teknik","GP Utama/5","Diinformasikan bahwa PT Jawa Pos Agro akan pindah ruangan ke Lantai 4, TNK : Dimohon untuk memindahkan line telepon 2137. (Dilakukan survey terlebih dahulu untuk mengetahui material yang dibutuhkan dan lokasi pemindahan)","FM.MRK.003","PT Jawa Pos Agro","Terbit","2020-11-19","2020-11-19","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("96","PMK/2020-11/0008","SPV Facility  Up. SCR","GP Utama/3/306","Diinformasikan bahwa Fatachul Hudi dan Rekan belum membayar uang sewa. SCR : Dimohon untuk melakukan penyegelan ruangan pada hari Kamis, 19 November 2020 jam 19.00.","FM.MRK.003","Fatachul Hudi dan Rekan","Terbit","2020-11-19","2020-11-19","","2020-11-19","2");
INSERT INTO tbl_surat_masuk VALUES("97","PMK/2020-11/0009","Kabag Teknik","GP Utama/5","Diinformasikan bahwa Group Jawa Pos di Lantai 5 sudah relokasi ke lantai 4, TNK : Dimohon untuk mematikan/menonaktifkan AHU 2 di podium per hari ini Kamis, 19 Nov 2020 untuk efisiensi.","FM.MRK.003","PT Graha Pena Jawa Pos","Terbit","2020-11-19","2020-11-19","","2020-11-19","2");
INSERT INTO tbl_surat_masuk VALUES("98","PMK/2020-11/0010","Kabag Teknik","GP Utama/5","Diinformasikan bahwa PT Jawa Pos Agro akan pindah ke Lantai 4, TNK : Dimohon untuk memindahkan KWH meter 1 phase 10 ampere milik JPA dari Lantai 5 ke Lantai 4. Dilakukan setelah server diturunkan ke Lantai 4 dikarenakan Server tidak boleh mati.(Waktu memindahkan server adalah Sabtu 21 November 2020 Pagi, pemindahan KWH / connect KWH dilakukan setelahnya)","FM.MRK.003","PT Jawa Pos Agro","Terbit","2020-11-19","2020-11-19","","2020-11-21","2");
INSERT INTO tbl_surat_masuk VALUES("99","PMK/2020-11/0011","Kabag Teknik/SPV Facility Up. SCR","GP Utama/4","Diinformasikan bahwa Indosat akan mengganti perangkat di Ruang Indosat Lantai 4 pada hari Kamis, 19 November 2020 Jam 19.00, TNK : Dimohon untuk supervisi. SCR : Mengetahui dan mengijinkan","FM.MRK.003","PT Indosat Tbk","Terbit","2020-11-19","2020-11-19","","2020-11-19","2");
INSERT INTO tbl_surat_masuk VALUES("100","PMK/2020-11/0012","Kabag Teknik/SPV Facility Up. SCR","GP Utama/9/906","Diinformasikan bahwa PT Victory Propertindo Berjaya akan melakukan pemasangan vinyl by vendor. Kontraktor menggunakan LA Design (PIC Bpk. Effendi - 081210009083). TNK SIPIL : Dimohon untuk supervisi, SCR : Mengetahui dan mengijinkan. Dilakukan pada hari Sabtu, 21 November 2020 mulai pagi jam 09.00.","FM.MRK.003","PT Victory Propertindo Berjaya","Terbit","2020-11-19","2020-11-19","","2020-11-21","2");
INSERT INTO tbl_surat_masuk VALUES("101","PMK/2020-11/0013","Kabag Teknik/SPV Facility Up. SCR","GP Utama/5","Diinformasikan bahwa PT Jawa Pos Agro akan melakukan pemindahan server dari lantai 5 ke lantai 4 (Dilakukan oleh Nusa Net), dan akan melakukan pemindahan AC Split dari Lantai 5 ke Lantai 4. TNK : Dimohon untuk supervisi pemindahan AC Split. SCR : Mengetahui dan mengijinkan. Pekerjaan akan dilakukan hari Sabtu, 21 November 2020 di pagi hari jam 08.00.","FM.MRK.003","PT Jawa Pos Agro","Terbit","2020-11-19","2020-11-19","","2020-11-21","2");
INSERT INTO tbl_surat_masuk VALUES("102","PMK/2020-11/0014","KEU","Ext/9/903","Diinformasikan bahwa PT Bukalapak.com tidak perpanjang sewa per 31 Oktober 2020.
KEU : Dimohon untuk mengeluarkan biaya deposit sebesar Rp 211.500.000,-","FM.MRK.003","PT Bukalapak.com","Terbit","2020-11-20","2020-11-20","","2020-11-20","2");
INSERT INTO tbl_surat_masuk VALUES("103","PMK/2020-11/0015","Kabag Teknik Up. SIPIL","GP Utama/5","Diinformasikan bahwa ruangan di depan JPA akan difungsikan sebagai ruang meeting.

TNK SIPIL : Dimohon untuk dapat memasang layar proyektor (dikarenakan tembok beton jadi harus menggunakan bor)","FM.MRK.003","Ruang Meeting Lantai 5","Terbit","2020-11-20","2020-11-20","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("104","PMK/2020-11/0016","Kabag Teknik","GP Utama/5","Diinformasikan bahwa The Square ada permintaan pemasangan SAD dan RAG di 1 ruangan (sudah di survey).

TNK : Dimohon untuk melakukan pemasangan RAG dan SAD (lokasinya sesuai dengan survey)","FM.MRK.003","The Square","Terbit","2020-11-20","2020-11-20","","2020-11-27","2");
INSERT INTO tbl_surat_masuk VALUES("105","PMK/2020-11/0017","Kabag Teknik","GP Utama/4","Diinformasikan bahwa Jawa Pos Holding ada permintaan pemasangan RAG dan SAD di ruang audit dan finance masing - masing 2 titik.

Teknik : Dimohon untuk instalasi RAG dan SAD tersebut","FM.MRK.003","PT Jawa Pos Holding","Terbit","2020-11-20","2020-11-20","","2020-11-28","2");
INSERT INTO tbl_surat_masuk VALUES("106","PMK/2020-11/0018","Kabag Teknik","Gedung DBL/1","Diinformasikan bahwa Pizza Hut telah selesai melakukan reinstate ruangan sewa. TNK : Dimohon untuk menonaktifkan dan mencatat meter akhir air pada hari Senin, 23 November 2020. Untuk meter listrik menunggu pekerjaan tambahan selesai dikerjakan (Menunggu Info)","FM.MRK.003","Pizza Hut","Terbit","2020-11-23","2020-11-23","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("107","PMK/2020-11/0019","Kabag Teknik/SPV Facility Up. SCR","GP Utama/3/306","Diinformasikan bahwa Kantor Advokat Fatachul Hudi sudah membayar sewa ruang. TNK : Dimohon untuk menyalakan listrik. SCR : Dimohon untuk membuka segel ruangan.","FM.MRK.003","Fatachul Hudi dan Rekan","Terbit","2020-11-23","2020-11-23","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("108","PMK/2020-11/0020","KEU/LEGAL","Ext/9/904","Diinformasikan bahwa PT Gibeon Solutions pindah ruangan ke 904 extention. KEU : Dimohon untuk cancel invoice untuk sewa di Lantai 16 dan membuat invoice sesuai dengan 904 extention per 20 November 2020. LGL : Dimohon untuk membuat perjanjian sewa.
Periode 01 November 2020 - 31 Oktober 2020. SW = 100.000/m2/bulan ; SC = 70.000/m2/bulan. Luas ruangan 22 m2.","FM.MRK.003","PT Gibeon Solutions","Terbit","2020-11-23","2020-11-23","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("109","PMK/2020-11/0021","KEU/LEGAL","Ext Service Ofice/9/907.C","Diinformasikan bahwa PT DGL Expedisi Indonesia memperpanjang sewa ruang. Diberikan Grace Period 1 bulan (1 Desember 2020 - 31 Desember 2020). Sewa terhitung mulai periode 1 Januari 2021 - 31 Desember 2021. Harga SW = Rp 103.636/m2/bln ; SC = Rp 110.000/m2/bln (Harga Tetap). Harga Sewa : Rp 4.700.000,- + PPN 10%. 
KEU : Dimohon untuk membuat invoice per bulan Januari 2021.
LGL : Dimohon untuk membuat addendum","FM.MRK.003","PT DGL Expedisi Indonesia","Terbit","2020-11-23","2020-11-23","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("110","PMK/2020-11/0022","Kabag Teknik/SPV Facility ","GP Utama dan Extension","Diinformasikan bahwa Bilik desinfektan di Gedung Utama dan Extension di remove. TNK & Facility : Dimohon untuk memindahkan bilik desinfektan dari lobby gedung utama dan extension. ","FM.MRK.003","PT Graha Pena Jawa Pos","Terbit","2020-11-23","2020-11-23","","2020-11-23","2");
INSERT INTO tbl_surat_masuk VALUES("111","PMK/2020-11/0023","Kabag Teknik, SPV Facility","Gedung Utama dan Extension","Diinformasikan bahwa tata letak di lobby akan di redecor. Untuk rak barang akan dijadikan sekaligus tempat menulis penerimaan barang dan dokumen. TNK : Dimohon untuk memasang vinyl di bagian atas dan samping rak barang serta memasang pintu untuk rak. FACILITY : Dimohon untuk setting penempatan di lobby","FM.MRK.003","PT Graha Pena Jawa Pos","Terbit","2020-11-23","2020-11-23","","2020-11-26","6");



DROP TABLE tbl_user;

CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user VALUES("1","Null","9328d3f1ea4d36d127a6221f48e2392d","Null","-","1");
INSERT INTO tbl_user VALUES("2","gea88","856ce1a9faec4429ace6f1aa84139c81","Adrine Gladia","35744","3");
INSERT INTO tbl_user VALUES("3","wiwik88","e8c671a9b8f36cf8b69430e0ec2e1811","Wiwik Sunariadi","-","1");
INSERT INTO tbl_user VALUES("5","desi88","1120edfeeb9c98edb2381776a00b69ef","Desi Suryani","2222","2");
INSERT INTO tbl_user VALUES("6","prima8","c335a8218ec0422be2049fbc33465ac5","Prima brahmana","-","1");
INSERT INTO tbl_user VALUES("7","mario88","a54ec791c0483969ef32aed9541360e3","Mario Restu","1234","4");
INSERT INTO tbl_user VALUES("8","arif88","6f171e9913431a13dee1bafd0ba6fefb","Arif Prasetyo","12345","4");
INSERT INTO tbl_user VALUES("9","markus88","464ffffefb06d2a1aa3f7076562e233b","Markus Basah","126","4");



