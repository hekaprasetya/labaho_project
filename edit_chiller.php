<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['nama_chiller']) || empty($_REQUEST['id_chiller'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
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
            $file = $_REQUEST['file'];
            $id_utility = $_REQUEST['id_utility'];
            $id_user = $_SESSION['id_user'];
            $id_chiller = intval($_REQUEST['id_chiller']);

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

                        $query = mysqli_query($config, "UPDATE utility_chiller SET  nama_chiller='$nama_chiller', leaving_evap='$leaving_evap', entering_evap='$entering_evap', setpoint='$setpoint', 
                        hp_c1='$hp_c1',lp_c2='$lp_c2',hp_c11='$hp_c11',lp_c22='$lp_c22',in_condensor='$in_condensor',out_condensor='$out_condensor',approach='$approach',oat='$oat',ampere='$ampere',file='$nfile',id_utility='$id_utility' WHERE id_chiller='$id_chiller'");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                            header("Location: ./admin.php?page=chiller");
                            echo 'Error: ' . mysqli_error($config);
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
                $query = mysqli_query($config, "UPDATE utility_chiller SET  nama_chiller='$nama_chiller', leaving_evap='$leaving_evap', entering_evap='$entering_evap', setpoint='$setpoint', 
                        hp_c1='$hp_c1',lp_c2='$lp_c2',hp_c11='$hp_c11',lp_c22='$lp_c22',in_condensor='$in_condensor',out_condensor='$out_condensor',approach='$approach',oat='$oat',ampere='$ampere',id_utility='$id_utility' WHERE id_chiller='$id_chiller'");


                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                    header("Location: ./admin.php?page=chiller");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                }
            }
        }
    }

    $id_chiller = mysqli_real_escape_string($config, $_REQUEST['id_chiller']);
    $query = mysqli_query($config, "SELECT * FROM utility_chiller WHERE id_chiller='$id_chiller'");
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_assoc()) {
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
                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Edit</a></li>
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="no_form" type="text" name="no_form" class="validate" value="<?= $row['no_form']; ?>" disabled>
                            <?php
                            if (isset($_SESSION['no_form'])) {
                                $no_form = $_SESSION['no_form'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $no_form ?></div>
                                <?php
                                unset($_SESSION['no_form']);
                            }
                            ?>
                            <label for="no_form">No.Form</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">assignment</i><label for="nama_chiller">Nama Utility</label><br />
                            <div class="input-field col s11 right">
                                <select name="nama_chiller" class="browser-default validate theSelect" id="nama_chiller">
                                    <option value="<?= $row['nama_chiller'] ?>" selected><?= $row['nama_chiller'] ?></option>
                                    <?php
                                    // Perintah SQL untuk menampilkan data dengan nama_utility 
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">battery_charging_full</i>
                            <input id="leaving_evap" type="text" name="leaving_evap" class="validate" value="<?= $row['leaving_evap']; ?>" required>
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">battery_charging_full</i>
                            <input id="entering_evap" type="text" name="entering_evap" class="validate" value="<?= $row['entering_evap']; ?>" required>
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">format_color_fill</i>
                            <input id="setpoint" type="text" name="setpoint" class="validate" value="<?= $row['setpoint']; ?>" required>
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">ac_unit</i>
                            <input id="hp_c1" type="text" name="hp_c1" class="validate" value="<?= $row['hp_c1']; ?>" required>
                            <?php
                            if (isset($_SESSION['hp_c1'])) {
                                $hp_c1 = $_SESSION['hp_c1'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $hp_c1 ?></div>
                                <?php
                                unset($_SESSION['hp_c1']);
                            }
                            ?>
                            <label for="hp_c1">hp c1</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">ac_unit</i>
                            <input id="lp_c2" type="text" name="lp_c2" class="validate" value="<?= $row['lp_c2']; ?>" required>
                            <?php
                            if (isset($_SESSION['lp_c2'])) {
                                $lp_c2 = $_SESSION['lp_c2'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $lp_c2 ?></div>
                                <?php
                                unset($_SESSION['lp_c2']);
                            }
                            ?>
                            <label for="lp_c2">lp c2</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">ev_station</i>
                            <input id="hp_c11" type="text" name="hp_c11" class="validate" value="<?= $row['hp_c11']; ?>" required>
                            <?php
                            if (isset($_SESSION['hp_c11'])) {
                                $hp_c11 = $_SESSION['hp_c11'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $hp_c11 ?></div>
                                <?php
                                unset($_SESSION['hp_c11']);
                            }
                            ?>
                            <label for="hp_c11">hp c1</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">power_input</i>
                            <input id="lp_c22" type="text" name="lp_c22" class="validate" value="<?= $row['lp_c22']; ?>" required>
                            <?php
                            if (isset($_SESSION['lp_c22'])) {
                                $lp_c22 = $_SESSION['lp_c22'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $lp_c22 ?></div>
                                <?php
                                unset($_SESSION['lp_c22']);
                            }
                            ?>
                            <label for="lp_c22">lp c2</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">highlight</i>
                            <input id="in_condensor" type="text" name="in_condensor" class="validate" value="<?= $row['in_condensor']; ?>" required>
                            <?php
                            if (isset($_SESSION['in_condensor'])) {
                                $in_condensor = $_SESSION['in_condensor'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $in_condensor ?></div>
                                <?php
                                unset($_SESSION['in_condensor']);
                            }
                            ?>
                            <label for="in_condensor">In Condensor</label>
                        </div>

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">power</i>
                            <input id="out_condensor" type="text" name="out_condensor" class="validate" value="<?= $row['out_condensor']; ?>" required>
                            <?php
                            if (isset($_SESSION['out_condensor'])) {
                                $out_condensor = $_SESSION['out_condensor'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $out_condensor ?></div>
                                <?php
                                unset($_SESSION['out_condensor']);
                            }
                            ?>
                            <label for="out_condensor">Out Condensor</label>
                        </div>
                        
                         <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">power</i>
                            <input id="oat" type="text" name="oat" class="validate" value="<?= $row['oat']; ?>" required>
                            <?php
                            if (isset($_SESSION['oat'])) {
                                $oat = $_SESSION['oat'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $oat ?></div>
                                <?php
                                unset($_SESSION['oat']);
                            }
                            ?>
                            <label for="oat">Oat</label>
                        </div>
                        
                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">more_horiz</i>
                            <input id="ampere" type="text" name="ampere" class="validate" value="<?= $row['ampere']; ?>" required>
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
                        
                         <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">more_horiz</i>
                            <input id="approach" type="text" name="approach" class="validate" value="<?= $row['approach']; ?>" required>
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

                        <!--div class="input-field col s12">
                            <div class="file-field input-field">
                                <div class="btn small light-green darken-1 right">
                                    <span>File</span>
                                    <input type="file" name="file" id="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Bukti Foto" value="<?= $row['file'] ?>" disabled>
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

                        <br>
                        <br>

                    </div>
                    <!-- ROW IN FORM END -->
                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                        </div>
                    </div>
                </form>
                <!-- FORM END -->
            </div>
            <!-- ROW END -->
            <?php
        }
    } else {
        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
    }
}
