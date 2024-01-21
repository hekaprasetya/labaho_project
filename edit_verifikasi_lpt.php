<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_lpt = $_REQUEST['id_lpt'];
        $query = mysqli_query($config, "SELECT * FROM tbl_lpt WHERE id_lpt='$id_lpt'");
        list($id_lpt) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['nama_verifikator'] == "" || $_REQUEST['tgl_verifikasi'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_verifikasi      = $_REQUEST['id_verifikasi'];
            $nama_verifikator   = $_REQUEST['nama_verifikator'];
            $tgl_verifikasi     = $_REQUEST['tgl_verifikasi'];
            $id_user            = $_SESSION['id_user'];

            //validasi input data


            $query = mysqli_query($config, "UPDATE tbl_verifikasi_lpt SET  nama_verifikator='$nama_verifikator', tgl_verifikasi='$tgl_verifikasi' ,  id_lpt='$id_lpt', id_user='$id_user' WHERE id_verifikasi='$id_verifikasi'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=lpt&act=verifikasi&id_lpt=' . $id_lpt . '";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {

        $id_verifikasi = mysqli_real_escape_string($config, $_REQUEST['id_verifikasi']);
        $query = mysqli_query($config, "SELECT * FROM tbl_verifikasi_lpt WHERE id_verifikasi='$id_verifikasi'");
        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {
                ?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Verifikasi</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
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
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="">

                        <!-- Row in form START -->
                        <div class="row">
                            
                            <div class="input-field col s6">
                                <input type="hidden" value="<?php echo $row['nama_verifikator']; ?>">
                                <i class="material-icons prefix md-prefix">people</i>
                                <input id="nama_verifikator" type="text" class="validate" name="nama_verifikator" value="<?php echo $row['nama_verifikator']; ?>" required>
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
                                <input type="hidden" value="<?php echo $row['tgl_verifikasi']; ?>">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="tgl_verifikasi" type="text" class="datepicker" name="tgl_verifikasi" value="<?php echo $row['tgl_verifikasi']; ?>" required>
                                <?php
                                if (isset($_SESSION['tgl_verifikasi'])) {
                                    $tgl_verifikasi = $_SESSION['tgl_verifikasi'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_verifikasi . '</div>';
                                    unset($_SESSION['tgl_verifikasi']);
                                }
                                ?>
                                <label for="tgl_verifikasi">Tgl.Verifikasi</label>
                            </div>
                        </div>
                        <!-- Row in form END -->

                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name ="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=lpt&act=verifikasi&id_lpt=<?php echo $row['id_lpt']; ?>" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
}
?>
