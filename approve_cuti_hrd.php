<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        // print_r($_POST);die;
        $id_cuti = $_REQUEST['id_cuti'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_cuti_hrd WHERE id_cuti='$id_cuti'");
        $no = 1;
        list($id_cuti) = mysqli_fetch_array($query); {

            $id_cuti = $_REQUEST['id_cuti'];
            $status_cuti_hrd = $_POST['status_cuti_hrd'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * FROM tbl_approve_cuti_hrd where id_cuti='$id_cuti'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_cuti_hrd(status_cuti_hrd,id_cuti,id_user)
                                        VALUES('$status_cuti_hrd','$id_cuti','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_cuti_hrd SET
                status_cuti_hrd='$status_cuti_hrd',
                id_cuti='$id_cuti',id_user='$id_user' WHERE id_app_cuti_hrd=$cek_data_row[id_app_cuti_hrd]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=cuti";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {
        // Pagination
        $limit = 5;
        $pg = @$_GET['pg'];
        if (empty($pg)) {
            $curr = 0;
            $pg = 1;
        } else {
            $curr = ($pg - 1) * $limit;
        }

        $id_cuti = $_REQUEST['id_cuti'];





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
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=cuti"><i class="material-icons">arrow_back</i> Kembali</a></li>
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
                            <th width="15%">No.Form<br />
                                <hr />Tanggal
                            </th>
                            <th width="20%">Nama<br />
                                <hr />Jabatan
                            </th>
                            <th width="15%">No.Telp<br />
                                <hr />Sisa Cuti</th>
                            <th width="10%">Tgl.Cuti<br />
                                <hr />Akhir Cuti
                            </th>
                            <th width="10%">Jumlah Hari</th>
                            <!-- <th width="10%">Tindakan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = mysqli_query($config, "SELECT a.*,
                            b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                            c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                            d.nama,jabatan,no_hp,sisa_cuti
                            FROM tbl_cuti a
                            LEFT JOIN tbl_approve_cuti_kabag b
                            ON a.id_cuti=b.id_cuti
                            LEFT JOIN tbl_approve_cuti_hrd c 
                            ON a.id_cuti=c.id_cuti
                            LEFT JOIN tbl_user d
                            ON a.id_user=d.id_user
                            
                            WHERE a.id_cuti='$id_cuti'");


                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><strong><?= $row['no_form'] ?></strong><br />
                                        <hr /><?= indoDate(date('Y-m-d')) ?>
                                    </td>
                                    <td><?= $row['nama'] ?><br />
                                        <hr /><?= $row['jabatan'] ?>
                                    </td>
                                    <td><?= $row['no_hp'] ?><br />
                                        <hr /><?= $row['sisa_cuti'] ?></td>
                                    <td><?= $row['tgl_cuti'] ?><br />
                                        <hr /><?= $row['akhir_cuti'] ?>
                                    </td>
                                    <td><?= $row['jumlah_hari'] ?></td>
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
                <a class="btn small modal-trigger" href="#modal2<?= $id_cuti ?>">TERBIT</a></span>
                <div id="modal2<?= $id_cuti ?>" class="modal">
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
                                    <input type="hidden" id="id_cuti_detail" name="id_cuti_detail" value="<?= $row['id_cuti_detail'] ?>" />
                                    <select name="status_cuti_hrd" class="browser-default validate" id="status_cuti_hrd" required>
                                        <option value="" disabled selected></option>
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

        ?>