<link rel="stylesheet" href="">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    
     if ($_SESSION['admin'] != 7 AND $_SESSION['admin'] != 15) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
    } else {

    if (isset($_REQUEST['submit'])) {

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
        $sisa_cuti = $_REQUEST['sisa_cuti'];
        $divisi = $_REQUEST['divisi'];
        $nip = $_REQUEST['nip'];
        $admin = $_REQUEST['admin'];
        $nama_tenant = $_REQUEST['nama_tenant'];

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
                if ($ukuran < 2500000) {

                    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                    $query = mysqli_query($config, "INSERT INTO tbl_user(tgl_join,username,password,nama,divisi,nip,file,admin,nama_tenant,email,tgl_lahir,tmpt_lahir,status,status_pajak,kontrak_habis,no_hp,kategori,jabatan,sisa_cuti)
                    VALUES('$tgl_join','$username',MD5('$password'),'$nama','$divisi','$nip','$nfile','$admin','$nama_tenant','$email','$tgl_lahir','$tmpt_lahir','$status','$status_pajak','$kontrak_habis','$no_hp','$kategori','$jabatan','$sisa_cuti')");


                    if ($query == true) {
                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                        header("Location: ./admin.php?page=usr");
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
            $query = mysqli_query($config, "INSERT INTO tbl_user(tgl_join,username,password,nama,divisi,nip,file,admin,nama_tenant,email,tgl_lahir,tmpt_lahir,status,status_pajak,kontrak_habis,no_hp,kategori,jabatan,sisa_cuti)
                    VALUES('$tgl_join','$username',MD5('$password'),'$nama','$divisi','$nip','$nfile','$admin','$nama_tenant','$email','$tgl_lahir','$tmpt_lahir','$status','$status_pajak','$kontrak_habis','$no_hp','$kategori','$jabatan','$sisa_cuti')");

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=usr");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }
    ?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="?page=usr&act=add_karyawan" class="judul"><i class="material-icons">person_add</i> Tambah Karyawan</a></li>
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
        <form class="col s12" method="post" action="?page=usr&act=add_karyawan" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">date_range</i>
                <input id="tgl_join" type="text" name="tgl_join" class="datepicker" required>
                <?php
                if (isset($_SESSION['tgl_join'])) {
                    $tgl_join = $_SESSION['tgl_join'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_join . '</div>';
                    unset($_SESSION['tgl_join']);
                }
                ?>
                <label for="tgl_join">Tgl.Join</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">account_circle</i>
                <input id="username" type="text" class="validate" name="username" required>
                <?php
                if (isset($_SESSION['uname'])) {
                    $uname = $_SESSION['uname'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $uname . '</div>';
                    unset($_SESSION['uname']);
                }
                if (isset($_SESSION['errUsername'])) {
                    $errUsername = $_SESSION['errUsername'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errUsername . '</div>';
                    unset($_SESSION['errUsername']);
                }
                if (isset($_SESSION['errUser5'])) {
                    $errUser5 = $_SESSION['errUser5'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errUser5 . '</div>';
                    unset($_SESSION['errUser5']);
                }
                ?>
                <label for="username">Username</label>
            </div>
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">text_fields</i>
                <input id="nama" type="text" class="validate" name="nama" required>
                <?php
                if (isset($_SESSION['namauser'])) {
                    $namauser = $_SESSION['namauser'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $namauser . '</div>';
                    unset($_SESSION['namauser']);
                }
                ?>
                <label for="nama">Nama</label>
            </div>
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">lock</i>
                <input id="password" type="password" class="validate" name="password" required>
                <?php
                if (isset($_SESSION['errPassword'])) {
                    $errPassword = $_SESSION['errPassword'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errPassword . '</div>';
                    unset($_SESSION['errPassword']);
                }
                ?>
                <label for="password">Password</label>
            </div>
            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">looks_one</i>
                <input id="nip" type="text" class="validate" name="nip">
                <?php
                if (isset($_SESSION['nipuser'])) {
                    $nipuser = $_SESSION['nipuser'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nipuser . '</div>';
                    unset($_SESSION['nipuser']);
                }
                ?>
                <label for="nip">NIP</label>
            </div>
            <div class="input-field col s10">
                <i class="material-icons prefix md-prefix">supervisor_account</i><label>Pilih Tipe User</label><br />
                <div class="input-field col s11">
                    <select class="browser-default validate" name="admin" id="admin">
                        <option value="">Pilih Level User</option>
                        <option value="2">Adm.TK</option>
                        <option value="3">TR</option>
                        <option value="4">Mng.Eng</option>
                        <option value="5">Engineer</option>
                        <option value="6">Keu</option>
                        <option value="7">GM/Adm</option>
                        <option value="8">Mng.Mkt</option>
                        <option value="9">Purch</option>
                        <option value="10">Mng.Keu</option>
                        <option value="11">Scr</option>
                        <option value="12">Gudang</option>
                        <option value="13">Ka.Facility</option>
                        <option value="11">Spv.Hkp</option>
                        <option value="15">HRGA</option>
                        <option value="11">Hkp</option>
                        <option value="11">Parkir</option>
                        <option value="18">Mkt.Event</option>
                        <option value="19">Tenant</option>
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

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">assignment</i><label>Jabatan</label><br />
                <div class="input-field col s9 ">
                    <select name="jabatan" class="browser-default validate theSelect" id="jabatan">
                        <?php
                        //Membuat koneksi ke database 
                        //Perintah sql untuk menampilkan semua data pada tabel
                        $sql = "SELECT * FROM master_jabatan
                                                                                             
                                                                    ORDER BY id_jabatan ASC ";

                        $hasil = mysqli_query($config, $sql);

                        while ($data = mysqli_fetch_array($hasil)) {
                            ?>
                            <option value="<?php
                            echo addslashes($data['jabatan']);
                            ?>"><?php
                                        echo addslashes($data['jabatan']);
                                        ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="input-field col s10">
                <i class="material-icons prefix md-prefix">accessibility</i><label>Divisi</label><br />
                <div class="input-field col s11">
                    <select class="browser-default validate" name="divisi" id="divisi">
                        <option value="">Pilih Divisi</option>
                        <option value="Teknik">Teknik</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="HRGA">HRGA</option>
                        <option value="Busdev">Busdev</option>
                        <option value="Legal">Legal</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Outsorcing">Outsorcing</option>
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

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">email</i>
                <input id="email" type="email" class="validate" name="email">
                <?php
                if (isset($_SESSION['email'])) {
                    $email = $_SESSION['email'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $email . '</div>';
                    unset($_SESSION['email']);
                }
                ?>
                <label for="email">Email</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">date_range</i>
                <input id="tgl_lahir" type="text" name="tgl_lahir" class="datepicker">
                <?php
                if (isset($_SESSION['tgl_lahir'])) {
                    $tgl_lahir = $_SESSION['tgl_lahir'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_lahir . '</div>';
                    unset($_SESSION['tgl_lahir']);
                }
                ?>
                <label for="tgl_lahir">Tanggal Lahir</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">domain</i>
                <input id="tmpt_lahir" type="text" class="validate" name="tmpt_lahir">
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
                <i class="material-icons prefix md-prefix">assignment_ind</i><label>Status</label><br />
                <div class="input-field col s11">
                    <select class="browser-default validate" name="status" id="status">
                        <option value="">Pilih Status</option>
                        <option value="Tetap">Tetap</option>
                        <option value="Kontrak">Kontrak</option>
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

            <div class="input-field col s10">
                <i class="material-icons prefix md-prefix">camera_front</i><label>Status Pajak</label><br />
                <div class="input-field col s11">
                    <select class="browser-default validate" name="status_pajak" id="status_pajak">
                        <option value="">Pilih Status</option>
                        <option value="TK">TK</option>
                        <option value="K0">K0</option>
                        <option value="K1">K1</option>
                        <option value="K2">K2</option>
                        <option value="K3">K3</option>
                    </select>
                </div>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">date_range</i>
                <input id="kontrak_habis" type="text" name="kontrak_habis" class="datepicker">
                <?php
                if (isset($_SESSION['kontrak_habis'])) {
                    $kontrak_habis = $_SESSION['kontrak_habis'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kontrak_habis . '</div>';
                    unset($_SESSION['kontrak_habis']);
                }
                ?>
                <label for="kontrak_habis">Kontrak Habis</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">phone</i>
                <input id="no_hp" type="tel" class="validate" name="no_hp">
                <?php
                if (isset($_SESSION['no_hp'])) {
                    $no_hp = $_SESSION['no_hp'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_hp . '</div>';
                    unset($_SESSION['no_hp']);
                }
                ?>
                <label for="no_hp">No Hp</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">beach_access</i>
                <input id="sisa_cuti" type="number" class="validate" name="sisa_cuti">
                <?php
                if (isset($_SESSION['sisa_cuti'])) {
                    $sisa_cuti = $_SESSION['sisa_cuti'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sisa_cuti . '</div>';
                    unset($_SESSION['sisa_cuti']);
                }
                ?>
                <label for="sisa_cuti">Sisa Cuti</label>
            </div>

            <div class="input-field col s9">
                <i class="material-icons prefix md-prefix">supervisor_account</i><label>Kategori User</label><br />
                <div class="input-field col s11 right">
                    <select class="browser-default validate" name="kategori" id="kategori">
                        <option value="karyawan">Karyawan</option>
                        <option value="outsorcing">Outsorcing</option>
                    </select>
                </div>

                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>File</span>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload Foto">
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
                <div class="row jarak-form">
                    <form class=" col s12" method="post" action="">
                        <div class="input-field col s6" style="display: none;">
                            <i class="material-icons prefix md-prefix">assignment_ind</i><label>Nama Tenant</label><br />
                            <div class="input-field col s11 right">
                                <select name="nama_tenant" class="browser-default validate theSelect" id="nama_tenant">
                                    <?php
                                    //Membuat koneksi ke database akademik
                                    //Perintah sql untuk menampilkan semua data pada tabel master barang
                                    $sql = "select * from master_tenant ORDER by nama_tenant ASC";

                                    $hasil = mysqli_query($config, $sql);
                                    $no = 0;
                                    while ($data = mysqli_fetch_array($hasil)) {
                                        $no++;
                                        ?>
                                        <option value="<?php echo $data['nama_tenant']; ?>"><?php echo $data['nama_tenant']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
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
        <script>
            $(".theSelect").select2();
        </script>
        <script>
            function myalert() {
            alert("Apa anda yakin ingin menghapus?");
            }
        </script>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <!-- Row form END -->

    <?php
}
}
?>