<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['nama_tenant'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_tenant = $_REQUEST['id_tenant'];
            $tgl_masuk = $_REQUEST['tgl_masuk'];
            $nama_tenant = $_REQUEST['nama_tenant'];
            $lantai = $_REQUEST['lantai'];
            $ruang = $_REQUEST['ruang'];
            $telp = $_REQUEST['telp'];
            $luas_ruangan = $_REQUEST['luas_ruangan'];
            $status_tenant = $_REQUEST['status_tenant'];

            $query = mysqli_query($config, "UPDATE master_tenant SET tgl_masuk='$tgl_masuk', nama_tenant='$nama_tenant', lantai='$lantai', ruang='$ruang', telp='$telp', luas_ruangan='$luas_ruangan', status_tenant='$status_tenant'  WHERE id_tenant='$id_tenant'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                header("Location: ./admin.php?page=master_tenant");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {

        $id_tenant = mysqli_real_escape_string($config, $_REQUEST['id_tenant']);
        $query = mysqli_query($config, "SELECT * FROM master_tenant WHERE id_tenant='$id_tenant'");
        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {
?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Tenant</a></li>
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

                            <div class="input-field col s9">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="tgl_masuk" type="text" name="tgl_masuk" class="datepicker" value="<?php echo $row['tgl_masuk']; ?>" required>
                                <?php
                                if (isset($_SESSION['tgl_masuk'])) {
                                    $tgl_masuk = $_SESSION['tgl_masuk'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_masuk . '</div>';
                                    unset($_SESSION['tgl_masuk']);
                                }
                                ?>
                                <label for="tgl_masuk">Tanggal Masuk</label>
                            </div>

                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['nama_tenant']; ?>">
                                <i class="material-icons prefix md-prefix">assignment_ind</i>
                                <input id="nama_tenant" type="text" class="validate" name="nama_tenant" value="<?php echo $row['nama_tenant']; ?>" required>
                                <?php
                                if (isset($_SESSION['nama_tenant'])) {
                                    $nama_tenant = $_SESSION['nama_tenant'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_tenant . '</div>';
                                    unset($_SESSION['nama_tenant']);
                                }
                                ?>
                                <label for="nama_tenant">Nama Tenant</label>
                            </div>
                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['lantai']; ?>">
                                <i class="material-icons prefix md-prefix">nature_people</i>
                                <input id="lantai" type="text" class="validate" name="lantai" value="<?php echo $row['lantai']; ?>">
                                <?php
                                if (isset($_SESSION['lantai'])) {
                                    $lantai = $_SESSION['lantai'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lantai . '</div>';
                                    unset($_SESSION['lantai']);
                                }
                                ?>
                                <label for="lantai" disabled>Lantai</label>
                            </div>
                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['ruang']; ?>">
                                <i class="material-icons prefix md-prefix">room</i>
                                <input id="ruang" type="text" class="validate" name="ruang" value="<?php echo $row['ruang']; ?>">
                                <?php
                                if (isset($_SESSION['ruang'])) {
                                    $ruang = $_SESSION['ruang'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ruang . '</div>';
                                    unset($_SESSION['ruang']);
                                }
                                ?>
                                <label for="no_tenant" disabled>Ruang</label>
                            </div>
                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['telp']; ?>">
                                <i class="material-icons prefix md-prefix">phone</i>
                                <input id="telp" type="text" class="validate" name="telp" value="<?php echo $row['telp']; ?>">
                                <?php
                                if (isset($_SESSION['telp'])) {
                                    $telp = $_SESSION['telp'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $telp . '</div>';
                                    unset($_SESSION['telp']);
                                }
                                ?>
                                <label for="no_tenant" disabled>Telp</label>
                            </div>
                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['luas_ruangan']; ?>">
                                <i class="material-icons prefix md-prefix">report</i>
                                <input id="luas_ruangan" type="text" class="validate" name="luas_ruangan" value="<?php echo $row['luas_ruangan']; ?>">
                                <?php
                                if (isset($_SESSION['luas_ruangan'])) {
                                    $luas_ruangan = $_SESSION['luas_ruangan'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $luas_ruangan . '</div>';
                                    unset($_SESSION['luas_ruangan']);
                                }
                                ?>
                                <label for="luas_ruangan" disabled>Luas Ruangan(m2)</label>
                            </div>
                            <div class="input-field col s7">
                                <input type="hidden" value="<?php echo $row['status_tenant']; ?>">
                                <i class="material-icons prefix md-prefix">import_export</i>
                                <label>Status</label><br />
                                <input type="hidden" id="id_tenant" name="id_tenant" value="<?= $row['id_tenant'] ?>" />
                                <select name="status_tenant" class="browser-default validate" id="status_tenant" required>
                                <option value="<?= $row['status_tenant'] ?>" selected><?= $row['status_tenant'] ?></option>
                                    <option value="">Pilih Status</option>
                                    <option value="Masuk">Masuk</option>
                                    <option value="Keluar">Keluar</option>
                                </select>
                                <?php
                                if (isset($_SESSION['status_tenant'])) {
                                    $status_tenant = $_SESSION['status_tenant'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status_tenant . '</div>';
                                    unset($_SESSION['status_tenant']);
                                }
                                ?>
                                <label for="status_tenant" disabled>Status</label>
                            </div>
                        </div>
                        <!-- Row in form END -->

                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=master_tenant" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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