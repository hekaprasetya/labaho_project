<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_wo'] == "" || $_REQUEST['divisi'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_wo = $_REQUEST['id_wo'];
            $no_wo = $_REQUEST['no_wo'];
            $divisi = $_REQUEST['divisi'];
            $id_user = $_SESSION['id_user'];


            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $no_wo)) {
                $_SESSION['no_wo'] = 'Form No LPT hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $divisi)) {
                    $_SESSION['divisi'] = 'No.Form hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {


                    $id_wo = $_REQUEST['id_wo'];
                    $query = mysqli_query($config, "UPDATE tbl_wo SET no_wo='$no_wo', divisi='$divisi', id_user='$id_user' WHERE id_wo='$id_wo'");

                    if ($query == true) {
                        $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                        echo '<script language="javascript">
                                           window.location.href="./admin.php?page=work_order";
                                      </script>';
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                }
            }
        }
    } else {

        $id_wo = mysqli_real_escape_string($config, $_REQUEST['id_wo']);
        $query = mysqli_query($config, "SELECT * FROM tbl_wo WHERE id_wo='$id_wo'");
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
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit</a></li>
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
                            <div class="input-field col s8">
                                <input type="hidden" value="<?php echo $row['no_wo']; ?>">
                                <i class="material-icons prefix md-prefix">looks_one</i>
                                <input id="no_wo" type="text" class="validate" name="no_wo" value="<?php echo $row['no_wo']; ?>">
                                <?php
                                if (isset($_SESSION['no_wo'])) {
                                    $no_wo = $_SESSION['no_wo'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_wo . '</div>';
                                    unset($_SESSION['no_wo']);
                                }
                                ?>
                                <label for="no_wo"><strong>NO.WO</strong></label>
                            </div>

                            <div class="input-field col s8">
                                <input type="hidden" value="<?php echo $row['divisi']; ?>">
                                <i class="material-icons prefix md-prefix">people</i>
                                <input id="divisi" type="text" class="validate" name="divisi" value="<?php echo $row['divisi']; ?>" required>
                                <?php
                                if (isset($_SESSION['divisi'])) {
                                    $divisi = $_SESSION['divisi'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi . '</div>';
                                    unset($_SESSION['divisi']);
                                }
                                ?>
                                <label for="divisi"><strong>Divisi</strong></label>
                            </div>

                        </div>
                        <!-- Row in form END -->

                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=work_order" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
