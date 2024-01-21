<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_mod         = $_REQUEST['id_mod'];
            $no_mod         = $_REQUEST['no_mod'];
            $keterangan_mod = $_REQUEST['keterangan_mod'];
            $tujuan_div     = $_REQUEST['tujuan_div'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/mod/";

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

                        $id_mod = $_REQUEST['id_mod'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_modku WHERE id_mod='$id_mod'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_modku SET no_mod='$no_mod',keterangan_mod='$keterangan_mod',tujuan_div='$tujuan_div',file='$nfile',id_user='$id_user' WHERE id_mod='$id_mod'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=mod");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_modku SET no_mod='$no_mod',keterangan_mod='$keterangan_mod',tujuan_div='$tujuan_div',file='$nfile',id_user='$id_user' WHERE id_mod='$id_mod'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=mod");
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
                $id_mod = $_REQUEST['id_mod'];

                $query = mysqli_query($config, "UPDATE tbl_modku SET no_mod='$no_mod',keterangan_mod='$keterangan_mod',tujuan_div='$tujuan_div',id_user='$id_user' WHERE id_mod='$id_mod'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=mod");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
} else {

$id_mod = mysqli_real_escape_string($config, $_REQUEST['id_mod']);
$query = mysqli_query($config, "SELECT id_mod, no_mod, keterangan_mod, tujuan_div, file, id_user FROM tbl_modku WHERE id_mod='$id_mod'");
list($id_mod, $no_mod, $keterangan_mod, $tujuan_div, $file, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href="./admin.php?page=mod";
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
                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Data</a></li>
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
    <form class="col s12" method="POST" action="?page=mod&act=edit" enctype="multipart/form-data">

        <!-- Row in form START -->
        <div class="row">
            <div class="input-field col s9">
                <input type="hidden" name="id_mod" value="<?php echo $id_mod; ?>">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <input id="no_mod" type="text" class="validate" value="<?php echo $no_mod; ?>" name="no_mod">
                <?php
                if (isset($_SESSION['eno_mod'])) {
                    $eno_mod = $_SESSION['eno_mod'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_mod . '</div>';
                    unset($_SESSION['eno_mod']);
                }
                ?>
                <label for="no_mod"><strong>No.MOD</strong></label>
            </div>
            
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">assignment_ind</i>
                <input id="keterangan_mod" type="text" class="validate" name="keterangan_mod" value="<?php echo $keterangan_mod; ?>" required>
                <?php
                if (isset($_SESSION['keterangan_mod'])) {
                    $keterangan_mod = $_SESSION['keterangan_mod'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan_mod . '</div>';
                    unset($_SESSION['keterangan_mod']);
                }
                ?>
                <label for="keterangan_mod"><strong>Keterangan</strong></label>
            </div>
            
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">group_add</i>
                <input id="tujuan_div" type="text" class="validate" name="tujuan_div" value="<?php echo $tujuan_div; ?>" required>
                <?php
                if (isset($_SESSION['tujuan_div'])) {
                    $tujuan_div= $_SESSION['tujuan_div'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tujuan_div . '</div>';
                    unset($_SESSION['tujuan_div']);
                }
                ?>
                <label for="tujuan_div"><strong>Divisi Tujuan</strong></label>
            </div>
       
        <div class="input-field col s6">
            <div class="file-field input-field">
                <div class="btn small light-green darken-1">
                    <span>File</span>
                    <input type="file" id="file" name="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file">
                    <?php
                    if (isset($_SESSION['errSize'])) {
                        $errSize = $_SESSION['errSize'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errSize . '</div>';
                        unset($_SESSION['errSize']);
                    }
                    if (isset($_SESSION['errFormat'])) {
                        $errFormat = $_SESSION['errFormat'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errFormat . '</div>';
                        unset($_SESSION['errFormat']);
                    }
                    ?>
                    <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                </div>
            </div>
        </div>
</div>
<!-- Row in form END -->

<div class="row">
    <div class="col 6">
        <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
    </div>
    <div class="col 6">
        <a href="?page=mod" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
    </div>
</div>

</form>
<!-- Form END -->

</div>
<!-- Row form END -->

<?php
}
}
}
?>
