<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_surat = $_REQUEST['id_surat'];
        $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
        $no = 1;
        list($id_surat) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['no_lpg'] == "" | $_REQUEST['tgl_lpg'] == "" | $_REQUEST['pekerjaan_lpg'] == "" ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_lpg = $_REQUEST['no_lpg'];
            $tgl_lpg = $_REQUEST['tgl_lpg'];
            $pekerjaan_lpg = $_REQUEST['pekerjaan_lpg'];
            $id_user = $_SESSION['id_user'];

            $query = mysqli_query($config, "INSERT INTO tbl_lpg(no_lpg,tgl_lpg,pekerjaan_lpg,id_surat,id_user)
                     VALUES('$no_lpg','$tgl_lpg','$pekerjaan_lpg','$id_surat','$id_user')");

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                $last_insert_id = mysqli_insert_id($config);
                echo '<script language="javascript">
                window.location.href="./admin.php?page=tsm&id_lpg=' . $last_insert_id . '";
              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
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
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah E-LPG</a></li>
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

                <div class="input-field col s7">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_lpg FROM tbl_lpg");
                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('Y-m');
                    $kode_jadi = "LPG/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_lpg'])) {
                        $no_lpt = $_SESSION['no_lpg'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_lpg . '</div>';
                        unset($_SESSION['no_lpg']);
                    }
                    ?>
                    <label for="no_lpg">No.LPG</label>
                    <input type="text" class="form-control" id="no_lpg" name="no_lpg"  value="<?php echo $kode_jadi ?>">
                    <input type="hidden" class="form-control" id="no_lpg" name="no_lpg"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s7">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_lpg" type="text" name="tgl_lpg" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_lpg'])) {
                        $tgl_lpg = $_SESSION['tgl_lpg'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_lpg . '</div>';
                        unset($_SESSION['tgl_lpg']);
                    }
                    ?>
                    <label for="tgl_lpg">Tanggal LPG</label>
                </div>
                
                <div class="input-field col s7">
                    <i class="material-icons prefix md-prefix">description</i>
                    <textarea id="pekerjaan_lpg" class="materialize-textarea validate" name="pekerjaan_lpg" required></textarea>
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
                <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
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
