<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_wo'] == "" || $_REQUEST['tgl_wo'] == "" || $_REQUEST['jenis_pekerjaan'] == "" || $_REQUEST['lokasi'] == "" || $_REQUEST['nama_perusahaan'] == "" || $_REQUEST['status'] == "" || $_REQUEST['tgl_selesai'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_engineering     = $_REQUEST['id_engineering'];
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

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $no_wo)) {
                $_SESSION['no_wo'] = 'Form Nomor Agenda harus diisi angka!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[0-9.-]*$/", $tgl_wo)) {
                    $_SESSION['etgl_wo'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $tgl_selesai)) {
                        $_SESSION['etgl_selesai'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

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
                                if ($ukuran < 2300000) {

                                    $id_engineering = $_REQUEST['id_engineering'];
                                    $query = mysqli_query($config, "SELECT file FROM tbl_engineering WHERE id_engineering='$id_engineering'");
                                    list($file) = mysqli_fetch_array($query);

                                    //jika file tidak kosong akan mengeksekusi script dibawah ini
                                    if (!empty($file)) {
                                        unlink($target_dir . $file);

                                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                        $query = mysqli_query($config, "UPDATE tbl_engineering SET no_wo='$no_wo', tgl_wo='$tgl_wo',jenis_pekerjaan='$jenis_pekerjaan',file='$nfile',lokasi='$lokasi',nama_perusahaan='$nama_perusahaan',penyebab='$penyebab',solusi='$solusi',status='$status',tgl_selesai='$tgl_selesai',id_user='$id_user' WHERE id_engineering='$id_engineering'");

                                        if ($query == true) {
                                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                            header("Location: ./admin.php?page=eng");
                                            die();
                                        } else {
                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        }
                                    } else {

                                        //jika file kosong akan mengeksekusi script dibawah ini
                                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                        $query = mysqli_query($config, "UPDATE tbl_engineering SET no_wo='$no_wo', tgl_wo='$tgl_wo',jenis_pekerjaan='$jenis_pekerjaan',file='$nfile',lokasi='$lokasi',nama_perusahaan='$nama_perusahaan',penyebab='$penyebab',solusi='$solusi',status='$status',tgl_selesai='$tgl_selesai',id_user='$id_user' WHERE id_engineering='$id_engineering'");

                                        if ($query == true) {
                                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                            header("Location: ./admin.php?page=eng");
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
                            $id_engineering = $_REQUEST['id_engineering'];

                            $query = mysqli_query($config, "UPDATE tbl_engineering SET no_wo='$no_wo', tgl_wo='$tgl_wo',jenis_pekerjaan='$jenis_pekerjaan',lokasi='$lokasi',nama_perusahaan='$nama_perusahaan',penyebab='$penyebab',solusi='$solusi',status='$status',tgl_selesai='$tgl_selesai',id_user='$id_user' WHERE id_engineering='$id_engineering'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=eng");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        }
                    }
                }
            }
                    }
                } else {

                    $id_engineering = mysqli_real_escape_string($config, $_REQUEST['id_engineering']);
                    $query = mysqli_query($config, "SELECT id_engineering, no_wo, tgl_wo, jenis_pekerjaan, file, lokasi, nama_perusahaan, penyebab, solusi, status, tgl_selesai, id_user FROM tbl_engineering WHERE id_engineering='$id_engineering'");
                    list($id_engineering, $no_wo, $tgl_wo, $jenis_pekerjaan, $file, $lokasi, $nama_perusahaan, $penyebab, $solusi, $status, $tgl_selesai, $id_user) = mysqli_fetch_array($query);

                    if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
                        echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href="./admin.php?page=eng";
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
                            <form class="col s12" method="POST" action="?page=eng&act=edit" enctype="multipart/form-data">

                                <!-- Row in form START -->
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="hidden" name="id_engineering" value="<?php echo $id_engineering; ?>">
                                        <i class="material-icons prefix md-prefix">looks_one</i>
                                        <input id="no_wo" type="text" class="validate" value="<?php echo $no_wo; ?>" name="no_wo">
                                        <?php
                                        if (isset($_SESSION['eno_wo'])) {
                                            $eno_wo = $_SESSION['eno_wo'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_wo . '</div>';
                                            unset($_SESSION['eno_wo']);
                                        }
                                        ?>
                                        <label for="eno_wo">No.WO</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">schedule</i>
                                        <input id="tgl_wo" type="text" class="validate" name="tgl_wo" value="<?php echo $tgl_wo; ?>" required>
                                        <?php
                                        if (isset($_SESSION['etgl_wo'])) {
                                            $etgl_wo = $_SESSION['etgl_wo'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etgl_wo . '</div>';
                                            unset($_SESSION['etgl_wo']);
                                        }
                                        ?>
                                        <label for="etgl_wo">Tgl.WO</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">build</i>
                                        <input id="jenis_pekerjaan" type="text" class="validate" name="jenis_pekerjaan" value="<?php echo $jenis_pekerjaan; ?>" required>
                                        <?php
                                        if (isset($_SESSION['ejenis_pekerjaan'])) {
                                            $ejenis_pekerjaan = $_SESSION['ejenis_pekerjaan'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ejenis_pekerjaan . '</div>';
                                            unset($_SESSION['ejenis_pekerjaan']);
                                        }
                                        ?>
                                        <label for="ejenis_pekerjaan">Jenis Pekerjaan</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">location_on</i>
                                        <input id="lokasi" type="text" class="validate" name="lokasi" value="<?php echo $lokasi; ?>" required>
                                        <?php
                                        if (isset($_SESSION['elokasi'])) {
                                            $elokasi = $_SESSION['elokasi'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $elokasi . '</div>';
                                            unset($_SESSION['elokasi']);
                                        }
                                        ?>
                                        <label for="elokasi">Lokasi</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">home</i>
                                        <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan" value="<?php echo $nama_perusahaan; ?>" required>
                                        <?php
                                        if (isset($_SESSION['enama_perusahaan'])) {
                                            $enama_perusahaan = $_SESSION['enama_perusahaan'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_perusahaan . '</div>';
                                            unset($_SESSION['enama_perusahaan']);
                                        }
                                        ?>
                                        <label for="enama_perusahaan">Nama Perusahaan</label>
                                    </div>
                                    
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">adb</i>
                                        <input id="penyebab" type="text" class="validate" name="penyebab" value="<?php echo $penyebab; ?>">
                                        <?php
                                        if (isset($_SESSION['epenyebab'])) {
                                            $epenyebab = $_SESSION['epenyebab'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epenyebab . '</div>';
                                            unset($_SESSION['epenyebab']);
                                        }
                                        ?>
                                        <label for="epenyebab">Penyebab</label>
                                    </div>
                                    
                                     <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">assignment_turned_in</i>
                                        <input id="solusi" type="text" class="validate" name="solusi" value="<?php echo $solusi; ?>">
                                        <?php
                                        if (isset($_SESSION['esolusi'])) {
                                            $esolusi = $_SESSION['esolusi'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $esolusi . '</div>';
                                            unset($_SESSION['esolusi']);
                                        }
                                        ?>
                                        <label for="esolusi">Solusi</label>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s6">
                                            <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                            <div class="input-field col s11 right">
                                                <select class="browser-default validate" name="status" id="status">
                                                    <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                                    <option value="Progres">Progres</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Material kosong">Material kosong</option>
                                                    <option value="Selesai">Selesai</option>
                                                </select>
                                            </div>


                                            <?php
                                            if (isset($_SESSION['status'])) {
                                                $status = $_SESSION['status'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status . '</div>';
                                                unset($_SESSION['status']);
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">schedule</i>
                                        <input id="tgl_selesai" type="text" class="datepicker" name="tgl_selesai" value="<?php echo $tgl_selesai; ?>" required>
                                        <?php
                                        if (isset($_SESSION['etgl_selesai'])) {
                                            $etgl_selesai = $_SESSION['etgl_selesai'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etgl_selesai . '</div>';
                                            unset($_SESSION['etgl_selesai']);
                                        }
                                        ?>
                                        <label for="etgl_selesai">Tgl.Selesai</label>
                                    </div>


                                </div>

                                <div class="input-field col s6">
                                    <div class="file-field input-field">
                                        <div class="btn light-green darken-1">
                                            <span>File</span>
                                            <input type="file" id="file" name="file">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/engineering">
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
            }
            ?>
