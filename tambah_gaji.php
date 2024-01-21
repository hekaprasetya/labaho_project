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
    
     if ($_SESSION['admin'] != 15) {
        echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
    } else {

    if (isset($_REQUEST['submit'])) {
        //print_r($_POST);die;
        //validasi form kosong
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {


            $nama = $_REQUEST['nama'];
            $id_user = $_SESSION['id_user'];


            $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $target_dir = "upload/gaji/";

            if (empty($nama)) {
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                header("Location: ./admin.php?page=gaji&act=add");
                exit();
            }

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if ($file != "") {


                $nfile = uniqid() . "-" . $file;

                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 2500000) {
                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);
                        $query = mysqli_query($config, "INSERT INTO tbl_gaji(nama,file,id_user)
                                                        VALUES('$nama','$nfile','$id_user')");

                        if ($query == true) {
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=gaji");
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
                $query = mysqli_query($config, "INSERT INTO tbl_gaji(nama,file,id_user)
                 VALUES('$nama','$file','$id_user')");
                if ($query == true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=gaji");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
    ?>
    <?php
    // if ('pastedImage' != '') {
    //     if (isset($_REQUEST['pastedImage'])) {
    //         $file = $_FILES['file'];
    //         $nama = $_REQUEST['nama'];
    //         $id_user = $_SESSION['id_user'];
    //         $target_dir = "upload/gaji/";
    //         $nfile = uniqid() . "-" . $fileName;
    //         move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);
    //         $query = mysqli_query($config, "INSERT INTO tbl_gaji(nama,file,id_user)
    //   VALUES('$nama','$nfile','$id_user')");
    //         if ($query == true) {
    //             $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
    //             header("Location: ./admin.php?page=gaji");
    //             die();
    //         } else {
    //             $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
    //             echo '<script language="javascript">window.history.back();</script>';
    //         }
    //     } else {
    //         echo 'PastedImage harus berupa gambar';
    //     }
    // }
    ?>
    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="?page=gaji&act=add" class="judul"><i class="material-icons">build</i> Tambah Data</a></li>
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
        <form class="col s12" method="POST" action="?page=gaji&act=add" id="form" enctype="multipart/form-data">

            <!-- Row in form START -->

            <div class="input-field col s8">
                <i class="material-icons prefix md-prefix">people</i>
                <label for="nama">Nama Karyawan</label><br />
                <div class="input-field col s9">
                    <select name="nama" class="browser-default validate theSelect" id="nama">

                        <?php
                        //Membuat koneksi ke database 
                        //Perintah sql untuk menampilkan semua data pada tabel
                        $sql = "SELECT * FROM tbl_user
                                                                                             
                          ORDER BY id_user ASC ";

                        $hasil = mysqli_query($config, $sql);

                        while ($data = mysqli_fetch_array($hasil)) {
                            ?>
                            <option value="<?php
                            echo addslashes($data['nama']);
                            ?>"><?php
                                        echo addslashes($data['nama']);
                                        ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>



            <div class="input-field col s6">
                <div class="file-field input-field">
                    <div class="btn small light-green darken-1 right">
                        <span>File</span>
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate input" type="text" placeholder="Upload file" id="fileInput">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $_SESSION['id_user']; ?>">
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
            <a href="?page=gaji" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <script>
        $(".theSelect").select2();
    </script>
    <script>
        function myalert() {
        alert("Apa anda yakin ingin menghapus?");
        }
    </script>
    <script>

    </script>
    <script>
        // const form = document.getElementById("form");
        // const fileInput = document.getElementById("fileInput");
        // fileInput.addEventListener('change', () => {
        //     form.submit();
        // });

        // window.addEventListener('paste', e => {
        //     fileInput.files = e.clipboardData.files;
        // });
    </script>
    <script>
        document.onpaste = function(e) {
        // Periksa apakah input dengan id=nama sudah terisi
        var nama = document.getElementById('nama').value;
        if (nama == 'Null') {
        // Tampilkan pesan peringatan
        alert('Nama karyawan belum diisi!');
        // Hentikan eksekusi fungsi
        return;
        }
        var items = e.clipboardData.items;
        // Dapatkan nama file



        // Jika nama file tidak ada, gunakan nama default

        var files = [];
        for (var i = 0, len = items.length; i < len; ++i) {
        var item = items[i];
        if (item.kind === "file") {
        var namaFile;
        if (item.getAsFile().name) {
        namaFile = item.getAsFile().name;
        }
        submitFileForm(item.getAsFile(), "paste");
        }
        }
        };

        function submitFileForm(file, type) {
        // Buat objek FormData
        var formData = new FormData();

        // Tambahkan file ke objek FormData
        formData.append('file', file);

        // Tambahkan tipe file ke objek FormData
        formData.append('submission-type', type);
        var nama = document.getElementById('nama').value;
        var id_user = document.getElementById('id_user').value;
        // Tambahkan variabel $nama ke objek FormData
        formData.append('nama', nama);

        // Tambahkan variabel $id_user ke objek FormData
        formData.append('id_user', id_user);

        // Buat objek XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Buka koneksi ke server
        xhr.open('POST', 'upload.php');

        // Set response type menjadi blob
        xhr.responseType = 'blob';

        // Tambahkan event listener untuk load
        xhr.onload = function() {
        if (xhr.status == 600) {
        // Tampilkan pesan peringatan
        alert('GAGAL!! File terlalu besar.');
        // Hentikan eksekusi fungsi
        return;
        }
        if (xhr.status == 700) {
        // Tampilkan pesan peringatan
        alert('GAGAL!! hanya gambar yang dizinkan.');
        // Hentikan eksekusi fungsi
        return;

        }
        if (xhr.status == 800) {
        // Tampilkan pesan peringatan
        alert('GAGAL!! Tidak ada file yang diunggah.');
        // Hentikan eksekusi fungsi
        return;

        } else {
        var input = document.getElementById('fileInput');
        input.value = file.name;
        alert('Berhasil Menambahkan Data!');
        window.location.href = '?page=gaji';

        }
        };

        // Kirim data ke server
        xhr.send(formData);
        }
    </script>
    <!-- Row form END -->
       <script>
           $(".theSelect").select2();

        </script>
    <?php
}
}
?>