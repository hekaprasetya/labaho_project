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
            header("Location: ./admin.php?page=report_pa");
            die();
        } else {

            $query = mysqli_query($config, "SELECT a.*, 
                                                   b.id_app_op_kabag,status_op_kabag,
                                                   c.id_app_op_gm,status_op_gm,
                                                   d.nama_barang,jumlah_op,satuan,harga_op,keterangan_op_detail,total_op,total_ppn
                                                                   
                                                   FROM tbl_op a
                                                   LEFT JOIN tbl_approve_op_kabag b
                                                   ON a.id_op=b.id_op
                                                   LEFT JOIN tbl_approve_op_gm c
                                                   ON a.id_op=c.id_op
                                                   LEFT JOIN tbl_op_detail d
                                                   ON a.id_op=d.id_op
                                                   
                                                   WHERE tgl_op
                                    BETWEEN '$dari_tanggal' AND '$sampai_tanggal' ");

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
                                        <li class="waves-effect waves-light"><a href="?page=op&act=report_op" class="judul"><i class="material-icons">print</i> Cetak Laporan E-OP<a></li>
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
                                                            $query5 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                                                            list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query5)
                                                            ?>
                                                            <span></span><br/>
                                                            <img class="logodisp" src="./upload/<?= $logo ?>"/>
                                                            <span></span><br/>
                                                            <span><h6>LAPORAN E - OP</h6></span><br/>
                                                            <span id="alamat">PT Graha Pena-Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/>
                                                        </div>

                                                        <div class="separator"></div>
                                                        <div class="col s10">
                                                            <p class="warna agenda">Laporan dari tanggal <strong><?= indoDate($dari_tanggal) ?></strong> sampai dengan tanggal <strong><?= indoDate($sampai_tanggal) ?></strong></p>
                                                        </div>
                                                        <div class="col s6">
                                                            <button type="submit" onClick="window.print()" class="btn-large deep-orange waves-effect waves-light right">CETAK <i class="material-icons">print</i></button>
                                                        </div>
                                                    </div>

                                                    <div id="colres" class="warna cetak">
                                                        <table class="bordered" id="tbl" width="100%">
                                                            <thead class="blue lighten-1">
                                                                <tr>
                                                                    <th width="2%">No</th>
                                                                    <th width="4%">No.OP</th>
                                                                    <th width="8%">Tgl.OP</th>
                                                                    <th width="8%">Nama Barang</th>
                                                                    <th width="4%">Supplier</th>
                                                                    <th width="8%">Jml.OP</th>
                                                                    <th width="8%">Satuan</th>
                                                                    <th width="8%">Harga</th>
                                                                    <th width="8%">Keterangan</th>
                                                                    <th width="8%">Total</th>
                                                                    <th width="8%">Total+PPn</th>
                                                                    <th width="8%">Status Manager<br/><hr/>Status GM</th>
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
                                                                            <td><strong><?= $row['no_op'] ?></td>
                                                                            <td><?= indoDate($row['tgl_op']) ?></td>
                                                                            <td><?= ucwords(strtolower($row['nama_barang'])) ?></td>
                                                                            <td><?= ucwords(strtolower($row['supplier'])) ?></td>
                                                                            <td><?= ucwords(strtolower($row['jumlah_op'])) ?></td>
                                                                            <td><?= ucwords(strtolower($row['satuan'])) ?></td>
                                                                            <td><?= $trow["harga_op"] = "Rp " . number_format((float) $row['harga_op'], 0, ',', '.') ?></td>
                                                                            <td><?= ucwords(strtolower($row['keterangan_op_detail'])) ?></td>
                                                                            <td><?= $trow["total_op"] = "Rp " . number_format((float) $row['total_op'], 0, ',', '.') ?></td>
                                                                            <td><?= $trow["total_ppn"] = "Rp " . number_format((float) $row['total_ppn'], 0, ',', '.') ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if (!empty($row['status_op_kabag'])) {
                                                                                    ?> <strong><?= $row['status_op_kabag'] ?></a></strong>
                                                                                    <?php
                                                                                } else {
                                                                                    ?> <font color="red"><i>Kabag Kosong</i></font>
                                                                                <?php }
                                                                                ?><br/><hr/>
                                                                                <?php
                                                                                if (!empty($row['status_op_gm'])) {
                                                                                    ?> <strong><?= $row['status_op_gm'] ?></a></strong>
                                                                                    <?php
                                                                                } else {
                                                                                    ?> <font color="red"><i>GM Kosong</i></font>
                                                                                <?php }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr><td colspan="9"><center><p class="add">Tidak ada Data</p></center></td></tr>
                                                            <?php }
                                                            ?>
                                                            </tbody>
                                                        </table>


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
                                                                            <li class="waves-effect waves-light"><a href="?page=op&act=report_op" class="judul"><i class="material-icons">print</i> Cetak Laporan E-OP</a></li>
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
                                                <?php
                                            }
                                        }
                                        ?>
