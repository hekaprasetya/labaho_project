<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['lokasi']) || empty($_REQUEST['catatan'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $lokasi = $_REQUEST['lokasi'];
            $jokey_on = $_REQUEST['jokey_on'];
            $jokey_off = $_REQUEST['jokey_off'];
            $main_on = $_REQUEST['main_on'];
            $main_off = $_REQUEST['main_off'];
            $catatan = $_REQUEST['catatan'];
            $id_user = $_SESSION['id_user'];
            $id_pompa = intval($_REQUEST['id_pompa']);
            $query = mysqli_query($config, "UPDATE utility_pompa SET lokasi='$lokasi', jokey_on='$jokey_on', jokey_off='$jokey_off', 
                main_on='$main_on', main_off='$main_off',catatan='$catatan' WHERE id_pompa='$id_pompa'");


            if ($query === true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                header("Location: ./admin.php?page=pompa");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            }
        }
    }

    $id_pompa = mysqli_real_escape_string($config, $_REQUEST['id_pompa']);
    $query = mysqli_query($config, "SELECT * FROM utility_pompa WHERE id_pompa='$id_pompa'");
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_assoc()) {
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
                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Edit Maintenance POMPA</a></li>
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
                <form class="col s12" method="post" action="" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">

                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="no_form" type="text" name="no_form" class="validate" value="<?= $row['no_form']; ?>" disabled>
                            <?php
                            if (isset($_SESSION['no_form'])) {
                                $no_form = $_SESSION['no_form'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $no_form ?></div>
                            <?php
                                unset($_SESSION['no_form']);
                            }
                            ?>
                            <label for="no_form">No.Form</label>
                        </div>



                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">place</i>
                            <label for="lokasi">LOKASI</label>
                            <br>
                            <div class="input-field col s11 right">
                                <select id="lokasi" class="browser-default validate theSelect" name="lokasi" required>
                                    <option value="<?= ($row['lokasi']) ? $row['lokasi'] : ''; ?>" selected><?= ($row['lokasi']) ? $row['lokasi'] : "Pilih Lokasi"; ?></option>
                                    <option value="GP-UTAMA">GP-UTAMA</option>
                                    <option value="GP-EXTENSION">GP-EXTENSION</option>
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
                            <input id="jokey_on" type="text" name="jokey_on" class="validate" value="<?= $row['jokey_on'] ?>" required>
                            <?php
                            if (isset($_SESSION['jokey_on'])) {
                                $jokey_on = $_SESSION['jokey_on'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $jokey_on ?></div>
                            <?php
                                unset($_SESSION['jokey_on']);
                            }
                            ?>
                            <label for="jokey_on">Jokey ON</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">panorama_fish_eye</i>
                            <input id="jokey_off" type="text" name="jokey_off" class="validate" value="<?= $row['jokey_off'] ?>" required>
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
                            <input id="main_on" type="text" name="main_on" class="validate" value="<?= $row['main_on'] ?>" required>
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
                            <input id="main_off" type="text" name="main_off" class="validate" value="<?= $row['main_off'] ?>" required>
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
                            <input id="catatan" type="text" name="catatan" class="validate" value="<?= $row['catatan'] ?>" required>
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
                    <!-- ROW IN FORM END -->
                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                        </div>
                    </div>
                </form>
                <!-- FORM END -->
            </div>
            <!-- ROW END -->
<?php
        }
    } else {
        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
    }
}
