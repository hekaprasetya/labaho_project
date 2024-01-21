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

            $no_ppi                 = $_REQUEST['no_ppi'];
            $tgl_ppi                = $_REQUEST['tgl_ppi'];
            $nama_peminta           = $_REQUEST['nama_peminta'];
            $divisi                 = $_REQUEST['divisi'];
            $permintaan_pekerjaan   = $_REQUEST['permintaan_pekerjaan'];
            $tujuan_divisi          = $_REQUEST['tujuan_divisi'];
            $lokasi                 = $_REQUEST['lokasi'];
            $id_user                = $_SESSION['id_user'];

            //validasi input data



            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/ppi/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 6900000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_ppi(no_ppi,tgl_ppi,nama_peminta,divisi,tujuan_divisi,permintaan_pekerjaan,lokasi,file,id_user)
                                                                        VALUES('$no_ppi','$tgl_ppi','$nama_peminta','$divisi','$tujuan_divisi','$permintaan_pekerjaan','$lokasi','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=ppi");
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
                $query = mysqli_query($config, "INSERT INTO tbl_ppi(no_ppi,tgl_ppi,nama_peminta,divisi,tujuan_divisi,permintaan_pekerjaan,lokasi,file,id_user)
                                                                        VALUES('$no_ppi','$tgl_ppi','$nama_peminta','$divisi','$tujuan_divisi','$permintaan_pekerjaan','$lokasi','$file','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=ppi");
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
                        <li class="waves-effect waves-light"><a href="?page=ppi&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data Permintaan Pekerjaan Internal</a></li>
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
        <form class="col s12" method="POST" action="?page=ppi&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="input-field col s12">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <?php
                //memulai mengambil datanya
                $sql = mysqli_query($config, "SELECT no_ppi FROM tbl_ppi");


                $result = mysqli_num_rows($sql);

                if ($result <> 0) {
                    $kode = $result + 1;
                } else {
                    $kode = 1;
                }

                //mulai bikin kode
                $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                $tahun = date('Y-m');
                $kode_jadi = "PPI/$tahun/$bikin_kode";

                if (isset($_SESSION['no_ppi'])) {
                    $no_pa = $_SESSION['no_ppi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_ppi . '</div>';
                    unset($_SESSION['no_ppi']);
                }
                ?>
                <label for="no_ppi">No.PPI</label>
                <input type="text" class="form-control" id="no_ppi" name="no_ppi"  value="<?php echo $kode_jadi ?>"disabled>
                <input type="hidden" class="form-control" id="no_ppi" name="no_ppi"  value="<?php echo $kode_jadi ?>" >
            </div>

              <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">date_range</i>
                <input id="tgl_ppi" type="text" name="tgl_ppi" class="datepicker" required>
                <?php
                if (isset($_SESSION['tgl_ppi'])) {
                    $tgl_ppi = $_SESSION['tgl_ppi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_ppi . '</div>';
                    unset($_SESSION['tgl_ppi']);
                }
                ?>
                <label for="tgl_ppi">Tanggal PPI</label>
            </div>
            
            <div class="input-field col s12">
                <i class="material-icons prefix md-prefix">contacts</i>
                <input id="nama_peminta" type="text" class="validate" name="nama_peminta" required>
                <?php
                if (isset($_SESSION['nama_peminta'])) {
                    $nama_peminta = $_SESSION['nama_peminta'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_peminta . '</div>';
                    unset($_SESSION['nama_peminta']);
                }
                ?>
                <label for="nama_peminta">Nama Peminta</label>
            </div>

             <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">accessibility_new</i><label>Divisi</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="divisi" id="divisi">
                            <option value="-- Pilih Divisi --">-- Pilih Divisi --</option>
                            <option value="Teknik">Teknik</option>
                            <option value="Marketing">Marketing</option>
                            <option value="HRGA">HRGA</option>
                            <option value="BUSDEV">Busdev</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Facility">Facility</option>
                        </select>
                    </div>
                </div>
            
             <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">build</i>
                    <textarea id="permintaan_pekerjaan" class="materialize-textarea validate" name="permintaan_pekerjaan" required></textarea>
                    <?php
                    if (isset($_SESSION['permintaan_pekerjaan'])) {
                        $permintaan_pekerjaan = $_SESSION['permintaan_pekerjaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $permintaan_pekerjaan . '</div>';
                        unset($_SESSION['permintaan_pekerjaan']);
                    }
                    ?>
                    <label for="permintaan_pekerjaan">Permintaan Pekerjaan</label>
                </div>

             <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">brightness_7</i><label>Divisi Tujuan</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="tujuan_divisi" id="tujuan_divisi">
                            <option value="-- Pilih Divisi --">-- Pilih Divisi --</option>
                            <option value="Teknik">Teknik</option>
                            <option value="Facility">Facility</option>
                            <option value="Arsitek">Arsitek</option>
                        </select>
                    </div>
                </div>
            
            <div class="input-field col s12">
                <i class="material-icons prefix md-prefix">location_on</i>
                <input id="lokasi" type="text" class="validate" name="lokasi">
                <?php
                if (isset($_SESSION['lokasi'])) {
                    $lokasi = $_SESSION['lokasi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi . '</div>';
                    unset($_SESSION['lokasi']);
                }
                ?>
                <label for="lokasi">lokasi</label>
            </div>
            
            <div class="input-field col s12">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1">
                        <span>File</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload file/scan gambar surat masuk">
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
                        <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 7 MB!</small>
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
            <a href="?page=ppi" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
