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
            ?><script language="javascript">
                window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                window.location.href = "./logout.php";
            </script>
            <?php
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_master_kendaraan.php";
                        break;
                    case 'edit':
                        include "edit_master_kendaraan.php";
                        break;
                    case 'del':
                        include "hapus_master_kendaraan.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT master_kendaraan FROM tbl_sett");
                list($master_kendaraan) = mysqli_fetch_array($query);

                //pagging
                $limit = $master_kendaraan;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=master_kendaraan&act=add" class="judul"><i class="material-icons md-3">directions_car</i> Master Kendaraan</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=master_kendaraan&act=add"><i class="material-icons md-30">add_circle</i>Tambah Data</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-med-and-down search right">
                                    <form method="post" action="?page=master_kendaraan">
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
                // membuat varibel untuk mengambil data
                $query_master_kendaraan = "SELECT * FROM master_kendaraan ";
                ?>
                <?php
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=master_kendaraan"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered centered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kendaraan</th>
                                    <th>Plat Nomer</th>
                                    <th>Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk mencari data
                                // menambahkan untuk variabel query untuk mencari
                                $query_master_kendaraan .= "WHERE kendaraan LIKE '%$cari%' 
                                    OR nopol LIKE '%$cari%' 
                                    ORDER by id_kendaraan DESC";
                                // meenggunakan fuction query
                                $result = mysqli_query($config, $query_master_kendaraan);

                                if (empty($result)) {
                                    $id = $row->id_kendaraan;
                                    ?><tr>
                                        <td colspan="5">
                                <center>
                                    <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=master_kendaraan&act=add">Tambah data baru</a></u></p>
                                </center>
                                </td>
                                </tr>
                                <?php
                            } else {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id_kendaraan'];
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row['kendaraan'] ?> </td>
                                        <td><?= $row['nopol'] ?></td>
                                        <td>
                                            <div class="social-icons">
                                                <div class="social-icons-image">
                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=master_kendaraan&act=edit&id_kendaraan=<?= $id ?>">
                                                        <i class="md-30 material-icons">edit</i></a>
                                                </div>
                                                <div class="social-icons-image">
                                                    <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=master_kendaraan&act=del&id_kendaraan=<?= $id ?>">
                                                        <i class="md-30 material-icons">delete</i></a>
                                                </div>
                                                <!-- <div class="social-icons-image">
                                                    <a class="btn small disables">
                                                        <i class="md-30 material-icons">view_carousel</i></a>
                                                </div> -->
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Row form END -->
                <?php
            } else {
                ?>
                <div class="col m12" id="colres">
                    <table class="bordered centered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Nama Kendaraan</th>
                                <th width="25%">Plat Nomer</th>
                                <th width="25%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                        <div id="modal" class="modal">
                            <div class="modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,master_kendaraan FROM tbl_sett");
                                list($id_sett, $master_kendaraan) = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="master_kendaraan" required>
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
                                                    $master_kendaraan = $_REQUEST['master_kendaraan'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET master_kendaraan='$master_kendaraan' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=master_kendaraan");
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
                            // menambahkan untuk variabel query untuk mencari
                            $query_master_kendaraan .= "ORDER by id_kendaraan DESC LIMIT $curr, $limit";
                            // meenggunakan fuction query
                            $result = mysqli_query($config, $query_master_kendaraan);
                            $cek = mysqli_num_rows($result);
                            if (empty($cek)) {
                                ?><tr>
                                    <td colspan="5">
                            <center>
                                <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=master_kendaraan&act=add">Tambah data baru</a></u></p>
                            </center>
                            </td>
                            </tr>
                            <?php
                        } else {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id_kendaraan'];
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['kendaraan'] ?> </td>
                                    <td><?= $row['nopol'] ?></td>
                                    <td>
                                        <div class="social-icons">
                                                <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=master_kendaraan&act=edit&id_kendaraan=<?= $id ?>">
                                                    <i class="md-11 material-icons">edit</i></a>
                                                <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=master_kendaraan&act=del&id_kendaraan=<?= $id ?>">
                                                    <i class="md-11 material-icons">delete</i></a>
                                            <!-- <div class="social-icons-image">
                                                <a class="btn small disables">
                                                    <i class="md-30 material-icons">view_carousel</i></a>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>


                    <!-- Row form END -->
                    <?php
                    $query = mysqli_query($config, "SELECT * FROM master_kendaraan");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);
                    ?><br /><!-- Pagination START -->
                    <ul class="pagination">
                        <?php
                        if ($cdata > $limit) {

                            //first and previous pagging
                            if ($pg > 1) {
                                $prev = $pg - 1;
                                ?><li><a href="?page=master_kendaraan&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                <li><a href="?page=master_kendaraan&pg= <?= $prev ?>"><i class="material-icons md-48">chevron_left</i></a></li>
                                <?php
                            } else {
                                ?><li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>
                                <?php
                            }

                            //perulangan pagging
                            for ($i = 1; $i <= $cpg; $i++) {
                                if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                    if ($i == $pg) {
                                        ?><li class="active waves-effect waves-dark"><a href="?page=master_kendaraan&pg= <?= $i ?>"> <?= $i ?> </a></li>
                                            <?php
                                        } else {
                                            ?><li class="waves-effect waves-dark"><a href="?page=master_kendaraan&pg=<?= $i ?>"> <?= $i ?> </a></li>
                                            <?php
                                        }
                                    }
                                }
                                //last and next pagging
                                if ($pg < $cpg) {
                                    $next = $pg + 1;
                                    ?><li><a href="?page=master_kendaraan&pg=<?= $next ?>"><i class="material-icons md-48">chevron_right</i></a></li>
                                <li><a href="?page=master_kendaraan&pg=<?= $cpg ?>"><i class="material-icons md-48">last_page</i></a></li>
                                <?php
                            } else {
                                ?><li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                                <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>
                                    <?php
                                }
                                ?>
                        </ul>
                        <?php
                    } else {
                        echo '';
                    }
                }
            }
        }
    }
    ?>
</div>