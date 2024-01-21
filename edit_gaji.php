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

            $id_gaji = $_POST['id_gaji'];
            $nama = $_POST['nama'];
            $file = $_POST['file'];
            $id_user = $_SESSION['id_user'];


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/gaji/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 2300000) {

                        $id_gaji = $_REQUEST['id_gaji'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_gaji WHERE id_gaji='$id_gaji'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            $user_query = mysqli_query($config, "SELECT nama FROM tbl_user WHERE id_user = '$id_user'");
                            $nama = $nama;

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_gaji SET nama='$nama',file='$nfile',id_user='$id_user' WHERE id_gaji='$id_gaji'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=gaji");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_gaji SET nama='$nama',file='$nfile',id_user='$id_user' WHERE id_gaji='$id_gaji'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=gaji");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
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
                $id_gaji = $_REQUEST['id_gaji'];

                $query = mysqli_query($config, "UPDATE tbl_gaji SET nama='$nama',id_user='$id_user' WHERE id_gaji='$id_gaji'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=gaji");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    } else {

        $id_gaji = mysqli_real_escape_string($config, $_REQUEST['id_gaji']);
        $query = mysqli_query($config, "SELECT id_gaji, nama, file, id_user FROM tbl_gaji WHERE id_gaji='$id_gaji'");
        list($id_gaji, $nama, $file, $id_user) = mysqli_fetch_array($query);

        if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] == 1) {
            echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href="./admin.php?page=gaji";
</script>';
        } else {
?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Data</a></li>
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
                <form class="col s12" method="POST" action="?page=gaji&act=edit" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">assignment</i><label>Nama Karyawan</label><br />
                            <input type="hidden" name="id_gaji" value="<?php echo $id_gaji; ?>">
                            <div class="input-field col s11 right">
                                <select class="browser-default validate theSelect" name="nama" id="nama">
                                    <?php
                                    // Mengambil nilai nama dari database untuk data yang akan diedit
                                    $sql = "SELECT nama FROM tbl_gaji WHERE id_gaji = '$id_gaji'";
                                    $hasil = mysqli_query($config, $sql);
                                    $data = mysqli_fetch_assoc($hasil);
                                    $nama_db = $data['nama'];

                                    // Menampilkan semua nama karyawan
                                    $sql = "SELECT * FROM tbl_user ORDER BY id_user ASC ";
                                    $hasil = mysqli_query($config, $sql);

                                    while ($data = mysqli_fetch_array($hasil)) {
                                        $selected = ($data['nama'] == $nama_db) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo addslashes($data['nama']); ?>" <?php echo $selected; ?>>
                                            <?php echo addslashes($data['nama']); ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <br>
                            </div>
                        </div>

                        <div class="input-field col s10">
                            <div class="file-field input-field">
                                <div class="btn small light-green darken-1">
                                    <span>Foto</span>
                                    <input type="file" id="file" name="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload file" value="<?php echo $file; ?>">
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
                            <a href="?page=gaji" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->
                <script>
                            $(".theSelect").select2();

        </script>
        <script>
            function myalert() {
                alert("Apa anda yakin ingin menghapus?");
            }
        </script> 
            </div>
            <!-- Row form END -->

<?php
        }
    }
}
?>