<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Interior Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
          Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>

    <?php
//cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 10 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15 AND $_SESSION['admin'] != 18) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_permintaan_acara.php";
                        break;
                    case 'edit':
                        include "edit_permintaan_acara.php";
                        break;
                    case 'del':
                        include "hapus_permintaan_acara.php";
                        break;
                    case 'app_pa':
                        include "approve_pa.php";
                        break;
                    case 'upload_dp':
                        include "upload_pa_dp.php";
                        break;
                    case 'upload_tf':
                        include "upload_pa_tf.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT permintaan_acara FROM tbl_sett");
                list($permintaan_acara) = mysqli_fetch_array($query);

                //pagging
                $limit = $permintaan_acara;
                $pg = @$_GET['pg'];
                if (empty($pg)) {
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }
                ?>

                <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-3">
                                <div class="col m12">
                                    <ul class="left">
                                        <li class="col s5 waves-effect waves-light show-on-small-only"><a href="?page=pa&act=add" class="judul"><i class="material-icons"></i>E -PA</a></li>
                                        <div class="col s7 show-on-med-and-down">
                                            <form method="post" action="?page=pa">
                                                <div class="input-field round-in-box">
                                                    <input id="search" type="search" name="cari" placeholder="Searching" required>
                                                    <label for="search"><i class="material-icons md-dark">search</i></label>
                                                    <input type="submit" name="submit" class="show-on-med-and-down">
                                                </div>
                                            </form>
                                        </div>
                                </div>
                        </nav>
                    </div>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
            if (isset($_SESSION['succAdd'])) {
                $succAdd = $_SESSION['succAdd'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succAdd']);
            }
            if (isset($_SESSION['succEdit'])) {
                $succEdit = $_SESSION['succEdit'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succEdit']);
            }
            if (isset($_SESSION['succDel'])) {
                $succDel = $_SESSION['succDel'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succDel']);
            }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <?php
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=pa"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                               <tr>
                                <th>No</th>
                                <th width="15%">No.PA<br/><hr/>Tanggal Buat</th>
                        <th width="20%">Nama Perusahaan<br/><hr/>Status Surat</th>
                        <th width="10%">Penanggung Jawab<br/><hr/>No.Telp</th>
                        <th width="18%">Ruangan Sewa<br/><hr/>Judul</th>
                        <th width="10%">Jadwal Acara<br/><hr/>Jam</th>
                        <th width="10%">Harga Sewa</th>
                        <th width="7%">Approve Manager</th>
                        <th width="10%">Bukti DP<br/><hr/>Bukti Penyelesaian</th>
                            <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                //script untuk mencari data
                                $query = mysqli_query($config, "SELECT a.*, 
                                                                    b.mng_mkt,
                                                                     c.id_hasil,total_all,
                                                                    d.id_tf,
                                                                    e.file_tf,
                                                                    f.id_dp,file_dp
                                                                    FROM tbl_pa a
                                                                    LEFT JOIN tbl_approve_pa b
                                                                    ON a.id_pa=b.id_pa
                                                                    LEFT JOIN tbl_pa_hasil c
                                                                    ON a.id_pa=c.id_pa
                                                                    LEFT JOIN tbl_pa_tf d
                                                                    ON a.id_pa=d.id_pa
                                                                    LEFT JOIN tbl_pa_tf e
                                                                    ON a.id_pa=e.id_pa
                                                                    LEFT JOIN tbl_pa_dp f
                                                                    ON a.id_pa=f.id_pa
                                                                       WHERE no_pa LIKE '%$cari%' or nama_perusahaan
                                                                                   LIKE '%$cari%' or penanggung_jawab
                                                                                   LIKE '%$cari%' or no_telp 
                                                                                   LIKE '%$cari%' or judul 
                                                                                   LIKE '%$cari%' or jam
                                                                                   LIKE '%$cari%' or ruangan_sewa
                                                                                   LIKE '%$cari%' or tgl_acara
                                                                                   LIKE '%$cari%' ORDER by id_pa DESC");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                         <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_pa'] ?></strong><br/><hr/><?= indoDate($row['tgl_pa']) ?></td>
                                        <td><?= ucwords(strtolower($row['nama_perusahaan'])) ?><br/><hr><strong><i><?= $row['status'] ?></i></strong></td>
                                        <td><?= ucwords(strtolower($row['penanggung_jawab'])) ?><br/><hr><?= $row['no_telp'] ?></td>
                                        <td><?= $row['ruangan_sewa'] ?><br/><hr/><?= ucwords(strtolower($row['judul'])) ?></td>
                                        <td><strong><i><?= indoDate($row['tgl_acara']) ?></i></strong><br/><hr/><?= $row['jam'] ?></td>
                                        <td><i><?= $row['total_all'] = "Rp " . number_format((float) $row['total_all'], 0, ',', '.') ?></i></td>
                                        <td><strong>
                                                <?php
                                                if (!empty($row['mng_mkt'])) {
                                                    echo ' <strong>' . $row['mng_mkt'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Manager Kosong</font></em>';
                                                }
                                                ?>
                                            </strong></td>
                                        <td>
                                            <?php
                                            if (!empty($row['file_dp'])) {
                                                ?>
                                                <strong><a href = "/./upload/bukti_dp_pa/<?= $row['file_dp'] ?>"><img src="/./upload/bukti_dp_pa/<?= $row['file_dp'] ?>" style="width: 40px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em><font color="red">Tidak ada DP</font></em>
                                            <?php }
                                            ?>
                                            <br/><hr/>
                                            <?php
                                            if (!empty($row['file_tf'])) {
                                                ?>
                                                <strong><a href = "/./upload/bukti_tf/<?= $row['file_tf'] ?>"><img src="/./upload/bukti_tf/<?= $row['file_tf'] ?>" style="width: 40px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em><font color="red">Tidak ada bukti penyelesaian</font></em>
                                            <?php }
                                            ?>
                                        </td>
                                            <td>
                                                <?php
                                                if ($_SESSION['admin'] == 6) {
                                                    if (is_null($row['id_tf'])) {
                                                        ?>
                                                        <a class="btn small orange darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Upload Bukti DP" href="?page=pa&act=upload_dp&id_pa=<?= $row['id_pa'] ?>">
                                                            <i class="material-icons">file_upload</i></a>
                                                        <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Upload Bukti Pelunasan" href="?page=pa&act=upload_tf&id_pa=<?= $row['id_pa'] ?>">
                                                            <i class="material-icons">file_upload</i></a>
                                                        <a class="btn small orange darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Bukti DP" href="hapus_pa_dp.php?id_dp=<?= $row["id_dp"] ?>">
                                                            <i class="material-icons">delete</i></a>
                                                        <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PA" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                            <i class="material-icons">print</i></a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PA" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                            <i class="material-icons">print</i></a>
                                                        <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Bukti TF" href="hapus_pa_tf.php?id_tf=<?= $row["id_tf"] ?>">
                                                            <i class="material-icons">delete</i></a>
                                                        <?php
                                                    }
                                                }

                                                if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 4 | $_SESSION['admin'] == 7 || $_SESSION['admin'] == 8 | $_SESSION['admin'] == 11 | $_SESSION['admin'] == 12 | $_SESSION['admin'] == 13 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 15) {
                                                    if ($_SESSION['admin']) {
                                                        ?>
                                                        <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                            <i class="material-icons">print</i>PRINT</a>
                                                        <?php
                                                    }
                                                }

                                                if ($_SESSION['admin'] == 18) {
                                                    if (is_null($row['id_hasil'])) {
                                                        ?>
                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PA" href="?page=pa&act=edit&id_pa=<?= $row['id_pa'] ?>">
                                                            <i class="material-icons">edit</i></a>
                                                        <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Konfirmasi" id="konfirmasi" onclick="myFunction()" href="?page=ctk_pa_hasil&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                            <i class="material-icons">warning</i></a>
                                                        <script>
                                                            function myFunction() {
                                                            var x = document.getElementById("konfirmasi");
                                                            x.disabled = true;
                                                            }
                                                        </script>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Upload Bukti TF" href="?page=pa&act=upload_tf&id_pa=<?= $row['id_pa'] ?>">
                                                            <i class="material-icons">file_upload</i></a>
                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PA" href="?page=pa&act=edit&id_pa=<?= $row['id_pa'] ?>">
                                                            <i class="material-icons">edit</i></a>
                                                        <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PA" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                            <i class="material-icons">print</i></a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>
                                <?php
                            }
                            ?>
                            </tbody></table><br/><br/>
                    </div>
                </div>
                <!-- Row form END -->
                <?php
            } else {
                ?>
                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th>No</th>
                                <th width="11%">No.PA<br/><hr/>Tanggal Buat</th>
                        <th width="13%">Nama Perusahaan<br/><hr/>Status Surat</th>
                        <th width="11%">Penanggung Jawab<br/><hr/>No.Telp</th>
                        <th width="11%">Ruangan Sewa<br/><hr/>Judul</th>
                        <th width="11%">Jadwal Acara<br/><hr/>Jam</th>
                        <th width="11%">Harga Sewa</th>
                        <th width="7%">Approve Manager</th>
                        <th width="7%">Bukti DP<br/><hr/>Bukti Penyelesaian</th>
                        <th width="13%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                        <div id="modal" class="modal">
                            <div class="modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,permintaan_acara FROM tbl_sett");
                                list($id_sett, $permintaan_acara) = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="permintaan_acara" required>
                                                    <option value="<?= $permintaan_acara ?>"><?= $permintaan_acara ?></option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer white">
                                                <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>
                                                <?php
                                                if (isset($_REQUEST['simpan'])) {
                                                    $id_sett = "1";
                                                    $permintaan_acara = $_REQUEST['permintaan_acara'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET permintaan_acara='$permintaan_acara',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=pa");
                                                        die();
                                                    }
                                                }
                                                ?>
                                                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            //script untuk menampilkan data
                            $query = mysqli_query($config, "SELECT a.*, 
                                                                    b.mng_mkt,
                                                                    c.id_hasil,total_all,
                                                                    d.id_tf,
                                                                    e.file_tf,
                                                                    f.id_dp,file_dp
                                                                    FROM tbl_pa a
                                                                    LEFT JOIN tbl_approve_pa b
                                                                    ON a.id_pa=b.id_pa
                                                                    LEFT JOIN tbl_pa_hasil c
                                                                    ON a.id_pa=c.id_pa
                                                                    LEFT JOIN tbl_pa_tf d
                                                                    ON a.id_pa=d.id_pa
                                                                    LEFT JOIN tbl_pa_tf e
                                                                    ON a.id_pa=e.id_pa
                                                                    LEFT JOIN tbl_pa_dp f
                                                                    ON a.id_pa=f.id_pa
                                                                    ORDER by id_pa DESC LIMIT $curr, $limit");
                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_pa'] ?></strong><br/><hr/><?= indoDate($row['tgl_pa']) ?></td>
                                        <td><?= ucwords(strtolower($row['nama_perusahaan'])) ?><br/><hr><strong><i><?= $row['status'] ?></i></strong></td>
                                        <td><?= ucwords(strtolower($row['penanggung_jawab'])) ?><br/><hr><?= $row['no_telp'] ?></td>
                                        <td><?= $row['ruangan_sewa'] ?><br/><hr/><?= ucwords(strtolower($row['judul'])) ?></td>
                                        <td><strong><i><?= indoDate($row['tgl_acara']) ?></i></strong><br/><hr/><?= $row['jam'] ?></td>
                                        <td><i><?= $row['total_all'] = "Rp " . number_format((float) $row['total_all'], 0, ',', '.') ?></i></td>
                                        <td><strong>
                                                <?php
                                                if (!empty($row['mng_mkt'])) {
                                                    echo ' <strong>' . $row['mng_mkt'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Manager Kosong</font></em>';
                                                }
                                                ?>
                                            </strong></td>
                                        <td>
                                            <?php
                                            if (!empty($row['file_dp'])) {
                                                ?>
                                                <strong><a href = "/./upload/bukti_dp_pa/<?= $row['file_dp'] ?>"><img src="/./upload/bukti_dp_pa/<?= $row['file_dp'] ?>" style="width: 40px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em><font color="red">Tidak ada DP</font></em>
                                            <?php }
                                            ?>
                                            <br/><hr/>
                                            <?php
                                            if (!empty($row['file_tf'])) {
                                                ?>
                                                <strong><a href = "/./upload/bukti_tf/<?= $row['file_tf'] ?>"><img src="/./upload/bukti_tf/<?= $row['file_tf'] ?>" style="width: 40px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em><font color="red">Tidak ada bukti penyelesaian</font></em>
                                            <?php }
                                            ?>
                                        </td>
                                        <td>

                                            <?php
                                            if ($_SESSION['admin'] == 6) {
                                                if (is_null($row['id_tf'])) {
                                                    ?>
                                                     <div class="social-icons">
                                                    <a class="btn small orange darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Upload Bukti DP" href="?page=pa&act=upload_dp&id_pa=<?= $row['id_pa'] ?>">
                                                        <i class="md-5 material-icons">file_upload</i></a>
                                                    <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Upload Bukti Pelunasan" href="?page=pa&act=upload_tf&id_pa=<?= $row['id_pa'] ?>">
                                                        <i class="md-5 material-icons">file_upload</i></a>
                                                    <a class="btn small orange darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Bukti DP" href="hapus_pa_dp.php?id_dp=<?= $row["id_dp"] ?>">
                                                        <i class="md-5 material-icons">delete</i></a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PA" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                        <i class="md-5 material-icons">print</i></a>
                                                        </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PA" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                        <i class="material-icons">print</i></a>
                                                    <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Bukti TF" href="hapus_pa_tf.php?id_tf=<?= $row["id_tf"] ?>">
                                                        <i class="material-icons">delete</i></a>
                                                    <?php
                                                }
                                            }

                                            if ($_SESSION['admin'] == 7) {
                                                if ($_SESSION['admin'] == 7) {
                                                    ?>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a>
                                                    <?php
                                                }
                                            }

                                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 4 | $_SESSION['admin'] == 11 | $_SESSION['admin'] == 12 | $_SESSION['admin'] == 13 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a>
                                                    <?php
                                                }
                                            }

                                            if ($_SESSION['admin'] == 18) {
                                                if (is_null($row['id_hasil'])) {
                                                    ?>
                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PA" href="?page=pa&act=edit&id_pa=<?= $row['id_pa'] ?>">
                                                        <i class="material-icons">edit</i></a>
                                                    <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Konfirmasi" id="konfirmasi" onclick="myFunction()" href="?page=ctk_pa_hasil&id_pa=<?= $row['id_pa'] ?>">
                                                        <i class="material-icons">warning</i></a>
                                                    <script>
                                                        function myFunction() {
                                                        document.getElementById('konfirmasi').disabled = true;
                                                        }
                                                    </script>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PA" href="?page=pa&act=edit&id_pa=<?= $row['id_pa'] ?>">
                                                        <i class="material-icons">edit</i></a>
                                                    <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PA" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>"target="_blank">
                                                        <i class="material-icons">print</i></a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pa&act=add">Tambah data baru</a></u></p></center></td></tr>
                                <?php
                            }
                            ?></tbody></table>
                </div>
                </div>
                <!-- Row form END -->
                <?php
                $query = mysqli_query($config, "SELECT * FROM tbl_pa");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
<ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=pa&pg=1"><i class="material-icons md-48">first_page</i></a></li>
    <li><a href="?page=pa&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pa&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=pa&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=pa&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
    <li><a href="?page=pa&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
    <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                    }
                    echo '
</ul>';
                } else {
                    echo '';
                }
            }
        }
    }
}
?>
