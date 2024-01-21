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

            $no_op = $_POST['no_op'];
            $tgl_op = $_POST['tgl_op'];
            $tgl_brg_dtg = $_POST['tgl_brg_dtg'];
            $syarat_pembayaran = $_POST['syarat_pembayaran'];
            $keterangan_op = $_POST['keterangan_op'];
            $supplier = $_POST['supplier'];
            $id_user = $_SESSION['id_user'];


            //jika form file kosong akan mengeksekusi script dibawah ini
            $query = mysqli_query($config, "INSERT INTO tbl_op(no_op,tgl_op,tgl_brg_dtg,syarat_pembayaran,keterangan_op,supplier,id_user)
                                                                        VALUES('$no_op','$tgl_op','$tgl_brg_dtg','$syarat_pembayaran','$keterangan_op','$supplier','$id_user')");

            $id_op_add = mysqli_insert_id($config);
            @session_start();
            if (isset($_SESSION["tableDet"])) {
                $tableDet = $_SESSION["tableDet"];
                foreach ($tableDet as $i => $v) {
                    if ($tableDet[$i]["mode_item"] == "N") {
                        $nama_barang = $tableDet[$i]["nama_barang"];
                        $jumlah_op = $tableDet[$i]["jumlah_op"];
                        $satuan = $tableDet[$i]["satuan"];
                        $harga_op = $tableDet[$i]["harga_op"];
                        $keterangan_op_detail = $tableDet[$i]["keterangan_op_detail"];
                        $total_op = $tableDet[$i]["total_op"];
                        $total_ppn = $tableDet[$i]["total_ppn"];
                        //              $nama_supplier = $tableDet[$i]["nama_supplier"];
                        $id_op = $id_op_add;

                        mysqli_query($config, "INSERT INTO tbl_op_detail(nama_barang,jumlah_op,satuan,harga_op,keterangan_op_detail,total_op,total_ppn,id_op)
                                                VALUES('$nama_barang','$jumlah_op','$satuan','$harga_op','$keterangan_op_detail','$total_op','$total_ppn','$id_op')");
                    }
                }
            }

            if ($query == true) {
                if (isset($_SESSION["tableDet"])) {
                    unset($_SESSION["tableDet"]);
                }
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=op");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
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
                    <div class="nav-wrapper blue darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=op&act=add" class="judul"><i class="material-icons">local_grocery_store</i> Tambah Data OP</a></li>
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
            <form class="col s12" method="POST" action="?page=op&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>

                                <th width="2%">No</th>
                                <th width="15%">Nama Barang</th>
                                <th width="5%">Jumlah</th>
                                <th width="5%">Satuan</th>
                                <th width="10%">Harga</th>
                                <th width="10%">Total</th>
                                <th width="10%">Total + PPN</th>
                                <th width="10%">Keterangan</th>
                                <!--th width="10%">Supplier</th-->
                                <th width="10%">Tindakan</th>
                                <th width="20%"><span> <a class="btn small red modal-trigger" href="#modal2">
                                            <i class="material-icons">add_circle_outline</i>Tambah</a></span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            @session_start();
                            $no = 0;
                            if (isset($_SESSION["tableDet"])) {
                                $tableDet = $_SESSION["tableDet"];
                                foreach ($tableDet as $i => $v) {
                                    if ($tableDet [$i]["mode_item"] != "D") {
                                        $no++;
                                        echo '<tr>';
                                        echo '<td>' . $no . '</td>';
                                        echo '<td>' . $tableDet[$i]["nama_barang"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["jumlah_op"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["satuan"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["harga_op"] = "Rp " . number_format((float) $tableDet[$i]['harga_op'], 0, ',', '.') . '</td>';
                                        echo '<td>' . $tableDet[$i]["total_op"] = "Rp " . number_format((float) $tableDet[$i]['total_op'], 0, ',', '.') . '</td>';
                                        echo '<td> ';
                                        if (!empty($tableDet[$i]["total_ppn"])) {
                                            echo ' <strong>' . $tableDet[$i]["total_ppn"] = "Rp " . number_format((float) $tableDet[$i]['total_ppn'], 0, ',', '.') . '</strong>';
                                        } else {
                                            echo '<em>Tidak ada PPN</em>';
                                        } echo '</td>';
                                        echo '<td>' . $tableDet[$i]["keterangan_op_detail"] . '</td>';
                                        //echo '<td>' . $tableDet[$i]["nama_supplier"] . '</td>';
                                        echo '<td><center><a href="hapus_item_op.php?id=' . $tableDet[$i]["i"] . '" class="btn small btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center></td>';
                                        echo '</tr>';
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10" style="text-align: center"><strong><font color="red">*** JANGAN LUPA ISI DATA BARANG DI ATAS***</font></strong></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>

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

                        <div id="modal2" class="modal">
                            <div class="modal-content white">
                                <div class="row">
                                    <!-- Secondary Nav START -->
                                    <div class="col s12">
                                        <nav class="secondary-nav">
                                            <div class="nav-wrapper blue darken-1">
                                                <ul class="left">
                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">add_shopping_cart</i> Tambah Data Barang</a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                    <!-- Secondary Nav END -->
                                </div>


                                <div class="row jarak-form">
                                    <form class="container" method="post" action="">
                                        <div class="input-field col s11">
                                            <i class="material-icons prefix md-prefix">assignment</i><label>Nama Barang</label><br/>
                                            <div class="input-field col s11 right">
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

                                        <div class="input-field col s11">
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

                                        <div class="input-field col s11">
                                            <i class="material-icons prefix md-prefix">bookmark</i><label>Satuan</label><br/>
                                            <div class="input-field col s11 right">
                                                <select class="browser-default validate theSelect" name="satuan" id="satuan">
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

                                        <div class="input-field col s11">
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

                                        <div class="input-field col s11">
                                            <i class="material-icons prefix md-prefix">done</i><label><strong><font color="green">TOTAL</font></strong></label><br/>
                                            <div class="input-field col s11 right">
                                                <input id="total_op" type="number" class="validate" name="total_op" onchange="sum2();"/>
                                            </div>
                                        </div>

                                        <div class="input-field col s11">
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

                                        <div class="input-field col s11">
                                            <i class="material-icons prefix md-prefix">done</i><label><strong><font color="green">TOTAL+PPN</font></strong></label><br/>
                                            <div class="input-field col s12 right">
                                                <input id="total_ppn" type="number" class="validate" name="total_ppn" onchange= "sum2();">
                                            </div>
                                        </div>

                                        <div class="input-field col s11">
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
                                            <br>
                                            <button type="ok" name ="ok" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>

                                            <a href="?page=op&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                        </div>

                                        <!--div class="input-field col s8">
                                            <i class="material-icons prefix md-prefix">build</i><label>Supplier</label><br/>
                                            <div class="input-field col s11 right">
                                                <select class="browser-default validate" name="nama_supplier" id="nama_supplier">
                                        <?php
                                        //Membuat koneksi ke database akademik
                                        //Perintah sql untuk menampilkan semua data pada tabel jurusan
                                        $sql = "select * from master_supplier  ORDER by nama_supplier ASC";

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
                                                <br>
                                                <button type="ok" name ="ok" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>
                
                                                <a href="?page=op&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                            </div-->
                                </div>
                                </form> 
                            </div> 




                            <!-- Footer -->

                            <?php
                            if (isset($_REQUEST['ok'])) {

                                //validasi form kosong
                                if ("") {
                                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $nama_barang = $_REQUEST['nama_barang'];
                                    $jumlah_op = $_REQUEST['jumlah_op'];
                                    $satuan = $_REQUEST['satuan'];
                                    $harga_op = $_REQUEST['harga_op'];
                                    $keterangan_op_detail = $_REQUEST['keterangan_op_detail'];
                                    $total_op = $_REQUEST['total_op'];
                                    $total_ppn = $_REQUEST['total_ppn'];
                                    //               $nama_supplier = $_REQUEST['nama_supplier'];
                                    $id_op = $_SESSION['id_op'];

                                    @session_start();
                                    if (!isset($_SESSION["tableDet"])) {
                                        $i = 0;
                                    } else {
                                        $tableDet = $_SESSION["tableDet"];
                                        $i = count($tableDet);
                                    }

                                    $tableDet[$i]['nama_barang'] = $nama_barang;
                                    $tableDet[$i]['jumlah_op'] = $jumlah_op;
                                    $tableDet[$i]['satuan'] = $satuan;
                                    $tableDet[$i]['harga_op'] = $harga_op;
                                    $tableDet[$i]['keterangan_op_detail'] = $keterangan_op_detail;
                                    $tableDet[$i]['total_op'] = $total_op;
                                    $tableDet[$i]['total_ppn'] = $total_ppn;
                                    //               $tableDet[$i]['nama_supplier'] = $nama_supplier;
                                    $tableDet[$i]["mode_item"] = "N";
                                    $tableDet[$i]["i"] = $i;

                                    $_SESSION["tableDet"] = $tableDet;
                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                    header("Location: ./admin.php?page=op&act=add");
                                    die();
                                }
                            }
                            ?>
                        </div>
                </div>

        </div>
        </div>
        </tr>
        </table>     
        <br>
        <br>
        </div>


        <div class="input-field col s8">
            <i class="material-icons prefix md-prefix">looks_one</i>
            <?php
            //memulai mengambil datanya
            $sql = mysqli_query($config, "SELECT no_op FROM tbl_op");


            $result = mysqli_num_rows($sql);

            if ($result <> 0) {
                $kode = $result + 1;
            } else {
                $kode = 1;
            }

            //mulai bikin kode

            $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
            $tahun = date('m-Y');
            $kode_jadi = "FM-PMB/$tahun/$bikin_kode";

            if (isset($_SESSION['no_op'])) {
                $no_op = $_SESSION['no_op'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_op . '</div>';
                unset($_SESSION['no_op']);
            }
            ?>
            <label for="no_op"><strong>No.OP</strong></label>
            <input type="text" class="form-control" id="no_op" name="no_op"  value="<?php echo $kode_jadi ?>"disabled>
            <input type="hidden" class="form-control" id="no_op" name="no_op"  value="<?php echo $kode_jadi ?>" >
        </div>

        <div class="input-field col s8">
            <i class="material-icons prefix md-prefix">date_range</i>
            <input id="tgl_op" type="date" name="tgl_op" class="datepicker" required>
            <?php
            if (isset($_SESSION['tgl_op'])) {
                $tgl_op = $_SESSION['tgl_op'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_op . '</div>';
                unset($_SESSION['tgl_op']);
            }
            ?>
            <label for="tgl_op">Tanggal OP</label>
        </div>

        <div class="input-field col s8">
            <i class="material-icons prefix md-prefix">event_available</i>
            <input id="tgl_brg_dtg" type="date" name="tgl_brg_dtg" class="datepicker" required>
            <?php
            if (isset($_SESSION['tgl_brg_dtg'])) {
                $tgl_brg_dtg = $_SESSION['tgl_brg_dtg'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_brg_dtg . '</div>';
                unset($_SESSION['tgl_brg_dtg']);
            }
            ?>
            <label for="tgl_brg_dtg">Tgl Barang Datang</label>
        </div>

        <div class="input-field col s8">
            <i class="material-icons prefix md-prefix">attach_money</i>
            <textarea id="syarat_pembayaran" class="materialize-textarea validate" name="syarat_pembayaran"></textarea>
            <?php
            if (isset($_SESSION['syarat_pembayaran'])) {
                $syarat_pembayaran = $_SESSION['syarat_pembayaran'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $syarat_pembayaran . '</div>';
                unset($_SESSION['syarat_pembayaran']);
            }
            if (isset($_SESSION['errDup'])) {
                $errDup = $_SESSION['errDup'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                unset($_SESSION['errDup']);
            }
            ?>
            <label for="syarat_pembayaran">Pembayaran</label>
        </div>

        <div class="input-field col s8">
            <i class="material-icons prefix md-prefix">border_color</i>
            <textarea id="keterangan_op" class="materialize-textarea validate" name="keterangan_op"></textarea>
            <?php
            if (isset($_SESSION['keterangan_op'])) {
                $keterangan_op = $_SESSION['keterangan_op'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan_op . '</div>';
                unset($_SESSION['keterangan_op']);
            }
            if (isset($_SESSION['errDup'])) {
                $errDup = $_SESSION['errDup'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                unset($_SESSION['errDup']);
            }
            ?>
            <label for="keterangan_op">Keterangan</label>
        </div>

                                           <div class="input-field col s8">
            <i class="material-icons prefix md-prefix">people</i><label>Supplier</label><br/>
            <div class="input-field col s11 right">
                <select class="browser-default validate theSelect"name="supplier" id="supplier">
                    <?php
                    //Membuat koneksi ke database akademik
                    //Perintah sql untuk menampilkan semua data pada tabel jurusan
                    $sql = "select * from master_supplier  ORDER by nama_supplier ASC";

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
                <br/>
                <br/>
                <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>

                <a href="?page=op&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
            </div>
        </div>


        </div>

        </div>

        </form>
        <!-- Form END -->

        </div>
        <script>
                            $(".theSelect").select2();

        </script>
        <script>
            function myalert() {
                alert("Apa anda yakin ingin menghapus?");
            }
        </script> 
        <!-- Row form END -->

        <?php
    }
}
?>
