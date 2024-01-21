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

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 9 AND $_SESSION['admin'] != 10 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15) {
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
                    case 'print':
                        include "cetak_pp.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT dashboard_pp FROM tbl_sett");
                list($dashboard_pp) = mysqli_fetch_array($query);

                //pagging
                $limit = $dashboard_pp;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=dashboard_pp" class="judul"><i class="material-icons"></i>Detail Barang</a></li>
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
                                    </ul>
                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=dashboard_pp">
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
                    <form method="post" action="?page=dashboard_pp">
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
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=dashboard_pp"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                               <tr>
                                <th>No</th>
                                <th width="20%">No.PP</th>
                                <th width="23%">Nama Barang<br/><hr/>Jumlah</th>
                        <th width="15%">Harga<br/><hr/>Jumlah Harga</th>
                        <th width="15%">Keterangan<br/><hr/>Divisi</th>
                        <th width="15%">Tujuan</th>
                        <th width="15%">Status GM<br/><hr/>Status Pembelian</th>
                        <th width="12%">Status Gudang</th>
                            <th width="1%">Option<span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk mencari data
                               $query = mysqli_query($config, "SELECT * FROM tbl_pp_barang
                                                                                             LEFT JOIN tbl_pp
                                                                                             ON tbl_pp_barang.id_pp=tbl_pp.id_pp
                                                                                             LEFT JOIN tbl_gm_pp
                                                                                             ON tbl_pp_barang.id_barang=tbl_gm_pp.id_barang
                                                                                             LEFT JOIN tbl_pembelian
                                                                                             ON tbl_pp_barang.id_pp=tbl_pembelian.id_pp
                                                                                             LEFT JOIN tbl_pp_gudang
                                                                                             ON tbl_pp_barang.id_barang=tbl_pp_gudang.id_barang
                                                                                             LEFT JOIN tbl_pembelian_realisasi
                                                                                             ON tbl_pp_barang.id_barang=tbl_pembelian_realisasi.id_barang
                                                                                             

                                                                       WHERE 
                                                                       nama_barang LIKE '%$cari%'
                                                                       or keterangan_pp LIKE '%$cari%'
                                                                       or divisi LIKE '%$cari%' 
                                                                       or status_gm LIKE '%$cari%'
                                                                       or no_pp LIKE '%$cari%'
                                                                       ORDER by nama_barang DESC ");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $no++;
                                        ?>
                                        <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_pp'] ?></strong><br/><hr/><i><?= indoDate($row['tgl_pp']) ?></i></td>
                                        <td><strong><?= ucwords(strtolower($row['nama_barang'])) ?></strong><br/><hr/><?= $row['jumlah'] ?> <?= $row['satuan'] ?></td>
                                        <td><?= $row['harga'] = "Rp " . number_format($row['harga'], 0, ',', '.') ?><br/><hr/><?= $row['jumlah_harga'] = "Rp " . number_format($row['jumlah_harga'], 0, ',', '.') ?></td>
                                        <td><?= ucwords(strtolower($row['keterangan_pp'])) ?> <br/><hr/><i><strong> <?= ucwords(strtolower($row['divisi'])) ?></strong></i></td>
                                        <td><strong><?= $row['tujuan_pp'] ?></strong></td>
                                        <td>
                                            <?php
                                            if (!empty($row['status_gm'])) {
                                                ?> <strong><?= $row['status_gm'] ?> <?= $row['jumlah_gm'] ?></a></strong><hr/><?= $row['catatan_gm'] ?>
                                                <?php
                                            } else {
                                                ?> <font color="red"><i>GM Kosong</i></font>
                                            <?php }
                                            ?><br/><hr/>
                                            <?php
                                            if (!empty($row['status_pembelian'])) {
                                                ?> <strong><?= $row['status_pembelian'] ?></a></strong>
                                                <?php
                                            } else {
                                                ?> <font color="red"><i>Pembelian Kosong</i></font>
                                            <?php }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($row['status_gudang'])) {
                                                ?> <strong><?= $row['status_gudang'] ?> <?= $row['jumlah_gudang'] ?></strong><hr/><?= $row['waktu_gudang'] ?>
                                                <?php
                                            } else {
                                                ?> <font color="red"><i>Gudang Kosong</i></font>
                                            <?php }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($_SESSION['admin'] == 12) {
                                                if (is_null($row['id_pp_gudang'])) {
                                                    ?>
                                                    <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gudang&id_pp=<?= $row['id_pp'] ?>">
                                                        <i class="material-icons">warning</i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                   
                                                    <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=<?= $row['id_pp'] ?>" target="_blank">
                                                        <i class="material-icons">print</i></a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?><tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pp&act=add">Tambah data baru</a></u></p></center></td></tr>';
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
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">

                            <tr>
                                <th>No</th>
                                <th width="20%">No.PP</th>
                                <th width="23%">Nama Barang<br/><hr/>Jumlah</th>
                        <th width="15%">Harga<br/><hr/>Jumlah Harga</th>
                        <th width="15%">Keterangan<br/><hr/>Divisi</th>
                        <th width="15%">Tujuan</th>
                        <th width="15%">Status GM<br/><hr/>Status Pembelian</th>
                        <th width="12%">Status Gudang</th>
                        <!--th width="10%">Tindakan</th-->
                        <th width="5%">Option<span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                        <div id="modal" class="modal">
                            <div class="modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>

                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,dashboard_pp FROM tbl_sett");
                                list($id_sett, $dashboard_pp) = mysqli_fetch_array($query);
                                ?>

                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="dashboard_pp" required>
                                                    <option value="<?= $dashboard_pp ?>"><?= $dashboard_pp ?></option>
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
                                                    $dashboard_pp = $_REQUEST['dashboard_pp'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET dashboard_pp='$dashboard_pp',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=dashboard_pp");
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
                            //Menampilkan Data

                            $query = mysqli_query($config, "SELECT * FROM tbl_pp_barang
                                                                                             LEFT JOIN tbl_pp
                                                                                             ON tbl_pp_barang.id_pp=tbl_pp.id_pp
                                                                                             LEFT JOIN tbl_gm_pp
                                                                                             ON tbl_pp_barang.id_barang=tbl_gm_pp.id_barang
                                                                                             LEFT JOIN tbl_pembelian
                                                                                             ON tbl_pp_barang.id_pp=tbl_pembelian.id_pp
                                                                                             LEFT JOIN tbl_pp_gudang
                                                                                             ON tbl_pp_barang.id_barang=tbl_pp_gudang.id_barang
                                                                                             LEFT JOIN tbl_pembelian_realisasi
                                                                                             ON tbl_pp_barang.id_barang=tbl_pembelian_realisasi.id_barang
                                                                                             
                                                                                             
                                                                                             ORDER by no_pp DESC LIMIT $curr, $limit");
                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_pp'] ?></strong><br/><hr/><i><?= indoDate($row['tgl_pp']) ?></i></td>
                                        <td><strong><?= ucwords(strtolower($row['nama_barang'])) ?></strong><br/><hr/><?= $row['jumlah'] ?> <?= $row['satuan'] ?></td>
                                        <td><?= $row['harga'] = "Rp " . number_format($row['harga'], 0, ',', '.') ?><br/><hr/><?= $row['jumlah_harga'] = "Rp " . number_format($row['jumlah_harga'], 0, ',', '.') ?></td>
                                        <td><?= ucwords(strtolower($row['keterangan_pp'])) ?> <br/><hr/><i><strong> <?= ucwords(strtolower($row['divisi'])) ?></strong></i></td>
                                        <td><strong><?= $row['tujuan_pp'] ?></strong></td>
                                        <td>
                                            <?php
                                            if (!empty($row['status_gm'])) {
                                                ?> <strong><?= $row['status_gm'] ?> <?= $row['jumlah_gm'] ?></a></strong><hr/><?= $row['catatan_gm'] ?>
                                                <?php
                                            } else {
                                                ?> <font color="red"><i>GM Kosong</i></font>
                                            <?php }
                                            ?><br/><hr/>
                                            <?php
                                            if (!empty($row['status_pembelian'])) {
                                                ?> <strong><?= $row['status_pembelian'] ?></a></strong>
                                                <?php
                                            } else {
                                                ?> <font color="red"><i>Pembelian Kosong</i></font>
                                            <?php }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($row['status_gudang'])) {
                                                ?> <strong><?= $row['status_gudang'] ?> <?= $row['jumlah_gudang'] ?></strong><hr/><?= $row['waktu_gudang'] ?>
                                                <?php
                                            } else {
                                                ?> <font color="red"><i>Gudang Kosong</i></font>
                                            <?php }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($_SESSION['admin'] == 12) {
                                                if (is_null($row['id_pp_gudang'])) {
                                                    ?>
                                                    <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pp&act=app_gudang&id_pp=<?= $row['id_pp'] ?>">
                                                        <i class="material-icons">warning</i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                   
                                                    <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print PP" href="?page=ctk_pp&id_pp=<?= $row['id_pp'] ?>" target="_blank">
                                                        <i class="material-icons">print</i></a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?><tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pp&act=add">Tambah data baru</a></u></p></center></td></tr>';
                                <?php
                            }
                            ?></tbody></table>
                </div>
                </div>
                <!-- Row form END -->

                <?php
                $query = mysqli_query($config, "SELECT * FROM tbl_pp_barang");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
                                <ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=dashboard_pp&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                    <li><a href="?page=dashboard_pp&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=dashboard_pp&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=dashboard_pp&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=dashboard_pp&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                    <li><a href="?page=dashboard_pp&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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