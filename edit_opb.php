<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong

        $no_form = $_REQUEST['no_form'];
        $tgl_opb = $_REQUEST['tgl_opb'];
        $divisi_opb = $_REQUEST['divisi_opb'];
        $id_user = $_SESSION['id_user'];

        $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
        $file = $_FILES['file']['name'];
        $x = explode('.', $file);
        $eks = strtolower(end($x));
        $ukuran = $_FILES['file']['size'];
        $target_dir = "upload/opb/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        //jika form file tidak kosong akan mengeksekusi script dibawah ini
        if ($file != "") {

            $rand = rand(1, 10000);
            $nfile = $rand . "-" . $file;

            //validasi file
            if (in_array($eks, $ekstensi) == true) {
                if ($ukuran < 2300000) {

                    $id_opb = $_REQUEST['id_opb'];
                    $query = mysqli_query($config, "SELECT file FROM tbl_opb WHERE id_opb='$id_opb'");
                    list($file) = mysqli_fetch_array($query);

                    //jika file tidak kosong akan mengeksekusi script dibawah ini
                    if (!empty($file)) {
                        unlink($target_dir . $file);

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "UPDATE tbl_opb SET no_form='$no_form', tgl_opb='$tgl_opb',divisi_opb='$divisi_opb',id_user='$id_user' WHERE id_opb='$id_opb'");

                        if ($query == true) {
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            header("Location: ./admin.php?page=opb");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    } else {

                        //jika file kosong akan mengeksekusi script dibawah ini
                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "UPDATE tbl_opb SET no_form='$no_form', tgl_opb='$tgl_opb',divisi_opb='$divisi_opb',id_user='$id_user' WHERE id_opb='$id_opb'");

                        if ($query == true) {
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            header("Location: ./admin.php?page=opb");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    }
                } else {
                    $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            } else {
                $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                echo '<script language="javascript">window.history.back();</script>';
            }
        } else {

            //jika form file kosong akan mengeksekusi script dibawah ini
            $id_opb = $_REQUEST['id_opb'];

            $query = mysqli_query($config, "UPDATE tbl_opb SET no_form='$no_form', tgl_opb='$tgl_opb',divisi_opb='$divisi_opb',id_user='$id_user' WHERE id_opb='$id_opb'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                header("Location: ./admin.php?page=opb");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }
}


$id_opb = mysqli_real_escape_string($config, $_REQUEST['id_opb']);
$query = mysqli_query($config, "SELECT id_opb, no_form, tgl_opb, divisi_opb, id_user FROM tbl_opb WHERE id_opb='$id_opb'");
list($id_opb, $no_form, $tgl_opb, $divisi_opb, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href = "./admin.php?page=opb";
</script>';
} else {
?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit OPB</a></li>
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
        <form class="col s12" method="POST" action="?page=opb&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s6">
                    <input type="hidden" name="id_opb" value="<?php echo $id_opb; ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_form" type="text" class="validate" value="<?php echo $no_form; ?>" name="no_form">
                    <?php
                    if (isset($_SESSION['no_form'])) {
                        $no_form = $_SESSION['no_form'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form . '</div>';
                        unset($_SESSION['no_form']);
                    }
                    ?>
                    <label for="no_form">No.Form</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">schedule</i>
                    <input id="tgl_opb" type="text" class="datepicker" name="tgl_opb" value="<?php echo $tgl_opb; ?>" required>
                    <?php
                    if (isset($_SESSION['tgl_opb'])) {
                        $tgl_opb = $_SESSION['tgl_opb'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['tgl_opb']) . '</div>';
                        unset($_SESSION['tgl_opb']);
                    }
                    ?>
                    <label for="tgl_opb">Tanggal</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i>
                    <input id="divisi_opb" type="text" class="validate" name="divisi_opb" value="<?php echo $divisi_opb; ?>" required>
                    <?php
                    if (isset($_SESSION['divisi_opb'])) {
                        $divisi_opb = $_SESSION['divisi_opb'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi_opb . '</div>';
                        unset($_SESSION['divisi_opb']);
                    }
                    ?>
                    <label for="divisi_opb">Divisi</label>
                </div>
            </div>
    </div>
    <!-- Row in form END -->

    <div class="row">
        <div class="col 8">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 8">
            <a href="?page=opb" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>
    <hr>
    <hr>
    <div class="col m12" id="colres">
        <table class="bordered" id="tbl">
            <thead class="blue lighten-4" id="head">
                <tr>
                    <th width="3%">No</th>
                    <th width="10%">Nama Peminta</th>
                    <th width="12%">Nama Barang</th>
                    <th width="5%">Jumlah</th>
                    <th width="5%">Satuan</th>
                    <th width="8%">Keperluan</th>
                    <th width="3%">
                        <center>Tindakan</center>
                    </th>
                </tr>
            </thead>
            <?php
            $query2 = mysqli_query($config, "SELECT *from tbl_opb_detail
                                           WHERE id_opb='$id_opb'");
            if (mysqli_num_rows($query2) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query2)) {
                    $no++;
            ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row['nama_opb'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= $row['satuan'] ?></td>
                        <td><?= $row['keperluan'] ?></td>
                        <td> <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Data" onClick="return confirm('YAKIN MAU DIHAPUS?')" href="hapus_opb_detail.php?id_opb_detail=<?= $row["id_opb_detail"] ?>">
                                <i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7">
                        <center>
                            <p class="add">Tidak ada detail barang</p>
                        </center>
                    </td>
                </tr>
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

                $nama_opb = $_REQUEST['nama_opb'];
                $nama_barang = $_REQUEST['nama_barang'];
                $jumlah = $_REQUEST['jumlah'];
                $satuan = $_REQUEST['satuan'];
                $keperluan = $_REQUEST['keperluan'];
                $id_opb = $_REQUEST['id_opb'];

                $query = mysqli_query($config, "UPDATE tbl_opb_detail SET nama_opb='$nama_opb,'nama_barang='$nama_barang',jumlah='$jumlah',satuan='$satuan',keperluan='$keperluan' WHERE id_opb='$id_opb'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=opb");
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
                <a href="?page=opb&act=opb_detail&id_opb=<?= $_GET['id_opb'] ?>" class="btn small green waves-effect waves-light">Tambah <i class="material-icons">add</i></a>
            </div>
            <div class="col 6">
                <a href="?page=opb" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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