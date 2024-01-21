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
            header("Location: ./admin.php?page=report_lpg");
            die();
        } else {

            $query = mysqli_query($config, "SELECT a.*, 
                                                           b.no_agenda,indeks,asal_surat,
                                                           c.id_approve_lpg,status_app_lpg
                                                           FROM tbl_lpg a
                                                           LEFT JOIN tbl_surat_masuk b
                                                           ON a.id_surat=b.id_surat
                                                           LEFT JOIN tbl_approve_lpg c
                                                           ON a.id_lpg=c.id_lpg                        
                                                        WHERE tgl_lpg BETWEEN '$dari_tanggal' AND '$sampai_tanggal'");

            $query2 = mysqli_query($config, "SELECT nama FROM tbl_instansi");
            list($nama) = mysqli_fetch_array($query2);

            echo '
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
                                                <li class="waves-effect waves-light"><a href="?page=asm" class="judul"><i class="material-icons">print</i> Cetak Laporan E-LPG<a></li>
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
            echo '<span></span><br/>';
            echo '<img class="logodisp" src="./upload/' . $logo . '"/>';
            echo '<span></span><br/>';
            echo '<span><h6>LAPORAN E - LPG</h6></span><br/>';
            echo '<span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/>

                    </div>
                    <div class="separator"></div>
                       <div class="col s10">
                          <p class="warna agenda">Laporan dari tanggal <strong>' . indoDate($dari_tanggal) . '</strong> sampai dengan tanggal <strong>' . indoDate($sampai_tanggal) . '</strong></p>
                        </div>
                        <div class="col s6">
                            <button type="submit" onClick="window.print()" class="btn small deep-orange waves-effect waves-light right">CETAK <i class="material-icons">print</i></button>
                        </div>
                    </div>
                    <div id="colres" class="warna cetak">
                        <table class="bordered" id="tbl" width="100%">
                            <thead class="blue lighten-1">
                                <tr>
                                       <th>No</th>
                                         <th width="20%">No.LPG<br/><hr/>Tgl.LPG</th>
                                         <th width="20%">No.PMK</th>
                                         <th width="20%">Nama Perusahaan<br/><hr/>Lokasi</th>
                                          <th width="20%">Jenis Pekerjaan</th>
                                         <th width="20%">Status Kepala Bagian</th>
                                  
                                </tr>
                            </thead>
                            <tbody>';


            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
                    $no++;
                    echo '
                                <tr>
                                    <td>' . $no . '</td>
                                    <td><strong>' . $row['no_lpg'] . '</strong><br/><hr/>' . indoDate($row['tgl_lpg']) . '</td>
                                    <td><strong>' . $row['no_agenda'] . '</strong></td>
                                    <td>' . $row['indeks'] . '<br/><hr/>' . $row['asal_surat'] . '</td>
                                    <td>' . $row['pekerjaan_lpg'] . '</td>
                                    <td><strong>' . $row['status_app_lpg'] . '</strong></td>
                                      
                                </tr>';
                }
            } else {
                echo '<tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>';
            } echo '
                        </tbody></table>
                    </div>';
        }
    } else {

        echo '
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper blue-grey darken-1">
                                    <div class="col 12">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="?page=report_pp" class="judul"><i class="material-icons">print</i> Cetak Laporan E-LPG<a></li>
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
                <!-- Row form END -->';
    }
}
?>
