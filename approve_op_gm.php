<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['sub'])) {
        $sub = $_REQUEST['sub'];
        switch ($sub) {
            
        }
    }

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        $id_OP = $_REQUEST['id_op'];
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_op_gm WHERE id_op='$id_op'");
        $no = 1;
        list($id_op) = mysqli_fetch_array($query);
        {

            $id_op = $_REQUEST['id_op'];
            $status_op_gm = $_POST['status_op_gm'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_approve_op_gm where id_op='$id_op'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_op_gm(status_op_gm,id_op,id_user)
                                        VALUES('$status_op_gm','$id_op','$id_user')");
            } else {
                 $query = mysqli_query($config, "UPDATE tbl_approve_op_gm SET
                status_op_gm='$status_op_gm',
                id_op='$id_op',id_user='$id_user' WHERE id_app_op_gm=$cek_data_row[id_app_op_gm]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=op";
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

        $id_op = $_REQUEST['id_op'];
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
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=op"><i class="material-icons">arrow_back</i> Kembali</a></li>
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
                <table class="bordered" id="tbl">
                    <thead class="blue lighten-4" id="head">
                        <tr>
                            <th width="6%">No</th>
                            <th width="15%">Nama Barang</th>
                            <th width="5%">Jumlah</th>
                            <th width="5%">Satuan</th>
                            <th width="10%">Harga</th>
                            <th width="10%">Total</th>
                            <th width="10%">Total + PPN</th>
                            <th width="10%">Keterangan</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = mysqli_query($config, "SELECT *from tbl_op_detail
                                                                  WHERE id_op='$id_op'");

                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords(strtolower($row['nama_barang'])) ?><br/></td>
                                    <td><?= $row['jumlah_op'] ?></td>
                                    <td><?= $row['satuan'] ?><br/></td>
                                    <td><?= $row["harga_op"] = "Rp " . number_format((float) $row['harga_op'], 0, ',', '.') ?></td>
                                    <td><?= $row["total_op"] = "Rp " . number_format((float) $row['total_op'], 0, ',', '.') ?></td>
                                    <td>      
                        <?php
                        if (!empty($row['total_ppn'])) {
                                            ?>
                                            <strong><?= $row['total_ppn'] = "Rp " . number_format((float) $row['total_ppn'], 0, ',', '.') ?></strong>
                                            <?php
                                        } else {
                                            ?>
                                            <em>Tidak ada PPN</em>
                                            <?php
                                        } 
                                        ?>
                        </td>
                                    <td><strong><?= $row['keterangan_op_detail'] ?></strong> </td>

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

        <a class="btn small modal-trigger" href="#modal<?= $id_op ?>">APPROVE</i></a></span>
        <div id="modal<?= $id_op ?>" class="modal">
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
                        <div class="input-field col s9">
                            <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                            <input type="hidden" id="id_op_detail" name="id_op_detail" value="<?= $row['id_op_detail'] ?>" />
                            <select name="status_op_gm" class="materialize-textarea validate" id="status_op_gm" required>
                                <option value=""></option>
                                <option value="Diterima">Diterima</option>
                                <option value="Dipending">Dipending</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>

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
