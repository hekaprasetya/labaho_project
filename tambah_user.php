<link rel="stylesheet" href="">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<?php
//cek session
$userId = $_SESSION['admin'];
$query = mysqli_query($config, "SELECT * FROM tbl_user WHERE admin='$userId'");
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if ($_SESSION['admin'] != 3) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
    } else {

        if (isset($_REQUEST['submit'])) {

            $tgl_join = $_REQUEST['tgl_join'];
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $nama = $_REQUEST['nama'];
            $divisi = $_REQUEST['divisi'];
            $nip = $_REQUEST['nip'];
            $admin = $_REQUEST['admin'];
            $nama_tenant = $_REQUEST['nama_tenant'];
            $kategori = $_REQUEST['kategori'];
                
            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/ttd/";

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

                        $query = mysqli_query($config, "INSERT INTO tbl_user(tgl_join,username,password,nama,divisi,nip,file,admin,nama_tenant,kategori)
                                                                        VALUES('$tgl_join','$username',MD5('$password'),'$nama','$divisi','$nip','$nfile','$admin','$nama_tenant','$kategori')");

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
                $query = mysqli_query($config, "INSERT INTO tbl_user(tgl_join,username,password,nama,divisi,nip,file,admin,nama_tenant,kategori)
                                                            VALUES('$tgl_join','$username',MD5('$password'),'$nama','$divisi','$nip','$nfile','$admin','$nama_tenant','$kategori')");

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
                            <li class="waves-effect waves-light"><a href="?page=usr&act=add_tenant" class="judul"><i class="material-icons">person_add</i> User Tenant</a></li>
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
            <form class="col s12" method="post" action="?page=usr&act=add" enctype="multipart/form-data" >

                <!-- Row in form START -->
                <div class="input-field col s8">
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

                <div class="input-field col s8">
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
                <div class="input-field col s8">
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
                <!--div class="input-field col s8">
                   <i class="material-icons prefix md-prefix">accessibility</i>
                   <input id="divisi" type="text" class="validate" name="divisi">
                <?php
                if (isset($_SESSION['divisi'])) {
                    $divisi = $_SESSION['divisi'];
                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $divisi . '</div>';
                    unset($_SESSION['divisi']);
                }
                ?>
                   <label for="divisi">Divisi</label>
               </div-->
                <div class="input-field col s8">
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
                <!--div class="input-field col s8">
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
                </div-->
                
                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">supervisor_account</i><label>Pilih Tipe User</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="admin" id="admin" required>
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">assignment_ind</i><label>Nama Tenant</label><br/>
                            <div class="input-field col s11 right">
                                <select  name="nama_tenant" class="browser-default validate theSelect"  id="nama_tenant">
                                    <?php
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

                        <div class="input-field col s8">
                            <i class="material-icons prefix md-prefix">low_priority</i><label>Kategori</label><br/>
                            <div class="input-field col s11 right">
                                <select class="browser-default validate" name="kategori" id="kategori" required>
                                    <option value="Tenant">Tenant</option>
                                </select>
                            </div>
                        </div>


                        <div class="input-field col s6">
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
