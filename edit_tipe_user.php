<?php
//cek session

if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        // Validasi form kosong 
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_user = $_REQUEST['id_user'];
            $tgl_join = $_REQUEST['tgl_join'];
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $jabatan = $_REQUEST['jabatan'];
            $kategori = $_REQUEST['kategori'];
            $nama = $_REQUEST['nama'];
            $email = $_REQUEST['email'];
            $tgl_lahir = $_REQUEST['tgl_lahir'];
            $tmpt_lahir = $_REQUEST['tmpt_lahir'];
            $status = $_REQUEST['status'];
            $status_pajak = $_REQUEST['status_pajak'];
            $kontrak_habis = $_REQUEST['kontrak_habis'];
            $no_hp = $_REQUEST['no_hp'];
            $divisi = $_REQUEST['divisi'];
            $nip = $_REQUEST['nip'];
            $sisa_cuti = $_REQUEST['sisa_cuti'];
            $admin = $_REQUEST['admin'];


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/user/";

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {

                $rand = rand(1, 10000);
                $nfile = $rand . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 9000000) {

                        $id_user = $_REQUEST['id_user'];
                        $query = mysqli_query($config, "SELECT file FROM tbl_user WHERE id_user='$id_user'");
                        list($file) = mysqli_fetch_array($query);

                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                        if (!empty($file)) {
                            unlink($target_dir . $file);

                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);
                            $query = mysqli_query($config, "UPDATE tbl_user SET  username='$username',nama='$nama',divisi='$divisi',nip='$nip',admin='$admin',jabatan='$jabatan',kategori='$kategori',email='$email',tgl_lahir='$tgl_lahir',tmpt_lahir='$tmpt_lahir',status='$status',status_pajak='$status_pajak',no_hp='$no_hp',kontrak_habis='$kontrak_habis',sisa_cuti='$sisa_cuti',file='$nfile',tgl_join='$tgl_join' WHERE id_user='$id_user'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        } else {

                            //jika file kosong akan mengeksekusi script dibawah ini
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                            $query = mysqli_query($config, "UPDATE tbl_user SET username='$username',nama='$nama',divisi='$divisi',nip='$nip',admin='$admin',jabatan='$jabatan',kategori='$kategori',email='$email',tgl_lahir='$tgl_lahir',tmpt_lahir='$tmpt_lahir',status='$status',status_pajak='$status_pajak',no_hp='$no_hp',kontrak_habis='$kontrak_habis',sisa_cuti='$sisa_cuti',file='$nfile',tgl_join='$tgl_join' WHERE id_user='$id_user'");

                            if ($query == true) {
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=usr");
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
                $id_user = $_REQUEST['id_user'];

                $query = mysqli_query($config, "UPDATE tbl_user SET username='$username',nama='$nama',divisi='$divisi',nip='$nip',admin='$admin',jabatan='$jabatan',kategori='$kategori',email='$email',tgl_lahir='$tgl_lahir',tmpt_lahir='$tmpt_lahir',status='$status',status_pajak='$status_pajak',no_hp='$no_hp',kontrak_habis='$kontrak_habis',sisa_cuti='$sisa_cuti',tgl_join='$tgl_join' WHERE id_user='$id_user'");

                if ($query == true) {
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=usr");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    } else {


        $id_user = mysqli_real_escape_string($config, $_REQUEST['id_user']);
        $query = mysqli_query($config, "SELECT id_user, username, nama, divisi, nip,admin,jabatan,kategori,email,tgl_lahir,tmpt_lahir,status,status_pajak,no_hp,kontrak_habis, sisa_cuti , file,tgl_join FROM tbl_user WHERE id_user='$id_user'");
        list($id_user, $username, $nama, $divisi, $nip, $admin, $jabatan, $kategori, $email, $tgl_lahir, $tmpt_lahir, $status,$status_pajak, $no_hp, $kontrak_habis, $sisa_cuti, $file, $tgl_join) = mysqli_fetch_array($query);

        if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] == 1) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=usr";
                  </script>';
        } else {
            ?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i>Edit Data User</a></li>
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
                <form class="col s12" method="POST" action="?page=usr&act=edit" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s10">
                            <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="username" type="text" class="validate" value="<?php echo $username; ?>" name="username">
                            <?php
                            if (isset($_SESSION['eusername'])) {
                                $eusername = $_SESSION['eusername'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eusername . '</div>';
                                unset($_SESSION['eusername']);
                            }
                            ?>
                            <label for="eusername">Username</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">lock</i>
                            <input id="password" type="password" class="validate" name="password">
                            <?php
                            if (isset($_SESSION['errPassword'])) {
                                $errPassword = $_SESSION['errPassword'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errPassword . '</div>';
                                unset($_SESSION['errPassword']);
                            }
                            ?>
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">contacts</i>
                            <input id="nama" type="text" class="validate" name="nama" value="<?php echo $nama; ?>">
                            <?php
                            if (isset($_SESSION['enama'])) {
                                $enama = $_SESSION['enama'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama . '</div>';
                                unset($_SESSION['enama']);
                            }
                            ?>
                            <label for="enama">Nama</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">home</i>
                            <input id="nip" type="text" class="validate" name="nip" value="<?php echo $nip; ?>">
                            <?php
                            if (isset($_SESSION['enip'])) {
                                $enip = $_SESSION['enip'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enip . '</div>';
                                unset($_SESSION['enip']);
                            }
                            ?>
                            <label for="enip">NIP</label>
                        </div>


                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">accessibility</i>
                            <input id="divisi" type="text" class="validate" name="divisi" value="<?= $divisi; ?>">
                            <?php
                            if (isset($_SESSION['divisi'])) {
                                $divisi = $_SESSION['divisi'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi . '</div>';
                                unset($_SESSION['divisi']);
                            }
                            ?>
                            <label for="divisi">Divisi</label>
                        </div>

                        <div class="input-field col s12">
                            <i class="material-icons prefix md-prefix">Jabatan</i><label for="jabatan">Jabatan</label><br />
                            <div class="input-field col s11 right">
                                <select name="jabatan" class="browser-default validate theSelect" id="jabatan">
                                    <option value="<?php echo $jabatan; ?>" selected><?php echo $jabatan; ?></option>
                                    <?php
                                    // Perintah SQL untuk menampilkan data dengan nama_utility 
                                    $sql = "SELECT * FROM master_jabatan  ORDER BY id_jabatan ASC";

                                    $hasil = mysqli_query($config, $sql);

                                    while ($data = mysqli_fetch_array($hasil)) {
                                    ?>
                                        <option value="<?= htmlspecialchars($data['jabatan']); ?>"><?= htmlspecialchars($data['jabatan']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">email</i>
                            <input id="email" type="email" class="validate" name="email" value="<?php echo $email; ?>">
                            <?php
                            if (isset($_SESSION['email'])) {
                                $email = $_SESSION['email'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $email . '</div>';
                                unset($_SESSION['email']);
                            }
                            ?>
                            <label for="email">Email</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_lahir" type="text" name="tgl_lahir" class="datepicker" value="<?php echo $tgl_lahir; ?>">
                            <?php
                            if (isset($_SESSION['tgl_lahir'])) {
                                $tgl_lahir = $_SESSION['tgl_lahir'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_lahir . '</div>';
                                unset($_SESSION['tgl_lahir']);
                            }
                            ?>
                            <label for="tgl_lahir">Tanggal Lahir</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">domain</i>
                            <input id="tmpt_lahir" type="text" class="validate" name="tmpt_lahir" value="<?php echo $tmpt_lahir; ?>">
                            <?php
                            if (isset($_SESSION['tmpt_lahir'])) {
                                $tmpt_lahir = $_SESSION['tmpt_lahir'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tmpt_lahir . '</div>';
                                unset($_SESSION['tmpt_lahir']);
                            }
                            ?>
                            <label for="tmpt_lahir">Tempat Lahir</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">assignment_ind</i>
                            <input id="status" type="text" class="validate" name="status" value="<?php echo $status; ?>">
                            <?php
                            if (isset($_SESSION['status'])) {
                                $status = $_SESSION['status'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status . '</div>';
                                unset($_SESSION['status']);
                            }
                            ?>
                            <label for="status">Status</label>
                        </div>

                         <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">camera_front</i>
                            <input id="status_pajak" type="text" class="validate" name="status_pajak" value="<?php echo $status_pajak; ?>">
                            <?php
                            if (isset($_SESSION['status_pajak'])) {
                                $status_pajak = $_SESSION['status_pajak'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status_pajak . '</div>';
                                unset($_SESSION['status_pajak']);
                            }
                            ?>
                            <label for="status_pajak">Status Pajak</label>
                        </div>
                        
                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="kontrak_habis" type="text" name="kontrak_habis" class="datepicker" value="<?php echo $kontrak_habis; ?>">
                            <?php
                            if (isset($_SESSION['kontrak_habis'])) {
                                $kontrak_habis = $_SESSION['kontrak_habis'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kontrak_habis . '</div>';
                                unset($_SESSION['kontrak_habis']);
                            }
                            ?>
                            <label for="kontrak_habis">Kontrak Habis</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_join" type="text" name="tgl_join" class="datepicker" value="<?php echo $tgl_join; ?>">
                            <?php
                            if (isset($_SESSION['tgl_join'])) {
                                $tgl_join = $_SESSION['tgl_join'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_join . '</div>';
                                unset($_SESSION['tgl_join']);
                            }
                            ?>
                            <label for="tgl_join">Tanggal Join</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">phone</i>
                            <input id="no_hp" type="tel" class="validate" name="no_hp" value="<?php echo $no_hp; ?>">
                            <?php
                            if (isset($_SESSION['no_hp'])) {
                                $no_hp = $_SESSION['no_hp'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_hp . '</div>';
                                unset($_SESSION['no_hp']);
                            }
                            ?>
                            <label for="no_hp">No Hp</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">beach_access</i>
                            <input id="sisa_cuti" type="number" class="validate" name="sisa_cuti" value="<?php echo $sisa_cuti; ?>">
                            <?php
                            if (isset($_SESSION['sisa_cuti'])) {
                                $sisa_cuti = $_SESSION['sisa_cuti'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sisa_cuti . '</div>';
                                unset($_SESSION['sisa_cuti']);
                            }
                            ?>
                            <label for="sisa_cuti">Sisa Cuti</label>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">supervisor_account</i>
                            <label for="kategori">Kategori User</label><br />
                            <div class="input-field col s11 right">
                                <select class="browser-default validate" name="kategori" id="kategori">
                                    <option value="" <?php echo ($kategori === '') ? 'selected' : ''; ?>>Pilih kategori</option>
                                    <option value="karyawan" <?php echo ($kategori === 'karyawan') ? 'selected' : ''; ?>>Karyawan</option>
                                    <option value="tenant" <?php echo ($kategori === 'tenant') ? 'selected' : ''; ?>>Tenant</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-field col s10">
                            <i class="material-icons prefix md-prefix">camera_front</i>
                            <label for="admin">Pilih Tipe User</label><br />
                            <div class="input-field col s11 right">
                                <select class="browser-default validate" name="admin" id="admin">
                                    <option value="">Pilih Level User</option>
                                    <option value="2" <?php echo ($admin === '2') ? 'selected' : ''; ?>>Adm.TK</option>
                                    <option value="3" <?php echo ($admin === '3') ? 'selected' : ''; ?>>TR</option>
                                    <option value="4" <?php echo ($admin === '4') ? 'selected' : ''; ?>>Mng.Eng</option>
                                    <option value="5" <?php echo ($admin === '5') ? 'selected' : ''; ?>>Engineer</option>
                                    <option value="6" <?php echo ($admin === '6') ? 'selected' : ''; ?>>Keu</option>
                                    <option value="7" <?php echo ($admin === '7') ? 'selected' : ''; ?>>GM/Adm</option>
                                    <option value="8" <?php echo ($admin === '8') ? 'selected' : ''; ?>>Mng.Mkt</option>
                                    <option value="9" <?php echo ($admin === '9') ? 'selected' : ''; ?>>Purch</option>
                                    <option value="10" <?php echo ($admin === '10') ? 'selected' : ''; ?>>Mng.Keu</option>
                                    <option value="11" <?php echo ($admin === '11') ? 'selected' : ''; ?>>Scr</option>
                                    <option value="12" <?php echo ($admin === '12') ? 'selected' : ''; ?>>Gudang</option>
                                    <option value="13" <?php echo ($admin === '13') ? 'selected' : ''; ?>>Ka.Facility</option>
                                    <option value="14" <?php echo ($admin === '14') ? 'selected' : ''; ?>>Spv.Hkp</option>
                                    <option value="15" <?php echo ($admin === '15') ? 'selected' : ''; ?>>HRGA</option>
                                    <option value="16" <?php echo ($admin === '16') ? 'selected' : ''; ?>>Hkp</option>
                                    <option value="17" <?php echo ($admin === '17') ? 'selected' : ''; ?>>Parkir</option>
                                    <option value="18" <?php echo ($admin === '18') ? 'selected' : ''; ?>>Mkt.Event</option>
                                    <option value="19" <?php echo ($admin === '19') ? 'selected' : ''; ?>>Tenant</option>
                                </select>
                            </div>


                            <?php
                            if (isset($_SESSION['tipeuser'])) {
                                $tipeuser = $_SESSION['tipeuser'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tipeuser . '</div>';
                                unset($_SESSION['tipeuser']);
                            }
                            ?>
                        </div>
                        <div class="input-field col s12">
                            <div class="file-field input-field">
                                <div class="btn small light-green darken-1">
                                    <span>Foto</span>
                                    <input type="file" id="file" name="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload file">
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
                    <!-- Row in form END -->

                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=usr" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->

            <?php
        }
    }
}
?>