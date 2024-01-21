<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['act'])) {
        $act = $_REQUEST['act'];
        switch ($act) {

            case 'del':
                include "hapus_lpg.php";
                break;
        }
    } else {
        if (isset($_REQUEST['sub'])) {
            $sub = $_REQUEST['sub'];
            switch ($sub) {
                case 'del':
                    include "hapus_lpg.php";
                    break;
            }
        } else {
    if (isset($_POST['submita'])) {
        // print_r($_POST);die;
        $id_lpg = $_POST['id_lpg'];
        $query = mysqli_query($config, "SELECT * FROM tbl_lpg WHERE id_lpg='$id_lpg'");
        $no = 1;
        list($id_lpg) = mysqli_fetch_array($query);
        {

            $nama_barang = $_POST['nama_barang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            $catatan = $_POST['catatan'];
            $id_user = $_SESSION['id_user'];

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/lpg_detail/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 2500000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_lpg_detail(nama_barang,jumlah,satuan,catatan,file,id_lpg,id_user)
                                        VALUES('$nama_barang','$jumlah','$satuan','$catatan','$nfile','$id_lpg','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            echo '<script language="javascript">
                                    window.history.go(-1)
                                        </script>';
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
                $query = mysqli_query($config, "INSERT INTO tbl_lpg_detail(nama_barang,jumlah,satuan,catatan,file,id_lpg,id_user)
                                        VALUES('$nama_barang','$jumlah','$satuan','$catatan','$nfile','$id_lpg','$id_user')");

                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=lpg_gudang");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    } else {

        //pagging
        $query = mysqli_query($config, "SELECT lpg FROM tbl_sett");
        list($lpg) = mysqli_fetch_array($query);

        //pagging
        $limit = $lpg;
        $pg = @$_GET['pg'];
        if (empty($pg)) {
            $curr = 0;
            $pg = 1;
        } else {
            $curr = ($pg - 1) * $limit;
        };
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <div class="z-depth-1">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <div class="col m12">
                                <ul class="left">
                                    <li class="col s5 waves-effect waves-light show-on-small-only"><a href="#" class="judul"><i class="material-icons">mail</i>E-LPG</a></li>
                                    <div class="col s6 show-on-medium-and-up">
                                        <form method="post" action="?page=lpg_gudang">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" placeholder="Searching" required>
                                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                                <input type="submit" name="submito" value="cari">
                                            </div>
                                        </form>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <?php
            if (isset($_SESSION['succAdd'])) {
                $succAdd = $_SESSION['succAdd'];
                ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succAdd ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['succAdd']);
            }
            if (isset($_SESSION['succEdit'])) {
                $succEdit = $_SESSION['succEdit'];
                ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succEdit ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['succEdit']);
            }
            if (isset($_SESSION['succDel'])) {
                $succDel = $_SESSION['succDel'];
                ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succDel ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['succDel']);
            }
            ?>
        </div>
        <!-- Row END -->

        <!-- Perihal START -->

        <div class="row jarak-form">

            <?php
            if (isset($_POST['submito'])) {
                $cari = mysqli_real_escape_string($config, $_POST['cari']);
                echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=lpg_gudang"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                   <th width="20%">No.LPG<br/><hr/>Tgl.LPG</th>
                                         <th width="20%">No.PMK</th>
                                         <th width="20%">Nama Perusahaan<br/><hr/>Lokasi</th>
                                          <th width="20%">Jenis Pekerjaan</th>
                                         <th width="20%">Status Kepala Bagian</th>
                                    <th width="18%">Tindakan <span class="right"><i class="material-icons" style="color: #333;">settings</i></span></th>
                                </tr>
                            </thead>
                            <tbody>';

                //script untuk mencari data
                $query = mysqli_query($config, "SELECT a.*, 
                                                           b.no_agenda,indeks,asal_surat,
                                                           c.status_app_lpg
                                                           FROM tbl_lpg a
                                                           LEFT JOIN tbl_surat_masuk b
                                                           ON a.id_surat=b.id_surat
                                                           LEFT JOIN tbl_approve_lpg c
                                                           ON a.id_lpg=c.id_lpg
                                                           WHERE no_lpg LIKE '%$cari%'or
                                                                 tgl_lpg LIKE '%$cari%' or
                                                                 indeks LIKE '%$cari%' or
                                                                 asal_surat LIKE '%$cari%' or
                                                                 pekerjaan_lpg LIKE '%$cari%' ORDER by id_lpg DESC");
                if (mysqli_num_rows($query) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $no++;

                        echo '
                                  <tr>
                                   <td>' . $no . '</td>
                                    <td><strong>' . $row['no_lpg'] . '</strong><br/><hr/>' . indoDate($row['tgl_lpg']) . '</td>
                                    <td>' . $row['no_agenda'] . '</td>
                                    <td>' . $row['indeks'] . '<br/><hr/>' . $row['asal_surat'] . '</td>
                                    <td>' . $row['pekerjaan_lpg'] . '</td>
                                    <td>' . $row['status_app_lpg'] . '</td>
                                    <td>';

                        if ($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] != 1) {
                            echo '<a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_surat=' . $row['id_surat'] . '" target="_blank">
                                            <i class="material-icons">print</i> PRINT</a>';
                        } else {
                            echo '<a class=" <a class="btn small yellow darken-2 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat Detail"  href="?page=ctk_lpg&id_lpg='.$row['id_lpg'].'" target="_blank">
                                                <i class="material-icons">print</i></a>';
                                           
                        } echo '
                                        </td>
                                    </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                }
                echo '</tbody></table><br/><br/>
                        </div>
                    </div>
                    <!-- Row form END -->';
            } else {
                ?>

                <div class = "col m12" id = "colres">
                    <table class = "bordered" id = "tbl">
                        <thead class = "blue lighten-4" id = "head">
                            <tr>
                                <th>No</th>
                                <th width="20%">No.LPG<br/><hr/>Tgl.LPG</th>
                        <th width="20%">No.PMK</th>
                        <th width="20%">Nama Perusahaan<br/><hr/>Lokasi</th>
                        <th width="20%">Jenis Pekerjaan</th>
                        <th width="20%">Status Kepala Bagian</th>
                        <th width="20%">Tindakan</th>
                        <th width = "3%">Atur Baris<span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                        <div id = "modal" class = "modal">
                            <div class = "modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,lpg FROM tbl_sett");
                                list($id_sett, $lpg) = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="lpg" required>
                                                    <option value="<?= $lpg ?>"><?= $lpg ?></option>
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
                                                    $lpg = $_REQUEST['lpg'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET lpg='$lpg',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=lpg_gudang");
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
                            //Menampilkan Data

                            $query = mysqli_query($config, $query = "SELECT a.*, 
                                                           b.no_agenda,indeks,asal_surat,
                                                           c.id_approve_lpg,status_app_lpg
                                                           FROM tbl_lpg a
                                                           LEFT JOIN tbl_surat_masuk b
                                                           ON a.id_surat=b.id_surat
                                                           LEFT JOIN tbl_approve_lpg c
                                                           ON a.id_lpg=c.id_lpg
                                                           ORDER by id_surat DESC LIMIT $curr, $limit");

                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= $row['no_lpg'] ?></strong><br/><hr/><?= indoDate($row['tgl_lpg']) ?></td>
                                        <td><strong><?= $row['no_agenda'] ?></strong></td>
                                        <td><?= $row['indeks'] ?><br/><hr/><?= $row['asal_surat'] ?></td>
                                        <td><i><?= $row['pekerjaan_lpg'] ?></i></td>
                                        <td><strong><?= $row['status_app_lpg'] ?></strong></td>
                                        <td><a class="btn small yellow darken-3 modal-trigger tooltipped" data-position="left" data-tooltip="Tambah Detail"   href="#modal<?= $no ?>">+detail</a></span>
                                            <div id="modal<?= $no ?>" class="modal">
                                                <div class="modal-content white">
                                                    <div class="row">
                                                        <!-- Secondary Nav START -->
                                                        <div class="col s12">
                                                            <nav class="secondary-nav">
                                                                <div class="nav-wrapper blue-grey darken-1">
                                                                    <ul class="left">
                                                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Detail Barang</a></li>
                                                                    </ul>
                                                                </div>
                                                            </nav>
                                                        </div>
                                                        <!-- Secondary Nav END -->
                                                    </div>

                                                    <div class="row jarak-form">
                                                        <form class="col s12" method="post" action="" enctype="multipart/form-data">
                                                            <div class="input-field col s9">
                                                                <input type="hidden" id="id_lpg" name="id_lpg" value="<?= $row['id_lpg'] ?>" />
                                                                <i class="material-icons prefix md-prefix">add_to_photos</i>
                                                                <input id="nama_barang" type="text" class="validate" name="nama_barang">
                                                                <label for="nama_barang">Nama Barang</label>
                                                            </div>

                                                            <div class="input-field col s9">
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

                                                            <div class="input-field col s9">
                                                                <i class="material-icons prefix md-prefix">library_books</i><label>Satuan</label><br/>
                                                                <div class="input-field col s11 right">
                                                                    <select class="browser-default validate" name="satuan" id="satuan">
                                                                        <option value="unit">unit</option>
                                                                        <option value="buah">buah</option>
                                                                        <option value="pasang">pasang</option>
                                                                        <option value="lembar">lembar</option>
                                                                        <option value="keping">keping</option>
                                                                        <option value="batang">batang</option>
                                                                        <option value="bungkus">bungkus</option>
                                                                        <option value="potong">potong</option>
                                                                        <option value="tablet">tablet</option>
                                                                        <option value="dos">dos</option>
                                                                        <option value="rim">rim</option>
                                                                         <option value="set">set</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="input-field col s9">
                                                                <i class="material-icons prefix md-prefix">note</i>
                                                                <textarea id="catatan" class="materialize-textarea validate" name="catatan"></textarea>
                                                                <?php
                                                                if (isset($_SESSION['catatan'])) {
                                                                    $catatan_pp = $_SESSION['catatan'];
                                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                                                                    unset($_SESSION['catatan']);
                                                                }
                                                                if (isset($_SESSION['errDup'])) {
                                                                    $errDup = $_SESSION['errDup'];
                                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                                                                    unset($_SESSION['errDup']);
                                                                }
                                                                ?>
                                                                <label for="catatan">Catatan</label>
                                                            </div>

                                                            <div class="input-field col s9">
                                                                <div class="file-field input-field">
                                                                    <div class="btn small light-green darken-1">
                                                                        <span>File</span>
                                                                        <input type="file" id="file" name="file">
                                                                    </div>
                                                                    <div class="file-path-wrapper">
                                                                        <input class="file-path validate" type="text" placeholder="Upload file/scan gambar">
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
                                                            <button type="submit" name ="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <a class="btn small blue darken-2 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit Data"  href="?page=lpg&act=edit&id_lpg=<?= $row['id_lpg'] ?>">
                                                                                                                
                                                <i class="material-icons">edit</i> Edit</a>
                                                   <a class="btn small green darken-2 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Lihat Detail"  href="?page=ctk_lpg&id_lpg=<?= $row['id_lpg'] ?>" target="_blank">
                                                <i class="material-icons">remove_red_eye</i>Lihat Detail</a>
                                                    <a class="btn small deep-orange waves-effect waves-light" href="?page=lpg_gudang&act=del&id_lpg=<?= $row['id_lpg'] ?>">
                                                        <i class="material-icons">delete</i> DEL</a>   
                                            
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan.</p></center></td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            $query = mysqli_query($config, "SELECT * FROM tbl_lpg");
            $cdata = mysqli_num_rows($query);
            $cpg = ceil($cdata / $limit);

            echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

            if ($cdata > $limit) {

                //first and previous pagging
                if ($pg > 1) {
                    $prev = $pg - 1;
                    echo '<li><a href="?page=lpg_gudang&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=lpg_gudang&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                } else {
                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                }

                //perulangan pagging
                for ($i = 1; $i <= $cpg; $i++) {
                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                        if ($i == $pg)
                            echo '<li class="active waves-effect waves-dark"><a href="?page=lpg_gudang&pg=' . $i . '"> ' . $i . ' </a></li>';
                        else
                            echo '<li class="waves-effect waves-dark"><a href="?page=lpg_gudang&pg=' . $i . '"> ' . $i . ' </a></li>';
                    }
                }

                //last and next pagging
                if ($pg < $cpg) {
                    $next = $pg + 1;
                    echo '<li><a href="?page=lpg&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=lpg&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                } else {
                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                }
                echo '
                        </ul>';
            }
            ?>

            <?php
            unset($_SESSION['succDel']);
        }
    }
    }
}
}
?>
    