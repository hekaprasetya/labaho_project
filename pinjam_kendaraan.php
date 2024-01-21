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
        });
    </script>

    <?php
    //cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 2 and $_SESSION['admin'] != 3 and $_SESSION['admin'] != 4 and $_SESSION['admin'] != 5 and $_SESSION['admin'] != 6 and $_SESSION['admin'] != 7 and $_SESSION['admin'] != 8 and $_SESSION['admin'] != 9 and $_SESSION['admin'] != 10 and $_SESSION['admin'] != 11 and $_SESSION['admin'] != 12 and $_SESSION['admin'] != 13 and $_SESSION['admin'] != 14 and $_SESSION['admin'] != 15 and $_SESSION['admin'] != 18) {
            ?> <script language="javascript">
                window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                window.location.href = "./logout.php";
            </script>
            <?php
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_kendaraan.php";
                        break;
                    case 'add_kembali':
                        include "tambah_kendaraan_kembali.php";
                        break;
                    case 'edit':
                        include "edit_kendaraan.php";
                        break;
                    case 'app_petugas_kendaraan':
                        include "approve_kendaraan_petugas.php";
                        break;
                    case 'app_kabag_kendaraan':
                        include "approve_kendaraan_kabag.php";
                        break;
                    case 'del':
                        include "hapus_kendaraan.php";
                        break;
                    case 'print':
                        include "cetak_kendaraan.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT pinjam_kendaraan FROM tbl_sett");
                list($pinjam_kendaraan) = mysqli_fetch_array($query);

                //pagging
                $limit = $pinjam_kendaraan;
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pinjam_kendaraan" class="judul"><i class="material-icons"></i>Pinjam Kendaraan</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=pinjam_kendaraan&act=add"><i class="material-icons md-30">add_circle</i> Tambah</a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="col s4 show-on-medium-and-up right search">
                                    <form method="post" action="?page=pinjam_kendaraan">
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
                // mengambil data dari Database
                $query_kendaraan = "SELECT a.*,
                b.id_app_kendaraan_kabag, status_kendaraan_kabag, waktu_kendaraan_kabag, 
                c.id_app_kendaraan_petugas, status_kendaraan_petugas, waktu_kendaraan_petugas,
                d.id_kendaraan_kembali, jam_kembali, bb_akhir, km_akhir, file_akhir                     
                
                FROM pinjam_kendaraan a
                LEFT JOIN tbl_approve_kendaraan_kabag b
                ON a.id_pinjam_kendaraan = b.id_pinjam_kendaraan
                LEFT JOIN tbl_approve_kendaraan_petugas c 
                ON a.id_pinjam_kendaraan = c.id_pinjam_kendaraan
                LEFT JOIN kendaraan_kembali d 
                ON a.id_pinjam_kendaraan = d.id_pinjam_kendaraan ";



                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=pinjam_kendaraan"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="centered centered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <th>No.Form<br />
                            <hr />Tanggal
                            </th>
                            <th>Nama<br />
                            <hr />Jabatan
                            </th>
                            <th>Tujuan</th>
                            <th>Kendaraan</th>
                            <th>Foto awal</th>
                            <th>Foto Akhir</th>
                            <th>Disetujui.Kabag<br />
                            <hr />Disetujui.Petugas
                            </th>
                            <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                //script untuk mencari data
                                $query_kendaraan .= "WHERE 
                                    no_form LIKE '%$cari%' 
                                    OR tujuan LIKE '%$cari%'
                                    OR nama_kendaraan LIKE '%$cari%'
                                    OR jabatan_kendaraan LIKE '%$cari%'
                                    ORDER by id_pinjam_kendaraan DESC";
                                $result = mysqli_query($config, $query_kendaraan);
                                $cek = mysqli_num_rows($result);
                                if (empty($cek)) {
                                    ?><tr>
                                        <td colspan="5">
                                <center>
                                    <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pinjam_kendaraan&act=add">Tambah data baru</a></u></p>
                                </center>
                                </td>
                                </tr>
                                <?php
                            } else {
                                $no = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $kabag = $row['status_kendaraan_kabag'];
                                    $petugas = $row['status_kendaraan_petugas'];
                                    $id = $row['id_pinjam_kendaraan'];
                                    ?>

                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $row['no_form'] ?><br />
                                            <hr /><?= indoDate($row['tgl']) ?>
                                        </td>
                                        <td><?= $row['nama_kendaraan'] ?><br />
                                            <hr /><?= $row['jabatan_kendaraan'] ?>
                                        </td>
                                        <td><?= $row['tujuan'] ?></td>
                                        <td><?= $row['kendaraan'] ?></td>
                                        <td>
                                            <?php
                                            if (!empty($row['file'])) {
                                                ?><img class="materialboxed" src="/./upload/kendaraan/<?= $row['file'] ?>" width=100px>
                                                <?php
                                            } else {
                                                ?><em>Tidak ada file yang di upload</em>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($row['file_akhir'])) {
                                                ?><img class="materialboxed" src="/./upload/kendaraan/<?= $row['file_akhir'] ?>" width=100px>
                                                <?php
                                            } else {
                                                ?><em>Tidak ada file yang di upload</em>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($kabag)) {
                                                ?><strong><?= $kabag ?></strong>
                                                <?php
                                            } else {
                                                ?><font color="red"><i>Kabag Kosong</i></font>
                                                <?php
                                            }
                                            ?><br /><?= $row['waktu_kendaraan_kabag'] ?><br />
                                            <hr />
                                            <?php
                                            if (!empty($petugas)) {
                                                ?><strong><?= $petugas ?></strong>
                                                <?php
                                            } else {
                                                ?><font color="red"><i>petugas Kosong</i></font>
                                                <?php
                                            }
                                            ?><br /><?= $row['waktu_kendaraan_petugas'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            //**USER BIASA
                                            if ($_SESSION['admin'] == 2 || $_SESSION['admin'] == 3 || $_SESSION['admin'] == 5 || $_SESSION['admin'] == 6 || $_SESSION['admin'] == 7 || $_SESSION['admin'] == 14 || $_SESSION['admin'] == 18) {
                                                if (is_null($row['id_kendaraan_kembali'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih tambah kembali" href="?page=pinjam_kendaraan&act=add_kembali&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-30 material-icons">warning</i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="btn small green waves-effect waves-light tooltipped" data-position="top" data-tooltip="Tambah" href="?page=pinjam_kendaraan&act=add_kembali&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-10 small material-icons">event_available</i></a>
                                                    <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Edit" href="?page=pinjam_kendaraan&act=edit&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-10 small material-icons">edit</i></a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Print" href="?page=pinjam_kendaraan&act=print&id_pinjam_kendaraan=<?= $id ?>" target="_blank">
                                                        <i class="md-10 small material-icons">print</i></a>
                                                    <?php
                                                }
                                            }

                                            //**KABAG APPROVE
                                            if ($_SESSION['admin'] == 4 || $_SESSION['admin'] == 8 || $_SESSION['admin'] == 13 || $_SESSION['admin'] == 15) {
                                                if (is_null($row['id_app_kendaraan_kabag'])) {
                                                    ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_kabag_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="material-icons">warning</i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_kabag_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-10 material-icons">assignment_turned_in</i></a>
                                                    <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Kendaraan" href="?page=pinjam_kendaraan&act=edit&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-10 material-icons">edit</i></a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Print" href="?page=pinjam_kendaraan&act=print&id_pinjam_kendaraan=<?= $id ?>" target="_blank">
                                                        <i class="md-10 small material-icons">print</i></a>
                                                    <?php
                                                }
                                            }

                                            //**PETUGAS APPROVE
                                            if ($_SESSION['admin'] == 11) {
                                                if (is_null($row['id_app_kendaraan_petugas'])) {
                                                    ?> <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_petugas_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="material-icons">warning</i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_petugas_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-10 material-icons">assignment_turned_in</i></a>
                                                    <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Kendaraan" href="?page=pinjam_kendaraan&act=edit&id_pinjam_kendaraan=<?= $id ?>">
                                                        <i class="md-10 material-icons">edit</i></a>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Print" href="?page=pinjam_kendaraan&act=print&id_pinjam_kendaraan=<?= $id ?>" target="_blank">
                                                        <i class="md-10 small material-icons">print</i></a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
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

                    <table class="centered centered" id="tbl">
                        <thead class="blue lighten-4" id="head">

                            <tr>
                                <th>No</th>
                                <th>No.Form<br />
                        <hr />Tanggal
                        </th>
                        <th>Nama<br />
                        <hr />Jabatan
                        </th>
                        <th>Tujuan</th>
                        <th>Kendaraan</th>
                        <th>Foto awal</th>
                        <th>Foto Akhir</th>
                        <th>Disetujui.Kabag<br />
                        <hr />Disetujui.Petugas
                        </th>
                        <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                        <div id="modal" class="modal">
                            <div class="modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,pinjam_kendaraan FROM tbl_sett");
                                list($id_sett, $pinjam_kendaraan) = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="pinjam_kendaraan" required>
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
                                                    $pinjam_kendaraan = $_REQUEST['pinjam_kendaraan'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET pinjam_kendaraan='$pinjam_kendaraan' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=pinjam_kendaraan");
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

                            <!-- script untuk menampilkan data -->
                            <?php
                            $query_kendaraan .= "ORDER by id_pinjam_kendaraan DESC LIMIT $curr, $limit";
                            $result = mysqli_query($config, $query_kendaraan);
                            $cek = mysqli_num_rows($result);
                            if (empty($cek)) {
                                ?><tr>
                                    <td colspan="5">
                            <center>
                                <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=pinjam_kendaraan&act=add">Tambah data baru</a></u></p>
                            </center>
                            </td>
                            </tr>
                            <?php
                        } else {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $kabag = $row['status_kendaraan_kabag'];
                                $petugas = $row['status_kendaraan_petugas'];
                                $id = $row['id_pinjam_kendaraan'];
                                ?>

                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $row['no_form'] ?><br />
                                        <hr /><?= indoDate($row['tgl']) ?>
                                    </td>
                                    <td><?= $row['nama_kendaraan'] ?><br />
                                        <hr /><?= $row['jabatan_kendaraan'] ?>
                                    </td>
                                    <td><?= $row['tujuan'] ?></td>
                                    <td><?= $row['kendaraan'] ?></td>
                                    <td>
                                        <?php
                                        if (!empty($row['file'])) {
                                            ?> <a href = "/./upload/kendaraan/<?= $row['file'] ?>"><img class="materialboxed" src="/./upload/kendaraan/<?= $row['file'] ?> " width=80px>
                                            <?php
                                        } else {
                                            ?><em>Tidak ada file yang di upload</em>
                                                <?php
                                            }
                                            ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($row['file_akhir'])) {
                                            ?><img class="materialboxed" src="upload/kendaraan/<?= $row['file_akhir'] ?>" width=80px>
                                            <?php
                                        } else {
                                            ?><em>Tidak ada file yang di upload</em>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($kabag)) {
                                            ?><strong><?= $kabag ?></strong>
                                            <?php
                                        } else {
                                            ?><font color="red"><i>Kabag Kosong</i></font>
                                            <?php
                                        }
                                        ?><br /><?= $row['waktu_kendaraan_kabag'] ?><br />
                                        <hr />
                                        <?php
                                        if (!empty($petugas)) {
                                            ?><strong><?= $petugas ?></strong>
                                            <?php
                                        } else {
                                            ?><font color="red"><i>petugas Kosong</i></font>
                                            <?php
                                        }
                                        ?><br /><?= $row['waktu_kendaraan_petugas'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        //**USER BIASA
                                        if ($_SESSION['admin'] == 2 || $_SESSION['admin'] == 3 || $_SESSION['admin'] == 5 || $_SESSION['admin'] == 6 || $_SESSION['admin'] == 7 || $_SESSION['admin'] == 14 || $_SESSION['admin'] == 18) {
                                            if (is_null($row['id_kendaraan_kembali'])) {
                                                ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih tambah kembali" href="?page=pinjam_kendaraan&act=add_kembali&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-30 material-icons">warning</i></a>
                                                <?php
                                            } else {
                                                ?>
                                                <a class="btn small green waves-effect waves-light tooltipped" data-position="top" data-tooltip="Tambah" href="?page=pinjam_kendaraan&act=add_kembali&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-10 small material-icons">event_available</i></a>
                                                <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Edit" href="?page=pinjam_kendaraan&act=edit&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-10 small material-icons">edit</i></a>
                                                <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Print" href="?page=pinjam_kendaraan&act=print&id_pinjam_kendaraan=<?= $id ?>" target="_blank">
                                                    <i class="md-10 small material-icons">print</i></a>
                                                <?php
                                            }
                                        }

                                        //**KABAG APPROVE
                                        if ($_SESSION['admin'] == 4 || $_SESSION['admin'] == 8 || $_SESSION['admin'] == 13 || $_SESSION['admin'] == 15) {
                                            if (is_null($row['id_app_kendaraan_kabag'])) {
                                                ?><a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_kabag_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="material-icons">warning</i></a>
                                                <?php
                                            } else {
                                                ?>
                                                <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_kabag_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-10 material-icons">assignment_turned_in</i></a>
                                                <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Kendaraan" href="?page=pinjam_kendaraan&act=edit&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-10 material-icons">edit</i></a>
                                                <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Print" href="?page=pinjam_kendaraan&act=print&id_pinjam_kendaraan=<?= $id ?>" target="_blank">
                                                    <i class="md-10 small material-icons">print</i></a>
                                                <?php
                                            }
                                        }

                                        //**PETUGAS APPROVE
                                        if ($_SESSION['admin'] == 11) {
                                            if (is_null($row['id_app_kendaraan_petugas'])) {
                                                ?> <a class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_petugas_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="material-icons">warning</i></a>
                                                <?php
                                            } else {
                                                ?>
                                                <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approval" href="?page=pinjam_kendaraan&act=app_petugas_kendaraan&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-10 material-icons">assignment_turned_in</i></a>
                                                <a class="btn small blue darken-1 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Kendaraan" href="?page=pinjam_kendaraan&act=edit&id_pinjam_kendaraan=<?= $id ?>">
                                                    <i class="md-10 material-icons">edit</i></a>
                                                <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Print" href="?page=pinjam_kendaraan&act=print&id_pinjam_kendaraan=<?= $id ?>" target="_blank">
                                                    <i class="md-10 small material-icons">print</i></a>
                                                <?php
                                            }
                                        }
                                        ?>
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
                    $query = mysqli_query($config, "SELECT * FROM pinjam_kendaraan");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata / $limit);
                    ?><br /><!-- Pagination START -->
                    <ul class="pagination">
                        <?php
                        if ($cdata > $limit) {

                            //first and previous pagging
                            if ($pg > 1) {
                                $prev = $pg - 1;
                                ?><li><a href="?page=pinjam_kendaraan&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                <li><a href="?page=pinjam_kendaraan&pg=<?= $prev ?>"><i class="material-icons md-48">chevron_left</i></a></li>
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
                                        ?><li class="active waves-effect waves-dark"><a href="?page=pinjam_kendaraan&pg=<?= $i ?>"> <?= $i ?></a></li>
                                        <?php } else {
                                            ?><li class="waves-effect waves-dark"><a href="?page=pinjam_kendaraan&pg=<?= $i ?>"> <?= $i ?></a></li>
                                            <?php
                                        }
                                    }
                                }
                                //last and next pagging
                                if ($pg < $cpg) {
                                    $next = $pg + 1;
                                    ?><li><a href="?page=pinjam_kendaraan&pg=<?= $next ?>"><i class="material-icons md-48">chevron_right</i></a></li>
                                <li><a href="?page=pinjam_kendaraan&pg=<?= $cpg ?>"><i class="material-icons md-48">last_page</i></a></li>
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
                        ?>
                        <?php
                    }
                }
            }
        }
    }
    ?>
</div>
