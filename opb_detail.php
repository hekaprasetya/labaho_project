<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_POST['submit'])) {
        //print_r($_POST);die;
        $id_opb = $_POST['id_opb'];
        $query = mysqli_query($config, "SELECT * FROM tbl_opb WHERE id_opb='$id_opb'");
        $no = 1;
        list($id_opb) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_POST['nama_opb'] == "" || $_POST['nama_barang'] == "" || $_POST['jumlah'] == "" || $_POST['keperluan'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_opb = $_POST['nama_opb'];
            $nama_barang = $_POST['nama_barang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            $keperluan = $_POST['keperluan'];
            $id_opb = $_GET['id_opb'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $nama_opb)) {
                $_SESSION['nama_opb'] = 'Form No LPT hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $nama_barang)) {
                    $_SESSION['nama_barang'] = 'Form No LPT hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $jumlah)) {
                        $_SESSION['jumlah'] = 'No.Form hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {


                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $satuan)) {
                            $_SESSION['satuan'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $keperluan)) {
                                $_SESSION['keperluan'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf dan minus(-)<br/>';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {



                                $query = mysqli_query($config, "INSERT INTO tbl_opb_detail(nama_opb,nama_barang,jumlah,satuan,keperluan,id_opb)
                                                                            VALUES('$nama_opb','$nama_barang','$jumlah','$satuan','$keperluan','$id_opb')");

                                if ($query == true) {
                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                    echo '<script language="javascript">
                                        window.history.go(-2);
                                                 </script>';

                                    die();
                                } else {
                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                    echo '<script language="javascript">window.history.back();</script>';
                                }
                            }
                        }
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
                    <div class="nav-wrapper blue darken-2">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Detail Barang</a></li>
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
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">people</i>
                    <input id="nama_opb" type="text" class="validate" name="nama_opb" required>
                    <?php
                    if (isset($_SESSION['nama_opb'])) {
                        $nama_opb = $_SESSION['nama_opb'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_opb  . '</div>';
                        unset($_SESSION['nama_opb']);
                    }
                    ?>
                    <label for="tujuan_pp">Nama Peminta</label>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">local_mall</i>
                    <input id="nama_barang" type="text" class="validate" name="nama_barang" required>
                    <?php
                    if (isset($_SESSION['nama_barang'])) {
                        $nama_barang = $_SESSION['nama_barang'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_barang . '</div>';
                        unset($_SESSION['nama_barang']);
                    }
                    ?>
                    <label for="nama_barang">Nama Barang</label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">playlist_add</i>
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

                <div class="input-field col s9">
                    <i class="material-icons prefix md-prefix">bookmark</i><label>Satuan</label><br />
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="satuan" id="satuan">
                            <?php
                            //Membuat koneksi ke database akademik
                            //Perintah sql untuk menampilkan semua data pada tabel jurusan
                            $sql = "select * from master_satuan ORDER by satuan ASC";

                            $hasil = mysqli_query($config, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                                $no++;
                            ?>
                                <option value="<?php echo $data['satuan']; ?>"><?php echo $data['satuan']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">local_mall</i>
                    <input id="keperluan" type="text" class="validate" name="keperluan" required>
                    <?php
                    if (isset($_SESSION['keperluan'])) {
                        $keperluan = $_SESSION['keperluan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keperluan . '</div>';
                        unset($_SESSION['keperluan']);
                    }
                    ?>
                    <label for="keperluan">Keperluan</label>
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