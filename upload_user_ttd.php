<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    ($_GET);
    //         die; 
    die();
} else {

    if (isset($_POST['submit'])) {
        //         print_r($_GET); die; 

        $id_user = $_REQUEST['id_user'];
     

        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $file_ttd = $_FILES['file']['name'];
        $x = explode('.', $file_ttd);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['file']['size'];
        $target_dir = "upload/ttd/";
        $cek_data_qry = mysqli_query($config, "select * FROM tbl_user_upload where id_user='$id_user'");
        $cek_data = mysqli_num_rows($cek_data_qry);
        $cek_data_row = mysqli_fetch_array($cek_data_qry);

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 5044070) {
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file_ttd);
                $query = mysqli_query($config, "INSERT INTO tbl_user_upload (file_ttd,id_user) VALUES ('$file_ttd','$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_user_upload SET
                file_ttd        ='$file_ttd',
                id_user     ='$id_user' 
                WHERE id_upload_ttd=$cek_data_row[id_upload_ttd]");
            }

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! berhasil diupload';
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
    }
?>

    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <ul class="left">
                        <li class="waves-effect waves-light"><a href="" class="judul"><i class="material-icons">file_upload</i> Upload</a></li>
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
        <form class="col s12" method="post" action="?page=usr&act=upload_ttd" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">

            </div>

            <div class="input-field col s6">
                <div class="file-field input-field">
                    <input type="hidden" id="id_user" name="id_user" value="<?= $_GET['id_user'] ?>" />
                    <div class="btn small light-green darken-1">
                        <span>Upload</span>
                        <input type="file" id="file" name="file" />
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload">
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
            <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
        </div>
    </div>

    </form>
    <!-- Form END -->

    </div>
    <!-- Row form END -->

<?php
}
?>