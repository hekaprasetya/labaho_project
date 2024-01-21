<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {


        $tgl_masuk = $_REQUEST['tgl_masuk'];
        $nama_tenant = $_REQUEST['nama_tenant'];
        $lantai = $_REQUEST['lantai'];
        $ruang = $_REQUEST['ruang'];
        $telp = $_REQUEST['telp'];
        $luas_ruangan = $_REQUEST['luas_ruangan'];
        $status_tenant = $_REQUEST['status_tenant'];

        $query = mysqli_query($config, "INSERT INTO master_tenant (tgl_masuk, nama_tenant, lantai, ruang, telp, luas_ruangan, status_tenant)
                                                                            VALUES('$tgl_masuk','$nama_tenant','$lantai','$ruang','$telp','$luas_ruangan', '$status_tenant')");

        if ($query == true) {
            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
            $last_insert_id = mysqli_insert_id($config);
            echo '<script language="javascript">
                  window.location.href="./admin.php?page=master_tenant";
                  </script>';
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            echo '<script language="javascript">window.history.back();</script>';
        }
    } else {
?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue darken-2">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">people</i> Tambah Tenant</a></li>
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

                <!-- <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    // $sql = mysqli_query($config, "SELECT id_tenant FROM master_tenant");

                    // $result = mysqli_num_rows($sql);

                    // if ($result <> 0) {
                    //     $kode = $result + 1;
                    // } else {
                    //     $kode = 1;
                    // }

                    //mulai bikin kode
                    // $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    // $tahun = date('Y-m');
                    // $kode_jadi = "Tenant/$tahun/$bikin_kode";

                    // if (isset($_SESSION['nama_tenant'])) {
                    //     $id_tenant = $_SESSION['nama_tenant'];
                    //     echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $id_tenant . '</div>';
                    //     unset($_SESSION['nama_tenant']);
                    // }
                    ?> 
                    <label for="id_tenant"><strong>No.Tenant</strong></label>
                    <input type="text" class="form-control" id="id_tenant" name="id_tenant" value="<?php echo $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="id_tenant" name="id_tenant" value="<?php echo $kode_jadi ?>">
                </div> -->

                <div class="input-field col s9">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_masuk" type="text" name="tgl_masuk" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_masuk'])) {
                        $tgl_masuk = $_SESSION['tgl_masuk'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_masuk . '</div>';
                        unset($_SESSION['tgl_masuk']);
                    }
                    ?>
                    <label for="tgl_masuk">Tanggal Masuk</label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">assignment_ind</i>
                    <input id="nama_tenant" type="text" class="validate" name="nama_tenant" required>
                    <?php
                    if (isset($_SESSION['nama_tenant'])) {
                        $nama_tenant = $_SESSION['nama_tenant'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_tenant . '</div>';
                        unset($_SESSION['nama_tenant']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="nama_tenant">Nama Tenant</label>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">nature_people</i>
                    <input id="lantai" type="text" class="validate" name="lantai" required>
                    <?php
                    if (isset($_SESSION['lantai'])) {
                        $lantai = $_SESSION['lantai'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lantai . '</div>';
                        unset($_SESSION['lantai']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="lantai">lantai</label>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">room</i>
                    <input id="ruang" type="text" class="validate" name="ruang" required>
                    <?php
                    if (isset($_SESSION['ruang'])) {
                        $ruang = $_SESSION['ruang'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ruang . '</div>';
                        unset($_SESSION['ruang']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="ruang">ruang</label>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">phone</i>
                    <input id="telp" type="text" class="validate" name="telp" required>
                    <?php
                    if (isset($_SESSION['telp'])) {
                        $telp = $_SESSION['telp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $telp . '</div>';
                        unset($_SESSION['telp']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="telp">telp</label>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">report</i>
                    <input id="luas_ruangan" type="text" class="validate" name="luas_ruangan" required>
                    <?php
                    if (isset($_SESSION['luas_ruangan'])) {
                        $luas_ruangan = $_SESSION['luas_ruangan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $luas_ruangan . '</div>';
                        unset($_SESSION['luas_ruangan']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="luas_ruangan">Luas Ruangan</label>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">import_export</i>
                    <label>Status</label><br />
                    <input type="hidden" id="id_tenant" name="id_tenant" value="<?= $row['id_tenant'] ?>" />
                    <select name="status_tenant" class="browser-default validate" id="status_tenant" required>
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
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="status_tenant">Status</label>
                </div>

        </div>
        <!-- Row in form END -->

        <div class="row">
            <div class="col 6">
                <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
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