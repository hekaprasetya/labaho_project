<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    ?>

    <style type="text/css">
        .hidd {
            display: none
        }

        @media print {
            body {
                font-size: 12px !important;
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
                font-size: 17px !important;
                font-weight: normal;
                margin-top: 45px;
                text-transform: uppercase
            }

            #nama {
                font-size: 20px !important;
                text-transform: uppercase;
                margin-top: 5px;
                font-weight: bold;
            }

            .status {
                font-size: 17px !important;
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
            header("Location: ./admin.php?page=chiller&act=laporan");
            die();
        } else {

            $query = mysqli_query($config, "SELECT a.*,
                                                   b.nama
                                                   from utility_chiller a
                                                   LEFT JOIN tbl_user b
                                                   ON a.id_user=b.id_user
                                                   WHERE tgl_chiller BETWEEN '$dari_tanggal' AND '$sampai_tanggal'");

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
                            <div class="nav-wrapper blue darken-2">
                                <div class="col 12">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="?page=chiller&act=laporan" class="judul"><i class="material-icons">print</i> Laporan Logsheet Chiller<a></li>
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
                                                                <i class="material-icons prefix md-prefix">event_available</i>
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
                                                            <span></span><br />
                                                            <img class="logodisp" src="./upload/<?= $logo ?>" />
                                                            <span></span><br />
                                                            <span>
                                                                <h6>LAPORAN Logsheet Chiller</h6>
                                                            </span><br />
                                                            <span id="alamat">PT Graha Pena-Jawa Pos Jl.Ayani No: 88, Surabaya</span><br />

                                                        </div>
                                                        <div class="separator"></div>
                                                        <div class="col s10">
                                                            <p class="warna agenda">Laporan dari tanggal <strong><?= indoDate($dari_tanggal) ?></strong> sampai dengan tanggal <strong><?= indoDate($sampai_tanggal) ?></strong></p>
                                                        </div>

                                                        <div class="col s6">
                                                             <form action="excel_report.php" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="header" value="<?= htmlspecialchars(json_encode($header)) ?>">
                                                                <input type="hidden" name="dataArray" value="<?= htmlspecialchars(json_encode($dataArray)) ?>">
                                                                <input type="hidden" name="fileName" value="<?= htmlspecialchars($fileName) ?>">
                                                                <button type="submit" class="btn-large green">excel <i class="material-icons"></i></button>
                                                            </form>
                                                            <a class="btn-large red" type="submit" onClick="window.print()">
                                                                <i class="material-icons"></i>pdf</a>
                                                        </div>

                                                    </div>
                                                    <div id="colres" class="warna cetak">
                                                        <table class="bordered" id="tbl" width="100%">
                                                            <thead class="blue lighten-4">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Form<br>
                                                            <hr>Waktu
                                                            </th>
                                                            <th>Pemeriksa<br>
                                                            <hr>Nama Chiller
                                                            </th>
                                                            <th>Leaving Evap<br>
                                                            <hr>Entering Evap
                                                            </th>
                                                            <th>Set Point
                                                            </th>
                                                            <th>HP Circuit 1<br>
                                                            <hr>LP Circuit 2
                                                            </th>
                                                            <th>HP Circuit 1<br>
                                                            <hr>LP Circuit 2
                                                            </th>
                                                            <th>In Condensor<br>
                                                            <hr>Out Condensor
                                                            </th>
                                                            <th>Ampere<br>
                                                            <hr>Oat
                                                            </th>
                                                            <th>
                                                                Approach
                                                            </th>
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
                                                                            <td><center>
                                                                        <?= $row['no_form'] ?> <br>
                                                                        <hr><?= indoDateTime($row['tgl_chiller']) ?>
                                                                    </center>   
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['nama'] ?><br>
                                                                        <hr><?= $row['nama_chiller'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['leaving_evap'] ?><br>
                                                                        <hr><?= $row['entering_evap'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['setpoint'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['hp_c1'] ?><br>
                                                                        <hr><?= $row['lp_c2'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['hp_c1'] ?><br>
                                                                        <hr><?= $row['lp_c2'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['in_condensor'] ?><br>
                                                                        <hr><?= $row['out_condensor'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['ampere'] ?><br>
                                                                        <hr><?= $row['oat'] ?>
                                                                    </center>
                                                                    </td>
                                                                    <td><center>
                                                                        <?= $row['approach'] ?></td>
                                                                    </center>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="9">
                                                                <center>
                                                                    <p class="add">Tidak ada data</p>
                                                                </center>
                                                                </td>
                                                                </tr>
                                                            <?php } ?>
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
                                                                <div class="nav-wrapper blue darken-2">
                                                                    <div class="col 12">
                                                                        <ul class="left">
                                                                            <li class="waves-effect waves-light"><a href="?page=chiller&act=laporan" class="judul"><i class="material-icons">print</i> Cetak Laporan<a></li>
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
                                                                                                    <i class="material-icons prefix md-prefix">event_available</i>
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