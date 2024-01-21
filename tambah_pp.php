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

            $no_pp = $_REQUEST['no_pp'];
            $tgl_pp = $_REQUEST['tgl_pp'];
            $target = $_REQUEST['target'];
            $divisi = $_REQUEST['divisi'];
            $catatan_pp = $_REQUEST['catatan_pp'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/pp/";

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

                        $query = mysqli_query($config, "INSERT INTO tbl_pp(no_pp,tgl_pp,target,file,divisi,catatan_pp,id_user)
                                                                        VALUES('$no_pp','$tgl_pp','$target','$nfile','$divisi','$catatan_pp','$id_user')");

                        $id_pp_add = mysqli_insert_id($config);
                        @session_start();
                        if (isset($_SESSION["tableDet"])) {
                            $tableDet = $_SESSION["tableDet"];
                            foreach ($tableDet as $i => $v) {
                                if ($tableDet[$i]["mode_item"] == "N") {
                                    $nama_barang = $tableDet[$i]["nama_barang"];
                                    $jumlah = $tableDet[$i]["jumlah"];
                                    $satuan = $tableDet[$i]["satuan"];
                                    $keterangan_pp = $tableDet[$i]["keterangan_pp"];
                                    $tujuan_pp = $tableDet[$i]["tujuan_pp"];
                                    $id_pp = $id_pp_add;

                                    mysqli_query($config, "INSERT INTO tbl_pp_barang(nama_barang,jumlah,satuan,keterangan_pp,tujuan_pp,id_pp)
                                                VALUES('$nama_barang','$jumlah','$satuan','$keterangan_pp','$tujuan_pp','$id_pp')");
                                }
                            }
                        }

                        if ($query == true) {
                            if (isset($_SESSION["tableDet"])) {
                                unset($_SESSION["tableDet"]);
                            }
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=pp");
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
                $query = mysqli_query($config, "INSERT INTO tbl_pp(no_pp,tgl_pp,target,file,divisi,catatan_pp,id_user)
                                                                        VALUES('$no_pp','$tgl_pp','$target','$nfile','$divisi','$catatan_pp','$id_user')");

                $id_pp_add = mysqli_insert_id($config);
                @session_start();
                if (isset($_SESSION["tableDet"])) {
                    $tableDet = $_SESSION["tableDet"];
                    foreach ($tableDet as $i => $v) {
                        if ($tableDet[$i]["mode_item"] == "N") {
                            $nama_barang = $tableDet[$i]["nama_barang"];
                            $jumlah = $tableDet[$i]["jumlah"];
                            $satuan = $tableDet[$i]["satuan"];
                            $keterangan_pp = $tableDet[$i]["keterangan_pp"];
                            $tujuan_pp = $tableDet[$i]["tujuan_pp"];
                            $id_pp = $id_pp_add;

                            mysqli_query($config, "INSERT INTO tbl_pp_barang(nama_barang,jumlah,satuan,keterangan_pp,tujuan_pp,id_pp)
                                                VALUES('$nama_barang','$jumlah','$satuan','$keterangan_pp','$tujuan_pp','$id_pp')");
                        }
                    }
                }

                if ($query == true) {
                    if (isset($_SESSION["tableDet"])) {
                        unset($_SESSION["tableDet"]);
                    }
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=pp");
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
                            <li class="waves-effect waves-light"><a href="?page=pp&act=add" class="judul"><i class="material-icons">local_grocery_store</i> Tambah Data PP</a></li>
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
            <form class="col s12" method="POST" action="?page=pp&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue  lighten-3" id="head">
                            <tr>

                                <th width="2%">No</th>
                                <th width="12%">Nama Barang</th>
                                <th width="5%">Jumlah</th>
                                <th width="5%">Satuan</th>
                                <th width="10%">Keterangan</th>
                                <th width="15%">Tujuan PP</th>
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
                                    if ($tableDet [$i]["mode_item"] != "D") {
                                        $no++;
                                        echo '<tr>';
                                        echo '<td>' . $no . '</td>';
                                        echo '<td>' . $tableDet[$i]["nama_barang"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["jumlah"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["satuan"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["keterangan_pp"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["tujuan_pp"] . '</td>';
                                        echo '<td><center><a href="hapus_item_pp.php?id=' . $tableDet[$i]["i"] . '" class="btn small btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center></td>';
                                        echo '</tr>';
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align: center"><strong><font color="red">*** JANGAN LUPA ISI DATA BARANG ***</font></strong></td>

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
                                            <div class="nav-wrapper blue-grey darken-1">
                                                <ul class="left">
                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">add_shopping_cart</i> Tambah Data Barang</a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                    <!-- Secondary Nav END -->
                                </div>

                                <div class="row jarak-form">
                                    <form class="col s8" method="post" action="">
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
                                            <i class="material-icons prefix md-prefix">bookmark</i><label>Satuan</label><br/>
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

                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">library_add</i><label>Keterangan</label><br/>
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
                                        </div>

                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">home</i>
                                            <input id="tujuan_pp" type="text" class="validate" name="tujuan_pp" >
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
                            </div>

                            <!-- Footer -->
                            <div class="col s12">
                                <div class="col 6">
                                    <button type="ok" name ="ok" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>
                                    <?php
                                    if (isset($_REQUEST['ok'])) {

                                        //validasi form kosong
                                        if ("") {
                                            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        } else {

                                            $nama_barang = $_REQUEST['nama_barang'];
                                            $jumlah = $_REQUEST['jumlah'];
                                            $satuan = $_REQUEST['satuan'];
                                            $keterangan_pp = $_REQUEST['keterangan_pp'];
                                            $tujuan_pp = $_REQUEST['tujuan_pp'];
                                            $id_pp = $_SESSION['id_pp'];

                                            @session_start();
                                            if (!isset($_SESSION["tableDet"])) {
                                                $i = 0;
                                            } else {
                                                $tableDet = $_SESSION["tableDet"];
                                                $i = count($tableDet);
                                            }

                                            $tableDet[$i]['nama_barang'] = $nama_barang;
                                            $tableDet[$i]['jumlah'] = $jumlah;
                                            $tableDet[$i]['satuan'] = $satuan;
                                            $tableDet[$i]['keterangan_pp'] = $keterangan_pp;
                                            $tableDet[$i]['tujuan_pp'] = $tujuan_pp;
                                            $tableDet[$i]["mode_item"] = "N";
                                            $tableDet[$i]["i"] = $i;

                                            $_SESSION["tableDet"] = $tableDet;
                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                            header("Location: ./admin.php?page=pp&act=add");
                                            die();
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="col s6">
                                    <a href="?page=pp&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
                    $sql = mysqli_query($config, "SELECT no_pp FROM tbl_pp");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('Y-m');
                    $kode_jadi = "PP/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_pp'])) {
                        $no_pp = $_SESSION['no_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_pp . '</div>';
                        unset($_SESSION['no_pp']);
                    }
                    ?>
                    <label for="no_pp"><strong>No.PP</strong></label>
                    <input type="text" class="form-control" id="no_pp" name="no_pp"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_pp" name="no_pp"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_pp" type="date" name="tgl_pp" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_pp'])) {
                        $tgl_pp = $_SESSION['tgl_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_pp . '</div>';
                        unset($_SESSION['tgl_pp']);
                    }
                    ?>
                    <label for="tgl_pp">Tanggal PP</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">event_available</i>
                    <input id="target" type="date" name="target" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['target'])) {
                        $target = $_SESSION['target'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $target . '</div>';
                        unset($_SESSION['target']);
                    }
                    ?>
                    <label for="target">Target</label>
                </div>

                <br>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">low_priority</i><label><strong><font color = "red">Divisi</font></strong></label><br/></i>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="divisi" id="divisi" required>
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
                    if (isset($_SESSION['divisi'])) {
                        $divisi = $_SESSION['divisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi . '</div>';
                        unset($_SESSION['divisi']);
                    }
                    ?>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">people</i>
                    <textarea id="catatan_pp" class="materialize-textarea validate" name="catatan_pp"></textarea>
                    <?php
                    if (isset($_SESSION['catatan_pp'])) {
                        $catatan_pp = $_SESSION['catatan_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan_pp . '</div>';
                        unset($_SESSION['catatan_pp']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="catatan_pp">Catatan PP</label>
                </div>

                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>File</span>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload file contoh">
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
                <a href="?page=pp" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
