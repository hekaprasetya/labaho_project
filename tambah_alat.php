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
            
            $no_alat      = $_REQUEST['no_alat'];
            $nama_alat    = $_REQUEST['nama_alat'];
            $jumlah       = $_REQUEST['jumlah'];
            $kondisi      = $_REQUEST['kondisi'];
            $id_user      = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/master_alat/";

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

                        $query = mysqli_query($config, "INSERT INTO tbl_alat(no_alat,nama_alat,jumlah,kondisi,file,id_user)
                                                                        VALUES('$no_alat','$nama_alat','$jumlah','$kondisi','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=master_alat");
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
                        $query = mysqli_query($config, "INSERT INTO tbl_alat(no_alat,nama_alat,jumlah,kondisi,file,id_user)
                                                                        VALUES('$no_alat','$nama_alat','$jumlah','$kondisi','$nfile','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=master_alat");
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
                <div class="nav-wrapper blue-grey darken-1">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="?page=master_alat&act=add" class="judul"><i class="material-icons">build</i> Tambah Data Alat</a></li>
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
        <form class="col s12" method="POST" action="?page=master_alat&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">looks_one</i>
            <?php
            //memulai mengambil datanya
            $sql = mysqli_query($config, "SELECT no_alat FROM tbl_alat");


            $result = mysqli_num_rows($sql);

            if ($result <> 0) {
                $kode = $result + 1;
            } else {
                $kode = 1;
            }

            //mulai bikin kode
            $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
            $tahun = date('Y-m');
            $kode_jadi = "GD/$tahun/$bikin_kode";

            if (isset($_SESSION['no_alat'])) {
                $no_alat = $_SESSION['no_alat'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_alat . '</div>';
                unset($_SESSION['no_alat']);
            }
            ?>
            <label for="no_alat">No.Alat</label>
            <input type="text" class="form-control" id="no_alat" name="no_alat"  value="<?php echo $kode_jadi ?>"disabled>
            <input type="hidden" class="form-control" id="no_alat" name="no_alat"  value="<?php echo $kode_jadi ?>" >
        </div>
            
            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">bookmark</i>
                <input id="nama_alat" type="text" class="validate" name="nama_alat" required>
                <?php
                if (isset($_SESSION['nama_alat'])) {
                    $nama_alat = $_SESSION['nama_alat'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_alat . '</div>';
                    unset($_SESSION['nama_alat']);
                }
                ?>
                <label for="nama_alat">Nama Alat</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">label</i>
                <input id="jumlah" type="number" class="validate" name="jumlah" required>
                <?php
                if (isset($_SESSION['jumlah'])) {
                    $jumlah = $_SESSION['jumlah'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah . '</div>';
                    unset($_SESSION['jumlah']);
                }
                ?>
                <label for="jumlah">Jumlah</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">class</i>
                <input id="kondisi" type="text" class="validate" name="kondisi" required>
                <?php
                if (isset($_SESSION['kondisi'])) {
                    $kondisi = $_SESSION['kondisi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kondisi . '</div>';
                    unset($_SESSION['kondisi']);
                }
                ?>
                <label for="kondisi">Kondisi</label>
            </div>

            <div class="input-field col s6">
                <div class="file-field input-field">
                    <div class="btn light-green darken-1">
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
            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 6">
            <a href="?page=master_alat" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
