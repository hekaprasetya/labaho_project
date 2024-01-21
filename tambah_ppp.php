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

            $no_ppp = $_REQUEST['no_ppp'];
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
                    if ($ukuran < 5000000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_ppp(no_ppp,lokasi_ppp,nama_perusahaan,permintaan_pekerjaan,file,id_user)
                                                                        VALUES('$no_ppp','$lokasi_ppp','$nama_perusahaan','$permintaan_pekerjaan','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=ppp");
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
                $query = mysqli_query($config, "INSERT INTO tbl_ppp(no_ppp,lokasi_ppp,nama_perusahaan,permintaan_pekerjaan,file,id_user)
                                                                        VALUES('$no_ppp','$lokasi_ppp','$nama_perusahaan','$permintaan_pekerjaan','$nfile','$id_user')");
                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=ppp");
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
                <div class="nav-wrapper blue-grey darken-1">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="?page=ppp&act=add" class="judul"><i class="material-icons">queue</i> Tambah Permintaan Pekerjaan Parkir</a></li>
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
        <form class="col s12" method="POST" action="?page=ppp&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="input-field col s8">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <?php
                //memulai mengambil datanya
                $sql = mysqli_query($config, "SELECT no_ppp FROM tbl_ppp");


                $result = mysqli_num_rows($sql);

                if ($result <> 0) {
                    $kode = $result + 1;
                } else {
                    $kode = 1;
                }

                //mulai bikin kode
                $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                $tahun = date('Y-m');
                $kode_jadi = "PPP/$tahun/$bikin_kode";

                if (isset($_SESSION['no_ppp'])) {
                    $no_ppp = $_SESSION['no_ppp'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_ppp . '</div>';
                    unset($_SESSION['no_ppp']);
                }
                ?>
                <label for="no_ppp">No.PPP</label>
                <input type="text" class="form-control" id="no_ppp" name="no_ppp"  value="<?php echo $kode_jadi ?>"disabled>
                <input type="hidden" class="form-control" id="no_ppp" name="no_ppp"  value="<?php echo $kode_jadi ?>" >
            </div>

            <div class="input-field col s8">
                <i class="material-icons prefix md-prefix">location_on</i><label>Lokasi</label><br/>
                <div class="input-field col s11 right">
                    <select class="browser-default validate" name="lokasi_ppp" id="lokasi_ppp">
                        <option value="-- Pilih Lokasi --">-- Pilih Lokasi --</option>
                        <option value="Graha Pena Utama">Graha Pena Utama</option>
                        <option value="Graha Pena Extension">Graha Pena Extension</option>
                    </select>
                </div>
            </div>

            <div class="input-field col s8">
                <i class="material-icons prefix md-prefix">home</i>
                <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan" required>
                <?php
                if (isset($_SESSION['nama_perusahaan'])) {
                    $nama_perusahaan = $_SESSION['nama_perusahaan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_perusahaan . '</div>';
                    unset($_SESSION['nama_perusahaan']);
                }
                ?>
                <label for="nama_perusahaan">Nama Perusahaan</label>
            </div>

            <div class="input-field col s8">
                <i class="material-icons prefix md-prefix">build</i>
                <textarea id="permintaan_pekerjaan" class="materialize-textarea validate" name="permintaan_pekerjaan" required></textarea>
                <?php
                if (isset($_SESSION['permintaan_pekerjaan'])) {
                    $permintaan_pekerjaan = $_SESSION['permintaan_pekerjaan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $permintaan_pekerjaan . '</div>';
                    unset($_SESSION['permintaan_pekerjaan']);
                }
                ?>
                <label for="permintaan_pekerjaan">Permintaan Pekerjaan</label>
            </div>

            <div class="input-field col s8">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1">
                        <span>UPLOAD</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload file 1">
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
            <a href="?page=ppp" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
