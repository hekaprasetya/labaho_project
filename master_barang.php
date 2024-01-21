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
                        include "tambah_master_barang.php";
                        break;
                    case 'edit':
                        include "edit_master_barang.php";
                        break;
                    case 'del':
                        include "hapus_master_barang.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT master_barang FROM tbl_sett");
                list($master_barang) = mysqli_fetch_array($query);

                //pagging
                $limit = $master_barang;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=master_barang&act=add" class="judul"><i class="material-icons md-3">filter_frames</i>Master Barang</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=master_barang&act=add"><i class="material-icons md-3">add_circle</i>Tambah Data</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-med-and-down">
                                    <form method="post" action="?page=master_barang">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=master_barang"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                      <th>No</th>
                                        <th width="20%">No.Barang</th>
                                        <th width="20%">Nama Barang</th>
                                        <th width="10%">Satuan</th>
                                        <th width="10%">Harga</th>
                                        <th width="20%">Foto</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk mencari data
                                $query = mysqli_query($config, "SELECT * FROM master_barang
                                                                         WHERE nama_barang LIKE '%$cari%' or
                                                                               satuan_barang LIKE '%$cari%' 
                                                                               ORDER by id_barang_gudang DESC");
                                if (mysqli_num_rows($query) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><?= $row['no_barang'] ?></strong></td>
                                            <td><?= ucwords(nl2br(htmlentities(strtolower($row['nama_barang'])))) ?></td>
                                            <td><?= $row['satuan_barang'] ?></td>
                                            <td><?= $row['harga_barang'] = "Rp " . number_format((float) $row['harga_barang'], 0, ',', '.') ?></td>
                                            <td></strong>
                                                <?php
                                                if (!empty($row['file'])) {
                                                    ?>
                                                    <strong><a href="?page=galeri_master_barang&act=file_master_barang&id_barang_gudang=<?= $row['id_barang_gudang'] ?>"><?= $row['file'] ?></a></strong>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <em>Tidak ada file yang di upload</em>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>

                                                <?php
                                                if ($_SESSION['admin'] == 9 | $_SESSION['admin'] == 12 |$_SESSION['admin'] == 15) {
                                                    if ($_SESSION['admin']) {
                                                        ?>
                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=master_barang&act=edit&id_barang_gudang=<?= $row['id_barang_gudang'] ?>">
                                                            <i class="material-icons">edit</i></a>
                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat"  onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=master_barang&act=del&id_barang_gudang=<?= $row['id_barang_gudang'] ?>">
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
                                    ?>
                                    <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pa&act=add">Tambah data baru</a></u></p></center></td></tr>
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
                                <th width="20%">No.Barang</th>
                                <th width="20%">Nama Barang</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Harga</th>
                                <th width="20%">Foto</th>
                                <th width="20%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                        <div id="modal" class="modal">
                            <div class="modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,master_barang FROM tbl_sett");
                                list($id_sett, $master_barang) = mysqli_fetch_array($query)
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="master_barang" required>
                                                    <option value="<?= $master_barang ?>"><?= $master_barang ?></option>
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
                                                    $master_barang = $_REQUEST['master_barang'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET master_barang='$master_barang',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=master_barang");
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
                            $query = mysqli_query($config, "SELECT * FROM master_barang ORDER by id_barang_gudang DESC LIMIT $curr, $limit");
                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_barang'] ?></strong></td>
                                        <td><?= ucwords(nl2br(htmlentities(strtolower($row['nama_barang'])))) ?></td>
                                        <td><?= $row['satuan_barang'] ?></td>
                                        <td><?= $row['harga_barang'] = "Rp " . number_format((float) $row['harga_barang'], 0, ',', '.') ?></td>
                                        <td></strong>
                                            <?php
                                            if (!empty($row['file'])) {
                                                ?>
                                                <strong><a href="?page=galeri_master_barang&act=file_master_barang&id_barang_gudang=<?= $row['id_barang_gudang'] ?>"><?= $row['file'] ?></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em>Tidak ada file yang di upload</em>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>

                                            <?php
                                            if ($_SESSION['admin'] == 9 | $_SESSION['admin'] == 12 | $_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=master_barang&act=edit&id_barang_gudang=<?= $row['id_barang_gudang'] ?>">
                                                        <i class="material-icons">edit</i></a>
                                                    <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat"  onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=master_barang&act=del&id_barang_gudang=<?= $row['id_barang_gudang'] ?>">
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
                                ?>
                                <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=master_barang&act=add">Tambah data baru</a></u></p></center></td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>

                <!-- Row form END -->
                <?php
                $query = mysqli_query($config, "SELECT * FROM master_barang");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
<ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=master_barang&pg=1"><i class="material-icons md-48">first_page</i></a></li>
    <li><a href="?page=master_barang&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=master_barang&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=master_barang&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=master_barang&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
    <li><a href="?page=master_barang&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
