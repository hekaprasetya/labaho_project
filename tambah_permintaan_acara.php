<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        //validasi form kosong
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_pa              = $_POST['no_pa'];
            $nama_perusahaan    = $_POST['nama_perusahaan'];
            $penanggung_jawab   = $_POST['penanggung_jawab'];
            $no_telp            = $_POST['no_telp'];
            $ruangan_sewa       = $_POST['ruangan_sewa'];
            $tgl_acara          = $_POST['tgl_acara'];
            $tgl_selesai        = $_POST['tgl_selesai'];
            $judul              = $_POST['judul'];
            $fasilitas          = $_POST['fasilitas'];
            $tambahan_lain      = $_POST['tambahan_lain'];
            $jam                = $_POST['jam'];
            $harga_sewa         = $_POST['harga_sewa'];
            $promo              = $_POST['promo'];
            $dp                 = $_POST['dp'];
            $ppn                = $_POST['ppn'];
            $status             = $_POST['status'];
            $id_user            = $_SESSION['id_user'];

            //validasi input data
            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/permintaan_acara/";

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

                        $query = mysqli_query($config, "INSERT INTO tbl_pa(no_pa,nama_perusahaan,penanggung_jawab,file,no_telp,ruangan_sewa,tgl_acara,tgl_selesai,judul,fasilitas,tambahan_lain,jam,harga_sewa,promo,dp,ppn,status,id_user)
                                                                        VALUES('$no_pa','$nama_perusahaan','$penanggung_jawab','$nfile','$no_telp','$ruangan_sewa','$tgl_acara','$tgl_selesai','$judul','$fasilitas','$tambahan_lain','$jam','$harga_sewa','$promo','$dp','$ppn','$status','$id_user')");

                        $id_pa_add = mysqli_insert_id($config);
                        @session_start();
                        if (isset($_SESSION["tableDet"])) {
                            $tableDet = $_SESSION["tableDet"];
                            foreach ($tableDet as $i => $v) {
                                if ($tableDet[$i]["mode_item"] == "N") {
                                    $nama_paket = $tableDet[$i]["nama_paket"];
                                    $harga = $tableDet[$i]["harga"];
                                    $id_pa = $id_pa_add;


                                    mysqli_query($config, "INSERT INTO tbl_pa_detail(nama_paket,harga,id_pa)
                                                VALUES('$nama_paket','$harga','$id_pa')");
                                }
                            }
                        }

                        if ($query == true) {
                            if (isset($_SESSION["tableDet"])) {
                                unset($_SESSION["tableDet"]);
                            }

                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=pa");
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
                $query = mysqli_query($config, "INSERT INTO tbl_pa(no_pa,nama_perusahaan,penanggung_jawab,file,no_telp,ruangan_sewa,tgl_acara,tgl_selesai,judul,fasilitas,tambahan_lain,jam,harga_sewa,promo,dp,ppn,status,id_user)
                                                                        VALUES('$no_pa','$nama_perusahaan','$penanggung_jawab','$nfile','$no_telp','$ruangan_sewa','$tgl_acara','$tgl_selesai','$judul','$fasilitas','$tambahan_lain','$jam','$harga_sewa','$promo','$dp','$ppn','$status','$id_user')");

                $id_pa_add = mysqli_insert_id($config);
                @session_start();
                if (isset($_SESSION["tableDet"])) {
                    $tableDet = $_SESSION["tableDet"];
                    foreach ($tableDet as $i => $v) {
                        if ($tableDet[$i]["mode_item"] == "N") {
                            $nama_paket = $tableDet[$i]["nama_paket"];
                            $harga      = $tableDet[$i]["harga"];
                            $id_pa      = $id_pa_add;

                            mysqli_query($config, "INSERT INTO tbl_pa_detail(nama_paket,harga,id_pa)
                                                VALUES('$nama_paket','$harga','$id_pa')");
                        }
                    }
                }

                if ($query == true) {
                    if (isset($_SESSION["tableDet"])) {
                        unset($_SESSION["tableDet"]);
                    }
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=pa");
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
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=pa&act=add" class="judul"><i class="material-icons">mail</i> Tambah Persiapan Acara</a></li>
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
            <form class="col s12" method="POST" action="?page=pa&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="white-grey lighten-3" id="head">
                            <tr>
                                <th width="2%">No</th>
                                <th width="12%">Charge Tambahan</th>
                                <th width="5%">Harga</th>
                                <th width="5%"><span> <a class="btn small light-green modal-trigger" href="#modal2">
                                   <i class="material-icons">add_circle_outline</i>Tambah Biaya</a></span>
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
                                        echo '<td>' . $tableDet[$i]["nama_paket"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["harga"]= "Rp " . number_format((float)$tableDet[$i]['harga'], 0, ',', '.') . '</td>';
                                        echo '<td><center><a href="hapus_item_pa.php?id=' . $tableDet[$i]["i"] . '" class="btn small btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center></td>';
                                        echo '</tr>';
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" style="text-align: center">Tidak ada charg tambahan.</td>
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
                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">add_shopping_cart</i> Tambah Data Charge</a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                    <!-- Secondary Nav END -->
                                </div>

                                <div class="row jarak-form">
                                    <form class="col s12" method="post" action="">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">local_mall</i>
                                            <input id="nama_paket" type="text" class="validate" name="nama_paket">
                                            <?php
                                            if (isset($_SESSION['nama_paket'])) {
                                                $nama_paket = $_SESSION['nama_paket'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_paket . '</div>';
                                                unset($_SESSION['nama_paket']);
                                            }
                                            ?>
                                            <label for="nama_paket">Nama Paket</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <i class="material-icons prefix md-prefix">playlist_add</i>
                                            <input id="harga" type="number" class="validate" name="harga">
                                            <?php
                                            if (isset($_SESSION['harga'])) {
                                                $harga = $_SESSION['harga'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $harga . '</div>';
                                                unset($_SESSION['harga']);
                                            }
                                            ?>
                                            <label for="harga">Harga</label>
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

                                            $nama_paket = $_REQUEST['nama_paket'];
                                            $harga = $_REQUEST['harga'];
                                            $id_pa = $_SESSION['id_pa'];
                                            $id_user = $_SESSION['id_user'];

                                            @session_start();
                                            if (!isset($_SESSION["tableDet"])) {
                                                $i = 0;
                                            } else {
                                                $tableDet = $_SESSION["tableDet"];
                                                $i = count($tableDet);
                                            }

                                            $tableDet[$i]['nama_paket'] = $nama_paket;
                                            $tableDet[$i]['harga'] = $harga;
                                            $tableDet[$i]["mode_item"] = "N";
                                            $tableDet[$i]["i"] = $i;

                                            $_SESSION["tableDet"] = $tableDet;
                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                            header("Location: ./admin.php?page=pa&act=add");
                                            die();
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="col s6">
                                    <a href="?page=pa&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
                    $sql = mysqli_query($config, "SELECT no_pa FROM tbl_pa");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('m/Y');
                    $kode_jadi = "FM-MRK-008/$bikin_kode/$tahun";

                    if (isset($_SESSION['no_pa'])) {
                        $no_pa = $_SESSION['no_pa'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_pa . '</div>';
                        unset($_SESSION['no_pa']);
                    }
                    ?>
                    <label for="no_pa">No.Form</label>
                    <input type="text" class="form-control" id="no_agenda" name="no_pa"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_agenda" name="no_pa"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_acara" type="text" name="tgl_acara" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_acara'])) {
                        $tgl_acara = $_SESSION['tgl_acara'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_acara . '</div>';
                        unset($_SESSION['tgl_acara']);
                    }
                    ?>
                    <label for="tgl_acara">Tanggal Acara</label>
                </div>    
                
                 <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">event</i>
                    <input id="tgl_selesai" type="text" name="tgl_selesai" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_selesai'])) {
                        $tgl_selesai = $_SESSION['tgl_selesai'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_selesai . '</div>';
                        unset($_SESSION['tgl_selesai']);
                    }
                    ?>
                    <label for="tgl_selesai">Tanggal Selesai</label>
                </div>   
                
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">description</i>
                    <input id="judul" type="text" class="validate" name="judul">
                    <?php
                    if (isset($_SESSION['judul'])) {
                        $judul = $_SESSION['judul'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $judul . '</div>';
                        unset($_SESSION['judul']);
                    }
                    ?>
                    <label for="judul">Judul</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">business</i>
                    <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan">
                    <?php
                    if (isset($_SESSION['nama_perusahaan'])) {
                        $nama_perusahaan = $_SESSION['nama_perusahaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_perusahaan . '</div>';
                        unset($_SESSION['nama_perusahaan']);
                    }
                    ?>
                    <label for="nama_perusahaan">Nama Perusahaan</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">contacts</i>
                    <input id="penanggung_jawab" type="text" class="validate" name="penanggung_jawab">
                    <?php
                    if (isset($_SESSION['penanggung_jawab'])) {
                        $penanggung_jawab = $_SESSION['penanggung_jawab'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $penanggung_jawab . '</div>';
                        unset($_SESSION['penanggung_jawab']);
                    }
                    ?>
                    <label for="penanggung_jawab">Penanggung Jawab</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">contact_phone</i>
                    <input id="no_telp" type="number" class="validate" name="no_telp" >
                    <?php
                    if (isset($_SESSION['no_telp'])) {
                        $no_telp = $_SESSION['no_telp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_telp . '</div>';
                        unset($_SESSION['no_telp']);
                    }
                    ?>
                    <label for="no_telp">No.Telp</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">alarm</i>
                    <input id="jam" type="text" class="validate" name="jam" >
                    <?php
                    if (isset($_SESSION['jam'])) {
                        $jam = $_SESSION['jam'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jam . '</div>';
                        unset($_SESSION['jam']);
                    }
                    ?>
                    <label for="jam">Jam Acara</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">home</i><label>Ruangan Sewa</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="ruangan_sewa" id="ruangan_sewa">
                            <option value="-- Pilih Ruangan --">-- Pilih Ruangan --</option>
                            <option value="Pena Room">Pena Room</option>
                            <option value="Zetizen Room">Zetizen Room</option>
                            <option value="Deteksi Room">Deteksi Room</option>
                            <option value="Nusantara Room">Nusantara Room</option>
                            <option value="DBL Tribun">DBL Tribun</option>
                            <option value="DBL Atrium">DBL Atrium</option>
                            <option value="DBL Academy">DBL Academy</option>
                            <option value="Lobby">Lobby Graha Pena Utama</option>
                            <option value="Lobby">Lobby Graha Pena Extension</option>
                            <option value="Area Parkir">Area Parkir</option>
                            <option value="Koridor JTV">Koridor JTV</option>
                            <option value="Heritage Lt.5">Heritage Lt.5</option>
                        </select>
                        </select>
                    </div>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">accessibility_new</i>
                    <textarea id="fasilitas" class="materialize-textarea validate" name="fasilitas"></textarea>
                    <?php
                    if (isset($_SESSION['fasilitas'])) {
                        $fasilitas = $_SESSION['fasilitas'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $fasilitas . '</div>';
                        unset($_SESSION['fasilitas']);
                    }
                    ?>
                    <label for="fasilitas">Fasilitas</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">description</i>
                    <textarea id="tambahan_lain" class="materialize-textarea validate" name="tambahan_lain"></textarea>
                    <?php
                    if (isset($_SESSION['tambahan_lain'])) {
                        $tambahan_lain = $_SESSION['tambahan_lain'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tambahan_lain . '</div>';
                        unset($_SESSION['tambahan_lain']);
                    }
                    ?>
                    <label for="tambahan_lain">Detail Harga Sewa</label>
                </div>

                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>file</span>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload file layout acara">
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
                 <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">attach_money</i>
                   <input id="harga_sewa" type="number" class="validate" name="harga_sewa">
                    <?php
                    if (isset($_SESSION['harga_sewa'])) {
                        $harga_sewa = $_SESSION['harga_sewa'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $harga_sewa . '</div>';
                        unset($_SESSION['harga_sewa']);
                    }
                    ?>
                    <label for="harga_sewa">Harga Sewa</label>
                </div>
        
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">archive</i>
                    <input id="promo" type="number" class="validate" name="promo">
                    <?php
                    if (isset($_SESSION['promo'])) {
                        $promo = $_SESSION['promo'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $promo . '</div>';
                        unset($_SESSION['promo']);
                    }
                    ?>
                    <label for="promo">Discount</label>
                </div>
        
                
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">brightness_7</i>
                    <input id="dp" type="number" class="validate" name="dp">
                    <?php
                    if (isset($_SESSION['dp'])) {
                        $dp = $_SESSION['dp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $dp . '</div>';
                        unset($_SESSION['dp']);
                    }
                    ?>
                    <label for="dp">DP</label>
                </div>
        
                 <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">home</i><label>PPN</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="ppn" id="ppn">
                            <option value="0.11">11%</option>
                            <option value="0.1">10%</option>
                        </select>
                    </div>
                </div>
        
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">edit</i><label>Status Surat</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="status" id="status">
                            <option value="Terbit">Terbit</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                </div>
        </div>
        <!-- Row in form END -->

        <div class="row">
            <div class="col 6">
                <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
            </div>
            <div class="col 6">
                <a href="?page=pa" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
