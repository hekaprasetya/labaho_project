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

        if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 2 and $_SESSION['admin'] != 3 and $_SESSION['admin'] != 4 and $_SESSION['admin'] != 5 and $_SESSION['admin'] != 6 and $_SESSION['admin'] != 7 and $_SESSION['admin'] != 8 and $_SESSION['admin'] != 9 and $_SESSION['admin'] != 10 and $_SESSION['admin'] != 11 and $_SESSION['admin'] != 12 and $_SESSION['admin'] != 13 and $_SESSION['admin'] != 14 and $_SESSION['admin'] != 15) {
    ?><script language="javascript">
                window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                window.location.href = "./logout.php";
            </script>
            <?php
        } else {


            $actArray = [
                'add' => 'tambah_master_apar.php',
                'edit' => 'edit_master_apar.php',
                'del' => 'hapus_master_apar.php'
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


                $query = mysqli_query($config, "SELECT master_apar FROM tbl_sett");
                list($master_apar) = mysqli_fetch_array($query);

                //pagging
                $limit = $master_apar;
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
                $apar->pg_name = 'master_apar';

                // judul pada secon nav
                $apar->judul = "MASTER APAR";

                // icon untuk judul
                $apar->icon_judul = "whatshot";

                // status approve 
                $apar->status = "status_utility";

                // array isi ari tabel
                $isi_row = array("posisi", "jenis_apar", "berat");
                $header = array("Posisi", "jenis Apar", "Berat");

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

                <!-- Row form Start -->
                <div class="row jarak-form">
                    <?php
                    // membuat varibel untuk mengambil data
                    $query_apar = "SELECT id_apar,posisi, jenis_apar, berat, tanggal FROM utility_apar ";

                    if (isset($_REQUEST['submit'])) {
                        $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                    <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=master_apar"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
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
                                        <th>Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //script untuk mencari data
                                    // menambahkan untuk variabel query untuk mencari
                                    $query_apar .= "WHERE (jenis_apar LIKE '%$cari%'
                                    OR posisi LIKE '%$cari%' 
                                    OR berat LIKE '%$cari%')
                                    AND tanggal IS NULL
                                    ORDER by id_apar DESC";
                                    // meenggunakan fuction query
                                    $result = mysqli_query($config, $query_apar);
                                    $cek = mysqli_num_rows($result);
                                    if ($cek) {
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id_apar'];
                                            $apar->id = $row['id_apar'];
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <?php
                                                foreach ($isi_row as $kolom) {
                                                ?> <td><?= $row[$kolom] ?></td> <?php
                                                                            } ?>
                                                <td><?= $apar->crud(); ?></td>
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
                                <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                <?php $apar->hal($config, $apar->tbl_name = 'master_apar'); ?>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            //script untuk menampilkan data
                            // menambahkan untuk variabel query untuk mencari
                            $query_apar .= " WHERE tanggal IS NULL ORDER BY id_apar DESC LIMIT $curr, $limit";
                            // meenggunakan fuction query
                            $result = mysqli_query($config, $query_apar);
                            $cek = mysqli_num_rows($result);
                            if ($cek) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id_apar'];
                                    $apar->id = $row['id_apar'];
                            ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <?php
                                        foreach ($isi_row as $kolom) {
                                        ?> <td><?= $row[$kolom] ?></td> <?php
                                                                    } ?>
                                        <td><?= $apar->crud(); ?></td>
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
                    <?php $query = mysqli_query($config, "SELECT * FROM utility_apar WHERE tanggal IS NULL");
                        $cdata = mysqli_num_rows($query);
                        $cpg = ceil($cdata / $limit);

                        echo '<br/><!-- Pagination START -->
                                <ul class="pagination">';

                        if ($cdata > $limit) {

                            //first and previous pagging
                            if ($pg > 1) {
                                $prev = $pg - 1;
                                echo '<li><a href="?page=master_apar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                            <li><a href="?page=master_apar&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                            } else {
                                echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                            <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                            }

                            //perulangan pagging
                            for ($i = 1; $i <= $cpg; $i++) {
                                if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                    if ($i == $pg)
                                        echo '<li class="active waves-effect waves-dark"><a href="?page=master_apar&pg=' . $i . '"> ' . $i . ' </a></li>';
                                    else
                                        echo '<li class="waves-effect waves-dark"><a href="?page=master_apar&pg=' . $i . '"> ' . $i . ' </a></li>';
                                }
                            }

                            //last and next pagging
                            if ($pg < $cpg) {
                                $next = $pg + 1;
                                echo '<li><a href="?page=master_apar&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                            <li><a href="?page=master_apar&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
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
