<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_surat = $_REQUEST['id_surat'];
        $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
        $no = 1;
        list($id_surat) = mysqli_fetch_array($query);

        //validasi form kosong
        if ($_REQUEST['no_lpt'] == "" || $_REQUEST['no_form'] == "" || $_REQUEST['tgl_lpt'] == "" || $_REQUEST['nama_tk'] == "" || $_REQUEST['nama_perusahaan'] == "" || $_REQUEST['peminta'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_lpt          = $_REQUEST['no_lpt'];
            $tgl_lpt            = $_REQUEST['tgl_lpt'];
            $no_form            = $_REQUEST['no_form'];
            $nama_tk            = $_REQUEST['nama_tk'];
            $nama_perusahaan    = $_REQUEST['nama_perusahaan'];
            $peminta            = $_REQUEST['peminta'];
            $lokasi_pengerjaan  = $_REQUEST['lokasi_pengerjaan'];
            $jenis_pekerjaan    = $_REQUEST['jenis_pekerjaan'];
            $nama_material      = $_REQUEST['nama_material'];
            $pekerjaan          = $_REQUEST['pekerjaan'];
            $lama_kerja         = $_REQUEST['lama_kerja'];
            $catatan            = $_REQUEST['catatan'];
            $id_user            = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $no_lpt)) {
                $_SESSION['no_lpt'] = 'Form No LPT hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $no_form)) {
                    $_SESSION['no_form'] = 'No.Form hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {


                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $tgl_lpt)) {
                        $_SESSION['tgl_lpt'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $nama_tk)) {
                            $_SESSION['nama_tk'] = 'Form Nama Teknisi hanya boleh mengandung karakter huruf dan minus(-)<br/>';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $nama_perusahaan)) {
                                $_SESSION['nama_perusahaan'] = 'Form catatan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-) garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $peminta)) {
                                    $_SESSION['peminta'] = 'Form SIFAT hanya boleh mengandung karakter huruf dan spasi';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $lokasi_pengerjaan)) {
                                        $_SESSION['lokasi_pengerjaan'] = 'Form lokasi pengerjaan hanya boleh mengandung karakter huruf dan spasi';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $jenis_pekerjaan)) {
                                            $_SESSION['jenis_pekerjaan'] = 'Form jenis pekerjaan hanya boleh mengandung karakter huruf dan spasi';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        } else {



                                                //if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $qty)) {
                                                  //  $_SESSION['qty'] = 'Form qty hanya boleh mengandung karakter huruf dan spasi';
                                                   // echo '<script language="javascript">window.history.back();</script>';
                                                //} else {

                                                    if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $satuan)) {
                                                        $_SESSION['satuan'] = 'Form satuan hanya boleh mengandung karakter huruf dan spasi';
                                                        echo '<script language="javascript">window.history.back();</script>';
                                                    } else {

                                                        if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $pekerjaan)) {
                                                            $_SESSION['pekerjaan'] = 'Form pekerjaan hanya boleh mengandung karakter huruf dan spasi';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        } else {

                                                            if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $lama_kerja)) {
                                                                $_SESSION['lama_kerja'] = 'Form lama kerja hanya boleh mengandung karakter huruf dan spasi';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            } else {

                                                                if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $catatan)) {
                                                                    $_SESSION['catatan'] = 'Form catatatn hanya boleh mengandung karakter huruf dan spasi';
                                                                    echo '<script language="javascript">window.history.back();</script>';
                                                                } else {

                                                                            $query = mysqli_query($config, "INSERT INTO tbl_lpt(no_lpt,no_form,tgl_lpt,nama_tk,nama_perusahaan,peminta,lokasi_pengerjaan,jenis_pekerjaan,nama_material,pekerjaan,lama_kerja,catatan,id_surat,id_user)
                                                                            VALUES('$no_lpt','$no_form','$tgl_lpt','$nama_tk','$nama_perusahaan','$peminta','$lokasi_pengerjaan','$jenis_pekerjaan','$nama_material','$pekerjaan','$lama_kerja','$catatan','$id_surat','$id_user')");

                                                                            if ($query == true) {
                                                                                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                                                $last_insert_id=mysqli_insert_id($config);
                                                                                echo '<script language="javascript">
                                                                                        window.location.href="./admin.php?page=tsm&id_lpt=' . $last_insert_id . '";
                                                                                      </script>';
                                                                            } else {
                                                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                                echo '<script language="javascript">window.history.back();</script>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
             
            
        
    } else {
        ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah E-LPT</a></li>
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
                    <!--div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">place</i>
                        <input id="tujuan" type="text" class="validate" name="tujuan" required>
                    <?php
                    if (isset($_SESSION['tujuan'])) {
                        $tujuan = $_SESSION['tujuan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tujuan . '</div>';
                        unset($_SESSION['tujuan']);
                    }
                    ?>
                        <label for="tujuan">Tujuan Disposisi</label>
                    </div>
                    <div class="input-field col s6">
                        
                        <i class="material-icons prefix md-prefix">alarm</i>
                        <input id="batas_waktu" type="text" name="batas_waktu" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['batas_waktu'])) {
                        $batas_waktu = $_SESSION['batas_waktu'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $batas_waktu . '</div>';
                        unset($_SESSION['batas_waktu']);
                    }
                    ?>
                        <label for="batas_waktu">Batas Waktu</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">description</i>
                        <textarea id="isi_disposisi" class="materialize-textarea validate" name="isi_disposisi" required></textarea>
                    <?php
                    if (isset($_SESSION['isi_disposisi'])) {
                        $isi_disposisi = $_SESSION['isi_disposisi'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $isi_disposisi . '</div>';
                        unset($_SESSION['isi_disposisi']);
                    }
                    ?>
                        <label for="isi_disposisi">Isi Disposisi</label>
                    </div-->
                    <!--div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">featured_play_list   </i>
                        <input id="catatan" type="text" class="validate" name="catatan" >
                    <?php
                    if (isset($_SESSION['catatan'])) {
                        $catatan = $_SESSION['catatan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                        unset($_SESSION['catatan']);
                    }
                    ?>
                        <label for="catatan">Catatan</label>
                    </div-->
                </div>
                
                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">looks_one</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_lpt FROM tbl_lpt");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $kode = $result + 1;
                    } else {
                        $kode = 1;
                    }

                    //mulai bikin kode
                    $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $tahun = date('Y-m');
                    $kode_jadi = "LPT/$tahun/$bikin_kode";

                    if (isset($_SESSION['no_lpt'])) {
                        $no_lpt = $_SESSION['no_lpt'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_lpt . '</div>';
                        unset($_SESSION['no_lpt']);
                    }
                    ?>
                    <label for="no_lpt">No.LPT</label>
                    <input type="text" class="form-control" id="no_lpt" name="no_lpt"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_lpt" name="no_lpt"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">note</i>
                    <?php
                    //memulai mengambil datanya
                    $sql = mysqli_query($config, "SELECT no_form FROM tbl_lpt");


                    $result = mysqli_num_rows($sql);

                    if ($result <> 0) {
                        $no_form = $result + 1;
                    } else {
                        $no_form = 1;
                    }

                    //mulai bikin kode
                    $tahun = date('Y');
                    $kode_jadi = "FM.TNK.004";

                    if (isset($_SESSION['no_form'])) {
                        $no_form = $_SESSION['no_form'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_form . '</div>';
                        unset($_SESSION['no_form']);
                    }
                    ?>
                    <label for="no_form">No.Form</label>
                    <input type="text" class="form-control" id="no_form" name="no_form"  value="<?php echo $kode_jadi ?>"disabled>
                    <input type="hidden" class="form-control" id="no_form" name="no_form"  value="<?php echo $kode_jadi ?>" >
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">date_range</i>
                    <input id="tgl_lpt" type="text" name="tgl_lpt" class="datepicker" required>
                    <?php
                    if (isset($_SESSION['tgl_lpt'])) {
                        $tgl_lpt = $_SESSION['tgl_lpt'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_lpt . '</div>';
                        unset($_SESSION['tgl_lpt']);
                    }
                    ?>
                    <label for="tgl_lpt">Tanggal Surat</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">people</i>
                    <input id="nama_tk" type="text" class="validate" name="nama_tk" required>
                    <?php
                    if (isset($_SESSION['nama_tk'])) {
                        $nama_tk = $_SESSION['nama_tk'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_tk . '</div>';
                        unset($_SESSION['nama_tk']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="nama_tk">Nama Teknisi</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">business</i>
                    <input id="nama_perusahaan" type="text" class="validate" name="nama_perusahaan" required>
                    <?php
                    if (isset($_SESSION['nama_perusahaan'])) {
                        $nama_perusahaan = $_SESSION['nama_perusahaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_perusahaan . '</div>';
                        unset($_SESSION['nama_perusahaan']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="nama_perusahaan">Nama Perusahaan</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">account_circle</i>
                    <input id="peminta" type="text" class="validate" name="peminta" required>
                    <?php
                    if (isset($_SESSION['peminta'])) {
                        $peminta = $_SESSION['peminta'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $peminta . '</div>';
                        unset($_SESSION['peminta']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="peminta">Nama Peminta</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">location_on</i>
                    <input id="lokasi_pengerjaan" type="text" class="validate" name="lokasi_pengerjaan" required>
                    <?php
                    if (isset($_SESSION['lokasi_pengerjaan'])) {
                        $lokasi_pengerjaan = $_SESSION['lokasi_pengerjaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lokasi_pengerjaan . '</div>';
                        unset($_SESSION['lokasi_pengerjaan']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="lokasi_pengerjaan">Lokasi Pengerjaan</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">web</i>
                    <input id="jenis_pekerjaan" type="text" class="validate" name="jenis_pekerjaan" required>
                    <?php
                    if (isset($_SESSION['jenis_pekerjaan'])) {
                        $jenis_pekerjaan = $_SESSION['jenis_pekerjaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $jenis_pekerjaan . '</div>';
                        unset($_SESSION['jenis_pekerjaan']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">assignment</i>
                    <input id="nama_material" type="text" class="validate" name="nama_material">
                    <?php
                    if (isset($_SESSION['nama_material'])) {
                        $nama_material = $_SESSION['nama_material'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_material . '</div>';
                        unset($_SESSION['nama_material']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="nama_material">Nama Material</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">build_circle</i>
                    <input id="pekerjaan" type="text" class="validate" name="pekerjaan" required>
                    <?php
                    if (isset($_SESSION['pekerjaan'])) {
                        $pekerjaan = $_SESSION['pekerjaan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pekerjaan . '</div>';
                        unset($_SESSION['pekerjaan']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="pekerjaan">Pekerjaan / Perubahan yang dilakukan</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">timer</i>
                    <input id="lama_kerja" type="text" class="validate" name="lama_kerja" required>
                    <?php
                    if (isset($_SESSION['lama_kerja'])) {
                        $lama_kerja = $_SESSION['lama_kerja'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $lama_kerja . '</div>';
                        unset($_SESSION['lama_kerja']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="lama_kerja">Lama Pengerjaan</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix md-prefix">note_add</i>
                    <input id="catatan" type="text" class="validate" name="catatan">
                    <?php
                    if (isset($_SESSION['catatan'])) {
                        $catatan = $_SESSION['catatan'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                        unset($_SESSION['catatan']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="catatan">Catatan</label>
                </div>
        </div>
        <!-- Row in form END -->

        <div class="row">
            <div class="col 6">
                <button type="submit" name ="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
            </div>
            <div class="col 6">
                <button type="reset" onclick="window.history.back();" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
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
