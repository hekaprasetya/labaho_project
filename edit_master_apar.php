<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['posisi']) || empty($_REQUEST['jenis_apar']) || empty($_REQUEST['berat'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $posisi = $_REQUEST['posisi'];
            $jenis_apar = $_REQUEST['jenis_apar'];
            $berat = $_REQUEST['berat'];
            $id_apar = intval($_REQUEST['id_apar']);
            if (!is_numeric($berat) || $berat < 0) {
                $_SESSION['berat'] = 'Berat harus berupa angka positif dengan dua desimal.';
                // Redirect kembali ke halaman formulir
                header("Location: edit_master_apar.php");
                exit();
            }

            $query = mysqli_query($conn, "UPDATE utility_apar SET  posisi='$posisi', jenis_apar='$jenis_apar', berat='$berat' WHERE id_apar='$id_apar'");
            if ($query === true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil diUpdate';
                header("Location: ./admin.php?page=master_apar");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
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
                            <i class="material-icons prefix md-prefix">place</i>
                            <input id="posisi" type="text" name="posisi" class="validate" value="<?= $row['posisi'] ?>" required>
                            <?php
                            if (isset($_SESSION['posisi'])) {
                                $posisi = $_SESSION['posisi'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $posisi ?></div>
                            <?php
                                unset($_SESSION['posisi']);
                            }
                            ?>
                            <label for="posisi">Posisi</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">nature</i>
                            <input id="jenis_apar" type="text" name="jenis_apar" class="validate" value="<?= $row['jenis_apar'] ?>" required>
                            <?php
                            if (isset($_SESSION['jenis_apar'])) {
                                $jenis_apar = $_SESSION['jenis_apar'];
                            ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $jenis_apar ?></div>
                            <?php
                                unset($_SESSION['jenis_apar']);
                            }
                            ?>
                            <label for="jenis_apar">Jenis Apar</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">filter_3</i>
                            <input id="berat" type="number" name="berat" class="validate" value="<?= $row['berat'] ?>" required step="0.01">
                            <?php
                            if (isset($_SESSION['berat'])) {
                                $berat = $_SESSION['berat'];
                            ?>
                                <div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $berat ?></div>
                            <?php
                                unset($_SESSION['berat']);
                            }
                            ?>
                            <label for="berat">Berat</label>
                        </div>
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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var form = document.getElementById('formulir'); // Gantilah 'formulir' dengan id formulir Anda

                    form.addEventListener('submit', function(event) {
                        var beratInput = document.getElementById('berat');
                        var beratValue = parseFloat(beratInput.value);

                        if (isNaN(beratValue) || beratValue < 0) {
                            alert('Berat harus berupa angka positif dengan dua desimal.');
                            event.preventDefault(); // Mencegah pengiriman formulir jika validasi gagal
                        }
                    });
                });
            </script>
<?php
        }
    } else {
        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
    }
}
