<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        $id_cuti = $_REQUEST['id_cuti'];
        $status_cuti_kabag = $_POST['status_cuti_kabag'];
        $id_user = $_SESSION['id_user'];

        // Ambil jumlah_trm untuk id_cuti saat ini
        $jumlah_trm_query = mysqli_query($config, "SELECT jumlah_trm FROM tbl_approve_cuti_kabag WHERE id_cuti='$id_cuti'");
        $jumlah_trm_row = mysqli_fetch_assoc($jumlah_trm_query);
        $jumlah_trm = $jumlah_trm_row['jumlah_trm'];

        // Ambil user_peminta berdasarkan id_cuti
        $user_peminta_query = mysqli_query($config, "SELECT user_peminta FROM tbl_approve_cuti_kabag WHERE id_cuti = '$id_cuti'");
        $user_peminta_row = mysqli_fetch_assoc($user_peminta_query);
        $user_peminta = $user_peminta_row['user_peminta'];

        // Periksa apakah status adalah "Diterima" sebelum mengupdate sisa_cuti
        if ($status_cuti_kabag === 'Diterima') {
            // Perbarui status_cuti_kabag di tbl_approve_cuti_kabag
            $cek_data_query = mysqli_query($config, "SELECT * FROM tbl_approve_cuti_kabag WHERE id_cuti='$id_cuti'");
            $cek_data = mysqli_num_rows($cek_data_query);
            $cek_data_row = mysqli_fetch_array($cek_data_query);
            $id_user_peminta = 'id';

            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_cuti_kabag(status_cuti_kabag, jumlah_trm, id_cuti, id_user, user_peminta)
                                            VALUES('$status_cuti_kabag', '$jumlah_trm', '$id_cuti', '$id_user', '$user_peminta')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_cuti_kabag SET
                status_cuti_kabag='$status_cuti_kabag',
                jumlah_trm='$jumlah_trm',
                id_cuti='$id_cuti', id_user='$id_user', user_peminta='$user_peminta' WHERE id_app_cuti_kabag=$cek_data_row[id_app_cuti_kabag]");
            }

            if ($query) {
                // Update kolom sisa_cuti dalam tabel tbl_user
                $update_sisa_cuti_query = mysqli_query($config, "UPDATE tbl_user SET sisa_cuti = sisa_cuti - $jumlah_trm WHERE id_user='$user_peminta'");
                if ($update_sisa_cuti_query) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query UPDATE sisa_cuti';
                }
            } else {
                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query INSERT/UPDATE';
            }
        } else {
            // Tangani kasus saat status adalah "Ditolak" (Anda dapat menambahkan logika khusus di sini jika diperlukan)
        }

        // Alihkan ke halaman yang sesuai
        echo '<script language="javascript">
                window.location.href="./admin.php?page=cuti";
              </script>';
    } else {
        // Pagination
        $limit = 5;
        $pg = isset($_GET['pg']) ? $_GET['pg'] : 1;
        if (empty($pg)) {
            $curr = 0;
            $pg = 1;
        } else {
            $curr = ($pg - 1) * $limit;
        }


        $id_cuti = $_REQUEST['id_cuti'];





        if (isset($_REQUEST['submit'])) {
            $id_cuti = $_REQUEST['id_cuti'];
            $jumlah_trm = $_POST['jumlah_trm'];
            $id_user = $_SESSION['id_user'];
            $user_peminta = $_REQUEST['user_peminta'];

            // Mendapatkan user_peminta dari tabel tbl_cuti berdasarkan id_user


            // Memeriksa apakah terdapat catatan yang ada untuk "id_cuti" yang diberikan
            $existing_record_query = mysqli_query($config, "SELECT * FROM tbl_approve_cuti_kabag WHERE id_cuti='$id_cuti'");
            $existing_record = mysqli_fetch_assoc($existing_record_query);

            if (!$existing_record) {
                // Jika tidak ada catatan yang ada, masukkan catatan baru
                $insert_query = mysqli_query($config, "INSERT INTO tbl_approve_cuti_kabag(jumlah_trm,user_peminta, id_cuti, id_user)
                                            VALUES('$jumlah_trm', '$user_peminta', '$id_cuti', '$id_user')");
                if ($insert_query) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query INSERT';
                }
            } else {
                // Jika catatan yang ada ditemukan, perbarui kolom "jumlah_trm"
                $id_app_cuti_kabag = $existing_record['id_app_cuti_kabag'];
                $update_query = mysqli_query($config, "UPDATE tbl_approve_cuti_kabag SET jumlah_trm='$jumlah_trm' WHERE id_app_cuti_kabag='$id_app_cuti_kabag'");
                if ($update_query) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil diperbarui';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query UPDATE';
                }
            }

            // Alihkan ke halaman yang sesuai
            header("Location: ./admin.php?page=cuti&act=app_kabag_cuti&id_cuti=$id_cuti");
            exit;
        } else {
            // Pagination
            $limit = 5;
            $pg = isset($_GET['pg']) ? $_GET['pg'] : 1;
            $curr = ($pg - 1) * $limit;

            $id_cuti = isset($_REQUEST['id_cuti']) ? $_REQUEST['id_cuti'] : null;
        }





?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <div class="z-depth-1">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <div class="col m12">
                                <ul class="left">
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="#" class="judul"><i class="material-icons">description</i>Approval</a></li>
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=cuti"><i class="material-icons">arrow_back</i> Kembali</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <?php
            if (isset($_SESSION['succAdd'])) {
                $succAdd = $_SESSION['succAdd'];
            ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succAdd ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                unset($_SESSION['succAdd']);
            }
            if (isset($_SESSION['succEdit'])) {
                $succEdit = $_SESSION['succEdit'];
            ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succEdit ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                unset($_SESSION['succEdit']);
            }
            if (isset($_SESSION['succDel'])) {
                $succDel = $_SESSION['succDel'];
            ?>
                <div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succDel ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                unset($_SESSION['succDel']);
            }
            ?>
        </div>
        <!-- Row END -->

        <!-- Perihal START -->

        <div class="row jarak-form">
            <div class="col m12" id="colres">
                <table class="bordered  centered highlight" id="tbl">
                    <thead class="blue lighten-4" id="head">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No.Form<br />
                                <hr />Tanggal
                            </th>
                            <th width="20%">Nama<br />
                                <hr />Jabatan
                            </th>
                            <th width="15%">No.Telp<br />
                                <hr />Sisa Cuti
                            </th>
                            <th width="10%">Tgl.Cuti<br />
                                <hr />Akhir Cuti
                            </th>
                            <th width="10%">Jumlah Hari<br />
                                <hr />Di Setujui
                            </th>
                            <th width="10%">Tindakan</th>

                            <!-- <th width="10%">Tindakan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = mysqli_query($config, "SELECT a.*,
                            b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                            c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                            d.nama,jabatan,no_hp,sisa_cuti 
                            FROM tbl_cuti a
                            LEFT JOIN tbl_approve_cuti_kabag b
                            ON a.id_cuti=b.id_cuti
                            LEFT JOIN tbl_approve_cuti_hrd c 
                            ON a.id_cuti=c.id_cuti
                            LEFT JOIN tbl_user d
                            ON a.id_user=d.id_user
                            
                            WHERE a.id_cuti='$id_cuti'");


                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><strong><?= $row['no_form'] ?></strong><br />
                                        <hr /><?= indoDate(date('Y-m-d')) ?>
                                    </td>
                                    <td><?= $row['nama'] ?><br />
                                        <hr /><?= $row['jabatan'] ?>
                                    </td>
                                    <td><?= $row['no_hp'] ?><br />
                                        <hr /><?= $row['sisa_cuti'] ?>
                                    </td>
                                    <td><?= $row['tgl_cuti'] ?><br />
                                        <hr /><?= $row['akhir_cuti'] ?>
                                    </td>
                                    <td><?= $row['jumlah_hari'] ?><br />
                                        <hr /><?= $row['jumlah_trm'] ?>
                                    </td>
                                    <td><a class="btn small modal-trigger" href="#modal<?= $no ?>">APP HARI</i></a></span>

                                        <div id="modal<?= $no ?>" class="modal">
                                            <div class="modal-content white-grey">
                                                <div class="row">
                                                    <!-- Secondary Nav START -->
                                                    <div class="col s12">
                                                        <nav class="secondary-nav">
                                                            <div class="nav-wrapper blue darken-2">
                                                                <ul class="left">
                                                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i>Tambah Jumlah Hari</a></li>
                                                                </ul>
                                                            </div>
                                                        </nav>
                                                    </div>
                                                    <!-- Secondary Nav END -->
                                                </div>
                                                <div class="row jarak-form">
                                                    <form class="col s12" method="post" action="">
                                                        <div class="input-field col s12">
                                                            <input type="hidden" name="id_app_cuti_kabag" value="<?php echo $id_app_cuti_kabag; ?>">
                                                            <i class="material-icons prefix md-prefix">edit</i>
                                                            <label class="active" for="jumlah_trm"><i style=font-size:13px;>Jumlah Hari yang disetujui</i></label>
                                                            <input id="jumlah_trm" type="number" class="validate " name="jumlah_trm" value="<?= $row['jumlah_hari']; ?>">
                                                            <input id="user_peminta" type="number" class="hidden " name="user_peminta" value="<?= $row['id_user']; ?>">
                                                            <button type="submit" name="submit" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <center>
                                        <p class="add">Tidak ada data untuk ditampilkan.</p>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <br>
                <a class="btn small modal-trigger" href="#modal2<?= $id_cuti ?>">TERBIT</a></span>
                <div id="modal2<?= $id_cuti ?>" class="modal">
                    <div class="modal-content white">
                        <div class="row">
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue darken-2">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i>Approve</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <!-- Secondary Nav END -->
                        </div>

                        <div class="row jarak-form">
                            <form class="col s12" method="post" action="">
                                <div class="input-field col s9">
                                    <i class="material-icons prefix md-prefix">low_priority</i><label>Status</label><br />
                                    <input type="hidden" id="id_cuti_detail" name="id_cuti_detail" value="<?= $row['id_cuti_detail'] ?>" />
                                    <select name="status_cuti_kabag" class="browser-default validate" id="status_cuti_kabag" required>
                                        <option value="" disabled selected></option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                        <option value="Batal">Batal</option>
                                    </select>
                                    <br>
                                    <button type="submit" name="submita" class="btn small blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                </div>

                                <!--div class="col 6">
                            <button type="reset" onclick= window.location.href="./admin.php?page=pp&act=app_gm_pp&id_pp=' . $row['id_barang_detail'] . '"; class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                        </div-->
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_SESSION['succAdd'])) {
                    $succAdd = $_SESSION['succAdd'];
                ?>
                    <div id="alert-message" class="row">
                        <div class="col m12">
                            <div class="card green lighten-5">
                                <div class="card-content notif">
                                    <span class="card-title green-text"><i class="material-icons md-36">done</i><?= $succAdd ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['succAdd']);
                }
                if (isset($_SESSION['succEdit'])) {
                    $succEdit = $_SESSION['succEdit'];
                ?>
                    <div id="alert-message" class="row">
                        <div class="col m12">
                            <div class="card green lighten-5">
                                <div class="card-content notif">
                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> <?= $succEdit ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['succEdit']);
                }
                if (isset($_SESSION['succDel'])) {
                    $succDel = $_SESSION['succDel'];
                ?>
                    <div id="alert-message" class="row">
                        <div class="col m12">
                            <div class="card green lighten-5">
                                <div class="card-content notif">
                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> <?= $succDel ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                    unset($_SESSION['succDel']);
                }
            }
        }

        ?>