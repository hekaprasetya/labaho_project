<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['no_agenda'] == "" || $_REQUEST['divisi'] == "" || $_REQUEST['kode'] == "" || $_REQUEST['indeks'] == "" || $_REQUEST['status'] == "" || $_REQUEST['keterangan'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_agenda = $_REQUEST['no_agenda'];
            $divisi = ($_REQUEST['divisi']);
            sort($divisi);
            $jumlah_divisi = count($divisi);

            $tgl_surat  = $_REQUEST['tgl_surat'];
            $asal_surat = $_REQUEST['asal_surat'];
            $isi        = $_REQUEST['isi'];
            $kode       = substr($_REQUEST['kode'], 0, 30);
            $nkode      = trim($kode);
            $kode_form  = $_REQUEST['kode_form'];
            $indeks     = $_REQUEST['indeks'];
            $status     = $_REQUEST['status'];
            $keterangan = $_REQUEST['keterangan'];
            $id_user    = $_SESSION['id_user'];



            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/surat_masuk/";

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
                        for ($x = 0; $x < $jumlah_divisi; $x++) {
                            $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_agenda,divisi,asal_surat,isi,kode,indeks,status,tgl_surat,
                                                            tgl_diterima,file,keterangan,kode_form,id_user)
                                                                VALUES('$no_agenda','$divisi[$x]','$asal_surat','$isi','$nkode','$indeks','$status','$tgl_surat',NOW(),'$nfile','$keterangan','$kode_form','$id_user')");
                        }

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=tsm");
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

                for ($x = 0; $x < $jumlah_divisi; $x++) {
                    $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_agenda,divisi,asal_surat,isi,kode,indeks,status,tgl_surat,
                                                    tgl_diterima,file,keterangan,kode_form,id_user)
                                                    VALUES('$no_agenda','$divisi[$x]','$asal_surat','$isi','$nkode','$indeks','$status','$tgl_surat',NOW(),'','$keterangan','$kode_form','$id_user')");
                }

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=tsm");
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
                            <li class="waves-effect waves-light"><a href="?page=tsm&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data PMK</a></li>
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
            <form class="col s12" method="POST" action="?page=tsm&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    // memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT kode_form, tgl_surat FROM tbl_surat_masuk ORDER BY id_surat DESC LIMIT 1");

                    // mengambil nilai no_form terbaru
                    $result = mysqli_fetch_assoc($sql);

                    if (!empty($result['kode_form']) && !empty($result['tgl_surat'])) {
                        $tanggal_terakhir = $result['tgl_surat'];
                        $tahun_terakhir = date("Y", strtotime($tanggal_terakhir));
                        $tahun_sekarang = date("Y");
                        // Periksa apakah input terakhir pada tahun yang sama
                        ($tahun_sekarang == $tahun_terakhir) ? $kode = $result['kode_form'] + 1 : $kode = 1;
                    } else {
                        $sql = mysqli_query($config, "SELECT no_agenda FROM tbl_surat_masuk");
                        ($result = mysqli_num_rows($sql)) != 0 ? $kode = $result + 1 : $kode = 1;
                    }
                    //mulai bikin kode
                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('Y-m');
                    $kode_jadi = "PMK/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_agenda'])) {
                        $no_agenda = $_SESSION['no_agenda'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_agenda . '</div>';
                        unset($_SESSION['no_agenda']);
                    }
                    ?>
                    <label for="no_agenda">No.Urut</label>
                    <input type="text" class="form-control" id="no_agenda" name="no_agenda" value="<?= $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="no_agenda" name="no_agenda" value="<?= $kode_jadi ?>">
                    <input type="hidden" class="form-control" id="kode_form" name="kode_form" value="<?= $kode ?>">
                </div>
                
                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">note</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT kode FROM tbl_surat_masuk");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $tahun = date('Y');
                    $kode_jadi = "FM.MRK.003";

                    if (isset($_SESSION['kode'])) {
                        $kode = $_SESSION['kode'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kode . '</div>';
                        unset($_SESSION['kode']);
                    }
                    ?>
                    <label for="kode">No.Form</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode_jadi ?>">
                </div>
                
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">event_available</i>
                    <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_surat'])) {
                        $keterangan = $_SESSION['tgl_surat'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_surat . '</div>';
                        unset($_SESSION['tgl_surat']);
                    }
                    ?>
                    <label for="tgl_surat">Tanggal Surat</label>
                </div>
                <!--div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">bookmark</i>
                    <input id="kode" type="text" class="validate" name="kode" required>
                <?php
                if (isset($_SESSION['kode'])) {
                    $kode = $_SESSION['kode'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kode . '</div>';
                    unset($_SESSION['kode']);
                }
                ?>
                    <label for="kode">Kode Klasifikasi</label>
                </div-->
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">place</i>
                    <input id="asal_surat" type="text" class="validate" name="asal_surat" required>
                    <?php
                    if (isset($_SESSION['asal_surat'])) {
                        $asal_surat = $_SESSION['asal_surat'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $asal_surat . '</div>';
                        unset($_SESSION['asal_surat']);
                    }
                    ?>
                    <label for="asal_surat">Lokasi / Lantai / Ruang</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="indeks" type="text" class="validate" name="indeks" required>
                    <?php
                    if (isset($_SESSION['indeks'])) {
                        $indeks = $_SESSION['indeks'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $indeks . '</div>';
                        unset($_SESSION['indeks']);
                    }
                    ?>
                    <label for="indeks">Nama Perusahaan</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">low_priority</i><label>Status PMK</label><br />
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="status" id="status" required>
                            <option value="Terbit">Terbit</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="keterangan" type="text" name="keterangan" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['keterangan'])) {
                        $keterangan = $_SESSION['keterangan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan . '</div>';
                        unset($_SESSION['keterangan']);
                    }
                    ?>
                    <label for="keterangan">Tanggal Pekerjaan Selesai</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">description</i>
                    <textarea id="isi" class="materialize-textarea validate" name="isi" required></textarea>
                    <?php
                    if (isset($_SESSION['isi'])) {
                        $isi = $_SESSION['isi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $isi . '</div>';
                        unset($_SESSION['isi']);
                    }
                    ?>
                    <label for="isi">Jenis Pekerjaan</label>
                </div>


                <div class="check-wrapper col s12">
                    <div>
                        <i class="material-icons prefix md-prefix">people</i>
                        <label for="divisi">Ditujukan Kepada</label>
                        <p>
                            <label for="divisi1">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Keuangan" id="divisi1" multiple />
                                <span>Keuangan</span>
                            </label>
                        </p>
                        <p>
                            <label for="divisi2">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Marketing" id="divisi2" multiple />
                                <span>Marketing</span>
                            </label>
                        </p>
                        <p>
                            <label for="divisi3">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Teknik" id="divisi3" multiple />
                                <span>Teknik</span>
                            </label>
                        </p>
                        <p>
                            <label for="divisi4">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Security" id="divisi4" multiple />
                                <span>Security</span>
                            </label>
                        </p>
                    </div>

                    <div>
                        <p>
                            <label for="divisi5">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Legal" id="divisi5" multiple />
                                <span>Legal</span>
                            </label>
                        </p>
                        <!--p>
                            <label for="divisi6">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Gudang" id="divisi6" multiple />
                                <span>Gudang</span>
                            </label>
                        </p-->
                        <p>
                            <label for="divisi7">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Busdev" id="divisi7" multiple />
                                <span>Busdev</span>
                            </label>
                        </p>
                        <p>
                            <label for="divisi8">
                                <input type="checkbox" class="filled-in" name="divisi[]" value="Facility" id="divisi8" multiple />
                                <span>Facility</span>
                            </label>
                        </p>
                    </div>
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
                <a href="?page=tsm" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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