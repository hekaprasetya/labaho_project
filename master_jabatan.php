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

        if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 2 and $_SESSION['admin'] != 3 and $_SESSION['admin'] != 4 and $_SESSION['admin'] != 5 and $_SESSION['admin'] != 6 and $_SESSION['admin'] != 7 and $_SESSION['admin'] != 8 and $_SESSION['admin'] != 9 and $_SESSION['admin'] != 10 and $_SESSION['admin'] != 11 and $_SESSION['admin'] != 12 and $_SESSION['admin'] != 13 and $_SESSION['admin'] != 14 and $_SESSION['admin'] != 15) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_master_jabatan.php";
                        break;
                    case 'hapus':
                        include "hapus_master_jabatan.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT master_jabatan FROM tbl_sett");
                list($master_jabatan) = mysqli_fetch_array($query);

                //pagging
                $limit = $master_jabatan;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=master_jabatan&act=add" class="judul"><i class="material-icons">business_center</i> Master Jabatan</a></li>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=master_jabatan&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>

                                        </ul>

                                    </div>
                                    <div class="col s4 show-on-medium-and-up">
                                        <form method="post" action="?page=master_jabatan">
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
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=master_jabatan"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th>No</th>
                                        <th width="50%">Jabatan</th>
                                        <th width="50%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //script untuk mencari data
                                    $query = mysqli_query($config, "SELECT * FROM master_jabatan  WHERE jabatan LIKE '%$cari%'
                                                                                  ORDER by id_jabatan DESC");
                                    if (mysqli_num_rows($query) > 0) {
                                        $no = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><strong><?= $row['jabatan'] ?></strong></td>
                                                <td>
                                                    <?php
                                                    if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8) {
                                                        if ($_SESSION['admin']) {
                                                    ?>

                                                            <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Data" href="?page=master_jabatan&act=hapus&id_jabatan=<?= $row['id_jabatan'] ?>">
                                                                <i class="material-icons">delete</i></a>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?><tr>
                                            <td colspan="5">
                                                <center>
                                                    <p class="add">Tidak ada data yang ditemukan</p>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table><br /><br />
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
                                <th>No</th>
                                <th>Jabatan</th>
                                <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                <div id="modal" class="modal">
                                    <div class="modal-content white">
                                        <h5>Jumlah data yang ditampilkan per halaman</h5>

                                        <?php
                                        $query = mysqli_query($config, "SELECT id_sett,master_jabatan FROM tbl_sett");
                                        list($id_sett, $master_jabatan) = mysqli_fetch_array($query);
                                        ?>
                                        <div class="row">
                                            <form method="post" action="">
                                                <div class="input-field col s12">
                                                    <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                    <div class="input-field col s1" style="float: left;">
                                                        <i class="material-icons prefix md-prefix">looks_one</i>
                                                    </div>
                                                    <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                        <select class="browser-default validate" name="master_jabatan" required>
                                                            <option value="<?= $master_jabatan ?>"><?= $master_jabatan ?></option>
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
                                                            $master_jabatan = $_REQUEST['master_jabatan'];

                                                            $query = mysqli_query($config, "UPDATE tbl_sett SET master_jabatan='$master_jabatan' WHERE id_sett='$id_sett'");
                                                            if ($query == true) {
                                                                header("Location: ./admin.php?page=master_jabatan");
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
                            $query = mysqli_query($config, "SELECT * FROM master_jabatan ORDER by id_jabatan DESC LIMIT $curr, $limit");
                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                            ?>
                                    <tr>
                                       
                                        <td><center><?= $no ?></center></td>
                                        <td><center><strong><?= $row['jabatan'] ?></strong></center></td>
                                        <td><center>
                                            <?php
                                            if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 |$_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                            ?>

                                                    <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Data" href="?page=master_jabatan&act=hapus&id_jabatan=<?= $row['id_jabatan'] ?>">
                                                        <i class="material-icons">delete</i></a>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </center>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5">
                                        <center>
                                            <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=master_jabatan&act=add">Tambah data baru</a></u></p>
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
                        $query = mysqli_query($config, "SELECT * FROM master_jabatan");
                        $cdata = mysqli_num_rows($query);
                        $cpg = ceil($cdata / $limit);
                ?>
                <br /><!-- Pagination START -->
                <ul class="pagination">
    <?php
                        if ($cdata > $limit) {

                            //first and previous pagging
                            if ($pg > 1) {
                                $prev = $pg - 1;
                                echo '<li><a href="?page=master_jabatan&pg=1"><i class="material-icons md-48">first_page</i></a></li>
    <li><a href="?page=master_jabatan&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                            } else {
                                echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                            }

                            //perulangan pagging
                            for ($i = 1; $i <= $cpg; $i++) {
                                if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                    if ($i == $pg)
                                        echo '<li class="active waves-effect waves-dark"><a href="?page=master_jabatan&pg=' . $i . '"> ' . $i . ' </a></li>';
                                    else
                                        echo '<li class="waves-effect waves-dark"><a href="?page=master_jabatan&pg=' . $i . '"> ' . $i . ' </a></li>';
                                }
                            }

                            //last and next pagging
                            if ($pg < $cpg) {
                                $next = $pg + 1;
                                echo '<li><a href="?page=master_jabatan&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
    <li><a href="?page=master_jabatan&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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