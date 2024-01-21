<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    ?>
    <style type="text/css">
        table {
            background: #fff;
            padding: 5px;
            line-height: 2.5;
        }
        tr, td {
            border: table-cell;
            border: 1px  solid #444;
            line-height: 1.3;
        }
        tr,td {
            vertical-align: top!important;
        }
        #right {
            border-right: none !important;
        }
        #left {
            border-left: none !important;
        }
        .isi {
            height: 300px!important;
        }
        .disp {
            text-align: center;
            padding: 1rem 0;
            margin-bottom: 1rem;
        }
        .logodisp {
            float: left;
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 0 0 1rem;
        }
        #lead {
            width: auto;
            position: relative;
            margin: 25px 0 0 75%;
        }
        .lead {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: -1px;
        }
        .tgh {
            text-align: center;
        }
        #nama {
            font-size: 2.1rem;
            margin-bottom: -1rem;
        }
        #alamat {
            font-size: 16px;
        }
        .up {
            text-transform: uppercase;
            margin: 0;
            line-height: 2.2rem;
            font-size: 1.5rem;
        }
        .status {
            margin: 0;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        #lbr {
            font-size: 20px;
            font-weight: bold;
        }
        .separator {
            border-bottom: 2px solid #616161;
            margin: -1.3rem 0 1.5rem;
        }
        @media print{
            body {
                font-size: 12px!important;
                color: #212121;
            }
            .disp {
                text-align: center;
                margin: -.5rem 0;
                width: 100%;
            }
            nav {
                display: none
            }
            .hidd {
                display: block
            }
            .logodisp {
                position: absolute;
                width: 80px;
                height: 80px;
                left: 50px;
                margin: 0 0 0 1.2rem;
            }
            .up {
                font-size: 17px!important;
                font-weight: normal;
                margin-top: 45px;
                text-transform: uppercase
            }
            #nama {
                font-size: 20px!important;
                text-transform: uppercase;
                margin-top: 5px;
                font-weight: bold;
            }
            .status {
                font-size: 17px!important;
                font-weight: normal;
                margin-top: -1.5rem;
            }
            #alamat {
                margin-top: -15px;
                font-size: 13px;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: 1rem 0;
            }
        }
    </style>
    <?php
    if (isset($_REQUEST['submit'])) {

        $dari_tanggal = $_REQUEST['dari_tanggal'];
        $sampai_tanggal = $_REQUEST['sampai_tanggal'];

        if ($_REQUEST['dari_tanggal'] == "" || $_REQUEST['sampai_tanggal'] == "") {
            header("Location: ./admin.php?page=report_pp");
            die();
        } else {

            $query1 = "SELECT * FROM tbl_pp_barang
                       LEFT JOIN tbl_pp
                       ON tbl_pp_barang.id_pp=tbl_pp.id_pp
                       LEFT JOIN tbl_gm_pp
                       ON tbl_pp_barang.id_barang=tbl_gm_pp.id_barang
                       LEFT JOIN tbl_pembelian
                       ON tbl_pp_barang.id_pp=tbl_pembelian.id_pp
                       LEFT JOIN tbl_pp_gudang
                       ON tbl_pp_barang.id_barang=tbl_pp_gudang.id_barang
                       LEFT JOIN tbl_pembelian_realisasi
                       ON tbl_pp_barang.id_barang=tbl_pembelian_realisasi.id_barang
                      
                                                           
                       WHERE DATE(tgl_pp) BETWEEN '$dari_tanggal' AND '$sampai_tanggal'";
            $query = mysqli_query($config, $query1);
            $query2 = mysqli_query($config, "SELECT nama FROM tbl_instansi");
            list($nama) = mysqli_fetch_array($query2);
            ?>
            <!-- SHOW DAFTAR AGENDA -->
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <div class="col 12">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="?page=pp&act=report_pp" class="judul"><i class="material-icons">print</i> Cetak Laporan E-PP<a></li>
                                                    </ul>
                                                    </div>
                                                    </div>
                                                    </nav>
                                                    </div>
                                                    </div>
                                                    <!-- Secondary Nav END -->
                                                    </div>
                                                    <!-- Row END -->

                                                    <!-- Row form Start -->
                                                    <div class="row jarak-form black-text">
                                                        <form class="col s12" method="post" action="">
                                                            <div class="input-field col s8">
                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                <input id="dari_tanggal" type="text" name="dari_tanggal" id="dari_tanggal" required>
                                                                <label for="dari_tanggal">Dari Tanggal</label>
                                                            </div>
                                                            <div class="input-field col s8">
                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                                                                <label for="sampai_tanggal">Sampai Tanggal</label>
                                                            </div>
                                                            <div class="col s6">
                                                                <button type="submit" name="submit" class="btn small blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- Row form END -->

                                                    <div class="row agenda">
                                                        <div class="disp hidd">
                                                            <?php
                                                            $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                                                            list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
                                                            ?>
                                                            <span></span><br/>
                                                            <img class="logodisp" src="./upload/<?= $logo ?>"/>
                                                            <span></span><br/>
                                                            <span><h6>LAPORAN E - PP</h6></span><br/>
                                                            <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/>

                                                        </div>
                                                        <div class="separator"></div>
                                                        <div class="col s10">
                                                            <p class="warna agenda">Laporan dari tanggal <strong><?= indoDate($dari_tanggal) ?></strong> sampai dengan tanggal <strong><?= indoDate($sampai_tanggal) ?></strong></p>
                                                        </div>
                                                        <div class="col s6">
                                                            <a class="btn-large red" type="submit" onClick="window.print()">
                                                                <i class="material-icons"></i>pdf</a>
                                                            <?php
                                                            // Menggunakan fungsi untuk menghasilkan dan mengunduh file CSV
                                                            $date = date('d-m-y');
                                                            $date = str_replace(".", "", $date);
                                                            $fileName = "Laporan-PP-" . $date . ".csv";

                                                            // Menambahkan header 
                                                            $header = array(
                                                                "No",
                                                                "No.PP",
                                                                "Tgl",
                                                                "Nama Barang",
                                                                "Jumlah",
                                                                "Satuan",
                                                                "Keterangan",
                                                                "Tujuan",
                                                                "Diketahui GM",
                                                                "Diterima Gudang"
                                                            );

                                                            // Mengambil hasil dari query
                                                            $res = mysqli_query($config, $query1);
                                                            $no = 1;

                                                            // Inisialisasi dataArray di luar loop
                                                            $dataArray = array();

                                                            while ($row = $res->fetch_assoc()) {
                                                                $dataArray[] = array(
                                                                    $no, $row['no_pp'],
                                                                    indoDate($row['tgl_pp']),
                                                                    $row['nama_barang'],
                                                                    $row['jumlah'],
                                                                    $row['satuan'],
                                                                    $row['keterangan_pp'],
                                                                    $row['tujuan_pp'],
                                                                    $row['status_gm'],
                                                                    (!empty($row['status_gudang'])) ? "{$row['status_gudang']},{$row['waktu_gudang']}" : 'Belum diterima'
                                                                );
                                                                $no++;
                                                            }
                                                            ?>

                                                            <form action="excel_report.php" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="header" value="<?= htmlspecialchars(json_encode($header)) ?>">
                                                                <input type="hidden" name="dataArray" value="<?= htmlspecialchars(json_encode($dataArray)) ?>">
                                                                <input type="hidden" name="fileName" value="<?= htmlspecialchars($fileName) ?>">
                                                                <button type="submit" class="btn-large green">excel <i class="material-icons"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div id="colres" class="warna cetak">
                                                        <table class="bordered" id="tbl" width="100%">
                                                            <thead class="blue lighten-1">
                                                                <tr>
                                                                    <th width="2%">No</th>
                                                                    <th width="11%">No.PP<br/><hr/>Tgl.PP</th>
                                                            <th width="11%">Nama Barang</th>
                                                            <th width="3%">Jumlah</th>
                                                            <th width="4%">Satuan</th>
                                                            <th width="10%">Keterangan</th>
                                                            <th width="10%">Tujuan</th>
                                                            <th width="10%">Diketahui GM</th>
                                                            <th width="11%">Diterima Gudang<br/><hr/>Waktu</th>
                                                            <th width="3%">Dibuat</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (mysqli_num_rows($query) > 0) {
                                                                    $no = 0;
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        $no++;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $no ?></td>
                                                                            <td><?= $row['no_pp'] ?><br/><hr/><?= indoDate($row['tgl_pp']) ?></td>
                                                                            <td><?= $row['nama_barang'] ?></td>
                                                                            <td><?= $row['jumlah'] ?></td>
                                                                            <td><?= $row['satuan'] ?></td>
                                                                            <td><?= $row['keterangan_pp'] ?></td>
                                                                            <td><?= $row['tujuan_pp'] ?></td>
                                                                            <td><strong><?= ucwords(strtolower($row['status_gm'])) ?></td>
                                                                            <td><strong><?= ucwords(strtolower($row['status_gudang'])) ?><br/><hr/><?= $row['waktu_gudang'] ?></strong></td>
                                                                            <td>
                                                                                <?php
                                                                                $id_user = $row['id_user'];
                                                                                $query3 = mysqli_query($config, "SELECT nama FROM tbl_user WHERE id_user='$id_user'");

                                                                                list($nama) = mysqli_fetch_array($query3); {
                                                                                    $row['id_user'] = '' . $nama . '';
                                                                                }

                                                                                echo '' . $row['id_user'] . '</td>

                                                                                 </tr>';
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                    <tr>
                                                                        <td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>
                                                            <?php }
                                                            ?>
                                                            </tbody></table>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <!-- Row Start -->
                                                <div class="row">
                                                    <!-- Secondary Nav START -->
                                                    <div class="col s12">
                                                        <div class="z-depth-1">
                                                            <nav class="secondary-nav">
                                                                <div class="nav-wrapper blue-grey darken-1">
                                                                    <div class="col 12">
                                                                        <ul class="left">
                                                                            <li class="waves-effect waves-light"><a href="?page=report_pp" class="judul"><i class="material-icons">print</i> Cetak Laporan E-PP<a></li>
                                                                                        </ul>
                                                                                        </div>
                                                                                        </div>
                                                                                        </nav>
                                                                                        </div>
                                                                                        </div>
                                                                                        <!-- Secondary Nav END -->
                                                                                        </div>
                                                                                        <!-- Row END -->

                                                                                        <!-- Row form Start -->
                                                                                        <div class="row jarak-form black-text">
                                                                                            <form class="col s12" method="post" action="">
                                                                                                <div class="input-field col s8">
                                                                                                    <i class="material-icons prefix md-prefix">date_range</i>
                                                                                                    <input id="dari_tanggal" type="text" name="dari_tanggal" id="dari_tanggal" required>
                                                                                                    <label for="dari_tanggal">Dari Tanggal</label>
                                                                                                </div>
                                                                                                <div class="input-field col s8">
                                                                                                    <i class="material-icons prefix md-prefix">date_range</i>
                                                                                                    <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                                                                                                    <label for="sampai_tanggal">Sampai Tanggal</label>
                                                                                                </div>
                                                                                                <div class="col s6">
                                                                                                    <button type="submit" name="submit" class="btn small blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                        <!-- Row form END --><?php
                                                                                }
                                                                            }
                                                                                    ?>
