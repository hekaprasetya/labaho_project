<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        //print_r($_POST);die;
        $id_ppp = $_REQUEST['id_ppp'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_ppp WHERE id_ppp='$id_ppp'");
        $no = 1;
        list($id_ppp) = mysqli_fetch_array($query); {

            $status_ppp = $_POST['status_ppp'];
            $id_ppp = $_REQUEST['id_ppp'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_ppp where id_ppp='$id_ppp'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_ppp(status_ppp,id_ppp,id_user)
                                            VALUES('$status_ppp','$id_ppp','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_ppp SET
                    status_ppp='$status_ppp',
                    id_ppp='$id_ppp',
                    id_user='$id_user' WHERE id_app_ppp=$cek_data_row[id_app_ppp]");
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
            $id_ppp = $_POST['id_ppp'];
            $query = mysqli_query($config, "SELECT * FROM tbl_approve_ppp WHERE id_ppp='$id_ppp'");
            $no = 1;
            list($id_ppp) = mysqli_fetch_array($query); {

                $status_ppp = $_POST['status_ppp'];
                $id_ppp = $_POST['id_ppp'];
                $id_user = $_SESSION['id_user'];
                $cek_data_qry = mysqli_query($config, "select * from tbl_approve_ppp where id_ppp='$id_ppp'");
                $cek_data = mysqli_num_rows($cek_data_qry);
                $cek_data_row = mysqli_fetch_array($cek_data_qry);
                if ($cek_data == 0) {
                    $query = mysqli_query($config, "INSERT INTO tbl_approve_ppp(status_ppp,id_ppp,id_user)
                                        VALUES('$gm','$id_ppp','$id_user')");
                } else {
                    $query = mysqli_query($config, "UPDATE tbl_approve_ppp SET
                status_ppp='$status_ppp',
                id_ppp='$id_ppp',
                id_user='$id_user' WHERE id_app_ppp=$cek_data_row[id_app_ppp]");
                }

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    echo '<script language="javascript">
                                                window.location.href="./admin.php?page=ppp&act=app_ppp";
                                              </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        } else {

            //pagging
            $query = mysqli_query($config, "SELECT ppp FROM tbl_sett");
            list($ppp) = mysqli_fetch_array($query);

            //pagging
            $limit = $ppp;
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
                                <div class="col m12">
                                    <ul class="left">
                                        <li class="col s5 waves-effect waves-light show-on-small-only"><a href="#" class="judul"><i class="material-icons">mail</i>E-PARKIR</a></li>
                                        <div class="col s6 show-on-medium-and-up">
                                            <form method="post" action="?page=ppp&act=app_ppp">
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
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=ppp&act=app_ppp"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                    </div>
                                </div>
                            </div>
    
                          <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                            <tr>
                                <th>No</th>
                                <th width="15%">No.PPP<br/><hr/>Tgl.PPP</th>
                                <th width="10%"><font color="green"><i class="material-icons">location_on</i></font>Lokasi</th>
                                <th width="17%"><font color="green"><i class="material-icons">home</i></font> Nama Perusahaan</th>
                                <th width="20%"><font color="green"><i class="material-icons">build</i></font> Permintaan Pekerjaan</th>
                                <th width="20%"><font color="green"><i class="material-icons">collections</i></font> File</th>
                                <th width="28%"><font color="green"><i class="material-icons">person</i></font>Marketing Manager<br/><hr/><i class="material-icons"><font color="green">person</i></font>Finance Manager</th>
                                <th width="25%"><font color="green"><i class="material-icons">person</i></font>Adm.Parkir</th>
                                <th width="18%"><font color="green"><i class="material-icons">pan_tool</i></font> Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"></a></span></th>
                            <th width = "3%">Atur Baris<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                            </tr>
                                </thead>
                                <tbody>';

                //script untuk mencari data
                $query = mysqli_query($config, "SELECT a.*, 
                                                       b.id_app_ppp,status_ppp,
                                                       c.id_app_ppp_keu,status_ppp_keu,
                                                       d.id_app_ppp_parkir,status_ppp_parkir
                                                                   
                                                       FROM tbl_ppp a
                                                       LEFT JOIN tbl_approve_ppp b
                                                       ON a.id_ppp=b.id_ppp
                                                       LEFT JOIN tbl_approve_ppp_keu c
                                                       ON a.id_ppp=c.id_ppp
                                                       LEFT JOIN tbl_approve_ppp_parkir d
                                                       ON a.id_ppp=d.id_ppp
                                                                    
                                                       WHERE no_ppp             LIKE '%$cari%'
                                                       or tgl_ppp               LIKE '%$cari%'
                                                       or lokasi_ppp            LIKE '%$cari%' 
                                                       or nama_perusahaan       LIKE '%$cari%' 
                                                       or permintaan_pekerjaan  LIKE '%$cari%' 
                                                                          
                                                       ORDER by id_ppp DESC");
                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><strong><?= $row['no_ppp'] ?></strong><br/><hr/><?= indoDate($row['tgl_ppp']) ?></td>
                                <td><?= ucwords(strtolower($row['lokasi_ppp'])) ?></td>
                                <td><?= ucwords(strtolower($row['nama_perusahaan'])) ?></td>
                                <td><?= ucwords(strtolower($row['permintaan_pekerjaan'])) ?></td>
                                <td>
                        <?php
                        if (!empty($row['file'])) {
                            ?>
                                        <strong><a href="?page=gppp&act=fppp&id_ppp=<?= $row['id_ppp'] ?>"><?= $row['file'] ?></a></strong>
                                        <?php
                                    } else {
                                        ?>
                                        <em><font color="red">Tidak ada</em></font>
                                    <?php }
                                    ?>
                                </td>
                                <td>
                        <?php
                        if (!empty($row['status_ppp'])) {
                            ?> <strong><?= $row['status_ppp'] ?></a></strong>
                                        <?php
                                    } else {
                                        ?> <font color="red"><i>Kabag Kosong</i></font>
                                    <?php }
                                    ?><br/><hr/>
                                    <?php
                                    if (!empty($row['status_ppp_keu'])) {
                                        ?> <strong><?= $row['status_ppp_keu'] ?></a></strong>
                                        <?php
                                    } else {
                                        ?> <font color="red"><i>Keuangan Kosong</i></font>
                                    <?php }
                                    ?>
                                </td>
                                <td>
                        <?php
                        if (!empty($row['status_ppp_parkir'])) {
                            ?> <strong><?= $row['status_ppp_parkir'] ?></a></strong>
                                        <?php
                                    } else {
                                        ?> <font color="red"><i>Adm.Parkir Kosong</i></font>

                                    <?php }
                                    ?>
                                </td>
                                <td><a class="btn small green darken-2 waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Approval" href="#modal<?= $no ?>">
                                                    <i class="material-icons">touch_app</i></a>
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
                                                        <input type="hidden" id="id_ppp" name="id_ppp" value="<?= $row['id_ppp'] ?>" />
                                                        <select name="status_ppp" class="browser-default validate" id="status_ppp" required>
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
                                    <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print" href="?page=ppp&act=ctk_ppp&id_ppp=<?= $row['id_ppp'] ?>">
                                        <i class="material-icons">print</i>PRINT</a>
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
                                    <th width="15%">No.PPP<br/><hr/>Tgl.PPP</th>
                            <th width="10%"><font color="green"><i class="material-icons">location_on</i></font>Lokasi</th>
                            <th width="17%"><font color="green"><i class="material-icons">home</i></font> Nama Perusahaan</th>
                            <th width="20%"><font color="green"><i class="material-icons">build</i></font> Permintaan Pekerjaan</th>
                            <th width="20%"><font color="green"><i class="material-icons">collections</i></font> File</th>
                            <th width="28%"><font color="green"><i class="material-icons">person</i></font>Marketing Manager<br/><hr/><i class="material-icons"><font color="green">person</i></font>Finance Manager</th>
                            <th width="25%"><font color="green"><i class="material-icons">person</i></font>Adm.Parkir</th>
                            <th width="18%"><font color="green"><i class="material-icons">pan_tool</i></font> Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"></a></span></th>
                            <th width = "3%">Atur Baris<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                            <div id = "modal" class = "modal">
                                <div class = "modal-content white">
                                    <h5>Jumlah data yang ditampilkan per halaman</h5>
                <?php
                $query = mysqli_query($config, "SELECT id_sett,ppp FROM tbl_sett");
                list($id_sett, $ppp) = mysqli_fetch_array($query);
                ?>
                                    <div class="row">
                                        <form method="post" action="">
                                            <div class="input-field col s12">
                                                <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                <div class="input-field col s1" style="float: left;">
                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                </div>
                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                    <select class="browser-default validate" name="ppp" required>
                                                        <option value="<?= $ppp ?>"><?= $ppp ?></option>
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
                    $ppp = $_REQUEST['ppp'];
                    $id_user = $_SESSION['id_user'];

                    $query = mysqli_query($config, "UPDATE tbl_sett SET ppp='$ppp',id_user='$id_user' WHERE id_sett='$id_sett'");
                    if ($query == true) {
                        header("Location: ./admin.php?page=ppp&act=app_ppp");
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
                                                                       b.id_app_ppp,status_ppp,
                                                                       c.id_app_ppp_keu,status_ppp_keu,
                                                                       d.id_app_ppp_parkir,status_ppp_parkir
                                                                   
                                                                    FROM tbl_ppp a
                                                                    LEFT JOIN tbl_approve_ppp b
                                                                    ON a.id_ppp=b.id_ppp
                                                                    LEFT JOIN tbl_approve_ppp_keu c
                                                                    ON a.id_ppp=c.id_ppp
                                                                    LEFT JOIN tbl_approve_ppp_parkir d
                                                                    ON a.id_ppp=d.id_ppp
                                                                   
                                                                    ORDER by id_ppp DESC ");

                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;
                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><?= $row['no_ppp'] ?></strong><br/><hr/><?= indoDate($row['tgl_ppp']) ?></td>
                                            <td><?= ucwords(strtolower($row['lokasi_ppp'])) ?></td>
                                            <td><?= ucwords(strtolower($row['nama_perusahaan'])) ?></td>
                                            <td><?= ucwords(strtolower($row['permintaan_pekerjaan'])) ?></td>
                                            <td>
                        <?php
                        if (!empty($row['file'])) {
                            ?>
                                                    <strong><a href="?page=gppp&act=fppp&id_ppp=<?= $row['id_ppp'] ?>"><?= $row['file'] ?></a></strong>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <em><font color="red">Tidak ada</em></font>
                                                <?php }
                                                ?>
                                            </td>
                                            <td>
                        <?php
                        if (!empty($row['status_ppp'])) {
                            ?> <strong><?= $row['status_ppp'] ?></a></strong>
                                                    <?php
                                                } else {
                                                    ?> <font color="red"><i>Kabag Kosong</i></font>
                                                <?php }
                                                ?><br/><hr/>
                                                <?php
                                                if (!empty($row['status_ppp_keu'])) {
                                                    ?> <strong><?= $row['status_ppp_keu'] ?></a></strong>
                                                    <?php
                                                } else {
                                                    ?> <font color="red"><i>Keuangan Kosong</i></font>
                                                <?php }
                                                ?>
                                            </td>
                                            <td>
                        <?php
                        if (!empty($row['status_ppp_parkir'])) {
                            ?> <strong><?= $row['status_ppp_parkir'] ?></a></strong>
                                                    <?php
                                                } else {
                                                    ?> <font color="red"><i>Adm.Parkir Kosong</i></font>

                                                <?php }
                                                ?>
                                            </td>

                                            <td><a class="btn small green darken-2 waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Approval" href="#modal<?= $no ?>">
                                                    <i class="material-icons">touch_app</i></a>
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
                                                                    <input type="hidden" id="id_ppp" name="id_ppp" value="<?= $row['id_ppp'] ?>" />
                                                                    <select name="status_ppp" class="browser-default validate" id="status_ppp" required>
                                                                        <option value="Pilih Status">Pilih Status</option>
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
                                                <a class="btn small yellow darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Print" href="?page=ppp&act=ctk_ppp&id_ppp=<?= $row['id_ppp'] ?>">
                                                    <i class="material-icons">print</i></a>
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
                $query = mysqli_query($config, "SELECT * FROM tbl_ppp");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
                              <ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=ppp&act=app_ppp&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                      <li><a href="?page=ppp&act=app_ppp&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                      <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=ppp&act=app_ppp&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=ppp&act=app_ppp&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=ppp&act=app_ppp&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                      <li><a href="?page=ppp&act=app_ppp&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
        