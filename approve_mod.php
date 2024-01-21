<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_mod = $_REQUEST['id_mod'];
        $query = mysqli_query($config, "SELECT * FROM tbl_modku WHERE id_mod='$id_mod'");
        $no = 1;
        list($id_mod) = mysqli_fetch_array($query);


        $status_mod = $_REQUEST['status_mod'];
        $id_mod     = $_REQUEST['id_mod'];
        $id_user    = $_SESSION['id_user'];
        $cek_data_qry = mysqli_query($config, "select * FROM tbl_approve_mod where id_mod='$id_mod'");
        $cek_data     = mysqli_num_rows($cek_data_qry);
        $cek_data_row = mysqli_fetch_array($cek_data_qry);

        //validasi input data

        if ($cek_data == 0) {
            $query = mysqli_query($config, "INSERT INTO tbl_approve_mod(status_mod, id_mod,id_user)
                                        VALUES('$status_mod','$id_mod','$id_user')");
        } else {
            $query = mysqli_query($config, "UPDATE tbl_approve_mod SET
                                status_mod='$status_mod', id_mod='$id_mod' ,id_user='$id_user' WHERE id_app_mod=$cek_data_row[id_app_mod]");

        }
            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                echo '<script language="javascript">
                                                window.location.href="./admin.php?page=mod";
                                              </script>';
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
            }
        
        } else {
            ?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Status</a></li>
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
                <form class="col s12" method="post" action="">

                    <!-- Row in form START -->
                    <div class="row">

                    </div>

                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">low_priority</i><label>Status Pekerjaan</label><br/>
                        <div class="input-field col s11 right">
                            <select class="browser-default validate" name="status_mod" id="status_mod" required>
                                <option value="Progres">Progres</option>
                                <option value="Material Kosong">Material Kosong</option>
                                <option value="Pending">Pending</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>


                        <?php
                        if (isset($_SESSION['status_mod'])) {
                            $status_mod = $_SESSION['status_mod'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $status_mod . '</div>';
                            unset($_SESSION['$status_mod']);
                        }
                        ?>
                    </div>


            </div>
            <!-- Row in form END -->

            <div class="row">
                <div class="col 6">
                    <button type="submit" name ="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
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
    }
    ?>
