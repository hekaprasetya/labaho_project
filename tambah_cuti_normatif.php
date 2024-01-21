<link rel="stylesheet" href="">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

//validasi form kosong
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_form_normatif = $_REQUEST['no_form_normatif'];
            $jenis_ijin = $_REQUEST['jenis_ijin'];
            $tgl_cuti = $_REQUEST['tgl_cuti'];
            $akhir_cuti = $_REQUEST['akhir_cuti'];
            $lain = $_REQUEST['lain'];
            $id_user = $_SESSION['id_user'];



//jika form file kosong akan mengeksekusi script dibawah ini
            $query = mysqli_query($config, "INSERT INTO tbl_cuti_normatif(no_form_normatif,jenis_ijin,tgl_cuti,akhir_cuti,lain,id_user)
                VALUES('$no_form_normatif','$jenis_ijin','$tgl_cuti','$akhir_cuti','$lain','$id_user')");

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=cuti_normatif";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {
        ?>
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=cuti_normatif&act=add" enctype="multipart/form-data">
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=cuti_normatif&act=add" class="judul"><i class="material-icons">control_point_duplicate</i> IJIN NORMATIF</a></li>
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

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_form_normatif FROM tbl_cuti_normatif");
                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    // $tahun = date('Y-m');
                    $kode_jadi = "FM/HRD/IJIN NORMATIF/$bikin_kode";

                    if (isset($_SESSION['no_form_normatif'])) {
                        $no_form_normatif = $_SESSION['no_form_normatif'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form_normatif . '</div>';
                        unset($_SESSION['no_form_normatif']);
                    }
                    ?>
                    <label for="no_form_normatif"><strong>No.Form</strong></label>
                    <input type="text" class="form-control" id="no_form" name="no_form_normatif" value="<?php echo $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="no_form" name="no_form_normatif" value="<?php echo $kode_jadi ?>">
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">input</i><label>Jenis Ijin</label><br/>
                    <div class="input-field col s11 ">
                        <select class="browser-default validate" name="jenis_ijin" id="jenis_ijin" required>
                            <option value="">Pilih jenis ijin</option>
                            <option value="Menikah pertama kali">Menikah pertama kali (3 Hari)</option>
                            <option value="Suami/istri meninggal">Suami/istri meninggal (3 Hari)</option>
                            <option value="Ortu/anak kandung meninggal">Ortu/anak kandung meninggal (3 Hari)</option>
                            <option value="Mertua/menantu meninggal">Mertua/menantu meninggal (2 Hari)</option>
                            <option value="Saudara kandung meninggal">Saudara kandung meninggal (2 Hari)</option>
                            <option value="Istri pertama meninggal">Istri pertama  meninggal (2 Hari)</option>
                            <option value="Pernikahan anak sah">Pernikahan anak sah (2 Hari)</option>
                        </select>
                    </div>
                </div>
                
                  <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">edit</i>
                    <input id="lain" type="text" class="validate" name="lain">
                    <?php
                    if (isset($_SESSION['lain'])) {
                        $lain = $_SESSION['lain'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lain . '</div>';
                        unset($_SESSION['lain']);
                    }
                    ?>
                    <label for="lain">Lainnya</label>
                </div>
                
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_cuti" type="date" name="tgl_cuti" class="event_available" required>
                    <?php
                    if (isset($_SESSION['tgl_cuti'])) {
                        $tgl_cuti = $_SESSION['tgl_cuti'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_cuti . '</div>';
                        unset($_SESSION['tgl_cuti']);
                    }
                    ?>
                    <label for="tgl_cuti">Tanggal Cuti</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">event_busy</i>
                    <input id="akhir_cuti" type="date" name="akhir_cuti" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['akhir_cuti'])) {
                        $akhir_cuti = $_SESSION['akhir_cuti'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $akhir_cuti . '</div>';
                        unset($_SESSION['akhir_cuti']);
                    }
                    ?>
                    <label for="akhir_cuti">Akhir Cuti</label>
                </div>
                <br>
                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>

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
?>