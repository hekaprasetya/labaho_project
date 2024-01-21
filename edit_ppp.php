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

            $id_ppp = $_REQUEST['id_ppp'];
            $no_ppp = $_REQUEST['no_ppp'];
            $tgl_ppp = $_REQUEST['tgl_ppp'];
            $lokasi_ppp = $_REQUEST['lokasi_ppp'];
            $nama_perusahaan = $_REQUEST['nama_perusahaan'];
            $permintaan_pekerjaan = $_REQUEST['permintaan_pekerjaan'];
            $id_user = $_SESSION['id_user'];

            //validasi input data


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/ppp/";

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

                        $id_ppp = $_REQUEST['id_ppp'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_ppp WHERE id_ppp='$id_ppp'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_ppp SET no_ppp='$no_ppp', tgl_ppp='$tgl_ppp',lokasi_ppp='$lokasi_ppp',nama_perusahaan='$nama_perusahaan',permintaan_pekerjaan='$permintaan_pekerjaan',file='$nfile',id_user='$id_user' WHERE id_ppp='$id_ppp'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=ppp");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_ppp SET no_ppp='$no_ppp',tgl_ppp='$tgl_ppp',lokasi_ppp='$lokasi_ppp',nama_perusahaan='$nama_perusahaan',permintaan_pekerjaan='$permintaan_pekerjaan',file='$nfile',id_user='$id_user' WHERE id_ppp='$id_ppp'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=ppp");
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
                $id_ppp = $_REQUEST['id_ppp'];

                $query = mysqli_query($config, "UPDATE tbl_ppp SET no_ppp='$no_ppp',tgl_ppp='$tgl_ppp',lokasi_ppp='$lokasi_ppp',nama_perusahaan='$nama_perusahaan',permintaan_pekerjaan='$permintaan_pekerjaan',id_user='$id_user' WHERE id_ppp='$id_ppp'");


                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=ppp");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }


    $id_ppp = mysqli_real_escape_string($config, $_REQUEST['id_ppp']);
    $query = mysqli_query($config, "SELECT id_ppp, no_ppp, tgl_ppp, lokasi_ppp, nama_perusahaan, permintaan_pekerjaan, file, id_user FROM tbl_ppp WHERE id_ppp='$id_ppp'");
    list( $id_ppp, $no_ppp, $tgl_ppp, $lokasi_ppp, $nama_perusahaan, $permintaan_pekerjaan,  $file, $id_user) = mysqli_fetch_array($query);

    if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=ppp";
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
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>EDIT E-PARKIR</a></li>
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
            <form class="col s12" method="POST" action="?page=ppp&act=edit" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <input type="hidden" name="id_ppp" value="<?php echo $id_ppp ?>">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="no_ppp" type="text" class="validate" value="<?php echo $no_ppp; ?>" name="no_ppp">
                        <?php
                        if (isset($_SESSION['eno_ppp'])) {
                            $eno_ppp = $_SESSION['eno_ppp'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_ppp . '</div>';
                            unset($_SESSION['eno_ppp']);
                        }
                        ?>
                        <label for="no_ppp">No.PPP</label>
                    </div>

                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">location_on</i>
                        <input id="lokasi_ppp" type="text" class="validate" name="lokasi_ppp" value="<?php echo $lokasi_ppp; ?>">
                        <?php
                        if (isset($_SESSION['elokasi_ppp'])) {
                            $elokasi_ppp = $_SESSION['elokasi_ppp'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi_ppp . '</div>';
                            unset($_SESSION['elokasi_ppp']);
                        }
                        ?>
                        <label for="elokasi_ppp">Lokasi</label>
                    </div>          

                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">home</i>
                        <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan" value="<?php echo $nama_perusahaan; ?>">
                        <?php
                        if (isset($_SESSION['enama_perusahaan'])) {
                            $nama_perusahaan = $_SESSION['enama_perusahaan'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_perusahaan . '</div>';
                            unset($_SESSION['enama_perusahaan']);
                        }
                        ?>
                        <label for="enama_perusahaan">Nama Perusahaan</label>
                    </div>

                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">build</i>
                        <input id="permintaan_pekerjaan" type="text" class="validate" name="permintaan_pekerjaan" value="<?php echo $permintaan_pekerjaan; ?>">
                        <?php
                        if (isset($_SESSION['epermintaan_pekerjaan'])) {
                            $epermintaan_pekerjaan = $_SESSION['epermintaan_pekerjaan'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epermintaan_pekerjaan . '</div>';
                            unset($_SESSION['epermintaan_pekerjaan']);
                        }
                        ?>
                        <label for="epermintaan_pekerjaan">Permintaan Pekerjaan</label>
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
                        <a href="?page=ppp" class="btn small deep-orange waves-effect waves-light">KEMBALI <i class="material-icons">clear</i></a>
                    </div>
                </div>

            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->

        <?php
    }
}
?>
