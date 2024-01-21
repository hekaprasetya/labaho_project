
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13  AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15 AND $_SESSION['admin'] != 17 AND $_SESSION['admin'] != 18) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_surat_masuk.php";
                        break;
                    case 'edit':
                        include "edit_surat_masuk.php";
                        break;
                    case 'disp':
                        include "disposisi.php";
                        break;
                     case 'app_gm':
                        include "approve_pmk_gm.php";
                        break;
                    case 'lpt':
                        include "lpt.php";
                        break;
                    case 'edit':
                        include "edit_lpt.php";
                        break;
                    case 'print':
                        include "cetak_disposisi.php";
                        break;
                    case 'del':
                        include "hapus_surat_masuk.php";
                        break;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=tsm" class="judul"><i class="material-icons">mail</i>P M K</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=tsm&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
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
                <nav class="secondary-nav yellow darken-3">
                    <form method="post" action="?page=tsm">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=tsm"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr><th>No</th>
                                    <th width="5%">No.PMK<br/><hr/>Status</th>
                                    <th width="40%">Jenis Pekerjaan<br/><hr/>File</th>
                                    <th width="15%">Lokasi<br/><hr/>Nama Perusahaan</th>
                                    <th width="10%">Ditujukan Kepada<br/><hr/>Tgl.Surat</th>
                                     <th width="10%">Disetujui.Mng<br/><hr/>Diketahui.GM</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                      $query = mysqli_query($config, "SELECT a.*,
                                                           b.manager_mkt,
                                                           c.id_lpt,
                                                           d.id_approve_gm,gm,
                                                           e.id_lpg
                                                           FROM tbl_surat_masuk a
                                                            LEFT JOIN tbl_disposisi b 
                                                           ON a.id_surat=b.id_surat 
                                                            LEFT JOIN tbl_lpt c 
                                                           ON a.id_surat=c. id_surat
                                                            LEFT JOIN tbl_approve_gm d
                                                           ON a.id_surat=d.id_surat
                                                            LEFT JOIN tbl_lpg e
                                                           ON a.id_surat=e.id_surat
                                                           
                                                           WHERE 
                                                           no_agenda LIKE '%$cari%'or
                                                           isi LIKE '%$cari%'or 
                                                           divisi LIKE '%$cari%' or 
                                                           gm LIKE '%$cari%' or
                                                           indeks LIKE '%$cari%' 
                                                           ORDER by id_surat DESC");
                    if (mysqli_num_rows($query) > 0) {
                         $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                        
                            echo '
                                  <tr>
                                    <td>' . $no . '</td>
                                    <td>' . $row['no_agenda'] . '<br/><hr/>' . $row['status'] . '</td>
                                   <td>' . nl2br(htmlentities($row['isi'])) . '<br/><br/><strong>File :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=gsm&act=fsm&id_surat=' . $row['id_surat'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '</td>
                                    <td>' . $row['asal_surat'] . '<br/><hr/>' . $row['indeks'] . '</td>
                                    <td>' . $row['divisi'] . '<br/><hr/>' . indoDate($row['tgl_surat']) . '</td>
                                    <td>';
                                        if (!empty($row['manager_mkt'])) {
                                            echo ' <strong>' . $row['manager_mkt'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Manager Kosong</i></font>';
                                        } echo '
                                        
                                        <br/><hr/>';
                                         if (!empty($row['gm'])) {
                                            echo ' <strong>' . $row['gm'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>GM Kosong</i></font>';
                                        } echo '
                                    </td>
                                        
                                   <td>';

                            //admin teknik
                            if ($_SESSION['admin'] == 2) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=tlpt&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">description</i>E-LPT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                } else {
                                    echo '<a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                          <a class="btn small blue waves-effect waves-light tooltiped" data-position="left" data-tooltip="Pilih untuk Edit" href="?page=lpt&act=edit&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">edit</i>EDIT</a>';
                                }
                            }
                            
                            //kabag teknik
                           if ($_SESSION['admin'] == 4) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="E-LPT Kosong" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_turned_in</i>Kosong</a>';
                                } else {
                                    echo '<a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approval E-LPT" href="?page=app_lpt_v&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_ind</i>Approval</a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a>';
                                }
                            }
                            
                            //tenant relation
                            if ($_SESSION['admin'] == 3) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Kosong" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">edit</i>EDIT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                } else {
                                    echo '<a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Done" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                          <!--a class="btn small blue waves-effect waves-light tooltipped" data-position="left" data-tooltip="Verifikasi LPT" href="?page=lpt&act=edit&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">aassignment</i>Verifikasi</a-->
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">edit</i>EDIT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }
                            
                            //keuangan,facility,markerting
                            if ($_SESSION['admin'] == 5|$_SESSION['admin'] == 6|$_SESSION['admin'] == 11|$_SESSION['admin'] == 18) {
                                if ($_SESSION['admin']){
                                    echo '<a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>';
                                }
                            }
                            
                            //gudang
                             if ($_SESSION['admin'] == 12) {
                                if (is_null($row['id_lpg'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Buat LPG" href="?page=tlpg&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">description</i>LPG</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                } else {
                                    echo '<a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat Ceklist" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>Print</a>
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
                                        <th>No.PMK<br/><hr/>Status PMK</th>
                                        <th>Jenis Pekerjaan<br/><hr/> File</th>
                                        <th>Lokasi<br/><hr/>Nama Perusahaan</th>
                                        <th>Ditujukan Kepada<br/><hr/>Tanggal Surat</th>
                                        <th>Disetujui.Mng<br/><hr/>Diketahui.GM</th>
                                        <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,surat_masuk FROM tbl_sett");
                    list($id_sett, $surat_masuk) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="surat_masuk" required>
                                                                        <option value="' . $surat_masuk . '">' . $surat_masuk . '</option>
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                        <option value="200">200</option>
                                                                        <option value="300">300</option>
                                                                        <option value="400">400</option>
                                                                        <option value="500">400</option>
                                                                        <option value="800">800</option>
                                                                        <option value="1000">1000</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer white">
                                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>';
                    if (isset($_REQUEST['simpan'])) {
                        $id_sett = "1";
                        $surat_masuk = $_REQUEST['surat_masuk'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET surat_masuk='$surat_masuk',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=tsm");
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
                    // $divisi = $_SESSION['divisi'];
                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.manager_mkt,
                                                           c.id_lpt,
                                                           d.id_approve_gm,gm,
                                                           e.id_lpg,
                                                           f.id_user
                                                           
                                                           FROM tbl_surat_masuk a
                                                            LEFT JOIN tbl_disposisi b 
                                                           ON a.id_surat=b.id_surat 
                                                            LEFT JOIN tbl_lpt c 
                                                           ON a.id_surat=c. id_surat
                                                            LEFT JOIN tbl_approve_gm d
                                                           ON a.id_surat=d.id_surat
                                                            LEFT JOIN tbl_lpg e
                                                           ON a.id_surat=e.id_surat
                                                            LEFT JOIN tbl_user f
                                                           ON a.id_user=f.id_user
                                                           
                                                           ORDER by id_surat DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td>' . $row['no_agenda'] . '<br/><hr/>' . $row['status'] . '</td>
                                        <td>' .ucwords(nl2br(htmlentities(strtolower($row['isi'])))). '<br/><br/><strong>File :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=gsm&act=fsm&id_surat=' . $row['id_surat'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '</td>
                                        <td>' . ucwords(strtolower($row['asal_surat'])) . '<br/><hr>' .ucwords(strtolower( $row['indeks'])) . '</td>
                                        <td>' . $row['divisi'] . '<br/><hr/>' . indoDate($row['tgl_surat']) . '</td>
                                         <td>';
                                        if (!empty($row['manager_mkt'])) {
                                            echo ' <strong>' . $row['manager_mkt'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Manager Kosong</i></font>';
                                        } echo '
                                        
                                        <br/><hr/>';
                                         if (!empty($row['gm'])) {
                                            echo ' <strong>' . $row['gm'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>GM Kosong</i></font>';
                                        } echo '
                                        </td>
                                       
                                        <td>';

                            //admin teknik
                            if ($_SESSION['admin'] == 2) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=tlpt&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">description</i>E-LPT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                } else {
                                    echo '<a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                          <a class="btn small blue waves-effect waves-light tooltiped" data-position="left" data-tooltip="Pilih untuk Edit" href="?page=lpt&act=edit&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">edit</i>EDIT</a>';
                                }
                            }
                            
                            //kabag teknik
                           if ($_SESSION['admin'] == 4) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="E-LPT Kosong" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_turned_in</i>Kosong</a>';
                                } else {
                                    echo '<a class="btn small purple waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approval E-LPT" href="?page=app_lpt_v&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">assignment_ind</i>Approval</a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk E-LPT" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a>';
                                }
                            }
                            
                            //tenant relation
                            if ($_SESSION['admin'] == 3) {
                                if (is_null($row['id_lpt'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Kosong" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a></a>
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">edit</i>EDIT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                } else {
                                    echo '<a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="LPT Done" href="?page=ctk_lpt&id_lpt=' . $row['id_lpt'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>E-LPT</a>
                                          <!--a class="btn small blue waves-effect waves-light tooltipped" data-position="left" data-tooltip="Verifikasi LPT" href="?page=lpt&act=edit&id_lpt=' . $row['id_lpt'] . '">
                                                <i class="material-icons">aassignment</i>Verifikasi</a-->
                                          <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PMK" href="?page=tsm&act=edit&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">edit</i>EDIT</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PMK" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }
                            
                            //keuangan,facility,markerting
                            if ($_SESSION['admin'] == 5|$_SESSION['admin'] == 6|$_SESSION['admin'] == 11|$_SESSION['admin'] == 18) {
                                if ($_SESSION['admin']){
                                    echo '<a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                                <i class="material-icons">print</i></a>';
                                }
                            }
                            
                            //gudang
                             if ($_SESSION['admin'] == 12) {
                                if (is_null($row['id_lpg'])) {
                                    echo '<a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Buat LPG" href="?page=tlpg&id_surat=' . $row['id_surat'] . '">
                                                <i class="material-icons">description</i>LPG</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                } else {
                                    echo '<a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat Ceklist" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">assignment_turned_in</i>Print</a>
                                          ';
                                }
                            }
                            
                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=tsm&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=tsm&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=tsm&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=tsm&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=tsm&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=tsm&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=tsm&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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