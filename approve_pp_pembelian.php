<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        //  print_r($_POST);die;
        $id_pp = $_REQUEST['id_pp'];
        $query = mysqli_query($config, "SELECT * FROM tbl_pembelian WHERE id_pp='$id_pp'");
        $no = 1;
        list($id_pp) = mysqli_fetch_array($query);
        {

            $id_pp = $_REQUEST['id_pp'];
            $status_pembelian = $_POST['status_pembelian'];
            $catatan_pembelian = $_POST['catatan_pembelian'];
            $id_user = $_SESSION['id_user'];
            $cek_data_qry = mysqli_query($config, "select * FROM tbl_pembelian where id_pp='$id_pp'");
            $cek_data = mysqli_num_rows($cek_data_qry);
            $cek_data_row = mysqli_fetch_array($cek_data_qry);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_pembelian(status_pembelian,catatan_pembelian,id_pp,id_user)
                                        VALUES('$status_pembelian','$catatan_pembelian','$id_pp','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_pembelian SET
                status_pembelian='$status_pembelian',catatan_pembelian='$catatan_pembelian',
               id_pp='$id_pp',id_user='$id_user' WHERE id_pembelian=$cek_data_row[id_pembelian]");
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
                            <th width="20%">Nama Barang<br/><hr/>No.PP</th>
                    <th width="5%">Jumlah<br/><hr/>Satuan</th>
                    <th width="20%">Keterangan<br/><hr/>Tujuan</th>
                    <th width="5%">Disetujui purchasing<br/><hr/>Satuan</th>
                    <th width="13%">Harga<br/><hr/>Jumlah Harga</th>
                    <th width="20%">Status GM<br/><hr/>Catatan GM</th>
                    <th width="20%">Status Gudang<br/><hr/>Catatan Gudang</th>
                    <th width="10%">Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <script>
                        function sum() {
                            var a = document.getElementById('jumlah_realisasi').value;
                            var b = document.getElementById('harga').value;

                            var result = parseInt(a) * parseInt(b);
                            if (!isNaN(result)) {
                                document.getElementById('jumlah_harga').value = result;
                            }
                        }
                    </script>

                    <?php
                    $query2 = mysqli_query($config, "SELECT *, tbl_pp_barang.id_barang as id_barang_detail FROM tbl_pp_barang
                                                                  LEFT JOIN tbl_gm_pp 
                                                                  ON tbl_pp_barang.id_pp = tbl_gm_pp.id_pp  and  tbl_pp_barang.id_barang = tbl_gm_pp.id_barang
                                                                  LEFT JOIN tbl_pembelian_realisasi
                                                                  ON tbl_pp_barang.id_pp = tbl_pembelian_realisasi.id_pp and tbl_pp_barang.id_barang = tbl_pembelian_realisasi.id_barang
                                                                  LEFT JOIN tbl_pp_gudang 
                                                                  ON tbl_pp_barang.id_pp = tbl_pp_gudang.id_pp and tbl_pp_barang.id_barang = tbl_pp_gudang.id_barang
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
                                <td><?= ucwords(strtolower($row['nama_barang'])) ?><br/><hr/><strong><?= $row['no_pp'] ?></strong></td>
                                <td><?= $row['jumlah'] ?><br/><hr/><?= $row['satuan'] ?></td>
                                <td><strong><?= $row['keterangan_pp'] ?></strong><br/><hr/><?= $row['tujuan_pp'] ?></td>
                                <td><strong>
                                        <?php
                                        if (!empty($row['jumlah_realisasi'])) {
                                            echo ' <strong>' . $row['jumlah_realisasi'] . '</strong>';
                                        } else {
                                            echo '<em><font color="red">Kosong</font></em>';
                                        }
                                        ?>
                                    </strong><br/><hr/><?= $row['satuan_realisasi'] ?>
                                </td>
                                <td><strong><i><?= $row['harga'] = "Rp " . number_format($row['harga'], 0, ',', '.') ?><br/><hr/><?= $row['jumlah_harga'] = "Rp " . number_format($row['jumlah_harga'], 0, ',', '.') ?></i></strong></td>
                                <td><strong><?= $row['status_gm'] ?></strong>  <?= $row['waktu'] ?><br/><hr/><?= $row['catatan_gm'] ?></td>
                                <td><strong><?= $row['status_gudang'] ?></strong> <?= $row['waktu_gudang'] ?><br/><hr/><?= $row['catatan_gudang'] ?></td>
                                <td><a class="btn blue small darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Realisasi" href="?page=pp&act=pp_realisasi&id_barang&id_barang=<?= $row['id_barang_detail'] ?>&id_pp=<?= $row['id_pp'] ?>" >
                                        <i class="material-icons">edit</i></a>
                               
                               <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Harga" href="hapus_pp_realisasi.php?id_pembelian_realisasi=<?= $row["id_pembelian_realisasi"] ?>">
                                        <i class="material-icons">delete</i></a>
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
                        <th class="right"><i>HARGA TOTAL ESTIMASI : </i><strong><?php echo "Rp " . number_format((float) "$harga_total[harga_total]", 0, '.', '.') ?></strong></th>
                        </thead>
                    </table>
                </table>

            </div>
        </div>


        <a class="btn green small modal-trigger" href="#modal2<?= $id_pp ?>">STATUS SURAT</a></span>
        <div id="modal2<?= $id_pp ?>" class="modal">
            <div class="modal-content white">
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i>Terbitkan Surat</a></li>
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
                            <select name="status_pembelian" class="browser-default validate" id="status_pembelian" required>
                                <option value="">Pilih Status Surat</option>
                                <option value="Progres">Progres</option>
                                <option value="Pending">Pending</option>
                                <option value="Batal">Batal</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Selesai Sebagian">Selesai Sebagian</option>
                            </select>
                        </div>

                        <div class="input-field col s9">
                            <i class="material-icons prefix md-prefix">edit</i>
                            <textarea id="status_pembelian" class="materialize-textarea validate" name="catatan_pembelian"></textarea>
                            <label for="catatan_pembelian">Catatan</label>
                        
                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
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
