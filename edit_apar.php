<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['posisi']) || empty($_REQUEST['tgl'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $posisi = $_REQUEST['posisi'];
            $tanggal = $_REQUEST['tgl'];
            $keterangan = $_REQUEST['ket_apar'];
            $status = $_REQUEST['status'];
            $id_user = $_SESSION['id_user'];
            $id_apar = intval($_REQUEST['id_apar']);

            $qer = mysqli_query($conn, "SELECT jenis_apar, berat FROM utility_apar WHERE posisi = '$posisi' AND tanggal IS NULL");
            $gg = $qer->fetch_assoc();
            $jenis_apar = $gg['jenis_apar'];
            $berat = $gg['berat'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/apar/";

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

                        $query = mysqli_query($config, "UPDATE utility_apar SET  posisi='$posisi', jenis_apar='$jenis_apar', berat='$berat', keterangan='$keterangan', 
                        status='$status',tanggal='$tanggal',file='$nfile' WHERE id_apar='$id_apar'");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                            header("Location: ./admin.php?page=apar");
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
                $query = mysqli_query($config, "UPDATE utility_apar SET  posisi='$posisi', jenis_apar='$jenis_apar', berat='$berat', keterangan='$keterangan', 
                status='$status',tanggal='$tanggal' WHERE id_apar='$id_apar'");


                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                    header("Location: ./admin.php?page=apar");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                }
            }
        }
    }

    $id_apar = mysqli_real_escape_string($config, $_REQUEST['id_apar']);
    $query = mysqli_query($config, "SELECT * FROM utility_apar WHERE id_apar='$id_apar'");
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
                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Edit Maintenance APAR</a></li>
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
                            <i class="material-icons prefix md-prefix">nature</i><label for="posisi">Nama Utility</label><br />
                            <div class="input-field col s11 right">
                                <select name="posisi" class="browser-default validate theSelect" id="posisi" required>
                                    <option value="<?= $row['posisi'] ?>" selected><?= $row['posisi'] ?></option>
                                    <?php

                                    // Perintah SQL untuk menampilkan data apar
                                    $sql = "SELECT posisi FROM utility_apar WHERE tanggal IS NULL ORDER BY id_apar ASC";


                                    $hasil = mysqli_query($config, $sql);
                                    while ($data = mysqli_fetch_array($hasil)) {
                                    ?>
                                        <option value="<?= htmlspecialchars($data['posisi']); ?>"><?= htmlspecialchars($data['posisi']); ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>


                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl" type="date" name="tgl" class="event_available" value="<?= $row['tanggal'] ?>" required>
                            <?php
                            if (isset($_SESSION['tanggal'])) {
                                $tgl = $_SESSION['tgl'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl . '</div>';
                                unset($_SESSION['tgl']);
                            }
                            ?>
                            <label for="tgl">Tanggal</label>
                        </div>

                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">assignment</i>
                            <input id="ket_apar" type="text" name="ket_apar" class="validate" value="<?= $row['keterangan'] ?>" required>
                            <?php
                            if (isset($_SESSION['ket_apar'])) {
                                $ket_apar = $_SESSION['ket_apar'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $ket_apar ?></div>
                            <?php
                                unset($_SESSION['ket_apar']);
                            }
                            ?>
                            <label for="ket_apar">Keterangan</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">beenhere</i>
                            <input id="status" type="text" name="status" class="validate" value="<?= $row['status'] ?>" required>
                            <?php
                            if (isset($_SESSION['status'])) {
                                $status = $_SESSION['status'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $status ?></div>
                            <?php
                                unset($_SESSION['status']);
                            }
                            ?>
                            <label for="status">Status</label>
                        </div>

                        <div class="input-field col s12">
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
                        </div>

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
