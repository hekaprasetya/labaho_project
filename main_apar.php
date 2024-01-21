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
            $id_apar = $_REQUEST['id_apar'];
            $status_utility = $_POST['status_utility'];
            $id_user = $_SESSION['id_user'];



            // Periksa apakah status adalah "Diterima" sebelum mengupdate sisa_apar
            // Perbarui status_utility di tbl_approve_utility
            $cek_data_query = mysqli_query($config, "SELECT * FROM tbl_approve_utility WHERE id_apar='$id_apar'");
            $cek_data = mysqli_num_rows($cek_data_query);
            $cek_data_row = mysqli_fetch_array($cek_data_query);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_utility(status_utility, id_apar, id_user)
                                                VALUES('$status_utility', '$id_apar', '$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_utility SET status_utility='$status_utility',
                    id_apar='$id_apar', id_user='$id_user' WHERE id_app_utility=$cek_data_row[id_app_utility]");
            }
            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=apar");
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
            // Alihkan ke halaman yang sesuai
            header("Location: ./admin.php?page=apar");
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
                    'add' => 'tambah_apar.php',
                    'edit' => 'edit_apar.php',
                    'del' => 'hapus_apar.php',
                    'laporan' => 'report_apar.php'
                ];
                if (isset($_REQUEST['act'])) {
                    $act = $_REQUEST['act'];
                    if (array_key_exists($act, $actArray)) {
                        $halaman = $actArray[$act];
                        (file_exists($halaman)) ? include $halaman :  print("File tidak ditemukan: $halaman");
                    } else {
                        echo "Halaman tidak ditemukan!";
                    }
                } else {


                    $query = mysqli_query($config, "SELECT utility_apar FROM tbl_sett");
                    list($utility_apar) = mysqli_fetch_array($query);

                    //pagging
                    $limit = $utility_apar;
                    $pg = @$_GET['pg'];
                    if (empty($pg)) {
                        $curr = 0;
                        $pg = 1;
                    } else {
                        $curr = ($pg - 1) * $limit;
                    }

                    // untuk function
                    $apar = new CRUD();

                    // id pada tabel berisi id_"$id_name" 
                    $apar->id_name = 'apar';

                    // nama tabel utama halaman
                    $apar->tbl_name = 'utility_apar';

                    // page halaman pemangilan di admin
                    $apar->pg_name = 'apar';

                    // judul pada secon nav
                    $apar->judul = "APAR";

                    // icon untuk judul
                    $apar->icon_judul = "whatshot";

                    // status approve 
                    $apar->status = "status_utility";

                    // array isi ari tabel
                    $isi_row = array("no_form", "tanggal", "nama", "jenis_apar", "berat", "posisi", "keterangan", "status");
                    $header = array("No.Form", "Tanggal", "Pemeriksa", "jenis Apar", "Berat", "Posisi", "Keterangan", "Status");

                    // SECONDARY NAV START
                    $apar->judul_s();
                    // SECONDARY NAV END

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
                    <button class="btn waves-effect waves-light light-blue" style="border-radius:7px;" onclick="window.location.href='?page=<?= $apar->pg_name ?>&act=laporan'">Laporan
                        <i class="material-icons right">description</i>
                    </button>

                    <!-- Row form Start -->
                    <div class="row">
                        <?php
                        // membuat varibel untuk mengambil data
                        $query_apar = "SELECT a.*,
                    b.id_app_utility,status_utility,waktu_utility,
                    c.nama
                    FROM $apar->tbl_name a
                    LEFT JOIN tbl_approve_utility b ON a.id_apar = b.id_apar 
                    LEFT JOIN tbl_user c ON a.id_user = c.id_user ";

                        if (isset($_REQUEST['submit'])) {
                            $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        ?>
                            <div class="col s12" style="margin-top: -18px;">
                                <div class="card blue lighten-5">
                                    <div class="card-content">
                                        <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=apar"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col m12" id="colres">
                                <table class="bordered centered" id="tbl">
                                    <thead class="blue lighten-4" id="head">
                                        <tr>
                                            <th>No</th>
                                            <?php foreach ($header as $head) { ?>
                                                <th><?= ucfirst(str_replace('_', ' ', $head)) ?></th> <?php } ?>
                                            <th>Bukti Foto</th>
                                            <th>Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        //script untuk mencari data
                                        // menambahkan untuk variabel query untuk mencari
                                        $query_apar .= "WHERE (jenis_apar LIKE '%$cari%' 
                                    OR nama LIKE '%$cari%' 
                                    OR posisi LIKE '%$cari%' 
                                    OR berat LIKE '%$cari%' 
                                    OR keterangan LIKE '%$cari%' 
                                    OR tanggal LIKE '%$cari%')
                                    AND a.tanggal
                                    ORDER by id_apar DESC";
                                        // meenggunakan fuction query
                                        $result = mysqli_query($config, $query_apar);
                                        $cek = mysqli_num_rows($result);
                                        if ($cek) {
                                            $no = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id_apar'];
                                                $apar->id = $row['id_apar'];
                                                $apar->file = $row['file'];
                                                $apar->dir = "upload/apar/$apar->file";
                                        ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <?php
                                                    foreach ($isi_row as $kolom) {
                                                        if ($kolom == "tanggal") {
                                                            // Jika kolom adalah 'tgl_panel', terapkan fungsi indoDateTime
                                                    ?>
                                                            <td><?= indoDate($row[$kolom]) ?></td>
                                                        <?php
                                                        } else {
                                                            // Untuk kolom lainnya
                                                        ?>
                                                            <td><?= $row[$kolom] ?></td>
                                                    <?php
                                                        }
                                                    }
                                                    $apar->tampilFile(); ?>
                                                    <td>
                                                        <?php
                                                        if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 100 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                            if ($_SESSION['admin']) {
                                                                $apar->crud();
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
                                                                <a class="btn small modal-trigger waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approve" href="#modal2<?= $id ?>"><i class="md-7 material-icons">assignment_turned_in</i></a>

                                                                <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=<?= $apar->pg_name ?>&act=edit&id_<?= $apar->id_name ?>=<?= $id ?>">
                                                                    <i class="md-7 material-icons">edit</i></a>

                                                                <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=<?= $apar->pg_name ?>&act=del&id_<?= $apar->id_name ?>=<?= $id ?>">
                                                                    <i class="md-7 material-icons">delete</i></a>
                                                        <?php

                                                            }
                                                        }
                                                        $apar->modalApp();
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php
                                                $no++;
                                            }
                                        } else {
                                            $apar->nodata();
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <!-- Row form END -->
                <?php } else { ?>
                    <div class="col m12" id="colres">
                        <table class="bordered centered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <?php foreach ($header as $head) { ?>
                                        <th><?= ucfirst(str_replace('_', ' ', $head)) ?></th> <?php } ?>
                                    <th>Bukti Foto</th>
                                    <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                    <?php $apar->hal($config); ?>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk menampilkan data
                                // menambahkan untuk variabel query untuk mencari
                                $query_apar .= " WHERE a.tanggal ORDER BY id_apar DESC LIMIT $curr, $limit";
                                // meenggunakan fuction query
                                $result = mysqli_query($config, $query_apar);
                                $cek = mysqli_num_rows($result);
                                if ($cek) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_apar'];
                                        $apar->id = $row['id_apar'];
                                        $apar->file = $row['file'];
                                        $apar->dir = "upload/apar/$apar->file";
                                ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <?php
                                            foreach ($isi_row as $kolom) {
                                                if ($kolom == "tanggal") {
                                                    // Jika kolom adalah 'tgl_panel', terapkan fungsi indoDateTime
                                            ?>
                                                    <td><?= indoDate($row[$kolom]) ?></td>
                                                <?php
                                                } else {
                                                    // Untuk kolom lainnya
                                                ?>
                                                    <td><?= $row[$kolom] ?></td>
                                            <?php
                                                }
                                            }
                                            $apar->tampilFile(); ?>
                                            <td>
                                                <?php
                                                if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 100 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                    if ($_SESSION['admin']) {
                                                        $apar->crud();
                                                    }
                                                }
                                                // APPROVE
                                                if ($_SESSION['admin'] == 4 | $_SESSION['admin'] == 7) {
                                                    if (is_null($row['id_app_utility'])) {
                                                ?>
                                                        <a class="btn small red waves-effect waves-light tooltipped modal-trigger" data-position="left" data-tooltip="Tanggapi" href="#modal2<?= $id ?>"> <i class="material-icons">warning</i></a></span>
                                                    <?php
                                                    } else {
                                                    ?>

                                                        <a class="btn small modal-trigger waves-effect waves-light tooltipped" data-position="left" data-tooltip="Approve" href="#modal2<?= $id ?>"><i class="md-7 material-icons">assignment_turned_in</i></a>

                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=<?= $apar->pg_name ?>&act=edit&id_<?= $apar->id_name ?>=<?= $id ?>">
                                                            <i class="md-7 material-icons">edit</i></a>

                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=<?= $apar->pg_name ?>&act=del&id_<?= $apar->id_name ?>=<?= $id ?>">
                                                            <i class="md-7 material-icons">delete</i></a>
                                                <?php
                                                    }
                                                }
                                                $apar->modalApp();
                                                ?>

                                            </td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                } else {
                                    $apar->nodata();
                                }
                                ?>
                            </tbody>
                        </table>


                        <!-- Row form END -->
                        <?php $query = mysqli_query($config, "SELECT tanggal FROM utility_apar WHERE tanggal IS NOT NULL");
                            $cdata = mysqli_num_rows($query);
                            $cpg = ceil($cdata / $limit);

                            echo '<br/><!-- Pagination START -->
                                <ul class="pagination">';

                            if ($cdata > $limit) {

                                //first and previous pagging
                                if ($pg > 1) {
                                    $prev = $pg - 1;
                                    echo '<li><a href="?page=cuti&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                            <li><a href="?page=cuti&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                                } else {
                                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                            <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                                }

                                //perulangan pagging
                                for ($i = 1; $i <= $cpg; $i++) {
                                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                        if ($i == $pg)
                                            echo '<li class="active waves-effect waves-dark"><a href="?page=cuti&pg=' . $i . '"> ' . $i . ' </a></li>';
                                        else
                                            echo '<li class="waves-effect waves-dark"><a href="?page=cuti&pg=' . $i . '"> ' . $i . ' </a></li>';
                                    }
                                }

                                //last and next pagging
                                if ($pg < $cpg) {
                                    $next = $pg + 1;
                                    echo '<li><a href="?page=cuti&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                            <li><a href="?page=cuti&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                                } else {
                                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                            <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                                }
                                echo '
                            </ul>';
                            } else {
                                echo '';
                            } ?>
                    </div> <?php
                        }
                    }
                }
            }
        }
