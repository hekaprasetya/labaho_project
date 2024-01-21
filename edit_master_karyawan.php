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

            $id_karyawan = $_POST['id_karyawan'];
            $nama_karyawan = $_POST['nama_karyawan'];
            $jabatan = $_POST['jabatan'];
            $nip     = $_POST['nip'];
            $email     = $_POST['email'];
            $tgl_lahir = $_POST['tgl_lahir'];
            $tmpt_lahir = $_POST['tmpt_lahir'];
            $status = $_POST['status'];
            $tgl_gabung = $_POST['tgl_gabung'];
            $kontrak_habis = $_POST['kontrak_habis'];
            $no_hp = $_POST['no_hp'];
            $sisa_cuti = $_POST['sisa_cuti'];
            $divisi = $_POST['divisi'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/master_karyawan/";

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

                        $id_karyawan = $_REQUEST['id_karyawan'];
                        $query = mysqli_query($config, "SELECT file FROM master_karyawan WHERE id_karyawan='$id_karyawan'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE master_karyawan SET nama_karyawan='$nama_karyawan',jabatan='$jabatan',nip='$nip',email='$email',tgl_lahir='$tgl_lahir',tmpt_lahir='$tmpt_lahir',status='$status',tgl_gabung='$tgl_gabung',kontrak_habis='$kontrak_habis',no_hp='$no_hp',sisa_cuti='$sisa_cuti',divisi='$divisi',file='$nfile',id_user='$id_user' WHERE id_karyawan='$id_karyawan'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=master_karyawan");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE master_karyawan SET nama_karyawan='$nama_karyawan',jabatan='$jabatan',nip='$nip',email='$email',tgl_lahir='$tgl_lahir',tmpt_lahir='$tmpt_lahir',status='$status',tgl_gabung='$tgl_gabung',kontrak_habis='$kontrak_habis',no_hp='$no_hp',sisa_cuti='$sisa_cuti',divisi='$divisi',file='$nfile',id_user='$id_user' WHERE id_karyawan='$id_karyawan'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=master_karyawan");
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
                $id_karyawan = $_REQUEST['id_karyawan'];

                $query = mysqli_query($config, "UPDATE master_karyawan SET nama_karyawan='$nama_karyawan', jabatan='$jabatan', nip='$nip', email='$email', tgl_lahir='$tgl_lahir',tmpt_lahir='$tmpt_lahir',status='$status',tgl_gabung='$tgl_gabung',kontrak_habis='$kontrak_habis',no_hp='$no_hp',sisa_cuti='$sisa_cuti',divisi='$divisi',id_user='$id_user' WHERE id_karyawan='$id_karyawan'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=master_karyawan");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    } else {

        $id_karyawan = mysqli_real_escape_string($config, $_REQUEST['id_karyawan']);
        $query = mysqli_query($config, "SELECT id_karyawan, nama_karyawan, jabatan, nip, email, tgl_lahir,tmpt_lahir,status,tgl_gabung,kontrak_habis, no_hp, sisa_cuti,divisi, file, id_user FROM master_karyawan WHERE id_karyawan='$id_karyawan'");
        list($id_karyawan, $nama_karyawan, $jabatan, $nip, $email, $tgl_lahir, $tmpt_lahir, $status, $tgl_gabung, $kontrak_habis, $no_hp, $sisa_cuti, $divisi, $file, $id_user) = mysqli_fetch_array($query);

        if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] == 1) {
            echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href="./admin.php?page=master_karyawan";
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
                <form class="col s12" method="POST" action="?page=master_karyawan&act=edit" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s9">
                            <input type="hidden" name="id_karyawan" value="<?php echo $id_karyawan; ?>">
                            <i class="material-icons prefix md-prefix">people</i>
                            <input id="nama_karyawan" type="text" class="validate" value="<?php echo $nama_karyawan; ?>" name="nama_karyawan">
                            <?php
                            if (isset($_SESSION['nama_karyawan'])) {
                                $nama_karyawan = $_SESSION['nama_karyawan'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_karyawan . '</div>';
                                unset($_SESSION['nama_karyawan']);
                            }
                            ?>
                            <label for="nama_karyawan">Nama Karyawan</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">bookmark</i>
                            <input id="jabatan" type="text" class="validate" name="jabatan" value="<?php echo $jabatan; ?>" required>
                            <?php
                            if (isset($_SESSION['jabatan'])) {
                                $jabatan = $_SESSION['jabatan'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jabatan . '</div>';
                                unset($_SESSION['jabatan']);
                            }
                            ?>
                            <label for="jabatan">Jabatan</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">local_library</i>
                            <input id="nip" type="number" class="validate" name="nip" value="<?php echo $nip; ?>" required>
                            <?php
                            if (isset($_SESSION['nip'])) {
                                $nip = $_SESSION['nip'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nip . '</div>';
                                unset($_SESSION['nip']);
                            }
                            ?>
                            <label for="nip">NIP</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">email</i>
                            <input id="email" type="email" class="validate" name="email" value="<?php echo $email; ?>" required>
                            <?php
                            if (isset($_SESSION['email'])) {
                                $email = $_SESSION['email'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $email . '</div>';
                                unset($_SESSION['email']);
                            }
                            ?>
                            <label for="email">Email</label>
                        </div>

                        <div class="input-field col s9">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_lahir" type="text" name="tgl_lahir" class="datepicker" value="<?php echo $tgl_lahir; ?>" required>
                            <?php
                            if (isset($_SESSION['tgl_lahir'])) {
                                $tgl_lahir = $_SESSION['tgl_lahir'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_lahir . '</div>';
                                unset($_SESSION['tgl_lahir']);
                            }
                            ?>
                            <label for="tgl_lahir">Tanggal Lahir</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">domain</i>
                            <input id="tmpt_lahir" type="text" class="validate" name="tmpt_lahir" value="<?php echo $tmpt_lahir; ?>" required>
                            <?php
                            if (isset($_SESSION['tmpt_lahir'])) {
                                $tmpt_lahir = $_SESSION['tmpt_lahir'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tmpt_lahir . '</div>';
                                unset($_SESSION['tmpt_lahir']);
                            }
                            ?>
                            <label for="tmpt_lahir">Tempat Lahir</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">assignment_ind</i>
                            <input id="status" type="text" class="validate" name="status" value="<?php echo $status; ?>" required>
                            <?php
                            if (isset($_SESSION['status'])) {
                                $status = $_SESSION['status'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status . '</div>';
                                unset($_SESSION['status']);
                            }
                            ?>
                            <label for="status">Status</label>
                        </div>

                        <div class="input-field col s9">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_gabung" type="text" name="tgl_gabung" class="datepicker" value="<?php echo $tgl_gabung; ?>" required>
                            <?php
                            if (isset($_SESSION['tgl_gabung'])) {
                                $tgl_gabung = $_SESSION['tgl_gabung'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_gabung . '</div>';
                                unset($_SESSION['tgl_gabung']);
                            }
                            ?>
                            <label for="tgl_gabung">Tanggal Gabung</label>
                        </div>

                        <div class="input-field col s9">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="kontrak_habis" type="text" name="kontrak_habis" class="datepicker" value="<?php echo $kontrak_habis; ?>" required>
                            <?php
                            if (isset($_SESSION['kontrak_habis'])) {
                                $kontrak_habis = $_SESSION['kontrak_habis'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kontrak_habis . '</div>';
                                unset($_SESSION['kontrak_habis']);
                            }
                            ?>
                            <label for="kontrak_habis">Kontrak Habis</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">phone</i>
                            <input id="no_hp" type="number" class="validate" name="no_hp" value="<?php echo $no_hp; ?>" required>
                            <?php
                            if (isset($_SESSION['no_hp'])) {
                                $no_hp = $_SESSION['no_hp'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_hp . '</div>';
                                unset($_SESSION['no_hp']);
                            }
                            ?>
                            <label for="no_hp">No Hp</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">beach_access</i>
                            <input id="sisa_cuti" type="text" class="validate" name="sisa_cuti" value="<?php echo $sisa_cuti; ?>" required>
                            <?php
                            if (isset($_SESSION['sisa_cuti'])) {
                                $sisa_cuti = $_SESSION['sisa_cuti'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sisa_cuti . '</div>';
                                unset($_SESSION['sisa_cuti']);
                            }
                            ?>
                            <label for="sisa_cuti">Sisa Cuti</label>
                        </div>
                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">group</i>
                            <input id="divisi" type="text" class="validate" name="divisi" value="<?php echo $divisi; ?>" required>
                            <?php
                            if (isset($_SESSION['divisi'])) {
                                $divisi = $_SESSION['divisi'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi . '</div>';
                                unset($_SESSION['divisi']);
                            }
                            ?>
                            <label for="divisi">Divisi</label>
                        </div>

                        <div class="input-field col s8">
                            <div class="file-field input-field">
                                <div class="btn small light-green darken-1">
                                    <span>Foto</span>
                                    <input type="file" id="file" name="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload file">
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
                            <a href="?page=master_karyawan" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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