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

            $no_lapor = $_REQUEST['no_lapor'];
            $divisi = $_REQUEST['divisi'];
            $jenis_komplain = $_REQUEST['jenis_komplain'];
            $pemberi_komplain = $_REQUEST['pemberi_komplain'];
            $aksi_komplain = $_REQUEST['aksi_komplain'];
            $pekerjaan = $_REQUEST['pekerjaan'];
            $lokasi = $_REQUEST['lokasi'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/lapor/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 7000000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_lapor(no_lapor,divisi,jenis_komplain,pemberi_komplain,aksi_komplain,pekerjaan,lokasi,file,id_user)
                                                                        VALUES('$no_lapor','$divisi','$jenis_komplain','$pemberi_komplain','$aksi_komplain','$pekerjaan','$lokasi','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=lapor");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan penulisan huruf';
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
                $query = mysqli_query($config, "INSERT INTO tbl_lapor(no_lapor,divisi,jenis_komplain,pemberi_komplain,aksi_komplain,pekerjaan,lokasi,file,id_user)
                                                                        VALUES('$no_lapor','$divisi','$jenis_komplain','$pemberi_komplain','$aksi_komplain','$pekerjaan','$lokasi','','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=lapor");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan penulisan huruf';
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
                            <li class="waves-effect waves-light"><a href="?page=lapor&act=add" class="judul"><i class="material-icons">mail</i>Tambah Data</a></li>
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
            <form class="col s12" method="POST" action="?page=lapor&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_lapor FROM tbl_lapor");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('m-Y');
                    $kode_jadi = "LP/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_lapor'])) {
                        $no_lapor = $_SESSION['no_lapor'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_lapor . '</div>';
                        unset($_SESSION['no_lapor']);
                    }
                    ?>
                    <label for="no_lapor">No.Lapor</label>
                    <input type="text" class="form-control" id="no_agenda" name="no_lapor"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_agenda" name="no_lapor"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">assignment_ind</i><label>Divisi</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="divisi" id="divisi" required>
                            <option value="Housekeeping (HKP, IPM, GDL, Taman)">Housekeeping (HKP, IPM, GDL, Taman)</option>
                            <option value="Parkir">Parkir</option>
                            <option value="Security">Security</option>
                            <option value="Kepala Departemen">Kepala Departemen</option>
                        </select>
                    </div>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">bug_report</i><label>Jenis Komplain</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="jenis_komplain" id="jenis_komplain" required>
                            <option value="Kebersihan (utilitas/fasilitas kotor)">Kebersihan (utilitas/fasilitas kotor)</option>
                            <option value="Serangga/Pest">Serangga/Pest</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Penerimaan Paket/Dokumen">Penerimaan Paket/Dokumen</option>
                            <option value="Parkir (admin)">Parkir (admin)</option>
                            <option value="Parkir (Lapangan)">Parkir (Lapangan)</option>
                            <option value="Kerusakan">Kerusakan</option>
                        </select>
                    </div>
                </div>
                
                 <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">group_add</i><label>Pemberi Komplain</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="pemberi_komplain" id="pemberi_komplain" required>
                            <option value="Manajemen Graha Pena">Manajemen Graha Pena</option>
                            <option value="Departemen Teknik">Departemen Teknik</option>
                            <option value="Penyewa/Tenant/Pengunjung">Penyewa/Tenant/Pengunjung</option>
                            <option value="Diri sendiri">Diri sendiri</option>
                        </select>
                    </div>
                </div>
                
                 <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">record_voice_over</i><label>Aksi Komplain</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="aksi_komplain" id="aksi_komplain" required>
                            <option value="Terselesaikan (Tuntas)">Terselesaikan (Tuntas)</option>
                            <option value="Dalam Penanganan (Karena pekerjaan bertahap)">Dalam Penanganan (Karena pekerjaan bertahap)</option>
                            <option value="Dilimpahkan ke Departemen lain (Non Facility)">Dilimpahkan ke Departemen lain (Non Facility)</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">build</i>
                    <textarea id="pekerjaan" class="materialize-textarea validate" name="pekerjaan" required></textarea>
                    <?php
                    if (isset($_SESSION['pekerjaan'])) {
                        $pekerjaan = $_SESSION['pekerjaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pekerjaan . '</div>';
                        unset($_SESSION['pekerjaan']);
                    }
                    ?>
                    <label for="pekerjaan">Informasi/Pekerjaan yang dikerjakan</label>
                </div>
                
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">room</i>
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

                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>Foto</span>
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
                <a href="?page=lapor" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
