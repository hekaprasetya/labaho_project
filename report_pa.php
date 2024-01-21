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
            header("Location: ./admin.php?page=report_pa");
            die();
        } else {

            $query = mysqli_query($config, "SELECT * FROM tbl_pa
                                                          LEFT JOIN tbl_approve_pa
                                                          ON tbl_pa.id_pa 
                                                          = tbl_approve_pa.id_pa 
                                                          LEFT JOIN tbl_pa_hasil
                                                          ON tbl_pa.id_pa
                                                          = tbl_pa_hasil.id_pa
                                                          WHERE tgl_acara
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
                                        <li class="waves-effect waves-light"><a href="?page=report_pa" class="judul"><i class="material-icons">print</i> Cetak Laporan E-P.A<a></li>
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
                                                            <span><h6>LAPORAN E - P.A</h6></span><br/>
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
                                                        <th>No</th>
                                                         <th width="8%">Status Surat</th>
                                                        <th width="12%">No.PA<br/><hr/>Tanggal Dibuat</th>
                                                        <th width="14%">Penanggung Jawab<br/><hr/>No.Telp</th>
                                                        <th width="14%">Ruangan Sewa<br/><hr/>Judul</th>
                                                        <th width="14%">Jadwal Acara<br/><hr/>Jam</th>
                                                        <th width="14%">Approve Manager</th>
                                                        <th width="14%">DP</th>
                                                        <th width="14%">Harga</th>
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
                                                        <td><strong><i><?= $row['status'] ?></i></strong></td>
                                                        <td><strong><?= $row['no_pa'] ?></strong><br/><hr/><?= indoDate($row['tgl_pa']) ?></td>
                                                        <!--td><?= substr($row['nama_perusahaan'], 0, 200) ?><br/><br/><strong>File :</strong>
                                                            <?php
                                                            if (!empty($row['file'])) {
                                                            ?>
                                                            <strong><a href="?page=gpa&act=fpa&id_pa=<?= $row['id_pa'] ?>"><?= $row['file'] ?></a></strong>
                                                            <?php
                                                            } else 
                                                                {
                                                            ?>
                                                            <em>Tidak ada file yang di upload</em>
                                                            <?php
                                                            } ?></td-->
                                                            
                                                        <td><?= ucwords(strtolower($row['penanggung_jawab'])) ?><br/><hr><?= $row['no_telp'] ?></td>
                                                        <td><?= $row['ruangan_sewa'] ?><br/><hr/><?= ucwords(strtolower($row['judul'])) ?></td>
                                                        <td><?= indoDate($row['tgl_acara'])?><br/><hr/><?= $row['jam'] ?></td>
                                                        <td><strong><?= $row['mng_mkt'] ?></strong></td>
                                                        <td><strong><?= $row['dp'] = "Rp " . number_format((float) $row['dp'], 0, ',', '.') ?></strong></td>
                                                        <td><strong><?= $row['total_all'] = "Rp " . number_format((float) $row['total_all'], 0, ',', '.') ?></strong></td>
                                                    </tr>
                                                    <?php
                                                    }

                                                    } else {
                                                    ?>
                                                    <tr><td colspan="9"><center><p class="add">Tidak ada Data</p></center></td></tr>
                                                    <?php
                                                } ?>
                                                </tbody></table>
                                            <?php
                                             $total = mysqli_fetch_array(mysqli_query($config, "SELECT sum(total_all) as total_semua,
                                                                                                        tgl_pa
                                                                                                        FROM tbl_pa_hasil
                                                                                                        JOIN tbl_pa
                                                                                                        ON tbl_pa_hasil.id_pa = tbl_pa.id_pa
                                                                                                        WHERE tgl_acara
                                                                                                        BETWEEN '$dari_tanggal' AND '$sampai_tanggal' "));
                                            ?>
                                               <table class="bordered" id="tbl" width="100%">
                                                <br/>
                                                <table class="bordered" id="tbl">
                                                    <thead class="blue lighten-4" id="head">
                                                    <th class="right">TOTAL : <strong><?php echo "Rp " . number_format((float)$total['total_semua'], 0, '.', '.') ?></strong></th>
                                                    </thead>
                                                </table>
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
                                                                    <li class="waves-effect waves-light"><a href="?page=report_pa" class="judul"><i class="material-icons">print</i> Cetak Laporan E-P.A</a></li>
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
