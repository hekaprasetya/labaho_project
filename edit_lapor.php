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

            $id_lapor = $_REQUEST['id_lapor'];
            $no_lapor = $_REQUEST['no_lapor'];
            $divisi = $_REQUEST['divisi'];
            $jenis_komplain = $_REQUEST['jenis_komplain'];
            $pemberi_komplain = $_REQUEST['pemberi_komplain'];
            $aksi_komplain = $_REQUEST['aksi_komplain'];
            $pekerjaan = $_REQUEST['pekerjaan'];
            $lokasi = $_REQUEST['lokasi'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/lapor/";

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

                        $id_lapor = $_REQUEST['id_lapor'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_lapor WHERE id_lapor='$id_lapor'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_lapor SET no_lapor='$no_lapor',divisi='$divisi',jenis_komplain='$jenis_komplain',pemberi_komplain='$pemberi_komplain',aksi_komplain='$aksi_komplain',pekerjaan='$pekerjaan',lokasi='$lokasi',file='$nfile',id_user='$id_user' WHERE id_lapor='$id_lapor'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=app_lapor");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_lapor SET no_lapor='$no_lapor',divisi='$divisi',jenis_komplain='$jenis_komplain',pemberi_komplain='$pemberi_komplain',aksi_komplain='$aksi_komplain',pekerjaan='$pekerjaan',lokasi='$lokasi',file='$nfile',id_user='$id_user' WHERE id_lapor='$id_lapor'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=app_lapor");
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
                $id_lapor = $_REQUEST['id_lapor'];

                $query = mysqli_query($config, "UPDATE tbl_lapor SET no_lapor='$no_lapor',divisi='$divisi',jenis_komplain='$jenis_komplain',pemberi_komplain='$pemberi_komplain',aksi_komplain='$aksi_komplain',pekerjaan='$pekerjaan',lokasi='$lokasi',id_user='$id_user' WHERE id_lapor='$id_lapor'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=app_lapor");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
} else {

$id_lapor = mysqli_real_escape_string($config, $_REQUEST['id_lapor']);
$query = mysqli_query($config, "SELECT id_lapor, no_lapor, divisi, jenis_komplain, pemberi_komplain, aksi_komplain, pekerjaan, lokasi, file, id_user FROM tbl_lapor WHERE id_lapor='$id_lapor'");
list($id_lapor, $no_lapor, $divisi, $jenis_komplain, $pemberi_komplain, $aksi_komplain, $pekerjaan, $lokasi, $file, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href="./admin.php?page=app_lapor";
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
    <form class="col s12" method="POST" action="?page=lapor&act=edit" enctype="multipart/form-data">

        <!-- Row in form START -->
        <div class="row">
            <div class="input-field col s9">
                <input type="hidden" name="id_lapor" value="<?php echo $id_lapor; ?>">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <input id="no_lapor" type="text" class="validate" value="<?php echo $no_lapor; ?>" name="no_lapor">
                <?php
                if (isset($_SESSION['eno_lapor'])) {
                    $eno_lapor = $_SESSION['eno_lapor'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_lapor . '</div>';
                    unset($_SESSION['eno_lapor']);
                }
                ?>
                <label for="no_lapor"><strong>No.Lapor</strong></label>
            </div>
            
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">assignment_ind</i>
                <input id="divisi" type="text" class="validate" name="divisi" value="<?php echo $divisi; ?>" required>
                <?php
                if (isset($_SESSION['edivisi'])) {
                    $edivisi = $_SESSION['edivisi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $edivisi . '</div>';
                    unset($_SESSION['edivisi']);
                }
                ?>
                <label for="divisi"><strong>Divisi</strong></label>
            </div>
            
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">bug_report</i>
                <input id="jenis_komplain" type="text" class="validate" name="jenis_komplain" value="<?php echo $jenis_komplain; ?>" required>
                <?php
                if (isset($_SESSION['jenis_komplain'])) {
                    $jenis_komplain = $_SESSION['jenis_komplain'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jenis_komplain . '</div>';
                    unset($_SESSION['jenis_komplain']);
                }
                ?>
                <label for="jenis_komplain"><strong>Jenis Komplain</strong></label>
            </div>
            
             <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">group_add</i>
                <input id="pemberi_komplain" type="text" class="validate" name="pemberi_komplain" value="<?php echo $pemberi_komplain; ?>" required>
                <?php
                if (isset($_SESSION['pemberi_komplain'])) {
                    $pemberi_komplain = $_SESSION['pemberi_komplain'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pemberi_komplain . '</div>';
                    unset($_SESSION['pemberi_komplain']);
                }
                ?>
                <label for="pemberi_komplain"><strong>Pemberi Komplain</strong></label>
            </div>
            
           <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">record_voice_over</i>
                <input id="aksi_komplain" type="text" class="validate" name="aksi_komplain" value="<?php echo $aksi_komplain; ?>" required>
                <?php
                if (isset($_SESSION['aksi_komplain'])) {
                    $aksi_komplain = $_SESSION['aksi_komplain'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $aksi_komplain . '</div>';
                    unset($_SESSION['aksi_komplain']);
                }
                ?>
                <label for="aksi_komplain"><strong>Aksi Komplain</strong></label>
            </div>

           <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">build</i>
                <input id="pekerjaan" type="text" class="validate" name="pekerjaan" value="<?php echo $pekerjaan; ?>" required>
                <?php
                if (isset($_SESSION['pekerjaan'])) {
                    $pekerjaan = $_SESSION['pekerjaan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pekerjaan . '</div>';
                    unset($_SESSION['pekerjaan']);
                }
                ?>
                <label for="pekerjaan"><strong>Pekerjaan</strong></label>
            </div>

          <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">room</i>
                <input id="lokasi" type="text" class="validate" name="lokasi" value="<?php echo $lokasi; ?>" required>
                <?php
                if (isset($_SESSION['lokasi'])) {
                    $lokasi = $_SESSION['lokasi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi . '</div>';
                    unset($_SESSION['lokasi']);
                }
                ?>
                <label for="lokasi"><strong>Lokasi</strong></label>
            </div>
        </div>
       
        <div class="input-field col s6">
            <div class="file-field input-field">
                <div class="btn small light-green darken-1">
                    <span>File</span>
                    <input type="file" id="file" name="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar surat masuk">
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
        <a href="?page=lapor" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
