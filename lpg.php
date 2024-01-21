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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 15) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_lpg.php";
                        break;
                    case 'edit':
                        include "edit_lpg.php";
                        break;
                    case 'app_lpg':
                        include "approve_lpg.php";
                        break;
                }
            } else {

                if (isset($_REQUEST['submita'])) {
                    //print_r($_POST);die;
                    $id_lpg = $_REQUEST['id_lpg'];
                    $query = mysqli_query($config, "SELECT * FROM tbl_approve_lpg WHERE id_lpg='$id_lpg'");
                    $no = 1;
                    list($id_lpg) = mysqli_fetch_array($query);
                    {

                        $status_app_lpg = $_POST['status_app_lpg'];
                        $id_lpg = $_REQUEST['id_lpg'];
                        $id_user = $_SESSION['id_user'];
                        $cek_data_qry = mysqli_query($config, "select * from tbl_approve_lpg where id_lpg='$id_lpg'");
                        $cek_data = mysqli_num_rows($cek_data_qry);
                        $cek_data_row = mysqli_fetch_array($cek_data_qry);
                        if ($cek_data == 0) {
                            $query = mysqli_query($config, "INSERT INTO tbl_approve_lpg(status_app_lpg,id_lpg,id_user)
                                        VALUES('$status_app_lpg','$id_lpg','$id_user')");
                        } else {
                            $query = mysqli_query($config, "UPDATE tbl_approve_lpg SET
                        status_app_lpg='$status_app_lpg',
                        id_lpg='$id_lpg',
                        id_user='$id_user'
                        WHERE id_approve_lpg=$cek_data_row[id_approve_lpg]");
                        }

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            echo '<script language="javascript">
                                                window.location.href="./admin.php?page=lpg";
                                              </script>';
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    }
                } else {
                    $query = mysqli_query($config, "SELECT lpg FROM tbl_sett");
                    list($lpg) = mysqli_fetch_array($query);

                    //pagging
                    $limit = $lpg;
                    $pg = @$_GET['pg'];
                    if (empty($pg)) {
                        $curr = 0;
                        $pg = 1;
                    } else {
                        $curr = ($pg - 1) * $limit;
                    }
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=lpg" class="judul"><i class="material-icons">mail</i>E-LPG</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=lpg&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=lpg">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=lpg"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr><th>No</th>
                                     <th width="20%">No.LPG<br/><hr/>Tgl.LPG</th>
                                         <th width="20%">No.PMK</th>
                                         <th width="20%">Nama Perusahaan<br/><hr/>Lokasi</th>
                                          <th width="20%">Jenis Pekerjaan</th>
                                         <th width="20%">Status Kepala Bagian</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                    //script untuk mencari data
                     
                          $query = mysqli_query($config, "SELECT a.*, 
                                                           b.no_agenda,indeks,asal_surat,
                                                           c.id_approve_lpg,status_app_lpg
                                                           FROM tbl_lpg a
                                                           LEFT JOIN tbl_surat_masuk b
                                                           ON a.id_surat=b.id_surat
                                                           LEFT JOIN tbl_approve_lpg c
                                                           ON a.id_lpg=c.id_lpg
                                                           WHERE no_lpg LIKE '%$cari%'or
                                                                 tgl_lpg LIKE '%$cari%' or 
                                                                 indeks LIKE '%$cari%' or 
                                                                 asal_surat LIKE '%$cari%' or 
                                                                 pekerjaan_lpg LIKE '%$cari%' ORDER by id_lpg DESC");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;

                            echo '
                                  <tr>
                                   <td>' . $no . '</td>
                                    <td><strong>' . $row['no_lpg'] . '</strong><br/><hr/>' . indoDate($row['tgl_lpg']) . '</td>
                                    <td>' . $row['no_agenda'] . '</td>
                                    <td>' . $row['indeks'] . '<br/><hr/>' . $row['asal_surat'] . '</td>
                                    <td>' . $row['pekerjaan_lpg'] . '</td>
                                    <td>';
                                        if (!empty($row['status_app_lpg'])) {
                                            echo ' <strong>' . $row['status_app_lpg'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Kabag Kosong</i></font>';
                                        } echo '
                                        
                                    </td>
                                    <td>';
                            
                            if ($_SESSION['admin'] == 15) {
                                if (is_null($row['id_approve_lpg'])) {
                                    echo '
                                       <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=lpg&act=app_lpg&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons"></i>Approve</a>';
                                } else {
                                    echo '
                                       <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=lpg&act=app_lpg&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons">check</i>done</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }
                            

                            if ($_SESSION['admin'] == 12) {
                                if ($_SESSION['admin'] == 12) {
                                    echo '<a class="btn small blue waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit LPG" href="?page=lpg&act=edit&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons">edit</i>Edit</a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print LPG" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>Print</a>';
                               
                                }
                            }
                            
                             if ($_SESSION['admin'] == 7) {
                                if ($_SESSION['admin'] == 7) {
                                    echo '
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print LPG" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>Print</a>';
                                } else {
                                    $query = mysqli_query($config, "UPDATE tbl_approve_lpg SET
                                status_app_lpg='$status_app_lpg', id_lpg='$id_lpg', id_user='$id_user' WHERE id_approve_lpg=$cek_data_row[id_approve_lpg]");
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
                                         <th width="20%">No.LPG<br/><hr/>Tgl.LPG</th>
                                         <th width="20%">No.PMK</th>
                                         <th width="20%">Nama Perusahaan<br/><hr/>Lokasi</th>
                                          <th width="20%">Jenis Pekerjaan</th>
                                         <th width="20%">Status Kepala Bagian</th>
                                        <th width="20%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                    $query = mysqli_query($config, "SELECT id_sett,lpg FROM tbl_sett");
                    list($id_sett, $lpg) = mysqli_fetch_array($query);
                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="' . $id_sett . '" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="lpg" required>
                                                                        <option value="' . $lpg . '">' . $lpg . '</option>
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
                        $lpg = $_REQUEST['lpg'];
                        $id_user = $_SESSION['id_user'];

                        $query = mysqli_query($config, "UPDATE tbl_sett SET lpg='$lpg',id_user='$id_user' WHERE id_sett='$id_sett'");
                        if ($query == true) {
                            header("Location: ./admin.php?page=lpg");
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
                    $query = mysqli_query($config, $query = "SELECT a.*, 
                                                           b.no_agenda,indeks,asal_surat,
                                                           c.id_approve_lpg,status_app_lpg
                                                           FROM tbl_lpg a
                                                           LEFT JOIN tbl_surat_masuk b
                                                           ON a.id_surat=b.id_surat
                                                           LEFT JOIN tbl_approve_lpg c
                                                           ON a.id_lpg=c.id_lpg
                                                           ORDER by id_surat DESC LIMIT $curr, $limit");
                    if (mysqli_num_rows($query) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            echo '
                                    <tr>
                                    <td>' . $no . '</td>
                                    <td><strong>' . $row['no_lpg'] . '</strong><br/><hr/>' . indoDate($row['tgl_lpg']) . '</td>
                                    <td><strong>' . $row['no_agenda'] . '</strong></td>
                                    <td>' . $row['indeks'] . '<br/><hr/>' . $row['asal_surat'] . '</td>
                                    <td><i>' . $row['pekerjaan_lpg'] . '</i></td>
                                    <td>';
                                        if (!empty($row['status_app_lpg'])) {
                                            echo ' <strong>' . $row['status_app_lpg'] . '</a></strong>';
                                        } else {
                                            echo '<font color="red"><i>Kabag Kosong</i></font>';
                                        } echo '
                                        
                                    </td>
                                    <td>';

                            if ($_SESSION['admin'] == 15) {
                                if (is_null($row['id_approve_lpg'])) {
                                    echo '
                                       <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=lpg&act=app_lpg&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons"></i>Approve</a>';
                                } else {
                                    echo '
                                       <a class="btn small light-brown waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=lpg&act=app_lpg&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons">check</i>done</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>';
                                }
                            }

                            if ($_SESSION['admin'] == 12) {
                                if ($_SESSION['admin'] == 12) {
                                    echo '<a class="btn small blue waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit LPG" href="?page=lpg&act=edit&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons">edit</i>Edit</a>
                                          <a class="btn small green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Tambah Detail Barang" href="?page=lpg&act=edit&id_lpg=' . $row['id_lpg'] . '">
                                                <i class="material-icons">edit</i>Edit</a>
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print LPG" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>Print</a>';
                                
                                }
                            }
                            
                             if ($_SESSION['admin'] == 7) {
                                if ($_SESSION['admin'] == 7) {
                                    echo '
                                          <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print LPG" href="?page=ctk_lpg&id_lpg=' . $row['id_lpg'] . '" target="_blank">
                                                <i class="material-icons">print</i>Print</a>';
                                }
                            }
                            

                            echo '
                                      </td>
                                    </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=lpg&act=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_lpg");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if ($cdata > $limit) {

                        //first and previous pagging
                        if ($pg > 1) {
                            $prev = $pg - 1;
                            echo '<li><a href="?page=lpg&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=lpg&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg)
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=lpg&pg=' . $i . '"> ' . $i . ' </a></li>';
                                else
                                    echo '<li class="waves-effect waves-dark"><a href="?page=lpg&pg=' . $i . '"> ' . $i . ' </a></li>';
                            }
                        }

                        //last and next pagging
                        if ($pg < $cpg) {
                            $next = $pg + 1;
                            echo '<li><a href="?page=lpg&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=lpg&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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