<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_wo_fc'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_wo_fc              = $_REQUEST['no_wo_fc'];
            $tgl_wo_fc             = $_REQUEST['tgl_wo_fc'];
            $jenis_pekerjaan_fc    = $_REQUEST['jenis_pekerjaan_fc'];
            $lokasi_fc             = $_REQUEST['lokasi_fc'];
            $perusahaan_fc         = $_REQUEST['perusahaan_fc'];
            $penyebab_fc           = $_REQUEST['penyebab_fc'];
            $tindakan_fc           = $_REQUEST['tindakan_fc'];
            $status_fc             = $_REQUEST['status_fc'];
            $tgl_selesai_fc        = $_REQUEST['tgl_selesai_fc'];
            $pelaksana_fc          = $_REQUEST['pelaksana_fc'];
            $divisi_fc             = $_REQUEST['divisi_fc'];
            $id_user               = $_SESSION['id_user'];




            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/facility/";

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

                        $query = mysqli_query($config, "INSERT INTO tbl_facility(no_wo_fc,tgl_wo_fc,jenis_pekerjaan_fc,file,lokasi_fc,perusahaan_fc,penyebab_fc,tindakan_fc,status_fc,tgl_selesai_fc,pelaksana_fc,divisi_fc,id_user)
                                                                        VALUES('$no_wo_fc','$tgl_wo_fc','$jenis_pekerjaan_fc','$nfile','$lokasi_fc','$perusahaan_fc','$penyebab_fc','$tindakan_fc','$status_fc','$tgl_selesai_fc','$pelaksana_fc','$divisi_fc','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=facility");
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
                $query = mysqli_query($config, "INSERT INTO tbl_facility(no_wo_fc,tgl_wo_fc,jenis_pekerjaan_fc,file,lokasi_fc,perusahaan_fc,penyebab_fc,tindakan_fc,status_fc,tgl_selesai_fc,pelaksana_fc,divisi_fc,id_user)
                                                                        VALUES('$no_wo_fc','$tgl_wo_fc','$jenis_pekerjaan_fc','$nfile','$lokasi_fc','$perusahaan_fc','$penyebab_fc','$tindakan_fc','$status_fc','$tgl_selesai_fc','$pelaksana_fc','$divisi_fc','$id_user')");


                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=facility");
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
                    <li class="waves-effect waves-light"><a href="?page=facility&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data</a></li>
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
    <form class="col s12" method="POST" action="?page=facility&act=add" enctype="multipart/form-data">

        <!-- Row in form START -->
        <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">looks_one</i>
            <?php
            //memulai mengambil datanya
            $sql = mysqli_query($config, "SELECT no_wo_fc FROM tbl_facility");


            $result = mysqli_num_rows($sql);

            if ($result <> 0) {
                $kode = $result + 1;
            } else {
                $kode = 1;
            }

            //mulai bikin kode
            $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
            $tahun = date('m-Y');
            $kode_jadi = "WO/$tahun/$bikin_kode";

            if (isset($_SESSION['no_wo'])) {
                $no_wo = $_SESSION['no_wo'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_wo_fc . '</div>';
                unset($_SESSION['no_wo_fc']);
            }
            ?>
            <label for="no_wo_fc">No.WO</label>
            <input type="text" class="form-control" id="no_wo_fc" name="no_wo_fc"  value="<?php echo $kode_jadi ?>"disabled>
            <input type="hidden" class="form-control" id="no_wo_fc" name="no_wo_fc"  value="<?php echo $kode_jadi ?>" >
        </div>
        
         <div class="input-field col s6">
            <i class="material-icons prefix md-prefix">date_range</i>
            <input id="tgl_wo_fc" type="text" name="tgl_wo_fc" class="datepicker" required>
            <?php
            if (isset($_SESSION['tgl_wo_fc'])) {
                $tgl_wo_fc = $_SESSION['tgl_wo_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_wo_fc . '</div>';
                unset($_SESSION['tgl_wo_fc']);
            }
            ?>
            <label for="tgl_wo_fc">Tgl.WO</label>
        </div>

        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">build</i>
            <input id="jenis_pekerjaan_fc" type="text" class="validate" name="jenis_pekerjaan_fc" required>
            <?php
            if (isset($_SESSION['jenis_pekerjaan_fc'])) {
                $jenis_pekerjaan_fc = $_SESSION['jenis_pekerjaan_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jenis_pekerjaan_fc . '</div>';
                unset($_SESSION['jenis_pekerjaan_fc']);
            }
            ?>
            <label for="jenis_pekerjaan_fc">Jenis Pekerjaan</label>
        </div>
        
        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">place</i>
            <input id="lokasi_fc" type="text" class="validate" name="lokasi_fc" required>
            <?php
            if (isset($_SESSION['lokasi_fc'])) {
                $lokasi_fc = $_SESSION['lokasi_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi_fc . '</div>';
                unset($_SESSION['lokasi_fc']);
            }
            ?>
            <label for="lokasi_fc">Lokasi</label>
        </div>
        
        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">home</i>
            <input id="perusahaan_fc" type="text" class="validate" name="perusahaan_fc" required>
            <?php
            if (isset($_SESSION['perusahaan_fc'])) {
                $perusahaan_fc = $_SESSION['perusahaan_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $perusahaan_fc . '</div>';
                unset($_SESSION['perusahaan_fc']);
            }
            ?>
            <label for="perusahaan_fc">Nama Perusahaan</label>
        </div>
        
        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">adb</i>
            <input id="penyebab_fc" type="text" class="validate" name="penyebab_fc">
            <?php
            if (isset($_SESSION['penyebab_fc'])) {
                $penyebab_fc = $_SESSION['penyebab_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $penyebab_fc . '</div>';
                unset($_SESSION['penyebab_fc']);
            }
            ?>
            <label for="penyebab_fc">Penyebab</label>
        </div>
        
          <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">assignment_turned_in</i>
            <input id="tindakan_fc" type="text" class="validate" name="tindakan_fc">
            <?php
            if (isset($_SESSION['tindakan_fc'])) {
                $tindakan_fc = $_SESSION['tindakan_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tindakan_fc . '</div>';
                unset($_SESSION['tindakan_fc']);
            }
            ?>
            <label for="tindakan_fc">Tindakan</label>
        </div>
        
        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">low_priority</i><label>Status Pekerjaan</label><br/>
            <div class="input-field col s11 right">
                <select class="browser-default validate" name="status_fc" id="status_fc" required>
                    <option value="Progres">Progres</option>
                    <option value="Pending">Pending</option>
                    <option value="Material kosong">Material kosong</option>
                    <option value="Material kosong">Selesai</option>
                </select>
            </div>
        </div>
        
        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">date_range</i>
            <input id="tgl_selesai_fc" type="text" name="tgl_selesai_fc" class="datepicker" required>
            <?php
            if (isset($_SESSION['tgl_selesai_fc'])) {
                $tgl_selesai_fc = $_SESSION['tgl_selesai_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_selesai_fc . '</div>';
                unset($_SESSION['tgl_selesai_fc']);
            }
            ?>
            <label for="tgl_selesai_fc">Tanggal Selesai</label>
        </div>

        <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">account_circle</i>
            <input id="pelaksana_fc" type="text" class="validate" name="pelaksana_fc">
            <?php
            if (isset($_SESSION['pelaksana_fc'])) {
                $pelaksana_fc = $_SESSION['pelaksana_fc'];
                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pelaksana_fc . '</div>';
                unset($_SESSION['pelaksana_fc']);
            }
            ?>
            <label for="pelaksana_fc">Pelaksana</label>
        </div>

          <div class="input-field col s9">
            <i class="material-icons prefix md-prefix">people</i><label>Divisi</label><br/>
            <div class="input-field col s11 right">
                <select class="browser-default validate" name="divisi_fc" id="divisi_fc" required>
                     <option value="Housekeeping">Housekeeping</option>
                            <option value="Parkir">Parkir</option>
                            <option value="Security">Security</option>
                            <option value="Kepala Departemen">Kepala Departemen</option>
                </select>
            </div>
        </div>
        
        <div class="input-field col s9">
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
        <a href="?page=facility" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
