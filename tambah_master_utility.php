<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        if (empty($_REQUEST['nama_utility']) || empty($_REQUEST['lokasi']) || empty($_REQUEST['tgl'])) {
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
                    if ($ukuran < 2000000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);
                        $query = mysqli_query($config, "INSERT INTO master_utility (nama_utility, lokasi, tgl, merk, type, sn, volt, kva, file)
                        VALUES('$nama_utility', '$lokasi', '$tgl', '$merk', '$type', '$sn', '$volt', '$kva', '$nfile')");

                        $id_utility_add = mysqli_insert_id($config);
                        @session_start();
                        if (isset($_SESSION["tableDet"])) {
                            $tableDet = $_SESSION["tableDet"];
                            foreach ($tableDet as $i => $v) {
                                if ($tableDet[$i]["mode_item"] == "N") {
                                    $nama_part = $tableDet[$i]["nama_part"];
                                    $tipe = $tableDet[$i]["tipe"];
                                    $jumlah = $tableDet[$i]["jumlah"];
                                    $id_utility = $id_utility_add;

                                    mysqli_query($config, "INSERT INTO master_utility_detail(nama_part,tipe,jumlah,id_utility)
                        VALUES('$nama_part','$tipe','$jumlah','$id_utility')");
                                }
                            }
                        }

                        if ($query === true) {
                            if (isset($_SESSION["tableDet"])) {
                                unset($_SESSION["tableDet"]);
                            }
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=master_utility");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            ?>
                            <script language="javascript">
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
                // jika tidak ada file
                $query = mysqli_query($config, "INSERT INTO master_utility (nama_utility, lokasi, tgl, merk, type, sn, volt, kva, file)
            VALUES('$nama_utility', '$lokasi', '$tgl','$merk','$type','$sn','$volt','$kva', '$file')");

                $id_utility_add = mysqli_insert_id($config);
                @session_start();
                if (isset($_SESSION["tableDet"])) {
                    $tableDet = $_SESSION["tableDet"];
                    foreach ($tableDet as $i => $v) {
                        if ($tableDet[$i]["mode_item"] == "N") {
                            $nama_part = $tableDet[$i]["nama_part"];
                            $jumlah = $tableDet[$i]["jumlah"];
                            $satuan = $tableDet[$i]["satuan"];
                            $id_utility = $id_utility_add;

                            mysqli_query($config, "INSERT INTO master_utility_detail(nama_part,jumlah,tipe,id_utility)
                                VALUES('$nama_part','$jumlah','$tipe','$id_utility')");
                        }
                    }
                }

                if ($query === true) {
                    if (isset($_SESSION["tableDet"])) {
                        unset($_SESSION["tableDet"]);
                    }
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=master_utility");
                    die();
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
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">build</i> Tambah Utility</a></li>
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
        <form class="col s12" method="post" action="?page=master_utility&act=add" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="col m12" id="colres">
                <table class="bordere centered" id="tbl">
                    <thead class="blue-darken  lighten-3 center" id="head">
                        <tr>
                            <th>No</th>
                            <th>Nama Part</th>
                            <th>Type</th>
                            <th>Jumlah</th>
                            <th><span><a class="btn small red modal-trigger" href="#modal2">
                                        <i class="material-icons">add_circle_outline</i> Sparepart</a></span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        @session_start();
                        $no = 0;
                        if (isset($_SESSION["tableDet"])) {
                            $tableDet = $_SESSION["tableDet"];
                            $no = 0;
                            foreach ($tableDet as $i => $v) {
                                if ($tableDet[$i]["mode_item"] != "D") {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $tableDet[$i]["nama_part"] ?></td>
                                        <td><?= $tableDet[$i]["tipe"] ?></td>
                                        <td><?= $tableDet[$i]["jumlah"] ?></td>
                                        <td>
                                <center><a href="hapus_item_utility.php?id=<?= $tableDet[$i]["i"] ?>" class="btn small btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>
                                </td>
                                </tr>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6" style="text-align: center"><strong>
                                    <font color="red">*** ISI JIKA ADA TAMBAHAN SPAREPART ***</font>
                                </strong></td>

                        </tr>

                        <?php
                    }
                    ?>
                    </tbody>

                    <div id="modal2" class="modal">
                        <div class="modal-content white">
                            <div class="row">
                                <!-- Secondary Nav START -->
                                <div class="col s12">
                                    <nav class="secondary-nav">
                                        <div class="nav-wrapper blue darken-2">
                                            <ul class="left">
                                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">device_hub</i> Tambah Sparepart</a></li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                                <!-- Secondary Nav END -->
                            </div>

                            <div  class="row jarak-form">
                                <form class="col s12" name="ok" action="ok" method="post">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix md-prefix">highlight</i>
                                        <input id="nama_part" type="text" class="validate" name="nama_part">
                                        <?php
                                        if (isset($_SESSION['nama_part'])) {
                                            $nama_part = $_SESSION['nama_part'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_part . '</div>';
                                            unset($_SESSION['nama_part']);
                                        }
                                        ?>
                                        <label for="nama_part">Nama Part</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <i class="material-icons prefix md-prefix">input</i>
                                        <input id="tipe" type="text" class="validate" name="tipe">
                                        <?php
                                        if (isset($_SESSION['tipe'])) {
                                            $tipe = $_SESSION['tipe'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tipe . '</div>';
                                            unset($_SESSION['tipe']);
                                        }
                                        ?>
                                        <label for="tipe">Type</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <i class="material-icons prefix md-prefix">playlist_add</i>
                                        <input id="jumlah" type="number" class="validate" name="jumlah">
                                        <?php
                                        if (isset($_SESSION['jumlah'])) {
                                            $jumlah = $_SESSION['jumlah'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah . '</div>';
                                            unset($_SESSION['jumlah']);
                                        }
                                        ?>
                                        <label for="jumlah">Jumlah</label>
                                    </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="col s12">
                            <div class="col s6">
                                <button type="ok" name="ok" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>
                                <?php
                                if (isset($_REQUEST['ok'])) {
                                    //validasi form kosong
                                    if (empty($_POST['nama_part']) && empty($_POST['tipe']) && empty($_POST['jumlah'])) {
                                        $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        $nama_part = $_REQUEST['nama_part'];
                                        $jumlah = $_REQUEST['jumlah'];
                                        $tipe = $_REQUEST['tipe'];
                                        $id_utility = $_SESSION['id_utility'];
                                        @session_start();
                                        if (!isset($_SESSION["tableDet"])) {
                                            $i = 0;
                                        } else {
                                            $tableDet = $_SESSION["tableDet"];
                                            $i = count($tableDet);
                                        }

                                        $tableDet[$i]['nama_part'] = $nama_part;
                                        $tableDet[$i]['tipe'] = $tipe;
                                        $tableDet[$i]['jumlah'] = $jumlah;
                                        $tableDet[$i]["mode_item"] = "N";
                                        $tableDet[$i]["i"] = $i;

                                        $_SESSION["tableDet"] = $tableDet;
                                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=master_utility&act=add");
                                        die();
                                    }
                                }
                                ?>

                            </div>

                            <div class="col s6">
                                <a href="#!" class="modal-action modal-close btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                            </div>
                        </div>

                    </div>
            </div>
            </tr>
            </table>     
            <br>
            <br>
            </div>

            <div class="input-field col s12">
                <i class="material-icons prefix md-prefix">build</i>
                <input id="nama_utility" type="text" name="nama_utility" class="validate">
                <?php
                if (isset($_SESSION['nama_utility'])) {
                    $nama_utility = $_SESSION['nama_utility'];
                    ?><div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $nama_utility ?></div>
                    <?php
                    unset($_SESSION['nama_utility']);
                }
                ?>
                <label for="nama_utility">Nama Utility</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix md-prefix">add_location</i>
                <input id="lokasi" type="text" name="lokasi" class="validate">
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
                <input id="tgl" type="text" name="tgl" class="datepicker">
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
                <input id="merk" type="text" name="merk" class="validate">
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
                <input id="type" type="text" name="type" class="validate">
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
                <input id="sn" type="text" name="sn" class="validate">
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
                <input id="volt" type="text" name="volt" class="validate">
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
                <input id="kva" type="text" name="kva" class="validate">
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
                        <input class="file-path validate" type="text" placeholder="Upload file">
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
