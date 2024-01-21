<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        //validasi form kosong
        if (empty($_REQUEST['nama_utility']) || empty($_REQUEST['lokasi'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
?>
            <script language="javascript">
                window.history.back();
            </script>
            <?php
        } else {

            $nama_utility = $_REQUEST['nama_utility'];
            $lokasi = $_REQUEST['lokasi'];
            $tgl = $_REQUEST['tgl'];
            $merk = $_REQUEST['merk'];
            $type = $_REQUEST['type'];
            $sn = $_REQUEST['sn'];
            $volt = $_REQUEST['volt'];
            $kva = $_REQUEST['kva'];
            $id_utility = intval($_REQUEST['id_utility']);

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/utility/";

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
                        $query = mysqli_query($config, "UPDATE master_utility  SET nama_utility='$nama_utility', lokasi='$lokasi', tgl='$tgl', merk='$merk', 
                        type='$type', sn='$sn', volt='$volt', kva='$kva', file='$nfile' WHERE id_utility='$id_utility'");


                        if ($query === true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=master_utility");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            ?><script language="javascript">
                                window.history.back();
                            </script>
                    <?php
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
                $query = mysqli_query($config, "UPDATE master_utility  SET nama_utility='$nama_utility', lokasi='$lokasi', tgl='$tgl', merk='$merk', 
                        type='$type', sn='$sn', volt='$volt', kva='$kva' WHERE id_utility='$id_utility'");
                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("location: ./admin.php?page=master_utility");
                    exit();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    ?>
                    <script language="javascript">
                        window.history.back();
                    </script>
                <?php
                }
            }
        }
    } else {
        $id_utility = mysqli_real_escape_string($config, $_REQUEST['id_utility']);
        $query = mysqli_query($config, "SELECT * FROM master_utility WHERE id_utility='$id_utility'");
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
                                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Edit Utility</a></li>
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

                <!-- ROW START -->
                <div class="row jarak-form">
                    <!-- FORM START -->
                    <form class="col s12" action="" method="post" enctype="multipart/form-data">
                        <!-- ROW IN FORM START-->
                        <div class="row">

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">build</i>
                                <input id="nama_utility" type="text" name="nama_utility" class="validate" value="<?= $row['nama_utility']; ?>">
                                <?php
                                if (isset($_SESSION['nama_utility'])) {
                                    $nama_utility = $_SESSION['nama_utility'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $nama_utility ?></div>
                                <?php
                                    unset($_SESSION['nama_utility']);
                                }
                                ?>
                                <label for="nama_utility">Utility</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">add_location</i>
                                <input id="lokasi" type="text" name="lokasi" class="validate" value="<?= $row['lokasi']; ?>">
                                <?php
                                if (isset($_SESSION['lokasi'])) {
                                    $lokasi = $_SESSION['lokasi'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $lokasi ?></div>
                                <?php
                                    unset($_SESSION['lokasi']);
                                }
                                ?>
                                <label for="lokasi">Lokasi</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="tgl" type="text" name="tgl" class="datepicker" value="<?= $row['tgl']; ?>">
                                <?php
                                if (isset($_SESSION['tgl'])) {
                                    $tgl = $_SESSION['tgl'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl . '</div>';
                                    unset($_SESSION['tgl']);
                                }
                                ?>
                                <label for="tgl">Tanggal Pengadaan</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">local_offer</i>
                                <input id="merk" type="text" name="merk" class="validate" value="<?= $row['merk']; ?>">
                                <?php
                                if (isset($_SESSION['merk'])) {
                                    $merk = $_SESSION['merk'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $merk ?></div>
                                <?php
                                    unset($_SESSION['merk']);
                                }
                                ?>
                                <label for="merk">Merk</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">local_activity</i>
                                <input id="type" type="text" name="type" class="validate" value="<?= $row['type']; ?>">
                                <?php
                                if (isset($_SESSION['type'])) {
                                    $type = $_SESSION['type'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $type ?></div>
                                <?php
                                    unset($_SESSION['type']);
                                }
                                ?>
                                <label for="type">Tipe</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">filter_9_plus</i>
                                <input id="sn" type="text" name="sn" class="validate" value="<?= $row['sn']; ?>">
                                <?php
                                if (isset($_SESSION['sn'])) {
                                    $sn = $_SESSION['sn'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $sn ?></div>
                                <?php
                                    unset($_SESSION['sn']);
                                }
                                ?>
                                <label for="sn">S/N</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">flash_on</i>
                                <input id="volt" type="text" name="volt" class="validate" value="<?= $row['volt']; ?>">
                                <?php
                                if (isset($_SESSION['volt'])) {
                                    $volt = $_SESSION['volt'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $volt ?></div>
                                <?php
                                    unset($_SESSION['volt']);
                                }
                                ?>
                                <label for="volt">Volt</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">flash_auto</i>
                                <input id="kva" type="text" name="kva" class="validate" value="<?= $row['kva']; ?>">
                                <?php
                                if (isset($_SESSION['kva'])) {
                                    $kva = $_SESSION['kva'];
                                ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $kva ?></div>
                                <?php
                                    unset($_SESSION['kva']);
                                }
                                ?>
                                <label for="kva">Kva</label>
                            </div>

                            <div class="input-field col s12">
                                <div class="file-field input-field">
                                    <div class="btn small light-green darken-1">
                                        <span>Foto</span>
                                        <input type="file" id="file" name="file">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Upload file" value="<?= $row['file']; ?>">
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
}
