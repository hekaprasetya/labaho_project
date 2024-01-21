<link rel="stylesheet" href="">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['nama_panel']) || empty($_REQUEST['kode_form'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $no_form = $_REQUEST['no_form'];
            $kode_form = $_REQUEST['kode_form'];
            $nama_panel = $_REQUEST['nama_panel'];
            $item = $_REQUEST['item'];
            $kondisi = $_REQUEST['kondisi'];
            $aktual = $_REQUEST['aktual'];
            $keterangan_panel = $_REQUEST['keterangan_panel'];
            $id_user = $_SESSION['id_user'];

            $qer = mysqli_query($conn, "SELECT id_utility FROM master_utility WHERE nama_utility = '$nama_panel'");
            $gg = $qer->fetch_assoc();
            $id_utility = $gg['id_utility'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/panel/";

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

                        $query = mysqli_query($config, "INSERT INTO utility_panel (no_form, kode_form,nama_panel,item,kondisi,aktual,keterangan_panel,file,id_utility,id_user)
                        VALUES('$no_form', '$kode_form','$nama_panel','$item','$kondisi','$aktual','$keterangan_panel','$nfile','$id_utility','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=panel");
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
                $query = mysqli_query($config, "INSERT INTO utility_panel (no_form, kode_form,nama_panel,item,kondisi,aktual,keterangan_panel,file,id_utility,id_user)
                VALUES('$no_form', '$kode_form','$nama_panel','$item','$kondisi','$aktual','$keterangan_panel','$file','$id_utility','$id_user')");

                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=panel");
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
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> PM Panel</a></li>
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
        <form class="col s12" method="post" action="?page=panel&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    // memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT kode_form, tgl_panel FROM utility_panel ORDER BY id_panel DESC LIMIT 1");

                    // mengambil nilai no_form terbaru
                    $result = mysqli_fetch_assoc($sql);

                    if (!empty($result['kode_form']) && !empty($result['tgl_panel'])) {
                        $tanggal_terakhir = $result['tgl_panel'];
                        $tahun_terakhir = date("Y", strtotime($tanggal_terakhir));
                        $tahun_sekarang = date("Y");
                        // Periksa apakah input terakhir pada tahun yang sama
                        ($tahun_sekarang == $tahun_terakhir) ? $kode = $result['kode_form'] + 1 :  $kode = 1;
                    } else {
                        $sql = mysqli_query($config, "SELECT no_form FROM utility_panel");
                        ($result = mysqli_num_rows($sql)) != 0 ?  $kode = $result + 1 :  $kode = 1;
                    }
                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    // $tahun = date('Y-m');
                    $kode_jadi = "PM/PANEL/$bikin_kode";

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
                    <i class="material-icons prefix md-prefix">settings</i><label for="nama_panel">Nama Utility</label><br />
                    <div class="input-field col s11 right">
                        <select name="nama_panel" class="browser-default validate theSelect" id="nama_panel" required>
                            <option value="" disabled selected>Pilih Panel</option>
                            <?php

                            // Perintah SQL untuk menampilkan data dengan nama_utility "PANEL" atau "SDP"
                            $sql = "SELECT * FROM master_utility WHERE nama_utility LIKE '%PANEL%' OR nama_utility LIKE '%SDP%' ORDER BY id_utility ASC";


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
                    <i class="material-icons prefix md-prefix">flare</i>
                    <label for="item">ITEM</label>
                    <br>
                    <div class="input-field col s11 right">
                        <select id="item" class="browser-default validate theSelect" name="item">
                            <option value="" disabled selected>Pilih Item</option>
                            <option value="Kebersihan Panel">Kebersihan Panel</option>
                            <option value="Lampu Indikator">Lampu Indikator</option>
                            <option value="Power Meter">Power Meter</option>
                            <option value="Push Button">Push Button</option>
                            <option value="Selector Switch">Selector Switch</option>
                            <option value="koneksi Kabel">koneksi Kabel</option>
                            <option value="Kondisi MCCB">Kondisi MCCB</option>
                            <option value="Kondisi MCB">Kondisi MCB</option>
                            <option value="Kondisi Relay">Kondisi Relay</option>
                            <option value="Kondisi Kontaktor">Kondisi Kontaktor</option>
                            <option value="Voltage (Voltase)">Voltage (Voltase)</option>
                            <option value="Current (Arus)">Current (Arus)</option>
                        </select>
                    </div>
                    <?php
                    if (isset($_SESSION['item'])) {
                        $item = $_SESSION['item'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $item . '</div>';
                        unset($_SESSION['item']);
                    }
                    ?>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">new_releases</i>
                    <label for="kondisi">KONDISI</label>
                    <br>
                    <div class="input-field col s11 right">
                        <select id="kondisi" class="browser-default validate theSelect" name="kondisi">
                            <option value="" disabled selected>Pilih Kondisi</option>
                            <option value="Baik">Baik</option>
                            <option value="Dapat dioprasikan dengan syarat">Dapat dioprasikan dengan syarat</option>
                            <option value="Diperbaiki">Diperbaiki</option>
                            <option value="Rusak">Rusak(tidak dapat diperbaiki)</option>
                        </select>
                    </div>
                    <?php
                    if (isset($_SESSION['kondisi'])) {
                        $kondisi = $_SESSION['kondisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kondisi . '</div>';
                        unset($_SESSION['kondisi']);
                    }
                    ?>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">priority_high</i>
                    <input id="aktual" type="text" name="aktual" class="validate" required>
                    <?php
                    if (isset($_SESSION['aktual'])) {
                        $aktual = $_SESSION['aktual'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $aktual ?></div>
                    <?php
                        unset($_SESSION['aktual']);
                    }
                    ?>
                    <label for="aktual">AKTUAL</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">assignment</i>
                    <input id="keterangan_panel" type="text" name="keterangan_panel" class="validate" required>
                    <?php
                    if (isset($_SESSION['keterangan_panel'])) {
                        $keterangan_panel = $_SESSION['keterangan_panel'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $keterangan_panel ?></div>
                    <?php
                        unset($_SESSION['keterangan_panel']);
                    }
                    ?>
                    <label for="keterangan_panel">KETERANGAN</label>
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
     <script>
     $(".theSelect").select2();

     </script>
    <!-- ROW END -->
<?php
}
