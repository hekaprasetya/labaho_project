<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

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

            $no_pengaduan = $_POST['no_pengaduan'];
            $pengaduan = $_POST['pengaduan'];
            $id_user = $_SESSION['id_user'];

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

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_pengaduan(no_pengaduan,pengaduan,file,id_user)
                                                                        VALUES('$no_pengaduan','$pengaduan','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=pengaduan_tenant");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
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
                $query = mysqli_query($config, "INSERT INTO tbl_pengaduan(no_pengaduan,pengaduan,id_user)
                                                                        VALUES('$no_pengaduan','$pengaduan','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=pengaduan_tenant");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
    ?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="?page=pengaduan&act=add" class="judul"><i class="material-icons">record_voice_over</i> Pengaduan</a></li>
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
        <form class="col s12" method="POST" action="?page=pengaduan&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="input-field col s11">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <?php
                //memulai mengambil datanya
                $sql = mysqli_query($config, "SELECT no_pengaduan FROM tbl_pengaduan");


                $result = mysqli_num_rows($sql);

                if ($result <> 0) {
                    $kode = $result + 1;
                } else {
                    $kode = 1;
                }

                //mulai bikin kode
                $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                $tahun = date('Y-m');
                $kode_jadi = "PG/$tahun/$bikin_kode";

                if (isset($_SESSION['no_pengaduan'])) {
                    $no_pengaduan = $_SESSION['no_pengaduan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_pengaduan . '</div>';
                    unset($_SESSION['no_pengaduan']);
                }
                ?>
                <label for="no_pengaduan">No.Pengaduan</label>
                <input type="text" class="form-control" id="no_pengaduan" name="no_pengaduan"  value="<?php echo $kode_jadi ?>"disabled>
                <input type="hidden" class="form-control" id="no_pengaduan" name="no_pengaduan"  value="<?php echo $kode_jadi ?>" >
            </div>

            <div class="input-field col s11">
                <i class="material-icons prefix md-prefix">record_voice_over</i>
                <textarea id="pengaduan" class="materialize-textarea validate" name="pengaduan" required></textarea>
                <?php
                if (isset($_SESSION['pengaduan'])) {
                    $pengaduan = $_SESSION['pengaduan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pengaduan . '</div>';
                    unset($_SESSION['pengaduan']);
                }
                ?>
                <label for="pengaduan">Hal yang di laporkan</label>
            </div>

            <div class="input-field col s9">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1">
                        <span>Upload</span>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
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

    <!-- Row form END -->

    <?php
}
?>
