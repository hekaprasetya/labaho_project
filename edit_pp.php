<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong

        $no_pp = $_REQUEST['no_pp'];
        $tgl_pp = $_REQUEST['tgl_pp'];
        $target = $_REQUEST['target'];
        $divisi = $_REQUEST['divisi'];
        $catatan_pp = $_REQUEST['catatan_pp'];
        $id_user = $_SESSION['id_user'];

        //validasi input data

        $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
        $file = $_FILES['file']['name'];
        $x = explode('.', $file);
        $eks = strtolower(end($x));
        $ukuran = $_FILES['file']['size'];
        $target_dir = "upload/pp/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        //jika form file tidak kosong akan mengeksekusi script dibawah ini
        if ($file != "") {

            $rand = rand(1, 10000);
            $nfile = $rand . "-" . $file;

            //validasi file
            if (in_array($eks, $ekstensi) == true) {
                if ($ukuran < 2300000) {

                    $id_pp = $_REQUEST['id_pp'];
                    $query = mysqli_query($config, "SELECT file FROM tbl_pp WHERE id_pp='$id_pp'");
                    list($file) = mysqli_fetch_array($query);

                    //jika file tidak kosong akan mengeksekusi script dibawah ini
                    if (!empty($file)) {
                        unlink($target_dir . $file);

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "UPDATE tbl_pp SET no_pp='$no_pp', tgl_pp='$tgl_pp',target='$target',file='$nfile',divisi='$divisi',catatan_pp='$catatan_pp',id_user='$id_user' WHERE id_pp='$id_pp'");

                        if ($query == true) {
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            header("Location: ./admin.php?page=pp");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    } else {

                        //jika file kosong akan mengeksekusi script dibawah ini
                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "UPDATE tbl_pp SET no_pp='$no_pp', tgl_pp='$tgl_pp',target='$target',file='$nfile',divisi='$divisi',catatan_pp='$catatan_pp',id_user='$id_user' WHERE id_pp='$id_pp'");

                        if ($query == true) {
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            header("Location: ./admin.php?page=pp");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
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
            $id_pp = $_REQUEST['id_pp'];

            $query = mysqli_query($config, "UPDATE tbl_pp SET no_pp='$no_pp', tgl_pp='$tgl_pp',target='$target',divisi='$divisi',catatan_pp='$catatan_pp',id_user='$id_user' WHERE id_pp='$id_pp'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                header("Location: ./admin.php?page=pp");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }
}

$id_pp = mysqli_real_escape_string($config, $_REQUEST['id_pp']);
$query = mysqli_query($config, "SELECT id_pp, no_pp, tgl_pp, target, file, divisi, catatan_pp, id_user FROM tbl_pp WHERE id_pp='$id_pp'");
list($id_pp, $no_pp, $tgl_pp, $target, $file, $divisi, $catatan_pp, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
    window.location.href = "./admin.php?page=pp";
</script>';
} else {
    ?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue-grey darken-1">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit PP</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Secondary Nav END -->
    </div>
    <!-- Row END -->

    <?php
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
    ?>

    <!-- Row form Start -->
    <div class="row jarak-form">

        <!-- Form START -->
        <form class="col s12" method="POST" action="?page=pp&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s6">
                    <input type="hidden" name="id_pp" value="<?php echo $id_pp; ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_pp" type="text" class="validate" value="<?php echo $no_pp; ?>" name="no_pp">
                    <?php
                    if (isset($_SESSION['eno_pp'])) {
                        $eno_pp = $_SESSION['eno_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_pp . '</div>';
                        unset($_SESSION['eno_pp']);
                    }
                    ?>
                    <label for="eno_pp">No.PP</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">schedule</i>
                    <input id="tgl_pp" type="text" class="datepicker" name="tgl_pp" value="<?php echo $tgl_pp; ?>" required>
                    <?php
                    if (isset($_SESSION['tgl_pp'])) {
                        $tgl_pp = $_SESSION['tgl_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . indoDate($row['tgl_pp']) . '</div>';
                        unset($_SESSION['tgl_pp']);
                    }
                    ?>
                    <label for="tgl_pp">Tgl.PP</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i>
                    <input id="divisi" type="text" class="validate" name="divisi" value="<?php echo $divisi; ?>" required>
                    <?php
                    if (isset($_SESSION['edivisi'])) {
                        $edivisi = $_SESSION['edivisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $edivisi . '</div>';
                        unset($_SESSION['edivisi']);
                    }
                    ?>
                    <label for="edivisi">Divisi</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">build</i>
                    <input id="target" type="text" class="datepicker" name="target" value="<?php echo $target; ?>" required>
                    <?php
                    if (isset($_SESSION['target'])) {
                        $target = $_SESSION['target'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $target . '</div>';
                        unset($_SESSION['target']);
                    }
                    ?>
                    <label for="target">Target</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">description</i>
                    <textarea id="catatan_pp" class="materialize-textarea validate" name="catatan_pp" required><?php echo $catatan_pp; ?></textarea>
                    <?php
                    if (isset($_SESSION['catatan_pp'])) {
                        $catatan_pp = $_SESSION['catatan_pp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan_pp . '</div>';
                        unset($_SESSION['catatan_pp']);
                    }
                    ?>
                    <label for="catatan_pp">Catatan PP</label>
                </div>
                <div class="input-field col s6">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>File</span>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/pp">
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
                            <!--small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small-->
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- Row in form END -->

    <div class="row">
        <div class="col 8">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
        </div>
        <div class="col 8">
            <a href="?page=pp" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>
    <hr>
    <hr>
    <div class="col m12" id="colres">
        <table class="bordered" id="tbl">
            <thead class="blue lighten-4" id="head">
                <tr>
                    <th width="3%">No</th>
                    <th width="12%">Nama Barang</th>
                    <th width="5%">Jumlah</th>
                    <th width="5%">Satuan</th>
                    <th width="8%">Keterangan</th>
                    <th width="10%">Tujuan</th>
                    <th width="3%"><center>Tindakan</center></th>
            </tr>
            </thead>
            <?php
            $query2 = mysqli_query($config, "SELECT *from tbl_pp_barang
                                           WHERE id_pp='$id_pp'");
            if (mysqli_num_rows($query2) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query2)) {
                    $no++;
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= $row['satuan'] ?></td>
                        <td><?= $row['keterangan_pp'] ?></td>
                        <td><?= $row['tujuan_pp'] ?></td>
                        <td> <a class="btn small red darken-3 waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus Data" href="hapus_pp_barang.php?id_barang=<?= $row["id_barang"] ?>">
                                <i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="7"><center><p class="add">Tidak ada detail barang</p></center></td></tr>
                <?php
            }
            ?>

        </table>
        <?Php
        if (isset($_REQUEST['submito'])) {
            // print_r($_POST);die;
            //validasi form kosong
            if ("") {
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                $nama_barang = $_REQUEST['nama_barang'];
                $jumlah = $_REQUEST['jumlah'];
                $satuan = $_REQUEST['satuan'];
                $keterangan_pp = $_REQUEST['keterangan_pp'];
                $tujuan_pp = $_REQUEST['tujuan_pp'];
                $id_pp = $_REQUEST['id_pp'];

                $query = mysqli_query($config, "UPDATE tbl_pp_barang SET nama_barang='$nama_barang',jumlah='$jumlah',satuan='$satuan',keterangan_pp='$keterangan_pp',tujuan_pp='$tujuan_pp' WHERE id_pp='$id_pp'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=pp");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
        ?>
        <hr>
        <br>
        <div class="row">
           <div class="col 6">
                <!--button type="submit" name="submito" class="btn small brown waves-effect waves-light">Ubah detail OP<i class="material-icons">done</i></button-->
                <a href="?page=pp&act=pp_detail&id_pp=<?= $_GET['id_pp'] ?>"  class="btn small green waves-effect waves-light">Tambah <i class="material-icons">add</i></a>
            </div>
            <div class="col 6">
                <a href="?page=pp" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
            </div>
        </div> 
    </div>
    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
