<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_lpt = $_REQUEST['id_lpt'];


        //validasi form kosong
        if ($_REQUEST['nama_verifikator'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_verifikator = $_REQUEST['nama_verifikator'];
            $tgl_verifikasi = $_REQUEST['tgl_verifikasi'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $nama_verifikator)) {
                $_SESSION['nama_verifikator'] = 'Form TTd Kabag hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $tgl_verifikasi)) {
                    $_SESSION['tgl_verifikasi'] = 'Form TTD Spv hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $query = mysqli_query($config, "INSERT INTO tbl_verifikasi_lpt(nama_verifikator,tgl_verifikasi,id_lpt,id_user)
                                        VALUES('$nama_verifikator','$tgl_verifikasi','$id_lpt','$id_user')");

                    if ($query == true) {
                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                        echo '<script language="javascript">
                                                window.location.href="./admin.php?page=lpt";
                                              </script>';
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                }
            }
        }
    } else {
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Verifikasi</a></li>
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
            <form class="col s12" method="post" action="">

                <!-- Row in form START -->
                <div class="row">

                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">contacts</i>
                    <input id="nama_verifikator" type="text" class="validate" name="nama_verifikator" required>
                    <?php
                    if (isset($_SESSION['nama_verifikator'])) {
                        $nama_verifikator = $_SESSION['nama_verifikator'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_verifikator . '</div>';
                        unset($_SESSION['nama_verifikator']);
                    }
                    ?>
                    <label for="nama_verifikator">Nama Verifikator</label>
                </div>


                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_verifikasi" type="text" name="tgl_verifikasi" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_verifikasi'])) {
                        $tgl_verifikasi = $_SESSION['tgl_verifikasi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_verifikasi . '</div>';
                        unset($_SESSION['tgl_verifikasi']);
                    }
                    ?>
                    <label for="tgl_verifikasi">Tanggal Verifikasi</label>
                </div>
        </div>
        <!-- Row in form END -->

        <div class="row">
            <div class="col 6">
                <button type="submit" name ="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
            </div>
            <div class="col 6">
                <button type="reset" onclick="window.history.back();" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
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
