<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['sub'])) {

        $id_user = $_SESSION['id_user'];

        if (isset($_REQUEST['submit'])) {

            //validasi form kosong
            if ($_REQUEST['no_hp'] == "" || $_REQUEST['password'] == "" || $_REQUEST['tgl_lahir'] == "" || $_REQUEST['tmpt_lahir'] == "") {
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                header("Location: ./admin.php?page=pro_karyawan&sub=pass");
                die();
            } else {


                $password_lama = $_REQUEST['password_lama'];
                $password = $_REQUEST['password'];
                $no_hp = $_REQUEST['no_hp'];
                $tgl_lahir = $_REQUEST['tgl_lahir'];
                $tmpt_lahir = $_REQUEST['tmpt_lahir'];


                //validasi input data
                if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $tgl_lahir)) {
                    $_SESSION['eptgl_lahir'] = 'Form Tanggal hanya boleh berformat YYYY-MM-DD';
                    header("Location: ./admin.php?page=pro_karyawan&sub=pass");
                    die();
                } else {

                    if (!preg_match("/^[a-zA-Z., ]*$/", $tmpt_lahir)) {
                        $_SESSION['eptmpt_lahir'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.) dan koma(,)';
                        header("Location: ./admin.php?page=pro_karyawan&sub=pass");
                        die();
                    } else {

                        if (!preg_match("/^[0-9 -]*$/", $no_hp)) {
                            $_SESSION['epno_hp'] = 'Form NIP hanya boleh mengandung karakter angka, spasi dan minus(-)';
                            header("Location: ./admin.php?page=pro_karyawan&sub=pass");
                            die();
                        } else {
                            if (strlen($password) < 5) {
                                $_SESSION['errEpPassword5'] = 'Password minimal 5 karakter!';
                                header("Location: ./admin.php?page=pro_karyawan&sub=pass");
                                die();
                            } else {

                                $query = mysqli_query($config, "SELECT password FROM tbl_user WHERE id_user='$id_user' AND password=MD5('$password_lama')");
                                if (mysqli_num_rows($query) > 0) {
                                    $do = mysqli_query($config, "UPDATE tbl_user SET password=MD5('$password'), no_hp='$no_hp', tgl_lahir='$tgl_lahir', tmpt_lahir='$tmpt_lahir' WHERE id_user='$id_user'");

                                    if ($do == true) {
                                        echo '<script language="javascript">
                                                        window.alert("SUKSES! profil berhasil diupdate");
                                                        window.location.href="./logout.php";
                                                      </script>';
                                    } else {
                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                        header("Location: ./admin.php?page=pro_karyawan&sub=pass");
                                        die();
                                    }
                                } else {
                                    echo '<script language="javascript">
                                                    window.alert("ERROR! Password lama tidak sesuai. Anda mungkin tidak memiliki akses ke halaman ini");
                                                    window.location.href="./logout.php";
                                                  </script>';
                                }
                            }
                        }
                    }
                }
            }
        } else { ?>

            <!-- UPDATE PROFIL PAGE START-->
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="?page=pro_karyawan&sub=pass" class="judul"><i class="material-icons">mode_edit</i> Edit Profil</a></li>
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
                <form class="col s12" method="post" action="?page=pro_karyawan&sub=pass">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">phone</i>
                            <input id="no_hp" type="tel" class="validate" name="no_hp" value="<?php echo $_SESSION['no_hp']; ?>" required>
                            <?php
                            if (isset($_SESSION['epno_hp'])) {
                                $epno_hp = $_SESSION['epno_hp'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epno_hp . '</div>';
                                unset($_SESSION['epno_hp']);
                            }
                            ?>
                            <label for="no_hp">No HandPhone</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_lahir" type="date" name="tgl_lahir" class="validate" value="<?php echo $_SESSION['tgl_lahir']; ?>">
                            <?php
                            if (isset($_SESSION['eptgl_lahir'])) {
                                $eptgl_lahir = $_SESSION['eptgl_lahir'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eptgl_lahir . '</div>';
                                unset($_SESSION['eptgl_lahir']);
                            }
                            ?>
                            <label for="tgl_lahir">Tgl Lahir</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">domain</i>
                            <input id="tmpt_lahir" type="text" class="validate" name="tmpt_lahir" value="<?php echo $_SESSION['tmpt_lahir']; ?>" required autocomplete="off">
                            <?php
                            if (isset($_SESSION['eptmpt_lahir'])) {
                                $eptmpt_lahir = $_SESSION['eptmpt_lahir'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eptmpt_lahir . '</div>';
                                unset($_SESSION['eptmpt_lahir']);
                            }
                            ?>
                            <label for="tmpt_lahir">Tmpt Lahir</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">lock_outline</i>
                            <input id="password_lama" type="password" class="validate" name="password_lama" required>
                            <label for="password_lama">Password Lama</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">lock</i>
                            <input id="password" type="password" class="validate" name="password" required>
                            <?php
                            if (isset($_SESSION['errEpPassword5'])) {
                                $errEpPassword5 = $_SESSION['errEpPassword5'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errEpPassword5 . '</div>';
                                unset($_SESSION['errEpPassword5']);
                            }
                            ?>
                            <label for="password">Password Baru</label>
                            <small class="red-text">*Setelah menekan tombol "Simpan", Anda akan diminta melakukan Login ulang.</small>
                        </div>
                    </div>
                    <!-- Row in form END -->
                    <br />
                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=pro_karyawan" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->
            <!-- UPDATE PROFIL PAGE END-->

        <?php
        }
    } else {
        ?>

        <!-- SHOW PROFIL PAGE START-->
        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue darken-2">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">person</i> Profil User</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->

        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="post" action="save.php">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">account_circle</i>
                        <input id="username" type="text" value="<?php echo $_SESSION['username']; ?>" readonly disable>
                        <label for="username">Username</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">text_fields</i>
                        <input id="nama" type="text" value="<?php echo $_SESSION['nama']; ?>" readonly disable>
                        <label for="nama">Nama</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">lock</i>
                        <input id="password" type="text" value="*" readonly disable>
                        <label for="password">Password</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="nip" type="text" value="<?php echo $_SESSION['nip']; ?>" readonly disable>
                        <label for="nip">NIP</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">accessibility</i>
                        <input id="divisi" type="text" value="<?= $_SESSION['divisi']; ?>" readonly disable>
                        <label for="divisi">Divisi</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">assignment</i>
                        <input type="text" id="jabatan" value="<?= $_SESSION['jabatan']; ?>" readonly disable>
                        <label for="jabatan">Jabatan</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">email</i>
                        <input type="text" name="email" value="<?= $_SESSION['email']; ?>" readonly disable>
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_lahir" type="text" value="<?= indoDate($_SESSION['tgl_lahir']); ?>" readonly disable>
                        <label for="tgl_lahir">Tanggal Lahir</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">domain</i>
                        <input id="tmpt_lahir" type="text" value="<?= $_SESSION['tmpt_lahir']; ?>" readonly disable>
                        <label for="tmpt_lahir">Tempat Lahir</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">assignment_ind</i>
                        <input id="status" type="text" value="<?= $_SESSION['status']; ?>" readonly disable>
                        <label for="status">Status</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="kontrak_habis" type="text" value="<?= indoDate($_SESSION['kontrak_habis']); ?>" readonly disable>
                        <label for="kontrak_habis">Kontrak Habis</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_join" type="text" value="<?= indoDate($_SESSION['tgl_join']); ?>" readonly disable>
                        <label for="tgl_join">Tanggal Join</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">phone</i>
                        <input id="no_hp" type="tel" value="<?= $_SESSION['no_hp']; ?>" readonly disable>
                        <label for="no_hp">No Hp</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">beach_access</i>
                        <input id="sisa_cuti" type="number" value="<?= $_SESSION['sisa_cuti']; ?>" readonly disable>
                        <label for="sisa_cuti">Sisa Cuti</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">supervisor_account</i>
                        <input type="text" id="kategori" value="<?= $_SESSION['kategori']; ?>" readonly disable>
                        <label for="kategori">Kategori</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">supervisor_account</i>
                        <input type="text" id="admin" value="<?= $_SESSION['admin']; ?>" readonly disable>
                        <label for="admin">Tipe User</label>
                    </div>
                    <div class="col s3 m3">
                        <h4 class="header">foto</h4>
                        <div class="card horizontal pro">

                            <?php
                            if (!empty($_SESSION['file'])) {
                            ?>
                                <a href="/simartektesting/upload/user/<?= $_SESSION['file'] ?>"><img src="/simartektesting/upload/user/<?= $_SESSION['file'] ?>"></a>
                            <?php
                            } else {
                            ?>
                                <em>Tidak ada foto</em>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Row in form END -->
                <br />
                <div class="row">
                    <div class="col m12">
                        <a href="?page=pro_karyawan&sub=pass" class="btn-large blue waves-effect waves-light">EDIT PROFIL<i class="material-icons">mode_edit</i></a>
                    </div>
                </div>

            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->
        <!-- SHOW PROFIL PAGE START-->

<?php
    }
}
?>