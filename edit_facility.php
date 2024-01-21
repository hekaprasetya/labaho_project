<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_wo_fc'] == "" || $_REQUEST['tgl_wo_fc'] == "" || $_REQUEST['jenis_pekerjaan_fc'] == "" || $_REQUEST['lokasi_fc'] == "" || $_REQUEST['perusahaan_fc'] == "" || $_REQUEST['status_fc'] == "" || $_REQUEST['tgl_selesai_fc'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_facillity = $_REQUEST['id_facility'];
            $no_wo_fc = $_REQUEST['no_wo_fc'];
            $tgl_wo_fc = $_REQUEST['tgl_wo_fc'];
            $jenis_pekerjaan_fc = $_REQUEST['jenis_pekerjaan_fc'];
            $lokasi_fc = $_REQUEST['lokasi_fc'];
            $perusahaan_fc = $_REQUEST['perusahaan_fc'];
            $penyebab_fc = $_REQUEST['penyebab_fc'];
            $tindakan_fc = $_REQUEST['tindakan_fc'];
            $status_fc = $_REQUEST['status_fc'];
            $tgl_selesai_fc = $_REQUEST['tgl_selesai_fc'];
            $pelaksana_fc = $_REQUEST['pelaksana_fc'];
            $divisi_fc = $_REQUEST['divisi_fc'];
            $id_user = $_SESSION['id_user'];

            //validasi input data

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
                    if ($ukuran < 2300000) {

                        $id_facility = $_REQUEST['id_facility'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_facility WHERE id_facility='$id_facility'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_facility SET no_wo_fc='$no_wo_fc',tgl_wo_fc='$tgl_wo_fc',jenis_pekerjaan_fc='$jenis_pekerjaan_fc',file='$nfile',lokasi_fc='$lokasi_fc',perusahaan_fc='$perusahaan_fc',penyebab_fc='$penyebab_fc',tindakan_fc='$tindakan_fc',status_fc='$status_fc',tgl_selesai_fc='$tgl_selesai_fc',pelaksana_fc='$pelaksana_fc',divisi_fc='$divisi_fc',id_user='$id_user' WHERE id_facility='$id_facility'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=facility");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {


                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_facility SET no_wo_fc='$no_wo_fc', tgl_wo_fc='$tgl_wo_fc',jenis_pekerjaan_fc='$jenis_pekerjaan_fc',file='$nfile',lokasi_fc='$lokasi_fc',perusahaan_fc='$perusahaan_fc',penyebab_fc='$penyebab_fc',tindakan_fc='$tindakan_fc',status_fc='$status_fc',tgl_selesai_fc='$tgl_selesai_fc',pelaksana_fc='$pelaksana_fc',divisi_fc='$divisi_fc',id_user='$id_user' WHERE id_facility='$id_facility'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=facility");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
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
                $id_facility = $_REQUEST['id_facility'];

                $query = mysqli_query($config, "UPDATE tbl_facility SET no_wo_fc='$no_wo_fc', tgl_wo_fc='$tgl_wo_fc',jenis_pekerjaan_fc='$jenis_pekerjaan_fc',lokasi_fc='$lokasi_fc',perusahaan_fc='$perusahaan_fc',penyebab_fc='$penyebab_fc',tindakan_fc='$tindakan_fc',status_fc='$status_fc',tgl_selesai_fc='$tgl_selesai_fc',pelaksana_fc='$pelaksana_fc',divisi_fc='$divisi_fc',id_user='$id_user' WHERE id_facility='$id_facility'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=facility");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
} else {

$id_facility = mysqli_real_escape_string($config, $_REQUEST['id_facility']);
$query = mysqli_query($config, "SELECT id_facility, no_wo_fc, tgl_wo_fc, jenis_pekerjaan_fc, file, lokasi_fc, perusahaan_fc, penyebab_fc, tindakan_fc, status_fc, tgl_selesai_fc, pelaksana_fc, divisi_fc, id_user FROM tbl_facility WHERE id_facility='$id_facility'");
list($id_facility, $no_wo_fc, $tgl_wo_fc, $jenis_pekerjaan_fc, $nfile, $lokasi_fc, $perusahaan_fc, $penyebab_fc, $tindakan_fc, $status_fc, $tgl_selesai_fc, $pelaksana_fc, $divisi_fc, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href = "./admin.php?page=facility";
</script>';
} else {
?>

<!-- Row Start -->
<div class="row">
    <!-- Secondary Nav START -->
    <div class="col s12">
        <nav class="secondary-nav">
            <div class="nav-wrapper blue-grey darken-1">
                <ul class="left">
                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Data</a></li>
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
    <form class="col s12" method="POST" action="?page=facility&act=edit" enctype="multipart/form-data">

        <!-- Row in form START -->
        <div class="row">
            <div class="input-field col s6">
                <input type="hidden" name="id_facility" value="<?php echo $id_facility; ?>">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <input id="no_wo_fc" type="text" class="validate" value="<?php echo $no_wo_fc; ?>" name="no_wo_fc">
                <?php
                if (isset($_SESSION['eno_wo_fc'])) {
                    $eno_wo_fc = $_SESSION['eno_wo_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_wo_fc . '</div>';
                    unset($_SESSION['eno_wo_fc']);
                }
                ?>
                <label for="eno_wo_fc">No.WO</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">schedule</i>
                <input id="tgl_wo_fc" type="text" class="datepicker" name="tgl_wo_fc" value="<?php echo $tgl_wo_fc; ?>" required>
                <?php
                if (isset($_SESSION['tgl_wo_fc'])) {
                    $tgl_wo_fc = $_SESSION['tgl_wo_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_wo_fc . '</div>';
                    unset($_SESSION['tgl_wo_fc']);
                }
                ?>
                <label for="tgl_wo_fc">Tgl.WO</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">build</i>
                <input id="jenis_pekerjaan_fc" type="text" class="validate" name="jenis_pekerjaan_fc" value="<?php echo $jenis_pekerjaan_fc; ?>" required>
                <?php
                if (isset($_SESSION['ejenis_pekerjaan_fc'])) {
                    $ejenis_pekerjaan_fc = $_SESSION['ejenis_pekerjaan_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ejenis_pekerjaan_fc . '</div>';
                    unset($_SESSION['ejenis_pekerjaan_fc']);
                }
                ?>
                <label for="ejenis_pekerjaan">Jenis Pekerjaan</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">location_on</i>
                <input id="lokasi_fc" type="text" class="validate" name="lokasi_fc" value="<?php echo $lokasi_fc; ?>" required>
                <?php
                if (isset($_SESSION['elokasi_fc'])) {
                    $elokasi_fc = $_SESSION['elokasi_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $elokasi_fc . '</div>';
                    unset($_SESSION['elokasi_fc']);
                }
                ?>
                <label for="elokasi_fc">Lokasi</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">home</i>
                <input id="perusahaan_fc" type="text" class="validate" name="perusahaan_fc" value="<?php echo $perusahaan_fc; ?>" required>
                <?php
                if (isset($_SESSION['enama_perusahaan_fc'])) {
                    $enama_perusahaan_fc = $_SESSION['enama_perusahaan_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_perusahaan_fc . '</div>';
                    unset($_SESSION['enama_perusahaan_fc']);
                }
                ?>
                <label for="enama_perusahaan_fc">Nama Perusahaan</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">adb</i>
                <input id="penyebab_fc" type="text" class="validate" name="penyebab_fc" value="<?php echo $penyebab_fc; ?>" required>
                <?php
                if (isset($_SESSION['epenyebab_fc'])) {
                    $epenyebab_fc = $_SESSION['epenyebab_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epenyebab_fc . '</div>';
                    unset($_SESSION['epenyebab_fc']);
                }
                ?>
                <label for="epenyebab_fc">Penyebab</label>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">assignment_turned_in</i>
                <input id="tindakan_fc" type="text" class="validate" name="tindakan_fc" value="<?php echo $tindakan_fc; ?>" required>
                <?php
                if (isset($_SESSION['etindakan_fc'])) {
                    $etindakan_fc = $_SESSION['etindakan_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etindakan_fc . '</div>';
                    unset($_SESSION['etindakan_fc']);
                }
                ?>
                <label for="etindakan_fc">Tindakan</label>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="status_fc" id="status_fc">
                            <option value="<?php echo $status_fc; ?>"><?php echo $status_fc; ?></option>
                            <option value="Progres">Progres</option>
                            <option value="Pending">Pending</option>
                            <option value="Material kosong">Material kosong</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>


                    <?php
                    if (isset($_SESSION['status_fc'])) {
                        $status_fc = $_SESSION['status_fc'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status_fc . '</div>';
                        unset($_SESSION['status_fc']);
                    }
                    ?>
                </div>
            </div>

            <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">date_range</i>
                <input id="tgl_selesai_fc" type="text" class="datepicker" name="tgl_selesai_fc" value="<?php echo $tgl_selesai_fc; ?>" required>
                <?php
                if (isset($_SESSION['tgl_selesai_fc'])) {
                    $tgl_selesai_fc = $_SESSION['tgl_selesai_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_selesai_fc . '</div>';
                    unset($_SESSION['tgl_selesai_fc']);
                }
                ?>
                <label for="tgl_selesai_fc">Tgl.Selesai</label>
            </div>
            
             <div class="input-field col s6">
                <i class="material-icons prefix md-prefix">account_circle</i>
                <input id="pelaksana_fc" type="text" class="validate" name="pelaksana_fc" value="<?php echo $pelaksana_fc; ?>" required>
                <?php
                if (isset($_SESSION['epelaksana_fc'])) {
                    $epelaksana_fc = $_SESSION['epelaksana_fc'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epelaksana_fc . '</div>';
                    unset($_SESSION['epelaksana_fc']);
                }
                ?>
                <label for="epelaksana_fc">Pelaksana</label>
            </div>

             <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">people</i><label>Status</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="divisi_fc" id="divisi_fc">
                            <option value="<?php echo $divisi_fc; ?>"><?php echo $divisi_fc; ?></option>
                            <option value="Housekeeping">Housekeeping</option>
                            <option value="Parkir">Parkir</option>
                            <option value="Security">Security</option>
                            <option value="Kepala Departemen">Kepala Departemen</option>
                        </select>
                    </div>

                    <?php
                    if (isset($_SESSION['divisi_fc'])) {
                        $divisi_fc = $_SESSION['divisi_fc'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi_fc . '</div>';
                        unset($_SESSION['divisi_fc']);
                    }
                    ?>
                </div>
            </div>

        </div>

        <div class="input-field col s6">
                <div class="file-field input-field">
                    <div class="btn light-green darken-1">
                        <span>File</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar">
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
        <a href="?page=facility" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
    </div>
</div>

</form>
<!-- Form END -->

</div>
<!-- Row form END -->

<?php
}
}
}
?>
