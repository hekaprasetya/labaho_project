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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 4  AND $_SESSION['admin'] != 7  AND $_SESSION['admin'] != 8) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
        $act = $_REQUEST['act'];
        switch ($act) {
            case 'add':
                include "tambah_lpt.php";
                break;
            case 'edit':
                include "edit_lpt.php";
                break;
            case 'del':
                include "hapus_lpt.php";
                break;
            case 'verifikasi':
                include "verifikasi_lpt.php";
                break;
        }
    } else {

                $query = mysqli_query($config, "SELECT lpt FROM tbl_sett");
                list($lpt) = mysqli_fetch_array($query);

                //pagging
                $limit = $lpt;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=lpt" class="judul"><i class="material-icons">mail</i>L P T</a></li>
                                        <li class="waves-effect waves-light">
                                            <!--a href="?page=lpt&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a-->
                                        </li>
                                    </ul>
                                </div>
                                 <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=lpt">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=lpt"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                               <th>No</th>
                                        <th width="15%">No.LPT<br/><hr/>Tgl.LPT</th>
                                        <th width="18%">No.PMK</th>
                                        <th width="30%">Nama Teknisi<br/><hr/>Nama Perusahaan</th>
                                        <th width="24%">Peminta<br/><hr/>Lokasi</th>
                                        <th width="18%">Jenis Pekerjaan<br/><hr/>Pekerjaan Yang Dilakukan</th>
                                        <th width="18%">Mng.Engineering</th>
                                        <th width="18%">Verifikator<br/><hr/>Tgl.Verifikasi</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.ttd_kabag ,
                                                           c.nama_verifikator,tgl_verifikasi,
                                                           d.no_agenda 
                                                           FROM tbl_lpt a
                                                           LEFT JOIN tbl_approve_lpt b
                                                           ON a.id_lpt=b.id_lpt 
                                                           LEFT JOIN tbl_verifikasi_lpt c
                                                           ON a.id_lpt=c.id_lpt 
                                                           LEFT JOIN tbl_surat_masuk d 
                                                           ON a.id_lpt=d.id_surat 
                                                           
                                                             WHERE no_lpt LIKE '%$cari%'or 
                                                             tgl_lpt LIKE '%$cari%' or 
                                                             nama_perusahaan LIKE '%$cari%' or 
                                                             peminta LIKE '%$cari%' or 
                                                             lokasi_pengerjaan LIKE '%$cari%' or 
                                                             jenis_pekerjaan LIKE '%$cari%' or 
                                                             pekerjaan LIKE '%$cari%' or 
                                                             verifikator LIKE '%$cari%' or 
                                                             nama_tk LIKE '%$cari%' 
                                                             ORDER by id_lpt DESC");
                    if (mysqli_num_rows($query) > 0) {
                         $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                        
                            echo '
                                  <tr>
                                    <td>' . $no . '</td>
                                    <td>' . $row['no_lpt'] . '<br/><hr/>' .indoDate ($row['tgl_lpt']) . '</td>
                                    <td><strong>' . $row['no_agenda'] . '</strong></td>
                                    <td>' . $row['nama_tk'] . '<br/><hr/>' . $row['nama_perusahaan'] . '</td>
                                    <td>' . $row['peminta'] . '<br/><hr/>' . $row['lokasi_pengerjaan'] . '</td>
                                    <td>' . $row['jenis_pekerjaan'] . '<br/><hr/>' . $row['pekerjaan'] . '</td>
                                    <td>';
                                        if (!empty($row['ttd_kabag'])) {
                                            echo ' <strong>' . $row['ttd_kabag'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Manager Kosong</i></font>';
                                        } echo '
                                        
                                    </td>
                                    <td>';
                                        if (!empty($row['nama_verifikator'])) {
                                            echo ' <strong>' . $row['nama_verifikator'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Verifikator Kosong</i></font>';
                                        } echo '
                                        
                                        <br/><hr/>';
                                         if (!empty($row['tgl_verifikasi'])) {
                                            echo ' <strong>' . indoDate($row['tgl_verifikasi']) . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Tgl.Kosong</i></font>';
                                        } echo '
                                    </td>
                                          <td>';
                                    
                            //kabag teknik
                           if ($_SESSION['admin'] == 4) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="E-LPT Kosong" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_turned_in</i>Kosong</a>';
                                } else {
                                    echo '<a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approval E-LPT" href="?page=app_lpt_v&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_ind</i>Approval</a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>Lihat E-LPT</a>';
                                }
                            }
                            
                            //tenant relation
                            if ($_SESSION['admin'] == 3) {
                                if ($_SESSION['admin']==3) {
                                    echo '<a class="btn small blue waves-effect waves-light tooltipped" data-position="left" data-tooltip="Verifikasi E-LPT" href="?page=lpt&act=verifikasi&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">touch_app</i></a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>';
                              
                                }
                            }
                            
                            //admin teknik & GM
                            if ($_SESSION['admin'] == 2 |$_SESSION['admin'] == 7) {
                                if ($_SESSION['admin']){
                                    echo '  <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>';
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
                                        <th width="15%">No.LPT<br/><hr/>Tgl.LPT</th>
                                        <th width="18%">No.PMK</th>
                                        <th width="30%">Nama Teknisi<br/><hr/>Nama Perusahaan</th>
                                        <th width="24%">Peminta<br/><hr/>Lokasi</th>
                                        <th width="18%">Jenis Pekerjaan<br/><hr/>Pekerjaan Yang Dilakukan</th>
                                        <th width="18%">Mng.Engineering</th>
                                        <th width="18%">Verifikator<br/><hr/>Tgl.Verifikasi</th>
                                        <th width="18%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>


                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,lpt FROM tbl_sett");
                    list($id_sett, $lpt) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="lpt" required>
                                                                        <option value="' . $lpt . '">' . $lpt . '</option>
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
                        $lpt = $_REQUEST['lpt'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET lpt='$lpt',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=lpt");
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
                                                           b.ttd_kabag ,
                                                           c.nama_verifikator,tgl_verifikasi,
                                                           d.no_agenda 
                                                           FROM tbl_lpt a
                                                           LEFT JOIN tbl_approve_lpt b
                                                           ON a.id_lpt=b.id_lpt 
                                                           LEFT JOIN tbl_verifikasi_lpt c
                                                           ON a.id_lpt=c.id_lpt 
                                                           LEFT JOIN tbl_surat_masuk d 
                                                           ON a.id_lpt=d.id_surat 
                                                           ORDER by id_surat DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            echo '
                                    <tr>
                                    <td>' . $no . '</td>
                                    <td>' . $row['no_lpt'] . '<br/><hr/>' .indoDate ($row['tgl_lpt']) . '</td>
                                    <td><strong>' . $row['no_agenda'] . '</strong></td>
                                    <td>' . $row['nama_tk'] . '<br/><hr/>' . $row['nama_perusahaan'] . '</td>
                                    <td>' . $row['peminta'] . '<br/><hr/>' . $row['lokasi_pengerjaan'] . '</td>
                                    <td>' . $row['jenis_pekerjaan'] . '<br/><hr/>' . $row['pekerjaan'] . '</td>
                                    <td>';
                                        if (!empty($row['ttd_kabag'])) {
                                            echo ' <strong>' . $row['ttd_kabag'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Manager Kosong</i></font>';
                                        } echo '
                                        
                                    </td>
                                    <td>';
                                        if (!empty($row['nama_verifikator'])) {
                                            echo ' <strong>' . $row['nama_verifikator'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Verifikator Kosong</i></font>';
                                        } echo '
                                        
                                        <br/><hr/>';
                                         if (!empty($row['tgl_verifikasi'])) {
                                            echo ' <strong>' . indoDate($row['tgl_verifikasi']) . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Tgl.Kosong</i></font>';
                                        } echo '
                                    </td>
                                    <td>';
                                    
                            //kabag teknik
                           if ($_SESSION['admin'] == 4) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="E-LPT Kosong" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_turned_in</i>Kosong</a>';
                                } else {
                                    echo '<a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approval E-LPT" href="?page=app_lpt_v&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_ind</i>Approval</a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>Lihat E-LPT</a>';
                                }
                            }
                            
                            //tenant relation
                            if ($_SESSION['admin'] == 3) {
                                if ($_SESSION['admin']==3) {
                                    echo '<a class="btn small blue waves-effect waves-light tooltipped" data-position="left" data-tooltip="Verifikasi E-LPT" href="?page=lpt&act=verifikasi&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">touch_app</i></a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>';
                              
                                }
                            }
                            
                            //admin teknik & GM
                            if ($_SESSION['admin'] == 2 |$_SESSION['admin'] == 7) {
                                if ($_SESSION['admin']){
                                    echo '  <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>';
                                }
                            }
                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=lpt&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_lpt");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=lpt&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=lpt&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=lpt&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=lpt&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=lpt&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=lpt&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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