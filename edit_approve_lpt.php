 <?php
//cek session
//echo "<h1>Ini halaman yang tepat choiii</h1>";
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_lpt = $_REQUEST['id_lpt'];
        //$query = mysqli_query($config, "SELECT * FROM tbl_lpt WHERE id_lpt='$id_lpt'");
        //list($id_lpt) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['ttd_kabag'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

          
           
            $ttd_kabag = $_REQUEST['ttd_kabag'];

            $query = mysqli_query($config, "UPDATE tbl_approve_lpt SET ttd_kabag='$ttd_kabag', id_user='$id_user' WHERE id_lpt='$id_lpt'");

            if ($query == true) {
                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=app_lpt_v&id_lpt=' . $id_lpt . '";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        }
    }


        //$id_approvel_lpt = mysqli_real_escape_string($config, $_REQUEST['id_approve_lpt']);
        $id_lpt = $_REQUEST['id_lpt'];
        //echo "SELECT * FROM tbl_approve_lpt WHERE id_lpt='$id_lpt'";
        $query = mysqli_query($config, "SELECT * FROM tbl_approve_lpt WHERE id_lpt='$id_lpt'");
        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {
                ?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Approval PMK</a></li>
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
                                    <select class="browser-default validate" name="ttd_kabag" id="ttd_kabag" required>
                                        <option value="<?php echo $row['ttd_kabag']; ?>"><?php echo $row['ttd_kabag']; ?></option>
                                        <option value="Belum Dibaca">Belum Dibaca</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <?php
                                if (isset($_SESSION['ttd_kabag'])) {
                                    $ttd_kabag = $_SESSION['ttd_kabag'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $ttd_kabag . '</div>';
                                    unset($_SESSION['ttd_kabag']);
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
                                <a href="?page=app_lpt_v&id_lpt=<?php echo $row['id_lpt']; ?>" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
