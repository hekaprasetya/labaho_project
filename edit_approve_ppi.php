<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_ppi = $_REQUEST['id_ppi'];
        $query = mysqli_query($config, "SELECT * FROM tbl_ppi WHERE id_ppi='$id_ppi'");
        list($id_ppi) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['manager_tk'] == "" || $_REQUEST['manager_tk'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_approve_ppi = $_REQUEST['id_approve_ppi'];
            $manager_tk = $_REQUEST['manager_tk'];
            $status = $_REQUEST['status'];
            $id_user = $_SESSION['id_user'];

            //validasi input data


            $query = mysqli_query($config, "UPDATE tbl_approve_ppi SET  manager_tk='$manager_tk',status='$status' ,  id_ppi='$id_ppi', id_user='$id_user' WHERE id_approve_ppi='$id_approve_ppi'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=ppi&act=app_ppi&id_ppi=' . $id_ppi . '";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    } else {

        $id_approve_ppi = mysqli_real_escape_string($config, $_REQUEST['id_approve_ppi']);
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_ppi WHERE id_approve_ppi='$id_approve_ppi'");
        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {
                ?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Approval PPI</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
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
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="">

                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">low_priority</i><label>Manager Engineering</label><br/>
                                <div class="input-field col s11 right">
                                    <select class="browser-default validate" name="manager_tk" id="sifat1">
                                        <option value="<?php echo $row['manager_tk']; ?>"><?php echo $row['manager_tk']; ?></option>
                                         <option value="Belum Dibaca">Belum Dibaca</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>


                                <?php
                                if (isset($_SESSION['manager_tk'])) {
                                    $manager_tk = $_SESSION['manager_tk'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $manager_tk . '</div>';
                                    unset($_SESSION['manager_tk']);
                                }
                                ?>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br/>
                                <div class="input-field col s11 right">
                                    <select class="browser-default validate" name="status" id="status">
                                        <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
                                       <option value="Progres">Progres</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                                <?php
                                if (isset($_SESSION['status'])) {
                                    $status = $_SESSION['status'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status . '</div>';
                                    unset($_SESSION['status']);
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Row in form END -->

                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name ="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=ppi&act=app_ppi&id_ppi=<?php echo $row['id_ppi']; ?>" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
}
?>
