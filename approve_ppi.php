<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_POST['submita'])) {
        //print_r($_POST);die;
        $id_ppi = $_POST['id_ppi'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_ppi WHERE id_ppi='$id_ppi'");
        $no = 1;
        list($id_ppi) = mysqli_fetch_array($query);
        {

            $manager = $_POST['manager'];
            $catatan_ppi = $_POST['catatan_ppi'];
            $id_ppi = $_POST['id_ppi'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_ppi where id_ppi='$id_ppi'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_ppi(manager,catatan_ppi,id_ppi,id_user)
                                        VALUES('$manager','$catatan_ppi','$id_ppi','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_ppi SET
                manager='$manager',
                catatan_ppi='$catatan_ppi',
                id_ppi='$id_ppi',
                id_user='$id_user' WHERE id_approve_ppi=$cek_data_row[id_approve_ppi]");
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
        $query = mysqli_query($config, "SELECT ppi FROM tbl_sett");
        list($ppi) = mysqli_fetch_array($query);

        //pagging
        $limit = $ppi;
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
                                    <li class="col s5 waves-effect waves-light show-on-small-only"><a href="?page=ppi&act=add" class="judul"><i class="material-icons">mail</i>E-PPI</a></li>
                                    <div class="col s6 show-on-medium-and-up">
                                        <form method="post" action="?page=app_ppi">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=app_ppi"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                 <tr>
                                    <th>No</th>
                                        <th width="15%">No.PPI<br/><hr/>Tanggal</th>
                                        <th width="24%">Nama Peminta<br/><hr/> Divisi</th>
                                        <th width="30%">Tujuan Divisi<br/><hr/>Permintaan Pekerjaan</th>
                                        <th width="18%">Lokasi<br/><hr/>File</th>
                                       <th width="18%">Manager<br/><hr/>Nama</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                //script untuk mencari data
                $query = mysqli_query($config, "SELECT a.*, 
                                                           b.manager,catatan_ppi,waktu_ttd_ppi,
                                                           c.nama
                                                           FROM tbl_ppi a
                                                           LEFT JOIN tbl_approve_ppi b 
                                                           ON a.id_ppi=b.id_ppi 
                                                           LEFT JOIN tbl_user c 
                                                           ON c.id_user=b.id_user 
                                                           
                                                       WHERE no_ppi LIKE '%$cari%' or
                                                             tgl_ppi LIKE '%$cari%' or 
                                                             nama_peminta LIKE '%$cari%' or 
                                                             tujuan_divisi LIKE '%$cari%' or 
                                                             permintaan_pekerjaan LIKE '%$cari%' or 
                                                             lokasi LIKE '%$cari%'
                                                             ORDER by id_ppi DESC");
                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;

                        echo '
                    <tr>
                                        <td>' . $no . '</td>
                                        <td><strong>' . $row['no_ppi'] . '</strong><br/><hr/>' . indoDate($row['tgl_ppi']) . '</td>
                                        <td>' . $row['nama_peminta'] . '<br/><hr>' . $row['divisi'] . '</td>
                                        <td><strong><i>' . $row['tujuan_divisi'] . '</i></strong><br/><hr/>' . nl2br(htmlentities($row['permintaan_pekerjaan'])) . '</td>
                                        <td>' . substr($row['lokasi'], 0, 200) . '<br/><br/><strong>File :</strong>';

                        if (!empty($row['file'])) {
                            echo ' <strong><a href="?page=gppi&act=fppi&id_ppi=' . $row['id_ppi'] . '">' . $row['file'] . '</a></strong>';
                        } else {
                            echo '<em>Tidak ada file yang di upload</em>';
                        } echo '</td>
                                        <td>';
                        if (!empty($row['manager'])) {
                            echo ' <strong>' . $row['manager'] . ', ' . $row['waktu_ttd_ppi'] . ', ' . $row['catatan_ppi'] . ' </a></strong>';
                        } else {
                            echo '<font color="red"><i>Manager Kosong</i></font>';
                        } echo '
                                        <br/><hr>' . $row['nama'] . '
                                        </td>
                                        <td>';

                        if ($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] != 1) {
                            echo '<a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_ppi=' . $row['id_ppi'] . '" target="_blank">
                                            <i class="material-icons">print</i> PRINT</a>';
                        } else {
                            echo '<a class="btn small blue waves-effect waves-light" href="?page=ppi&act=edit&id_ppi=' . $row['id_ppi'] . '">
                                                <i class="material-icons">edit</i> EDIT</a>
                                            <!--a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih untuk approve" href="?page=pa&act=disp&id_ppi=' . $row['id_ppi'] . '">
                                                <i class="check-icons">description</i> Approve</a-->
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_ppi=' . $row['id_ppi'] . '" target="_blank">
                                                <i class="material-icons">print</i> PRINT</a>
                                            <a class="btn small deep-orange waves-effect waves-light" href="?page=pa&act=del&id_ppi=' . $row['id_ppi'] . '">
                                                <i class="material-icons">delete</i> DEL</a>';
                        } echo '
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
                                <th width="15%">No.PPI<br/><hr/>Tanggal</th>
                        <th width="24%">Nama Peminta<br/><hr/> Divisi</th>
                        <th width="30%">Tujuan Divisi<br/><hr/>Permintaan Pekerjaan</th>
                        <th width="18%">Lokasi<br/><hr/>File</th>
                        <th width="18%">Manager<br/><hr/>Nama</th>
                        <th width = "3%">Atur Baris<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                        <div id = "modal" class = "modal">
                            <div class = "modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,ppi FROM tbl_sett");
                                list($id_sett, $ppi) = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="ppi" required>
                                                    <option value="<?= $ppi ?>"><?= $ppi ?></option>
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
                                                    $ppi = $_REQUEST['ppi'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET ppi='$ppi',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=app_ppi");
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
                            //--Menampilkan Data--
                            $query = mysqli_query($config, "SELECT a.*, 
                                                           b.manager,catatan_ppi,waktu_ttd_ppi,
                                                           c.nama
                                                           FROM tbl_ppi a
                                                           LEFT JOIN tbl_approve_ppi b 
                                                           ON a.id_ppi=b.id_ppi 
                                                           LEFT JOIN tbl_user c 
                                                           ON c.id_user=b.id_user 
                                                           
                                                           ORDER by id_ppi DESC LIMIT $curr, $limit");

                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_ppi'] ?></strong><br/><hr/><?= indoDate($row['tgl_ppi']) ?></td>
                                        <td><?= $row['nama_peminta'] ?><br/><hr><?= $row['divisi'] ?></td>
                                        <td><strong><i><?= $row['tujuan_divisi'] ?></i></strong><br/><hr/><?= nl2br(htmlentities($row['permintaan_pekerjaan'])) ?></td>
                                        <td><?= substr($row['lokasi'], 0, 200) ?><br/><br/><strong>File :</strong>
                                            <?php
                                            if (!empty($row['file'])) {
                                                echo ' <strong><a href="?page=gppi&act=fppi&id_ppi=' . $row['id_ppi'] . '">' . $row['file'] . '</a></strong>';
                                            } else {
                                                echo '<em>Tidak ada file yang di upload</em>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                            if (!empty($row['manager'])) {
                                echo ' <strong>' . $row['manager'] . ', ' . $row['waktu_ttd_ppi'] . ',' . $row['catatan_ppi'] . '</a></strong>';
                            } else {
                                echo '<font color="red"><i>Manager Kosong</i></font>';
                            } ?>
                                        <br/><hr><?= $row['nama']?>
                                        </td>
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
                                                                <input type="hidden" id="id_ppi" name="id_ppi" value="<?= $row['id_ppi'] ?>" />
                                                                <select name="manager" class="browser-default validate" id="manager" required>
                                                                    <option value="">Pilih Status</option>
                                                                    <option value="Progres">Progres</option>
                                                                    <option value="Material Kosong">Material Kosong</option>
                                                                    <option value="Pending">Pending</option>
                                                                    <option value="Ditolak">Ditolak</option>
                                                                    <option value="Selesai">Selesai</option>
                                                                </select>
                                                            </div>
                                                            
                                                              <div class="input-field col s9">
                                                            <i class="material-icons prefix md-prefix">noted</i><label>Catatan</label><br/>
                                                            <textarea id="catatan_ppi" class="materialize-textarea validate" name="catatan_ppi"></textarea>
                                                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                             </div>

                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_ppi&id_ppi=<?= $row['id_ppi'] ?>" target="_blank">
                                                <i class="material-icons">print</i>PRINT</a>
                                             <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit PPI" href="?page=ppi&act=edit&id_ppi=<?= $row['id_ppi'] ?>">
                                                <i class="material-icons">edit</i> EDIT</a>
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
            $query = mysqli_query($config, "SELECT * FROM tbl_ppi");
            $cdata = mysqli_num_rows($query);
            $cpg = ceil($cdata / $limit);

            echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

            if ($cdata > $limit) {

                //first and previous pagging
                if ($pg > 1) {
                    $prev = $pg - 1;
                    echo '<li><a href="?page=app_ppi&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=app_ppi&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                } else {
                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                }

                //perulangan pagging
                for ($i = 1; $i <= $cpg; $i++) {
                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                        if ($i == $pg)
                            echo '<li class="active waves-effect waves-dark"><a href="?page=app_ppi&pg=' . $i . '"> ' . $i . ' </a></li>';
                        else
                            echo '<li class="waves-effect waves-dark"><a href="?page=app_ppi&pg=' . $i . '"> ' . $i . ' </a></li>';
                    }
                }

                //last and next pagging
                if ($pg < $cpg) {
                    $next = $pg + 1;
                    echo '<li><a href="?page=ppi&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=ppi&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
    