<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {
         // print_r($_POST);die;
        $id_alat = $_REQUEST['id_alat'];
        $query = mysqli_query($config, "SELECT * FROM tbl_alat WHERE id_alat='$id_alat'");
        $no = 1;
        list($id_alat) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['status_pinjam_alat'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_pinjam = $_REQUEST['no_pinjam'];
            $nama_alat = $_REQUEST['nama_alat'];
            $status_pinjam_alat = $_REQUEST['status_pinjam_alat'];
            $catatan = $_REQUEST['catatan'];
            $id_user = $_SESSION['id_user'];

            $query = mysqli_query($config, "INSERT INTO tbl_alat_pinjam(no_pinjam,nama_alat,status_pinjam_alat,catatan,id_user)
                     VALUES('$no_pinjam','$nama_alat','$status_pinjam_alat','$catatan','$id_user')");

            if ($query == true) {
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                $last_insert_id = mysqli_insert_id($config);
                echo '<script language="javascript">
                window.location.href="./admin.php?page=pinjam_alat";
              </script>';
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
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">build</i> Pinjam Alat</a></li>
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

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_pinjam FROM tbl_alat_pinjam");
                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('Y-m');
                    $kode_jadi = "PJ/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_pinjam'])) {
                        $no_pinjam = $_SESSION['no_pinjam'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_pinjam . '</div>';
                        unset($_SESSION['no_pinjam']);
                    }
                    ?>
                    <label for="no_pinjam">No.Pinjam</label>
                    <input type="text" class="form-control" id="no_lpg" name="no_pinjam"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_lpg" name="no_pinjam"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s12">
                      <i class="material-icons prefix md-prefix">build</i><label>Nama Alat</label><br/>
                       <div class="input-field col s11 right">
                    <select class="browser-default validate" name="nama_alat" id="nama_alat" required>
                        <?php
                        //Membuat koneksi ke database akademik

                        //Perintah sql untuk menampilkan semua data pada tabel jurusan
                        $sql = "select * from tbl_alat";

                        $hasil = mysqli_query($config, $sql);
                        $no = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                            $no++;
                            ?>
                            <option value="<?php echo $data['nama_alat']; ?>"><?php echo $data['nama_alat']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                       </div>
                </div>  

                <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">low_priority</i><label>Status Pinjam</label><br/>
                    <div class="input-field col s11 right">
                        <select class="browser-default validate" name="status_pinjam_alat" id="status_pinjam_alat" required>
                            <option value="Pinjam">Pinjam</option>
                        </select>
                    </div>
                </div>
                
                  <div class="input-field col s12">
                    <i class="material-icons prefix md-prefix">note</i>
                    <textarea id="catatan" class="materialize-textarea validate" name="catatan" required>-</textarea>
                    <?php
                    if (isset($_SESSION['catatan'])) {
                        $catatan = $_SESSION['catatan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                        unset($_SESSION['catatan']);
                    }
                    ?>
                    <label for="catatan"></label>
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

?>
