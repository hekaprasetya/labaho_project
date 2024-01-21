<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 2 and $_SESSION['admin'] != 3 and $_SESSION['admin'] != 4 and $_SESSION['admin'] != 5 and $_SESSION['admin'] != 6 and $_SESSION['admin'] != 7 and $_SESSION['admin'] != 8 and $_SESSION['admin'] != 9 and $_SESSION['admin'] != 10 and $_SESSION['admin'] != 11 and $_SESSION['admin'] != 12 and $_SESSION['admin'] != 13 and $_SESSION['admin'] != 14 and $_SESSION['admin'] != 15 and $_SESSION['admin'] != 18) {
            echo '<script language="javascript">
                window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                window.location.href="./logout.php";
                </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_cuti.php";
                        break;
                    case 'edit':
                        include "edit_cuti.php";
                        break;
                    case 'app_hrd_cuti':
                        include "approve_cuti_hrd.php";
                        break;
                    case 'app_kabag_cuti':
                        include "approve_cuti_kabag.php";
                        break;
                    case 'print':
                        include "cetak_cuti.php";
                        break;
                    case 'report_cuti':
                        include "report_cuti.php";
                        break;
                    case 'bersama':
                        include "cuti_bersama.php";
                        break;
                    case 'reset':
                        include "reset_cuti.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT cuti FROM tbl_sett");
                list($cuti) = mysqli_fetch_array($query);

                //pagging
                $limit = $cuti;
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
                            <div class="nav-wrapper blue darken-2">
                                <div class="col m7">
                                    <ul class="left">
                                        <li>
                                            <a class="dropdown-button judul" href="#!" data-activates="cuti_dashboard"><i class="material-icons md-20">account_circle</i> Daftar Cuti<i class="material-icons md-18"> arrow_drop_down</i></a>
                                            <ul id="cuti_dashboard" class="dropdown-content">
                                                <li>
                                                    <a href="?page=cuti"><i class="material-icons md-18"> cloud_done</i> Cuti Pilihan</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="?page=cuti_normatif"><i class="material-icons md-18"> cloud_circle</i> Ijin Normatif</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="?page=cuti_bersama"><i class="material-icons md-18"> cloud_download</i> Cuti Bersama</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </nav>
                    </div>

                </div>

                <!-- Secondary Nav END -->
            </div>

            <div class="z-depth-1">
                <center>
                    <li class="waves-effect waves-light">
                        <a href="?page=cuti"><i class="material-icons md-24">speaker_group</i> HAL. CUTI PILIHAN |</a>
                    </li>
                    <li class="waves-effect waves-light">
                        <a href="?page=cuti&act=add" ><i class="material-icons md-24">add_circle</i> Tambah</a>
                    </li>
                </center>
                <nav class="secondary-nav yellow darken-3">
                    <form method="post" action="?page=cuti">
                        <center><div class="input-field round-in-box">
                                <input id="search" type="search" name="cari" placeholder="Searching" required>
                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                <input type="submit" name="submit" class="hidden">
                            </div>
                        </center>
                    </form>
                </nav>
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=cuti"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <th width="15%">No.Form<br />
                            <hr />Tanggal
                            </th>
                            <th width="20%">Nama<br />
                            <hr />Jabatan
                            </th>
                            <th width="15%">No.HP
                            <hr />Keperluan
                            </th>
                            <th width="5%">Sisa Cuti</th>
                            <th width="10%">Tgl.Cuti<br />
                            <hr />Akhir Cuti
                            </th>
                            <th width="10%">Jumlah Hari<br />
                            <hr />Di Setujui
                            </th>
                            <th width="20%">Disetujui.Kabag<br />
                            <hr />Disetujui.HRD
                            </th>
                            <th width="10%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                //script untuk mencari data
                                $query = mysqli_query($config, "SELECT a.*,
                                b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                d.nama,jabatan,no_hp,sisa_cuti
                                FROM tbl_cuti a
                                LEFT JOIN tbl_approve_cuti_kabag b
                                ON a.id_cuti=b.id_cuti
                                LEFT JOIN tbl_approve_cuti_hrd c 
                                ON a.id_cuti=c.id_cuti
                                LEFT JOIN tbl_user d
                                ON a.id_user=d.id_user
                                WHERE 
                                no_form LIKE '%$cari%' 
                                or tgl_cuti LIKE '%$cari%'
                                or nama LIKE '%$cari%'
                                or jabatan LIKE '%$cari%'
                                ORDER by id_cuti DESC ");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><i><?= $row['no_form'] ?><br />
                                                        <hr /><?= indoDate(date('Y-m-d')) ?></td>
                                                        <td><?= $row['nama'] ?><br />
                                                            <hr /><?= $row['jabatan'] ?>
                                                        </td>
                                                        <td><?= $row['no_hp'] ?>
                                                            <hr /><?= $row['alasan_cuti'] ?>
                                                        </td>
                                                        <td><?= $row['sisa_cuti'] ?></td>
                                                        <td><?= indoDate($row['tgl_cuti']) ?><br />
                                                            <hr /><?= indoDate($row['akhir_cuti']) ?>
                                                        </td>
                                                        <td><?= $row['jumlah_hari'] ?><br />
                                                            <hr /><?= $row['jumlah_trm'] ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (!empty($row['status_cuti_kabag'])) {
                                                                ?>
                                                                <strong><?= $row['status_cuti_kabag'] ?></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <font color="red"><i>Kabag Kosong</i></font>
                                                                <?php
                                                            }
                                                            ?><br>
                                                            <?= $row['waktu_cuti_kabag'] ?>
                                                            <br />
                                                            <hr />
                                                            <?php
                                                            if (!empty($row['status_cuti_hrd'])) {
                                                                ?>
                                                                <strong><?= $row['status_cuti_hrd'] ?></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <font color="red"><i>HRD Kosong</i></font>
                                                                <?php
                                                            }
                                                            ?>
                                                            , <br>
                                                            <?= $row['waktu_cuti_hrd'] ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            //**USER BIASA
                                                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                                if ($_SESSION['admin']) {
                                                                    ?>
                                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit CUTI" href="?page=cuti&act=edit&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">edit</i></a>
                                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print CUTI" href="?page=ctk_cuti&id_cuti=<?= $row['id_cuti'] ?>" target="_blank">
                                                                        <i class="material-icons">print</i></a>

                                                                    <?php
                                                                }
                                                            }

                                                            //**KABAG APPROVE
                                                            if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 10 | $_SESSION['admin'] == 13) {
                                                                if (is_null($row['id_app_cuti_kabag'])) {
                                                                    ?>
                                                                    <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=cuti&act=app_kabag_cuti&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">warning</i></a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=cuti&act=app_kabag_cuti&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">assignment_turned_in</i></a>
                                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit CUTI" href="?page=cuti&act=edit&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">edit</i></a>
                                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print CUTI" href="?page=ctk_cuti&id_cuti=<?= $row['id_cuti'] ?>" target="_blank">
                                                                        <i class="material-icons">print</i></a>
                                                                    <?php
                                                                }
                                                            }

                                                            //**HRD APPROVE
                                                            if ($_SESSION['admin'] == 15) {
                                                                if (is_null($row['id_app_cuti_hrd'])) {
                                                                    ?>
                                                                    <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=cuti&act=app_hrd_cuti&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">warning</i></a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=cuti&act=app_hrd_cuti&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">assignment_turned_in</i></a>
                                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit CUTI" href="?page=cuti&act=edit&id_cuti=<?= $row['id_cuti'] ?>">
                                                                        <i class="material-icons">edit</i></a>
                                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print CUTI" href="?page=ctk_cuti&id_cuti=<?= $row['id_cuti'] ?>" target="_blank">
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
                                                    <tr>
                                                        <td colspan="5">
                                                    <center>
                                                        <p class="add">Tidak ada data yang ditemukan</p>
                                                    </center>
                                                    </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                                </table><br /><br />
                                                </div>
                                                </div>
                                                <!-- Row form END -->
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col m12" id="colres">
                                                    <table class="bordered striped" id="tbl">
                                                        <thead class="blue lighten-4" id="head">
                                                            <tr>
                                                                <th>No</th>
                                                                <th width="15%">No.Form<br />
                                                        <hr />Tanggal
                                                        </th>
                                                        <th width="20%">Nama<br />
                                                        <hr />Jabatan
                                                        </th>
                                                        <th width="15%">No.HP
                                                        <hr />Keperluan
                                                        </th>
                                                        <th width="5%">Sisa Cuti</th>
                                                        <th width="10%">Tgl.Cuti<br />
                                                        <hr />Akhir Cuti
                                                        </th>
                                                        <th width="10%">Jumlah Hari<br />
                                                        <hr />Di Setujui
                                                        </th>
                                                        <th width="20%">Disetujui.Kabag<br />
                                                        <hr />Disetujui.HRD
                                                        </th>
                                                        <th width="10%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                                        <div id="modal" class="modal">
                                                            <div class="modal-content white">
                                                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                                                <?php
                                                                $query = mysqli_query($config, "SELECT id_sett,cuti FROM tbl_sett");
                                                                list($id_sett, $cuti) = mysqli_fetch_array($query);
                                                                ?>
                                                                <div class="row">
                                                                    <form method="post" action="">
                                                                        <div class="input-field col s12">
                                                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                                            <div class="input-field col s1" style="float: left;">
                                                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                                                            </div>
                                                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                                <select class="browser-default validate" name="cuti" required>
                                                                                    <option value="<?= $cuti ?>"><?= $cuti ?></option>
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
                                                                                    $cuti = $_REQUEST['cuti'];
                                                                                    $id_user = $_SESSION['id_user'];

                                                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET cuti='$cuti',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                                    if ($query == true) {
                                                                                        header("Location: ./admin.php?page=cuti");
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
                                                                                            b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                                                                            c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                                                                            d.nama,jabatan,no_hp,divisi,sisa_cuti

                                                                                            FROM tbl_cuti a
                                                                                            LEFT JOIN tbl_approve_cuti_kabag b
                                                                                            ON a.id_cuti=b.id_cuti
                                                                                            LEFT JOIN tbl_approve_cuti_hrd c 
                                                                                            ON a.id_cuti=c.id_cuti
                                                                                            LEFT JOIN tbl_user d
                                                                                            ON a.id_user=d.id_user

                                                    ORDER by id_cuti DESC LIMIT $curr, $limit");
                                                            if (mysqli_num_rows($query) > 0) {
                                                                $no = 0;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                    $no++;
                                                                    ?>

                                                                    <?php
                                                                    //**USER BIASA
                                                                    if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                                        if ($_SESSION['admin']) {
                                                                            ?>
                                                                            <?php
                                                                            //script untuk menampilkan data
                                                                            $nama = $_SESSION['nama'];
                                                                            $query = mysqli_query($config, "SELECT a.*,
                                                                            b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                                                            c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                                                            d.nama,jabatan,no_hp,divisi,sisa_cuti

                                                                            FROM tbl_cuti a
                                                                            LEFT JOIN tbl_approve_cuti_kabag b
                                                                            ON a.id_cuti=b.id_cuti
                                                                            LEFT JOIN tbl_approve_cuti_hrd c 
                                                                            ON a.id_cuti=c.id_cuti
                                                                            LEFT JOIN tbl_user d
                                                                            ON a.id_user=d.id_user

                                                                            WHERE nama = '$nama'
                                                                            ORDER by id_cuti DESC LIMIT $curr, $limit");
                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                $no = 0;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                    $no++;
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?= $no ?></td>
                                                                                        <td><strong><i><?= $row['no_form'] ?><br />
                                                                                                    <hr /><?= indoDate($row['tgl']) ?></td>
                                                                                                    <td><?= $row['nama'] ?><br />
                                                                                                        <hr /><?= $row['jabatan'] ?>,<?= $row['divisi'] ?>
                                                                                                    </td>
                                                                                                    <td><?= $row['no_hp'] ?><br />
                                                                                                        <hr /><?= $row['alasan_cuti'] ?>
                                                                                                    </td>
                                                                                                    <td><?= $row['sisa_cuti'] ?></td>
                                                                                                    <td><?= indoDate($row['tgl_cuti']) ?><br />
                                                                                                        <hr /><?= indoDate($row['akhir_cuti']) ?>
                                                                                                    </td>
                                                                                                    <td><?= $row['jumlah_hari'] ?> Hari<br />
                                                                                                        <hr /><?= $row['jumlah_trm'] ?> Hari
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php
                                                                                                        if (!empty($row['status_cuti_kabag'])) {
                                                                                                            ?>
                                                                                                            <strong><?= $row['status_cuti_kabag'] ?></a></strong>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                            <font color="red"><i>Kabag Kosong</i></font>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                        , <br>
                                                                                                        <?= $row['waktu_cuti_kabag'] ?>
                                                                                                        <br />
                                                                                                        <hr />
                                                                                                        <?php
                                                                                                        if (!empty($row['status_cuti_hrd'])) {
                                                                                                            ?>
                                                                                                            <strong><?= $row['status_cuti_hrd'] ?></a></strong>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                            <font color="red"><i>HRD Kosong</i></font>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>, <br>
                                                                                                        <?= $row['waktu_cuti_hrd'] ?>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit CUTI" href="?page=cuti&act=edit&id_cuti=<?= $row['id_cuti'] ?>">
                                                                                                            <i class="material-icons">edit</i></a>
                                                                                                        <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print CUTI" href="?page=ctk_cuti&id_cuti=<?= $row['id_cuti'] ?>" target="_blank">
                                                                                                            <i class="material-icons">print</i></a>
                                                                                                    </td>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }

                                                                                    //**KABAG APPROVE
                                                                                    if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 10 | $_SESSION['admin'] == 13) {
                                                                                        if ($_SESSION['admin']) {
                                                                                            ?>
                                                                                            <?php
                                                                                            //script untuk menampilkan data
                                                                                            $divisi = $_SESSION['divisi'];
                                                                                            $query = mysqli_query($config, "SELECT a.*,
                                                                                            b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                                                                            c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                                                                            d.nama,jabatan,no_hp,divisi,sisa_cuti

                                                                                            FROM tbl_cuti a
                                                                                            LEFT JOIN tbl_approve_cuti_kabag b
                                                                                            ON a.id_cuti=b.id_cuti
                                                                                            LEFT JOIN tbl_approve_cuti_hrd c 
                                                                                            ON a.id_cuti=c.id_cuti
                                                                                            LEFT JOIN tbl_user d
                                                                                            ON a.id_user=d.id_user

                                                                                            WHERE divisi = '$divisi'
                                                                                            ORDER by id_cuti DESC LIMIT $curr, $limit");
                                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                                $no = 0;
                                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                                    $no++;
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?= $no ?></td>
                                                                                                        <td><strong><i><?= $row['no_form'] ?><br />
                                                                                                                    <hr /><?= indoDate($row['tgl']) ?></td>
                                                                                                                    <td><?= $row['nama'] ?><br />
                                                                                                                        <hr /><?= $row['jabatan'] ?>,<?= $row['divisi'] ?>
                                                                                                                    </td>
                                                                                                                    <td><?= $row['no_hp'] ?><br />
                                                                                                                        <hr /><?= $row['alasan_cuti'] ?>
                                                                                                                    </td>
                                                                                                                    <td><?= $row['sisa_cuti'] ?></td>
                                                                                                                    <td><?= indoDate($row['tgl_cuti']) ?><br />
                                                                                                                        <hr /><?= indoDate($row['akhir_cuti']) ?>
                                                                                                                    </td>
                                                                                                                    <td><?= $row['jumlah_hari'] ?> Hari<br />
                                                                                                                        <hr /><?= $row['jumlah_trm'] ?> Hari
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <?php
                                                                                                                        if (!empty($row['status_cuti_kabag'])) {
                                                                                                                            ?>
                                                                                                                            <strong><?= $row['status_cuti_kabag'] ?></a></strong>
                                                                                                                            <?php
                                                                                                                        } else {
                                                                                                                            ?>
                                                                                                                            <font color="red"><i>Kabag Kosong</i></font>
                                                                                                                            <?php
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                        , <br>
                                                                                                                        <?= $row['waktu_cuti_kabag'] ?>
                                                                                                                        <br />
                                                                                                                        <hr />
                                                                                                                        <?php
                                                                                                                        if (!empty($row['status_cuti_hrd'])) {
                                                                                                                            ?>
                                                                                                                            <strong><?= $row['status_cuti_hrd'] ?></a></strong>
                                                                                                                            <?php
                                                                                                                        } else {
                                                                                                                            ?>
                                                                                                                            <font color="red"><i>HRD Kosong</i></font>
                                                                                                                            <?php
                                                                                                                        }
                                                                                                                        ?>, <br>
                                                                                                                        <?= $row['waktu_cuti_hrd'] ?>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=cuti&act=app_kabag_cuti&id_cuti=<?= $row['id_cuti'] ?>">
                                                                                                                            <i class="material-icons">assignment_turned_in</i></a>
                                                                                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit CUTI" href="?page=cuti&act=edit&id_cuti=<?= $row['id_cuti'] ?>">
                                                                                                                            <i class="material-icons">edit</i></a>
                                                                                                                        <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print CUTI" href="?page=ctk_cuti&id_cuti=<?= $row['id_cuti'] ?>" target="_blank">
                                                                                                                            <i class="material-icons">print</i></a>
                                                                                                                    </td>
                                                                                                                    <?php
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }



                                                                                                    //**HRD APPROVE
                                                                                                    if ($_SESSION['admin'] == 15) {
                                                                                                        if ($_SESSION['admin']) {
                                                                                                            ?>
                                                                                                            <?php
                                                                                                            //script untuk menampilkan data
                                                                                                            $query = mysqli_query($config, "SELECT a.*,
                                                                                                                                                    b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                                                                                                                                    c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                                                                                                                                    d.nama,jabatan,no_hp,divisi,sisa_cuti

                                                                                                                                                    FROM tbl_cuti a
                                                                                                                                                    LEFT JOIN tbl_approve_cuti_kabag b
                                                                                                                                                    ON a.id_cuti=b.id_cuti
                                                                                                                                                    LEFT JOIN tbl_approve_cuti_hrd c 
                                                                                                                                                    ON a.id_cuti=c.id_cuti
                                                                                                                                                    LEFT JOIN tbl_user d
                                                                                                                                                    ON a.id_user=d.id_user

                                                                                                                                                    ORDER by id_cuti DESC LIMIT $curr, $limit");
                                                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                                                $no = 0;
                                                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                                                    $no++;
                                                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td><?= $no ?></td>
                                                                                                                        <td><strong><i><?= $row['no_form'] ?><br />
                                                                                                                                    <hr /><?= indoDate($row['tgl']) ?></td>
                                                                                                                                    <td><?= $row['nama'] ?><br />
                                                                                                                                        <hr /><?= $row['jabatan'] ?>,<?= $row['divisi'] ?>
                                                                                                                                    </td>
                                                                                                                                    <td><?= $row['no_hp'] ?><br />
                                                                                                                                        <hr /><?= $row['alasan_cuti'] ?>
                                                                                                                                    </td>
                                                                                                                                    <td><?= $row['sisa_cuti'] ?></td>
                                                                                                                                    <td><?= indoDate($row['tgl_cuti']) ?><br />
                                                                                                                                        <hr /><?= indoDate($row['akhir_cuti']) ?>
                                                                                                                                    </td>
                                                                                                                                    <td><?= $row['jumlah_hari'] ?> Hari<br />
                                                                                                                                        <hr /><?= $row['jumlah_trm'] ?> Hari
                                                                                                                                    </td>
                                                                                                                                    <td>
                                                                                                                                        <?php
                                                                                                                                        if (!empty($row['status_cuti_kabag'])) {
                                                                                                                                            ?>
                                                                                                                                            <strong><?= $row['status_cuti_kabag'] ?></a></strong>
                                                                                                                                            <?php
                                                                                                                                        } else {
                                                                                                                                            ?>
                                                                                                                                            <font color="red"><i>Kabag Kosong</i></font>
                                                                                                                                            <?php
                                                                                                                                        }
                                                                                                                                        ?>
                                                                                                                                        , <br>
                                                                                                                                        <?= $row['waktu_cuti_kabag'] ?>
                                                                                                                                        <br />
                                                                                                                                        <hr />
                                                                                                                                        <?php
                                                                                                                                        if (!empty($row['status_cuti_hrd'])) {
                                                                                                                                            ?>
                                                                                                                                            <strong><?= $row['status_cuti_hrd'] ?></a></strong>
                                                                                                                                            <?php
                                                                                                                                        } else {
                                                                                                                                            ?>
                                                                                                                                            <font color="red"><i>HRD Kosong</i></font>
                                                                                                                                            <?php
                                                                                                                                        }
                                                                                                                                        ?>, <br>
                                                                                                                                        <?= $row['waktu_cuti_hrd'] ?>
                                                                                                                                    </td>
                                                                                                                                    <td>
                                                                                                                                        <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=cuti&act=app_hrd_cuti&id_cuti=<?= $row['id_cuti'] ?>">
                                                                                                                                            <i class="material-icons">assignment_turned_in</i></a>
                                                                                                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit CUTI" href="?page=cuti&act=edit&id_cuti=<?= $row['id_cuti'] ?>">
                                                                                                                                            <i class="material-icons">edit</i></a>
                                                                                                                                        <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print CUTI" href="?page=ctk_cuti&id_cuti=<?= $row['id_cuti'] ?>" target="_blank">
                                                                                                                                            <i class="material-icons">print</i></a>
                                                                                                                                    </td>
                                                                                                                                    <?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    </td>
                                                                                                                    </tr>
                                                                                                                    <?php
                                                                                                                }
                                                                                                            } else {
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td colspan="5">
                                                                                                                <center>
                                                                                                                    <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=cuti&act=add">Tambah data</a></u></p>
                                                                                                                </center>
                                                                                                                </td>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                            </tbody>
                                                                                                            </table>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            <!-- Row form END -->
                                                                                                            <?php
                                                                                                            $query = mysqli_query($config, "SELECT * FROM tbl_cuti");
                                                                                                            $cdata = mysqli_num_rows($query);
                                                                                                            $cpg = ceil($cdata / $limit);

                                                                                                            echo '<br/><!-- Pagination START -->
                                                                                                                <ul class="pagination">';

                                                                                                            if ($cdata > $limit) {

                                                                                                                //first and previous pagging
                                                                                                                if ($pg > 1) {
                                                                                                                    $prev = $pg - 1;
                                                                                                                    echo '<li><a href="?page=cuti&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                                                                                                     <li><a href="?page=cuti&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                                                                                                                } else {
                                                                                                                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                                                                                                         <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                                                                                                                }

                                                                                                                //perulangan pagging
                                                                                                                for ($i = 1; $i <= $cpg; $i++) {
                                                                                                                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                                                                                                        if ($i == $pg)
                                                                                                                            echo '<li class="active waves-effect waves-dark"><a href="?page=cuti&pg=' . $i . '"> ' . $i . ' </a></li>';
                                                                                                                        else
                                                                                                                            echo '<li class="waves-effect waves-dark"><a href="?page=cuti&pg=' . $i . '"> ' . $i . ' </a></li>';
                                                                                                                    }
                                                                                                                }

                                                                                                                //last and next pagging
                                                                                                                if ($pg < $cpg) {
                                                                                                                    $next = $pg + 1;
                                                                                                                     echo '<li><a href="?page=cuti&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                                                                                                <li><a href="?page=cuti&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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