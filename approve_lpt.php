<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_POST['submita'])) {
        //print_r($_POST);die;
        $id_lpt = $_POST['id_lpt'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_lpt WHERE id_lpt='$id_lpt'");
        $no = 1;
        list($id_lpt) = mysqli_fetch_array($query); {

            $ttd_kabag = $_POST['ttd_kabag'];
            $id_lpt = $_POST['id_lpt'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_lpt where id_lpt='$id_lpt'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_lpt(ttd_kabag,id_lpt,id_user)
                                        VALUES('$ttd_kabag','$id_lpt','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_lpt SET
                ttd_kabag='$ttd_kabag',
                id_lpt='$id_lpt',
                id_user='$id_user' WHERE id_approve_lpt=$cek_data_row[id_approve_lpt]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                 window.history.go(-1)
                     </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {

        //pagging
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
        };
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <div class="z-depth-1">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <div class="col m12">
                                <ul class="left">
                                    <li class="col s5 waves-effect waves-light show-on-small-only"><a href="#" class="judul"><i class="material-icons">mail</i>E-LPT</a></li>
                                    <div class="col s6 show-on-medium-and-up">
                                        <form method="post" action="?page=app_lpt_v">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" placeholder="Searching" required>
                                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                                <input type="submit" name="submito" value="cari">
                                            </div>
                                        </form>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <?php
            if (isset($_SESSION['succAdd'])) {
                $succAdd = $_SESSION['succAdd'];
                ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succAdd ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['succAdd']);
            }
            if (isset($_SESSION['succEdit'])) {
                $succEdit = $_SESSION['succEdit'];
                ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succEdit ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['succEdit']);
            }
            if (isset($_SESSION['succDel'])) {
                $succDel = $_SESSION['succDel'];
                ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succDel ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['succDel']);
            }
            ?>
        </div>
        <!-- Row END -->

        <!-- Perihal START -->

        <div class="row jarak-form">

            <?php
            if (isset($_POST['submito'])) {
                $cari = mysqli_real_escape_string($config, $_POST['cari']);
                echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=app_lpt_v"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

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
                                        <th width="18%">Verifikator<br/><hr/>Tgl.Verifikator</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                //script untuk mencari data
                $query = mysqli_query($config, "SELECT * FROM tbl_lpt WHERE no_lpt LIKE '%$cari%'or tgl_lpt LIKE '%$cari%' or nama_tk LIKE '%$cari%' ORDER by id_lpt DESC");
                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;

                        echo '
                                  <tr>
                                    <td>' . $no . '</td>
                                    <td>' . $row['no_lpt'] . '<br/><hr/>' . $row['tgl_lpt'] . '</td>
                                    <td>' . $row['nama_tk'] . '<br/><hr/>' . $row['nama_perusahaan'] . '</td>
                                    <td>' . $row['peminta'] . '<br/><hr/>' . $row['lokasi_pengerjaan'] . '</td>
                                    <td>' . $row['jenis_pekerjaan'] . '<br/><hr/>' . $row['pekerjaan'] . '</td>
                                    <td>';
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
                ?>

                <div class = "col m12" id = "colres">
                    <table class = "bordered" id = "tbl">
                        <thead class = "blue lighten-4" id = "head">
                            <tr>
                                <th>No</th>
                                <th width="15%">No.LPT<br/><hr/>Tgl.LPT</th>
                        <th width="18%">No.PMK</th>
                        <th width="30%">Nama Teknisi<br/><hr/>Nama Perusahaan</th>
                        <th width="24%">Peminta<br/><hr/>Lokasi</th>
                        <th width="18%">Jenis Pekerjaan<br/><hr/>Pekerjaan Yang Dilakukan</th>
                        <th width="18%">Mng.Engineering</th>
                        <th width="18%">Verifikator<br/><hr/>Tgl.Verifikator</th>
                        <th width = "10%">Tindakan</th>
                        <th width = "3%">Atur Baris<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                        <div id = "modal" class = "modal">
                            <div class = "modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,lpt FROM tbl_sett");
                                list($id_sett, $lpt) = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="lpt" required>
                                                    <option value="<?= $lpt ?>"><?= $lpt ?></option>
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
                                                    $lpt = $_REQUEST['lpt'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET lpt='$lpt',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=app_lpt_v");
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
                            $query = mysqli_query($config, "SELECT a.*, 
                                                           b.ttd_kabag ,
                                                           c.nama_verifikator ,tgl_verifikasi ,
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
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row['no_lpt'] ?><br/><hr/><?= indoDate ($row['tgl_lpt']) ?></td>
                                        <td><strong><?= $row['no_agenda'] ?></strong></td>
                                        <td><?= $row['nama_tk'] ?><br/><hr/><?= $row['nama_perusahaan'] ?></td>
                                        <td><?=  $row['peminta'] ?><br/><hr/><?= $row['lokasi_pengerjaan'] ?></td>
                                        <td><?=  $row['jenis_pekerjaan'] ?><br/><hr/><?=$row['pekerjaan'] ?></td>
                                        <td><strong><?=  $row['ttd_kabag']?></strong></td>
                                        <td><strong><?= $row['nama_verifikator'] ?><br/><hr/><?= $row['tgl_verifikasi'] ?></strong></td>
                                        
                                        <td><a class="btn small modal-trigger" href="#modal<?= $no ?>">APPROVE</i></a></span>
                                            <div id="modal<?= $no ?>" class="modal">
                                                <div class="modal-content white">
                                                    <div class="row">
                                                        <!-- Secondary Nav START -->
                                                        <div class="col s12">
                                                            <nav class="secondary-nav">
                                                                <div class="nav-wrapper blue-grey darken-1">
                                                                    <ul class="left">
                                                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Approval</a></li>
                                                                    </ul>
                                                                </div>
                                                            </nav>
                                                        </div>
                                                        <!-- Secondary Nav END -->
                                                    </div>

                                                    <div class="row jarak-form">
                                                        <form class="col s12" method="post" action="">
                                                            <div class="input-field col s7">
                                                                <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                <input type="hidden" id="id_surat" name="id_lpt" value="<?= $row['id_lpt'] ?>" />
                                                                <select name="ttd_kabag" class="browser-default validate" id="ttd_kabag" required>
                                                                    <option value=""></option>
                                                                    <option value="Diterima">Diterima</option>
                                                                    <option value="Ditolak">Ditolak</option>
                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col 6">
                                                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_lpt&id_lpt=<?= $row['id_lpt'] ?>" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan.</p></center></td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            $query = mysqli_query($config, "SELECT * FROM tbl_lpt");
            $cdata = mysqli_num_rows($query);
            $cpg = ceil($cdata / $limit);

            echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

            if ($cdata > $limit) {

                //first and previous pagging
                if ($pg > 1) {
                    $prev = $pg - 1;
                    echo '<li><a href="?page=app_lpt_v&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=app_lpt_v&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                } else {
                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                }

                //perulangan pagging
                for ($i = 1; $i <= $cpg; $i++) {
                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                        if ($i == $pg)
                            echo '<li class="active waves-effect waves-dark"><a href="?page=app_lpt_v&pg=' . $i . '"> ' . $i . ' </a></li>';
                        else
                            echo '<li class="waves-effect waves-dark"><a href="?page=app_lpt_v&pg=' . $i . '"> ' . $i . ' </a></li>';
                    }
                }

                //last and next pagging
                if ($pg < $cpg) {
                    $next = $pg + 1;
                    echo '<li><a href="?page=app_lpt_v=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=app_lpt_v=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                } else {
                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                }
                echo '
                        </ul>';
            }
            ?>

            <?php
            unset($_SESSION['succDel']);
        }
    }
}
?>
    