<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        //print_r($_POST);die;
        $id_pa = $_REQUEST['id_pa'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_pa WHERE id_pa='$id_pa'");
        $no = 1;
        list($id_pa) = mysqli_fetch_array($query); {

            $mng_mkt = $_POST['mng_mkt'];
            $id_pa = $_REQUEST['id_pa'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_pa where id_pa='$id_pa'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_pa(mng_mkt,id_pa,id_user)
                                        VALUES('$mng_mkt','$id_pa','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_pa SET
                mng_mkt     ='$mng_mkt',
                id_pa       ='$id_pa',
                id_user     ='$id_user' WHERE id_approve_pa=$cek_data_row[id_approve_pa]");
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
        if (isset($_REQUEST['submit_cari'])) {
            //print_r($_POST);die;
            $id_pa = $_REQUEST['id_pa'];
            $query = mysqli_query($config, "SELECT * FROM tbl_approve_pa WHERE id_pa='$id_pa'");
            $no = 1;
            list($id_pa) = mysqli_fetch_array($query); {

                $mng_mkt = $_POST['mng_mkt'];
                $id_pa = $_REQUEST['id_pa'];
                $id_user = $_SESSION['id_user'];
                $cek_data_qry = mysqli_query($config, "select * from tbl_approve_pa where id_pa='$id_pa'");
                $cek_data = mysqli_num_rows($cek_data_qry);
                $cek_data_row = mysqli_fetch_array($cek_data_qry);
                if ($cek_data == 0) {
                    $query = mysqli_query($config, "INSERT INTO tbl_approve_pa(mng_mkt,id_pa,id_user)
                                        VALUES('$mng_mkt','$id_pa','$id_user')");
                } else {
                    $query = mysqli_query($config, "UPDATE tbl_approve_pa SET
                mng_mkt     ='$mng_mkt',
                id_pa       ='$id_pa',
                id_user     ='$id_user' WHERE id_approve_pa=$cek_data_row[id_approve_pa]");
                }
 
                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=app_pa");
                            die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        } else {

            //pagging
            $query = mysqli_query($config, "SELECT permintaan_acara FROM tbl_sett");
            list($permintaan_acara) = mysqli_fetch_array($query);

            //pagging
            $limit = $permintaan_acara;
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
                                        <li class="col s5 waves-effect waves-light show-on-small-only"><a href="#" class="judul"><i class="material-icons">mail</i>E-PA</a></li>
                                        <div class="col s6 show-on-medium-and-up">
                                            <form method="post" action="?page=app_pa">
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
                ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=app_pa"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                            <th>No</th>
                            <th width="15%">No.PA<br/><hr/>Tanggal Buat</th>
                            <th width="20%">Nama Perusahaan<br/><hr/>Status Surat</th>
                            <th width="10%">Penanggung Jawab<br/><hr/>No.Telp</th>
                            <th width="18%">Ruangan Sewa<br/><hr/>Judul</th>
                            <th width="10%">Jadwal Acara<br/><hr/>Jam</th>
                            <th width="7%">Approve Manager</th>
                            <th width="10%">Bukti TF</th>
                            <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                            </tr>
                            </thead>
                            <tbody>

                <?php
                //script untuk mencari data
                $query = mysqli_query($config, "SELECT a.*, 
                                                       b.mng_mkt,
                                                       c.id_hasil,
                                                       d.id_tf,
                                                       e.file_tf
                                                       FROM tbl_pa a
                                                       LEFT JOIN tbl_approve_pa b
                                                       ON a.id_pa=b.id_pa
                                                       LEFT JOIN tbl_pa_hasil c
                                                       ON a.id_pa=c.id_pa
                                                       LEFT JOIN tbl_pa_tf d
                                                       ON a.id_pa=d.id_pa
                                                       LEFT JOIN tbl_pa_tf e
                                                       ON a.id_pa=e.id_pa 
                                                                    
                                                       WHERE no_pa LIKE '%$cari%' or 
                                                       nama_perusahaan LIKE '%$cari%' or 
                                                       penanggung_jawab LIKE '%$cari%' or
                                                       no_telp LIKE '%$cari%' or 
                                                       judul LIKE '%$cari%' or 
                                                       jam LIKE '%$cari%' or
                                                       ruangan_sewa LIKE '%$cari%' 
                                                       ORDER by id_pa DESC");

                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;
                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><strong><?= $row['no_pa'] ?></strong><br/><hr/><?= indoDate($row['tgl_pa']) ?></td>
                                            <td><?= ucwords(strtolower($row['nama_perusahaan'])) ?><br/><hr><strong><i><?= $row['status'] ?></i></strong></td>
                                            <td><?= ucwords(strtolower($row['penanggung_jawab'])) ?><br/><hr><?= $row['no_telp'] ?></td>
                                            <td><?= $row['ruangan_sewa'] ?><br/><hr/><?= ucwords(strtolower($row['judul'])) ?></td>
                                            <td><strong><i><?= indoDate($row['tgl_acara']) ?></i></strong><br/><hr/><?= $row['jam'] ?></td>
                                            <td><strong><?= $row['mng_mkt'] ?></strong></td>
                                            <td>
                        <?php
                        if (!empty($row['file_tf'])) {
                            ?>
                                                    <strong><a href = "/./upload/bukti_tf/<?= $row['file_tf'] ?>"><img src="/./upload/bukti_tf/<?= $row['file_tf'] ?>" style="width: 100px"></a></strong>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <em>Tidak ada foto</em>
                                                <?php }
                                                ?>
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
                                                                    <input type="hidden" id="id_pa" name="id_pa" value="<?= $row['id_pa'] ?>" />
                                                                    <select name="mng_mkt" class="browser-default validate" id="mng_mkt" required>
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
                                                </form>
                                             
                                                     <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_pa&id_pa=<?= $row['id_pa'] ?>">
                                                            <i class="material-icons">print</i>PRINT</a>
                                            </td>
                                        </tr>
                        <?php
                    }
                } else {
                    ?>
                                    <tr>
                                        <td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>
                    <?php
                }
                ?>
                            </tbody>
                        </table>
                        <br/><br/>
                    </div>
                </div>
                <!-- Row form END -->
                <?php
            } else {
                ?>

                <div class = "col m12" id = "colres">
                    <table class = "bordered" id = "tbl">
                        <thead class = "blue lighten-4" id = "head">
                            <tr>
                                <th>No</th>
                                <th width="15%">No.PA<br/><hr/>Tanggal Buat</th>
                        <th width="20%">Nama Perusahaan<br/><hr/>Status Surat</th>
                        <th width="10%">Penanggung Jawab<br/><hr/>No.Telp</th>
                        <th width="18%">Ruangan Sewa<br/><hr/>Judul</th>
                        <th width="10%">Jadwal Acara<br/><hr/>Jam</th>
                        <th width="7%">Approve Manager</th>
                        <th width="10%">Bukti TF</th>
                        <th width = "3%">Tindakan<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                        <div id = "modal" class = "modal">
                            <div class = "modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                <?php
                $query = mysqli_query($config, "SELECT id_sett,permintaan_acara FROM tbl_sett");
                list($id_sett, $permintaan_acara) = mysqli_fetch_array($query);
                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="permintaan_acara" required>
                                                    <option value="<?= $permintaan_acara ?>"><?= $permintaan_acara ?></option>
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
                    $permintaan_acara = $_REQUEST['permintaan_acara'];
                    $id_user = $_SESSION['id_user'];

                    $query = mysqli_query($config, "UPDATE tbl_sett SET permintaan_acara='$permintaan_acara',id_user='$id_user' WHERE id_sett='$id_sett'");
                    if ($query == true) {
                        header("Location: ./admin.php?page=app_pa");
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
                                                                    b.mng_mkt,
                                                                    c.id_hasil,
                                                                    d.id_tf,
                                                                    e.file_tf
                                                                    FROM tbl_pa a
                                                                    LEFT JOIN tbl_approve_pa b
                                                                    ON a.id_pa=b.id_pa
                                                                    LEFT JOIN tbl_pa_hasil c
                                                                    ON a.id_pa=c.id_pa
                                                                    LEFT JOIN tbl_pa_tf d
                                                                    ON a.id_pa=d.id_pa
                                                                    LEFT JOIN tbl_pa_tf e
                                                                    ON a.id_pa=e.id_pa 
                                                           ORDER by id_pa DESC LIMIT $curr, $limit");

                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;
                        ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_pa'] ?></strong><br/><hr/><?= indoDate($row['tgl_pa']) ?></td>
                                        <td><?= ucwords(strtolower($row['nama_perusahaan'])) ?><br/><hr><strong><i><?= $row['status'] ?></i></strong></td>
                                        <td><?= ucwords(strtolower($row['penanggung_jawab'])) ?><br/><hr><?= $row['no_telp'] ?></td>
                                        <td><?= $row['ruangan_sewa'] ?><br/><hr/><?= ucwords(strtolower($row['judul'])) ?></td>
                                        <td><strong><i><?= indoDate($row['tgl_acara']) ?></i></strong><br/><hr/><?= $row['jam'] ?></td>
                                        <td><strong><?= $row['mng_mkt'] ?></strong></td>
                                        <td>
                        <?php
                        if (!empty($row['file_tf'])) {
                            ?>
                                                <strong><a href = "/./upload/bukti_tf/<?= $row['file_tf'] ?>"><img src="/./upload/bukti_tf/<?= $row['file_tf'] ?>" style="width: 100px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em>Tidak ada foto</em>
                                            <?php }
                                            ?>
                                        </td>
                                        <td><a class="btn small green darken-2 modal-trigger" href="#modal<?= $no ?>">APPROVE</i></a></span>
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
                                                                <input type="hidden" id="id_pa" name="id_pa" value="<?= $row['id_pa'] ?>" />
                                                                <select name="mng_mkt" class="browser-default validate" id="mng_mkt" required>
                                                                    <option value=""></option>
                                                                    <option value="Diterima">Diterima</option>
                                                                    <option value="Ditolak">Ditolak</option>
                                                                </select>
                                                            </div>
                                                    </div

                                                    <div class="row">
                                                        <div class="col 6">
                                                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk_pa_hasil&id_pa= <?= $row['id_pa'] ?>" target="_blank">
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
                $query = mysqli_query($config, "SELECT * FROM tbl_pa");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!--Pagination START-->
                            <ul class = "pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href = "?page=app_pa&pg=1"><i class = "material-icons md-48">first_page</i></a></li>
                            <li><a href = "?page=app_pa&pg=' . $prev . '"><i class = "material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class = "disabled"><a href = "#"><i class = "material-icons md-48">first_page</i></a></li>
                            <li class = "disabled"><a href = "#"><i class = "material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class = "active waves-effect waves-dark"><a href = "?page=app_pa&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class = "waves-effect waves-dark"><a href = "?page=app_pa&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href = "?page=pa&pg=' . $next . '"><i class = "material-icons md-48">chevron_right</i></a></li>
                            <li><a href = "?page=pa&pg=' . $cpg . '"><i class = "material-icons md-48">last_page</i></a></li>';
                    } else {
                        echo '<li class = "disabled"><a href = "#"><i class = "material-icons md-48">chevron_right</i></a></li>
                            <li class = "disabled"><a href = "#"><i class = "material-icons md-48">last_page</i></a></li>';
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
    