<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Interior Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
          Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
        window.scrollTo(0, 1);
        }
    </script>


    <?php
    //cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
        if (isset($_REQUEST['submita'])) {
            $id_chiller = $_REQUEST['id_chiller'];
            $status_utility = $_POST['status_utility'];
            $id_user = $_SESSION['id_user'];


            // Periksa apakah status adalah "Diterima" sebelum mengupdate sisa_panel
            // Perbarui status_utility di tbl_approve_utility
            $cek_data_query = mysqli_query($config, "SELECT * FROM tbl_approve_utility WHERE id_chiller='$id_chiller'");
            $cek_data = mysqli_num_rows($cek_data_query);
            $cek_data_row = mysqli_fetch_array($cek_data_query);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_utility(status_utility, id_chiller, id_user)
                                                VALUES('$status_utility', '$id_chiller', '$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_utility SET status_utility='$status_utility',
                    id_chiller='$id_chiller', id_user='$id_user' WHERE id_app_utility=$cek_data_row[id_app_utility]");
            }
            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=chiller");
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
            // Alihkan ke halaman yang sesuai
            header("Location: ./admin.php?page=chiller");
            die();
        } else {
            if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 2 and $_SESSION['admin'] != 3 and $_SESSION['admin'] != 4 and $_SESSION['admin'] != 5 and $_SESSION['admin'] != 6 and $_SESSION['admin'] != 7 and $_SESSION['admin'] != 8 and $_SESSION['admin'] != 9 and $_SESSION['admin'] != 10 and $_SESSION['admin'] != 11 and $_SESSION['admin'] != 12 and $_SESSION['admin'] != 13 and $_SESSION['admin'] != 14 and $_SESSION['admin'] != 15) {
                ?><script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href = "./logout.php";
                </script>
                <?php
            } else {
                $actArray = [
                    'add' => 'tambah_chiller.php',
                    'edit' => 'edit_chiller.php',
                    'del' => 'hapus_chiller.php',
                    'laporan' => 'report_chiller.php'
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

                    $query = mysqli_query($config, "SELECT utility_chiller FROM tbl_sett");
                    list($utility_chiller) = mysqli_fetch_array($query);

                    //pagging
                    $limit = $utility_chiller;
                    $pg = @$_GET['pg'];
                    if (empty($pg)) {
                        $curr = 0;
                        $pg = 1;
                    } else {
                        $curr = ($pg - 1) * $limit;
                    }

                    // untuk function
                    $chiller = new CRUD();

                    // id pada tabel berisi id_"$id_name" 
                    $chiller->id_name = 'chiller';

                    // nama tabel utama halaman
                    $chiller->tbl_name = 'utility_chiller';

                    // page halaman pemangilan di admin
                    $chiller->pg_name = 'chiller';

                    // judul pada secon nav
                    $chiller->judul = "CHILLER";

                    // icon untuk judul
                    $chiller->icon_judul = "build";

                    // status approve 
                    $chiller->status = "status_utility";

                    // SECONDARY NAV START
                    $chiller->judul_s();
                    // SECONDARY NAV END
                    ?>


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

                <br>
                <button class="btn waves-effect waves-light light-blue" style="border-radius:7px;" onclick="window.location.href = '?page=<?= $chiller->pg_name ?>&act=laporan'">Laporan
                    <i class="material-icons right">description</i>
                </button>

                <!-- Row form Start -->
                <div class="row">
                    <?php
                    // membuat varibel untuk mengambil data
                    $query_chiller = "SELECT a.*,
                    b.id_app_utility,status_utility,waktu_utility,
                    c.nama
                    FROM utility_chiller a
                    LEFT JOIN tbl_approve_utility b ON a.id_chiller = b.id_chiller
                    LEFT JOIN tbl_user c ON a.id_user = c.id_user  ";
                    ?>
                    <?php
                    if (isset($_REQUEST['submit'])) {
                        $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        ?>
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=chiller"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                            <table class="bordered centered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th>No</th>
                                        <th>Form<br>
                                <hr>Waktu
                                </th>
                                <th>Pemeriksa<br>
                                <hr>Nama Chiller
                                </th>
                                <th>Leaving Evap<br>
                                <hr>Entering Evap
                                </th>
                                <th>Set Point
                                </th>
                                <th>HP Circuit 1<br>
                                <hr>LP Circuit 2
                                </th>
                                <th>HP Circuit 1<br>
                                <hr>LP Circuit 2
                                </th>
                                <th>In Condensor<br>
                                <hr>Out Condensor
                                </th>
                                <th>Ampere</th>
                                <th>Pemeriksa</th>
                                <th>Supervisor</th>
                                <th>ID Utility</th>

                                <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span>
                                </th>
                                <?php
                                $chiller->hal($config);
                                ?>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //script untuk mencari data
                                    // menambahkan untuk variabel query untuk mencari
                                    $query_chiller .= "WHERE no_form LIKE '%$cari%' 
                                    OR nama_chiller LIKE '%$cari%' 
                                    OR tgl_chiller LIKE '%$cari%' 
                                    OR nama LIKE '%$cari%' 
                                   
                                    ORDER by id_chiller DESC";
                                    // meenggunakan fuction query
                                    $result = mysqli_query($config, $query_chiller);
                                    $cek = mysqli_num_rows($result);
                                    if ($cek) {
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id_chiller'];
                                            $chiller->id = $row['id_chiller'];
                                            $chiller->file = $row['file'];
                                            $chiller->dir = "upload/chiller/$chiller->file";
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row['no_form'] ?> <br>
                                                    <hr><?= indoDateTime($row['tgl_chiller']) ?>
                                                </td>
                                                <td><?= $row['nama'] ?><br>
                                                    <hr><?= $row['nama_chiller'] ?>
                                                </td>
                                                <td><?= $row['leaving_evap'] ?><br>
                                                    <hr><?= $row['entering_evap'] ?>
                                                </td>
                                                <td><?= $row['setpoint'] ?></td>
                                                <td><?= $row['hp_c1'] ?><br>
                                                    <hr><?= $row['lp_c2'] ?>
                                                </td>
                                                <td><?= $row['hp_c1'] ?><br>
                                                    <hr><?= $row['lp_c2'] ?>
                                                </td>
                                                <td><?= $row['in_condensor'] ?><br>
                                                    <hr><?= $row['out_condensor'] ?>
                                                </td>
                                                <td><?= $row['ampere'] ?><br>
                                                    <hr><?= $row['oat'] ?>
                                                </td>
                                                <td><?= $row['approach'] ?></td>
                                                <td><?= $row['status_utility'] ?></td>
                                                <td><i><?= $row['id_utility'] ?></i></td>
                                                <td>
                                                    <?php
                                                    if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 100 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                        if ($_SESSION['admin']) {
                                                            $chiller->crud();
                                                        }
                                                    }
                                                    //**KABAG APPROVE
                                                    if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7) {
                                                        if (is_null($row['id_app_utility'])) {
                                                            ?>
                                                            <a class="btn small red waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Tanggapi" href="#modal2<?= $id ?>"> <i class="material-icons">warning</i></a></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="row">
                                                                <a class="btn small modal-trigger" href="#modal2<?= $id ?>">
                                                                    <i class="material-icons">assignment_turned_in</i></a><br>
                                                                <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=<?= $chiller->pg_name ?>&act=edit&id_<?= $chiller->id_name ?>=<?= $id ?>">
                                                                    <i class="material-icons">edit</i></a>
                                                             <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus" onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=chiller&act=del&id_chiller=<?= $row['id_chiller'] ?>">
                                                                <i class="material-icons">delete</i> </a>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    $chiller->modalApp();
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $no++;
                                        }
                                    } else {
                                        $chiller->nodata();
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
                                    <th>Form <br>
                            <hr>Waktu
                            </th>
                            <th>Pemeriksa<br>
                            <hr>Nama Chiller
                            </th>
                            <th>Leaving Evap<br>
                            <hr>Entering Evap
                            </th>
                            <th>Set Point
                            </th>
                            <th>HP Circuit 1<br>
                            <hr>LP Circuit 2
                            </th>
                            <th>HP Circuit 1<br>
                            <hr>LP Circuit 2
                            </th>
                            <th>In Condensor<br>
                            <hr>Out Condensor
                            </th>
                            <th>Ampere<br>
                            <hr>Oat
                            </th>
                            <th>Approach</th>
                            <th>Supervisor</th>
                            <th>ID Utility</th>

                            <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span>
                            </th>
                            <?php
                            $chiller->hal($config);
                            ?>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk menampilkan data
                                // menambahkan untuk variabel query untuk mencari
                                $query_chiller .= " ORDER BY id_chiller DESC LIMIT $curr, $limit";
                                // meenggunakan fuction query
                                $result = mysqli_query($config, $query_chiller);
                                $cek = mysqli_num_rows($result);
                                if ($cek) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_chiller'];
                                        $chiller->id = $row['id_chiller'];
                                        $chiller->file = $row['file'];
                                        $chiller->dir = "upload/chiller/$chiller->file";
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $row['no_form'] ?> <br>
                                                <hr><?= indoDateTime($row['tgl_chiller']) ?>
                                            </td>
                                            <td><?= $row['nama'] ?><br>
                                                <hr><?= $row['nama_chiller'] ?>
                                            </td>
                                            <td><?= $row['leaving_evap'] ?><br>
                                                <hr><?= $row['entering_evap'] ?>
                                            </td>
                                            <td><?= $row['setpoint'] ?></td>
                                            <td><?= $row['hp_c1'] ?><br>
                                                <hr><?= $row['lp_c2'] ?>
                                            </td>
                                            <td><?= $row['hp_c1'] ?><br>
                                                <hr><?= $row['lp_c2'] ?>
                                            </td>
                                            <td><?= $row['in_condensor'] ?><br>
                                                <hr><?= $row['out_condensor'] ?>
                                            </td>
                                            <td><?= $row['ampere'] ?><br>
                                                <hr><?= $row['oat'] ?>
                                            </td>
                                            <td><?= $row['approach'] ?></td>
                                            <td><?= $row['status_utility'] ?></td>
                                            <td><i><?= $row['id_utility'] ?></i></td>
                                            <td>
                                                <?php
                                                if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 100 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                    if ($_SESSION['admin']) {
                                                        $chiller->crud();
                                                    }
                                                }
                                                //**KABAG APPROVE
                                                if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7) {
                                                    if (is_null($row['id_app_utility'])) {
                                                        ?>
                                                        <a class="btn small red waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Tanggapi" href="#modal2<?= $id ?>"> <i class="material-icons">warning</i></a></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="row">
                                                            <a class="btn small modal-trigger" href="#modal2<?= $id ?>">
                                                                <i class="material-icons">assignment_turned_in</i></a><br>
                                                            <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit" href="?page=<?= $chiller->pg_name ?>&act=edit&id_<?= $chiller->id_name ?>=<?= $id ?>">
                                                                <i class="material-icons">edit</i></a>
                                                            <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus" onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=chiller&act=del&id_chiller=<?= $row['id_chiller'] ?>">
                                                                <i class="material-icons">delete</i>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                $chiller->modalApp();
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                } else {
                                    $chiller->nodata();
                                }
                                ?>
                            </tbody>
                        </table>


                        <!-- Row form END -->
                        <?= $chiller->pagging($conn, $limit, $pg) ?>
                    </div>
                    <?php
                }
            }
        }
    }
}
