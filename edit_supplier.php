<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
  //print_r($_POST);die;
        //validasi form kosong

        $id_supplier = $_REQUEST['id_supplier'];
        $nama_supplier = $_REQUEST['nama_supplier'];
        $telp_supplier = $_REQUEST['telp_supplier'];
        $alamat_supplier = $_REQUEST['alamat_supplier'];
        $email_supplier = $_REQUEST['email_supplier'];
        $id_user = $_SESSION['id_user'];

        //jika form file kosong akan mengeksekusi script dibawah ini

        $query = mysqli_query($config, "UPDATE master_supplier SET nama_supplier='$nama_supplier' ,telp_supplier='$telp_supplier', alamat_supplier='$alamat_supplier',email_supplier='$email_supplier',id_user='$id_user' WHERE id_supplier = '$id_supplier'");

        if ($query == true) {
            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
            header("Location: ./admin.php?page=master_supplier");
            die();
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            echo '<script language="javascript">window.history.back();</script>';
        }
    }
}

$id_supplier = mysqli_real_escape_string($config, $_REQUEST['id_supplier']);
$query = mysqli_query($config, "SELECT id_supplier, nama_supplier, telp_supplier, alamat_supplier, email_supplier, id_user FROM master_supplier WHERE id_supplier='$id_supplier'");
list($id_supplier, $nama_supplier, $telp_supplier, $alamat_supplier, $email_supplier, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href = "./admin.php?page=master_supplier";
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
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Supplier</a></li>
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
        <form class="col s12" method="POST" action="?page=master_supplier&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i>
                    <input id="nama_supplier" type="text" class="validate" name="nama_supplier" value="<?php echo $nama_supplier; ?>">
                    <?php
                    if (isset($_SESSION['nama_supplier'])) {
                        $nama_supplier = $_SESSION['nama_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_supplier . '</div>';
                        unset($_SESSION['nama_supplier']);
                    }
                    ?>
                    <label for="nama_supplier">Nama</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">phone</i>
                    <input id="telp_supplier" type="number" class="validate" name="telp_supplier" value="<?php echo $telp_supplier; ?>">
                    <?php
                    if (isset($_SESSION['telp_supplier'])) {
                        $telp_supplier = $_SESSION['telp_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $telp_supplier . '</div>';
                        unset($_SESSION['telp_supplier']);
                    }
                    ?>
                    <label for="telp_supplier">Telp</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="alamat_supplier" type="text" class="validate" name="alamat_supplier" value="<?php echo $alamat_supplier; ?>">
                    <?php
                    if (isset($_SESSION['alamat_supplier'])) {
                        $alamat_supplier = $_SESSION['alamat_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $alamat_supplier . '</div>';
                        unset($_SESSION['alamat_supplier']);
                    }
                    ?>
                    <label for="alamat_supplier">Alamat</label>
                </div>
                
                  <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">mail</i>
                    <input id="email_supplier" type="text" class="validate" name="email_supplier" value="<?php echo $email_supplier; ?>">
                    <?php
                    if (isset($_SESSION['email_supplier'])) {
                        $email_supplier = $_SESSION['email_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $email_supplier . '</div>';
                        unset($_SESSION['email_supplier']);
                    }
                    ?>
                    <label for="email_supplier">Email</label>
                </div>

            </div>
    </div>
    <!-- Row in form END -->

    <div class="row">
        <div class="col 8">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 8">
            <a href="?page=master_supplier" class="btn small deep-orange waves-effect waves-light">KELUAR <i class="material-icons">clear</i></a>
        </div>
    </div>
    <hr>
    <hr>
    <div class="col m12" id="colres">
        <table class="bordered" id="tbl">
            <thead class="blue lighten-4" id="head">
                <tr>
                    <th width="3%">No</th>
                    <th width="12%">Nama Produk</th>
                    <th width="5%">Harga Produk</th>
                    <th width="3%"><center>Tindakan</center></th>
            </tr>
            </thead>

            <?php
            $query2 = mysqli_query($config, "SELECT *from master_supplier_detail
                                           WHERE id_supplier='$id_supplier'");
            if (mysqli_num_rows($query2) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query2)) {
                    $no++;
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row['produk'] ?></td>
                        <td><?= $row['harga_produk'] = "Rp " . number_format((float) $row['harga_produk'], 0, ',', '.') ?></td>
                        <td> <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Data" href="hapus_supplier_detail.php?id_supplier_detail=<?= $row["id_supplier_detail"] ?>">
                                <i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="7"><center><p class="add">Silahkan Masukkan Item Supplier</p></center></td></tr>
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

                $produk = $_REQUEST['produk'];
                $harga_produk= $_REQUEST['harga_produk'];
                $id_supplier = $_REQUEST['id_supplier'];

                $id_supplier_detail = $_REQUEST['id_supplier_detail'];

                $query = mysqli_query($config, "UPDATE master_supplier_detail SET produk='$produk' WHERE id_supplier_detail=id_supplier_detail");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=master_supplier");
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
                <a href="?page=master_supplier&act=supplier_detail&id_supplier=<?= $_GET['id_supplier'] ?>"  class="btn small green waves-effect waves-light">Tambah <i class="material-icons">add</i></a>
            </div>
            <div class="col 6">
                <a href="?page=master_supplier" class="btn small deep-orange waves-effect waves-light">KELUAR <i class="material-icons">clear</i></a>
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
