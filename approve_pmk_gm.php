<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        //print_r($_POST);die;
        $id_surat = $_REQUEST['id_surat'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_gm WHERE id_surat='$id_surat'");
        $no = 1;
        list($id_surat) = mysqli_fetch_array($query); {

            $gm = $_POST['gm'];
            $id_surat = $_REQUEST['id_surat'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_gm where id_surat='$id_surat'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_gm(gm,id_surat,id_user)
                                            VALUES('$gm','$id_surat','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_gm SET
                    gm='$gm',
                    id_surat='$id_surat',
                    id_user='$id_user' WHERE id_approve_gm=$cek_data_row[id_approve_gm]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                     window.history.go(-1);
                                                  </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {
        if (isset($_POST['submit_cari'])) {
            //print_r($_POST);die;
            $id_surat = $_POST['id_surat'];
            $query = mysqli_query($config, "SELECT * FROM tbl_approve_gm WHERE id_surat='$id_surat'");
            $no = 1;
            list($id_surat) = mysqli_fetch_array($query); {

                $gm = $_POST['gm'];
                $id_surat = $_POST['id_surat'];
                $id_user = $_SESSION['id_user'];
                $cek_data_qry = mysqli_query($config, "select * from tbl_approve_gm where id_surat='$id_surat'");
                $cek_data = mysqli_num_rows($cek_data_qry);
                $cek_data_row = mysqli_fetch_array($cek_data_qry);
                if ($cek_data == 0) {
                    $query = mysqli_query($config, "INSERT INTO tbl_approve_gm(gm,id_surat,id_user)
                                        VALUES('$gm','$id_surat','$id_user')");
                } else {
                    $query = mysqli_query($config, "UPDATE tbl_approve_gm SET
                gm='$gm',
                id_surat='$id_surat',
                id_user='$id_user' WHERE id_disposisi=$cek_data_row[id_approve_gm]");
                }

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    echo '<script language="javascript">
                                                window.location.href="./admin.php?page=app_gm";
                                              </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        } else {

            //pagging
            $query = mysqli_query($config, "SELECT surat_masuk FROM tbl_sett");
            list($surat_masuk) = mysqli_fetch_array($query);

            //pagging
            $limit = $surat_masuk;
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
                                        <li class="col s5 waves-effect waves-light show-on-small-only"><a href="#" class="judul"><i class="material-icons">mail</i>E-PMK</a></li>
                                        <div class="col s6 show-on-medium-and-up">
                                            <form method="post" action="?page=app_gm">
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
            if (isset($_REQUEST['submito'])) {
                $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                echo '
                            <div class="col s12" style="margin-top: -18px;">
                                <div class="card blue lighten-5">
                                    <div class="card-content">
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=app_gm"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                    </div>
                                </div>
                            </div>
    
                          <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr><th>No</th>
                                        <th width="5%">No.PMK<br/><hr/>Status</th>
                                        <th width="40%">Jenis Pekerjaan<br/><hr/>File</th>
                                        <th width="15%">Lokasi<br/><hr/>Nama Perusahaan</th>
                                        <th width="10%">Ditujukan Kepada<br/><hr/>Tgl.Surat</th>
                                        <th width = "10%">Disetujui.Mng<br/><hr/>Diketahui.GM</th>
                                        <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                    </tr>
                                </thead>
                                <tbody>';

                //script untuk mencari data
                $query = mysqli_query($config, "SELECT a.*,
                                                               b.manager_mkt,
                                                               c.id_lpt,
                                                               d.id_approve_gm,gm,
                                                               e.id_lpg
                                                               FROM tbl_surat_masuk a
                                                                LEFT JOIN tbl_disposisi b 
                                                               ON a.id_surat=b.id_surat 
                                                                LEFT JOIN tbl_lpt c 
                                                               ON a.id_surat=c. id_surat
                                                                LEFT JOIN tbl_approve_gm d
                                                               ON a.id_surat=d.id_surat
                                                                LEFT JOIN tbl_lpg e
                                                               ON a.id_surat=e.id_surat
                                                               WHERE 
                                                               no_agenda LIKE '%$cari%'or
                                                               isi LIKE '%$cari%'or 
                                                               divisi LIKE '%$cari%' or 
                                                               gm LIKE '%$cari%' or 
                                                               indeks LIKE '%$cari%' 
                                                               ORDER by id_surat DESC");
                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><strong><?= $row['no_agenda'] ?><br/><hr/><?= $row['status'] ?></strong></td>
                                <td><?= ucwords(nl2br(htmlentities(strtolower($row['isi'])))) ?><br/><br/><strong>File :<a href="?page=gsm&act=fsm&id_surat=<?= $row['id_surat'] ?>"><?= $row['file'] ?></strong>'
                                <td><?= ucwords(strtolower($row['asal_surat'])) ?><br/><hr><?= ucwords(strtolower($row['indeks'])) ?></td>
                                <td><?= ucwords(strtolower($row['no_surat'])) ?> <br/><hr/><?= indoDate($row['tgl_surat']) ?></td>
                                <td><strong>
                                                <?php
                                                if (!empty($row['manager_mkt'])) {
                                                    echo ' <strong>' . $row['manager_mkt'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Manager Kosong</font></em>';
                                                }
                                                ?>
                                                <br/><hr>
                                                <?php
                                                if (!empty($row['gm'])) {
                                                    echo ' <strong>' . $row['gm'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">GM Kosong</font></em>';
                                                }
                                                ?>
                                </strong></td>
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
                                                        <input type="hidden" id="id_surat" name="id_surat" value="<?= $row['id_surat'] ?>" />
                                                        <select name="gm" class="browser-default validate" id="gm" required>
                                                            <option value=""></option>
                                                            <option value="Diterima">Diterima</option>
                                                            <option value="Ditolak">Ditolak</option>
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
                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $row['id_surat'] ?>" target="_blank">
                                        <i class="material-icons">print</i>PRINT
                                    </a>
                                    </form>
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
                                    <th width = "10%">No.PMK<br/><hr/>Status PMK</th>
                            <th width = "34%">Jenis Pekerjaan<br/><hr/> File</th>
                            <th width = "20%">Lokasi<br/><hr/>Nama Perusahaan</th>
                            <th width = "10%">Ditujukan Kepada<br/><hr/>Tanggal Surat</th>
                            <th width = "10%">Disetujui.Mng<br/><hr/>Diketahui.GM</th>
                            <th width = "10%">Tindakan<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                            <div id = "modal" class = "modal">
                                <div class = "modal-content white">
                                    <h5>Jumlah data yang ditampilkan per halaman</h5>
                                    <?php
                                    $query = mysqli_query($config, "SELECT id_sett,surat_masuk FROM tbl_sett");
                                    list($id_sett, $surat_masuk) = mysqli_fetch_array($query);
                                    ?>
                                    <div class="row">
                                        <form method="post" action="">
                                            <div class="input-field col s12">
                                                <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                <div class="input-field col s1" style="float: left;">
                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                </div>
                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                    <select class="browser-default validate" name="surat_masuk" required>
                                                        <option value="<?= $surat_masuk ?>"><?= $surat_masuk ?></option>
                                                       <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                        <option value="200">200</option>
                                                                        <option value="300">300</option>
                                                                        <option value="400">400</option>
                                                                        <option value="500">400</option>
                                                                        <option value="800">800</option>
                                                                        <option value="1000">1000</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer white">
                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>
                                                    <?php
                                                    if (isset($_REQUEST['simpan'])) {
                                                        $id_sett = "1";
                                                        $surat_masuk = $_REQUEST['surat_masuk'];
                                                        $id_user = $_SESSION['id_user'];

                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET surat_masuk='$surat_masuk',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                        if ($query == true) {
                                                            header("Location: ./admin.php?page=app_gm");
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
                                                               b.manager_mkt,
                                                               c.id_lpt, 
                                                               d.gm,
                                                               e.id_lpg
                                                               FROM tbl_surat_masuk a
                                                               LEFT JOIN tbl_disposisi b 
                                                               ON a.id_surat=b.id_surat 
                                                               LEFT JOIN tbl_lpt c
                                                               ON a.id_surat=c.id_surat
                                                               LEFT JOIN tbl_approve_gm d 
                                                               ON a.id_surat=d.id_surat
                                                               LEFT JOIN tbl_lpg e
                                                               ON a.id_surat=e.id_surat
                                                               ORDER by id_surat DESC LIMIT $curr, $limit");

                                if (mysqli_num_rows($query) > 0) {
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><?= $row['no_agenda'] ?><br/><hr/><?= $row['status'] ?></strong></td>
                                            <td><?= ucwords(nl2br(htmlentities(strtolower($row['isi'])))) ?><br/><br/><strong>File :</strong>
                                                <?php
                                                if (!empty($row['file'])) {
                                                    echo ' <strong><a href="?page=gsm&act=fsm&id_surat=' . $row['id_surat'] . '">' . $row['file'] . '</strong>';
                                                } else {
                                                    echo '<em>Tidak ada file yang di upload</em>';
                                                }
                                                ?>
                                            </td>
                                            <td><?= ucwords(strtolower($row['asal_surat'])) ?><br/><hr><?= ucwords(strtolower($row['indeks'])) ?></td>
                                            <td><?= ucwords(strtolower($row['divisi'])) ?> <br/><hr/><?= indoDate($row['tgl_surat']) ?></td>
                                            <td><strong>
                                                <?php
                                                if (!empty($row['manager_mkt'])) {
                                                    echo ' <strong>' . $row['manager_mkt'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Manager Kosong</font></em>';
                                                }
                                                ?>
                                                <br/><hr>
                                                <?php
                                                if (!empty($row['gm'])) {
                                                    echo ' <strong>' . $row['gm'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">GM Kosong</font></em>';
                                                }
                                                ?>
                                            </strong></td>
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
                                                                    <input type="hidden" id="id_surat" name="id_surat" value="<?= $row['id_surat'] ?>" />
                                                                    <select name="gm" class="browser-default validate" id="gm" required>
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
                                                <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=<?= $row['id_surat'] ?>" target="_blank">
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
                $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
                              <ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=app_gm&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                      <li><a href="?page=app_gm&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                      <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=app_gm&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=app_gm&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=tsm&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                      <li><a href="?page=tsm&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
}
?>
        