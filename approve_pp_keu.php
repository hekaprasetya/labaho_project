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
            case 'add':
                include "tambah_approve_pp_gm.php";
                break;
            case 'edit':
                include "edit_approve_pp_gm.php";
                break;
            case 'del':
                include "hapus_approve_pp_gm.php";
                break;
        }
    }

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        $id_pp = $_REQUEST['id_pp'];
        $query = mysqli_query($config, "SELECT * FROM tbl_kabag_keu WHERE id_pp='$id_pp'");
        $no = 1;
        list($id_pp) = mysqli_fetch_array($query); {
            
             $id_pp = $_REQUEST['id_pp'];
            $status_keu = $_POST['status_keu'];
            $catatan_keu = $_POST['catatan_keu'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * from tbl_kabag_keu where id_pp='$id_pp'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_kabag_keu(status_keu,catatan_keu,id_pp,id_user)
                                        VALUES('$status_keu','$catatan_keu','$id_pp','$id_user')");
                // $query = mysqli_query($config, "UPDATE tbl_gm_pp SET  status_gm='$status_gm', catatan_gm='$catatan_gm', id_barang='$id_barang_detail', id_pp='$id_pp', id_user='$id_user' WHERE id_pp='$id_pp'");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_kabag_keu SET
                status_keu='$status_keu',
                catatan_keu='$catatan_keu',
                    id_pp='$id_pp',id_user='$id_user' WHERE id_kabag_keu=$cek_data_row[id_kabag_keu]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=pp";
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

        $id_pp = $_REQUEST['id_pp'];
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
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pp"><i class="material-icons">arrow_back</i> Kembali</a></li>
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
                                <th width="5%">Jumlah<br/><hr/>Satuan</th>
                                <th width="12%">Keterangan</th>
                                <th width="12%">Tujuan PP</th>
                                <th width="5%">Disetujui purchasing<br/><hr/>Satuan</th>
                                 <th width="13%">Harga<br/><hr/>Jumlah Harga</th>
                                <th width="20%">Status GM<br/><hr/>Catatan GM</th>
                                <th width="20%">Status Gudang<br/><hr/>Catatan Gudang</th>
                                
                    </thead>
                    <tbody>
                        <?php
                         $query2 = mysqli_query($config, "SELECT *, tbl_pp_barang.id_barang as id_barang_detail FROM tbl_pp_barang
                                                                  LEFT JOIN tbl_gm_pp ON tbl_pp_barang.id_pp = tbl_gm_pp.id_pp  and  tbl_pp_barang.id_barang = tbl_gm_pp.id_barang
                                                                  LEFT JOIN tbl_pembelian_realisasi ON tbl_pp_barang.id_pp = tbl_pembelian_realisasi.id_pp and tbl_pp_barang.id_barang = tbl_pembelian_realisasi.id_barang
                                                                  LEFT JOIN tbl_pp_gudang ON tbl_pp_barang.id_pp = tbl_pp_gudang.id_pp and tbl_pp_barang.id_barang = tbl_pp_gudang.id_barang
                                                                   LEFT JOIN tbl_pp
                                                                  ON tbl_pp_barang.id_pp = tbl_pp.id_pp
                                                                  WHERE tbl_pp_barang.id_pp='$id_pp'");
                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                     <td><?= $no ?></td>
                                       <td><?= $row['nama_barang'] ?><br/><hr/><strong><?= $row['no_pp'] ?></strong></td>
                                        <td><?= $row['jumlah'] ?><br/><hr/><?= $row['satuan'] ?></td>
                                        <td><?= $row['keterangan_pp'] ?><br/></td>
                                        <td><?= $row['tujuan_pp'] ?><br/></td>
                                        <td><strong>
                                                <?php
                                                if (!empty($row['jumlah_realisasi'])) {
                                                    echo ' <strong>' . $row['jumlah_realisasi'] . '</strong>';
                                                } else {
                                                    echo '<em><font color="red">Kosong</font></em>';
                                                }
                                                ?>
                                        </strong><br/><hr/><?= $row['satuan_realisasi'] ?></td>
                                       <td><strong><i><?= $row['harga'] = "Rp " . number_format($row['harga'], 0, ',', '.') ?><br/><hr/><?= $row['jumlah_harga'] = "Rp " . number_format($row['jumlah_harga'], 0, ',', '.') ?></i></strong></td>
                                        <td><strong><?= $row['status_gm'] ?> <?= $row['jumlah_gm'] ?> </strong> <hr/><?= $row['waktu'] ?><br/><hr/><?= $row['catatan_gm'] ?></td>
                                        <td><strong><?= $row['status_gudang'] ?> <?= $row['jumlah_gudang'] ?> </strong> <hr/><?= $row['waktu_gudang'] ?><br/><hr/><?= $row['catatan_gudang'] ?></td>
                                   
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
                 <?php
                     $harga_total = mysqli_fetch_array(mysqli_query($config, "SELECT sum(jumlah_harga) as harga_total
                                                                                               FROM tbl_pembelian_realisasi  
                                                                                               WHERE id_pp='$id_pp'"));
                    ?>
                    <table class="bordered" id="tbl" width="100%">
                        <br/>
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                            <th class="right"><i>HARGA TOTAL ESTIMASI : </i><strong><?php  echo "Rp " . number_format((float) "$harga_total[harga_total]", 0, '.', '.') ?></strong></th>
                            </thead>
                        </table>
                    </table>

            </div>
        </div>
        <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Kabag" href="?page=pp&act=app_kabag_pp&id_pp=<?= $id_pp ?>">
            <i class="material-icons">assignment_turned_in</i></a>
             
       <a class="btn small modal-trigger waves-effect waves-light tooltipped" data-position="right" data-tooltip="Mng.Keuangan" href="#modal<?= $id_pp ?>">APPROVE</i></a></span>
        <div id="modal<?= $id_pp ?>" class="modal">
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
                            <input type="hidden" id="id_barang" name="id_barang" value="<?= $row['id_barang_detail'] ?>" />
                            <select name="status_keu" class="browser-default validate" id="status_keu" required>
                                <option value="">Pilih Status</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Dipending">Dipending</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div class="input-field col s9">
                            <i class="material-icons prefix md-prefix">playlist_add</i>
                            <textarea id="catatan_keu" class="materialize-textarea validate" name="catatan_keu"></textarea>
                            <label for="catatan_keu">Catatan</label>
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
