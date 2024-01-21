<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['nama_genset']) || empty($_REQUEST['c_accu'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_genset = $_REQUEST['nama_genset'];
            $c_accu = $_REQUEST['c_accu'];
            $c_pelumas = $_REQUEST['c_pelumas'];
            $c_pendingin = $_REQUEST['c_pendingin'];
            $c_bb = $_REQUEST['c_bb'];
            $c_panel = $_REQUEST['c_panel'];
            $c_phg = $_REQUEST['c_phg'];
            $id_genset = intval($_REQUEST['id_genset']);

            $qer = mysqli_query($conn, "SELECT id_utility FROM master_utility WHERE nama_utility = '$nama_genset'");
            $gg = $qer->fetch_assoc();
            $id_utility = $gg['id_utility'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/genset/";

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

                        $query = mysqli_query($config, "UPDATE utility_genset SET nama_genset='$nama_genset',
                            c_accu='$c_accu', c_pelumas='$c_pelumas', c_pendingin='$c_pendingin', c_bb='$c_bb', c_panel='$c_panel', c_phg='$c_phg',
                            file='$nfile',id_utility = '$id_utility' WHERE id_genset='$id_genset'");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                            header("Location: ./admin.php?page=genset");
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
                $query = mysqli_query($config, "UPDATE utility_genset SET nama_genset='$nama_genset',
                c_accu='$c_accu', c_pelumas='$c_pelumas', c_pendingin='$c_pendingin', c_bb='$c_bb', c_panel='$c_panel', c_phg='$c_phg',id_utility = '$id_utility'  WHERE id_genset='$id_genset'");


                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                    header("Location: ./admin.php?page=genset");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }

    $id_genset = mysqli_real_escape_string($config, $_REQUEST['id_genset']);
    $query = mysqli_query($config, "SELECT * FROM utility_genset WHERE id_genset='$id_genset'");
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
                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">directions_car</i> Edit Maintenance Genset</a></li>
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

                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">assignment</i><label for="nama_genset">Nama Utility</label><br />
                            <div class="input-field col s12">
                                <select name="nama_genset" class="browser-default validate theSelect" id="nama_genset" required>
                                    <option value="<?= $row['nama_genset'] ?>" selected><?= $row['nama_genset'] ?></option>
                                    <?php
                                    // Perintah SQL untuk menampilkan data dengan nama_utility "GENSET"
                                    $sql = "SELECT * FROM master_utility WHERE nama_utility LIKE '%GENSET%' ORDER BY id_utility ASC";

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
                            <input id="c_accu" type="text" name="c_accu" class="validate" value="<?= $row['c_accu']; ?>">
                            <?php
                            if (isset($_SESSION['c_accu'])) {
                                $c_accu = $_SESSION['c_accu'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $c_accu ?></div>
                            <?php
                                unset($_SESSION['c_accu']);
                            }
                            ?>
                            <label for="c_accu">Cek Kondisi Battery/ACCU</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">format_color_fill</i>
                            <input id="c_pelumas" type="text" name="c_pelumas" class="validate" value="<?= $row['c_pelumas'] ?>">
                            <?php
                            if (isset($_SESSION['c_pelumas'])) {
                                $c_pelumas = $_SESSION['c_pelumas'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $c_pelumas ?></div>
                            <?php
                                unset($_SESSION['c_pelumas']);
                            }
                            ?>
                            <label for="c_pelumas">Cek Sistem Pelumasan</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">ac_unit</i>
                            <input id="c_pendingin" type="text" name="c_pendingin" class="validate" value="<?= $row['c_pendingin'] ?>">
                            <?php
                            if (isset($_SESSION['c_pendingin'])) {
                                $c_pendingin = $_SESSION['c_pendingin'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $c_pendingin ?></div>
                            <?php
                                unset($_SESSION['c_pendingin']);
                            }
                            ?>
                            <label for="c_pendingin">Cek Sistem Pendinginan</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">ev_station</i>
                            <input id="c_bb" type="text" name="c_bb" class="validate" value="<?= $row['c_bb'] ?>">
                            <?php
                            if (isset($_SESSION['c_bb'])) {
                                $c_bb = $_SESSION['c_bb'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $c_bb ?></div>
                            <?php
                                unset($_SESSION['c_bb']);
                            }
                            ?>
                            <label for="c_bb">Cek Sistem Bahan Bakar</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">highlight</i>
                            <input id="c_panel" type="text" name="c_panel" class="validate" value="<?= $row['c_panel'] ?>">
                            <?php
                            if (isset($_SESSION['c_panel'])) {
                                $c_panel = $_SESSION['c_panel'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $c_panel ?></div>
                            <?php
                                unset($_SESSION['c_panel']);
                            }
                            ?>
                            <label for="c_panel">Cek Engine Panel</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">power</i>
                            <input id="c_phg" type="text" name="c_phg" class="validate" value="<?= $row['c_phg'] ?>">
                            <?php
                            if (isset($_SESSION['c_phg'])) {
                                $c_phg = $_SESSION['c_phg'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $c_phg ?></div>
                            <?php
                                unset($_SESSION['c_phg']);
                            }
                            ?>
                            <label for="c_phg">Cek Power House Genset</label>
                        </div>

                        <div class="input-field col s12">
                            <div class="file-field input-field">
                                <div class="btn small light-green darken-1 right">
                                    <span>File</span>
                                    <input type="file" name="file" id="file"">
                                </div>
                                <div class=" file-path-wrapper">
                                    <input class="file-path" type="text" name="files" placeholder="Bukti Foto" value="<?= $row['file'] ?>" disabled>
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
    } else {
        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
    }
}
