<?php

//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    echo '
            <style type="text/css">
                .hidd {
                    display: none
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
            </style>';
    if (isset($_REQUEST['submit'])) {

        $dari_tanggal = $_REQUEST['dari_tanggal'];
        $sampai_tanggal = $_REQUEST['sampai_tanggal'];

        if ($_REQUEST['dari_tanggal'] == "" || $_REQUEST['sampai_tanggal'] == "") {
            header("Location: ./admin.php?page=absen&act=laporan");
            die();
        } else {

            $query1 = "SELECT a.*,
            b.nama
                      FROM tbl_absen a
                      LEFT JOIN tbl_user b ON a.id_user=b.id_user
                                                        WHERE DATE(tanggal) BETWEEN '$dari_tanggal' AND '$sampai_tanggal'";

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
                            <div class="nav-wrapper blue darken-2">
                                <div class="col 12">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="?page=asm" class="judul"><i class="material-icons">print</i> Cetak Laporan E-Absen<a></li>
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
                <div class="disp hidd">';
                    $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                    list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
                    echo '<span></span><br />';
                    echo '<img class="logodisp" src="./upload/' . $logo . '" />';
                    echo '<span></span><br />';
                    echo '<span>
                        <h6>LAPORAN E - Absen</h6>
                    </span><br />';
                    ?><span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br />

                </div>
                <div class="separator"></div>
                <div class="col s10">
                    <p class="warna agenda">Laporan dari tanggal <strong><?= indoDate($dari_tanggal) ?></strong> sampai dengan tanggal <strong><?= indoDate($sampai_tanggal) ?></strong></p>
                </div>

                <div class="col s6">
                    <!--button type="submit" onClick="window.print()" class="btn small deep-orange waves-effect waves-light right">CETAK <i class="material-icons">print</i></button-->
                    <?php


                    // Menggunakan fungsi untuk menghasilkan dan mengunduh file CSV
                    $date = date('d-m-y');
                    $date = str_replace(".", "", $date);
                    $fileName = "Laporan-Absen-" . $date . ".csv";

                    // Menambahkan header 
                    $header = array(
                        "Nama",
                        "Tanggal",
                        "jenis Absen",
                        "Status Absen",
                        "lokasi"
                    );

                    // Mengambil hasil dari query
                    $res = mysqli_query($conn, $query1);
                    $no = 1;

                    // Inisialisasi dataArray di luar loop
                    $dataArray = array();

                    while ($row = $res->fetch_assoc()) {
                        $long = $row['longi'];
                        $lati = $row['lati'];
                        $dataArray[] = array(
                            $row['nama'],
                            $row['tanggal'],
                            $row['jenis_absen'],
                            $row['status_absen'],
                            'https://www.google.com/maps/place/' . $lati . ',' . $long . '/@' . $lati . ',' . $long . ',17z/data=!3m1!4b1!4m4!3m3!8m2!3d' . $lati . '!4d' . $long . '?entry=ttu'
                        );
                        $no++;
                    }
                    $isi_row = array("nama", "tanggal", "jenis_absen", "status_absen");
                    $header = array("Nama", "Tanggal", "Jenis Absen", "Status Absen", "Lokasi");
                    ?>

                    <form action="excel_report.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="header" value="<?= htmlspecialchars(json_encode($header)) ?>">
                        <input type="hidden" name="dataArray" value="<?= htmlspecialchars(json_encode($dataArray)) ?>">
                        <input type="hidden" name="fileName" value="<?= htmlspecialchars($fileName) ?>">
                        <button type="submit" class="btn-large green waves-effect waves-light left">EXCEL<i class="material-icons">print</i></button>
                    </form>
                </div>
            </div>
            <div id="colres" class="warna cetak">
                <table class="bordered centered" id="tbl" width="100%">
                    <thead class="blue lighten-1">
                        <tr>
                            <th>No</th>
                            <?php foreach ($header as $head) { ?>
                                <th><?= ucfirst(str_replace('_', ' ', $head)) ?></th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (mysqli_num_rows($query) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query)) {
                                $no++;
                                $id = $row['id_absen'];
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <?php
                                    foreach ($isi_row as $kolom) {
                                        if ($kolom == "tanggal") {
                                            // Jika kolom adalah 'tgl_panel', terapkan fungsi indoDateTime
                                    ?>
                                            <td><?= indoDateTime($row[$kolom]) ?></td>
                                    <?php
                                        } else {
                                            // Untuk kolom lainnya
                                            echo "<td>$row[$kolom]</td>";
                                        }
                                    }
                                    ?>
                                    <td><a target="_blank" href="https://www.google.com/maps/place/<?= $row['lati'] ?>,<?= $row['longi'] ?>/@<?= $row['lati'] ?>,<?= $row['longi'] ?>,17z/data=!3m1!4b1!4m4!3m3!8m2!3d<?= $row['lati'] ?>!4d<?= $row['longi'] ?>?entry=ttu"><img src="asset/img/google.jpeg" width="50px" alt="lokasi"></a></td>


                                </tr>
                    <?php
                            }
                        } else {
                            echo '<tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>';
                        }
                        echo '
                        </tbody></table>
                    </div>';
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
                                                <li class="waves-effect waves-light"><a href="?page=absen&act=report" class="judul"><i class="material-icons">print</i> Cetak Laporan E-Absen<a></li>
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
                                <i class="material-icons prefix md-prefix">insert_invitation</i>
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
