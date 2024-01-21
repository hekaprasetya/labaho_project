<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['id_utility'])) {

        $id_utility = intval($_REQUEST['id_utility']);
        // Query untuk mengambil id_utility_detail dengan id_utility yang sama
        $query_id = mysqli_query($config, "SELECT id_utility_detail FROM master_utility_detail WHERE id_utility='$id_utility'");

        // Mengambil semua hasil query ke dalam array
        $id_array = array();
        while ($row = $query_id->fetch_assoc()) {
            $id_array[] = $row['id_utility_detail'];
        }

        // Menggunakan implode untuk menggabungkan nilai-nilai id_utility_detail menjadi satu string dengan koma
        $id_utility_detail = implode(',', $id_array);
    } else {
        
    }

   // $query = mysqli_query($config, "SELECT master_utility_detail FROM tbl_sett");
    list($master_utility_detail) = mysqli_fetch_array($query);
    if (isset($_POST['mod'])) {
        //validasi form kosong
        if (empty($_POST['nama_part']) && empty($_POST['tipe']) && empty($_POST['jumlah'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_part = $_POST['nama_part'];
            $jumlah = $_POST['jumlah'];
            $tipe = $_POST['tipe'];
            $query_add = mysqli_query($config, "INSERT INTO master_utility_detail(nama_part,tipe,jumlah,id_utility)
            VALUES('$nama_part','$tipe','$jumlah','$id_utility')");
            if ($query_add === true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=master_utility&act=dit&id_utility=$id_utility");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                header("Location: ./admin.php?page=master_utility&act=dit&id_utility=$id_utility");
            }
        }
    } else {
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
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=master_utility&act=add" class="judul"><i class="material-icons md-3">build</i> Detail Utility</a></li>
                                    <li class="waves-effect waves-light">
                                        <a class="waves-effect waves-light modal-trigger" href="#modal2"><i class="material-icons md-30">add_circle</i>Tambah Data</a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a onclick="window.location.href = './admin.php?page=master_utility'"><i class="material-icons md-30">arrow_back</i>Kembali</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s4 show-on-med-and-down search right">
                                <form method="post" action="">
                                    <div class="input-field round-in-box">
                                        <input id="search" type="search" name="cari" placeholder="Searching" required>
                                        <label for="search"><i class="material-icons md-dark">search</i></label>
                                        <input type="submit" name="submit" class="hidden">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Row END -->
        <?php
        // Menggunakan string yang telah digabungkan dalam query nama_utility
        $query_nama = mysqli_query($config, "SELECT nama_utility,lokasi FROM master_utility WHERE id_utility = '$id_utility'");

        $rows = mysqli_fetch_assoc($query_nama);

        // rows akan berisi nama_utility yang sesuai dengan id_utility yang sama
        ?>
        <blockquote>
            <i class="material-icons prefix md-prefix">device_hub</i> Nama Utility : <?= $rows['nama_utility'] ?><i></p>
            <i class="material-icons prefix md-prefix">location_on</i> Lokasi      : <?= $rows['lokasi'] ?><i></p>
        </blockquote>

        <?php
        if (isset($_SESSION['errQ'])) {
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row jarak-card">
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
        <div class="row jarak-form">
            <?php
            $query_dit = "SELECT * FROM master_utility_detail";

            if (isset($_REQUEST['submit'])) {
                $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                ?>
                <div class="col s12" style="margin-top: -18px;">
                    <div class="card blue lighten-5">
                        <div class="card-content">
                            <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=master_utility&act=dit&id_utility=<?= $id_utility ?>"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                        </div>
                    </div>
                </div>

                <?php
                //script untuk mencari data
                $query_dit .= " WHERE nama_part LIKE '%$cari%' 
                                    OR tipe LIKE '%$cari%' 
                                    OR jumlah LIKE '%$cari%' 
                                    OR id_utility LIKE '%$cari%' 
                                    ORDER BY id_utility_detail DESC";
                // meenggunakan fuction query
                $result = mysqli_query($config, $query_dit);
                ?>
                <!-- Row form Start -->
                <div class="row jarak-card">
                    <div class="col m12">
                        <div class="card">
                            <div class="card-content">
                                <table>
                                    <thead class="blue lighten-4">
                                        <tr>
                                            <th>No</th>
                                            <th>Part</th>
                                            <th>Tipe</th>
                                            <th>Jumlah</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            $no = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $row['nama_part'] ?></td>
                                                    <td><?= $row['tipe'] ?></td>
                                                    <td><?= $row['jumlah'] ?></td>
                                                    <td><a onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=master_utility&act=dit&submita=yes&id_utility_detail= <?= $row['id_utility_detail'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="5">
                                        <center>
                                            <p class="add">Tidak ada data yang dimaksud.<u><a href="?page=master_utility&act=dit&id_utility=<?= $id_utility ?>">Kembali Ke Halaman</a></u></p>
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
                    </div>
                </div>
                <!-- Row form END -->
                <?php
            } else {
                // menampilkan

                $query_dit .= " WHERE id_utility = '$id_utility'"; // Sesuaikan dengan filter yang sesuai
                $query_dit .= " ORDER BY id_utility_detail DESC"; // Sesuaikan nama kolom yang ingin Anda urutkan
                $query = mysqli_query($config, $query_dit);
                ?>
                <!-- Row form Start -->
                <div class="row jarak-card">
                    <div class="col m12">
                        <div class="card">
                            <div class="card-content">
                                <table>
                                    <thead class="blue lighten-4">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Part</th>
                                            <th>Tipe</th>
                                            <th>Jumlah</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($query) > 0) {
                                            $no = 1;
                                            while ($row = $query->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $row['nama_part'] ?></td>
                                                    <td><?= $row['tipe'] ?></td>
                                                    <td><?= $row['jumlah'] ?></td>
                                                    <td> <a onClick="return confirm('YAKIN MAU DIHAPUS?')" href="?page=master_utility&act=dit&submita=yes&id_utility_detail= <?= $row['id_utility_detail'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a></td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                        } else {
                                            ?><tr>
                                                <td colspan="5">
                                        <center>
                                            <p class="add">Tidak ada sparepart. <u><a class="waves-effect waves-light modal-trigger" href="#modal2"> Tambah</a></u></p>
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
                    </div>
                </div>
                <!-- Row form END -->
                <div id="modal2" class="modal">
                    <div class="modal-content white">
                        <div class="row">
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue darken-2">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">device_hub</i> Tambah Data Part</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <!-- Secondary Nav END -->
                        </div>
                        <div  class="row jarak-form">
                            <form class="col s12" action="" method="post">
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
                                <!-- Tombol "SIMPAN" di dalam formulir -->
                                <div class="col s12 modal-footer">
                                    <div class="col s6 left">
                                        <button href="#!" type="submit" name="mod" class="modal-action btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>
                                    </div>
                                    <div class="col s6">
                                        <a href="#!" class="modal-action modal-close btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_REQUEST['submita'])) {
                    $id_utility_detail = $_REQUEST['id_utility_detail'];
                    $query_uti = mysqli_query($config, "SELECT id_utility FROM master_utility_detail WHERE id_utility_detail='$id_utility_detail'");

                    if ($query_uti) {
                        $row = $query_uti->fetch_assoc();
                        $id_utility = $row['id_utility'];

                        $query = mysqli_query($config, "DELETE FROM master_utility_detail WHERE id_utility_detail='$id_utility_detail'");

                        if ($query === true) {
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                            header("Location: ./admin.php?page=master_utility&act=dit&id_utility=$id_utility");
                            exit; // Penting untuk menghentikan eksekusi skrip setelah mengarahkan ke halaman lain
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            header("Location: ./admin.php?page=master_utility&act=dit&id_utility=$id_utility");
                            exit;
                        }
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Tidak dapat menemukan data dengan id_utility_detail yang dimaksud';
                        header("Location: ./admin.php?page=master_utility&act=dit");
                        exit;
                    }
                }
            }
            ?>
        </div>
        <?php
    }
}
