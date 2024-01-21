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
            $tgl_opb = $_REQUEST['tgl_opb'];
            $divisi_opb = $_REQUEST['divisi_opb'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/opb/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 10000000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_opb(no_form,tgl_opb,divisi_opb,id_user)
                                                                        VALUES('$no_form','$tgl_opb','$divisi_opb','$id_user')");

                        $id_opb_add = mysqli_insert_id($config);
                        @session_start();
                        if (isset($_SESSION["tableDet"])) {
                            $tableDet = $_SESSION["tableDet"];
                            foreach ($tableDet as $i => $v) {
                                if ($tableDet[$i]["mode_item"] == "N") {
                                    $nama_opb = $tableDet[$i]["nama_opb"];
                                    $nama_barang = $tableDet[$i]["nama_barang"];
                                    $jumlah = $tableDet[$i]["jumlah"];
                                    $satuan = $tableDet[$i]["satuan"];
                                    $keperluan = $tableDet[$i]["keperluan"];
                                    $id_opb = $id_opb_add;

                                    mysqli_query($config, "INSERT INTO tbl_opb_detail(nama_opb,nama_barang,jumlah,satuan,keperluan,id_opb)
                                                VALUES('$nama_opb','$nama_barang','$jumlah','$satuan','$keperluan','$id_opb')");
                                }
                            }
                        }

                        if ($query == true) {
                            if (isset($_SESSION["tableDet"])) {
                                unset($_SESSION["tableDet"]);
                            }
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=opb");
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
                $query = mysqli_query($config, "INSERT INTO tbl_opb(no_form,tgl_opb,divisi_opb,id_user)
                                                                        VALUES('$no_form','$tgl_opb','$divisi_opb','$id_user')");

                $id_opb_add = mysqli_insert_id($config);
                @session_start();
                if (isset($_SESSION["tableDet"])) {
                    $tableDet = $_SESSION["tableDet"];
                    foreach ($tableDet as $i => $v) {
                        if ($tableDet[$i]["mode_item"] == "N") {
                            $nama_opb = $tableDet[$i]["nama_opb"];
                            $nama_barang = $tableDet[$i]["nama_barang"];
                            $jumlah = $tableDet[$i]["jumlah"];
                            $satuan = $tableDet[$i]["satuan"];
                            $keperluan = $tableDet[$i]["keperluan"];
                            $id_opb = $id_opb_add;

                            mysqli_query($config, "INSERT INTO tbl_opb_detail(nama_opb,nama_barang,jumlah,satuan,keperluan,id_opb)
                                                VALUES('$nama_opb','$nama_barang','$jumlah','$satuan','$keperluan','$id_opb')");
                        }
                    }
                }

                if ($query == true) {
                    if (isset($_SESSION["tableDet"])) {
                        unset($_SESSION["tableDet"]);
                    }
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=opb");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
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
                            <li class="waves-effect waves-light"><a href="?page=opb&act=add" class="judul"><i class="material-icons">local_grocery_store</i> Tambah Data OPB</a></li>
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
            <form class="col s12" method="POST" action="?page=opb&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue  lighten-3" id="head">
                            <tr>

                                <th width="2%">No</th>
                                <th width="12%">Nama Peminta</th>
                                <th width="15%">Nama Barang</th>
                                <th width="5%">Jumlah</th>
                                <th width="5%">Satuan</th>
                                <th width="10%">Keperluan</th>
                                <th width="10%"><span> <a class="btn small red modal-trigger" href="#modal2">
                                            <i class="material-icons">add_circle_outline</i>Tambah Barang</a></span>
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
                                    if ($tableDet[$i]["mode_item"] != "D") {
                                        $no++;
                                        echo '<tr>';
                                        echo '<td>' . $no . '</td>';
                                        echo '<td>' . $tableDet[$i]["nama_opb"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["nama_barang"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["jumlah"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["satuan"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["keperluan"] . '</td>';
                                        echo '<td><center><a href="hapus_item_opb.php?id=' . $tableDet[$i]["i"] . '" class="btn small btn-xs red btn-removable "><i class="fa fa-times"></i> Hapus</a></center></td>';

                                        echo '</tr>';
                                    }
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6" style="text-align: center"><strong>
                                            <font color="red">*** JANGAN LUPA ISI DATA BARANG ***</font>
                                        </strong></td>

                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>

                        <div id="modal2" class="modal">
                            <div class="modal-content white">
                                <div class="row">
                                    <!-- Secondary Nav START -->
                                    <div class="col s12">
                                        <nav class="secondary-nav">
                                            <div class="nav-wrapper blue darken-2">
                                                <ul class="left">
                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">add_shopping_cart</i> Tambah Data Barang</a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                    <!-- Secondary Nav END -->
                                </div>

                                <div class="row jarak-form">
                                    <form class="col s12" method="post" action="">
                                        <div class="input-field col s11">
                                            <input type="hidden" id="id_opb_detail" name="id_opb_detail" value="<? $_row['id_opb_detail'] ?>" />
                                            <i class="material-icons prefix md-prefix">local_mall</i><label>Nama Barang</label><br />



                                            <div class="input-field col s11 right">
                                                <select name="nama_barang" class="browser-default validate theSelect" id="nama_barang">
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
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">people</i>
                                            <input id="nama_opb" type="text" class="validate" name="nama_opb">
                                            <?php
                                            if (isset($_SESSION['nama_opb'])) {
                                                $nama_opb = $_SESSION['nama_opb'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_opb . '</div>';
                                                unset($_SESSION['nama_opb']);
                                            }
                                            ?>
                                            <label for="nama_opb">Nama Peminta</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">playlist_add</i>
                                            <input id="jumlah" type="number" class="validate" name="jumlah">
                                            <?php
                                            if (isset($_SESSION['jumlah'])) {
                                                $jumlah = $_SESSION['jumlah'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah . '</div>';
                                                unset($_SESSION['jumlah']);
                                            }
                                            ?>
                                            <label for="jumlah">Jumlah</label>
                                        </div>

                                        <div class="input-field col s12">
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

                                        <!-- <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">library_add</i><label>Keterangan</label><br />
                                            <div class="input-field col s11 right">
                                                <select class="browser-default validate" name="keterangan_pp" id="keterangan_pp">
                                                    <option value="Sparepart">Sparepart</option>
                                                    <option value="Building Improvement">Building Improvement</option>
                                                    <option value="Project">Project</option>
                                                    <option value="Stock">Stock</option>
                                                    <option value="Atk">Atk</option>
                                                    <option value="Tools">Tools</option>
                                                    <option value="Maintenance">Maintenance</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">home</i>
                                            <input id="keperluan" type="text" class="validate" name="keperluan">
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
                            </div>

                            <!-- Footer -->
                            <div class="col s12">
                                <div class="col 6">
                                    <button type="ok" name="ok" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>
                                    <?php
                                    if (isset($_REQUEST['ok'])) {

                                        //validasi form kosong
                                        if ("") {
                                            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        } else {

                                            $nama_opb = $_REQUEST['nama_opb'];
                                            $nama_barang = $_REQUEST['nama_barang'];
                                            $jumlah = $_REQUEST['jumlah'];
                                            $satuan = $_REQUEST['satuan'];
                                            $keperluan = $_REQUEST['keperluan'];
                                            $id_opb = $_SESSION['id_opb'];

                                            @session_start();
                                            if (!isset($_SESSION["tableDet"])) {
                                                $i = 0;
                                            } else {
                                                $tableDet = $_SESSION["tableDet"];
                                                $i = count($tableDet);
                                            }

                                            $tableDet[$i]['nama_opb'] = $nama_opb;
                                            $tableDet[$i]['nama_barang'] = $nama_barang;
                                            $tableDet[$i]['jumlah'] = $jumlah;
                                            $tableDet[$i]['satuan'] = $satuan;
                                            $tableDet[$i]['keperluan'] = $keperluan;
                                            $tableDet[$i]["mode_item"] = "N";
                                            $tableDet[$i]["i"] = $i;

                                            $_SESSION["tableDet"] = $tableDet;
                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                            header("Location: ./admin.php?page=opb&act=add");
                                            die();
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="col s6">
                                    <a href="?page=opb&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>

                        </div>
                </div>
                </tr>
                </table>
                <br>
                <br>
        </div>


        <div class="input-field col s12">
            <i class="material-icons prefix md-prefix">looks_one</i>
            <?php
            //memulai mengambil datanya
            $sql = mysqli_query($config, "SELECT no_form FROM tbl_opb");


            $result = mysqli_num_rows($sql);

            if ($result <> 0) {
                $kode = $result + 1;
            } else {
                $kode = 1;
            }

            //mulai bikin kode
            $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
            $tahun = date('Y-m');
            $kode_jadi = "FM/GDG/$bikin_kode";

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


        <div class="input-field col s12">
            <i class="material-icons prefix md-prefix">date_range</i>
            <input id="tgl_opb" type="date" name="tgl_opb" class="datepicker" required>
            <?php
            if (isset($_SESSION['tgl_opb'])) {
                $tgl_opb = $_SESSION['tgl_opb'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_opb . '</div>';
                unset($_SESSION['tgl_opb']);
            }
            ?>
            <label for="tgl_opb">Tanggal</label>
        </div>


        <br>
        <div class="input-field col s12">
            <i class="material-icons prefix md-prefix">low_priority</i><label><strong>
                    <span color="red">Divisi</span>
                </strong></label><br /></i>
            <div class="input-field col s11 right">
                <select class="browser-default validate" name="divisi_opb" id="divisi_opb" required>
                    <option value="Pilih Divisi">Pilih Divisi</option>
                    <option value="Teknik">Teknik</option>
                    <option value="Facility">Facility</option>
                    <option value="Keuangan">Keuangan</option>
                    <option value="Marketing">Marketing</option>
                    <option value="HRGA">HRGA</option>
                    <option value="Busdev">Busdev</option>
                </select>
            </div>

            <?php
            if (isset($_SESSION['divisi_opb'])) {
                $divisi_opb = $_SESSION['divisi_opb'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi_opb . '</div>';
                unset($_SESSION['divisi_opb']);
            }
            ?>
        </div>


        </div>
        <!-- Row in form END -->

        <div class="row">
            <div class="col 6">
                <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>

            </div>
            <div class="col 6">
                <a href="?page=opb" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
            </div>
        </div>

        </form>
        <!-- Form END -->

        </div>
        <!-- Row form END -->
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