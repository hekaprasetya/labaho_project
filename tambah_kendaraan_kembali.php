<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        // Validasi form kosong
        // Mendapatkan data dari formulir
        $id_pinjam_kendaraan = $_GET['id_pinjam_kendaraan']; // Mengambil ID dari URL
        $bb_akhir = $_REQUEST['bb_akhir'];
        $km_akhir = $_REQUEST['km_akhir'];
        $id_user = $_SESSION['id_user'];

        $existing_record_query = mysqli_query($config, "SELECT * FROM pinjam_kendaraan WHERE id_pinjam_kendaraan='$id_pinjam_kendaraan'");
        $existing_record = mysqli_fetch_assoc($existing_record_query);
        $id_pinjam_kendaraan = $existing_record['id_pinjam_kendaraan'];


        // Pengaturan direktori untuk menyimpan file
        $target_dir = "upload/kendaraan/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Mengecek apakah ada file yang diunggah
        if (!empty($_FILES['file_akhir']['name'])) {
            $file_akhir = $_FILES['file_akhir']['name'];
            $x = explode('.', $file_akhir);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file_akhir']['size'];

            // Ekstensi file yang diperbolehkan
            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');

            // Menghasilkan nama file acak
            $rand = rand(1, 10000);
            $nfile = $rand . "-" . $file_akhir;

            // Validasi ekstensi file
            if (in_array($eks, $ekstensi) == true) {
                if ($ukuran < 2500000) { // Ukuran maksimum file (dalam byte)
                    $query_get_id = mysqli_query($config, "SELECT id_kendaraan_kembali FROM kendaraan_kembali WHERE id_pinjam_kendaraan='$id_pinjam_kendaraan'");
                    $data_id = mysqli_fetch_assoc($query_get_id);
                    $id_kendaraan_kembali = $data_id['id_kendaraan_kembali'];
                    if ($data_id == 0) {
                        move_uploaded_file($_FILES['file_akhir']['tmp_name'], $target_dir . $nfile);
                        $query = mysqli_query($config, "INSERT INTO kendaraan_kembali(bb_akhir, km_akhir, file_akhir, id_pinjam_kendaraan, id_user)
                                                    VALUES('$bb_akhir', '$km_akhir', '$nfile', '$id_pinjam_kendaraan', '$id_user')");
                    } else {
                        $query = mysqli_query($config, "UPDATE kendaraan_kembali SET
             bb_akhir='$bb_akhir',
             km_akhir='$km_akhir',
             file_akhir='$file_akhir', 
             id_pinjam_kendaraan='$id_pinjam_kendaraan', id_user='$id_user' WHERE id_kendaraan_kembali='$id_kendaraan_kembali'");
                    }

                    if ($query == true) {
                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                        header("Location: ./admin.php?page=pinjam_kendaraan");
                        die();
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                } else {
                    $_SESSION['errSize'] = 'Ukuran file yang diunggah terlalu besar!';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            } else {
                $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                echo '<script language="javascript">window.history.back();</script>';
            }
        } else {
            // Jika tidak ada file yang diunggah
            $query = mysqli_query($config, "UPDATE kendaraan_kembali SET
             bb_akhir='$bb_akhir',
             km_akhir='$km_akhir',
             file_akhir='$nfile', 
             id_pinjam_kendaraan='$id_pinjam_kendaraan', id_user='$id_user' WHERE id_kendaraan_kembali='$id_kendaraan_kembali'");

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
    ?>
    <div class="row jarak-form">

        <!-- Form START -->
        <form class="col s12" method="POST" action="" enctype="multipart/form-data">
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="?page=pinjam_kendaraan&act=add_kembali" class="judul"><i class="material-icons">directions_car</i> Kendaraan Kembali</a></li>
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

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">directions_car</i>
                <input id="km_akhir" class="validate" type="number" name="km_akhir" required>
                <?php
                if (isset($_SESSION['km_akhir'])) {
                    $km_akhir = $_SESSION['km_akhir'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $km_akhir . '</div>';
                    unset($_SESSION['km_akhir']);
                }
                ?>
                <label for="km_akhir">KM Kembali</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">local_gas_station</i>
                <label for="bb_akhir">Kadar BBM Kembali</label>
                <br>
                <div class="input-field col s11 right">
                    <select id="bb_akhir" class="browser-default validate theSelect" name="bb_akhir">
                        <option value="" disabled selected>Pilih Kadar BBM Kembali</option>
                        <option value="Full">Full</option>
                        <option value="1/2">Setengah</option>
                        <option value="1/3">Kurang Dari setengah</option>
                        <option value="1/4">Hampir Habis</option>
                        <option value="0">Habis</option>
                    </select>
                </div>
                <?php
                if (isset($_SESSION['bb_akhir'])) {
                    $bb_akhir = $_SESSION['bb_akhir'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $bb_akhir . '</div>';
                    unset($_SESSION['bb_akhir']);
                }
                ?>
            </div>


            <div class="input-field col s9">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1">
                        <span>File</span>
                        <input type="file" id="file_akhir" name="file_akhir">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload foto KM Kembali">
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

            <br>



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

    <?php
}
?>