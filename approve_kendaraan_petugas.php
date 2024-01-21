<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submita'])) {
        $id_pinjam_kendaraan = $_REQUEST['id_pinjam_kendaraan'];
        $status_kendaraan_petugas = $_REQUEST['status_kendaraan_petugas']; // Mengganti 'kabag' menjadi 'petugas'
        $id_user = $_SESSION['id_user'];

        // Periksa apakah data sudah ada dalam tabel tbl_approve_kendaraan_petugas
        if ($status_kendaraan_petugas === 'Diketahui') {
            // Perbarui status_kendaraan_petugas di tbl_approve_kendaraan_petugas
            $cek_data_query = mysqli_query($config, "SELECT * FROM tbl_approve_kendaraan_petugas WHERE id_pinjam_kendaraan='$id_pinjam_kendaraan'");
            $cek_data = mysqli_num_rows($cek_data_query);
            $cek_data_row = mysqli_fetch_array($cek_data_query);

            if ($cek_data == 0) {
                $query = mysqli_query($config, "INSERT INTO tbl_approve_kendaraan_petugas(status_kendaraan_petugas, id_pinjam_kendaraan, id_user)
                                            VALUES('$status_kendaraan_petugas', '$id_pinjam_kendaraan', '$id_user')");
            } else {
                $query = mysqli_query($config, "UPDATE tbl_approve_kendaraan_petugas SET
                    status_kendaraan_petugas='$status_kendaraan_petugas', id_pinjam_kendaraan='$id_pinjam_kendaraan', id_user='$id_user' WHERE id_app_kendaraan_petugas=$cek_data_row[id_app_kendaraan_petugas]");
            }
        } else {
            // Tangani kasus saat status adalah "Ditolak" (Anda dapat menambahkan logika khusus di sini jika diperlukan)
        }

        // Alihkan ke halaman yang sesuai
        echo '<script language="javascript">
                window.location.href="./admin.php?page=pinjam_kendaraan";
              </script>';
    } else {
        // Pagination
        $limit = 5;
        $pg = @$_GET['pg'];
        if (empty($pg)) {
            $curr = 0;
            $pg = 1;
        } else {
            $curr = ($pg - 1) * $limit;
        }

        $id_pinjam_kendaraan = $_REQUEST['id_pinjam_kendaraan'];





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
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pinjam_kendaraan"><i class="material-icons">arrow_back</i> Kembali</a></li>
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
                            <th width="10%">No.Form</th>
                            <th width="10%">Tanggal</th>
                            <th width="20%">Nama Peminta</th>
                            <th width="15%">Jabatan</th>
                            <th width="25%">Tujuan</th>
                            <th width="15%">Kendaraan</th>
                            <!-- <th width="10%">Tindakan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = mysqli_query($config, "SELECT a.*,
                        b.id_app_kendaraan_petugas,status_kendaraan_petugas,
                        c.nama 
                        FROM pinjam_kendaraan a
                        LEFT JOIN tbl_approve_kendaraan_petugas b
                        ON a.id_pinjam_kendaraan=b.id_pinjam_kendaraan
                        LEFT JOIN tbl_user c
                        ON a.id_user=c.id_user
                        
                        WHERE a.id_pinjam_kendaraan='$id_pinjam_kendaraan'");


                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['no_form'] ?></td>
                                    <td><?= indoDate($row['tgl']); ?></td>
                                    <td><?= $row['nama_kendaraan'] ?></td>
                                    <td><?= $row['jabatan_kendaraan']; ?></td>
                                    <td><?= $row['tujuan']; ?></td>
                                    <td><?= $row['kendaraan']; ?></td>

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
                <a class="btn small modal-trigger waves-effect waves-light tooltipped" data-position="right" data-tooltip="Klik Approve" href="#modal2<?= $id_pinjam_kendaraan ?>">APPROVE</a>
                <div id="modal2<?= $id_pinjam_kendaraan ?>" class="modal">
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
                                    <input type="number" class="hidden" id="id_pinjam_kendaraan" name="id_pinjam_kendaraan" value="<?= $_REQUEST['id_pinjam_kendaraan']; ?>">
                                    <select name="status_kendaraan_petugas" class="browser-default validate" id="status_kendaraan_petugas" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Diketahui">Diterima</option>
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