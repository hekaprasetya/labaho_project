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
            $nama_kendaraan = $_REQUEST['nama_kendaraan'];
            $jabatan_kendaraan = $_REQUEST['jabatan_kendaraan'];
            $tujuan = $_REQUEST['tujuan'];
            $km_awal = $_REQUEST['km_awal'];
            $bb_awal = $_REQUEST['bb_awal'];
            $kendaraan = $_REQUEST['kendaraan'];
            $id_pinjam_kendaraan = $_SESSION['id_pinjam_kendaraan'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/kendaraan/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 2500000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO pinjam_kendaraan(no_form,nama_kendaraan,jabatan_kendaraan,tujuan,km_awal,bb_awal,kendaraan,file,id_user)
                                                                        VALUES('$no_form','$nama_kendaraan','$jabatan_kendaraan','$tujuan','$km_awal','$bb_awal','$kendaraan','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=pinjam_kendaraan");
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
                $query = mysqli_query($config, "INSERT INTO pinjam_kendaraan(no_form,nama_kendaraan,jabatan_kendaraan,tujuan,km_awal,bb_awal,kendaraan,file,id_user)
                VALUES('$no_form','$nama_kendaraan','$jabatan_kendaraan','$tujuan','$km_awal','$bb_awal','$kendaraan','$file','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=pinjam_kendaraan");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
    ?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="?page=pinjam_kendaraan&act=add" class="judul"><i class="material-icons">directions_car</i> Pinjam Kendaraan</a></li>
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
        <form class="col s12" method="POST" action="?page=pinjam_kendaraan&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="input-field col s11">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <?php
                //memulai mengambil datanya
                $sql = mysqli_query($config, "SELECT no_form FROM pinjam_kendaraan");

                $result = mysqli_num_rows($sql);

                if ($result <> 0) {
                    $kode = $result + 1;
                } else {
                    $kode = 1;
                }

                //mulai bikin kode
                $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                // $tahun = date('Y-m');
                $kode_jadi = "FM/SEC/012/$bikin_kode";

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

            <div class="input-field col s11">
                <i class="material-icons prefix md-prefix">people</i>
                <input id="nama_kendaraan" type="text" class="validate" name="nama_kendaraan" required>
                <?php
                if (isset($_SESSION['nama_kendaraan'])) {
                    $nama_kendaraan = $_SESSION['nama_kendaraan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_kendaraan . '</div>';
                    unset($_SESSION['nama_kendaraan']);
                }
                ?>
                <label for="nama_kendaraan">Nama Peminjam</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">assignment</i><label for="jabatan_kendaraan">Jabatan</label><br />
                <div class="input-field col s9">
                    <select name="jabatan_kendaraan" class="browser-default validate theSelect" id="jabatan_kendaraan">
                        <?php
                        //Membuat koneksi ke database 
                        //Perintah sql untuk menampilkan semua data pada tabel
                        $sql = "SELECT * FROM master_jabatan
                                                                                             
                          ORDER BY id_jabatan ASC ";

                        $hasil = mysqli_query($config, $sql);

                        while ($data = mysqli_fetch_array($hasil)) {
                            ?>
                            <option value="<?php
                            echo addslashes($data['jabatan']);
                            ?>"><?php
                                        echo addslashes($data['jabatan']);
                                        ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="input-field col s11">
                <i class="material-icons prefix md-prefix">assignment_turned_in</i>
                <input id="tujuan" type="text" class="validate" name="tujuan" required>
                <?php
                if (isset($_SESSION['tujuan'])) {
                    $tujuan = $_SESSION['tujuan'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tujuan . '</div>';
                    unset($_SESSION['tujuan']);
                }
                ?>
                <label for="tujuan">Tujuan Peminjaman</label>
            </div>

            <!--div class="input-field col s11">
                <i class="material-icons prefix md-prefix">directions_car</i>
                <input id="km_awal" class="validate" type="number" name="km_awal" required>
                <?php
                if (isset($_SESSION['km_awal'])) {
                    $km_awal = $_SESSION['km_awal'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $km_awal . '</div>';
                    unset($_SESSION['km_awal']);
                }
                ?>
                <label for="km_awal">KM Awal</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">local_gas_station</i>
                <label for="bb_awal">Kadar BBM Awal</label>
                <br>
                <div class="input-field col s9">
                    <select id="bb_awal" class="browser-default validate theSelect" name="bb_awal">
                        <option value="" disabled selected>Pilih Kadar BBM Awal</option>
                        <option value="Full">Full</option>
                        <option value="1/2">Setengah</option>
                        <option value="1/3">Kurang Dari setengah</option>
                        <option value="1/4">Hampir Habis</option>
                        <option value="0">Habis</option>
                    </select>
                </div>
                <?php
                if (isset($_SESSION['bb_awal'])) {
                    $bb_awal = $_SESSION['bb_awal'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $bb_awal . '</div>';
                    unset($_SESSION['bb_awal']);
                }
                ?>
            </div-->

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">directions_car</i><label>Nama Kendaraan</label><br/>
                <div class="input-field col s9">
                    <select  name="kendaraan" class="browser-default validate theSelect"  id="kendaraan">
                        <?php
                        //Membuat koneksi ke database akademik
                        //Perintah sql untuk menampilkan semua data pada tabel master barang
                        $sql = "SELECT * FROM master_kendaraan
                                   ORDER BY id_kendaraan ASC";

                        $hasil = mysqli_query($config, $sql);
                        $no = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                            $no++;
                            ?>
                            <option value="<?php echo $data['kendaraan']; ?>"><?php echo $data['kendaraan']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div> 

            <div class="input-field col s11">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1">
                        <span>Foto</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload file">
                        <?php
                        if (isset($_SESSION['errSize'])) {
                            $errSize = $_SESSION['errSize'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errSize . '</div>';
                            unset($_SESSION['errSize']);
                        }
                        if (isset($_SESSION['errFormat'])) {
                            $errFormat = $_SESSION['errFormat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errFormat . '</div>';
                            unset($_SESSION['errFormat']);
                        }
                        ?>
                        <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                    </div>
                </div>
            </div>


    </div>
    <!-- Row in form END -->

    <div class="row">
        <div class="col 6">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 6">
            <a href="?page=pinjam_kendaraan" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->
    <script>
        $(".theSelect").select2();

    </script>
    <?php
}
?>
