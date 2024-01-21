<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_POST['submit'])) {
        // print_r($_POST);die;
        //validasi form kosong
        if ($_POST['jumlah_realisasi'] == "" || $_POST['satuan_realisasi'] == "" || $_POST['harga'] == "" || $_POST['jumlah_harga'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $jumlah_realisasi = $_POST['jumlah_realisasi'];
            $satuan_realisasi = $_POST['satuan_realisasi'];
            $harga = $_POST['harga'];
            $jumlah_harga = $_POST['jumlah_harga'];
            $id_pp = $_POST['id_pp'];
            $id_barang_detail = $_GET['id_barang'];
            $id_user = $_SESSION['id_user'];



            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $jumlah_realisasi)) {
                $_SESSION['jumlah_realisasi'] = 'Form No LPT hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $satuan_realisasi)) {
                    $_SESSION['satuan_realisasi'] = 'No.Form hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {


                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $harga)) {
                        $_SESSION['harga'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $jumlah_harga)) {
                            $_SESSION['jumlah_harga'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf dan minus(-)<br/>';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            $query = mysqli_query($config, "INSERT INTO tbl_pembelian_realisasi(jumlah_realisasi,satuan_realisasi,harga,jumlah_harga,id_barang,id_pp,id_user)
                                                                            VALUES('$jumlah_realisasi','$satuan_realisasi','$harga','$jumlah_harga','$id_barang_detail','$id_pp','$id_user')");

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


                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
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
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Realisasi</a></li>

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

        <div class="row jarak-form">
            <div class="col m12" id="colres">
                <table class="bordered" id="tbl">
                    <thead class="blue lighten-4" id="head">
                        <tr>
                            <th width="6%">No</th>
                            <th width="20%">Nama Barang<br/><hr/>No.PP</th>
                    <th width="5%">Jumlah<br/><hr/>Satuan</th>
                    <th width="20%">Keterangan<br/><hr/>Tujuan</th>

                    </tr>
                    </thead>
                    <tbody>

                        <?php
                        $id_barang = mysqli_real_escape_string($config, $_REQUEST['id_barang']);

                       $query2 = mysqli_query($config, "SELECT *, tbl_pp_barang.id_barang as id_barang_detail FROM tbl_pp_barang
                                                                  LEFT JOIN tbl_pp ON tbl_pp_barang.id_pp = tbl_pp.id_pp 
                                                                  WHERE tbl_pp_barang.id_barang='$id_barang'");


                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords(strtolower($row['nama_barang'])) ?><br/><hr/><strong><?= $row['no_pp'] ?></strong></td>
                                    <td><?= $row['jumlah'] ?><br/><hr/><?= $row['satuan'] ?></td>
                                    <td><strong><?= $row['keterangan_pp'] ?></strong><br/><hr/><?= $row['tujuan_pp'] ?></td>

                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan.</p></center></td></tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>


            </div>
        </div>

        <script>
            function sum() {
            var a = document.getElementById('jumlah_realisasi').value;
            var b = document.getElementById('harga').value;

            var result = parseInt(a) * parseInt(b);
            if (!isNaN(result)) {
            document.getElementById('jumlah_harga').value = result;
            }
            }
        </script>

        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="post" action="">

                <!-- Row in form START -->
                <div class="row">
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">playlist_add</i>
                    <?php
                    $id_pp = $_GET['id_pp'];
                    ?>
                    <input type="hidden" id="id_pp" name="id_pp" value="<?= $id_pp ?>"/>
                    <input id="jumlah_realisasi" type="number" class="validate" name="jumlah_realisasi" onkeyup="sum();" />
                    <?php
                    if (isset($_SESSION['jumlah_realisasi'])) {
                        $jumlah_realisasi = $_SESSION['jumlah_realisasi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah_realisasi . '</div>';
                        unset($_SESSION['jumlah_realisasi']);
                    }
                    ?>
                    <label for="jumlah_realisasi">Jumlah Realisasi</label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">bookmark</i><label>Satuan</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="satuan_realisasi" id="satuan_realisasi">
                            <?php
                            //Membuat koneksi ke database 
                            //Perintah sql untuk menampilkan semua data 
                            $sql = "select * from master_satuan";

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
                    <i class="material-icons prefix md-prefix">attach_money</i>
                    <input id="harga" type="number" class="validate" name="harga" onkeyup="sum();" />
                    <?php
                    if (isset($_SESSION['harga'])) {
                        $harga = $_SESSION['harga'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $harga . '</div>';
                        unset($_SESSION['harga']);
                    }
                    ?>
                    <label for="harga">Harga </label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">done</i><label><strong><font color="green">TOTAL</font></strong></label><br/>
                    <div class="input-field col s11 right">
                        <input id="jumlah_harga" type="number" class="validate" name="jumlah_harga" onchange="sum();"/>
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
