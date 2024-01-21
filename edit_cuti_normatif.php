<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong

        $no_form_normatif = $_REQUEST['no_form_normatif'];
        $tgl_cuti = $_REQUEST['tgl_cuti'];
        $akhir_cuti = $_REQUEST['akhir_cuti'];
        $jenis_ijin = $_REQUEST['jenis_ijin'];
        $lain = $_REQUEST['lain'];
        $id_user = $_SESSION['id_user'];

        $id_cuti_normatif = $_REQUEST['id_cuti_normatif'];
        $query = mysqli_query($config, "UPDATE tbl_cuti_normatif SET no_form_normatif='$no_form_normatif', tgl_cuti='$tgl_cuti', akhir_cuti='$akhir_cuti', jenis_ijin='$jenis_ijin', lain='$lain', id_user='$id_user' WHERE id_cuti_normatif='$id_cuti_normatif'");

        if ($query == true) {
            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
            header("Location: ./admin.php?page=cuti_normatif");
            die();
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            echo '<script language="javascript">window.history.back();</script>';
        }
    } else {

        $id_cuti_normatif = mysqli_real_escape_string($config, $_REQUEST['id_cuti_normatif']);
        $query = mysqli_query($config, "SELECT * FROM tbl_cuti_normatif WHERE id_cuti_normatif='$id_cuti_normatif'");
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
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Ijin Normatif</a></li>
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
                                <input type="hidden" value="<?php echo $row['no_form_normatif']; ?>">
                                <i class="material-icons prefix md-prefix">people</i>
                                <input id="no_form_normatif" type="text" class="validate" name="no_form_normatif" value="<?php echo $row['no_form_normatif']; ?>">
                                <?php
                                if (isset($_SESSION['no_form_normatif'])) {
                                    $no_form_normatif = $_SESSION['no_form_normatif'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form_normatif . '</div>';
                                    unset($_SESSION['no_form_normatif']);
                                }
                                ?>
                                <label for="no_form_normatif"disabled>No.Form</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">schedule</i>
                                <input id="tgl_cuti" type="text" class="datepicker" name="tgl_cuti" value="<?php echo indoDate($row['tgl_cuti']); ?>" required>
                                <?php
                                if (isset($_SESSION['tgl_cuti'])) {
                                    $tgl_cuti = $_SESSION['tgl_cuti'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['tgl_cuti']) . '</div>';
                                    unset($_SESSION['tgl_cuti']);
                                }
                                ?>
                                <label for="tgl_cuti">Tanggal Cuti</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">schedule</i>
                                <input id="akhir_cuti" type="text" class="validate" name="akhir_cuti" value="<?php echo indoDate($row['akhir_cuti']); ?>" required>
                                <?php
                                if (isset($_SESSION['akhir_cuti'])) {
                                    $akhir_cuti = $_SESSION['akhir_cuti'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['akhir_cuti']) . '</div>';
                                    unset($_SESSION['akhir_cuti']);
                                }
                                ?>
                                <label for="akhir_cuti">Akhir Cuti</label>
                            </div>

                            <div class="input-field col s10">
                                <i class="material-icons prefix md-prefix">supervisor_account</i>
                                <label for="jenis_ijin">Jenis Ijin</label><br />
                                <div class="input-field col s11 right">
                                    <select class="browser-default validate" name="jenis_ijin" id="jenis_ijin">
                                        <option value="" <?php echo ($row['jenis_ijin'] === '') ? 'selected' : ''; ?>>Pilih Jenis</option>
                                        <option value="Menikah pertama kali (3 Hari)" <?php echo ($row['jenis_ijin'] === 'Menikah pertama kali (3 Hari)') ? 'selected' : ''; ?>>Menikah pertama kali (3 Hari)</option>
                                        <option value="Suami/istri meninggal (2 Hari)" <?php echo ($row['jenis_ijin'] === 'Suami/istri meninggal (2 Hari)') ? 'selected' : ''; ?>>Suami/istri meninggal (2 Hari)</option>
                                        <option value="Ortu/anak kandung meninggal (2 Hari)" <?php echo ($row['jenis_ijin'] === 'Ortu/anak kandung meninggal (2 Hari)') ? 'selected' : ''; ?>>Ortu/anak kandung meninggal (2 Hari)</option>
                                        <option value="Mertua/menantu meninggal (2 Hari)" <?php echo ($row['jenis_ijin'] === 'Mertua/menantu meninggal (2 Hari)') ? 'selected' : ''; ?>>Mertua/menantu meninggal (2 Hari)</option>
                                        <option value="Saudara kandung meninggal (2 Hari)" <?php echo ($row['jenis_ijin'] === 'Saudara kandung meninggal (2 Hari)') ? 'selected' : ''; ?>>Saudara kandung meninggal (2 Hari)</option>
                                        <option value="Istri pertama  meninggal (2 Hari)" <?php echo ($row['jenis_ijin'] === 'Istri pertama  meninggal (2 Hari)') ? 'selected' : ''; ?>>Istri pertama  meninggal (2 Hari)</option>
                                        <option value="Pernikahan anak sah (2 Hari)" <?php echo ($row['jenis_ijin'] === 'Pernikahan anak sah (2 Hari)') ? 'selected' : ''; ?>>Pernikahan anak sah (2 Hari)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['lain']; ?>">
                                <i class="material-icons prefix md-prefix">web</i>
                                <input id="lain" type="text" class="validate" name="lain" value="<?php echo $row['lain']; ?>" required>
                                <?php
                                if (isset($_SESSION['lain'])) {
                                    $lain = $_SESSION['lain'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lain . '</div>';
                                    unset($_SESSION['lain']);
                                }
                                ?>
                                <label for="lain">Lain Lain</label>
                            </div>
                        </div>
                        <!-- Row in form END -->

                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=cuti_normatif" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
