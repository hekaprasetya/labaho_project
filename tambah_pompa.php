<?php
//cek session
if (empty($_SESSION['admin']) || empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['lokasi']) || empty($_REQUEST['kode_form'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $no_form = $_REQUEST['no_form'];
            $kode_form = $_REQUEST['kode_form'];
            $lokasi = $_REQUEST['lokasi'];
            $jokey_on = $_REQUEST['jokey_on'];
            $jokey_off = $_REQUEST['jokey_off'];
            $main_on = $_REQUEST['main_on'];
            $main_off = $_REQUEST['main_off'];
            $catatan = $_REQUEST['catatan'];
            $id_user = $_SESSION['id_user'];

            $query = mysqli_query($config, "INSERT INTO utility_pompa (no_form, kode_form, lokasi, jokey_on, jokey_off, main_on, main_off,catatan, id_user)
                VALUES ('$no_form', '$kode_form', '$lokasi', '$jokey_on', '$jokey_off', '$main_on', '$main_off','$catatan','$id_user')");

            if ($query === true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=pompa");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }
?>
    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <div class="z-depth-1">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue darken-2">
                        <div class="col m7">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">add_alert</i> Tambah Maintenance POMPA</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Secondary Nav END -->
    </div>
    <!-- Row END -->

    <?php
    if (isset($_SESSION['succAdd'])) {
        $succAdd = $_SESSION['succAdd'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succAdd']);
    }
    if (isset($_SESSION['succEdit'])) {
        $succEdit = $_SESSION['succEdit'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succEdit']);
    }
    if (isset($_SESSION['succDel'])) {
        $succDel = $_SESSION['succDel'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succDel']);
    }
    ?>
    <!-- Row form Start -->
    <div class="row jarak-form">

        <!-- Form START -->
        <form class="col s12" method="post" action="?page=pompa&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    // memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT kode_form, tanggal FROM utility_pompa WHERE no_form IS NOT NULL ORDER BY id_pompa DESC LIMIT 1");

                    // mengambil nilai no_form terbaru
                    $result = mysqli_fetch_assoc($sql);

                    if (!empty($result['kode_form']) && !empty($result['tanggal'])) {
                        $tanggal_terakhir = $result['tanggal'];
                        $tahun_terakhir = date("Y", strtotime($tanggal_terakhir));
                        $tahun_sekarang = date("Y");
                        // Periksa apakah input terakhir pada tahun yang sama
                        ($tahun_sekarang == $tahun_terakhir) ? $kode = $result['kode_form'] + 1 :  $kode = 1;
                    } else {
                        $sql = mysqli_query($config, "SELECT no_form FROM utility_pompa WHERE no_form IS NOT NULL");
                        ($result = mysqli_num_rows($sql)) != NULL ?  $kode = $result + 1 :  $kode = 1;
                    }
                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    // $tahun = date('Y-m');
                    $kode_jadi = "PM/POMPA/$bikin_kode";

                    if (isset($_SESSION['no_form'])) {
                        $no_form = $_SESSION['no_form'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form . '</div>';
                        unset($_SESSION['no_form']);
                    }
                    ?>
                    <label for="no_form"><strong>No.Form</strong></label>
                    <input type="text" class="form-control" id="no_form" name="no_form" value="<?= $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="no_form" name="no_form" value="<?= $kode_jadi ?>">
                    <input type="hidden" class="form-control" id="kode_form" name="kode_form" value="<?= $kode ?>">
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">place</i>
                    <label for="lokasi">Lokasi</label>
                    <br>
                    <div class="input-field col s11 right">
                        <select id="lokasi" class="browser-default validate theSelect" name="lokasi" required>
                            <option disabled selected>Pilih Lokasi</option>
                            <option value="GP-Utama">GP-Utama</option>
                            <option value="GP-Extension">GP-Extension</option>
                        </select>
                    </div>
                    <?php
                    if (isset($_SESSION['lokasi'])) {
                        $lokasi = $_SESSION['lokasi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi . '</div>';
                        unset($_SESSION['lokasi']);
                    }
                    ?>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">radio_button_checked</i>
                    <input id="jokey_on" type="text" name="jokey_on" class="validate" required>
                    <?php
                    if (isset($_SESSION['jokey_on'])) {
                        $jokey_on = $_SESSION['jokey_on'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $jokey_on ?></div>
                    <?php
                        unset($_SESSION['jokey_on']);
                    }
                    ?>
                    <label for="jokey_on">Jokey On</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">panorama_fish_eye</i>
                    <input id="jokey_off" type="text" name="jokey_off" class="validate" required>
                    <?php
                    if (isset($_SESSION['jokey_off'])) {
                        $jokey_off = $_SESSION['jokey_off'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $jokey_off ?></div>
                    <?php
                        unset($_SESSION['jokey_off']);
                    }
                    ?>
                    <label for="jokey_off">Jokey Off</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">notifications_active</i>
                    <input id="main_on" type="text" name="main_on" class="validate" required>
                    <?php
                    if (isset($_SESSION['main_on'])) {
                        $main_on = $_SESSION['main_on'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $main_on ?></div>
                    <?php
                        unset($_SESSION['main_on']);
                    }
                    ?>
                    <label for="main_on">Main On</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">notifications_none</i>
                    <input id="main_off" type="text" name="main_off" class="validate" required>
                    <?php
                    if (isset($_SESSION['main_off'])) {
                        $main_off = $_SESSION['main_off'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $main_off ?></div>
                    <?php
                        unset($_SESSION['main_off']);
                    }
                    ?>
                    <label for="main_off">Main Off</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">message</i>
                    <input id="catatan" type="text" name="catatan" class="validate" required>
                    <?php
                    if (isset($_SESSION['catatan'])) {
                        $catatan = $_SESSION['catatan'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $catatan ?></div>
                    <?php
                        unset($_SESSION['catatan']);
                    }
                    ?>
                    <label for="catatan">Catatan</label>
                </div>



            </div>
            <div class="row">
                <div class="col 6">
                    <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                </div>
                <div class="col 6">
                    <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                </div>
            </div>
            <!-- ROW IN FORM END -->
        </form>
        <!-- FORM END -->
    </div>
    <!-- ROW END -->
<?php
}
