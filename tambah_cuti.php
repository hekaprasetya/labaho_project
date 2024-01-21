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

            $no_form = $_REQUEST['no_form'];
            $jumlah_hari = $_REQUEST['jumlah_hari'];
            $alasan_cuti = $_REQUEST['alasan_cuti'];
            $tgl_cuti = $_REQUEST['tgl_cuti'];
            $akhir_cuti = $_REQUEST['akhir_cuti'];
            $id_user = $_SESSION['id_user'];


            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ("") {


                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 10000000) {


                        $query = mysqli_query($config, "INSERT INTO tbl_cuti(no_form,jumlah_hari,alasan_cuti,tgl_cuti,akhir_cuti,id_user)
                                                                        VALUES('$no_form','$jumlah_hari','$alasan_cuti','$tgl_cuti','$akhir_cuti','$id_user')");


                        if ($query == true) {
                            if (isset($_SESSION["tableDet"])) {
                                unset($_SESSION["tableDet"]);
                            }
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=cuti");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    } else {
                        $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                } else {
                    $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            } else {

                //jika form file kosong akan mengeksekusi script dibawah ini
                $query = mysqli_query($config, "INSERT INTO tbl_cuti(no_form,jumlah_hari,alasan_cuti,tgl_cuti,akhir_cuti,id_user)
                VALUES('$no_form','$jumlah_hari','$alasan_cuti','$tgl_cuti','$akhir_cuti','$id_user')");



                if ($query == true) {
                    if (isset($_SESSION["tableDet"])) {
                        unset($_SESSION["tableDet"]);
                    }
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=cuti");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    } else {
?>
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=cuti&act=add" enctype="multipart/form-data">
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=cuti&act=add" class="judul"><i class="material-icons">local_grocery_store</i> Tambah Data CUTI</a></li>
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
                    $sql = mysqli_query($config, "SELECT no_form FROM tbl_cuti");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    // $tahun = date('Y-m');
                    $kode_jadi = "FM/HRD/008/$bikin_kode";

                    if (isset($_SESSION['no_form'])) {
                        $no_form = $_SESSION['no_form'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form . '</div>';
                        unset($_SESSION['no_form']);
                    }
                    ?>
                    <label for="no_form"><strong>No.Form</strong></label>
                    <input type="text" class="form-control" id="no_form" name="no_form" value="<?php echo $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="no_form" name="no_form" value="<?php echo $kode_jadi ?>">
                </div>

                 <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">description</i>
                    <textarea id="alasan_cuti" class="materialize-textarea validate" name="alasan_cuti" required></textarea>
                    <?php
                    if (isset($_SESSION['alasan_cuti'])) {
                        $alasan_cuti = $_SESSION['alasan_cuti'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $alasan_cuti . '</div>';
                        unset($_SESSION['alasan_cuti']);
                    }
                    ?>
                    <label for="alasan_cuti">Keperluan</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">beach_access</i>
                    <input id="jumlah_hari" type="number" class="validate" name="jumlah_hari" required>
                    <?php
                    if (isset($_SESSION['jumlah_hari'])) {
                        $jumlah_hari = $_SESSION['jumlah_hari'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah_hari . '</div>';
                        unset($_SESSION['jumlah_hari']);
                    }
                    ?>
                    <label for="jumlah_hari">Jumlah Hari</label>
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
                <a href="?page=cuti" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
            </div>
        </div>

        </form>
        <!-- Form END -->

        </div>
        <!-- Row form END -->
        <script>
            $(".theSelect").select2();
        </script>
        <script>
            function myalert() {
                alert("Apa anda yakin ingin menghapus?");
            }
        </script>

<?php
    }
}
?>