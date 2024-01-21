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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] !=5 AND $_SESSION['admin'] !=6  AND $_SESSION['admin'] !=7 AND $_SESSION['admin'] !=8 AND $_SESSION['admin'] !=9 AND $_SESSION['admin'] !=10 AND $_SESSION['admin'] !=11 AND $_SESSION['admin'] !=12 AND $_SESSION['admin'] !=13 AND $_SESSION['admin'] !=14 AND $_SESSION['admin'] !=15) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_alat.php";
                        break;
                    case 'edit':
                        include "edit_alat.php";
                        break;
                    case 'del':
                        include "hapus_alat.php";
                        break;
                    case 'pinjam_alat':
                        include "pinjam_alat.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT master_alat FROM tbl_sett");
                list($master_alat) = mysqli_fetch_array($query);

                //pagging
                $limit = $master_alat;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=master_alat&act=add" class="judul"><i class="material-icons md-3">build</i>Master Alat</a></li>
                                         <li class="waves-effect waves-light">
                                            <a href="?page=t_pinjam_alat"><i class="material-icons md-3">add_circle</i>Pinjam Alat</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-med-and-down">
                                    <form method="post" action="?page=master_alat">
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
                <!-- Secondary Nav START -->
                <!-- Secondary Nav END -->
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
              <div class="row">
                <div class="col s7">
                <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Cek Alat"  href="?page=pinjam_alat">
                  <i class="material-icons">check</i> CEK RIWAYAT PINJAM</a>
                </div>
                </div>
            <!-- Row form Start -->
            <div class="row jarak-form">

                <?php
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=master_alat"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                        <th width="15%">No.Alat</th>
                                        <th width="20%">Nama Alat</th>
                                        <th width="10%">Jumlah</th>
                                        <th width="15%">Kondisi</th>
                                        <th width="15%">Foto</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                    $query = mysqli_query($config, "SELECT * FROM tbl_alat  WHERE nama_alat LIKE '%$cari%' or jumlah LIKE '%$cari%' or kondisi LIKE '%$cari%' ORDER by id_alat DESC");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_array($query)) {
                            echo '
                                  <tr>
                                   <td>' . $no . '</td>
                                        <td><strong>' . $row['no_alat'] . '</strong></td>
                                        <td>' . ucwords(nl2br(htmlentities(strtolower($row['nama_alat'])))) . '</td>
                                        <td>' . $row['jumlah'] . '</td>
                                        <td>' . ucwords(nl2br(htmlentities(strtolower($row['kondisi'])))) . '</td>
                                   <td><strong>Foto :</strong>';
                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=galeri_alat&act=file_alat&id_alat=' . $row['id_alat'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '</td>
                                   <td>';

                            if ($_SESSION['admin'] == 2|$_SESSION['admin'] == 3|$_SESSION['admin'] == 4|$_SESSION['admin'] == 5|$_SESSION['admin'] == 6|$_SESSION['admin'] == 8|$_SESSION['admin'] == 9|$_SESSION['admin'] == 10|$_SESSION['admin'] == 11|$_SESSION['admin'] == 13|$_SESSION['admin'] == 14|$_SESSION['admin'] == 15) {
                            if ($_SESSION['admin']) {
                                    echo ' 
                                        <!--a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Cek Alat"  href="?page=pinjam_alat">
                                                <i class="material-icons">check</i></a-->';
                                        
                                }
                            }
                            
                            
                            if ($_SESSION['admin'] == 7|$_SESSION['admin'] == 12) {
                                if ($_SESSION['admin']) {
                                    echo ' 
                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=master_alat&act=edit&id_alat=' . $row['id_alat'] . '">
                                                <i class="material-icons">edit</i></a>
                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat"  href="?page=master_alat&act=del&id_alat=' . $row['id_alat'] . '">
                                                <i class="material-icons">delete</i></a>
                                        <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Cek Alat"  href="?page=pinjam_alat">
                                                <i class="material-icons">check</i></a>';
                                        
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
                                        <th width="15%">No. Alat</th>
                                        <th width="20%">Nama Alat</th>
                                        <th width="10%">Jumlah</th>
                                        <th width="15%">Kondisi</th>
                                        <th width="15%">Foto</th>
                                        <th width="18%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,master_alat FROM tbl_sett");
                    list($id_sett, $master_alat) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="master_alat" required>
                                                                        <option value="' . $master_alat . '">' . $master_alat . '</option>
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
                        $master_alat = $_REQUEST['master_alat'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET master_alat='$master_alat',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=master_alat");
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
                    
                    $query = mysqli_query($config, "SELECT * FROM tbl_alat ORDER by id_alat DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;

                            echo '
                                      <tr>
                                        <td>' . $no . '</td>
                                        <td><strong>' . $row['no_alat'] . '</strong></td>
                                        <td>' . ucwords(nl2br(htmlentities(strtolower($row['nama_alat'])))) . '</td>
                                        <td>' . $row['jumlah'] . '</td>
                                        <td>' . ucwords(nl2br(htmlentities(strtolower($row['kondisi'])))) . '</td>
                                        <td>Foto :</strong>';

                            if (!empty($row['file'])) {
                                echo ' <strong><a href="?page=galeri_alat&act=file_alat&id_alat=' . $row['id_alat'] . '">' . $row['file'] . '</a></strong>';
                            } else {
                                echo '<em>Tidak ada file yang di upload</em>';
                            } echo '</td>
                                        <td>';
                            
                            if ($_SESSION['admin'] == 2|$_SESSION['admin'] == 3|$_SESSION['admin'] == 4|$_SESSION['admin'] == 5|$_SESSION['admin'] == 6|$_SESSION['admin'] == 8|$_SESSION['admin'] == 9|$_SESSION['admin'] == 10|$_SESSION['admin'] == 11|$_SESSION['admin'] == 13|$_SESSION['admin'] == 14|$_SESSION['admin'] == 15) {
                            if ($_SESSION['admin']) {
                                    echo ' 
                                        <!--a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Cek Alat"  href="?page=pinjam_alat">
                                                <i class="material-icons">check</i></a-->';
                                        
                                }
                            }
                            
                            
                            if ($_SESSION['admin'] == 7|$_SESSION['admin'] == 12) {
                                if ($_SESSION['admin']) {
                                    echo ' 
                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=master_alat&act=edit&id_alat=' . $row['id_alat'] . '">
                                                <i class="material-icons">edit</i></a>
                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat"  href="?page=master_alat&act=del&id_alat=' . $row['id_alat'] . '">
                                                <i class="material-icons">delete</i></a>
                                        <!--a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Cek Alat"  href="?page=pinjam_alat">
                                                <i class="material-icons">check</i></a-->';
                                        
                                }
                            }
                            
                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=master_alat&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_alat");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=master_alat&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=master_alat&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=master_alat&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=master_alat&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=master_alat&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=master_alat&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
