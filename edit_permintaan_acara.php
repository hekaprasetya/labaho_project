<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        //validasi form kosong
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_pa = $_POST['id_pa'];
            $no_pa = $_POST['no_pa'];
            $nama_perusahaan = $_POST['nama_perusahaan'];
            $penanggung_jawab = $_POST['penanggung_jawab'];
            $no_telp = $_POST['no_telp'];
            $ruangan_sewa = $_POST['ruangan_sewa'];
            $tgl_acara = $_REQUEST['tgl_acara'];
            $tgl_selesai = $_REQUEST['tgl_selesai'];
            $jam = $_POST['jam'];
            $judul = $_POST['judul'];
            $fasilitas = $_POST['fasilitas'];
            $tambahan_lain = $_POST['tambahan_lain'];
            $harga_sewa = $_POST['harga_sewa'];
            $dp = $_POST['dp'];
            $promo = $_POST['promo'];
            $status = $_POST['status'];
            $id_user = $_SESSION['id_user'];

            //validasi input data

            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/permintaan_acara/";

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

                        $id_pa = $_REQUEST['id_pa'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_pa WHERE id_pa='$id_pa'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_pa SET no_pa='$no_pa', nama_perusahaan='$nama_perusahaan', penanggung_jawab='$penanggung_jawab', no_telp='$no_telp', file='$nfile', ruangan_sewa='$ruangan_sewa', judul='$judul', tgl_acara='$tgl_acara', tgl_selesai='$tgl_selesai', jam='$jam', fasilitas='$fasilitas', tambahan_lain='$tambahan_lain', harga_sewa='$harga_sewa', promo='$promo', dp='$dp', status='$status', id_user='$id_user' WHERE id_pa='$id_pa'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=pa");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_pa SET no_pa='$no_pa', nama_perusahaan='$nama_perusahaan', penanggung_jawab='$penanggung_jawab', file='$nfile', no_telp='$no_telp', ruangan_sewa='$ruangan_sewa', tgl_acara='$tgl_acara', tgl_selesai='$tgl_selesai', jam='$jam', judul='$judul', fasilitas='$fasilitas', tambahan_lain='$tambahan_lain', harga_sewa='$harga_sewa', promo='$promo', dp='$dp',status='$status', id_user='$id_user' WHERE id_pa='$id_pa'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=pa");
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
                $id_pa = $_REQUEST['id_pa'];

                $query = mysqli_query($config, "UPDATE tbl_pa SET no_pa='$no_pa',nama_perusahaan='$nama_perusahaan',penanggung_jawab='$penanggung_jawab',no_telp='$no_telp',ruangan_sewa='$ruangan_sewa',tgl_acara='$tgl_acara',tgl_selesai='$tgl_selesai', jam='$jam',judul='$judul',fasilitas='$fasilitas',tambahan_lain='$tambahan_lain',harga_sewa='$harga_sewa',promo='$promo',dp='$dp',status='$status',id_user='$id_user' WHERE id_pa='$id_pa'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=pa");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
}

$id_pa = mysqli_real_escape_string($config, $_REQUEST['id_pa']);
$query = mysqli_query($config, "SELECT id_pa, no_pa, nama_perusahaan, penanggung_jawab, file, no_telp, ruangan_sewa, tgl_acara, tgl_selesai, jam, judul, fasilitas, tambahan_lain, harga_Sewa, promo, dp, status, id_user FROM tbl_pa WHERE id_pa='$id_pa'");
list($id_pa, $no_pa, $nama_perusahaan, $penanggung_jawab, $file, $no_telp, $ruangan_sewa, $tgl_acara, $tgl_selesai, $jam, $judul, $fasilitas, $tambahan_lain, $harga_sewa, $promo, $dp, $status, $id_user) = mysqli_fetch_array($query);

if ($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] == 1) {
    echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=pa";
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
                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Data PA</a></li>
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
        <form class="col s12" method="POST" action="?page=pa&act=edit" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s10">
                    <input type="hidden" name="id_pa" value="<?php echo $id_pa; ?>">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <input id="no_pa" type="text" class="validate" value="<?php echo $no_pa; ?>" name="no_pa">
                    <?php
                    if (isset($_SESSION['eno_pa'])) {
                        $eno_pa = $_SESSION['eno_pa'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_pa . '</div>';
                        unset($_SESSION['eno_pa']);
                    }
                    ?>
                    <label for="no_pa">No.PA</label>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">business</i>
                    <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan" value="<?php echo $nama_perusahaan; ?>">
                    <?php
                    if (isset($_SESSION['enama_perusahaan'])) {
                        $enama_perusahaan = $_SESSION['enama_perusahaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_perusahaan . '</div>';
                        unset($_SESSION['enama_perusahaan']);
                    }
                    ?>
                    <label for="enama_perusahaan">Nama Perusahaan</label>
                </div>          

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">contacts</i>
                    <input id="penanggung_jawab" type="text" class="validate" name="penanggung_jawab" value="<?php echo $penanggung_jawab; ?>">
                    <?php
                    if (isset($_SESSION['epenanggung_jawab'])) {
                        $epenanggung_jawab = $_SESSION['epenanggung_jawab'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epenanggung_jawab . '</div>';
                        unset($_SESSION['epenanggung_jawab']);
                    }
                    ?>
                    <label for="epenanggung_jawab">Penanggung Jawab</label>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">contact_phone</i>
                    <input id="no_telp" type="text" class="validate" name="no_telp" value="<?php echo $no_telp; ?>">
                    <?php
                    if (isset($_SESSION['eno_telp'])) {
                        $eno_telp = $_SESSION['eno_telp'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_telp . '</div>';
                        unset($_SESSION['eno_telp']);
                    }
                    ?>
                    <label for="eno_telp">No.Telp</label>
                </div>

                 <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">home</i>
                    <input id="ruangan_sewa" type="text" class="validate" name="ruangan_sewa" value="<?php echo $ruangan_sewa; ?>">
                    <?php
                    if (isset($_SESSION['eruangan_sewa'])) {
                        $eruangan_sewa = $_SESSION['eruangan_sewa'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eruangan_sewa . '</div>';
                        unset($_SESSION['eruangan_sewa']);
                    }
                    ?>
                    <label for="eruangan_sewa">Ruangan Sewa</label>
                </div>



                <div class="input-field col s10">
                    <input type="hidden" value="<?php echo $tgl_acara ?>">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_acara" type="text" class="datepicker" name="tgl_acara" value="<?php echo $tgl_acara ?>" required>
                    <?php
                    if (isset($_SESSION['tgl_acara'])) {
                        $tgl_acara = $_SESSION['tgl_acara'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $tgl_acara ?></div>';
                        unset($_SESSION['tgl_acara']);
                    }
                    ?>
                    <label for="tgl_acara">Tgl.Acara</label>
                </div>
                
                <div class="input-field col s10">
                    <input type="hidden" value="<?php echo $tgl_selesai ?>">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_selesai" type="text" class="datepicker" name="tgl_selesai" value="<?php echo $tgl_selesai ?>" required>
                    <?php
                    if (isset($_SESSION['tgl_selesai'])) {
                        $tgl_selesai = $_SESSION['tgl_selesai'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><?= $tgl_selesai ?></div>';
                        unset($_SESSION['tgl_selesai']);
                    }
                    ?>
                    <label for="tgl_selesai">Tgl.Selesai</label>
                </div>
                
                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">looks_two</i>
                    <input id="judul" type="text" class="validate" name="judul" value="<?php echo $judul; ?>">
                    <?php
                    if (isset($_SESSION['ejudul'])) {
                        $ejudul = $_SESSION['ejudul'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ejudul . '</div>';
                        unset($_SESSION['ejudul']);
                    }
                    ?>
                    <label for="ejudul">Judul</label>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">alarm</i>
                    <input id="jam" type="text" class="validate" name="jam" value="<?php echo $jam; ?>">
                    <?php
                    if (isset($_SESSION['ejam'])) {
                        $ejam = $_SESSION['ejam'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ejam . '</div>';
                        unset($_SESSION['ejam']);
                    }
                    ?>
                    <label for="ejam">Jam</label>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">accessibility_new</i>
                    <textarea id="fasilitas" class="materialize-textarea validate" name="fasilitas"><?php echo $fasilitas; ?></textarea>
                    <?php
                    if (isset($_SESSION['fasilitas'])) {
                        $fasilitas = $_SESSION['fasilitas'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $fasilitas . '</div>';
                        unset($_SESSION['fasilitas']);
                    }
                    ?>
                    <label for="fasilitas">Fasilitas</label>
                </div>

                <div class="input-field col s10">
                    <i class="material-icons prefix md-prefix">description</i>
                    <textarea id="tambahan_lain" class="materialize-textarea validate" name="tambahan_lain"><?php echo $tambahan_lain; ?></textarea>
                    <?php
                    if (isset($_SESSION['tambahan_lain'])) {
                        $tambahan_lain = $_SESSION['tambahan_lain'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tambahan_lain . '</div>';
                        unset($_SESSION['tambahan_lain']);
                    }
                    ?>
                    <label for="tambahan_lain">Detail Harga Sewa</label>
                </div>

            </div>

            <div class="input-field col s10">
                <i class="material-icons prefix md-prefix">attach_money</i>
                <input id="harga_sewa" type="number" class="validate" name="harga_sewa" value="<?php echo $harga_sewa; ?>">
                <?php
                if (isset($_SESSION['harga_sewa'])) {
                    $harga_sewa = $_SESSION['harga_sewa'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><' . $row['harga_sewa'] = "Rp " . number_format($row['harga_sewa'], 0, ',', '.') . '></div>';
                    unset($_SESSION['harga_sewa']);
                }
                ?>
                <label for="harga_sewa">Harga Sewa</label>
            </div>

            <div class="input-field col s10">
                <i class="material-icons prefix md-prefix">brightness_7</i>
                <input id="promo" type="number" class="validate" name="promo" value="<?php echo $promo; ?>">
                <?php
                if (isset($_SESSION['promo'])) {
                    $promo = $_SESSION['promo'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><' . $row['promo'] = "Rp " . number_format($row['promo'], 0, ',', '.') . '></div>';
                    unset($_SESSION['promo']);
                }
                ?>
                <label for="promo">Discount</label>
            </div>

            <div class="input-field col s10">
                <i class="material-icons prefix md-prefix">brightness_7</i>
                <input id="dp" type="number" class="validate" name="dp" value="<?php echo $dp; ?>">
                <?php
                if (isset($_SESSION['dp'])) {
                    $dp = $_SESSION['dp'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><' . $row['dp'] = "Rp " . number_format($row['dp'], 0, ',', '.') . '></div>';
                    unset($_SESSION['dp']);
                }
                ?>
                <label for="dp">DP</label>
            </div>

              <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">low_priority</i>
                    <input id="status" type="text" class="validate" name="status" value="<?php echo $status; ?>" required>
                    <?php
                    if (isset($_SESSION['estatus'])) {
                        $estatus = $_SESSION['estatus'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $estatus . '</div>';
                        unset($_SESSION['estatus']);
                    }
                    ?>
                    <label for="estatus"><strong><i>Status Surat</i></strong></label>
                </div>

            <div class="input-field col s10">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1">
                        <span>File</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar surat masuk">
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
            <table>
                <thead class="blue lighten-4" id="head">
                    <tr>
                        <th width="5%"><center>No</center></th>
                <th width="12%"><center>Charge Tambahan</center></th>
                <th width="5%"><center>Harga</center></th>
                <th width="5%"><center>Action</center></th>  
                </tr>
                </thead>

                <?php
                $query2 = mysqli_query($config, "SELECT *from tbl_pa_detail
                                                                    WHERE id_pa='$id_pa'");
                if (mysqli_num_rows($query2) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_array($query2)) {
                        $no++;
                        ?>
                        <tr>
                            <td><center><?= $no ?></center></td>
                        <td><center><?= ucwords(nl2br(htmlentities(strtolower($row['nama_paket'])))) ?></center><br/></td>
                        <td><center><?= $row['harga'] = "Rp " . number_format((float) $row['harga'], 0, ',', '.') ?></center></td>
                        <td><center><a href="hapus_pa_detail.php?id_pa_detail= <?= $row["id_pa_detail"] ?>" class="btn small deep-orange waves-effect waves-light"><i class="material-icons">delete</i></a></center></td>
                        </tr>  
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                    <td colspan="5" style="text-align: center"><strong><i>** TIDAK ADA CHARGE TAMBAHAN **</i></strong></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
    </div>
    <!-- Row in form END -->

    <div class="row" >
        <div class="col 6">
            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">ubah data <i class="material-icons">done</i></button>
        </div>
        <div class="col 6">
            <a href="?page=pa" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>
    <hr/>
    <hr/>
    <hr/>
      <hr width="50%" noshade>
    <br/>
     <table>
            <?php
            $query2 = mysqli_query($config, "SELECT *from tbl_pa_hasil
                                                        WHERE id_pa='$id_pa'");
            if (mysqli_num_rows($query2) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query2)) {
                    $no++;
                    ?>
                    <form class="col s12" method="POST" action="?page=pa&act=edit" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">brightness_7</i>
                                <input id="total_all" type="text" class="validate" name="total_all" value="<?php echo $row['total_all']; ?>">
                                <?php
                                if (isset($_SESSION['total_all'])) {
                                    $total_all = $_SESSION['total_all'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text"><' . $row['total_all'] .'></div>';
                                    unset($_SESSION['total_all']);
                                }
                                ?>
                                <label for="total_all"><strong>TOTAL HARGA</strong></label>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td colspan="5"><center><p class="add">Tidak ada charge tambahan</p></center></td></tr>
                    <?php
                }
                ?>

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submito" class="btn small green waves-effect waves-light">Ubah total harga <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=pa" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                    </div>
                </div> 
        </table>
    <?Php
     if (isset($_REQUEST['submito'])) {
       // print_r($_POST);die;
        //validasi form kosong
        if ($_REQUEST['total_all'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

           // $id_pa_detail = $_REQUEST['id_pa_detail'];
            $total_all = $_REQUEST['total_all'];
          $id_pa = $_REQUEST['id_pa'];

            $query = mysqli_query($config, "UPDATE tbl_pa_hasil SET total_all='$total_all' WHERE id_pa='$id_pa'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                header("Location: ./admin.php?page=pa");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }
    ?>
    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

    <?php
}
?>
