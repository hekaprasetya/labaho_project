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

            $id_barang_gudang = $_REQUEST['id_barang_gudang'];
            $no_barang = $_REQUEST['no_barang'];
            $nama_barang = $_REQUEST['nama_barang'];
            $satuan_barang = $_REQUEST['satuan_barang'];
            $harga_barang = $_REQUEST['harga_barang'];

            //validasi input data


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/master_barang/";

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

                        $id_barang_gudang = $_REQUEST['id_barang_gudang'];
                        $query = mysqli_query($config, "SELECT file FROM master_barang WHERE id_barang_gudang='$id_barang_gudang'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE master_barang SET no_barang='$no_barang',nama_barang='$nama_barang',satuan_barang='$satuan_barang',harga_barang='$harga_barang',file='$nfile' WHERE id_barang_gudang='$id_barang_gudang'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=master_barang");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE master_barang SET no_barang='$no_barang',nama_barang='$nama_barang',satuan_barang='$satuan_barang',harga_barang='$harga_barang',file='$nfile' WHERE id_barang_gudang='$id_barang_gudang'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=master_barang");
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
                $id_barang_gudang = $_REQUEST['id_barang_gudang'];

                $query = mysqli_query($config, "UPDATE master_barang SET no_barang='$no_barang',nama_barang='$nama_barang',satuan_barang='$satuan_barang',harga_barang='$harga_barang' WHERE id_barang_gudang='$id_barang_gudang'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=master_barang");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
}

$id_barang_gudang = mysqli_real_escape_string($config, $_REQUEST['id_barang_gudang']);
$query = mysqli_query($config, "SELECT id_barang_gudang, no_barang, nama_barang, satuan_barang, harga_barang, file FROM master_barang WHERE id_barang_gudang='$id_barang_gudang'");
list( $id_barang_gudang, $no_barang, $nama_barang, $satuan_barang, $harga_barang, $file) = mysqli_fetch_array($query);
{
    ?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue-grey darken-1">
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
        <form class="col s12" method="POST" action="?page=master_barang&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s6">
                    <input type="hidden" name="id_barang_gudang" value="<?php echo $id_barang_gudang ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_barang" type="text" class="validate" value="<?php echo $no_barang; ?>" name="no_barang">
                    <?php
                    if (isset($_SESSION['eno_barang'])) {
                        $eno_barang = $_SESSION['eno_alat'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_barang . '</div>';
                        unset($_SESSION['eno_barang']);
                    }
                    ?>
                    <label for="eno_barang">No.Barang</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">archive</i>
                    <input id="nama_barang" type="text" class="validate" name="nama_barang" value="<?php echo $nama_barang; ?>">
                    <?php
                    if (isset($_SESSION['enama_barang'])) {
                        $enama_barang = $_SESSION['enama_barang'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_barang . '</div>';
                        unset($_SESSION['enama_barang']);
                    }
                    ?>
                    <label for="enama_barang">Nama Barang</label>
                </div>          

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">bookmark</i>
                    <input id="satuan_barang" type="text" class="validate" name="satuan_barang" value="<?php echo $satuan_barang; ?>">
                    <?php
                    if (isset($_SESSION['esatuan_barang'])) {
                        $esatuan_barang = $_SESSION['esatuan_barang'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $esatuan_barang . '</div>';
                        unset($_SESSION['esatuan_barang']);
                    }
                    ?>
                    <label for="esatuan_barang">Satuan Barang</label>
                </div>
                
                 <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">attach_money</i>
                    <input id="harga_barang" type="number" class="validate" name="harga_barang" value="<?php echo $harga_barang; ?>">
                    <?php
                    if (isset($_SESSION['eharga_barang'])) {
                        $eharga_barang = $_SESSION['eharga_barang'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eharga_barang . '</div>';
                        unset($_SESSION['eharga_barang']);
                    }
                    ?>
                    <label for="eharga_barang">Harga Barang</label>
                </div>  

                <div class="input-field col s6">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>File</span>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar alat">
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
                    <a href="?page=master_barang" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                </div>
            </div>

        </form>
        <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
