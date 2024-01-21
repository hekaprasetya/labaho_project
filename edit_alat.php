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

            $id_alat        = $_REQUEST['id_alat'];
            $no_alat        = $_REQUEST['no_alat'];
            $tgl_alat       = $_REQUEST['tgl_alat'];
            $nama_alat      = $_REQUEST['nama_alat'];
            $jumlah         = $_REQUEST['jumlah'];
            $kondisi        = $_REQUEST['kondisi'];
            $id_user        = $_SESSION['id_user'];

            //validasi input data


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/master_alat/";

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

                        $id_alat = $_REQUEST['id_alat'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_alat WHERE id_alat='$id_alat'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_alat SET no_alat='$no_alat',tgl_alat='$tgl_alat',nama_alat='$nama_alat',jumlah='$jumlah',kondisi='$kondisi',file='$nfile',id_user='$id_user' WHERE id_alat='$id_alat'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=master_alat");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_alat SET no_alat='$no_alat',tgl_alat='$tgl_alat',nama_alat='$nama_alat',jumlah='$jumlah',kondisi='$kondisi',file='$nfile',id_user='$id_user' WHERE id_alat='$id_alat'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=master_alat");
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
                $id_alat = $_REQUEST['id_alat'];

                $query = mysqli_query($config, "UPDATE tbl_alat SET no_alat='$no_alat',tgl_alat='$tgl_alat',nama_alat='$nama_alat',jumlah='$jumlah',kondisi='$kondisi', id_user='$id_user' WHERE id_alat='$id_alat'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=master_alat");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
}

$id_alat = mysqli_real_escape_string($config, $_REQUEST['id_alat']);
$query = mysqli_query($config, "SELECT id_alat, no_alat, tgl_alat, nama_alat, jumlah, kondisi, file, id_user FROM tbl_alat WHERE id_alat='$id_alat'");
list( $id_alat, $no_alat, $tgl_alat, $nama_alat, $jumlah, $kondisi, $file,  $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=master_alat";
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
        <form class="col s12" method="POST" action="?page=master_alat&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s6">
                    <input type="hidden" name="id_alat" value="<?php echo $id_alat ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_alat" type="text" class="validate" value="<?php echo $no_alat; ?>" name="no_alat">
                    <?php
                    if (isset($_SESSION['eno_alat'])) {
                        $eno_alat = $_SESSION['eno_alat'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_alat. '</div>';
                        unset($_SESSION['eno_alat']);
                    }
                    ?>
                    <label for="no_alat">No.Alat</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">contacts</i>
                    <input id="nama_alat" type="text" class="validate" name="nama_alat" value="<?php echo $nama_alat; ?>">
                    <?php
                    if (isset($_SESSION['enama_alat'])) {
                        $enama_alat = $_SESSION['enama_alat'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_alat . '</div>';
                        unset($_SESSION['enama_alat']);
                    }
                    ?>
                    <label for="enama_alat">Nama Alat</label>
                </div>          

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="jumlah" type="number" class="validate" name="jumlah" value="<?php echo $jumlah; ?>">
                    <?php
                    if (isset($_SESSION['ejumlah'])) {
                        $ejumlah = $_SESSION['ejumlah'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ejumlah . '</div>';
                        unset($_SESSION['ejumlah']);
                    }
                    ?>
                    <label for="ejumlah">Jumlah</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">accessibility_new</i>
                    <input id="kondisi" type="text" class="validate" name="kondisi" value="<?php echo $kondisi; ?>">
                    <?php
                    if (isset($_SESSION['ekondisi'])) {
                        $ekondisi = $_SESSION['ekondisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ekondisi . '</div>';
                        unset($_SESSION['ekondisi']);
                    }
                    ?>
                    <label for="ekondisi">Kondisi</label>
                </div>
               
            <div class="input-field col s6">
                <div class="file-field input-field">
                    <div class="btn light-green darken-1">
                        <span>File</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar alat">
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
            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 6">
            <a href="?page=master_alat" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
