<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_wo'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_wo              = $_REQUEST['no_wo'];
            $tgl_wo             = $_REQUEST['tgl_wo'];
            $jenis_pekerjaan    = $_REQUEST['jenis_pekerjaan'];
            $lokasi             = $_REQUEST['lokasi'];
            $nama_perusahaan    = $_REQUEST['nama_perusahaan'];
            $penyebab           = $_REQUEST['penyebab'];
            $solusi             = $_REQUEST['solusi'];
            $status             = $_REQUEST['status'];
            $tgl_selesai        = $_REQUEST['tgl_selesai'];
            $id_user            = $_SESSION['id_user'];




            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/engineering/";

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

                        $query = mysqli_query($config, "INSERT INTO tbl_engineering(no_wo,tgl_wo,jenis_pekerjaan,file,lokasi,nama_perusahaan,penyebab, solusi, status,tgl_selesai,id_user)
                                                                        VALUES('$no_wo','$tgl_wo','$jenis_pekerjaan','$nfile','$lokasi','$nama_perusahaan','$penyebab','$solusi','$status','$tgl_selesai','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=eng");
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
                $query = mysqli_query($config, "INSERT INTO tbl_engineering(no_wo,tgl_wo,jenis_pekerjaan,file,lokasi,nama_perusahaan,penyebab,solusi,status,tgl_selesai,id_user)
                                                                        VALUES('$no_wo','$tgl_wo','$jenis_pekerjaan','$nfile','$lokasi','$nama_perusahaan','$penyebab','$solusi','$status','$tgl_selesai','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=eng");
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
                    <li class="waves-effect waves-light"><a href="?page=tsm&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data</a></li>
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
    <form class="col s12" method="POST" action="?page=eng&act=add" enctype="multipart/form-data">

        <!-- Row in form START -->
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">looks_one</i>
            <?php
            //memulai mengambil datanya
            $sql = mysqli_query($config, "SELECT no_wo FROM tbl_engineering");


            $result = mysqli_num_rows($sql);

            if ($result <> 0) {
                $kode = $result + 1;
            } else {
                $kode = 1;
            }

            //mulai bikin kode
            $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
            $tahun = date('Y-m');
            $kode_jadi = "WO/$tahun/$bikin_kode";

            if (isset($_SESSION['no_wo'])) {
                $no_wo = $_SESSION['no_wo'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_wo . '</div>';
                unset($_SESSION['no_wo']);
            }
            ?>
            <label for="no_wo">No.WO</label>
            <input type="text" class="form-control" id="no_wo" name="no_wo"  value="<?php echo $kode_jadi ?>"disabled>
            <input type="hidden" class="form-control" id="no_wo" name="no_wo"  value="<?php echo $kode_jadi ?>" >
        </div>
        
         <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">date_range</i>
            <input id="tgl_wo" type="text" name="tgl_wo" class="datepicker" required>
            <?php
            if (isset($_SESSION['tgl_wo'])) {
                $tgl_wo = $_SESSION['tgl_wo'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_wo . '</div>';
                unset($_SESSION['tgl_wo']);
            }
            ?>
            <label for="tgl_wo">Tgl.WO</label>
        </div>

        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">build</i>
            <input id="jenis_pekerjaan" type="text" class="validate" name="jenis_pekerjaan" required>
            <?php
            if (isset($_SESSION['jenis_pekerjaan'])) {
                $jenis_pekerjaan = $_SESSION['jenis_pekerjaan'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jenis_pekerjaan . '</div>';
                unset($_SESSION['jenis_pekerjaan']);
            }
            ?>
            <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
        </div>
        
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">place</i>
            <input id="lokasi" type="text" class="validate" name="lokasi" required>
            <?php
            if (isset($_SESSION['lokasi'])) {
                $lokasi = $_SESSION['lokasi'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi . '</div>';
                unset($_SESSION['lokasi']);
            }
            ?>
            <label for="lokasi">Lokasi</label>
        </div>
        
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">home</i>
            <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan" required>
            <?php
            if (isset($_SESSION['nama_perusahaan'])) {
                $nama_perusahaan = $_SESSION['nama_perusahaan'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_perusahaan . '</div>';
                unset($_SESSION['nama_perusahaan']);
            }
            ?>
            <label for="nama_perusahaan">Nama Perusahaan</label>
        </div>
        
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">adb</i>
            <input id="penyebab" type="text" class="validate" name="penyebab">
            <?php
            if (isset($_SESSION['penyebab'])) {
                $penyebab = $_SESSION['penyebab'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $penyebab . '</div>';
                unset($_SESSION['penyebab']);
            }
            ?>
            <label for="penyebab">Penyebab</label>
        </div>
        
          <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">assignment_turned_in</i>
            <input id="solusi" type="text" class="validate" name="solusi">
            <?php
            if (isset($_SESSION['solusi'])) {
                $solusi = $_SESSION['solusi'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $solusi . '</div>';
                unset($_SESSION['solusi']);
            }
            ?>
            <label for="solusi">Solusi</label>
        </div>
        
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">low_priority</i><label>Status Pekerjaan</label><br/>
            <div class="input-field col s11 right">
                <select class="browser-default validate" name="status" id="status" required>
                    <option value="Progres">Progres</option>
                    <option value="Pending">Pending</option>
                    <option value="Material kosong">Material kosong</option>
                    <option value="Material kosong">Selesai</option>
                </select>
            </div>
        </div>
        
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">date_range</i>
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

    

        <div class="input-field col s6">
            <div class="file-field input-field">
                <div class="btn light-green darken-1">
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
                    <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                </div>
            </div>
        </div>


</div>
<!-- Row in form END -->

<div class="row">
    <div class="col 6">
        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
    </div>
    <div class="col 6">
        <a href="?page=eng" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
