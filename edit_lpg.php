<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_lpg'] == "" || $_REQUEST['tgl_lpg'] == "" || $_REQUEST['pekerjaan_lpg'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_lpg = $_REQUEST['id_lpg'];
            $no_lpg = $_REQUEST['no_lpg'];
            $tgl_lpg = $_REQUEST['tgl_lpg'];
            $pekerjaan_lpg = $_REQUEST['pekerjaan_lpg'];
            $id_user = $_SESSION['id_user'];

            $id_lpg = $_REQUEST['id_lpg'];
            $query = mysqli_query($config, "UPDATE tbl_lpg SET no_lpg='$no_lpg', tgl_lpg='$tgl_lpg', pekerjaan_lpg='$pekerjaan_lpg', id_user='$id_user' WHERE id_lpg='$id_lpg'");
            
            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                header("Location: ./admin.php?page=lpg_gudang");
                  die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {

        $id_lpg = mysqli_real_escape_string($config, $_REQUEST['id_lpg']);
        $query = mysqli_query($config, "SELECT * FROM tbl_lpg WHERE id_lpg='$id_lpg'");
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
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit E-LPG</a></li>
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
                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['no_lpg']; ?>">
                                <i class="material-icons prefix md-prefix">people</i>
                                <input id="no_lpg" type="text" class="validate" name="no_lpg" value="<?php echo $row['no_lpg']; ?>">
                                <?php
                                if (isset($_SESSION['no_lpg'])) {
                                    $no_lpg = $_SESSION['no_lpg'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_lpg . '</div>';
                                    unset($_SESSION['no_lpg']);
                                }
                                ?>
                                <label for="no_lpg"disabled>NO.LPG</label>
                            </div>

                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['tgl_lpg']; ?>">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="tgl_lpg" type="text" class="datepicker" name="tgl_lpg" value="<?php echo $row['tgl_lpg']; ?>" required>
                                <?php
                                if (isset($_SESSION['tgl_lpg'])) {
                                    $tgl_lpg = $_SESSION['tgl_lpg'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_lpg . '</div>';
                                    unset($_SESSION['tgl_lpg']);
                                }
                                ?>
                                <label for="tgl_lpg">Tgl.LPG</label>
                            </div>

                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['pekerjaan_lpg']; ?>">
                                <i class="material-icons prefix md-prefix">web</i>
                                <input id="pekerjaan_lpg" type="text" class="validate" name="pekerjaan_lpg" value="<?php echo $row['pekerjaan_lpg']; ?>" required>
                                <?php
                                if (isset($_SESSION['pekerjaan_lpg'])) {
                                    $pekerjaan_lpg = $_SESSION['pekerjaan_lpg'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pekerjaan_lpg . '</div>';
                                    unset($_SESSION['pekerjaan_lpg']);
                                }
                                ?>
                                <label for="pekerjaan_lpg">Jenis Pekerjaan</label>
                            </div>
                        </div>
                        <!-- Row in form END -->

                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=lpg_gudang" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
