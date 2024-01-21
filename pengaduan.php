<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Interior Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
          Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    <script>
        function myFunction() {
        var x = document.getElementById("Btn");
        x.disabled = true;
        }
    </script>
    
    <script>
        function myFunction() {
        var x = document.getElementById("Btn");
        x.disabled = true;
        }
    </script>

    <?php
//cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
        if (isset($_REQUEST['submita'])) {
            // print_r($_POST);die;
            $id_pengaduan = $_REQUEST['id_pengaduan'];
            $query = mysqli_query($config, "SELECT * FROM tbl_approve_pengaduan WHERE id_pengaduan='$id_pengaduan'");
            $no = 1;
            list($id_pengaduan) = mysqli_fetch_array($query); {

                $id_pengaduan = $_REQUEST['id_pengaduan'];
                $status_pengaduan = $_POST['status_pengaduan'];
                $catatan = $_POST['catatan'];
                $id_user = $_SESSION['id_user'];
                $cek_data_qry = mysqli_query($config, "select * FROM tbl_approve_pengaduan where id_pengaduan='$id_pengaduan'");
                $cek_data = mysqli_num_rows($cek_data_qry);
                $cek_data_row = mysqli_fetch_array($cek_data_qry);
                if ($cek_data == 0) {
                    $query = mysqli_query($config, "INSERT INTO tbl_approve_pengaduan(status_pengaduan,catatan,id_pengaduan,id_user)
                                        VALUES('$status_pengaduan','$catatan','$id_pengaduan','$id_user')");
                } else {
                    $query = mysqli_query($config, "UPDATE tbl_approve_pengaduan SET
                status_pengaduan='$status_pengaduan',
                catatan='$catatan',
                id_pengaduan='$id_pengaduan',
                id_user='$id_user' 
                WHERE id_approve_pengaduan=$cek_data_row[id_approve_pengaduan]");
                }

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    echo '<script language="javascript">
                                                window.location.href="./admin.php?page=pengaduan";
                                              </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        } else {

            if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 9 AND $_SESSION['admin'] != 10 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 19) {
                echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
            } else {

                if (isset($_REQUEST['act'])) {
                    $act = $_REQUEST['act'];
                    switch ($act) {
                        case 'add':
                            include "tambah_pengaduan.php";
                            break;
                        case 'edit':
                            include "edit_pengaduan.php";
                            break;
                        case 'del':
                            include "hapus_pengaduan.php";
                            break;
                        case 'ctk_pengaduan':
                            include "cetak_pengaduan.php";
                            break;
                        case 'report_pengaduan':
                            include "report_pengaduan.php";
                            break;
                    }
                } else {

                    $query = mysqli_query($config, "SELECT pengaduan FROM tbl_sett");
                    list($pengaduan) = mysqli_fetch_array($query);

                    //pagging
                    $limit = $pengaduan;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="" class="judul"><i class="material-icons md-3">record_voice_over</i> Pengaduan</a></li>
                                            <!--li class="waves-effect waves-light">
                                                <a href="?page=pengaduan&act=add"><i class="material-icons md-3">add_circle</i>Tambah</a>
                                            </li-->
                                        </ul>
                                    </div>
                                    <div class="col s5 show-on-med-and-down">
                                        <form method="post" action="?page=pengaduan">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" placeholder="Search" required>
                                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                                <input type="submit" name="submit" class="hidden">
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
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=pengaduan"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="3%">No</th>
                                        <th width="15%">No.Pengaduan<br/><hr/>Pengaduan</th>
                                <th width="15%">File</th>
                                <th width="10%">Nama PIC<br/><hr/>Nama Perusahaan</th>
                                <th width="10%">Status</th>
                                <th width="10%">Work Order</th>
                                <th width="15%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //script untuk mencari data
                                    $query = mysqli_query($config, "SELECT a.*,
                                                                    b.nama,nama_tenant,
                                                                    c.id_approve_pengaduan,status_pengaduan,waktu_ttd_pengaduan,catatan,tgl_pengaduan,
                                                                    d.id_wo,no_wo,
                                                                    e.status_kepuasan
                                                                    
                                                                    FROM tbl_pengaduan a
                                                                    LEFT JOIN tbl_user b
                                                                    ON a.id_user=b.id_user
                                                                    LEFT JOIN tbl_approve_pengaduan c
                                                                    ON a.id_pengaduan=c.id_pengaduan
                                                                    LEFT JOIN tbl_wo d
                                                                    ON a.id_pengaduan=d.id_pengaduan
                                                                    LEFT JOIN tbl_kepuasan e
                                                                    ON a.id_pengaduan=e.id_pengaduan
                                                                    
                                                                        
                                                                         WHERE no_pengaduan LIKE '%$cari%' or
                                                                               pengaduan LIKE '%$cari%' or
                                                                               catatan LIKE '%$cari%' or
                                                                               nama LIKE '%$cari%'
                                                                               ORDER by id_pengaduan DESC");
                                    if (mysqli_num_rows($query) > 0) {
                                        $no = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><strong><?= $row['no_pengaduan'] ?></strong>,<br/><?= $row['tgl_pengaduan'] ?><br/><hr/><?= ucwords(nl2br(htmlentities(strtolower($row['pengaduan'])))) ?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['file'])) {
                                                        echo ' <strong><a href = "/./upload/pengaduan/' . $row['file'] . '"><img src="/./upload/pengaduan/' . $row['file'] . '" style="width: 70px"></a></strong>';
                                                    } else {
                                                        echo '<em>Tidak ada file yang di upload</em>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $row['nama'] ?><br/><hr/><?= $row['nama_tenant'] ?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['status_pengaduan'])) {
                                                        echo '<strong><i>' . $row['status_pengaduan'] . ',<br/>' . $row['catatan'] . '<br/>' . $row['waktu_ttd_pengaduan'] . '<br/><hr/>' . $row['status_kepuasan'] . '</i> </strong>';
                                                    } else {
                                                        echo '<em><font color="red"><i>Belum ada tanggapan</i></font></em>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['no_wo'])) {
                                                        echo '<strong><i>' . $row['no_wo'] . '</i> </strong>';
                                                    } else {
                                                        echo '<em><font color="red"><i>Belum ada WO</i></font></em>';
                                                    }
                                                    ?>
                                                </td>


                                                <td>
                                                    <?php
                                                    //HAK ASES GM & TR
                                                    if ($_SESSION['admin'] == 7 | $_SESSION['admin'] == 3) {
                                                        if (is_null($row['id_approve_pengaduan'])) {
                                                            ?>
                                                            <a class="btn small red waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Tanggapi"  href="#modal<?= $no ?>"> <i class="material-icons">warning</i></a></span>
                                                            <div id="modal<?= $no ?>" class="modal">
                                                                <div class="modal-content white">
                                                                    <div class="row">
                                                                        <!-- Secondary Nav START -->
                                                                        <div class="col s12">
                                                                            <nav class="secondary-nav">
                                                                                <div class="nav-wrapper blue-grey darken-1">
                                                                                    <ul class="left">
                                                                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tanggapi</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </nav>
                                                                        </div>
                                                                        <!-- Secondary Nav END -->
                                                                    </div>

                                                                    <div class="row jarak-form">
                                                                        <form class="col s12" method="post" action="">
                                                                            <div class="input-field col s7">
                                                                                <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                                <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                                <select name="status_pengaduan" class="browser-default validate" id="status_pengaduan" required>
                                                                                    <option value="">Pilih Status</option>
                                                                                    <option value="Progres">Progres</option>
                                                                                    <option value="Material sedang beli">Material sedang beli</option>
                                                                                    <option value="Selesai">Selesai</option>
                                                                                </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col 6">
                                                                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                                            <a href="?page=pengaduan" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </form>
                                                            <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus"  href="?page=pengaduan&act=del&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                                <i class="material-icons">delete</i></a>

                                                            <?php
                                                        } else {
                                                            ?>

                                                            <a class="btn small green waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Update" href="#modal<?= $no ?>"> <i class="material-icons">done</i></a></span>
                                                            <div id="modal<?= $no ?>" class="modal">
                                                                <div class="modal-content white">
                                                                    <div class="row">
                                                                        <!-- Secondary Nav START -->
                                                                        <div class="col s12">
                                                                            <nav class="secondary-nav">
                                                                                <div class="nav-wrapper blue-grey darken-1">
                                                                                    <ul class="left">
                                                                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">event_available</i> Tanggapi</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </nav>
                                                                        </div>
                                                                        <!-- Secondary Nav END -->
                                                                    </div>

                                                                    <div class="row jarak-form">
                                                                        <form class="col s12" method="post" action="">
                                                                            <div class="input-field col s7">
                                                                                <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                                <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                                <select name="status_pengaduan" class="browser-default validate" id="status_pengaduan" required>
                                                                                    <option value="">Pilih Status</option>
                                                                                    <option value="Progres">Progres</option>
                                                                                    <option value="Material sedang beli">Material sedang beli</option>
                                                                                    <option value="Selesai">Selesai</option>
                                                                                </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="row jarak-form">
                                                                        <form class="col s12" method="post" action="">
                                                                            <div class="input-field col s7">
                                                                                <i class="material-icons prefix md-prefix">edit</i>
                                                                                <!--input type="hidden" id="id_wo" name="id_wo" value="<?= $row['id_wo'] ?>" /-->
                                                                                <input id="catatan" type="text" class="validate" name="catatan">
                                                                                <?php
                                                                                if (isset($_SESSION['catatan'])) {
                                                                                    $catatan = $_SESSION['catatan'];
                                                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                                                                                    unset($_SESSION['catatan']);
                                                                                }
                                                                                ?>
                                                                                <label for="catatan">Catatan</label>
                                                                            </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col 6">
                                                                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                                            <a href="?page=pengaduan" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </form>
                                                            <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print" href="?page=pengaduan&act=ctk_pengaduan&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                                <i class="material-icons">print</i></a>
                                                            <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus"  href="?page=pengaduan&act=del&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                                <i class="material-icons">delete</i></a>
                                                            <a class="btn small brown darken-5 waves-effect waves-light tooltipped" data-position="right" data-tooltip="Bikin WO"  href="?page=t_wo&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                                <i class="material-icons">contact_phone</i></a>

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
                                        <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pengaduan&act=add">Tambah</a></u></p></center></td></tr>
                                    <?php
                                }
                                ?></tbody></table>
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
                                    <th width="3%">No</th>
                                    <th width="15%">No.Pengaduan<br/><hr/>Pengaduan</th>
                            <th width="15%">File</th>
                            <th width="10%">Nama PIC<br/><hr/>Nama Perusahaan</th>
                            <th width="10%">Status</th>
                            <th width="10%">Work Order</th>
                            <th width="15%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                            <div id="modal" class="modal">
                                <div class="modal-content white">
                                    <h5>Jumlah data yang ditampilkan per halaman</h5>
                                    <?php
                                    $query = mysqli_query($config, "SELECT id_sett,pengaduan FROM tbl_sett");
                                    list($id_sett, $pengaduan) = mysqli_fetch_array($query)
                                    ?>
                                    <div class="row">
                                        <form method="post" action="">
                                            <div class="input-field col s12">
                                                <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                <div class="input-field col s1" style="float: left;">
                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                </div>
                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                    <select class="browser-default validate" name="pengaduan" required>
                                                        <option value="<?= $pengaduan ?>"><?= $pengaduan ?></option>
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
                                                        $pengaduan = $_REQUEST['pengaduan'];
                                                        $id_user = $_SESSION['id_user'];

                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET pengaduan='$pengaduan',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                        if ($query == true) {
                                                            header("Location: ./admin.php?page=pengaduan");
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
                                                                    b.nama,nama_tenant,
                                                                    c.id_approve_pengaduan,status_pengaduan,waktu_ttd_pengaduan,catatan,
                                                                    d.id_wo,no_wo,
                                                                    e.status_kepuasan
                                                                    
                                                                    FROM tbl_pengaduan a
                                                                    LEFT JOIN tbl_user b
                                                                    ON a.id_user=b.id_user
                                                                    LEFT JOIN tbl_approve_pengaduan c
                                                                    ON a.id_pengaduan=c.id_pengaduan
                                                                    LEFT JOIN tbl_wo d
                                                                    ON a.id_pengaduan=d.id_pengaduan
                                                                    LEFT JOIN tbl_kepuasan e
                                                                    ON a.id_pengaduan=e.id_pengaduan
                                                                    
                                                                    
                                                                    ORDER by id_pengaduan DESC LIMIT $curr, $limit");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><?= $row['no_pengaduan'] ?></strong>,<br/><?= $row['tgl_pengaduan'] ?><br/><hr/><?= ucwords(nl2br(htmlentities(strtolower($row['pengaduan'])))) ?></td>
                                            <td>
                                                <?php
                                                if (!empty($row['file'])) {
                                                    echo ' <strong><a href = "/./upload/pengaduan/' . $row['file'] . '"><img src="/./upload/pengaduan/' . $row['file'] . '" style="width: 70px"></a></strong>';
                                                } else {
                                                    echo '<em>Tidak ada file yang di upload</em>';
                                                }
                                                ?>
                                            </td>
                                            <td><?= $row['nama'] ?><br/><hr/><?= $row['nama_tenant'] ?></td>
                                            <td>
                                                <?php
                                                if (!empty($row['status_pengaduan'])) {
                                                    echo '<strong><i>' . $row['status_pengaduan'] . ',<br/>' . $row['catatan'] . '<br/>' . $row['waktu_ttd_pengaduan'] . '<br/><hr/>' . $row['status_kepuasan'] . '</i> </strong>';
                                                } else {
                                                    echo '<em><font color="red"><i>Belum ada tanggapan</i></font></em>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (!empty($row['no_wo'])) {
                                                    echo '<strong><i>' . $row['no_wo'] . '</i> </strong>';
                                                } else {
                                                    echo '<em><font color="red"><i>Belum ada WO</i></font></em>';
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                //HAK ASES GM & TR
                                                if ($_SESSION['admin'] == 7 | $_SESSION['admin'] == 3) {
                                                    if (is_null($row['id_approve_pengaduan'])) {
                                                        ?>
                                                        <a class="btn small red waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Tanggapi"  href="#modal<?= $no ?>"> <i class="material-icons">warning</i></a></span>
                                                        <div id="modal<?= $no ?>" class="modal">
                                                            <div class="modal-content white">
                                                                <div class="row">
                                                                    <!-- Secondary Nav START -->
                                                                    <div class="col s12">
                                                                        <nav class="secondary-nav">
                                                                            <div class="nav-wrapper blue-grey darken-1">
                                                                                <ul class="left">
                                                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tanggapi</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </nav>
                                                                    </div>
                                                                    <!-- Secondary Nav END -->
                                                                </div>

                                                                <div class="row jarak-form">
                                                                    <form class="col s12" method="post" action="">
                                                                        <div class="input-field col s7">
                                                                            <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                            <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                            <select name="status_pengaduan" class="browser-default validate" id="status_pengaduan" required>
                                                                                <option value="">Pilih Status</option>
                                                                                <option value="Progres">Progres</option>
                                                                                <option value="Material sedang beli">Material sedang beli</option>
                                                                                <option value="Selesai">Selesai</option>
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                                <div class="row jarak-form">
                                                                    <form class="col s12" method="post" action="">
                                                                        <div class="input-field col s7">
                                                                            <i class="material-icons prefix md-prefix">edit</i>
                                                                            <!--input type="hidden" id="id_wo" name="id_wo" value="<?= $row['id_wo'] ?>" /-->
                                                                            <input id="catatan" type="text" class="validate" name="catatan">
                                                                            <?php
                                                                            if (isset($_SESSION['catatan'])) {
                                                                                $catatan = $_SESSION['catatan'];
                                                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                                                                                unset($_SESSION['catatan']);
                                                                            }
                                                                            ?>
                                                                            <label for="catatan">Catatan</label>
                                                                        </div>

                                                                </div>

                                                                <div class="row">
                                                                    <div class="col 6">
                                                                        <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                                        <a href="?page=pengaduan" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus"  href="?page=pengaduan&act=del&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                            <i class="material-icons">delete</i></a>

                                                        <?php
                                                    } else {
                                                        ?>

                                                        <a class="btn small green waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Update Status" href="#modal<?= $no ?>"> <i class="material-icons">done</i></a></span>
                                                        <div id="modal<?= $no ?>" class="modal">
                                                            <div class="modal-content white">
                                                                <div class="row">
                                                                    <!-- Secondary Nav START -->
                                                                    <div class="col s12">
                                                                        <nav class="secondary-nav">
                                                                            <div class="nav-wrapper blue-grey darken-1">
                                                                                <ul class="left">
                                                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">event_available</i> Tanggapi</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </nav>
                                                                    </div>
                                                                    <!-- Secondary Nav END -->
                                                                </div>

                                                                <div class="row jarak-form">
                                                                    <form class="col s12" method="post" action="">
                                                                        <div class="input-field col s7">
                                                                            <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                            <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                            <select name="status_pengaduan" class="browser-default validate" id="status_pengaduan" required>
                                                                                <option value="">Pilih Status</option>
                                                                                <option value="Progres">Progres</option>
                                                                                <option value="Material sedang beli">Material sedang beli</option>
                                                                                <option value="Selesai">Selesai</option>
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                                <div class="row jarak-form">
                                                                    <form class="col s12" method="post" action="">
                                                                        <div class="input-field col s7">
                                                                            <i class="material-icons prefix md-prefix">edit</i>
                                                                            <!--input type="hidden" id="id_wo" name="id_wo" value="<?= $row['id_wo'] ?>" /-->
                                                                            <input id="catatan" type="text" class="validate" name="catatan">
                                                                            <?php
                                                                            if (isset($_SESSION['catatan'])) {
                                                                                $catatan = $_SESSION['catatan'];
                                                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                                                                                unset($_SESSION['catatan']);
                                                                            }
                                                                            ?>
                                                                            <label for="catatan">Catatan</label>
                                                                        </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col 6">
                                                                        <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                                        <a href="?page=pengaduan" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                        <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print" href="?page=pengaduan&act=ctk_pengaduan&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                            <i class="material-icons">print</i></a>
                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus"  href="?page=pengaduan&act=del&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                            <i class="material-icons">delete</i></a>
                                                        <a class="btn small brown darken-5 waves-effect waves-light tooltipped" id="Btn" onclick="myFunction()" data-position="right" data-tooltip="Bikin WO"  href="?page=t_wo&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                            <i class="material-icons">contact_phone</i></a>

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
                                    <!--tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pengaduan&act=add">Tambah</a></u></p></center></td></tr-->
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <!-- Row form END -->
                    <?php
                    $query = mysqli_query($config, "SELECT * FROM tbl_pengaduan");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
<ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengaduan&pg=1"><i class="material-icons md-48">first_page</i></a></li>
    <li><a href="?page=pengaduan&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=pengaduan&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=pengaduan&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengaduan&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
    <li><a href="?page=pengaduan&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
}
?>
    