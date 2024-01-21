<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong

        $no_op = $_REQUEST['no_op'];
        $tgl_op = $_REQUEST['tgl_op'];
        $tgl_brg_dtg = $_REQUEST['tgl_brg_dtg'];
        $syarat_pembayaran = $_REQUEST['syarat_pembayaran'];
        $keterangan_op = $_REQUEST['keterangan_op'];
        $supplier = $_REQUEST['supplier'];
        $id_user = $_SESSION['id_user'];


        //jika form file kosong akan mengeksekusi script dibawah ini
        $id_op = $_REQUEST['id_op'];

        $query = mysqli_query($config, "UPDATE tbl_op SET no_op='$no_op' ,tgl_op='$tgl_op',tgl_brg_dtg='$tgl_brg_dtg', syarat_pembayaran='$syarat_pembayaran',keterangan_op='$keterangan_op',supplier='$supplier',id_user='$id_user' WHERE id_op='$id_op'");

        if ($query == true) {
            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
            header("Location: ./admin.php?page=op");
            die();
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            echo '<script language="javascript">window.history.back();</script>';
        }
    }
}

$id_op = mysqli_real_escape_string($config, $_REQUEST['id_op']);
$query = mysqli_query($config, "SELECT id_op, no_op, tgl_op,tgl_brg_dtg, syarat_pembayaran, keterangan_op, supplier, id_user FROM tbl_op WHERE id_op='$id_op'");
list($id_op, $no_op,  $tgl_op, $tgl_brg_dtg, $syarat_pembayaran, $keterangan_op, $supplier, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href = "./admin.php?page=op";
</script>';
} else {
    ?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue-grey darken-1">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit OP</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Secondary Nav END -->
    </div>
    <!-- Row END -->

    <?php
    if (isset($_SESSION['errQ'])) {
        $errQ = $_SESSION['errQ'];
        echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
        unset($_SESSION['errQ']);
    }
    if (isset($_SESSION['errEmpty'])) {
        $errEmpty = $_SESSION['errEmpty'];
        echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errEmpty . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
        unset($_SESSION['errEmpty']);
    }
    ?>

    <!-- Row form Start -->
    <div class="row jarak-form">

        <!-- Form START -->
        <form class="col s12" method="POST" action="?page=op&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                
                 <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">event_available</i>
                    <input id="tgl_op" type="text" class="datepicker" name="tgl_op" value="<?php echo $tgl_op; ?>">
                    <?php
                    if (isset($_SESSION['tgl_op'])) {
                        $tgl_op = $_SESSION['tgl_op'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['tgl_op']) . '</div>';
                        unset($_SESSION['tgl_op']);
                    }
                    ?>
                    <label for="tgl_op">Tgl.OP</label>
                </div>
                
                <div class="input-field col s6">
                    <input type="hidden" name="id_op" value="<?php echo $id_op; ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_op" type="text" class="validate" value="<?php echo $no_op; ?>" name="no_op">
                    <?php
                    if (isset($_SESSION['eno_op'])) {
                        $eno_op = $_SESSION['eno_op'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_op . '</div>';
                        unset($_SESSION['eno_op']);
                    }
                    ?>
                    <label for="eno_op">No.OP</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">schedule</i>
                    <input id="tgl_brg_dtg" type="text" class="datepicker" name="tgl_brg_dtg" value="<?php echo $tgl_brg_dtg; ?>" required>
                    <?php
                    if (isset($_SESSION['tgl_brg_dtg'])) {
                        $tgl_brg_dtg = $_SESSION['tgl_brg_dtg'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['tgl_brg_dtg']) . '</div>';
                        unset($_SESSION['tgl_brg_dtg']);
                    }
                    ?>
                    <label for="tgl_brg_dtg">Tgl.Barang Datang</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i>
                    <input id="syarat_pembayaran" type="text" class="validate" name="syarat_pembayaran" value="<?php echo $syarat_pembayaran; ?>" required>
                    <?php
                    if (isset($_SESSION['syarat_pembayaran'])) {
                        $syarat_pembayaran = $_SESSION['syarat_pembayaran'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $syarat_pembayaran . '</div>';
                        unset($_SESSION['syarat_pembayaran']);
                    }
                    ?>
                    <label for="syarat_pembayaran">Syarat Pembayaran</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i>
                    <input id="keterangan_op" type="text" class="validate" name="keterangan_op" value="<?php echo $keterangan_op; ?>" required>
                    <?php
                    if (isset($_SESSION['keterangan_op'])) {
                        $keterangan_op = $_SESSION['keterangan_op'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan_op . '</div>';
                        unset($_SESSION['keterangan_op']);
                    }
                    ?>
                    <label for="keterangan_op">Keterangan</label>
                </div>
                
                 <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">people</i>
                    <input id="supplier" type="text" class="validate" name="supplier" value="<?php echo $supplier; ?>" required>
                    <?php
                    if (isset($_SESSION['supplier'])) {
                        $supplier = $_SESSION['supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $supplier . '</div>';
                        unset($_SESSION['supplier']);
                    }
                    ?>
                    <label for="supplier">Supplier</label>
                </div>

               
            </div>
    </div>
    <!-- Row in form END -->

    <div class="row">
        <div class="col 8">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 8">
            <a href="?page=op" class="btn small deep-orange waves-effect waves-light">Keluar <i class="material-icons">clear</i></a>
        </div>
    </div>
    <hr>
    <hr>
    <div class="col m12" id="colres">
        <table class="bordered" id="tbl">
            <thead class="blue lighten-4" id="head">
                <tr>
                    <th width="3%">No</th>
                    <th width="12%">Nama Barang</th>
                    <th width="5%">Jumlah</th>
                    <th width="5%">Satuan</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Total</th>
                    <th width="10%">Total+PPN</th>
                    <!--th width="10%">Supplier</th-->
                    <th width="8%">Keterangan</th>
                    <th width="3%"><center>Tindakan</center></th>
            </tr>
            </thead>
            
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
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah_op'] ?></td>
                        <td><?= $row['satuan'] ?></td>
                        <td><?= $row['harga_op'] = "Rp " . number_format((float) $row['harga_op'], 0, ',', '.') ?></td>
                        <td><?= $row['total_op'] = "Rp " . number_format((float) $row['total_op'], 0, ',', '.') ?></td>
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
                        <td><?= $row['keterangan_op_detail'] ?></td>
                        <!--td><?= $row['nama_supplier'] ?></td-->
                        <td> <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Data" href="hapus_op_detail.php?id_op_detail=<?= $row["id_op_detail"] ?>">
                                <i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="7"><center><p class="add">Tidak ada detail OP</p></center></td></tr>
                <?php
            }
            ?>

        </table>
        <?Php
        if (isset($_REQUEST['submito'])) {
            // print_r($_POST);die;
            //validasi form kosong
            if ("") {
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                $nama_barang = $_REQUEST['nama_barang'];
                $jumlah_op = $_REQUEST['jumlah_op'];
                $satuan = $_REQUEST['satuan'];
                $harga_op = $_REQUEST['harga_op'];
                $keterangan_op_detail = $_REQUEST['keterangan_op_detail'];
                $total_op = $_REQUEST['total_op'];
                $total_ppn = $_REQUEST['total_ppn'];
                //$nama_supplier= $_REQUEST['nama_supplier'];
                $id_op = $_REQUEST['id_op'];
                
                $id_op_detail = $_REQUEST['id_op_detail'];

                $query = mysqli_query($config, "UPDATE tbl_op_detail SET nama_barang='$nama_barang',jumlah_op='$jumlah_op',satuan='$satuan',harga_op='$harga_op',keterangan_op_detail='$keterangan_op_detail',total_op='$total_op',total_ppn='$total_ppn' WHERE id_op_detail=id_op_detail");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=op");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
        ?>
        <hr>
        <br>
        <div class="row">
            <div class="col 6">
                <!--button type="submit" name="submito" class="btn small brown waves-effect waves-light">Ubah detail OP<i class="material-icons">done</i></button-->
                <a href="?page=op&act=op_detail&id_op=<?= $_GET['id_op'] ?>"  class="btn small green waves-effect waves-light">Tambah <i class="material-icons">add</i></a>
            </div>
            <div class="col 6">
                <a href="?page=op" class="btn small deep-orange waves-effect waves-light">Keluar <i class="material-icons">clear</i></a>
            </div>
        </div> 
    </div>
    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
