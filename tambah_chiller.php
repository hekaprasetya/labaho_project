<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['no_form'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $no_form = $_REQUEST['no_form'];
            $kode_form = $_REQUEST['kode_form'];
            $nama_chiller = $_REQUEST['nama_chiller'];
            $leaving_evap = $_REQUEST['leaving_evap'];
            $entering_evap = $_REQUEST['entering_evap'];
            $setpoint = $_REQUEST['setpoint'];
            $hp_c1 = $_REQUEST['hp_c1'];
            $lp_c2 = $_REQUEST['lp_c2'];
            $hp_c11 = $_REQUEST['hp_c11'];
            $lp_c22 = $_REQUEST['lp_c22'];
            $in_condensor = $_REQUEST['in_condensor'];
            $out_condensor = $_REQUEST['out_condensor'];
            $approach = $_REQUEST['approach'];
            $oat = $_REQUEST['oat'];
            $ampere = $_REQUEST['ampere'];
            $id_user = $_SESSION['id_user'];

            $qer = mysqli_query($conn, "SELECT id_utility FROM master_utility WHERE nama_utility = '$nama_chiller'");
            $gg = $qer->fetch_assoc();
            $id_utility = $gg['id_utility'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/chiller_log/";

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

                        $query = mysqli_query($config, "INSERT INTO utility_chiller (no_form, kode_form,nama_chiller,leaving_evap,entering_evap,setpoint,hp_c1,lp_c2,hp_c11,lp_c22,in_condensor,out_condensor,approach,oat,ampere,file,id_utility,id_user)
                        VALUES('$no_form', '$kode_form','$nama_chiller','$leaving_evap','$entering_evap','$setpoint','$hp_c1','$lp_c2','$hp_c11','$lp_c22','$in_condensor','$out_condensor','$approach','$oat','$ampere','$nfile','$id_utility','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=chiller");
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
                $query = mysqli_query($config, "INSERT INTO utility_chiller (no_form, kode_form,nama_chiller,leaving_evap,entering_evap,setpoint,hp_c1,lp_c2,hp_c11,lp_c22,in_condensor,out_condensor,approach,oat,ampere,file,id_utility,id_user)
                        VALUES('$no_form', '$kode_form','$nama_chiller','$leaving_evap','$entering_evap','$setpoint','$hp_c1','$lp_c2','$hp_c11','$lp_c22','$in_condensor','$out_condensor','$approach','$oat','$ampere','$file','$id_utility','$id_user')");

                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=chiller");
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
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Tambah Logsheet Chiller</a></li>
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
        <form class="col s12" method="post" action="" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    // memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT kode_form, tgl_chiller FROM utility_chiller ORDER BY id_chiller DESC LIMIT 1");

                    // mengambil nilai no_form terbaru
                    $result = mysqli_fetch_assoc($sql);

                    if ($result && !empty($result['kode_form'])) {
                        $tanggal_terakhir = $result['tgl_chiller'];
                        $tahun_terakhir = date("Y", strtotime($tanggal_terakhir));
                        $tahun_sekarang = date("Y");

                        // Periksa apakah input terakhir pada tahun yang sama
                        ($tahun_sekarang == $tahun_terakhir) ? $kode = $result['kode_form'] + 1 : $kode = 1;
                    } else {
                        $sql = mysqli_query($config, "SELECT no_form FROM utility_chiller");
                        ($result = mysqli_num_rows($sql)) != 0 ? $kode = $result + 1 : $kode = 1;
                    }
                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                     $tahun = date('Y-m');
                    $kode_jadi = "Log/Chiller/$tahun/$bikin_kode";

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
                    <i class="material-icons prefix md-prefix">assignment</i><label for="nama_chiller">Nama Utility</label><br />
                    <div class="input-field col s12">
                        <select name="nama_chiller" class="browser-default validate theSelect" id="nama_chiller" required>
                            <option value="" disabled selected>Pilih Chiller</option>
                            <?php
                            // Perintah SQL untuk menampilkan data dengan nama_utility "GENSET"
                            $sql = "SELECT * FROM master_utility WHERE nama_utility LIKE '%CH-%' ORDER BY id_utility ASC";

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
                    <i class="material-icons prefix md-prefix">battery_charging_full</i>
                    <input id="leaving_evap" type="text" name="leaving_evap" class="validate" required>
                    <?php
                    if (isset($_SESSION['leaving_evap'])) {
                        $leaving_evap = $_SESSION['leaving_evap'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $leaving_evap ?></div>
                        <?php
                        unset($_SESSION['leaving_evap']);
                    }
                    ?>
                    <label for="leaving_evap">Leaving Evaporator</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">battery_charging_full</i>
                    <input id="entering_evap" type="text" name="entering_evap" class="validate" required>
                    <?php
                    if (isset($_SESSION['entering_evap'])) {
                        $entering_evap = $_SESSION['entering_evap'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $entering_evap ?></div>
                        <?php
                        unset($_SESSION['entering_evap']);
                    }
                    ?>
                    <label for="entering_evap">Entering Evaporator</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">format_color_fill</i>
                    <input id="setpoint" type="text" name="setpoint" class="validate" required>
                    <?php
                    if (isset($_SESSION['setpoint'])) {
                        $setpoint = $_SESSION['setpoint'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $setpoint ?></div>
                        <?php
                        unset($_SESSION['setpoint']);
                    }
                    ?>
                    <label for="setpoint">Setpoint</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">ac_unit</i>
                    <input id="hp_c1" type="text" name="hp_c1" class="validate" required>
                    <?php
                    if (isset($_SESSION['hp_c1'])) {
                        $hp_c1 = $_SESSION['hp_c1'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $hp_c1 ?></div>
                        <?php
                        unset($_SESSION['hp_c1']);
                    }
                    ?>
                    <label for="hp_c1">HP C1</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">ac_unit</i>
                    <input id="hp_c1" type="text" name="hp_c1" class="validate" required>
                    <?php
                    if (isset($_SESSION['hp_c1'])) {
                        $hp_c1 = $_SESSION['hp_c1'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $hp_c1 ?></div>
                        <?php
                        unset($_SESSION['hp_c1']);
                    }
                    ?>
                    <label for="hp_c1">HP C1</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">ev_station</i>
                    <input id="lp_c2" type="text" name="lp_c2" class="validate" required>
                    <?php
                    if (isset($_SESSION['lp_c2'])) {
                        $lp_c2 = $_SESSION['lp_c2'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $lp_c2 ?></div>
                        <?php
                        unset($_SESSION['lp_c2']);
                    }
                    ?>
                    <label for="lp_c2">LP C2</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">ev_station</i>
                    <input id="hp_c11" type="text" name="hp_c11" class="validate" required>
                    <?php
                    if (isset($_SESSION['hp_c11'])) {
                        $hp_c11 = $_SESSION['hp_c11'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $hp_c11 ?></div>
                        <?php
                        unset($_SESSION['hp_c11']);
                    }
                    ?>
                    <label for="hp_c11">HP C1</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">ev_station</i>
                    <input id="lp_c22" type="text" name="lp_c22" class="validate" required>
                    <?php
                    if (isset($_SESSION['lp_c22'])) {
                        $lp_c22 = $_SESSION['lp_c22'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $lp_c22 ?></div>
                        <?php
                        unset($_SESSION['lp_c22']);
                    }
                    ?>
                    <label for="lp_c22">LP C2</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">highlight</i>
                    <input id="in_condensor" type="text" name="in_condensor" class="validate" required>
                    <?php
                    if (isset($_SESSION['in_condensor'])) {
                        $in_condensor = $_SESSION['in_condensor'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $in_condensor ?></div>
                        <?php
                        unset($_SESSION['in_condensor']);
                    }
                    ?>
                    <label for="in_condensor">In Kondensor</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">power</i>
                    <input id="out_condensor" type="text" name="out_condensor" class="validate" required>
                    <?php
                    if (isset($_SESSION['out_condensor'])) {
                        $out_condensor = $_SESSION['out_condensor'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $out_condensor ?></div>
                        <?php
                        unset($_SESSION['out_condensor']);
                    }
                    ?>
                    <label for="out_condensor">Out Kondensor</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">power</i>
                    <input id="approach" type="text" name="approach" class="validate" required>
                    <?php
                    if (isset($_SESSION['approach'])) {
                        $approach = $_SESSION['approach'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $approach ?></div>
                        <?php
                        unset($_SESSION['approach']);
                    }
                    ?>
                    <label for="approach">Approach</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">power</i>
                    <input id="oat" type="text" name="oat" class="validate" required>
                    <?php
                    if (isset($_SESSION['oat'])) {
                        $oat = $_SESSION['oat'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $oat ?></div>
                        <?php
                        unset($_SESSION['oat']);
                    }
                    ?>
                    <label for="oat">OAT</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">power</i>
                    <input id="ampere" type="text" name="ampere" class="validate" required>
                    <?php
                    if (isset($_SESSION['ampere'])) {
                        $ampere = $_SESSION['ampere'];
                        ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $ampere ?></div>
                        <?php
                        unset($_SESSION['ampere']);
                    }
                    ?>
                    <label for="ampere">Ampere</label>
                </div>

                <!--div class="input-field col s12">
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
                </div-->


                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                    </div>
                </div>
            </div>
            <!-- ROW IN FORM END -->
        </form>
        <!-- FORM END -->
    </div>
    <!-- ROW END -->
    <?php
}
