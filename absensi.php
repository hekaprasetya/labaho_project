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
                'add' => 'tambah_absen.php',
                'edit' => 'edit_absen.php',
                'del' => 'hapus_absen.php',
                'pulang' => 'tambah_absen_pulang.php',
                'laporan' => 'report_absen.php'
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


                $query = mysqli_query($config, "SELECT tbl_absen FROM tbl_sett");
                list($utility_absen) = mysqli_fetch_array($query);

                //pagging
                $limit = $utility_absen;
                $pg = @$_GET['pg'];
                if (empty($pg)) {
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }

                // untuk function
                $absen = new CRUD();

                // id pada tabel berisi id_"$id_name" 
                $absen->id_name = 'absen';

                // nama tabel utama halaman
                $absen->tbl_name = 'tbl_absen';

                // page halaman pemangilan di admin
                $absen->pg_name = 'absen';

                // judul pada secon nav
                $absen->judul = "absen";

                // icon untuk judul
                $absen->icon_judul = "alarm";

                // array isi ari tabel
                $isi_row = array("nama", "tanggal", "jenis_absen", "status_absen");
                $header = array("Nama", "Tanggal", "Jenis Absen", "Status Absen");

                // SECONDARY NAV START
                $id_user = $_SESSION['id_user'];
                $query = mysqli_query($conn, "SELECT * FROM tbl_absen WHERE id_user = '$id_user' AND DATE(tanggal) = CURDATE()");
                $row = $query->fetch_assoc();
                if ($query->num_rows != null) {
                    $id_absen = $row['id_absen'];
                    $id = $row['id'];
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
                                        <?php
                                        if ($row['status_absen'] == "Sudah Pulang") {
                                            ?>
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=<?= $absen->pg_name ?>" class="judul"><i class="material-icons md-3"><?= $absen->icon_judul ?></i> <?= $absen->judul ?></a></li>
                                            <?php
                                        } else {
                                            echo ($query->num_rows == null) ?
                                                    ' <li class="waves-effect waves-light">
                                            <a href="?page=' . $absen->pg_name . '&act=add" class="judul"><i class="material-icons">alarm_add</i> Absen Masuk</a></li>' :
                                                    '<li class="waves-effect waves-light">
                                        <a href="?page=absen&act=pulang&id_absen=' . $id_absen . '" class="judul"><i class="material-icons">alarm_on</i> Absen Pulang</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>

                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->
            <!-- Row END -->
            <div class="z-depth-1">
                <nav class="secondary-nav yellow darken-3">
                    <form method="post" action="?page=<?= $absen->pg_name ?>">
                        <center>
                            <div class="input-field round-in-box">
                                <input id="search" type="search" name="cari" placeholder="Searching" required>
                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                <input type="submit" name="submit" class="hidden">
                            </div>
                        </center>
                    </form>
                </nav>
            </div>
            <?php
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
            <?php
            echo ($_SESSION['admin'] == 15) ? '<br>
            <button class="btn waves-effect waves-light light-blue" style="border-radius:7px;" onclick="window.location.href=\'?page=absen&act=laporan\'">Laporan
                <i class="material-icons right">description</i>
            </button>' : '';
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">
                <?php
                // membuat varibel untuk mengambil data
                $query_absen = "SELECT a.*,
                    b.nama
                    FROM $absen->tbl_name a
                    LEFT JOIN tbl_user b ON a.id_user = b.id_user ";

                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=absen"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
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
                                    <th>Foto</th>
                                    <?php
                                    $user = $_SESSION['nama'];
                                    echo ($_SESSION['admin'] == 15) ? '<th>Lokasi</th><th>Tindakan <span class="right"><i class="material-icons right" style="color: #333;">settings</i></span></th>' : '<th>Lokasi<span class="right"><i class="material-icons right" style="color: #333;">settings</i></span></th>';
                                    ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk mencari data
                                // menambahkan untuk variabel query untuk mencari
                                $kolom1 = implode(" LIKE '%$cari%' OR ", $isi_row) . " LIKE '%$cari%'";
                                if ($_SESSION['admin'] == 15) {
                                    $query_absen .= "WHERE ($kolom1) ORDER BY id_$absen->id_name DESC";
                                } else {
                                    $user = $_SESSION['nama'];
                                    $query_absen .= "WHERE ($kolom1) AND nama = '$user' ORDER BY id_$absen->id_name DESC";
                                }

                                // meenggunakan fuction query
                                $result = mysqli_query($config, $query_absen);
                                $cek = mysqli_num_rows($result);
                                if ($cek) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_absen'];
                                        $absen->id = $row['id_absen'];
                                        $absen->file = $row['file'];
                                        $absen->dir = "upload/absen/$absen->file";
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <?php
                                            foreach ($isi_row as $kolom) {
                                                if ($kolom == "tanggal") {
                                                    // Jika kolom adalah 'tgl_panel', terapkan fungsi indoDateTime
                                                    ?>
                                                    <td><?= indoDateTime($row[$kolom]) ?></td>
                                                    <?php
                                                } else {
                                                    // Untuk kolom lainnya
                                                    echo "<td>$row[$kolom]</td>";
                                                }
                                            }
                                            $absen->tampilFile();
                                            ?>
                                            <td><a target="_blank" href="https://www.google.com/maps/place/<?= $row['lati'] ?>,<?= $row['longi'] ?>/@<?= $row['lati'] ?>,<?= $row['longi'] ?>,17z/data=!3m1!4b1!4m4!3m3!8m2!3d<?= $row['lati'] ?>!4d<?= $row['longi'] ?>?entry=ttu"><img src="asset/img/google-maps.webp" width="50px" alt="lokasi"></a></td>
                                            <?php
                                            if ($_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <td>
                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus" href="?page=<?= $absen->pg_name ?>&act=del&id_<?= $absen->id_name ?>=<?= $absen->id ?>">
                                                            <i class="material-icons">delete</i></a>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                } else {
                                    $absen->nodata();
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
                                <th>Foto</th>
                                <?php
                                $user = $_SESSION['nama'];
                                echo ($_SESSION['admin'] == 15) ? '<th>Lokasi</th><th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>' : '<th>lokasi<a class="modal-trigger right" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>';
                                $absen->hal($config);
                                ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            //script untuk menampilkan data
                            // menambahkan untuk variabel query untuk mencari
                            $user = $_SESSION['nama'];
                            if ($_SESSION['admin'] == 15) {
                                $query_absen .= " ORDER BY id_absen DESC LIMIT $curr, $limit";
                            } else {
                                $user = $_SESSION['nama'];
                                $query_absen .= " WHERE nama = '$user' ORDER BY id_absen DESC LIMIT $curr, $limit";
                            }
                            // meenggunakan fuction query
                            $result = mysqli_query($config, $query_absen);
                            $cek = mysqli_num_rows($result);
                            if ($cek) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id_absen'];
                                    $absen->id = $row['id_absen'];
                                    $absen->file = $row['file'];
                                    $absen->dir = "upload/absen/$absen->file";
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <?php
                                        foreach ($isi_row as $kolom) {
                                            if ($kolom == "tanggal") {
                                                // Jika kolom adalah 'tgl_panel', terapkan fungsi indoDateTime
                                                ?>
                                                <td><?= indoDateTime($row[$kolom]) ?></td>
                                                <?php
                                            } else {
                                                // Untuk kolom lainnya
                                                echo "<td>$row[$kolom]</td>";
                                            }
                                        }
                                        $absen->tampilFile();
                                        ?>
                                        <td><a target="_blank" href="https://www.google.com/maps/place/<?= $row['lati'] ?>,<?= $row['longi'] ?>/@<?= $row['lati'] ?>,<?= $row['longi'] ?>,17z/data=!3m1!4b1!4m4!3m3!8m2!3d<?= $row['lati'] ?>!4d<?= $row['longi'] ?>?entry=ttu"><img src="asset/img/google.jpeg" width="50px" alt="lokasi"></a></td>

                                        <?php
                                        if ($_SESSION['admin'] == 15) {
                                            if ($_SESSION['admin']) {
                                                ?>
                                                <td>
                                                    <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Alat" href="?page=<?= $absen->pg_name ?>&act=del&id_<?= $absen->id_name ?>=<?= $absen->id ?>">
                                                        <i class="md-30 material-icons">delete</i></a>
                                                </td>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </tr>
                                    <?php
                                    $no++;
                                }
                            } else {
                                $absen->nodata();
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Row form END -->
                    <?= $absen->pagging($conn, $limit, $pg) ?>
                </div> <?php
            }
        }
    }
}
