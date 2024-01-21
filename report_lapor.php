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
            header("Location: ./admin.php?page=lapor&act=report_lapor");
            die();
        } else {

            $query = mysqli_query($config, "SELECT a.*, 
                                                                    b.id_app_lapor_tk,status_tk,waktu_tk,
                                                                    c.id_app_lapor_hkp,status_hkp,waktu_hkp,
                                                                    d.nama
                                                                    FROM tbl_lapor a
                                                                    LEFT JOIN tbl_approve_lapor_tk b
                                                                    ON a.id_lapor=b.id_lapor
                                                                    LEFT JOIN tbl_approve_lapor_hkp c
                                                                    ON a.id_lapor=c.id_lapor
                                                                    LEFT JOIN tbl_user d
                                                                    ON a.id_user=d.id_user                   
                                                        WHERE tgl_lapor BETWEEN '$dari_tanggal' AND '$sampai_tanggal'");

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
                                        <li class="waves-effect waves-light"><a href="?page=lapor&act=report_lapor" class="judul"><i class="material-icons">print</i> Cetak Laporan E-LAPOR</a></li>
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
                    <img class="logodisp" src="./upload/<?= $logo ?>"/>';
                    <span></span><br/>
                    <span><h6>LAPORAN E - LAPOR</h6></span><br/>
                    <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/>

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
                <th>No</th>
                <th width="15%">No.Lapor<br/><hr/>Tgl.Lapor</th>
        <th width="20%">Divisi<br/><hr/>Jenis Komplain</th>
        <th width="24%">Pemberi Komplain<br/><hr/>Pekerjaan yang dilakukan</th>
        <th width="18%">Aksi Komplain</th>
        <th width="18%">Lokasi<br/><hr/>Foto</th>
        <th width="18%">Pelapor</th>
        <th width="18%">Status</th>
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
                                            <td><strong><?= $row['no_lapor'] ?></strong><br/><hr/><?= indoDate($row['tgl_lapor']) ?></td>
                                            <td><?= ucwords(strtolower($row['divisi'])) ?><br/><hr><?= ucwords(strtolower($row['jenis_komplain'])) ?></td>
                                            <td><?= ucwords(strtolower($row['pemberi_komplain'])) ?><br/><hr><?= ucwords(strtolower($row['pekerjaan'])) ?></td>
                                            <td><strong><i><?= ucwords(strtolower($row['aksi_komplain'])) ?></i></strong></td>
                                            <td><?= nl2br(htmlentities($row['lokasi'])) ?><br/><br/><strong>Foto :</strong>
                                            <?php
                                            if (!empty($row['file'])) {
                                                ?>
                                                <strong><a href = "/./upload/lapor/<?= $row['file'] ?>"><img src="/./upload/lapor/<?= $row['file'] ?>" style="width: 100px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em>Tidak ada foto</em>
                                            <?php }
                                            ?>
                                        </td>
                                            <td><strong><?= $row['nama'] ?></strong></td>
                                            <td><strong><?= $row['status_hkp'] ?><h6><?= $row['waktu_hkp'] ?></h6><br/><hr><?= $row['status_tk'] ?><h6><?= $row['waktu_tk'] ?></h6></strong></td>

            </tr>
            <?php
            }
            } else {
            ?>
            <tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>
        <?php
        } ?>
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
                            <li class="waves-effect waves-light"><a href="?page=lapor&act=report_lapor" class="judul"><i class="material-icons">print</i> Cetak Laporan E-LAPOR</a></li>
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
