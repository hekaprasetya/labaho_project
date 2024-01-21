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

            $id_ppi = $_REQUEST['id_ppi'];
            $no_ppi = $_REQUEST['no_ppi'];
            $tgl_ppi = $_REQUEST['tgl_ppi'];
            $nama_peminta = $_REQUEST['nama_peminta'];
            $divisi = $_REQUEST['divisi'];
            $tujuan_divisi = $_REQUEST['tujuan_divisi'];
            $permintaan_pekerjaan = $_REQUEST['permintaan_pekerjaan'];
            $lokasi = $_REQUEST['lokasi'];
            $id_user = $_SESSION['id_user'];

            //validasi input data


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/ppi/";

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

                        $id_ppi = $_REQUEST['id_ppi'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_ppi WHERE id_ppi='$id_ppi'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_ppi SET no_ppi='$no_ppi',nama_peminta='$nama_peminta',divisi='$divisi',tujuan_divisi='$tujuan_divisi',permintaan_pekerjaan='$permintaan_pekerjaan',lokasi='$lokasi',file='$nfile',id_user='$id_user' WHERE id_ppi='$id_ppi'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=ppi");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_ppi SET no_ppi='$no_ppi',nama_peminta='$nama_peminta',tujuan_divisi='$tujuan_divisi',divisi='$divisi',permintaan_pekerjaan='$permintaan_pekerjaan',lokasi='$lokasi',file='$nfile',,id_user='$id_user' WHERE id_ppi='$id_ppi'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=ppi");
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
                $id_ppi = $_REQUEST['id_ppi'];

                $query = mysqli_query($config, "UPDATE tbl_ppi SET no_ppi='$no_ppi',nama_peminta='$nama_peminta',tujuan_divisi='$tujuan_divisi',divisi='$divisi',permintaan_pekerjaan='$permintaan_pekerjaan',tgl_ppi='$tgl_ppi',lokasi='$lokasi',id_user='$id_user' WHERE id_ppi='$id_ppi'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=ppi");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }


$id_ppi = mysqli_real_escape_string($config, $_REQUEST['id_ppi']);
$query = mysqli_query($config, "SELECT id_ppi, no_ppi, tgl_ppi, nama_peminta, tujuan_divisi ,divisi, permintaan_pekerjaan, lokasi, file, id_user FROM tbl_ppi WHERE id_ppi='$id_ppi'");
list( $id_ppi, $no_ppi, $tgl_ppi, $nama_peminta, $tujuan_divisi, $divisi, $permintaan_pekerjaan, $lokasi, $file, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=ppi";
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
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Data PPI</a></li>
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
        <form class="col s12" method="POST" action="?page=ppi&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s6">
                    <input type="hidden" name="id_ppi" value="<?php echo $id_ppi ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_ppi" type="text" class="validate" value="<?php echo $no_ppi; ?>" name="no_ppi">
                    <?php
                    if (isset($_SESSION['eno_ppi'])) {
                        $eno_ppi = $_SESSION['eno_ppi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_ppi . '</div>';
                        unset($_SESSION['eno_ppi']);
                    }
                    ?>
                    <label for="no_ppi">No.PPI</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_ppi" type="text" name="tgl_ppi" class="datepicker" value="<?php echo $tgl_ppi; ?>">
                    <?php
                    if (isset($_SESSION['etgl_ppi'])) {
                        $etgl_ppi = $_SESSION['etgl_ppi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etgl_ppi . '</div>';
                        unset($_SESSION['etgl_ppi']);
                    }
                    ?>
                    <label for="tgl_ppi">Tanggal PPI</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">contacts</i>
                    <input id="nama_peminta" type="text" class="validate" name="nama_peminta" value="<?php echo $nama_peminta; ?>">
                    <?php
                    if (isset($_SESSION['enama_peminta'])) {
                        $enama_peminta = $_SESSION['enama_peminta'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_peminta . '</div>';
                        unset($_SESSION['enama_peminta']);
                    }
                    ?>
                    <label for="enama_peminta">Nama Peminta</label>
                </div>          

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="divisi" type="text" class="validate" name="divisi" value="<?php echo $divisi; ?>">
                    <?php
                    if (isset($_SESSION['edivisi'])) {
                        $divisi = $_SESSION['edivisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi . '</div>';
                        unset($_SESSION['edivisi']);
                    }
                    ?>
                    <label for="edivisi">Divisi</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="tujuan_divisi" type="text" class="validate" name="tujuan_divisi" value="<?php echo $tujuan_divisi; ?>">
                    <?php
                    if (isset($_SESSION['etujuan_divisi'])) {
                        $etujuan_divisi = $_SESSION['etujuan_divisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etujuan_divisi . '</div>';
                        unset($_SESSION['etujuan_divisi']);
                    }
                    ?>
                    <label for="etujuan_divisi">Tujuan Divisi</label>
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
                    <i class="material-icons prefix md-prefix">location_on</i>
                    <input id="lokasi" type="text" class="validate" name="lokasi" value="<?php echo $lokasi; ?>">
                    <?php
                    if (isset($_SESSION['elokasi'])) {
                        $elokasi = $_SESSION['elokasi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $elokasi . '</div>';
                        unset($_SESSION['elokasi']);
                    }
                    ?>
                    <label for="elokasi">Lokasi</label>
                </div>
                <div class="input-field col s6">
                    <div class="file-field input-field">
                        <div class="btn light-green darken-1">
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
                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                </div>
                <div class="col 6">
                    <a href="?page=ppi" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
