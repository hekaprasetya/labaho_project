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
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_barang = $_POST['nama_barang'];
            $jumlah_op = $_POST['jumlah_op'];
            $satuan = $_POST['satuan'];
            $harga_op = $_POST['harga_op'];
            $keterangan_op_detail = $_POST['keterangan_op_detail'];
            $total_op = $_POST['total_op'];
            $total_ppn = $_POST['total_ppn'];
            //  $nama_supplier = $_POST['nama_supplier'];
            $id_op = $_GET['id_op'];

            $query = mysqli_query($config, "INSERT INTO tbl_op_detail(nama_barang,jumlah_op,satuan,harga_op,keterangan_op_detail,total_op,total_ppn,id_op)
                                                                        VALUES('$nama_barang','$jumlah_op','$satuan','$harga_op','$keterangan_op_detail','$total_op','$total_ppn','$id_op')");



            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
              window.history.go(-2);
                       </script>';

                die();
            } else {
                $_SESSION['errQ'] = ' ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
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

                <div class="input-field col s11">
                    <i class="material-icons prefix md-prefix">assignment</i><label>Nama Barang</label><br/>
                    <div class="input-field col s11">
                        <select  name="nama_barang" class="browser-default validate theSelect"  id="nama_barang">
                            <?php
                            //Membuat koneksi ke database 
                            //Perintah sql untuk menampilkan semua data pada tabel
                            $sql = "SELECT * FROM tbl_pp_barang
                                                                                             LEFT JOIN tbl_pp
                                                                                             ON tbl_pp_barang.id_pp=tbl_pp.id_pp
                                                                                             LEFT JOIN tbl_gm_pp
                                                                                             ON tbl_pp_barang.id_barang=tbl_gm_pp.id_barang
                                                                                             LEFT JOIN tbl_pembelian
                                                                                             ON tbl_pp_barang.id_pp=tbl_pembelian.id_pp
                                                                                             LEFT JOIN tbl_pp_gudang
                                                                                             ON tbl_pp_barang.id_barang=tbl_pp_gudang.id_barang
                                                                                             LEFT JOIN tbl_pembelian_realisasi
                                                                                             ON tbl_pp_barang.id_barang=tbl_pembelian_realisasi.id_barang
                                                                                             
                                                                    ORDER BY no_pp ASC ";

                            $hasil = mysqli_query($config, $sql);

                            while ($data = mysqli_fetch_array($hasil)) {
                                ?>
                                <option
                                    value="<?php
                                    echo $data['no_pp'];
                                    echo " / ";
                                    echo $data['status_gm'], $data['jumlah_gm'];
                                    echo " / ";
                                    echo addslashes($data ['nama_barang']);
                                    ?>"><?php
                                        echo $data['no_pp'];
                                        echo " / ";
                                        echo $data['status_gm'], $data['jumlah_gm'];
                                        echo " / ";
                                        echo addslashes($data ['nama_barang']);
                                        ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">playlist_add</i>
                    <input type="text" id="jumlah_op" name="jumlah_op"  onkeyup="sum();" />
                    <?php
                    if (isset($_SESSION['jumlah_op'])) {
                        $jumlah_op = $_SESSION['jumlah'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah_op . '</div>';
                        unset($_SESSION['jumlah_op']);
                    }
                    ?>
                    <label for="jumlah_op">Jumlah</label>
                </div>

                <div class="input-field col s10">
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

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">attach_money</i>
                    <input type="text" id="harga_op" name="harga_op" onkeyup="sum();" />
                    <?php
                    if (isset($_SESSION['harga_op'])) {
                        $harga_op = $_SESSION['harga_op'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $harga_op . '</div>';
                        unset($_SESSION['harga_op']);
                    }
                    ?>
                    <label for="harga_op">Harga</label>
                </div>

                <div class="input-field col s10">
                    <label for="total_op"><strong>Total</strong></label>
                    <i class="material-icons prefix md-prefix"></i>
                    <input id="total_op" type="number" class="validate" name="total_op" onchange="sum2();" />
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">attach_money </i><label>PPN</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" input type="hidden" name="nama_pajak" id="nama_pajak" onchange="sum2();" />
                        <?php
                        //Membuat koneksi ke database 
                        //Perintah sql untuk menampilkan semua data pada tabel
                        $sql = "select * from master_pajak ";

                        $hasil = mysqli_query($config, $sql);
                        $no = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                            $no++;
                            ?>
                            <option
                                value="<?php echo $data['nama_pajak']; ?>"><?php echo $data['nama_pajak'] ?>
                            </option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>    

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">done</i><label>Total+PPN</label><br/>
                    <div class="input-field col s11 right">
                        <input id="total_ppn" type="number" class="validate" name="total_ppn" onchange="sum2();">
                    </div>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">get_app</i>
                    <input type="text" id="keterangan_op_detail" name="keterangan_op_detail" />
                    <?php
                    if (isset($_SESSION['keterangan_op_detail'])) {
                        $keterangan_op_detail = $_SESSION['keterangan_op_detail'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan_op_detail . '</div>';
                        unset($_SESSION['keterangan_op_detail']);
                    }
                    ?>
                    <label for="keterangan_op_detail">Keterangan</label>
                </div>

                <!--div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">build</i><label>Supplier</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="nama_supplier" id="nama_supplier">
                <?php
                //Membuat koneksi ke database akademik
                //Perintah sql untuk menampilkan semua data pada tabel jurusan
                $sql = "select * from master_supplier";

                $hasil = mysqli_query($config, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                    ?>
                                            <option value="<?php echo $data['nama_supplier']; ?>"><?php echo $data['nama_supplier']; ?></option>
                    <?php
                }
                ?>
                        </select>
                    </div>
                </div--> 

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
        <script>
                        function sum() {
                            var q = document.getElementById('jumlah_op').value;
                            var w = document.getElementById('harga_op').value;

                            var result = parseInt(q) * parseInt(w);
                            if (!isNaN(result)) {
                                document.getElementById('total_op').value = result;
                            }
                        }
        </script>

        <script>
            function sum2() {
                var a = document.getElementById('total_op').value;
                var b = document.getElementById('nama_pajak').value;
                var c = document.getElementById('total_op').value;
                var result = parseFloat(a) * parseInt(b) / 100;
                if (!isNaN(result)) {
                    document.getElementById('total_ppn').value = parseInt(result) + parseInt(c);
                }
            }
        </script>   

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
