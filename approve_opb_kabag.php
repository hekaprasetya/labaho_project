<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        // print_r($_POST);die;
        $id_opb = $_REQUEST['id_opb'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_opb_kabag WHERE id_opb='$id_opb'");
        $no = 1;
        list($id_opb) = mysqli_fetch_array($query); {

            $id_opb = $_REQUEST['id_opb'];
            $status_opb_kabag = $_POST['status_opb_kabag'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * FROM tbl_approve_opb_kabag where id_opb='$id_opb'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_opb_kabag(status_opb_kabag,id_opb,id_user)
                                        VALUES('$status_opb_kabag','$id_opb','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_opb_kabag SET
                status_opb_kabag='$status_opb_kabag',
                id_opb='$id_opb',id_user='$id_user' WHERE id_app_opb_kabag=$cek_data_row[id_app_opb_kabag]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=opb";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {
        //pagging
        $limit = 5;
        $pg = @$_GET['pg'];
        if (empty($pg)) {
            $curr = 0;
            $pg = 1;
        } else {
            $curr = ($pg - 1) * $limit;
        }

        $id_opb = $_REQUEST['id_opb'];



        if (isset($_REQUEST['submit'])) {
            //print_r($_POST);die;
            $id_opb = $_REQUEST['id_opb'];
            $query = mysqli_query($config, "SELECT * FROM tbl_kabag_opb WHERE id_opb='$id_opb'");
            $no = 1;
            list($id_opb_detail) = mysqli_fetch_array($query); {
                $id_opb = $_REQUEST['id_opb'];
                $terbit_kabag = $_POST['terbit_kabag'];
                $id_user = $_SESSION['id_user'];
                $cek_data_qry = mysqli_query($config, "select * from tbl_kabag_opb where id_opb_detail='$id_opb_detail'");
                $cek_data = mysqli_num_rows($cek_data_qry);
                $cek_data_row = mysqli_fetch_array($cek_data_qry);
                if ($cek_data == 0) {
                    $query = mysqli_query($config, "INSERT INTO tbl_kabag_opb(status_opb_kabag,id_opb_detail,id_opb,id_user)
                                        VALUES('$status_opb_kabag''$id_opb_detail','$id_opb','$id_user')");
                    // $query = mysqli_query($config, "UPDATE tbl_gm_pp SET  status_gm='$status_gm', catatan_gm='$catatan_gm', id_barang='$id_barang_detail', id_pp='$id_pp', id_user='$id_user' WHERE id_pp='$id_pp'");
                } else {
                    $query = mysqli_query($config, "UPDATE tbl_kabag_opb SET
                status_opb_kabag='$status_opb_kabag',
                id_opb_detail='$id_opb_detail',
                    id_opb='$id_opb',id_user='$id_user' WHERE id_app_opb_kabag=$cek_data_row[id_app_opb_kabag]");
                }

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    echo '<script language="javascript">
                                                window.location.href="./admin.php?page=opb&act=app_kabag_opb&id_opb=' . $id_opb . '";
                                              </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        } else {

            //pagging
            $limit = 5;
            $pg = @$_GET['pg'];
            if (empty($pg)) {
                $curr = 0;
                $pg = 1;
            } else {
                $curr = ($pg - 1) * $limit;
            }

            $id_opb = $_REQUEST['id_opb'];
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
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="#" class="judul"><i class="material-icons">description</i>Approval</a></li>
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=opb"><i class="material-icons">arrow_back</i> Kembali</a></li>
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
                <div class="col m12" id="colres">
                    <table class="bordered  centered highlight" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">No.Form</th>
                                <th width="20%">Nama Peminta</th>
                                <th width="20%">Nama Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="10%">Satuan</th>
                                <th width="20%">Keperluan</th>
                                <!-- <th width="10%">Tindakan</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = mysqli_query($config, "SELECT a.*,
                            b.id_app_opb_kabag,status_opb_kabag,waktu_opb_kabag, 
                            c.id_app_opb_petugas,status_opb_petugas,waktu_opb_petugas,
                            d.id_opb_detail,nama_opb,nama_barang,jumlah,satuan,keperluan,
                            e.nama 
                            FROM tbl_opb a
                            LEFT JOIN tbl_approve_opb_kabag b
                            ON a.id_opb=b.id_opb
                            LEFT JOIN tbl_approve_opb_petugas c 
                            ON a.id_opb=c.id_opb
                            LEFT JOIN tbl_opb_detail d 
                            ON a.id_opb=d.id_opb  
                            LEFT JOIN tbl_user e
                            ON a.id_user=e.id_user
                            
                            WHERE d.id_opb='$id_opb'");


                            if (mysqli_num_rows($query2) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query2)) {
                                    $no++;
                            ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_form'] ?></strong></td>
                                        <td><?= $row['nama_opb'] ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['jumlah'] ?> </td>
                                        <td><?= $row['satuan'] ?> </td>
                                        <td><?= $row['keperluan'] ?><br /></td>

                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5">
                                        <center>
                                            <p class="add">Tidak ada data untuk ditampilkan.</p>
                                        </center>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <a class="btn small modal-trigger" href="#modal2<?= $id_opb ?>">APPROVE</a></span>
                    <div id="modal2<?= $id_opb ?>" class="modal">
                        <div class="modal-content white">
                            <div class="row">
                                <!-- Secondary Nav START -->
                                <div class="col s12">
                                    <nav class="secondary-nav">
                                        <div class="nav-wrapper blue darken-2">
                                            <ul class="left">
                                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i>Approve</a></li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                                <!-- Secondary Nav END -->
                            </div>

                            <div class="row jarak-form">
                                <form class="col s12" method="post" action="">
                                    <div class="input-field col s9">
                                        <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br />
                                        <input type="hidden" id="id_opb_detail" name="id_opb_detail" value="<?= $row['id_opb_detail'] ?>" />
                                        <select name="status_opb_kabag" class="browser-default validate" id="status_opb_kabag" required>
                                            <option value=""></option>
                                            <option value="Diterima">Diterima</option>
                                            <option value="Ditolak">Ditolak</option>
                                            <option value="Batal">Batal</option>
                                        </select>
                                        <br>
                                        <button type="submit" name="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>

                                    <!--div class="col 6">
                            <button type="reset" onclick= window.location.href="./admin.php?page=pp&act=app_gm_pp&id_pp=' . $row['id_barang_detail'] . '"; class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                        </div-->
                                </form>
                            </div>
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
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> <?= $succEdit ?></span>
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
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> <?= $succDel ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
        <?php
                        unset($_SESSION['succDel']);
                    }
                }
            }
        }
        ?>