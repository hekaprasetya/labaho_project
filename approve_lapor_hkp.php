<h6><?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        $id_lapor = $_REQUEST['id_lapor'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_lapor_hkp WHERE id_lapor='$id_lapor'");
        $no = 1;
        list($id_lapor) = mysqli_fetch_array($query); {

            $status_hkp = $_POST['status_hkp'];
            $id_lapor = $_REQUEST['id_lapor'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_lapor_hkp where id_lapor='$id_lapor'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_lapor_hkp(status_hkp,id_lapor,id_user)
                                        VALUES('$status_hkp','$id_lapor','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_lapor_hkp SET
                status_hkp='$status_hkp',
                id_lapor='$id_lapor',
                id_user='$id_user' WHERE id_app_lapor_hkp=$cek_data_row[id_app_lapor_hkp]");
            }

           if ($query == true) {
             $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=app_lapor");
                    die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {

        //pagging
        $query = mysqli_query($config, "SELECT lapor FROM tbl_sett");
        list($lapor) = mysqli_fetch_array($query);

        //pagging
        $limit = $lapor;
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
                            <div class="nav-wrapper blue-grey darken-1">
                                <div class="col m7">
                                    <ul class="left">
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pp" class="judul"><i class="material-icons"></i>E-LAPOR</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=lapor&act=add"><i class="material-icons md-24">add_circle</i>Tambah Data</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=app_lapor">
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
            if (isset($_REQUEST['submit_search'])) {
                $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                ?>
                <div class="col s12" style="margin-top: -18px;">
                    <div class="card blue lighten-5">
                        <div class="card-content">
                            <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=app_lapor"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                        </div>
                    </div>
                </div>

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr> 
                                <th>No</th>
                                <th width="15%">No.Lapor<br/><hr/>Tgl.Lapor</th>
                        <th width="20%">Divisi<br/><hr/>Jenis Komplain</th>
                        <th width="24%">Pemberi Komplain<br/><hr/>Pekerjaan yang dilakukan</th>
                        <th width="18%">Aksi Komplain</th>
                        <th width="18%">Lokasi<br/><hr/>File</th>
                        <th width="18%">Pelapor</th>
                        <th width="18%">Status</th>
                        <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php
                            //script untuk mencari data
                            $query = mysqli_query($config, "SELECT a.*, 
                                                                    b.status_hkp
                                                                    FROM tbl_lapor a
                                                                    LEFT JOIN tbl_approve_lapor_hkp b
                                                                    ON a.id_lapor=b.id_lapor
                                                                        WHERE no_lapor  LIKE '%$cari%' or tgl_lapor
                                                                                        LIKE '%$cari%' or divisi
                                                                                        LIKE '%$cari%' or jenis_komplain 
                                                                                        LIKE '%$cari%' or pemberi_komplain
                                                                                        LIKE '%$cari%' or pekerjaan
                                                                                        LIKE '%$cari%' or lokasi
                                                                                        LIKE '%$cari%' ORDER by id_lapor DESC");
                            if (mysqli_num_rows($query) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_lapor'] ?></strong><br/><hr/><?= indoDate($row['tgl_lapor']) ?></td>
                                        <td><?= ucwords(strtolower($row['divisi'])) ?><br/><hr><?= ucwords(strtolower($row['jenis_komplain'])) ?></td>
                                        <td><?= ucwords(strtolower($row['pemberi_komplain'])) ?><br/><hr><?= ucwords(strtolower($row['pekerjaan'])) ?></td>
                                        <td><strong><i><?= ucwords(strtolower($row['aksi_komplain'])) ?></i></strong></td>
                                        <td><strong><?= $row['lokasi'] ?></strong></td>
                                        <td><strong><?= $row['status_hkp'] ?></strong></td>
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
                                                                <input type="hidden" id="id_lapor" name="id_lapor" value="<?= $row['id_lapor'] ?>" />
                                                                <select name="status_hkp" class="browser-default validate" id="status_hkp" required>
                                                                            <option value="Progres">Progres</option>
                                                                            <option value="Material Kosong">Material Kosong</option>
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Selesai">Selesai</option>
                                                                        </select>
                                                            </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col 6">
                                                            <button type="submit" name ="submit_cari" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <a class="btn small yellow darken-3 waves-effect waves-light"href="?page=ctk_lapor&id_lapor=<?= $row['id_lapor'] ?>">
                                                <i class="material-icons">print</i>PRINT</a>
                                        </td>
                                    </tr>
                                    <?php
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
                                        <th width="15%">No.Lapor<br/><hr/>Tgl.Lapor</th>
                                <th width="20%">Divisi<br/><hr/>Jenis Komplain</th>
                                <th width="24%">Pemberi Komplain<br/><hr/>Pekerjaan yang dilakukan</th>
                                <th width="18%">Aksi Komplain</th>
                                <th width="18%">Lokasi<br/><hr/>File</th>
                                <th width="18%">Pelapor</th>
                                <th width="18%">Status</th>
                                <th width = "3%">Tindakan<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                                <div id = "modal" class = "modal">
                                    <div class = "modal-content white">
                                        <h5>Jumlah data yang ditampilkan per halaman</h5>
                                        <?php
                                        $query = mysqli_query($config, "SELECT id_sett,lapor FROM tbl_sett");
                                        list($id_sett, $lapor) = mysqli_fetch_array($query);
                                        ?>
                                        <div class="row">
                                            <form method="post" action="">
                                                <div class="input-field col s12">
                                                    <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                    <div class="input-field col s1" style="float: left;">
                                                        <i class="material-icons prefix md-prefix">looks_one</i>
                                                    </div>
                                                    <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                        <select class="browser-default validate" name="lapor" required>
                                                            <option value="<?= $lapor ?>"><?= $lapor ?></option>
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
                                                            $lapor = $_REQUEST['lapor'];
                                                            $id_user = $_SESSION['id_user'];

                                                            $query = mysqli_query($config, "UPDATE tbl_sett SET lapor='$lapor',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                            if ($query == true) {
                                                                header("Location: ./admin.php?page=app_lapor");
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
                                    //Menampilkan data
                                    $query = mysqli_query($config, "SELECT a.*, 
                                                                    b.id_app_lapor_tk,status_tk,waktu_tk,
                                                                    c.id_app_lapor_hkp,status_hkp,waktu_hkp,
                                                                    d.nama
                                                                    FROM tbl_lapor a
                                                                    LEFT JOIN tbl_approve_lapor_tk b
                                                                    ON a.id_lapor=b.id_lapor
                                                                    LEFT JOIN tbl_approve_lapor_hkp c
                                                                    ON a.id_lapor=c.id_lapor
                                                                    LEFT JOIN tbl_user d
                                                                    ON a.id_user=d.id_user
                                                                    ORDER by id_lapor DESC LIMIT $curr, $limit");

                                    if (mysqli_num_rows($query) > 0) {
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $no++;
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><strong><?= $row['no_lapor'] ?></strong><br/><hr/><?= indoDate($row['tgl_lapor']) ?></td>
                                                <td><?= ucwords(strtolower($row['divisi'])) ?><br/><hr><?= ucwords(strtolower($row['jenis_komplain'])) ?></td>
                                                <td><?= ucwords(strtolower($row['pemberi_komplain'])) ?><br/><hr><?= ucwords(strtolower($row['pekerjaan'])) ?></td>
                                                <td><strong><i><?= ucwords(strtolower($row['aksi_komplain'])) ?></i></strong></td>
                                                <td><?= nl2br(htmlentities($row['lokasi'])) ?><br/><br/><strong>Foto :</strong>
                                                    <?php
                                                    if (!empty($row['file'])) {
                                                        ?>
                                                        <strong><a href = "/./upload/lapor/<?= $row['file'] ?>"><img src="/./upload/lapor/<?= $row['file'] ?>" style="width: 100px"></a></strong>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <em>Tidak ada foto</em>
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td><strong><?= $row['nama'] ?></strong></td>
                                               <td><strong><?= $row['status_hkp'] ?><h6><?= $row['waktu_hkp'] ?></h6><br/><hr><?= $row['status_tk'] ?><h6><?= $row['waktu_tk'] ?></h6></strong></td>
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
                                                                    <div class="input-field col s12">
                                                                        <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                                                        <input type="hidden" id="id_lapor" name="id_lapor" value="<?= $row['id_lapor'] ?>" />
                                                                        <select name="status_hkp" class="browser-default validate" id="status_hkp" required>
                                                                            <option value="Progres">Progres</option>
                                                                            <option value="Material Kosong">Material Kosong</option>
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Selesai">Selesai</option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col 6">
                                                                    <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=lapor&act=ctk_lapor&id_lapor=<?= $row['id_lapor'] ?>">
                                                        <i class="material-icons">print</i>PRINT</a>
                                                     <a class="btn small blue darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=lapor&act=edit&id_lapor=<?= $row['id_lapor'] ?>">
                                                        <i class="material-icons">edit</i> EDIT</a
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
                $query = mysqli_query($config, "SELECT * FROM tbl_lapor");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=app_lapor&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=app_lapor&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=app_lapor&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=app_lapor&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=lapor&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=lapor&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
    