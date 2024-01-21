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
                        include "tambah_opb.php";
                        break;
                    case 'edit':
                        include "edit_opb.php";
                        break;
                    case 'app_petugas_opb':
                        include "approve_opb_petugas.php";
                        break;
                    case 'app_kabag_opb':
                        include "approve_opb_kabag.php";
                        break;
                    case 'opb_detail':
                        include "opb_detail.php";
                        break;
                    case 'print':
                        include "cetak_opb.php";
                        break;
                    case 'report_opb':
                        include "report_opb.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT opb FROM tbl_sett");
                list($opb) = mysqli_fetch_array($query);

                //pagging
                $limit = $opb;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=opb" class="judul"><i class="material-icons"></i>OPB</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=opb&act=add"><i class="material-icons md-24">add_circle</i> Tambah</a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=opb">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=opb"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr><th>No</th>
                                        <th width="15%">No.Form</th>
                                        <th width="20%">Tanggal</th>
                                        <th width="11%">Divisi</th>
                                        <th width="17%">Disetujui.Kabag</th>
                                        <th width="17%">Disetujui.Petugas</th>
                                        <th width="15%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.id_app_opb_kabag,status_opb_kabag,waktu_opb_kabag, 
                                                           c.id_app_opb_petugas,status_opb_petugas,waktu_opb_petugas,
                                                           d.nama 
                                                           FROM tbl_opb a
                                                           LEFT JOIN tbl_approve_opb_kabag b
                                                           ON a.id_opb=b.id_opb
                                                           LEFT JOIN tbl_approve_opb_petugas c 
                                                           ON a.id_opb=c.id_opb 
                                                           LEFT JOIN tbl_user d
                                                           ON a.id_user=d.id_user
                                                           
                                                        WHERE 
                                                        no_form LIKE '%$cari%' 
                                                        or tgl_opb LIKE '%$cari%'      
                                                        or divisi_opb LIKE '%$cari%'
                                                        or status_opb_kabag LIKE '%$cari%'
                                                        or status_opb_petugas LIKE '%$cari%'
                                                        ORDER by id_opb DESC ");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;

                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td><strong><i>' . $row['no_form'] . '</td>
                                        <td>' . indoDate($row['tgl_opb']) . '</td>
                                        <td>' . $row['divisi_opb'] . '</td>
                                        <td>';
                            if (!empty($row['status_opb_kabag'])) {
                                echo ' <strong>' . $row['status_opb_kabag'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Kabag Kosong</i></font>';
                            }
                            echo ', <br>
                                                    ' . $row['waktu_opb_kabag'] . '
                                        </td>
                                        <td>';
                            if (!empty($row['status_opb_petugas'])) {
                                echo ' <strong>' . $row['status_opb_petugas'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Petugas Kosong</i></font>';
                            }
                            echo ', <br>
                                                    ' . $row['waktu_opb_petugas'] . '
                                        </td>
                                        <td>';

                            //**USER BIASA
                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                if ($_SESSION['admin']) {
                                    echo '
                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit OPB" href="?page=opb&act=edit&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">edit</i></a>
                                   <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print OPB" href="?page=opb&act=print&id_opb=' . $row['id_opb'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                    ';
                                }
                            }

                            //**KABAG APPROVE
                            if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 13 | $_SESSION['admin'] == 15) {
                                if (is_null($row['id_app_opb_kabag'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_kabag_opb&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo '
                                          <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_kabag_opb&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit OPB" href="?page=opb&act=edit&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print OPB" href="?page=opb&act=print&id_opb=' . $row['id_opb'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }


                            //**PETUGAS APPROVE
                            if ($_SESSION['admin'] == 9|$_SESSION['admin'] == 12) {
                                if (is_null($row['id_app_opb_petugas'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_petugas_opb&id_opb=' . $row['id_opb'] . '">
                                        <i class="material-icons">warning</i></a>';
                                                    } else {
                                                        echo '
                            <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_petugas_opb&id_opb=' . $row['id_opb'] . '">
                                  <i class="material-icons">assignment_turned_in</i></a>
                            <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit OPB" href="?page=opb&act=edit&id_opb=' . $row['id_opb'] . '">
                                  <i class="material-icons">edit</i></a>
                            <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print OPB" href="?page=opb&act=print&id_opb=' . $row['id_opb'] . '" target="_blank">
                                                                    <i class="material-icons">print</i></a>
                            ';
                                }
                            }
                            echo '
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
                            <table class="bordered striped" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                
                                    <tr>
                                        <th>No</th>
                                        <th width="15%">No.Form</th>
                                        <th width="20%">Tanggal</th>
                                        <th width="11%">Divisi</th>
                                        <th width="17%">Disetujui.Kabag</th>
                                        <th width="17%">Disetujui.Petugas</th>
                                        <th width="15%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,opb FROM tbl_sett");
                    list($id_sett, $opb) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="opb" required>
                                                                        <option value="' . $opb . '">' . $opb . '</option>
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
                        $opb = $_REQUEST['opb'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET opb='$opb',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=opb");
                            die();
                        }
                    }
                    echo '
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
                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.id_app_opb_kabag,status_opb_kabag,waktu_opb_kabag, 
                                                           c.id_app_opb_petugas,status_opb_petugas,waktu_opb_petugas,
                                                           d.nama 
                                                           FROM tbl_opb a
                                                           LEFT JOIN tbl_approve_opb_kabag b
                                                           ON a.id_opb=b.id_opb
                                                           LEFT JOIN tbl_approve_opb_petugas c 
                                                           ON a.id_opb=c.id_opb 
                                                           LEFT JOIN tbl_user d
                                                           ON a.id_user=d.id_user
                                                           ORDER by id_opb DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td><strong><i>' . $row['no_form'] . '</td>
                                        <td>' . indoDate($row['tgl_opb']) . '</td>
                                        <td>' . $row['divisi_opb'] . '</td>
                                        <td>';
                            if (!empty($row['status_opb_kabag'])) {
                                echo ' <strong>' . $row['status_opb_kabag'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Kabag Kosong</i></font>';
                            }
                            echo ', <br>
                                                    ' . $row['waktu_opb_kabag'] . '
                                        </td>
                                        <td>';
                            if (!empty($row['status_opb_petugas'])) {
                                echo ' <strong>' . $row['status_opb_petugas'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Petugas Kosong</i></font>';
                            }
                            echo ', <br>
                                                    ' . $row['waktu_opb_petugas'] . '
                                        </td>
                                        <td>';

                            //**USER BIASA
                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                if ($_SESSION['admin']) {
                                    echo '
                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit OPB" href="?page=opb&act=edit&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">edit</i></a>
                                   <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print OPB" href="?page=opb&act=print&id_opb=' . $row['id_opb'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                    ';
                                }
                            }

                            //**KABAG APPROVE
                            if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 13 | $_SESSION['admin'] == 15) {
                                if (is_null($row['id_app_opb_kabag'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_kabag_opb&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo '
                                          <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_kabag_opb&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit OPB" href="?page=opb&act=edit&id_opb=' . $row['id_opb'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print OPB" href="?page=opb&act=print&id_opb=' . $row['id_opb'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }


                            //**PETUGAS APPROVE
                            if ($_SESSION['admin'] == 9 | $_SESSION['admin'] == 12) {
                                if (is_null($row['id_app_opb_petugas'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_petugas_opb&id_opb=' . $row['id_opb'] . '">
                                        <i class="material-icons">warning</i></a>';
                                                    } else {
                                                        echo '
                            <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=opb&act=app_petugas_opb&id_opb=' . $row['id_opb'] . '">
                                  <i class="material-icons">assignment_turned_in</i></a>
                            <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit OPB" href="?page=opb&act=edit&id_opb=' . $row['id_opb'] . '">
                                  <i class="material-icons">edit</i></a>
                            <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print OPB" href="?page=opb&act=print&id_opb=' . $row['id_opb'] . '" target="_blank">
                                                                    <i class="material-icons">print</i></a>
                            ';
                                }
                            }

                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=opb&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_opb");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=opb&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=opb&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=opb&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=opb&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=opb&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=opb&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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