<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        // print_r($_POST);die;

        $id_pengaduan = $_REQUEST['id_pengaduan'];
        $query = mysqli_query($config, "SELECT * FROM tbl_pengaduan WHERE id_pengaduan='$id_pengaduan'");
        $no = 1;
        list($id_pengaduan) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['no_wo'] == "" || $_REQUEST['divisi'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_wo          = $_REQUEST['no_wo'];
            $divisi         = $_REQUEST['divisi'];
            $id_user        = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $no_wo)) {
                $_SESSION['no_wo'] = 'Form No LPT hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $divisi)) {
                    $_SESSION['divisi'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {
                    
                    $cek_data_qry = mysqli_query($config, "select * FROM tbl_wo where id_pengaduan='$id_pengaduan'");
                    $cek_data = mysqli_num_rows($cek_data_qry);
                    $cek_data_row = mysqli_fetch_array($cek_data_qry);
                    if ($cek_data == 0) {
                        $query = mysqli_query($config, "INSERT INTO tbl_wo (no_wo,divisi,id_pengaduan,id_user)
                                                                            VALUES('$no_wo','$divisi','$id_pengaduan','$id_user')");
                    }else {
                        $query = mysqli_query($config, "UPDATE tbl_wo SET
                        no_wo       ='$no_wo',
                        divisi      ='$divisi',
                        id_user     ='$id_user', 
                        id_pengaduan     ='$id_pengaduan' 
                        WHERE $cek_data_row[id_wo]");
                    }

                     if ($query == true) {
                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                          echo '<script language="javascript">
                         window.location.href="./admin.php?page=pengaduan";
                          </script>';
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                }
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
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah WO</a></li>
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


                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_wo FROM tbl_wo");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('Y-m');
                    $kode_jadi = "WO/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_wo'])) {
                        $no_wo = $_SESSION['no_wo'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_wo . '</div>';
                        unset($_SESSION['no_wo']);
                    }
                    ?>
                    <label for="no_wo">No.WO</label>
                    <input type="text" class="form-control" id="no_wo" name="no_wo"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_wo" name="no_wo"  value="<?php echo $kode_jadi ?>" >
                </div>
                 <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">accessibility_new</i><label>Divisi</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="divisi" id="divisi">
                            <option value="-- Pilih Divisi --">-- Pilih Divisi --</option>
                            <option value="Teknik">Teknik</option>
                            <option value="Facility">Facility</option>
                        </select>
                    </div>
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
