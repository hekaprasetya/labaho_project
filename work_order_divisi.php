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
        function hideURLbar(){ window.scrollTo(0,1); } </script>

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
            list($id_pengaduan) = mysqli_fetch_array($query);
            {

                $id_pengaduan = $_REQUEST['id_pengaduan'];
                $status_pengaduan = $_POST['status_pengaduan'];
                $kategori_masalah = $_POST['kategori_masalah'];
                $catatan = $_POST['catatan'];
                $id_user = $_SESSION['id_user'];
                $cek_data_qry = mysqli_query($config, "select * FROM tbl_approve_pengaduan where id_pengaduan='$id_pengaduan'");
                $cek_data = mysqli_num_rows($cek_data_qry);
                $cek_data_row = mysqli_fetch_array($cek_data_qry);
                if ($cek_data == 0) {
                    $query = mysqli_query($config, "INSERT INTO tbl_approve_pengaduan(status_pengaduan,kategori_masalah,catatan,id_pengaduan,id_user)
                                        VALUES('$status_pengaduan','$kategori_masalah','$catatan','$id_pengaduan','$id_user')");
                } else {
                    $query = mysqli_query($config, "UPDATE tbl_approve_pengaduan SET
                status_pengaduan='$status_pengaduan',
                catatan='$catatan',
                kategori_masalah='$kategori_masalah',
                id_pengaduan='$id_pengaduan',
                id_user='$id_user' 
                WHERE id_approve_pengaduan=$cek_data_row[id_approve_pengaduan]");
                }

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    echo '<script language="javascript">
                                                window.location.href="./admin.php?page=work_order_divisi";
                                              </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        } else {

            if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 9 AND $_SESSION['admin'] != 10 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15) {
                echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
            } else {

                if (isset($_REQUEST['act'])) {
                    $act = $_REQUEST['act'];
                    switch ($act) {
                        //  case 'add':
                        //include "tambah_wo.php";
                        //  break;
                        case 'edit':
                            include "edit_wo.php";
                            break;
                        case 'del':
                            include "hapus_wo.php";
                            break;
                        case 'ctk_wo':
                            include "cetak_wo.php";
                            break;
                    }
                } else {

                    $query = mysqli_query($config, "SELECT work_order FROM tbl_sett");
                    list($work_order) = mysqli_fetch_array($query);

                    //pagging
                    $limit = $work_order;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=work_order_divisi" class="judul"><i class="material-icons md-3">group_add</i> Work Order</a></li>
                                            <!--li class="waves-effect waves-light">
                                                <a href="?page=word_order&act=add"><i class="material-icons md-3">add_circle</i>Tambah</a>
                                            </li-->
                                        </ul>
                                    </div>
                                    <div class="col s5 show-on-med-and-down">
                                        <form method="post" action="?page=work_order_divisi">
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
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=work_order_divisi"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="3%">No</th>
                                        <th width="12%">No.WO<br/><hr/>No.Pengaduan</th>
                                <th width="21%">Pengaduan<br/><hr/>Divisi</th>
                                <th width="12%">File</th>
                                <th width="18%">Nama Tenant</th>
                                <th width="12%">Status Pekerjaan</th>
                                <th width="8%">Kategori</th>
                                <th width="10%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //script untuk mencari data
                                    $query = mysqli_query($config, "SELECT a.*,
                                                                        b.no_pengaduan,pengaduan,status_pengaduan,
                                                                        b.file,
                                                                        c.nama,nama_tenant,
                                                                        d.id_wo_divisi,pekerjaan_divisi,
                                                                        e.id_approve_pengaduan,waktu_ttd_pengaduan,kategori_masalah
                                                                     
                                                                          FROM tbl_wo a
                                                                          LEFT JOIN tbl_pengaduan b
                                                                          ON a.id_pengaduan=b.id_pengaduan
                                                                          LEFT JOIN tbl_user c
                                                                          ON b.id_user=c.id_user
                                                                          LEFT JOIN tbl_wo_divisi d
                                                                          ON a.id_wo=d.id_wo
                                                                          LEFT JOIN tbl_approve_pengaduan e
                                                                          ON a.id_pengaduan=e.id_pengaduan
                                                                        
                                                                         WHERE no_pengaduan LIKE '%$cari%' or
                                                                               a.divisi LIKE '%$cari%' or
                                                                               a.no_wo LIKE '%$cari%' or
                                                                               pengaduan LIKE '%$cari%' or
                                                                               kategori_masalah LIKE '%$cari%' or
                                                                               nama_tenant LIKE '%$cari%'
                                                                                   
                                                                               ORDER by id_wo DESC");
                                    if (mysqli_num_rows($query) > 0) {
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $no++;
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><strong><?= $row['no_wo'] ?><br/><hr/><?= $row['no_pengaduan'] ?></strong></td>
                                                <td><strong><?= ucwords(nl2br(htmlentities(strtolower($row['pengaduan'])))) ?></strong><br/><hr/><?= $row['divisi'] ?><br/><hr/></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['file'])) {
                                                        echo ' <strong><a href = "/./upload/pengaduan/' . $row['file'] . '"><img src="/./upload/pengaduan/' . $row['file'] . '" style="width: 70px"></a></strong>';
                                                    } else {
                                                        echo '<em>Tidak ada file yang di upload</em>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><center><?= $row['nama_tenant'] ?></center></td>
                                                <td><strong><?= $row['status_pengaduan'] ?></strong>,<br/><?= $row['waktu_ttd_pengaduan'] ?></td>
                                                <td><center><strong><?= $row['kategori_masalah'] ?></strong></center></td>
                                        <td>
                                            <?php
                                            //HAK AkSES Adm.TK/EM/Facility
                                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 4 | $_SESSION['admin'] == 13) {
                                                if ($_SESSION['admin']) {
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
                                                                    <div class="input-field col s9">
                                                                        <i class="material-icons prefix md-prefix">exit_to_app</i><label>Kategori</label><br/>
                                                                        <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                        <select name="kategori_masalah" class="browser-default validate" id="kategori_masalah" required>
                                                                            <option value="">Pilih Kategori</option>
                                                                            <option value="AC">AC</option>
                                                                            <option value="Listrik">Listrik</option>
                                                                            <option value="Plumbing">Plumbing</option>
                                                                        </select>
                                                                    </div>
                                                            </div>

                                                            <div class="row jarak-form">
                                                                <form class="col s12" method="post" action="">
                                                                    <div class="input-field col s9">
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
                                                                    <div class="input-field col s9">
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
                                                                    <a href="?page=work_order_divisi" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print" href="?page=pengaduan&act=ctk_pengaduan&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                        <i class="material-icons">print</i></a>
                                                    </form>

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
                                    <th width="12%">No.WO<br/><hr/>No.Pengaduan</th>
                            <th width="21%">Pengaduan<br/><hr/>Divisi</th>
                            <th width="12%">File</th>
                            <th width="18%">Nama Tenant</th>
                            <th width="12%">Status Pekerjaan</th>
                            <th width="8%">Kategori</th>
                            <th width="10%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                            <div id="modal" class="modal">
                                <div class="modal-content white">
                                    <h5>Jumlah data yang ditampilkan per halaman</h5>
                                    <?php
                                    $query = mysqli_query($config, "SELECT id_sett,work_order FROM tbl_sett");
                                    list($id_sett, $work_order) = mysqli_fetch_array($query)
                                    ?>
                                    <div class="row">
                                        <form method="post" action="">
                                            <div class="input-field col s12">
                                                <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                <div class="input-field col s1" style="float: left;">
                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                </div>
                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                    <select class="browser-default validate" name="work_order" required>
                                                        <option value="<?= $work_order ?>"><?= $work_order ?></option>
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
                                                        $work_order = $_REQUEST['work_order'];
                                                        $id_user = $_SESSION['id_user'];

                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET work_order='$work_order',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                        if ($query == true) {
                                                            header("Location: ./admin.php?page=work_order");
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
                                //  print_r($_POST);
                                $divisi = $_SESSION['divisi'];
                                $query = mysqli_query($config, "SELECT a.*,
                                                                        b.no_pengaduan,pengaduan,tgl_pengaduan,
                                                                        b.file,
                                                                        c.nama_tenant,
                                                                        d.id_wo_divisi,pekerjaan_divisi,waktu_pekerjaan,
                                                                        e.status_pengaduan,waktu_ttd_pengaduan,kategori_masalah
                                                                      
                                                                     
                                                                          FROM tbl_wo a
                                                                          LEFT JOIN tbl_pengaduan b
                                                                          ON a.id_pengaduan=b.id_pengaduan
                                                                          LEFT JOIN tbl_user c
                                                                          ON b.id_user=c.id_user
                                                                          LEFT JOIN tbl_wo_divisi d
                                                                          ON a.id_wo=d.id_wo
                                                                          LEFT JOIN tbl_approve_pengaduan e
                                                                          ON a.id_pengaduan=e.id_pengaduan
                                                                       
                                                                          
                                                                    WHERE a.divisi='$divisi'        
                                                                    ORDER by id_wo DESC LIMIT $curr, $limit");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><?= $row['no_wo'] ?><br/><hr/><?= $row['no_pengaduan'] ?></strong></td>
                                            <td><strong><?= ucwords(nl2br(htmlentities(strtolower($row['pengaduan'])))) ?></strong><br/><hr/><?= $row['divisi'] ?><br/><hr/></td>
                                            <td>
                                                <?php
                                                if (!empty($row['file'])) {
                                                    echo ' <strong><a href = "/./upload/pengaduan/' . $row['file'] . '"><img src="/./upload/pengaduan/' . $row['file'] . '" style="width: 70px"></a></strong>';
                                                } else {
                                                    echo '<em>Tidak ada file yang di upload</em>';
                                                }
                                                ?>
                                            </td>
                                            <td><center><?= $row['nama_tenant'] ?></center></td>
                                            <td><strong><?= $row['status_pengaduan'] ?></strong>,<br/><?= $row['waktu_ttd_pengaduan'] ?></td>
                                            <td><center><strong><?= $row['kategori_masalah'] ?></strong></center></td>

                                    <td>
                                        <?php
                                        //HAK AkSES Adm.TK/EM/Facility
                                        if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 4 | $_SESSION['admin'] == 13) {
                                            if ($_SESSION['admin']) {
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
                                                                <div class="input-field col s9">
                                                                    <i class="material-icons prefix md-prefix">exit_to_app</i><label>Kategori</label><br/>
                                                                    <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                    <select name="kategori_masalah" class="browser-default validate" id="kategori_masalah" required>
                                                                        <option value="<?= $row['kategori_masalah'] ?>" selected><?= $row['kategori_masalah'] ?></option>
                                                                        <option value="">Pilih Kategori</option>
                                                                        <option value="AC">AC</option>
                                                                        <option value="Listrik">Listrik</option>
                                                                        <option value="Plumbing">Plumbing</option>
                                                                        <option value="Kebersihan">Kebersihan</option>
                                                                        <option value="Parkir">Parkir</option>
                                                                    </select>
                                                                </div>
                                                        </div>

                                                        <div class="row jarak-form">
                                                            <form class="col s12" method="post" action="">
                                                                <div class="input-field col s9">
                                                                    <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                    <input type="hidden" id="id_pengaduan" name="id_pengaduan" value="<?= $row['id_pengaduan'] ?>" />
                                                                    <select name="status_pengaduan" class="browser-default validate" id="status_pengaduan" required>
                                                                        <option value="<?= $row['status_pengaduan'] ?>" selected><?= $row['status_pengaduan'] ?></option>
                                                                        <option value="">Pilih Status</option>
                                                                        <option value="Progres">Progres</option>
                                                                        <option value="Material sedang beli">Material sedang beli</option>
                                                                        <option value="Selesai">Selesai</option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="row jarak-form">
                                                            <form class="col s12" method="post" action="">
                                                                <div class="input-field col s9">
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
                                                                <a href="?page=work_order_divisi" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print" href="?page=pengaduan&act=ctk_pengaduan&id_pengaduan=<?= $row['id_pengaduan'] ?>">
                                                    <i class="material-icons">print</i></a>
                                                </form>

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
                        <!--tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=w&act=add">Tambah</a></u></p></center></td></tr-->
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <!-- Row form END -->
                    <?php
                    $query = mysqli_query($config, "SELECT * FROM tbl_wo");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                            <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=work_order&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                        <li><a href="?page=work_order&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                        <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=work_order&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=work_order&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=work_order&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                         <li><a href="?page=work_order&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
    