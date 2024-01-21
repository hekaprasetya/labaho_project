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

    if (isset($_POST['submit'])) {
        //print_r($_POST);die;
        $id_pp = $_POST['id_pp'];
        $query = mysqli_query($config, "SELECT * FROM tbl_pp WHERE id_pp='$id_pp'");
        $no = 1;
        list($id_pp) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_POST['nama_barang'] == "" || $_POST['jumlah'] == "" || $_POST['satuan'] == "" || $_POST['keterangan_pp'] == "" || $_POST['tujuan_pp'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_barang = $_POST['nama_barang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            $keterangan_pp = $_POST['keterangan_pp'];
            $tujuan_pp = $_POST['tujuan_pp'];
            $id_pp = $_GET['id_pp'];

            //validasi input data
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

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $keterangan_pp)) {
                            $_SESSION['keterangan_pp'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf dan minus(-)<br/>';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $tujuan_pp)) {
                                $_SESSION['tujuan_pp'] = 'Form catatan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-) garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                $query = mysqli_query($config, "INSERT INTO tbl_pp_barang(nama_barang,jumlah,satuan,keterangan_pp,tujuan_pp,id_pp)
                                                                            VALUES('$nama_barang','$jumlah','$satuan','$keterangan_pp','$tujuan_pp','$id_pp')");

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
                    <div class="nav-wrapper blue-grey darken-1">
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
                                            <input type="hidden" id="id_barang_gudang" name="id_barang_gudang" value="<? $_row['id_barang_gudang'] ?>" />
                                            <i class="material-icons prefix md-prefix">local_mall</i><label>Nama Barang</label><br/>
                                            <div class="input-field col s11 right">
                                                <select  name="nama_barang" class="browser-default validate theSelect"  id="nama_barang">
                                                    <?php
                                                    //Membuat koneksi ke database akademik
                                                    //Perintah sql untuk menampilkan semua data pada tabel master barang
                                                    $sql = "select * from master_barang ORDER by nama_barang ASC";

                                                    $hasil = mysqli_query($config, $sql);
                                                    $no = 0;
                                                    while ($data = mysqli_fetch_array($hasil)) {
                                                        $no++;
                                                        ?>
                                                        <option value="<?php echo $data['nama_barang']; ?>"><?php echo $data['nama_barang']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
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

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">library_books</i><label>Satuan</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="satuan" id="satuan">
                            <option value="unit">unit</option>
                            <option value="buah">buah</option>
                            <option value="pasang">pasang</option>
                            <option value="lembar">lembar</option>
                            <option value="keping">keping</option>
                            <option value="batang">batang</option>
                            <option value="bungkus">bungkus</option>
                            <option value="potong">potong</option>
                            <option value="tablet">tablet</option>
                            <option value="galon">galon</option>
                            <option value="roll">roll</option>
                            <option value="rim">rim</option>
                            <option value="dos">dos</option>
                            <option value="set">set</option>
                            <option value="pack">pack</option>
                            <option value="pail">pail</option>
                            <option value="meter">meter</option>
                            <option value="kg">kg</option>
                            <option value="liter">liter</option>
                            <option value="karung">karung</option>
                        </select>
                    </div>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">library_add</i><label>Keterangan</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="keterangan_pp" id="keterangan_pp">
                            <option value="Sparepart">Sparepart</option>
                            <option value="Building Improvement">Building Improvement</option>
                            <option value="Project">Project</option>
                            <option value="Stock">Stock</option>
                            <option value="Atk">Atk</option>
                        </select>
                    </div>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="tujuan_pp" type="text" class="validate" name="tujuan_pp" required>
                    <?php
                    if (isset($_SESSION['tujuan_pp'])) {
                        $tujuan_pp = $_SESSION['tujuan_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tujuan_pp . '</div>';
                        unset($_SESSION['tujuan_pp']);
                    }
                    ?>
                    <label for="tujuan_pp">Tujuan PP</label>
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
         <script>
            $(".theSelect").select2();

        </script>

        </div>
        <!-- Row form END -->

        <?php
    }
}
?>
