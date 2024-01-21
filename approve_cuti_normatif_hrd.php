<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        // print_r($_POST);die;
        $id_cuti_normatif = $_REQUEST['id_cuti_normatif'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_cuti_normatif_hrd WHERE id_cuti_normatif='$id_cuti_normatif'");
        $no = 1;
        list($id_cuti_normatif) = mysqli_fetch_array($query);
        {

            $id_cuti_normatif = $_GET['id_cuti_normatif'];
            $status_hrd = $_POST['status_hrd'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * FROM tbl_approve_cuti_normatif_hrd where id_cuti_normatif='$id_cuti_normatif'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_cuti_normatif_hrd(status_hrd,id_cuti_normatif,id_user)
                                        VALUES('$status_hrd','$id_cuti_normatif','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_cuti_normatif_hrd SET
                status_hrd='$status_hrd',
                id_cuti_normatif='$id_cuti_normatif',id_user='$id_user' WHERE id_hrd_normatif=$cek_data_row[id_hrd_normatif]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=cuti_normatif";
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

        $id_cuti_normatif = $_REQUEST['id_cuti_normatif'];
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
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=cuti_normatif"><i class="material-icons">arrow_back</i> Kembali</a></li>
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
                    <th width="15%">Jenis Ijin<br />
                    <hr />Sisa Cuti
                    </th>
                    <th width="10%">Tgl.Cuti<br />
                    <hr />Akhir Cuti
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = mysqli_query($config, "SELECT a.*,
                                                b.id_kabag_normatif,status_kabag,waktu_kabag,
                                                c.id_hrd_normatif,status_hrd,waktu_cuti_hrd,
                                                d.nama,jabatan,no_hp,sisa_cuti
                                                FROM tbl_cuti_normatif a

                                                LEFT JOIN tbl_approve_cuti_normatif_kabag b
                                                ON a.id_cuti_normatif=b.id_cuti_normatif

                                                LEFT JOIN tbl_approve_cuti_normatif_hrd c 
                                                ON a.id_cuti_normatif=c.id_cuti_normatif

                                               LEFT JOIN tbl_user d
                                                ON a.id_user=d.id_user
                            
                            WHERE a.id_cuti_normatif = '$id_cuti_normatif'");


                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><strong><?= $row['no_form_normatif'] ?></strong><br />
                                        <hr /><?= indoDate(date('Y-m-d')) ?>
                                    </td>
                                    <td><?= $row['nama'] ?><br />
                                        <hr /><?= $row['jabatan'] ?>
                                    </td>
                                    <td><?= $row['jenis_ijin'] ?><br />
                                        <hr /><?= $row['sisa_cuti'] ?></td>
                                    <td><?= indoDate($row['tgl_cuti']) ?><br />
                                        <hr /><?= indoDate($row['akhir_cuti']) ?>
                                    </td>
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
                <a class="btn small modal-trigger" href="#modal2<?= $id_cuti_normatif ?>">TERBIT</a></span>
                <div id="modal2<?= $id_cuti_normatif ?>" class="modal">
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
                                    <input type="hidden" id="id_cuti_normatif" name="id_cuti_normatif" value="<?= $row['id_cuti_normatif'] ?>" />
                                    <select name="status_hrd" class="browser-default validate" id="status_hrd" required>
                                        <option value="" disabled selected></option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                        <option value="Batal">Batal</option>
                                    </select>
                                    <br>
                                    <button type="submit" name="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                </div>

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