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
            $id_ac = $_REQUEST['id_ac'];
            $status_utility = $_POST['status_utility'];
            $id_user = $_SESSION['id_user'];



            // Periksa apakah status adalah "Diterima" sebelum mengupdate sisa_ac
            // Perbarui status_utility di tbl_approve_utility
            $cek_data_query = mysqli_query($config, "SELECT * FROM tbl_approve_utility WHERE id_ac='$id_ac' ");
            $cek_data = mysqli_num_rows($cek_data_query);
            $cek_data_row = mysqli_fetch_array($cek_data_query);
            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_utility(status_utility, id_ac, id_user)
                                                VALUES('$status_utility', '$id_ac', '$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_utility SET status_utility='$status_utility',
                    id_ac='$id_ac', id_user='$id_user' WHERE id_app_utility=$cek_data_row[id_app_utility]");
            }
            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=ac");
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
            // Alihkan ke halaman yang sesuai
            header("Location: ./admin.php?page=ac");
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
                    'add' => 'tambah_ac.php',
                    'edit' => 'edit_ac.php',
                    'del' => 'hapus_ac.php',
                    'laporan' => 'report_ac.php'
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


                    $query = mysqli_query($config, "SELECT utility_ac FROM tbl_sett");
                    list($utility_ac) = mysqli_fetch_array($query);

                    //pagging
                    $limit = $utility_ac;
                    $pg = @$_GET['pg'];
                    if (empty($pg)) {
                        $curr = 0;
                        $pg = 1;
                    } else {
                        $curr = ($pg - 1) * $limit;
                    }

                    // untuk function
                    $ac = new CRUD();

                    // id pada tabel berisi id_"$id_name" 
                    $ac->id_name = 'ac';

                    // nama tabel utama halaman
                    $ac->tbl_name = 'utility_ac';

                    // page halaman pemangilan di admin
                    $ac->pg_name = 'ac';

                    // judul pada secon nav
                    $ac->judul = "Air Conditioner";

                    // icon untuk judul
                    $ac->icon_judul = "ac_unit";

                    // status approve 
                    $ac->status = "status_utility";
                    // untuk isi tabel <tbody></tbody>
                    $isi_row1 = array("no_form", "nama", "cuci_unit", "kondisi_outdoor", "arus_ac");
                    $isi_row2 = array("tgl_ac", "nama_ac", "kondisi_kompressor", "kondisi_indoor", "isi_freon");
                    // untuk judul tabel <thead></thead>
                    $header1 = array("no.Form", "Pemeriksa", "cuci_unit", "kondisi_outdoor", "arus_ac");
                    $header2 = array("tanggal", "AC", "kondisi_kompressor", "kondisi_indoor", "isi_freon");

                    // SECONDARY NAV START
                    $ac->judul_s();
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
                    <button class="btn waves-effect waves-light light-blue" style="border-radius:7px;" onclick="window.location.href = '?page=<?= $ac->pg_name ?>&act=laporan'">Laporan
                        <i class="material-icons right">description</i>
                    </button>
                    
                    <!-- Row form Start -->
                    <div class="row">
                        <?php
                        // membuat varibel untuk mengambil data
                        $query_ac = "SELECT a.*,
                    b.id_app_utility,status_utility,waktu_utility,
                    c.nama
                    FROM $ac->tbl_name a
                    LEFT JOIN tbl_approve_utility b ON a.id_ac = b.id_ac 
                    LEFT JOIN tbl_user c ON a.id_user = c.id_user ";

                        if (isset($_REQUEST['submit'])) {
                            $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        ?>
                            <div class="col s12" style="margin-top: -18px;">
                                <div class="card blue lighten-5">
                                    <div class="card-content">
                                        <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=ac"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col m12" id="colres">
                                <table class="bordered centered" id="tbl">
                                    <the<tr>
                                    <th>No</th>
                                    <?php foreach ($header2 as $index => $kolom) {
                                        $head = $header1[$index] ?>
                                        <th><?= ucfirst(str_replace('_', ' ', $head)) ?><br>
                                            <hr>
                                            <?= ucfirst(str_replace('_', ' ', $kolom)) ?>
                                        </th> <?php } ?>
                                        <th>Lain2</th>
                                        <th>ID Utility</th>
                                    <th>Bukti Foto</th>
                                    <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                    <?php $ac->hal($config); ?>

                                </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        //script untuk mencari data
                                        // menambahkan untuk variabel query untuk mencari
                                        $query_ac .= "WHERE nama_ac LIKE '%$cari%' 
                                                        OR nama LIKE '%$cari%' 
                                                        OR kondisi_kompressor LIKE '%$cari%' 
                                                        OR kondisi_outdoor LIKE '%$cari%' 
                                                        OR kondisi_indoor LIKE '%$cari%' 
                                                        OR arus_ac LIKE '%$cari%'
                                                        OR tgl_ac LIKE '%$cari%' 
                                                        OR isi_freon LIKE '%$cari%' 
                                                        OR lain LIKE '%$cari%' 
                                                        ORDER by id_ac DESC";
                                        // meenggunakan fuction query
                                        $result = mysqli_query($config, $query_ac);
                                        $cek = mysqli_num_rows($result);
                                        if ($cek) {
                                            $no = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id_ac'];
                                                $ac->id = $row['id_ac'];
                                                $ac->file = $row['file'];
                                                $ac->dir = "upload/ac/$ac->file";
                                        ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <?php foreach ($isi_row2 as $index => $kolom) {
                                                        $head = $isi_row1[$index]; ?>
                                                        <td><?= $row[$head] ?><br>
                                                            <hr>
                                                            <?php if ($kolom == "tgl_ac") {
                                                                echo  indoDate($row['tgl_ac']);
                                                            } else {
                                                                echo $row[$kolom];
                                                            } ?>
                                                        </td>
                                                     <?php } ?>
                                                         <td><?= $row['lain'] ?></td>
                                                         <td><?= $row['id_utility'] ?></td>
                                                        <?php $ac->tampilFile(); ?>
                                                    <td>
                                                        <?php
                                                        if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 100 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                            if ($_SESSION['admin']) {
                                                                $ac->crud();
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

                                                                <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=<?= $ac->pg_name ?>&act=edit&id_<?= $ac->id_name ?>=<?= $id ?>">
                                                                    <i class="md-7 material-icons">edit</i></a>

                                                                <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=<?= $ac->pg_name ?>&act=del&id_<?= $ac->id_name ?>=<?= $id ?>">
                                                                    <i class="md-7 material-icons">delete</i></a>
                                                        <?php

                                                            }
                                                        }
                                                        $ac->modalApp();
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php
                                                $no++;
                                            }
                                        } else {
                                            $ac->nodata();
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
                                    <?php foreach ($header2 as $index => $kolom) {
                                        $head = $header1[$index] ?>
                                        <th><?= ucfirst(str_replace('_', ' ', $head)) ?><br>
                                            <hr>
                                            <?= ucfirst(str_replace('_', ' ', $kolom)) ?>
                                        </th> <?php } ?>
                                        <th>Lain2</th>
                                        <th>ID Utility</th>
                                    <th>Bukti Foto</th>
                                    <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                    <?php $ac->hal($config); ?>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk menampilkan data
                                // menambahkan untuk variabel query untuk mencari
                                $query_ac .= "  ORDER BY id_ac DESC LIMIT $curr, $limit";
                                // meenggunakan fuction query
                                $result = mysqli_query($config, $query_ac);
                                $cek = mysqli_num_rows($result);
                                if ($cek) {
                                    $no = 1;

                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_ac'];
                                        $ac->id = $row['id_ac'];
                                        $ac->file = $row['file'];
                                        $ac->dir = "upload/ac/$ac->file";
                                ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <?php foreach ($isi_row2 as $index => $kolom) {
                                                $head = $isi_row1[$index]; ?>
                                                <td><?= $row[$head] ?><br>
                                                    <hr>
                                                    <?php if ($kolom == "tgl_ac") {
                                                        echo  indoDate($row['tgl_ac']);
                                                    } else {
                                                        echo $row[$kolom];
                                                    } ?>
                                                </td>
                                            <?php } ?>
                                             <td><?= $row['lain'] ?></td>
                                             <td><?= $row['id_utility'] ?></td>
                                            <?php $ac->tampilFile(); ?>
                                            <td>
                                                <?php
                                                if ($_SESSION['admin'] == 2 | $_SESSION['admin'] == 3 | $_SESSION['admin'] == 5 | $_SESSION['admin'] == 6 | $_SESSION['admin'] == 100 | $_SESSION['admin'] == 14 | $_SESSION['admin'] == 18) {
                                                    if ($_SESSION['admin']) {
                                                        $ac->crud();
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

                                                        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Alat" href="?page=<?= $ac->pg_name ?>&act=edit&id_<?= $ac->id_name ?>=<?= $id ?>">
                                                            <i class="md-7 material-icons">edit</i></a>

                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=<?= $ac->pg_name ?>&act=del&id_<?= $ac->id_name ?>=<?= $id ?>">
                                                            <i class="md-7 material-icons">delete</i></a>
                                                <?php
                                                    }
                                                }
                                                $ac->modalApp();
                                                ?>

                                            </td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                } else {
                                    $ac->nodata();
                                }
                                ?>
                            </tbody>
                        </table>


                        <!-- Row form END -->
                        <?= $ac->pagging($conn, $limit, $pg) ?>
                    </div> <?php
                        }
                    }
                }
            }
        }
