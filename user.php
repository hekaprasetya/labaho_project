<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Interior Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
          Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>

    <?php
//cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if ($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 4 AND $_SESSION['admin'] != 5 AND $_SESSION['admin'] != 6 AND $_SESSION['admin'] != 7 AND $_SESSION['admin'] != 8 AND $_SESSION['admin'] != 9 AND $_SESSION['admin'] != 10 AND $_SESSION['admin'] != 11 AND $_SESSION['admin'] != 12 AND $_SESSION['admin'] != 13 AND $_SESSION['admin'] != 14 AND $_SESSION['admin'] != 15) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_user_karyawan.php";
                        break;
                    case 'add_tenant':
                        include "tambah_user.php";
                        break;
                    case 'edit':
                        include "edit_tipe_user.php";
                        break;
                    case 'del':
                        include "hapus_user.php";
                        break;
                    case 'upload_ttd':
                        include "upload_user_ttd.php";
                        break;
                    case 'del_upload':
                        include "hapus_user_ttd.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT usr FROM tbl_sett");
                list($usr) = mysqli_fetch_array($query);

                //pagging
                $limit = $usr;
                $pg = @$_GET['pg'];
                if (empty($pg)) {
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }
                ?>

                <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <div class="col m7">
                                    <ul class="left">
                                        <!--li class="waves-effect waves-light hide-on-small-only"><a href="?page=usr&act=add" class="judul"><i class="material-icons md-3">filter_frames</i>Manage Karyawan</a></li-->
                                        <li class="waves-effect waves-light">
                                            <a href="?page=usr&act=add"><i class="material-icons md-3">add_circle</i>Karyawan</a>
                                        </li>
                                        <li class="waves-effect waves-light">
                                            <a href="?page=usr&act=add_tenant"><i class="material-icons md-3">add_circle</i>Tenant</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s4 show-on-med-and-down">
                                    <form method="post" action="?page=usr">
                                    </form>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>

                <!-- Secondary Nav END -->
            </div>
            <div class="z-depth-1">
                <nav class="secondary-nav yellow darken-3">
                    <form method="post" action="?page=usr">
                        <center><div class="input-field round-in-box">
                                <input id="search" type="search" name="cari" placeholder="Searching" required>
                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                <input type="submit" name="submit" class="hidden">
                            </div>
                        </center>
                    </form>
                </nav>
            </div>
            <!-- Row END -->

            <?php
            if (isset($_SESSION['succAdd'])) {
                $succAdd = $_SESSION['succAdd'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succAdd']);
            }
            if (isset($_SESSION['succEdit'])) {
                $succEdit = $_SESSION['succEdit'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succEdit']);
            }
            if (isset($_SESSION['succDel'])) {
                $succDel = $_SESSION['succDel'];
                echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                unset($_SESSION['succDel']);
            }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <?php
                if (isset($_REQUEST['submit'])) {
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                    ?>
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"<?= stripslashes($cari) ?>"</strong><span class="right"><a href="?page=usr"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <?php
                                if ($_SESSION['admin'] != 3) {
                                    ?>
                                <th>No</th>
                                <th>Username<br/><hr/>Nama</th>
                                <th>Jabatan<br/><hr/>Nip</th>
                                <th>Tgl.Gabung<br/><hr/>Kontrak Habis</th>
                                <th>Email<br/><hr/>No.HP</th>
                                <th>Tgl.Lahir<br/><hr/>Tempat Lahir</th>
                                <th>Sisa Cuti<br/><hr/>Divisi</th>
                                <th>Status<br/><hr/>Status Pajak</th>
                                <th>Kategori<br/><hr/>Foto</th>
                                <th>TTD</th>
                                <th>Tindakan <span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                                <?php
                            } else {
                                ?>
                                <th>No</th>
                                <th>Username<br/><hr/>Nama</th>
                                <th>Tgl.Gabung</th>
                                <th>Kategori<br/><hr/>Foto</th>
                                <th>Tindakan <span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                                <?php
                            }
                            ?>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                //script untuk mencari data
                                $query = mysqli_query($config, "SELECT a.*,
                                                                        b.file_ttd

                                                                        FROM tbl_user a
                                                                        LEFT JOIN tbl_user_upload b
                                                                        ON a.id_user=b.id_user 
                                
                                                                WHERE username LIKE '%$cari%' or 
                                                                nama LIKE '%$cari%' or 
                                                                nip LIKE '%$cari%' or 
                                                                divisi LIKE '%$cari%'or 
                                                                jabatan LIKE '%$cari%'or 
                                                                kategori LIKE '%$cari%'or 
                                                                status LIKE '%$cari%'or 
                                                                tmpt_lahir LIKE '%$cari%'
                                                                
                                                                ORDER by id_user DESC");

                                if (mysqli_num_rows($query) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <?php
                                            //GM
                                            if ($_SESSION['admin'] == 7) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <?php
                                                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                           ORDER by username asc LIMIT $curr, $limit");
                                                    if (mysqli_num_rows($query) > 0) {
                                                        $no = 0;
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $no++;
                                                            ?>
                                                        <tr>

                                                            <td><?= $no ?></td>
                                                            <td><?= $row['username'] ?><br />
                                                                <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['nama'])))) ?>
                                                            </td>
                                                            <td><?= $row['jabatan'] ?><br />
                                                                <hr /><?= $row['nip'] ?>
                                                            </td>
                                                            <td>
                                                                <?= indoDate($row['tgl_join']) ?><br />
                                                                <hr />
                                                                <?php
                                                                if ($row['kontrak_habis'] == '0000-00-00') {
                                                                    ?>
                                                                    <em>-</em>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <strong><?= indoDate($row['kontrak_habis']) ?></strong>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $row['email'] ?><br />
                                                                <hr /><?= $row['no_hp'] ?>
                                                            </td>
                                                            <td><?= indoDate($row['tgl_lahir']) ?><br />
                                                                <hr /><?= $row['tmpt_lahir'] ?>
                                                            </td>
                                                            <td><?= $row['sisa_cuti'] ?><br />
                                                                <hr /><?= $row['divisi'] ?>
                                                            </td>
                                                            <td><?= $row['status'] ?><br />
                                                                <hr /><?= $row['status_pajak'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $row['kategori'] ?>
                                                                <br />
                                                                <hr /><?php
                                                                if (!empty($row['file'])) {
                                                                    ?>
                                                                    <strong><a href="/./upload/user/<?= $row['file'] ?>"><img src="/./upload/user/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <em>Tidak ada foto</em>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (!empty($row['file_ttd'])) {
                                                                    ?>
                                                                    <strong><a href="/./upload/ttd/<?= $row['file_ttd'] ?>"><img src="/./upload/ttd/<?= $row['file_ttd'] ?>" style="width: 50px"></a></strong>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <em>TTD Kosong</em>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn small blue waves-effect waves-light tooltipped" data-tooltip="Edit User" href="?page=usr&act=edit&id_user=<?= $row['id_user'] ?>">
                                                                    <i class="material-icons">edit</i></a>
                                                                <a class="btn small deep-orange waves-effect waves-light tooltipped" data-tooltip="Hapus User" href="?page=usr&act=del&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                                <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-tooltip="Upload TTD" href="?page=usr&act=upload_ttd&id_user=<?= $row['id_user'] ?>">
                                                                    <i class="material-icons">file_upload</i></a>
                                                                <a class="btn small deep-green darken-1 waves-effect waves-light tooltipped" data-tooltip="Hapus TTD" href="?page=usr&act=del_upload&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        ?>

                                                        <?php
                                                    }
                                                }
                                            }

                                            //HRD
                                            if ($_SESSION['admin'] == 15) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <?php
                                                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                           WHERE kategori='karyawan'
                                                           ORDER by username asc LIMIT $curr, $limit");

                                                    if (mysqli_num_rows($query) > 0) {
                                                        $no = 0;
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $no++;
                                                            ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $row['username'] ?><br />
                                                                <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['nama'])))) ?>
                                                            </td>
                                                            <td><?= $row['jabatan'] ?><br />
                                                                <hr /><?= $row['nip'] ?>
                                                            </td>
                                                            <td>
                                                                <?= indoDate($row['tgl_join']) ?><br />
                                                                <hr />
                                                                <?php
                                                                if ($row['kontrak_habis'] == '0000-00-00') {
                                                                    ?>
                                                                    <em>-</em>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <strong><?= indoDate($row['kontrak_habis']) ?></strong>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $row['email'] ?><br />
                                                                <hr /><?= $row['no_hp'] ?>
                                                            </td>
                                                            <td><?= indoDate($row['tgl_lahir']) ?><br />
                                                                <hr /><?= $row['tmpt_lahir'] ?>
                                                            </td>
                                                            <td><?= $row['sisa_cuti'] ?><br />
                                                                <hr /><?= $row['divisi'] ?>
                                                            </td>
                                                            <td><?= $row['status'] ?><br />
                                                                <hr /><?= $row['status_pajak'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $row['kategori'] ?>
                                                                <br />
                                                                <hr /><?php
                                                                if (!empty($row['file'])) {
                                                                    ?>
                                                                    <strong><a href="/./upload/user/<?= $row['file'] ?>"><img src="/./upload/user/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <em>Tidak ada foto</em>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (!empty($row['file_ttd'])) {
                                                                    ?>
                                                                    <strong><a href="/./upload/ttd/<?= $row['file_ttd'] ?>"><img src="/./upload/ttd/<?= $row['file_ttd'] ?>" style="width: 50px"></a></strong>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <em>TTD Kosong</em>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn small blue waves-effect waves-light tooltipped" data-tooltip="Edit User" href="?page=usr&act=edit&id_user=<?= $row['id_user'] ?>">
                                                                    <i class="material-icons">edit</i></a>
                                                                <a class="btn small deep-orange waves-effect waves-light tooltipped" data-tooltip="Hapus User" href="?page=usr&act=del&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                                <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-tooltip="Upload TTD" href="?page=usr&act=upload_ttd&id_user=<?= $row['id_user'] ?>">
                                                                    <i class="material-icons">file_upload</i></a>
                                                                <a class="btn small deep-green darken-1 waves-effect waves-light tooltipped" data-tooltip="Hapus TTD" href="?page=usr&act=del_upload&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                            </td>
                                                        <?php } ?>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                            }

                                            //TENANT RELATION
                                            if ($_SESSION['admin'] == 3) {
                                                if ($_SESSION['admin']) {
                                                    ?>
                                                    <?php
                                                    $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                           WHERE kategori='tenant'or 'os'
                                                           ORDER by username asc LIMIT $curr, $limit");
                                                    if (mysqli_num_rows($query) > 0) {
                                                        $no = 0;
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $no++;
                                                            ?>
                                                        <tr>
                                                            <td><center><?= $no ?></center></td>
                                                    <td><center><?= $row['username'] ?><br />
                                                        <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['nama'])))) ?>
                                                    </center>
                                                    </td>
                                                    <td><center><?= indoDate($row['tgl_join']) ?></center><br />
                                                    </td>
                                                    <td>
                                                    <center>
                                                        <?php
                                                        if (!empty($row['file'])) {
                                                            ?>
                                                            <strong><a href="/./upload/user/<?= $row['file'] ?>"><img class="circle" src="/./upload/user/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <em>Tidak ada foto</em>
                                                        <?php }
                                                        ?>
                                                    </center>
                                                    </td>
                                                    <td>
                                                    <center>
                                                        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-tooltip="Hapus User" href="?page=usr&act=del&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                    </center>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=usr&act=add">Tambah data baru</a></u></p></center></td></tr>
                                <?php
                            }
                            ?></tbody></table>
                    </div>
                </div>
                <!-- Row form END -->
                <?php
            } else {
                ?>
                <div class="col m12" id="colres">
                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <?php
                                if ($_SESSION['admin'] != 3) {
                                    ?>
                                    <th>No</th>
                                    <th>Username<br/><hr/>Nama</th>
                            <th>Jabatan<br/><hr/>Nip</th>
                            <th>Tgl.Gabung<br/><hr/>Kontrak Habis</th>
                            <th>Email<br/><hr/>No.HP</th>
                            <th>Tgl.Lahir<br/><hr/>Tempat Lahir</th>
                            <th>Sisa Cuti<br/><hr/>Divisi</th>
                            <th>Status<br/><hr/>Status Pajak</th>
                            <th>Kategori<br/><hr/>Foto</th>
                            <th>TTD</th>
                            <th>Tindakan <span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                            <?php
                        } else {
                            ?>
                            <th>No</th>
                            <th>Username<br/><hr/>Nama</th>
                            <th>Tgl.Gabung</th>
                            <th>Kategori<br/><hr/>Foto</th>
                            <th>Tindakan <span class = "right tooltipped" data-position = "left" data-tooltip = "Atur jumlah data yang ditampilkan"><a class = "modal-trigger" href = "#modal"><i class = "material-icons" style = "color: #333;">settings</i></a></span></th>
                            <?php
                        }
                        ?>
                        <div id="modal" class="modal">
                            <div class="modal-content white">
                                <h5>Jumlah data yang ditampilkan per halaman</h5>
                                <?php
                                $query = mysqli_query($config, "SELECT id_sett,usr FROM tbl_sett");
                                list($id_sett, $usr) = mysqli_fetch_array($query)
                                ?>
                                <div class="row">
                                    <form method="post" action="">
                                        <div class="input-field col s12">
                                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                                            <div class="input-field col s1" style="float: left;">
                                                <i class="material-icons prefix md-prefix">looks_one</i>
                                            </div>
                                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                <select class="browser-default validate" name="usr" required>
                                                    <option value="<?= $usr ?>"><?= $usr ?></option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer white">
                                                <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>
                                                <?php
                                                if (isset($_REQUEST['simpan'])) {
                                                    $id_sett = "1";
                                                    $usr = $_REQUEST['usr'];
                                                    $id_user = $_SESSION['id_user'];

                                                    $query = mysqli_query($config, "UPDATE tbl_sett SET usr='$usr',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                    if ($query == true) {
                                                        header("Location: ./admin.php?page=usr");
                                                        die();
                                                    }
                                                }
                                                ?>
                                                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                            //script untuk menampilkan data
                            $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                          ORDER by username asc LIMIT $curr, $limit");

                            if (mysqli_num_rows($query) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <?php
                                        //GM
                                        if ($_SESSION['admin'] == 7) {
                                            if ($_SESSION['admin']) {
                                                ?>
                                                <?php
                                                $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                           ORDER by username asc LIMIT $curr, $limit");
                                                if (mysqli_num_rows($query) > 0) {
                                                    $no = 0;
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $no++;
                                                        ?>
                                                    <tr>

                                                        <td><?= $no ?></td>
                                                        <td><?= $row['username'] ?><br />
                                                            <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['nama'])))) ?>
                                                        </td>
                                                        <td><?= $row['jabatan'] ?><br />
                                                            <hr /><?= $row['nip'] ?>
                                                        </td>
                                                        <td>
                                                            <?= indoDate($row['tgl_join']) ?><br />
                                                            <hr />
                                                            <?php
                                                            if ($row['kontrak_habis'] == '0000-00-00') {
                                                                ?>
                                                                <em>-</em>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <strong><?= indoDate($row['kontrak_habis']) ?></strong>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $row['email'] ?><br />
                                                            <hr /><?= $row['no_hp'] ?>
                                                        </td>
                                                        <td><?= indoDate($row['tgl_lahir']) ?><br />
                                                            <hr /><?= $row['tmpt_lahir'] ?>
                                                        </td>
                                                        <td><?= $row['sisa_cuti'] ?><br />
                                                            <hr /><?= $row['divisi'] ?>
                                                        </td>
                                                        <td><?= $row['status'] ?><br />
                                                            <hr /><?= $row['status_pajak'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['kategori'] ?>
                                                            <br />
                                                            <hr /><?php
                                                            if (!empty($row['file'])) {
                                                                ?>
                                                                <strong><a href="/./upload/user/<?= $row['file'] ?>"><img src="/./upload/user/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <em>Tidak ada foto</em>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (!empty($row['file_ttd'])) {
                                                                ?>
                                                                <strong><a href="/./upload/ttd/<?= $row['file_ttd'] ?>"><img src="/./upload/ttd/<?= $row['file_ttd'] ?>" style="width: 50px"></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <em>TTD Kosong</em>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a class="btn small blue waves-effect waves-light tooltipped" data-tooltip="Edit User" href="?page=usr&act=edit&id_user=<?= $row['id_user'] ?>">
                                                                <i class="material-icons">edit</i></a>
                                                            <a class="btn small deep-orange waves-effect waves-light tooltipped" data-tooltip="Hapus User" href="?page=usr&act=del&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                            <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-tooltip="Upload TTD" href="?page=usr&act=upload_ttd&id_user=<?= $row['id_user'] ?>">
                                                                <i class="material-icons">file_upload</i></a>
                                                            <a class="btn small deep-green darken-1 waves-effect waves-light tooltipped" data-tooltip="Hapus TTD" href="?page=usr&act=del_upload&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                }
                                            }
                                        }

                                        //HRD
                                        if ($_SESSION['admin'] == 15) {
                                            if ($_SESSION['admin']) {
                                                ?>
                                                <?php
                                                $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                           WHERE kategori='karyawan'
                                                           ORDER by username asc LIMIT $curr, $limit");

                                                if (mysqli_num_rows($query) > 0) {
                                                    $no = 0;
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $no++;
                                                        ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= $row['username'] ?><br />
                                                            <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['nama'])))) ?>
                                                        </td>
                                                        <td><?= $row['jabatan'] ?><br />
                                                            <hr /><?= $row['nip'] ?>
                                                        </td>
                                                        <td>
                                                            <?= indoDate($row['tgl_join']) ?><br />
                                                            <hr />
                                                            <?php
                                                            if ($row['kontrak_habis'] == '0000-00-00') {
                                                                ?>
                                                                <em>-</em>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <strong><?= indoDate($row['kontrak_habis']) ?></strong>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $row['email'] ?><br />
                                                            <hr /><?= $row['no_hp'] ?>
                                                        </td>
                                                        <td><?= indoDate($row['tgl_lahir']) ?><br />
                                                            <hr /><?= $row['tmpt_lahir'] ?>
                                                        </td>
                                                        <td><?= $row['sisa_cuti'] ?><br />
                                                            <hr /><?= $row['divisi'] ?>
                                                        </td>
                                                        <td><?= $row['status'] ?><br />
                                                            <hr /><?= $row['status_pajak'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['kategori'] ?>
                                                            <br />
                                                            <hr /><?php
                                                            if (!empty($row['file'])) {
                                                                ?>
                                                                <strong><a href="/./upload/user/<?= $row['file'] ?>"><img src="/./upload/user/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <em>Tidak ada foto</em>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (!empty($row['file_ttd'])) {
                                                                ?>
                                                                <strong><a href="/./upload/ttd/<?= $row['file_ttd'] ?>"><img src="/./upload/ttd/<?= $row['file_ttd'] ?>" style="width: 50px"></a></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <em>TTD Kosong</em>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a class="btn small blue waves-effect waves-light tooltipped" data-tooltip="Edit User" href="?page=usr&act=edit&id_user=<?= $row['id_user'] ?>">
                                                                <i class="material-icons">edit</i></a>
                                                            <a class="btn small deep-orange waves-effect waves-light tooltipped" data-tooltip="Hapus User" href="?page=usr&act=del&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                            <a class="btn small green darken-3 waves-effect waves-light tooltipped" data-tooltip="Upload TTD" href="?page=usr&act=upload_ttd&id_user=<?= $row['id_user'] ?>">
                                                                <i class="material-icons">file_upload</i></a>
                                                            <a class="btn small deep-green darken-1 waves-effect waves-light tooltipped" data-tooltip="Hapus TTD" href="?page=usr&act=del_upload&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                        </td>
                                                    <?php } ?>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                        }

                                        //TENANT RELATION
                                        if ($_SESSION['admin'] == 3) {
                                            if ($_SESSION['admin']) {
                                                ?>
                                                <?php
                                                //script untuk menampilkan data

                                                $query = mysqli_query($config, "SELECT a.*,
                                                           b.file_ttd
                                                           
                                                           FROM tbl_user a
                                                           LEFT JOIN tbl_user_upload b
                                                           ON a.id_user=b.id_user 
                                                           
                                                           WHERE kategori='tenant'or 'os'
                                                           ORDER by username asc LIMIT $curr, $limit");
                                                if (mysqli_num_rows($query) > 0) {
                                                    $no = 0;
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $no++;
                                                        ?>
                                                    <tr>
                                                        <td><center><?= $no ?></center></td>
                                                <td><center><?= $row['username'] ?><br />
                                                    <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['nama'])))) ?>
                                                </center>
                                                </td>
                                                <td><center><?= indoDate($row['tgl_join']) ?></center><br />
                                                </td>
                                                <td>
                                                <center>
                                                    <?php
                                                    if (!empty($row['file'])) {
                                                        ?>
                                                        <strong><a href="/./upload/user/<?= $row['file'] ?>"><img class="circle" src="/./upload/user/<?= $row['file'] ?>" style="width: 50px"></a></strong>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <em>Tidak ada foto</em>
                                                    <?php }
                                                    ?>
                                                </center>
                                                </td>
                                                <td>
                                                <center>
                                                    <a class="btn small deep-orange waves-effect waves-light tooltipped" data-tooltip="Hapus User" href="?page=usr&act=del&id_user=<?= $row['id_user'] ?>"><i class="material-icons">delete</i></a>
                                                </center>
                                                </td>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                </td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=usr&act=add">Tambah data baru</a></u></p></center></td></tr>
                                    <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                </div>

                <!-- Row form END -->
                <?php
                $query = mysqli_query($config, "SELECT * FROM tbl_user");
                $cdata = mysqli_num_rows($query);
                $cpg = ceil($cdata / $limit);

                echo '<br/><!-- Pagination START -->
            <ul class="pagination">';
            
                            if ($cdata > $limit) {
            
            //first and previous pagging
                                if ($pg > 1) {
                                    $prev = $pg - 1;
                                    echo '<li><a href="?page=usr&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                <li><a href="?page=usr&pg=' . $prev . '"><i class="material-icons md-48">chevron_left</i></a></li>';
                                } else {
                                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                                }
            
            //perulangan pagging
                                for ($i = 1; $i <= $cpg; $i++) {
                                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                        if ($i == $pg)
                                            echo '<li class="active waves-effect waves-dark"><a href="?page=usr&pg=' . $i . '"> ' . $i . ' </a></li>';
                                        else
                                            echo '<li class="waves-effect waves-dark"><a href="?page=usr&pg=' . $i . '"> ' . $i . ' </a></li>';
                                    }
                                }
            
            //last and next pagging
                                if ($pg < $cpg) {
                                    $next = $pg + 1;
                                    echo '<li><a href="?page=usr&pg=' . $next . '"><i class="material-icons md-48">chevron_right</i></a></li>
                <li><a href="?page=usr&pg=' . $cpg . '"><i class="material-icons md-48">last_page</i></a></li>';
                                } else {
                                    echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                                }
                                echo '
            </ul>';
                            } else {
                                echo '';
                            }
                        }
                    }
                }
            }
            ?>
