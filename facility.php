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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_facility.php";
                        break;
                    case 'edit':
                        include "edit_facility.php";
                        break;
                    case 'print':
                        include "cetak_facility.php";
                        break;
                    case 'del':
                        include "hapus_facility.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT facility FROM tbl_sett");
                list($facility) = mysqli_fetch_array($query);

                //pagging
                $limit = $facility;
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
                            <div class="nav-wrapper blue-grey darken-1">
                                <div class="col m7">
                                    <ul class="left">
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=facility" class="judul"><i class="material-icons">mail</i>Facility</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=facility&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col m5 hide-on-med-and-down">
                                    <form method="post" action="?page=facility">
                                        <div class="input-field round-in-box">
                                            <input id="search" type="search" name="cari" placeholder="Searching" required>
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
                    echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=tsm"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr><th>No</th>
                                    <th width="5%">No.WO<br/><hr/>Tgl.WO</th>
                                    <th width="30%">Jenis Pekerjaan<br/><hr/>File</th>
                                    <th width="15%">Lokasi<br/><hr/>Nama Perusahaan</th>
                                     <th width="20%">Penyebab<br/><hr/>Tindakan</th>
                                     <th width="10%">Pelaksana<br/><hr/>Divisi</th></th>
                                    <th width="12%">Status Pekerjaan<br/><hr/>Tgl.Selesai</th>
                                    <th width="10%">Option<span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                    $query = mysqli_query($config, "SELECT * FROM tbl_facility WHERE no_wo_fc LIKE '%$cari%'or tgl_wo_fc LIKE '%$cari%' or jenis_pekerjaan_fc LIKE '%$cari%' or lokasi_fc LIKE '%$cari%' or perusahaan_fc LIKE '%$cari%' or penyebab_fc LIKE '%$cari%' or tindakan LIKE '%$cari%' or divisi LIKE '%$cari%'ORDER by id_facility DESC LIMIT 15");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;

                            echo '
                                  <tr>
                                    <td>' . $no . '</td>
                                    <td>' . $row['no_wo_fc'] . '<br/><hr/>' . indoDate($row['tgl_wo_fc']) . '</td>
                                   <td>' . nl2br(htmlentities($row['jenis_pekerjaan_fc'])) . '<br/><br/><strong>File :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=gal_fac&act=file_fac&id_facility=' . $row['id_facility'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '</td>
                                    <td>' . $row['lokasi_fc'] . '<br/><hr/>' . $row['perusahaan_fc'] . '</td>
                                    <td><strong>' . $row['penyebab_fc'] . '</strong><br/><hr/><strong>' . $row['tindakan_fc'] . '</strong></td>
                                    <td><strong>' . $row['status_fc'] . '</strong><br/><hr/>' . indoDate($row['tgl_selesai_fc']) . '</td>
                                         <td><strong>' . $row['pelaksana_fc'] . '</strong><br/><hr/><strong>' . $row['divisi_fc'] . '</strong></td>
                                    <td>';

                            
                             if ($_SESSION['admin'] == 2||$_SESSION['admin'] == 13|$_SESSION['admin'] == 14) {
                                if ($_SESSION['admin']) {
                                    echo '
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=facility&act=edit&id_facility=' . $row['id_facility'] . '">
                                                <i class="material-icons">edit</i> EDIT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_facility&id_facility=' . $row['id_facility'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }

                            if ($_SESSION['admin'] == 7) {
                                if ($_SESSION['admin'] == 7) {
                                    echo '  <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_facility=' . $row['id_facility'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }
                            
                            if ($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] != 1) {
                                echo '<a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_facility=' . $row['id_facility'] . '" target="_blank">
                                            <i class="material-icons">print</i> PRINT</a>';
                            } else {
                                echo '<a class="btn small blue waves-effect waves-light" href="?page=facility&act=edit&id_facility=' . $row['id_facility'] . '">
                                                <i class="material-icons">edit</i> EDIT</a>
                                         
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=facility&id_facility=' . $row['id_facility'] . '" target="_blank">
                                                <i class="material-icons">print</i> PRINT</a>
                                            <a class="btn small deep-orange waves-effect waves-light" href="?page=facility&act=del&id_facility=' . $row['id_facility'] . '">
                                                <i class="material-icons">delete</i> DEL</a>';
                            } echo '
                                        </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                    }
                    echo '</tbody></table><br/><br/>
                        </div>
                    </div>
                    <!-- Row form END -->';
                } else {

                    echo '
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                
                                    <tr>
                                        <th>No</th>
                                        <th width="5%">No.WO<br/><hr/>Tgl.WO</th>
                                        <th width="30%">Jenis Pekerjaan<br/><hr/> File</th>
                                        <th width="15%">Lokasi<br/><hr/>Nama Perusahaan</th>
                                        <th width="30%">Penyebab<br/><hr/>Tindakan</th>
                                        <th width="12%">Status<br/><hr/>Tanggal Selesai</th>
                                         <th width="12%">Pelaksana<br/><hr/>Divisi</th></th>
                                        <th width="10%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,facility FROM tbl_sett");
                    list($id_sett, $facility) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="engineering" required>
                                                                        <option value="' . $facility . '">' . $facility . '</option>
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer white">
                                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>';
                    if (isset($_REQUEST['simpan'])) {
                        $id_sett = "1";
                        $facility = $_REQUEST['facility'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET facility='$facility',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=facility");
                            die();
                        }
                    } echo '
                                                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    </tr>
                                </thead>
                                <tbody>';

                    //script untuk menampilkan data
                    $query = mysqli_query($config, "SELECT * FROM tbl_facility ORDER by id_facility DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td>' . $row['no_wo_fc'] . '<br/><hr/>' . indoDate($row['tgl_wo_fc']) . '</td>
                                        <td>' . ucwords(nl2br(htmlentities(strtolower($row['jenis_pekerjaan_fc'])))) . '<br/><br/><strong>File :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=gal_fac&act=file_fac&id_facility=' . $row['id_facility'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '</td>
                                        <td>' . ucwords(strtolower($row['lokasi_fc'])) . '<br/><hr>' . ucwords(strtolower($row['perusahaan_fc'])) . '</td>
                                        <td>' . ucwords(strtolower($row['penyebab_fc'])) . '<br/><hr>' . ucwords(strtolower($row['tindakan_fc'])) . '</td>
                                        <td><strong>' . ucwords(strtolower($row['status_fc'])) . '</stong><br/><hr/>' . indoDate($row['tgl_selesai_fc']) . '</td>
                                        <td>' . ucwords(strtolower($row['pelaksana_fc'])) . '<br/><hr>' . ucwords(strtolower($row['divisi_fc'])) . '</td>
                                        <td>';



                            if ($_SESSION['admin'] == 2||$_SESSION['admin'] == 13|$_SESSION['admin'] == 14) {
                                if ($_SESSION['admin']) {
                                    echo '
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=facility&act=edit&id_facility=' . $row['id_facility'] . '">
                                                <i class="material-icons">edit</i> EDIT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_facility&id_facility=' . $row['id_facility'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }

                            if ($_SESSION['admin'] == 7) {
                                if ($_SESSION['admin'] == 7) {
                                    echo '  <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_facility&id_facility=' . $row['id_facility'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }


                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=facility&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_facility");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=facility&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=facility&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=facility&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=facility&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=facility&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=facility&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
</div>