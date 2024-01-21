<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Interior Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
      Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript">
    addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
    window.scrollTo(0, 1);
    }
</script>

<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 3 and $_SESSION['admin'] != 2 and $_SESSION['admin'] != 4 and $_SESSION['admin'] != 5 and $_SESSION['admin'] != 6 and $_SESSION['admin'] != 7 and $_SESSION['admin'] != 8 and $_SESSION['admin'] != 11 and $_SESSION['admin'] != 12 and $_SESSION['admin'] != 13 and $_SESSION['admin'] != 14 and $_SESSION['admin'] != 15 and $_SESSION['admin'] != 17) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
    } else {
        $actArray = [
            'add' => 'tambah_surat_masuk.php',
            'edit' => 'edit_surat_masuk.php',
            'disp' => 'disposisi.php',
            'app_gm' => 'approve_pmk_gm.php',
            'lpt' => 'lpt.php',
           // 'edit' => 'edit_lpt.php',
            'print' => 'cetak_disposisi.php',
            'del' => 'hapus_surat_masuk.php'
        ];
        if (isset($_REQUEST['act'])) {
            $act = $_REQUEST['act'];
            if (array_key_exists($act, $actArray)) {
                $halaman = $actArray[$act];
                (file_exists($halaman)) ? include $halaman : print("File tidak ditemukan: $halaman");
            } else {
                echo "Halaman tidak ditemukan!";
            }
        } else {

            $query = mysqli_query($config, "SELECT surat_masuk FROM tbl_sett");
            list($surat_masuk) = mysqli_fetch_array($query);

            //pagging
            $limit = $surat_masuk;
            $pg = @$_GET['pg'];
            if (empty($pg)) {
                $curr = 0;
                $pg = 1;
            } else {
                $curr = ($pg - 1) * $limit;
            }

            // untuk function
            $surat = new CRUD();
            // id pada tabel berisi id_"$id_name" 
            $surat->id_name = 'surat';
            // nama tabel utama halaman
            $surat->tbl_name = 'tbl_surat_masuk';
            // page halaman pemangilan di admin
            $surat->pg_name = 'tsm';
            // judul pada secon nav
            $surat->judul = "P M K";
            // icon untuk judul
            $surat->icon_judul = "mail";
            // SECONDARY NAV START
            $surat->judul_s();
            // SECONDARY NAV END

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
                $query_surat = "SELECT a.*,
                                        b.manager_mkt,
                                        c.id_lpt,
                                        d.id_approve_gm,gm,
                                        e.id_lpg
                                        FROM $surat->tbl_name a
                                         LEFT JOIN tbl_disposisi b 
                                        ON a.id_surat=b.id_surat 
                                         LEFT JOIN tbl_lpt c 
                                        ON a.id_surat=c.id_surat
                                         LEFT JOIN tbl_approve_gm d
                                        ON a.id_surat=d.id_surat
                                         LEFT JOIN tbl_lpg e
                                        ON a.id_surat=e.id_surat";
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=tsm"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <th>No.PMK<br />
                            <hr />Status
                            </th>
                            <th>Jenis Pekerjaan<br />
                            <hr />File
                            </th>
                            <th>Lokasi<br />
                            <hr />Nama Perusahaan
                            </th>
                            <th>Ditujukan Kepada<br />
                            <hr />Tgl.Surat
                            </th>
                            <th>Disetujui.Mng<br />
                            <hr />Diketahui.GM
                            </th>
                            <th>Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                            </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                //script untuk mencari data
                                $query_surat .= " WHERE no_agenda LIKE '%$cari%'or
                                                        isi LIKE '%$cari%'or 
                                                        divisi LIKE '%$cari%' or 
                                                        indeks LIKE '%$cari%' or
                                                        tgl_surat LIKE '%$cari%'
                                                        ORDER by id_surat DESC";
                                $query = mysqli_query($config, $query_surat);
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $id = $row['id_surat'];
                                        $surat->id = $row['id_surat'];
                                        $id_lpt = $row['id_lpt'];
                                        $id_lpg = $row['id_lpg'];
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $row['no_agenda'] ?><br />
                                                <hr /><?= $row['status'] ?>
                                            </td>
                                            <td><?= ucwords(nl2br(htmlentities(strtolower($row['isi'])))) ?><br /><br /><strong>File :</strong>
                                                <?php
                                                if (!empty($row['file'])) {
                                                    ?> <strong><a href="?page=gsm&act=fsm&id_surat=<?= $id ?>"><?= $row['file'] ?></a></strong>
                                                <?php } else {
                                                    ?><em>Tidak ada file yang di upload</em><?php }
                                                ?></td>
                                            <td><?= ucwords(strtolower($row['asal_surat'])) ?><br />
                                                <hr><?= ucwords(strtolower($row['indeks'])) ?>
                                            </td>
                                            <td><?= $row['divisi'] ?><br />
                                                <hr /><?= indoDate($row['tgl_surat']) ?>
                                            </td>
                                            <td><?php
                                                if (!empty($row['manager_mkt'])) {
                                                    ?> <strong><?= $row['manager_mkt'] ?></a></strong><?php
                                                } else {
                                                    ?><font color="red"><i>Manager Kosong</i></font><?php
                                                }
                                                ?>

                                                <br />
                                                <hr /><?php
                                                if (!empty($row['gm'])) {
                                                    ?> <strong><?= $row['gm'] ?></a></strong><?php
                                                } else {
                                                    ?><font color="red"><i>GM Kosong</i></font><?php
                                                }
                                                ?>
                                            </td>

                                              <td>
                                            <?php
                                            //admin teknik
                                            if ($_SESSION['admin'] == 2) {
                                                if (is_null($row['id_lpt'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=tlpt&id_surat=<?= $id ?>">
                                                        <i class="material-icons">assignment_late</i>E-LPT</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                } else {
                                                    ?><a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                                    <a class="btn small blue waves-effect waves-light tooltiped" data-position="left" data-tooltip="Pilih untuk Edit" href="?page=lpt&act=edit&id_lpt=<?= $id_lpt ?>">
                                                        <i class="material-icons">edit</i>EDIT</a><?php
                                                }
                                            }

                                           //kabag teknik
                                            if ($_SESSION['admin'] == 4) {
                                                if (is_null($row['id_lpt'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="E-LPT Kosong" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i></a><?php
                                                } else {
                                                    ?><!--a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approval E-LPT" href="?page=app_lpt_v&id_lpt=<?= $id_lpt ?>">
                                                        <i class="material-icons">assignment_ind</i>Approval</a-->
                                                    <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i></a><?php
                                                }
                                            }
                                            //tenant relation
                                            if ($_SESSION['admin'] == 3) {
                                                if (is_null($row['id_lpt'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Kosong" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_late</i>E-LPT</a></a>
                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=<?= $id ?>">
                                                        <i class="material-icons">edit</i>EDIT</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                } else {
                                                    ?><a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Done" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                                    <a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Verifikasi LPT" href="?page=lpt&act=verifikasi&id_lpt=<?= $id_lpt ?>">
                                                        <i class="material-icons">assignment</i>Verifikasi</a>
                                                    <a class="btn small blue darken-2  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=<?= $id ?>">
                                                        <i class="material-icons">edit</i>EDIT</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                }
                                            }
                                            //facility dan security
                                            if ($_SESSION['admin'] == 5 | $_SESSION['admin'] == 11 | $_SESSION['admin'] == 17) {
                                                if ($_SESSION['admin']) {
                                                    ?><a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i> PRINT</a><?php
                                                }
                                            }
                                            //gudang
                                            if ($_SESSION['admin'] == 12) {
                                                if (is_null($row['id_lpg'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Buat LPG" href="?page=tlpg&id_surat=<?= $id ?>">
                                                        <i class="material-icons">description</i>Buat LPG</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpg&id_lpg=<?= $id_lpg ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                } else {
                                                    ?><a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat Ceklist" href="?page=ctk_lpg&id_lpg=<?= $id_lpg ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i>Print LPG</a>
                                                    <?php
                                                }
                                            }
                                            //lain2
                                            if ($_SESSION['admin'] == 13 || $_SESSION['admin'] == 14 || $_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                    }
                                                }
                                                ?>
                                        </td>
                                        </tr><?php
                                    }
                                } else {
                                    $surat->nodata();
                                }
                                ?>
                            </tbody>
                        </table><br /><br />
                    </div>
                </div>
                <!-- Row form END --><?php
            } else {
                ?>
                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">

                            <tr>
                                <th>No</th>
                                <th>No.PMK<br />
                        <hr />Status PMK
                        </th>
                        <th>Jenis Pekerjaan<br />
                        <hr /> File
                        </th>
                        <th>Lokasi<br />
                        <hr />Nama Perusahaan
                        </th>
                        <th>Ditujukan Kepada<br />
                        <hr />Tanggal Surat
                        </th>
                        <th>Disetujui.Mng<br />
                        <hr />Diketahui.GM
                        </th>
                        <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                        <?= $surat->hal($config, $surat->tbl_name = 'surat_masuk'); ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            //script untuk menampilkan data
                            //   mysqli_query("SELECT divisi FROM tbl_surat_masuk WHERE  id_surat");
                            $divisi = $_SESSION['divisi'];
                            if ($_SESSION['admin'] == 3) {
                                $query_surat .= " ORDER BY id_surat DESC LIMIT $curr, $limit";
                            } else {
                                $divisi = $_SESSION['divisi'];
                                $query_surat .= " WHERE divisi = '$divisi' ORDER BY id_surat DESC LIMIT $curr, $limit";
                            }

                            // $divisi = $_SESSION['divisi'];
                            // $query_surat .= " WHERE divisi = '$divisi'
                            //               ORDER by id_surat DESC LIMIT $curr, $limit";

                            $query = mysqli_query($config, $query_surat);
                            if (mysqli_num_rows($query) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $id = $row['id_surat'];
                                    $surat->id = $row['id_surat'];
                                    $id_lpt = $row['id_lpt'];
                                    $id_lpg = $row['id_lpg'];
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row['no_agenda'] ?><br />
                                            <hr/><?= $row['status'] ?>
                                        </td>
                                        <td><?= ucwords(nl2br(htmlentities(strtolower($row['isi'])))) ?><br /><br /><strong>File :</strong>
                                            <?php
                                            if (!empty($row['file'])) {
                                                ?> <strong><a href="?page=gsm&act=fsm&id_surat=<?= $id ?>"><?= $row['file'] ?></a></strong>
                                            <?php } else {
                                                ?><em>Tidak ada file yang di upload</em><?php }
                                            ?></td>
                                        <td><?= ucwords(strtolower($row['asal_surat'])) ?><br />
                                            <hr><?= ucwords(strtolower($row['indeks'])) ?>
                                        </td>
                                        <td><?= $row['divisi'] ?><br />
                                            <hr /><?= indoDate($row['tgl_surat']) ?>
                                        </td>
                                        <td><?php
                                            if (!empty($row['manager_mkt'])) {
                                                ?> <strong><?= $row['manager_mkt'] ?></a></strong><?php
                                            } else {
                                                ?><font color="red"><i>Manager Kosong</i></font><?php
                                            }
                                            ?><br />
                                            <hr /><?php
                                            if (!empty($row['gm'])) {
                                                ?> <strong><?= $row['gm'] ?></a></strong><?php
                                            } else {
                                                ?><font color="red"><i>GM Kosong</i></font><?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            //admin teknik
                                            if ($_SESSION['admin'] == 2) {
                                                if (is_null($row['id_lpt'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=tlpt&id_surat=<?= $id ?>">
                                                        <i class="material-icons">assignment_late</i>E-LPT</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                } else {
                                                    ?><a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                                    <a class="btn small blue waves-effect waves-light tooltiped" data-position="left" data-tooltip="Pilih untuk Edit" href="?page=lpt&act=edit&id_lpt=<?= $id_lpt ?>">
                                                        <i class="material-icons">edit</i>EDIT</a><?php
                                                }
                                            }

                                            //kabag teknik
                                            if ($_SESSION['admin'] == 4) {
                                                if (is_null($row['id_lpt'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="E-LPT Kosong" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i></a><?php
                                                } else {
                                                    ?><!--a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approval E-LPT" href="?page=app_lpt_v&id_lpt=<?= $id_lpt ?>">
                                                        <i class="material-icons">assignment_ind</i>Approval</a-->
                                                    <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i></a><?php
                                                }
                                            }
                                            //tenant relation
                                            if ($_SESSION['admin'] == 3) {
                                                if (is_null($row['id_lpt'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Kosong" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_late</i>E-LPT</a></a>
                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=<?= $id ?>">
                                                        <i class="material-icons">edit</i>EDIT</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                } else {
                                                    ?><a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Done" href="?page=ctk_lpt&id_lpt=<?= $id_lpt ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                                    <a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Verifikasi LPT" href="?page=lpt&act=verifikasi&id_lpt=<?= $id_lpt ?>">
                                                        <i class="material-icons">assignment</i>Verifikasi</a>
                                                    <a class="btn small blue darken-2  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=<?= $id ?>">
                                                        <i class="material-icons">edit</i>EDIT</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                }
                                            }
                                            //facility dan security
                                            if ($_SESSION['admin'] == 5 | $_SESSION['admin'] == 11 | $_SESSION['admin'] == 17) {
                                                if ($_SESSION['admin']) {
                                                    ?><a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i> PRINT</a><?php
                                                }
                                            }
                                            //gudang
                                            if ($_SESSION['admin'] == 12) {
                                                if (is_null($row['id_lpg'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Buat LPG" href="?page=tlpg&id_surat=<?= $id ?>">
                                                        <i class="material-icons">description</i>Buat LPG</a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpg&id_lpg=<?= $id_lpg ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                } else {
                                                    ?><a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat Ceklist" href="?page=ctk_lpg&id_lpg=<?= $id_lpg ?>" target="_blank">
                                                        <i class="material-icons">assignment_turned_in</i>Print LPG</a>
                                                    <?php
                                                }
                                            }
                                            //lain2
                                            if ($_SESSION['admin'] == 13 || $_SESSION['admin'] == 14 || $_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $id ?>" target="_blank">
                                                        <i class="material-icons">print</i>PRINT</a><?php
                                                    }
                                                }
                                                ?>
                                        </td>
                                    </tr><?php
                                }
                            } else {
                                $surat->nodata();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <!-- Row form END -->
                <!-- Pagination START -->
                <?= $surat->pagging($config, $limit, $pg, $surat->tbl_name = 'tbl_surat_masuk') ?>
                </div>
                <?php
            }
        }
    }
}
