<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ("") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $nama_supplier = $_POST['nama_supplier'];
            $telp_supplier = $_POST['telp_supplier'];
            $alamat_supplier = $_POST['alamat_supplier'];
            $email_supplier = $_POST['email_supplier'];
            $id_user = $_SESSION['id_user'];

            //jika form file kosong akan mengeksekusi script dibawah ini
            $query = mysqli_query($config, "INSERT INTO master_supplier(nama_supplier,telp_supplier,alamat_supplier,email_supplier,id_user)
                                                                        VALUES('$nama_supplier','$telp_supplier','$alamat_supplier','$email_supplier','$id_user')");

            $id_supplier_add = mysqli_insert_id($config);
            @session_start();
            if (isset($_SESSION["tableDet"])) {
                $tableDet = $_SESSION["tableDet"];
                foreach ($tableDet as $i => $v) {
                    if ($tableDet[$i]["mode_item"] == "N") {
                        $produk = $tableDet[$i]["produk"];
                        $harga_produk = $tableDet[$i]["harga_produk"];
                        $id_supplier = $id_supplier_add;

                        mysqli_query($config, "INSERT INTO master_supplier_detail(produk,harga_produk,id_supplier)
                                                VALUES('$produk','$harga_produk','$id_supplier')");
                    }
                }
            }

            if ($query == true) {
                if (isset($_SESSION["tableDet"])) {
                    unset($_SESSION["tableDet"]);
                }
                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                header("Location: ./admin.php?page=master_supplier");
                die();
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                echo '<script language="javascript">window.history.back();</script>';
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
                            <li class="waves-effect waves-light"><a href="?page=master_supplier&act=add" class="judul"><i class="material-icons">local_grocery_store</i> Tambah Data Supplier</a></li>
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
            <form class="col s12" method="POST" action="?page=master_supplier&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->

                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="white-grey lighten-3" id="head">
                            <tr>

                                <th width="2%">No</th>
                                <th width="15%">Produk</th>
                                <th width="5%">Harga</th>
                                <th width="20%"><span> <a class="btn small red modal-trigger" href="#modal2">
                                            <i class="material-icons">add_circle_outline</i>Tambah Produk</a></span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            @session_start();
                            $no = 0;
                            if (isset($_SESSION["tableDet"])) {
                                $tableDet = $_SESSION["tableDet"];
                                foreach ($tableDet as $i => $v) {
                                    if ($tableDet [$i]["mode_item"] != "D") {
                                        $no++;
                                        echo '<tr>';
                                        echo '<td>' . $no . '</td>';
                                        echo '<td>' . $tableDet[$i]["produk"] . '</td>';
                                        echo '<td>' . $tableDet[$i]["harga_produk"] = "Rp " . number_format((float) $tableDet[$i]['harga_produk'], 0, ',', '.') . '</td>';
                                        echo '<td><center><a href="hapus_item_supplier.php?id=' . $tableDet[$i]["i"] . '" class="btn small btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center></td>';
                                        echo '</tr>';
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" style="text-align: center"><strong>*** JANGAN LUPA ISI DATA PRODUK ***</strong></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>


                        <div id="modal2" class="modal">
                            <div class="modal-content white">
                                <div class="row">
                                    <!-- Secondary Nav START -->
                                    <div class="col s12">
                                        <nav class="secondary-nav">
                                            <div class="nav-wrapper blue-grey darken-1">
                                                <ul class="left">
                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">add_shopping_cart</i> Tambah Data Produk</a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                    <!-- Secondary Nav END -->
                                </div>

                                <div class="row jarak-form">
                                    <form class="col s12" method="post" action="">

                                        <div class="input-field col s11">
                                            <i class="material-icons prefix md-prefix">playlist_add</i>
                                            <input type="text" id="produk" name="produk"  />
                                            <?php
                                            if (isset($_SESSION['produk'])) {
                                                $produk = $_SESSION['produk'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $produk . '</div>';
                                                unset($_SESSION['produk']);
                                            }
                                            ?>
                                            <label for="produk">Produk</label>
                                        </div>

                                        <div class="input-field col s11">
                                            <i class="material-icons prefix md-prefix">attach_money</i>
                                            <input type="text" id="harga_produk" name="harga_produk"  />
                                            <?php
                                            if (isset($_SESSION['harga_produk'])) {
                                                $harga_produk = $_SESSION['harga_produk'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $harga_produk . '</div>';
                                                unset($_SESSION['harga_produk']);
                                            }
                                            ?>
                                            <label for="harga_produk">Harga</label>
                                        </div>
                                </div>

                                <!-- Footer -->
                                <div class="col s12">
                                    <div class="col 6">
                                        <button type="ok" name ="ok" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">offline_pin</i></button>
                                        <?php
                                        if (isset($_REQUEST['ok'])) {

                                            //validasi form kosong
                                            if ("") {
                                                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            } else {

                                                $produk = $_REQUEST['produk'];
                                                $harga_produk = $_REQUEST['harga_produk'];
                                                $id_supplier = $_SESSION['id_supplier'];

                                                @session_start();
                                                if (!isset($_SESSION["tableDet"])) {
                                                    $i = 0;
                                                } else {
                                                    $tableDet = $_SESSION["tableDet"];
                                                    $i = count($tableDet);
                                                }

                                                $tableDet[$i]['produk'] = $produk;
                                                $tableDet[$i]['harga_produk'] = $harga_produk;
                                                $tableDet[$i]["mode_item"] = "N";
                                                $tableDet[$i]["i"] = $i;

                                                $_SESSION["tableDet"] = $tableDet;
                                                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                header("Location: ./admin.php?page=master_supplier&act=add");
                                                die();
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div class="col s6">
                                        <a href="?page=master_supplier&act=add" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        </tr>
                    </table>     
                    <br>
                    <br>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">people</i>
                    <textarea id="nama_supplier" class="materialize-textarea validate" name="nama_supplier"></textarea>
                    <?php
                    if (isset($_SESSION['nama_supplier'])) {
                        $nama_supplier = $_SESSION['nama_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_supplier . '</div>';
                        unset($_SESSION['nama_supplier']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="nama_supplier">Nama</label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">phone</i>
                    <input type="number" id="telp_supplier" name="telp_supplier" />
                    <?php
                    if (isset($_SESSION['telp_supplier'])) {
                        $telp_supplier = $_SESSION['telp_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $telp_supplier . '</div>';
                        unset($_SESSION['telp_supplier']);
                    }
                    ?>
                    <label for="telp_supplier">Telp</label>
                </div>


                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">home</i>
                    <textarea id="alamat_supplier" class="materialize-textarea validate" name="alamat_supplier"></textarea>
                    <?php
                    if (isset($_SESSION['alamat_supplier'])) {
                        $telp_supplier = $_SESSION['alamat_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $alamat_supplier . '</div>';
                        unset($_SESSION['alamat_supplier']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="alamat_supplier">Alamat</label>
                </div>

                <div class="input-field col s8">
                    <i class="material-icons prefix md-prefix">email</i>
                    <textarea id="email_supplier" class="materialize-textarea validate" name="email_supplier"></textarea>
                    <?php
                    if (isset($_SESSION['email_supplier'])) {
                        $email_supplier = $_SESSION['email_supplier'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $email_supplier . '</div>';
                        unset($_SESSION['email_supplier']);
                    }
                    if (isset($_SESSION['errDup'])) {
                        $errDup = $_SESSION['errDup'];
                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                        unset($_SESSION['errDup']);
                    }
                    ?>
                    <label for="email_supplier">Email</label>
                </div>

        </div>
        <!-- Row in form END -->

        <div class="row">
            <div class="col 6">
                <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
            </div>
            <div class="col 6">
                <a href="?page=master_supplier" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
