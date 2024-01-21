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

            $id_pengaduan = $_REQUEST['id_pengaduan'];
            $no_pengaduan = $_REQUEST['no_pengaduan'];
            $pengaduan = $_REQUEST['pengaduan'];

            //validasi input data


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/pengaduan/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 10000000) {

                        $id_pengaduan = $_REQUEST['id_pengaduan'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_pengaduan WHERE id_pengaduan='$id_pengaduan'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_pengaduan SET no_pengaduan='$no_pengaduan',pengaduan='$pengaduan',file='$nfile' WHERE id_pengaduan='$id_pengaduan'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=pengaduan_tenant");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_pengaduan SET no_pengaduan='$no_pengaduan',pengaduan='$pengaduan',file='$nfile' WHERE id_pengaduan='$id_pengaduan'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=pengaduan_tenant");
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
                $id_pengaduan = $_REQUEST['id_pengaduan'];

                $query = mysqli_query($config, "UPDATE tbl_pengaduan SET no_pengaduan='$no_pengaduan',pengaduan='$pengaduan' WHERE id_pengaduan='$id_pengaduan'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=pengaduan_tenant");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
}

$id_pengaduan = mysqli_real_escape_string($config, $_REQUEST['id_pengaduan']);
$query = mysqli_query($config, "SELECT id_pengaduan, no_pengaduan, pengaduan,  file FROM tbl_pengaduan WHERE id_pengaduan='$id_pengaduan'");
list( $id_pengaduan, $no_pengaduan, $pengaduan,  $file) = mysqli_fetch_array($query);
{
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
        <form class="col s12" method="POST" action="?page=pengaduan&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s8">
                    <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_pengaduan" type="text" class="validate" value="<?php echo $no_pengaduan; ?>" name="no_pengaduan">
                    <?php
                    if (isset($_SESSION['eno_pengaduan'])) {
                        $eno_pengaduan = $_SESSION['eno_pengaduan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_pengaduan . '</div>';
                        unset($_SESSION['eno_pengaduan']);
                    }
                    ?>
                    <label for="eno_pengaduan">No.Pengaduan</label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">archive</i>
                    <input id="pengaduan" type="text" class="validate" name="pengaduan" value="<?php echo $pengaduan; ?>">
                    <?php
                    if (isset($_SESSION['epengaduan'])) {
                        $epengaduan = $_SESSION['epengaduan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epengaduan . '</div>';
                        unset($_SESSION['epengaduan']);
                    }
                    ?>
                    <label for="epengaduan">Pengaduan</label>
                </div>          

                <div class="input-field col s8">
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
                    <a href="?page=pengaduan_tenant" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                </div>
            </div>

        </form>
        <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
<script type="text/javascript">
        var message = "Ngapain?";

        function clickIE4() {

            if (event.button == 2) {

                alert(message);

                return false;

            }

        }

        function clickNS4(e) {

            if (document.layers || document.getElementById && !document.all) {

                if (e.which == 2 || e.which == 3) {

                    alert(message);

                    return false;

                }

            }

        }

        if (document.layers) {

            document.captureEvents(Event.MOUSEDOWN);

            document.onmousedown = clickNS4;

        } else if (document.all && !document.getElementById) {

            document.onmousedown = clickIE4;

        }

        document.oncontextmenu = new Function("alert(message);return false");
    </script><!--IE=internet explorer 4+ dan NS=netscape 4+0-->
    <!-- Javascript END -->

    <noscript>
        <meta http-equiv="refresh" content="0;URL='/enable-javascript.html'" />
    </noscript>

