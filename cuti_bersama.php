<script type="application/x-javascript">
    addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
    window.scrollTo(0, 1);
    }

    function confirmReset() {
    var r = confirm("Apakah Anda yakin ingin mereset sisa cuti?");
    if (r) {

    window.location.href = "?page=cuti&act=reset";
    // Menghilangkan animasi loading
    alert("Reset BERHASIL.");
    } else {
    alert("Reset dibatalkan.");
    }
    }
</script>
<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./admin.php?page=cuti_bersama");
    die();
} else {

    $actArray = [
        'del' => 'hapus_cuti_bersama.php'
    ];
    if (isset($_REQUEST['act'])) {
        $act = $_REQUEST['act'];
        if (array_key_exists($act, $actArray)) {
            $halaman = $actArray[$act];
            (file_exists($halaman)) ? include $halaman : print("File tidak ditemukan: $halaman");
        } else {
            echo "Halaman tidak ditemukan!";
        }
    } else {

        if (isset($_REQUEST['submita'])) {
            // validasi form kosong
            if (empty($_POST['jumlah_hari']) || empty($_POST['keterangan_cuti']) || empty($_POST['tgl_cutibs_awal']) || empty($_POST['tgl_cutibs_akhir'])) {
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                $no_form = $_POST['no_form'];
                $jumlah_hari = $_POST['jumlah_hari'];
                $tgl_cutibs_awal = $_POST['tgl_cutibs_awal'];
                $tgl_cutibs_akhir = $_POST['tgl_cutibs_akhir'];
                $keterangan_cuti = $_POST['keterangan_cuti'];
                $id_user = $_SESSION['id_user'];

                $query = mysqli_query($config, "INSERT INTO tbl_cuti_bersama (no_form, tgl_cutibs_awal, tgl_cutibs_akhir, jumlah_hari, keterangan_cuti, id_user) 
            VALUES ('$no_form','$tgl_cutibs_awal','$tgl_cutibs_akhir','$jumlah_hari','$keterangan_cuti','$id_user')");

                if ($query == true) {
                    if (isset($_SESSION["tableDet"])) {
                        unset($_SESSION["tableDet"]);
                    }
                    $query_sisa_cuti = mysqli_query($config, "UPDATE tbl_user SET sisa_cuti = sisa_cuti - $jumlah_hari WHERE jabatan !='Engineering'");
                    if ($query_sisa_cuti) {
                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query UPDATE sisa_cuti';
                    }
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=cuti_bersama");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }

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


        // SESSION START
        // HRD 
        if ($_SESSION['admin'] == 15 | $_SESSION['admin'] == 7) {
            if ($_SESSION['admin']) {
                ?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#!" class="judul"><i class="material-icons">control_point</i> Cuti Bersama</a></li>
                                    <li class="waves-effect waves-light"><a onclick="confirmReset()" class="judul"><i class="material-icons"> highlight_off</i> Reset Cuti</a>
                                    </li>
                                </ul>

                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->


                <!-- ROW START -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s9">
                                <i class="material-icons prefix md-prefix">looks_one</i>
                                <?php
                                // memulai mengambil datanya
                                $sql = mysqli_query($config, "SELECT id_cuti_bersama FROM tbl_cuti_bersama");

                                $result = mysqli_num_rows($sql);

                                $tahun_sekarang = date("Y");

                                $tahun_sebelumnya = date("Y", strtotime("- 1 day"));

                                // mereset hitungan
                                if ($tahun_sekarang != $tahun_sebelumnya) {
                                    $kode = 1;
                                } else {
                                    $kode = $result + 1;
                                }

                                // mulai bikin kode
                                $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                                $kode_jadi = "FM/HRD/$bikin_kode";


                                if (isset($_SESSION['no_form'])) {
                                    $id_tenant = $_SESSION['no_form'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form . '</div>';
                                    unset($_SESSION['no_form']);
                                }
                                ?>
                                <label for="no_form"><strong>No.FORM</strong></label>
                                <input type="text" class="form-control" id="no_form" name="no_form" value="<?= $kode_jadi ?>" disabled>
                                <input type="hidden" class="form-control" id="no_form" name="no_form" value="<?= $kode_jadi ?>">
                            </div>

                            <div class="input-field col s9">
                                <i class="material-icons prefix md-prefix">beach_access</i>
                                <input id="jumlah_hari" type="number" class="validate" name="jumlah_hari" required>
                                <?php
                                if (isset($_SESSION['jumlah_hari'])) {
                                    $jumlah_hari = $_SESSION['jumlah_hari'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jumlah_hari . '</div>';
                                    unset($_SESSION['jumlah_hari']);
                                }
                                ?>
                                <label for="jumlah_hari">Jumlah Hari</label>
                            </div>

                            <div class="input-field col s9">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="tgl_cutibs_awal" type="text" name="tgl_cutibs_awal" class="datepicker" required>
                                <?php
                                if (isset($_SESSION['tgl_cutibs_awal'])) {
                                    $tgl_cutibs_awal = $_SESSION['tgl_cutibs_awal'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_cutibs_awal . '</div>';
                                    unset($_SESSION['tgl_cutibs_awal']);
                                }
                                ?>
                                <label for="tgl_cutibs_awal">Tgl Mulai</label>
                            </div>

                            <div class="input-field col s9">
                                <i class="material-icons prefix md-prefix">event_available</i>
                                <input id="tgl_cutibs_akhir" type="text" name="tgl_cutibs_akhir" class="datepicker" required>
                                <?php
                                if (isset($_SESSION['tgl_cutibs_akhir'])) {
                                    $tgl_cutibs_akhir = $_SESSION['tgl_cutibs_akhir'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_cutibs_akhir . '</div>';
                                    unset($_SESSION['tgl_cutibs_akhir']);
                                }
                                ?>
                                <label for="tgl_cutibs_akhir">Tgl Akhir</label>
                            </div>

                            <div class="input-field col s9">
                                <i class="material-icons prefix md-prefix">assignment</i>
                                <input id="keterangan_cuti" type="text" class="validate" name="keterangan_cuti" required>
                                <?php
                                if (isset($_SESSION['keterangan_cuti'])) {
                                    $keterangan = $_SESSION['keterangan_cuti'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan_cuti . '</div>';
                                    unset($_SESSION['keterangan_cuti']);
                                }
                                ?>
                                <label for="keterangan_cuti">Keterangan Cuti</label>
                            </div>
                        </div>
                        <!-- ROW IN FORM END -->
                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>

                            </div>
                            <div class="col 6">
                                <a href="?page=cuti" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                            </div>
                        </div>
                    </form>
                    <!-- FORM END -->
                </div>
                <!-- ROW END -->
                <?php
            }
        }
        // SESSION END
        // GM
        if ($_SESSION['admin'] == 7 | $_SESSION['admin'] == 15 | $_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18 | $_SESSION['admin'] == 4 | $_SESSION['admin'] == 7 | $_SESSION['admin'] == 8 | $_SESSION['admin'] == 10 | $_SESSION['admin'] == 13) {
            if ($_SESSION['admin']) {
                $query = mysqli_query($config, "SELECT cuti_bersama FROM tbl_sett");
                list($cuti_bersama) = mysqli_fetch_array($query);

                //pagging
                $limit = $cuti_bersama;
                $pg = @$_GET['pg'];
                if (empty($pg)) {
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
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
                                            <li>
                                                <a class="dropdown-button judul" href="#!" data-activates="cuti_dashboard"><i class="material-icons md-20">account_circle</i> Daftar Cuti<i class="material-icons md-18"> arrow_drop_down</i></a>
                                                <ul id="cuti_dashboard" class="dropdown-content">
                                                    <li>
                                                        <a href="?page=cuti"><i class="material-icons md-18"> cloud_done</i> Cuti Pilihan</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="?page=cuti_normatif"><i class="material-icons md-18"> cloud_circle</i> Ijin Normatif</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="?page=cuti_bersama"><i class="material-icons md-18"> cloud_download</i> Cuti Bersama</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!-- Secondary Nav END -->
                </div>
                <div class="z-depth-1">
                    <center>
                        <li class="waves-effect waves-light">
                            <a href=""><i class="material-icons md-24">cloud_download</i> HAL. CUTI BERSAMA</a>
                        </li>
                    </center>
                    <nav class="secondary-nav yellow darken-3">
                        <form method="post" action="?page=cuti_bersama">
                            <center><div class="input-field round-in-box">
                                    <input id="search" type="search" name="cari" placeholder="Searching" required>
                                    <label for="search"><i class="material-icons md-dark">search</i></label>
                                    <input type="submit" name="submit" class="hidden">
                                </div>
                            </center>
                        </form>
                    </nav>
                </div>
                <!-- Row END -->

                <!-- Row form Start -->
                <div class="row jarak-form">
                    <?php
                    // membuat varibel untuk mengambil data
                    $query_cuti_bersama = "SELECT * FROM tbl_cuti_bersama ";
                    ?>
                    <?php
                    if (isset($_REQUEST['submit'])) {
                        $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        ?>
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=cuti_bersama"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                            <table class="centered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th>No</th>
                                        <th>No.Form</th>
                                        <th>Jumlah Hari</th>
                                        <th>Tgl Mulai</th>
                                        <th>Tgl Akhir</th>
                                        <th>Keterangan Cuti <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //script untuk mencari data
                                    // menambahkan untuk variabel query untuk mencari
                                    $query_cuti_bersama .= "WHERE jumlah_hari LIKE '%$cari%' 
                                    OR keterangan_cuti LIKE '%$cari%' 
                                    ORDER by id_cuti_bersama DESC";
                                    // meenggunakan fuction query
                                    $result = query($query_cuti_bersama);

                                    if (!empty($result)) {
                                        $no = 1;
                                        foreach ($result as $row) {
                                            $id = $row->id_cuti_bersama;
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row->no_form ?></td>
                                                <td><?= $row->jumlah_hari ?></td>
                                                <td><?= indoDate($row->tgl_cutibs_awal) ?></td>
                                                <td><?= indoDate($row->tgl_cutibs_akhir) ?></td>
                                                <td><?= $row->keterangan_cuti ?></td>
                                            </tr>
                                            <?php
                                            $no++;
                                        }
                                    } else {
                                        ?><tr>
                                            <td colspan="5">
                                    <center>
                                        <p class="add">Tidak ada data untuk ditampilkan. <u><a href="#!">Tidak ada Cuti</a></u></p>
                                    </center>
                                    </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Row form END -->
                    <?php
                } else {
                    ?>
                    <div class="col m12" id="colres">
                        <table class="bordered centered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <th>No.Form</th>
                                    <th>Jumlah Hari</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Akhir</th>
                                    <th>Tindakan</th>
                                    <th>Keterangan Cuti <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                            <div id="modal" class="modal">
                                <div class="modal-content white">
                                    <h5>Jumlah data yang ditampilkan per halaman</h5>
                                    <?php
                                    $query = mysqli_query($config, "SELECT id_sett, cuti_bersama FROM tbl_sett");
                                    list($id_sett, $cuti_bersama) = mysqli_fetch_array($query);
                                    ?>
                                    <div class="row">
                                        <form method="post" action="">
                                            <div class="input-field col s12">
                                                <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                                <div class="input-field col s1" style="float: left;">
                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                </div>
                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                    <select class="browser-default validate" name="cuti_bersama" required>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="20">20</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer white">
                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>
                                                    <?php
                                                    if (isset($_REQUEST['simpan'])) {
                                                        $id_sett = "1";
                                                        $cuti_bersama = $_REQUEST['cuti_bersama'];

                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET cuti_bersama='$cuti_bersama' WHERE id_sett='$id_sett'");
                                                        if ($query == true) {
                                                            header("Location: ./admin.php?page=cuti_bersama");
                                                            die();
                                                        }
                                                    }
                                                    ?>
                                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk menampilkan data
                                // menambahkan untuk variabel query untuk mencari
                                $query_cuti_bersama .= " ORDER by id_cuti_bersama DESC LIMIT $curr, $limit";
                                // meenggunakan fuction query
                                $result = query($query_cuti_bersama);

                                if (empty($result)) {
                                    ?><tr>
                                        <td colspan="5">
                                <center>
                                    <p class="add">Tidak ada data untuk ditampilkan. <u><a href="#!">Tidak ada Cuti</a></u></p>
                                </center>
                                </td>
                                </tr>
                                <?php
                            } else {
                                $no = 1;
                                foreach ($result as $row) {
                                    $id = $row->id_cuti_bersama;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row->no_form ?> </td>
                                        <td><?= $row->jumlah_hari ?> </td>
                                        <td><?= indoDate($row->tgl_cutibs_awal) ?></td>
                                        <td><?= indoDate($row->tgl_cutibs_akhir) ?></td>
                                        <td><?= $row->keterangan_cuti ?></td>
                                        <td> <a class="btn small red darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus" href="?page=cuti_bersama&act=del&id_cuti_bersama=<?= $row->id_cuti_bersama ?>">
                                                <i class="material-icons">delete</i></a>                                                                                                                               
                                        </td>                                                                                                                                                                                            
                                    </tr>
                                    <?php
                                    $no++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>


                        <!-- Row form END -->
                        <?php
                        $query = mysqli_query($config, "SELECT * FROM tbl_cuti_bersama");
                        $cdata = mysqli_num_rows($query);
                        $cpg = ceil($cdata / $limit);
                        ?><br /><!-- Pagination START -->
                        <ul class="pagination">
                            <?php
                            if ($cdata > $limit) {

                                //first and previous pagging
                                if ($pg > 1) {
                                    $prev = $pg - 1;
                                    ?><li><a href="?page=cuti_bersama&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                    <li><a href="?page=cuti_bersama&pg=<?= $prev ?>"><i class="material-icons md-48">chevron_left</i></a></li>
                                    <?php
                                } else {
                                    ?><li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>
                                    <?php
                                }

                                //perulangan pagging
                                for ($i = 1; $i <= $cpg; $i++) {
                                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                        if ($i == $pg) {
                                            ?><li class="active waves-effect waves-dark"><a href="?page=cuti_bersama&pg=<?= $i ?>"> <?= $i ?> </a></li>
                                                <?php
                                            } else {
                                                ?><li class="waves-effect waves-dark"><a href="?page=cuti_bersama&pg=<?= $i ?>"> <?= $i ?> </a></li>
                                                <?php
                                            }
                                        }
                                    }
                                    //last and next pagging
                                    if ($pg < $cpg) {
                                        $next = $pg + 1;
                                        ?><li><a href="?page=cuti_bersama&pg=<?= $next ?>"><i class="material-icons md-48">chevron_right</i></a></li>
                                    <li><a href="?page=cuti_bersama&pg=<?= $cpg ?>"><i class="material-icons md-48">last_page</i></a></li>
                                    <?php
                                } else {
                                    ?><li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                                    <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>
                                        <?php
                                    }
                                    ?>
                            </ul>
                            <?php
                        } else {
                            echo '';
                        }
                    }
                }
            }
        }
    }
