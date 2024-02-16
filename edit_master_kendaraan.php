<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        //validasi form kosong
        if (empty($_REQUEST['kendaraan']) || empty($_REQUEST['nopol'])) {
            $text = 'ERROR! Semua form wajib diisi';
            sweetError($text);
        } else {

            $id_kendaraan = $_REQUEST['id_kendaraan'];
            $kendaraan = $_REQUEST['kendaraan'];
            $nopol = $_REQUEST['nopol'];
            $value = [$kendaraan, $nopol];
            $update = new DataBaseHandler($config);
            $res = $update->update('master_kendaraan', ['kendaraan', 'nopol'], $value, 'id_kendaraan', $id_kendaraan);
            if ($res['success'] == true) {
                sweetSucc('Data Berhasil Diperbarui.', '?page=master_kendaraan');
            } else {
                echo $res['error'];
                sweetError();
            }
        }
    } else {
        $id_kendaraan = mysqli_real_escape_string($config, $_REQUEST['id_kendaraan']);
        $query = mysqli_query($config, "SELECT * FROM master_kendaraan WHERE id_kendaraan='$id_kendaraan'");
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
                                            <li class="waves-effect waves-light"><a href="#" class="judul"><i
                                                        class="material-icons md-3">directions_car</i> Edit Kendaraan</a></li>
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

                <!-- ROW START -->
                <div class="row jarak-form">
                    <!-- FORM START -->
                    <form class="col s12" action="" method="post">
                        <!-- ROW IN FORM START-->
                        <div class="row">

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">directions_car</i>
                                <input id="kendaraan" type="text" name="kendaraan" class="validate"
                                    value="<?php echo $row['kendaraan']; ?>">
                                <?php
                                if (isset($_SESSION['kendaraan'])) {
                                    $kendaraan = $_SESSION['kendaraan'];
                                    ?>
                                    <div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">
                                        <?= $kendaraan ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['kendaraan']);
                                }
                                ?>
                                <label for="kendaraan">Nama Kendaraan</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">fiber_pin</i>
                                <input id="nopol" type="text" name="nopol" class="validate" value="<?php echo $row['nopol']; ?>"
                                    required>
                                <?php
                                if (isset($_SESSION['nopol'])) {
                                    $nopol = $_SESSION['nopol'];
                                    ?>
                                    <div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">
                                        <?= $nopol ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['nopol']);
                                }
                                ?>
                                <label for="nopol">Plat Nomor</label>
                            </div>

                            <div class="row">
                                <div class="col 6">
                                    <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i
                                            class="material-icons">done</i></button>
                                </div>
                                <div class="col 6">
                                    <button type="reset" onclick="window.history.back();"
                                        class="btn small deep-orange waves-effect waves-light">BATAL <i
                                            class="material-icons">clear</i></button>
                                </div>
                            </div>

                        </div>
                        <!-- ROW IN FORM END -->
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
}
