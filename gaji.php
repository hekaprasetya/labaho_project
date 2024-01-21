<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Interior Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
          Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
     <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>

    <?php
    //cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15 AND $_SESSION['admin'] != 17) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_gaji.php";
                        break;
                    case 'edit':
                        include "edit_gaji.php";
                        break;
                    case 'del':
                        include "hapus_gaji.php";
                        break;
                    case 'print':
                        include "cetak_gaji.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT gaji FROM tbl_sett");
                list($gaji) = mysqli_fetch_array($query);

                //pagging
                $limit = $gaji;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=gaji" class="judul"><i class="material-icons"></i>E-GAJI</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=gaji&act=add"><i class="material-icons md-24">add_circle</i> Tambah</a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=gaji">
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
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=gaji"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered striped centered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr><th>No</th>
                                    <th width="20%">Nama</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="50%">File</th>
                                    <th width="15%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //script untuk mencari data
                                $query = mysqli_query($config, "SELECT * From tbl_gaji
                                                                       
                                                                WHERE 
                                                                nama LIKE '%$cari%' 
                                                                ORDER by id_gaji DESC ");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><i><?= $row['nama'] ?></td>
                                                        <td><?= indoDate($row['tgl']) ?></td>
                                                        <td>
                                                            <?php
                                                            if (!empty($row['file'])) {
                                                                ?>
                                                                <strong><a href="/./upload/gaji/<?= $row['file'] ?>"><img src="/./upload/gaji/<?= $row['file'] ?>" style="width: 70px"></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <em>Tidak ada file</em>
                                                                <?php
                                                            }
                                                            ?></td>
                                                        <td>
                                                            <?php
                                                            if ($_SESSION['admin'] == 15) {
                                                                if ($_SESSION['admin']) {
                                                                    ?>
                                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=gaji&act=edit&id_gaji=<?= $row['id_gaji'] ?>">
                                                                        <i class="material-icons">edit</i></a>
                                                                     <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus" onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=gaji&act=del&id_gaji=<?= $row['id_gaji'] ?>">
                                                                        <i class="material-icons">delete</i>
                                                                        </a>
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
                                                    <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=gaji&act=add">Tambah data baru</a></u></p></center></td></tr>
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
                                                    <table class="bordered striped centered" id="tbl">
                                                        <thead class="blue lighten-4" id="head">

                                                            <tr>
                                                                <th>No</th>
                                                                <th width="30%">Nama</th>
                                                                <th width="30%">Tanggal</th>
                                                                <th width="25%">File</th>
                                                                <th width="15%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                                        <div id="modal" class="modal">
                                                            <div class="modal-content white">
                                                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                                                <?php
                                                                $query = mysqli_query($config, "SELECT id_sett,gaji FROM tbl_sett");
                                                                list($id_sett, $gaji) = mysqli_fetch_array($query);
                                                                ?>
                                                                <div class="row">
                                                                    <form method="post" action="">
                                                                        <div class="input-field col s12">
                                                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                                            <div class="input-field col s1" style="float: left;">
                                                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                                                            </div>
                                                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                                <select class="browser-default validate" name="gaji" required>
                                                                                    <option value="<?= $gaji ?>"><?= $gaji ?></option>
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
                                                                                    $gaji = $_REQUEST['gaji'];
                                                                                    $id_user = $_SESSION['id_user'];

                                                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET gaji='$gaji',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                                    if ($query == true) {
                                                                                        header("Location: ./admin.php?page=gaji");
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

                                                            $query = mysqli_query($config, "SELECT * FROM tbl_gaji
                                                                                                    
                                                                                                    ORDER by id_gaji DESC LIMIT $curr, $limit");
                                                            if (mysqli_num_rows($query) > 0) {
                                                                $no = 0;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                    $no++;
                                                                    ?>

                                                                    <?php
                                                                    //**KARYAWAN 
                                                                    if ($_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 10 |$_SESSION['admin'] == 12) {
                                                                        if ($_SESSION['admin']) {
                                                                            ?>
                                                                            <?php
                                                                            //script untuk menampilkan data
                                                                            $nama = $_SESSION['nama'];
                                                                            $query = mysqli_query($config, "SELECT * FROM tbl_gaji
                                                                                                    
                                                                                                    WHERE nama='$nama'
                                                                                                    ORDER by id_gaji DESC LIMIT $curr, $limit");
                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                $no = 0;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                    $no++;
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?= $no ?></td>
                                                                                        <td><strong><i><?= $row['nama'] ?></td>
                                                                                                    <td><?= indoDate($row['tgl']) ?></td>
                                                                                                    <td><?php
                                                                                                        if (!empty($row['file'])) {
                                                                                                            ?>
                                                                                                            <a class="file-1"  href="/./upload/gaji/<?= $row['file'] ?>" target="_blank"><i class="material-icons medium">insert_drive_file</i> File :<?= $row['file'] ?></a>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                            <em>Tidak ada file yang di upload</em>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                    </td>
                                                                                                    <!--td>
                                                                                                        <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=gaji&act=edit&id_gaji=<?= $row['id_gaji'] ?>">
                                                                                                            <i class="material-icons">edit</i>
                                                                                                        </a>
                                                                                                    </td-->
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }

                                                                                    //**HRD SCENE
                                                                                    if ($_SESSION['admin'] == 15) {
                                                                                        if ($_SESSION['admin']) {
                                                                                            ?>
                                                                                            <?php
                                                                                            //script untuk menampilkan data
                                                                                            $query = mysqli_query($config, "SELECT *FROM tbl_gaji
                                                                                                    
                                                                                                    ORDER by id_gaji DESC LIMIT $curr, $limit");
                                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                                $no = 0;
                                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                                    $no++;
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?= $no ?></td>
                                                                                                        <td><strong><i><?= $row['nama'] ?></td>
                                                                                                                    <td><?= indoDate($row['tgl']) ?></td>
                                                                                                                    <td><?php
                                                                                                                        if (!empty($row['file'])) {
                                                                                                                            ?>
                                                                                                                            <a class="file-1"  href="/./upload/gaji/<?= $row['file'] ?>" target="_blank"><i class="material-icons medium">insert_drive_file</i> File :<?= $row['file'] ?></a>
                                                                                                                            <?php
                                                                                                                        } else {
                                                                                                                            ?>
                                                                                                                            <em>Tidak ada file yang di upload</em>
                                                                                                                            <?php
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    </td>

                                                                                                                    <td>
                                                                                                                        <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=gaji&act=edit&id_gaji=<?= $row['id_gaji'] ?>">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </a>
                                                                                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus" onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=gaji&act=del&id_gaji=<?= $row['id_gaji'] ?>">
                                                                                                                           <i class="material-icons">delete</i>
                                                                                                                        </a>
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
                                                                                                    <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=gaji&act=add">Tambah data</a></u></p>
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
                                                                                            $query = mysqli_query($config, "SELECT * FROM tbl_gaji");
                                                                                            $cdata = mysqli_num_rows($query);
                                                                                            $cpg = ceil($cdata / $limit);

                                                                                            echo '<br/><!-- Pagination START -->
                                                                                            <ul class="pagination">';

                                                                                            if ($cdata > $limit) {

                                                                                                //first and previous pagging
                                                                                                if ($pg > 1) {
                                                                                                    $prev = $pg - 1;
                                                                                                    echo '<li><a href="?page=gaji&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                                                                <li><a href="?page=gaji&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                                                                                                } else {
                                                                                                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                                                                <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                                                                                                }

                                                                                                //perulangan pagging
                                                                                                for ($i = 1; $i <= $cpg; $i++) {
                                                                                                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                                                                                        if ($i == $pg)
                                                                                                            echo '<li class="active waves-effect waves-dark"><a href="?page=gaji&pg=' . $i . '"> ' . $i . ' </a></li>';
                                                                                                        else
                                                                                                            echo '<li class="waves-effect waves-dark"><a href="?page=gaji&pg=' . $i . '"> ' . $i . ' </a></li>';
                                                                                                    }
                                                                                                }

                                                                                                //last and next pagging
                                                                                                if ($pg < $cpg) {
                                                                                                    $next = $pg + 1;
                                                                                                    echo '<li><a href="?page=gaji&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                                                <li><a href="?page=gaji&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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