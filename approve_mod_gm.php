
<?php
//cek session
error_reporting(0);
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        $id_mod = $_REQUEST['id_mod'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_mod_gm WHERE id_mod='$id_mod'");
        $no = 1;
        list($id_mod) = mysqli_fetch_array($query);
        {

            $target_mod = $_POST['target_mod'];
            $catatan_gm = $_POST['catatan_gm'];
            $id_mod = $_REQUEST['id_mod'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_mod_gm where id_mod='$id_mod'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_mod_gm(target_mod,catatan_gm,id_mod,id_user)
                                        VALUES('$target_mod','$catatan_gm','$id_mod','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_mod_gm SET
                target_mod ='$target_mod',
                catatan_gm ='$catatan_gm',
                id_mod='$id_mod',
                id_user='$id_user' WHERE id_app_mod_gm=$cek_data_row[id_app_mod_gm]");
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

        //pagging
        $query = mysqli_query($config, "SELECT modku FROM tbl_sett");
        list($modku) = mysqli_fetch_array($query);

        //pagging
        $limit = $modku;
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
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <div class="col m7">
                                    <ul class="left">
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=mod&act=add" class="judul"><i class="material-icons">mail</i>E-MOD</a></li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=mod&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-medium-and-up">
                                    <form method="post" action="?page=mod">
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
                            <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=mod&act=app_mod_gm"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                        </div>
                    </div>
                </div>

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr> 
                                <th>No</th>
                                <th width="15%">No.MOD<br/><hr/>Tgl.MOD</th>
                        <th width="20%">Keterangan<br/><hr/>Tujuan Divisi</th>
                        <th width="18%">Dokumentasi</th>
                        <th width="18%">Petugas</th>
                        <th width="18%">Target GM</th>
                        <th width="18%">Status Laporan</th>
                        <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php
                            //script untuk mencari data
                            $query = mysqli_query($config, "SELECT a.*, 
                                                                    b.id_app_mod,status_mod,
                                                                    c.nama,
                                                                    d.id_app_mod_gm,target_mod,catatan_gm
                                                                    FROM tbl_modku a
                                                                    LEFT JOIN tbl_approve_mod b
                                                                    ON a.id_mod=b.id_mod
                                                                    LEFT JOIN tbl_user c
                                                                    ON a.id_user=c.id_user
                                                                    LEFT JOIN tbl_approve_mod_gm d
                                                                    ON a.id_mod=d.id_mod
                                                                    WHERE no_mod  LIKE '%$cari%' or tgl_mod
                                                                                        LIKE '%$cari%' or tujuan_div
                                                                                        LIKE '%$cari%' or keterangan_mod
                                                                                        LIKE '%$cari%' or status_mod 
                                                                                        LIKE '%$cari%' or nama
                                                                                        LIKE '%$cari%' ORDER by id_mod DESC");
                           if (mysqli_num_rows($query) > 0) {
                         $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_mod'] ?></strong><br/><hr/><?= indoDate($row['tgl_mod']) ?></td>
                                        <td><?= ucwords(strtolower($row['keterangan_mod'])) ?><br/><hr><strong><?= ucwords(strtolower($row['tujuan_div'])) ?></strong></td>
                                        <td><strong></strong>
                                            <?php
                                            if (!empty($row['file'])) {
                                                ?>
                                                <strong><a href = "/./upload/mod/<?= $row['file'] ?>"><img src="/./upload/mod/<?= $row['file'] ?>" style="width: 100px"></a></strong>
                                                <?php
                                            } else {
                                                ?>
                                                <em>Tidak ada foto</em>
                                            <?php }
                                            ?>
                                        </td>
                                        <td><strong><?= $row['nama'] ?></strong></td>
                                        <td><strong><?= indoDate($row['target_mod']) ?><br/><hr/><?= $row['catatan_gm'] ?></strong></td>
                                       <td><strong>
                                                <?php
                                                if (!empty($row['status_mod'])) {
                                                    echo ' <strong>' . $row['status_mod'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Progres Kosong</font></em>';
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
                                                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Target</a></li>
                                                                    </ul>
                                                                </div>
                                                            </nav>
                                                        </div>
                                                        <!-- Secondary Nav END -->
                                                    </div>

                                                    <div class="row jarak-form">
                                                        <form class="col s12" method="post" action="">
                                                            <div class="input-field col s9">
                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                <input type="hidden" id="id_mod" name="id_mod" class="datepicker" value="<?= $row['id_mod'] ?>" />
                                                                <?php
                                                                if (isset($_SESSION['target_mod'])) {
                                                                    $target_mod = $_SESSION['target_mod'];
                                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $target_mod . '</div>';
                                                                    unset($_SESSION['target_mod']);
                                                                }
                                                                ?>
                                                                <label for="target_mod">Tanggal Target</label>
                                                            </div>

                                                            <div class="input-field col s9">
                                                                <i class="material-icons prefix md-prefix">playlist_add</i>
                                                                <textarea id="catatan_gm" class="materialize-textarea validate" name="catatan_gm"></textarea>
                                                                <label for="catatan_gm">Catatan</label>
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
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=mod&act=ctk_mod&id_mod=<?= $row['id_mod'] ?>">
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
                                        <th width="15%">No.MOD<br/><hr/>Tgl.MOD</th>
                                <th width="20%">Keterangan<br/><hr/>Tujuan Divisi</th>
                                <th width="18%">Dokumentasi</th>
                                <th width="18%">Petugas</th>
                                <th width="18%">Target GM</th>
                                <th width="18%">Status Laporan</th>
                                <th width = "3%">Tindakan<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                                <div id = "modal" class = "modal">
                                    <div class = "modal-content white">
                                        <h5>Jumlah data yang ditampilkan per halaman</h5>
                                        <?php
                                        $query = mysqli_query($config, "SELECT id_sett,modku FROM tbl_sett");
                                        list($id_sett, $modku) = mysqli_fetch_array($query);
                                        ?>
                                        <div class="row">
                                            <form method="post" action="">
                                                <div class="input-field col s12">
                                                    <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                    <div class="input-field col s1" style="float: left;">
                                                        <i class="material-icons prefix md-prefix">looks_one</i>
                                                    </div>
                                                    <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                        <select class="browser-default validate" name="modku" required>
                                                            <option value="<?= $modku ?>"><?= $modku ?></option>
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
                                                            $modku = $_REQUEST['modku'];
                                                            $id_user = $_SESSION['id_user'];

                                                            $query = mysqli_query($config, "UPDATE tbl_sett SET modku='$modku',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                            if ($query == true) {
                                                                header("Location: ./admin.php?page=mod&act=app_mod_gm");
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
                                                                    b.id_app_mod,status_mod,catatan_gm,
                                                                    c.nama,
                                                                    d.id_app_mod_gm,target_mod
                                                                    FROM tbl_modku a
                                                                    LEFT JOIN tbl_approve_mod b
                                                                    ON a.id_mod=b.id_mod
                                                                    LEFT JOIN tbl_user c
                                                                    ON a.id_user=c.id_user
                                                                    LEFT JOIN tbl_approve_mod_gm d
                                                                    ON a.id_mod=d.id_mod
                                                                    ORDER by id_mod DESC LIMIT $curr, $limit");

                                    if (mysqli_num_rows($query) > 0) {
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $no++;
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><strong><?= $row['no_mod'] ?></strong><br/><hr/><?= indoDate($row['tgl_mod']) ?></td>
                                                <td><?= ucwords(strtolower($row['keterangan_mod'])) ?><br/><hr><strong><?= ucwords(strtolower($row['tujuan_div'])) ?></strong></td>
                                                <td><strong></strong>
                                                    <?php
                                                    if (!empty($row['file'])) {
                                                        ?>
                                                        <strong><a href = "/./upload/mod/<?= $row['file'] ?>"><img src="/./upload/mod/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <em>Tidak ada foto</em>
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td><strong><?= $row['nama'] ?></strong></td>
                                                 <td><strong><?= indoDate($row['target_mod']) ?><br/><hr/><?= $row['catatan_gm'] ?></strong></td>
                                                <td><strong>
                                                <?php
                                                if (!empty($row['status_mod'])) {
                                                    echo ' <strong>' . $row['status_mod'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Progres Kosong</font></em>';
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
                                                                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Target</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </nav>
                                                                </div>
                                                                <!-- Secondary Nav END -->
                                                            </div>

                                                            <div class="row jarak-form">
                                                                <form class="col s12" method="post" action="">
                                                                    <div class="input-field col s12">
                                                                        <i class="material-icons prefix md-prefix">date_range</i>
                                                                         <input type="hidden" id="id_mod" name="id_mod" value="<?= $row['id_mod'] ?>" />
                                                                        <input id="target_mod" type="text" name="target_mod" class="datepicker" required>
                                                                        <?php
                                                                        if (isset($_SESSION['target_mod'])) {
                                                                            $target_mod = $_SESSION['target_mod'];
                                                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $target_mod . '</div>';
                                                                            unset($_SESSION['target_mod']);
                                                                        }
                                                                        ?>
                                                                        <label for="target_mod">Target Pekerjaan</label>
                                                                    </div>
                                                                    
                                                                     
                                                                    
                                                                    <div class="input-field col s12">
                                                                        <i class="material-icons prefix md-prefix">playlist_add</i>
                                                                        <textarea id="catatan_gm" class="materialize-textarea validate" name="catatan_gm"></textarea>
                                                                        <label for="catatan_gm">Catatan</label>
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
                                                    <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=mod&act=ctk_mod&id_mod=<?= $row['id_mod'] ?>">
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
                $query = mysqli_query($config, "SELECT * FROM tbl_modku");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                if ($cdata > $limit) {

                    //first and previous pagging
                    if ($pg > 1) {
                        $prev = $pg - 1;
                        echo '<li><a href="?page=mod&act=app_mod_gm&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=mod&act=app_mod_gm&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                    } else {
                        echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                    }

                    //perulangan pagging
                    for ($i = 1; $i <= $cpg; $i++) {
                        if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                            if ($i == $pg)
                                echo '<li class="active waves-effect waves-dark"><a href="?page=mod&act=app_mod_gm&pg=' . $i . '"> ' . $i . ' </a></li>';
                            else
                                echo '<li class="waves-effect waves-dark"><a href="?page=mod&act=app_mod_gm&pg=' . $i . '"> ' . $i . ' </a></li>';
                        }
                    }

                    //last and next pagging
                    if ($pg < $cpg) {
                        $next = $pg + 1;
                        echo '<li><a href="?page=mod&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=mod&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
    