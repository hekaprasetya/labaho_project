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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 9 AND $_SESSION['admin'] != 10 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15 AND $_SESSION['admin'] != 18) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_pp.php";
                        break;
                    case 'edit':
                        include "edit_pp.php";
                        break;
                    case 'del':
                        include "hapus_pp.php";
                        break;
                    case 'app_gm_pp':
                        include "approve_pp_gm.php";
                        break;
                    case 'app_kabag_pp':
                        include "approve_pp_kabag.php";
                        break;
                    case 'app_keu_pp':
                        include "approve_pp_keu.php";
                        break;
                    case 'app_pembelian_pp':
                        include "approve_pp_pembelian.php";
                        break;
                    case 'app_gudang':
                        include "approve_pp_gudang.php";
                        break;
                    case 'pp_detail':
                        include "pp_detail.php";
                        break;
                    case 'pp_realisasi':
                        include "pp_realisasi.php";
                        break;
                    case 'print':
                        include "cetak_pp.php";
                        break;
                    case 'export_pp':
                        include "export_pp.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT pp FROM tbl_sett");
                list($pp) = mysqli_fetch_array($query);

                //pagging
                $limit = $pp;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pp" class="judul"><i class="material-icons"></i>PP</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=pp&act=add"><i class="material-icons md-24">add_circle</i> Tambah</a>
                                        </li>
                                        <li><a class="dropdown-button " href="#!" data-activates="cuti_dashboard"> Pilihan<i class="material-icons md-8"> arrow_drop_down</i></a></li>
                                        <ul id='cuti_dashboard' class='dropdown-content'>
                                            <li><a href="?page=pp_uncomplete"><i class="material-icons md-18">close</i>Uncomplete</a></li>
                                             <li class="divider"></li>
                                            <li><a href="?page=pp_complete"><i class="material-icons md-18">done</i> Complete</a></li>
                                             <li class="divider"></li>
                                            <li><a href="?page=dashboard_pp"><i class="material-icons md-18">local_grocery_store</i> Detail Barang</a></li>
                                             <li class="divider"></li>
                                            <li><a href="?page=pp"><i class="material-icons md-18">redo</i> Back</a></li>
                                        </ul>
                                          <li class="waves-effect waves-light">
                                            <a href=""><i class="material-icons md-24">close</i> UNCOMPLETE</a>
                                        </li>
                                    </ul>


                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=pp">
                                    </form>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- Secondary Nav END -->
            </div>
             <div class="z-depth-1">
                <nav class="secondary-nav yellow darken-3">
                    <form method="post" action="?page=pp_uncomplete">
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
                    echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=pp"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr><th>No</th>
                                        <th width="20%">No.PP<br/><hr/>Tgl.PP</th>
                                        <th width="10%">Target<br/><hr/>File</th>
                                        <th width="10%">Divisi<br/><hr/>Catatan</th>
                                        <th width="10%">Disetujui.Kabag<br/><hr/>Diketahui.Pembelian</th>
                                        <th width="10%">Diketahui Mng.Keuangan<br/><hr/>Disetujui.GM</th>
                                        <th width="15%">Diterima Gudang<br/><hr/>Waktu</th>
                                        <th width="10%">Pembuat</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.id_kabag_pp,status_kabag,waktu_kabag_pp, 
                                                           c.id_kabag_keu,status_keu,waktu_keu_pp, 
                                                           d.id_pembelian,status_pembelian,waktu_pembelian_pp,
                                                           e.id_gm_terbit,terbit_gm,waktu_terbit_gm,
                                                           f.id_pp_gudang_terbit,status_gudang_terbit,waktu_gudang_terbit,
                                                           g.nama
                                                           FROM tbl_pp a
                                                           LEFT JOIN tbl_kabag_pp b
                                                           ON a.id_pp=b.id_pp
                                                           LEFT JOIN tbl_kabag_keu c 
                                                           ON a.id_pp=c.id_pp 
                                                           LEFT JOIN tbl_pembelian d
                                                           ON a.id_pp=d.id_pp
                                                           LEFT JOIN tbl_gm_pp_terbit e
                                                           ON a.id_pp=e.id_pp
                                                           LEFT JOIN tbl_pp_gudang_terbit f
                                                           ON a.id_pp=f.id_pp
                                                           LEFT JOIN tbl_user g
                                                           ON a.id_user=g.id_user
                                                           WHERE 
                                                                 no_pp LIKE '%$cari%' 
                                                             or tgl_pp LIKE '%$cari%'
                                                             or target LIKE '%$cari%'
                                                             or divisi LIKE '%$cari%'
                                                             or catatan_pp LIKE '%$cari%'
                                                             or nama LIKE '%$cari%' 
                                                             or status_pembelian LIKE '%$cari%'
                                                             or status_kabag     LIKE '%$cari%'
                                                             or status_keu       LIKE '%$cari%'
                                                             or terbit_gm        LIKE '%$cari%'
                                                             or status_gudang_terbit  LIKE '%$cari%'
                                                             ORDER by id_pp DESC ");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;

                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td><strong><i>' . $row['no_pp'] . '</i></strong><br/><hr/>' . indoDate($row['tgl_pp']) . '</td>
                                        <td>' . indoDate($row['target']) . '<br/><hr/><strong>File :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=gpp&act=fpp&id_pp=' . $row['id_pp'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '
                                        </td>
                                        <td><strong>' . ucwords(strtolower($row['divisi'])) . '</strong><br/><hr/>' . ucwords(strtolower($row['catatan_pp'])) . '</td>
                                        
                                        <td>';
                            if (!empty($row['status_kabag'])) {
                                echo ' <strong>' . $row['status_kabag'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Kabag Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_kabag_pp'] . '
                                        
                                        <br/><hr/>';
                            if (!empty($row['status_pembelian'])) {
                                echo ' <strong>' . $row['status_pembelian'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Pembelian Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_pembelian_pp'] . '
                                        </td>
                                        
                                        <td>';
                            if (!empty($row['status_keu'])) {
                                echo ' <strong>' . $row['status_keu'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Keuangan Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_keu_pp'] . '
                                        
                                        <br/><hr/>';
                            if (!empty($row['terbit_gm'])) {
                                echo ' <strong>' . $row['terbit_gm'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>GM Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_terbit_gm'] . '
                                        </td>
                                        
                                        <td>';
                            if (!empty($row['status_gudang_terbit'])) {
                                echo ' <strong>' . $row['status_gudang_terbit'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Belum ada digudang</i></font>';
                            } echo '<br/><hr/>
                                        ' . $row['waktu_gudang_terbit'] . '</td>
                                        <td><i>' . $row['nama'] . '</i></td>
                                        <td>';

                            //**USER BIASA
                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                if ($_SESSION['admin']) {
                                    echo '
                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                    ';
                                }
                            }

                            //**KABAG APPROVE
                            if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 13 | $_SESSION['admin'] == 15) {
                                if (is_null($row['id_kabag_pp'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_kabag_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_kabag_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }

                            //**GM APPROVE
                            if ($_SESSION['admin'] == 7) {
                                if (is_null($row['id_gm_terbit'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gm_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gm_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                          ';
                                }
                            }

                            //**PEMBELIAN APPROVE
                            if ($_SESSION['admin'] == 9) {
                                if (is_null($row['id_pembelian'])) {
                                    echo '<a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_pembelian_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_pembelian_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }

                            //**KEUANGAN APPROVE
                            if ($_SESSION['admin'] == 10) {
                                if (is_null($row['id_kabag_keu'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_keu_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_keu_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                            ';
                                }
                            }

                            //**GUDANG APPROVE
                            if ($_SESSION['admin'] == 12) {
                                if (is_null($row['id_pp_gudang_terbit'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gudang&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gudang&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
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
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                
                                    <tr>
                                        <th>No</th>
                                        <th width="15%">No.PP<br/><hr/>Tgl.PP</th>
                                        <th width="8%">Target<br/><hr/>File</th>
                                        <th width="20%">Divisi<br/><hr/>Catatan</th>
                                        <th width="8%">Disetujui.Kabag<br/><hr/>Diketahui.Pembelian</th>
                                         <th width="8%">Diketahui Mng.Keuangan<br/><hr/>Disetujui.GM</th>
                                          <th width="15%">Diterima Gudang<br/><hr/>Waktu</th>
                                           <th width="10%">Pembuat</th>
                                        <th width="14%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,pp FROM tbl_sett");
                    list($id_sett, $pp) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="pp" required>
                                                                        <option value="' . $pp . '">' . $pp . '</option>
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
                        $pp = $_REQUEST['pp'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET pp='$pp',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=pp");
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
                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.id_kabag_pp,status_kabag,waktu_kabag_pp, 
                                                           c.id_kabag_keu,status_keu,waktu_keu_pp, 
                                                           d.id_pembelian,status_pembelian,waktu_pembelian_pp,
                                                           e.id_gm_terbit,terbit_gm,waktu_terbit_gm,
                                                           f.id_pp_gudang_terbit,status_gudang_terbit,waktu_gudang_terbit,
                                                           g.nama
                                                           FROM tbl_pp a
                                                           LEFT JOIN tbl_kabag_pp b
                                                           ON a.id_pp=b.id_pp
                                                           LEFT JOIN tbl_kabag_keu c 
                                                           ON a.id_pp=c.id_pp 
                                                           LEFT JOIN tbl_pembelian d
                                                           ON a.id_pp=d.id_pp
                                                           LEFT JOIN tbl_gm_pp_terbit e
                                                           ON a.id_pp=e.id_pp
                                                           LEFT JOIN tbl_pp_gudang_terbit f
                                                           ON a.id_pp=f.id_pp
                                                           LEFT JOIN tbl_user g
                                                           ON a.id_user=g.id_user
                                                           
                                                           WHERE id_pp_gudang_terbit is null
                                                           ORDER by id_gm_terbit is null DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td><strong><i>' . $row['no_pp'] . '</i></strong><br/><hr/>' . indoDate($row['tgl_pp']) . '</td>
                                        <td>' . indoDate($row['target']) . '<br/><hr/><strong>File :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=gpp&act=fpp&id_pp=' . $row['id_pp'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '
                                        </td>
                                        <td><strong>' . ucwords(strtolower($row['divisi'])) . '</strong><br/><hr/>' . ucwords(strtolower($row['catatan_pp'])) . '</td>
                                        
                                        <td>';
                            if (!empty($row['status_kabag'])) {
                                echo ' <strong>' . $row['status_kabag'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Kabag Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_kabag_pp'] . '
                                        
                                        <br/><hr/>';
                            if (!empty($row['status_pembelian'])) {
                                echo ' <strong>' . $row['status_pembelian'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Pembelian Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_pembelian_pp'] . '
                                        </td>
                                        
                                        <td>';
                            if (!empty($row['status_keu'])) {
                                echo ' <strong>' . $row['status_keu'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Keuangan Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_keu_pp'] . '
                                        
                                        <br/><hr/>';
                            if (!empty($row['terbit_gm'])) {
                                echo ' <strong>' . $row['terbit_gm'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>GM Kosong</i></font>';
                            } echo ', <br>
                                        ' . $row['waktu_terbit_gm'] . '
                                        </td>
                                        
                                        <td>';
                            if (!empty($row['status_gudang_terbit'])) {
                                echo ' <strong>' . $row['status_gudang_terbit'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Belum ada digudang</i></font>';
                            } echo '<br/><hr/>
                                        ' . $row['waktu_gudang_terbit'] . '</td>
                                        <td><i>' . $row['nama'] . '</i></td>
                                        <td>';

                            //**USER BIASA
                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                if ($_SESSION['admin']) {
                                    echo '
                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                    ';
                                }
                            }

                            //**KABAG APPROVE
                            if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 13 | $_SESSION['admin'] == 15) {
                                if (is_null($row['id_kabag_pp'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_kabag_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_kabag_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }

                            //**GM APPROVE
                            if ($_SESSION['admin'] == 7) {
                                if (is_null($row['id_gm_terbit'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gm_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gm_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                            ';
                                }
                            }

                            //**PEMBELIAN APPROVE
                            if ($_SESSION['admin'] == 9) {
                                if (is_null($row['id_pembelian'])) {
                                    echo '<a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_pembelian_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_pembelian_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                          ';
                                }
                            }

                            //**KEUANGAN APPROVE
                            if ($_SESSION['admin'] == 10) {
                                if (is_null($row['id_kabag_keu'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_keu_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_keu_pp&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }

                            //**GUDANG APPROVE
                            if ($_SESSION['admin'] == 12) {
                                if (is_null($row['id_pp_gudang_terbit'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gudang&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">warning</i></a>';
                                } else {
                                    echo'
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gudang&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">assignment_turned_in</i></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PP" href="?page=pp&act=edit&id_pp=' . $row['id_pp'] . '">
                                                <i class="material-icons">edit</i></a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=' . $row['id_pp'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>
                                           ';
                                }
                            }

                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pp&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_pp");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pp&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pp&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=pp&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=pp&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=pp&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pp&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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