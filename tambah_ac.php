<?php
//cek session
if (empty($_SESSION['admin']) || empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['nama_ac']) || empty($_REQUEST['kode_form']) || empty($_SESSION['id_user'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $no_form = $_REQUEST['no_form'];
            $kode_form = $_REQUEST['kode_form'];
            $nama_ac = $_REQUEST['nama_ac'];
            $cuci_unit = $_REQUEST['cuci_unit'];
            $kondisi_kompressor = $_REQUEST['kompressor'];
            $kondisi_outdoor = $_REQUEST['outdoor'];
            $kondisi_indoor = $_REQUEST['indoor'];
            $arus_ac = $_REQUEST['arus_ac'];
            $isi_freon = $_REQUEST['isi_freon'];
            $lain = $_REQUEST['lain'];
            $id_user = $_SESSION['id_user'];

            $qer = mysqli_query($conn, "SELECT id_utility FROM master_utility WHERE nama_utility = '$nama_ac'");
            $gg = $qer->fetch_assoc();
            $id_utility = $gg['id_utility'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/ac/";

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if (!empty($file)) {

                $nfile = uniqid() . "-" . $file;
                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 10000000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO utility_ac (no_form, kode_form,nama_ac,cuci_unit,kondisi_kompressor,kondisi_outdoor,kondisi_indoor,arus_ac,isi_freon,lain,file,id_utility,id_user)
                        VALUES('$no_form', '$kode_form','$nama_ac','$cuci_unit','$kondisi_kompressor','$kondisi_outdoor','$kondisi_indoor','$arus_ac','$isi_freon','$lain','$nfile','$id_utility','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=ac");
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
                $query = mysqli_query($config, "INSERT INTO utility_ac (no_form, kode_form,nama_ac,cuci_unit,kondisi_kompressor,kondisi_outdoor,kondisi_indoor,arus_ac,isi_freon,lain,file,id_utility,id_user)
                VALUES('$no_form', '$kode_form','$nama_ac','$cuci_unit','$kondisi_kompressor','$kondisi_outdoor','$kondisi_indoor','$arus_ac','$isi_freon','$lain','$file','$id_utility','$id_user')");

                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=ac");
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
            <div class="z-depth-1">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue darken-2">
                        <div class="col m7">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Tambah Maintenance Air Conditioner</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Secondary Nav END -->
    </div>
    <!-- Row END -->

    <?php
    if (isset($_SESSION['succAdd'])) {
        $succAdd = $_SESSION['succAdd'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succAdd']);
    }
    if (isset($_SESSION['succEdit'])) {
        $succEdit = $_SESSION['succEdit'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succEdit']);
    }
    if (isset($_SESSION['succDel'])) {
        $succDel = $_SESSION['succDel'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succDel']);
    }
    ?>
    <!-- Row form Start -->
    <div class="row jarak-form">

        <!-- Form START -->
        <form class="col s12" method="post" action="?page=ac&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    // memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT kode_form, tgl_ac FROM utility_ac ORDER BY id_ac DESC LIMIT 1");

                    // mengambil nilai no_form terbaru
                    $result = mysqli_fetch_assoc($sql);

                    if (!empty($result['kode_form']) && !empty($result['tgl_ac'])) {
                        $tanggal_terakhir = $result['tgl_ac'];
                        $tahun_terakhir = date("Y", strtotime($tanggal_terakhir));
                        $tahun_sekarang = date("Y");
                        // Periksa apakah input terakhir pada tahun yang sama
                        ($tahun_sekarang == $tahun_terakhir) ? $kode = $result['kode_form'] + 1 :  $kode = 1;
                    } else {
                        $sql = mysqli_query($config, "SELECT no_form FROM utility_ac");
                        ($result = mysqli_num_rows($sql)) != 0 ?  $kode = $result + 1 :  $kode = 1;
                    }
                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    // $tahun = date('Y-m');
                    $kode_jadi = "PM/AC/$bikin_kode";

                    if (isset($_SESSION['no_form'])) {
                        $no_form = $_SESSION['no_form'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form . '</div>';
                        unset($_SESSION['no_form']);
                    }
                    ?>
                    <label for="no_form"><strong>No.Form</strong></label>
                    <input type="text" class="form-control" id="no_form" name="no_form" value="<?= $kode_jadi ?>" disabled>
                    <input type="hidden" class="form-control" id="no_form" name="no_form" value="<?= $kode_jadi ?>">
                    <input type="hidden" class="form-control" id="kode_form" name="kode_form" value="<?= $kode ?>">
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">ac_unit</i><label for="nama_ac">Nama Utility</label><br />
                    <div class="input-field col s11 right">
                        <select name="nama_ac" class="browser-default validate theSelect" id="nama_ac" required>
                            <option value="" disabled selected>Pilih AC</option>
                            <?php

                            // Perintah SQL untuk menampilkan data dengan nama_utility "ac" atau "SDP"
                            $sql = "SELECT * FROM master_utility WHERE nama_utility LIKE '%pk%' ORDER BY id_utility ASC";


                            $hasil = mysqli_query($config, $sql);
                            while ($data = mysqli_fetch_array($hasil)) {
                            ?>
                                <option value="<?= htmlspecialchars($data['nama_utility']); ?>"><?= htmlspecialchars($data['nama_utility']); ?></option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>


                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">brush</i>
                    <input id="cuci_unit" type="text" name="cuci_unit" class="validate" required>
                    <?php
                    if (isset($_SESSION['cuci_unit'])) {
                        $cuci_unit = $_SESSION['cuci_unit'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $cuci_unit ?></div>
                    <?php
                        unset($_SESSION['cuci_unit']);
                    }
                    ?>
                    <label for="cuci_unit">Cuci Unit</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">settings_input_composite</i>
                    <input id="kompressor" type="text" name="kompressor" class="validate" required>
                    <?php
                    if (isset($_SESSION['kompressor'])) {
                        $kompressor = $_SESSION['kompressor'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $kompressor ?></div>
                    <?php
                        unset($_SESSION['kompressor']);
                    }
                    ?>
                    <label for="kompressor">Kondisi Kompressor</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">nature_people</i>
                    <input id="outdoor" type="text" name="outdoor" class="validate" required>
                    <?php
                    if (isset($_SESSION['outdoor'])) {
                        $outdoor = $_SESSION['outdoor'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $outdoor ?></div>
                    <?php
                        unset($_SESSION['outdoor']);
                    }
                    ?>
                    <label for="outdoor">Kondisi Outdoor</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">room</i>
                    <input id="indoor" type="text" name="indoor" class="validate" required>
                    <?php
                    if (isset($_SESSION['indoor'])) {
                        $indoor = $_SESSION['indoor'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $indoor ?></div>
                    <?php
                        unset($_SESSION['indoor']);
                    }
                    ?>
                    <label for="indoor">Kondisi Indoor</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">power_input</i>
                    <input id="arus_ac" type="text" name="arus_ac" class="validate" required>
                    <?php
                    if (isset($_SESSION['v'])) {
                        $arus_ac = $_SESSION['arus_ac'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $arus_ac ?></div>
                    <?php
                        unset($_SESSION['arus_ac']);
                    }
                    ?>
                    <label for="arus_ac">Arus AC</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">format_color_fill</i>
                    <input id="isi_freon" type="text" name="isi_freon" class="validate" required>
                    <?php
                    if (isset($_SESSION['isi_freon'])) {
                        $isi_freon = $_SESSION['isi_freon'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $isi_freon ?></div>
                    <?php
                        unset($_SESSION['isi_freon']);
                    }
                    ?>
                    <label for="isi_freon">Isi Freon</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">more_horiz</i>
                    <input id="lain" type="text" name="lain" class="validate" required>
                    <?php
                    if (isset($_SESSION['lain'])) {
                        $lain = $_SESSION['lain'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $lain ?></div>
                    <?php
                        unset($_SESSION['lain']);
                    }
                    ?>
                    <label for="lain">Lain-lain</label>
                </div>


                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1 right">
                            <span>File</span>
                            <input type="file" name="file" id="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Bukti Foto">
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
            <div class="row">
                <div class="col 6">
                    <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                </div>
                <div class="col 6">
                    <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                </div>
            </div>
            <!-- ROW IN FORM END -->
        </form>
        <!-- FORM END -->
    </div>
    <!-- ROW END -->
<?php
}
