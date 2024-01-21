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
        $alasan_cuti = $_REQUEST['alasan_cuti'];
        $jumlah_hari = $_REQUEST['jumlah_hari'];
        $tgl_cuti = $_REQUEST['tgl_cuti'];
        $akhir_cuti = $_REQUEST['akhir_cuti'];
        $id_user = $_SESSION['id_user'];

        $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
        $file = $_FILES['file']['name'];
        $x = explode('.', $file);
        $eks = strtolower(end($x));
        $ukuran = $_FILES['file']['size'];
        $target_dir = "upload/cuti/";

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

                    $id_cuti = $_REQUEST['id_cuti'];
                    $query = mysqli_query($config, "SELECT file FROM tbl_cuti WHERE id_cuti='$id_cuti'");
                    list($file) = mysqli_fetch_array($query);

                    //jika file tidak kosong akan mengeksekusi script dibawah ini
                    if (!empty($file)) {
                        unlink($target_dir . $file);

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "UPDATE tbl_cuti SET no_form='$no_form',jumlah_hari='$jumlah_hari', alasan_cuti='$alasan_cuti',tgl_cuti='$tgl_cuti',akhir_cuti='$akhir_cuti',id_user='$id_user' WHERE id_cuti='$id_cuti'");

                        if ($query == true) {
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            header("Location: ./admin.php?page=cuti");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    } else {

                        //jika file kosong akan mengeksekusi script dibawah ini
                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "UPDATE tbl_cuti SET no_form='$no_form',jumlah_hari='$jumlah_hari', alasan_cuti='$alasan_cuti',tgl_cuti='$tgl_cuti',akhir_cuti='$akhir_cuti',id_user='$id_user' WHERE id_cuti='$id_cuti'");

                        if ($query == true) {
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            header("Location: ./admin.php?page=cuti");
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
            $id_cuti = $_REQUEST['id_cuti'];

            $query = mysqli_query($config, "UPDATE tbl_cuti SET no_form='$no_form',jumlah_hari='$jumlah_hari', alasan_cuti='$alasan_cuti',tgl_cuti='$tgl_cuti',akhir_cuti='$akhir_cuti',id_user='$id_user' WHERE id_cuti='$id_cuti'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                header("Location: ./admin.php?page=cuti");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }
}


$id_cuti = mysqli_real_escape_string($config, $_REQUEST['id_cuti']);
$query = mysqli_query($config, "SELECT id_cuti, no_form,jumlah_hari, alasan_cuti,tgl_cuti, akhir_cuti, id_user FROM tbl_cuti WHERE id_cuti='$id_cuti'");
list($id_cuti, $no_form, $jumlah_hari, $alasan_cuti, $tgl_cuti, $akhir_cuti, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href = "./admin.php?page=cuti";
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
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit CUTI</a></li>
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
        <form class="col s12" method="POST" action="?page=cuti&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s12">
                    <input type="hidden" name="id_cuti" value="<?php echo $id_cuti; ?>">
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

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">beach_access</i>
                    <input id="jumlah_hari" type="number" class="datepicker" name="jumlah_hari" value="<?php echo $jumlah_hari; ?>" required>
                    <?php
                    if (isset($_SESSION['jumlah_hari'])) {
                        $jumlah_hari = $_SESSION['jumlah_hari'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah_hari . '</div>';
                        unset($_SESSION['jumlah_hari']);
                    }
                    ?>
                    <label for="jumlah_hari">Jumlah Hari</label>
                </div>

                <div class="input-field col s12">
                    <input type="hidden" value="<?php echo $row['alasan_cuti']; ?>">
                    <i class="material-icons prefix md-prefix">web</i>
                    <input id="alasan_cuti" type="text" class="validate" name="alasan_cuti" value="<?php echo $alasan_cuti; ?>" required>
                    <label for="alasan_cuti">Keperluan</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">schedule</i>
                    <input id="tgl_cuti" type="text" class="datepicker" name="tgl_cuti" value="<?php echo $tgl_cuti; ?>" required>
                    <?php
                    if (isset($_SESSION['tgl_cuti'])) {
                        $tgl_cuti = $_SESSION['tgl_cuti'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['tgl_cuti']) . '</div>';
                        unset($_SESSION['tgl_cuti']);
                    }
                    ?>
                    <label for="tgl_cuti">Tanggal Cuti</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">schedule</i>
                    <input id="akhir_cuti" type="text" class="validate" name="akhir_cuti" value="<?php echo $akhir_cuti; ?>" required>
                    <?php
                    if (isset($_SESSION['akhir_cuti'])) {
                        $akhir_cuti = $_SESSION['akhir_cuti'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $akhir_cuti . '</div>';
                        unset($_SESSION['akhir_cuti']);
                    }
                    ?>
                    <label for="akhir_cuti">Akhir Cuti</label>
                </div>
            </div>
    </div>
    <!-- Row in form END -->

    <div class="row">
        <div class="col 8">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 8">
            <a href="?page=cuti" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>