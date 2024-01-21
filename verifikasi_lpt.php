<?php

//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['sub'])) {
        $sub = $_REQUEST['sub'];
        switch ($sub) {
            case 'add':
                include "tambah_verifikasi_lpt.php";
                break;
            case 'edit':
                include "edit_verifikasi_lpt.php";
                break;
            case 'del':
                include "hapus_verifikasi_lpt.php";
                break;
        }
    } else {

        //pagging
        $limit = 5;
        $pg = @$_GET['pg'];
        if (empty($pg)) {
            $curr = 0;
            $pg = 1;
        } else {
            $curr = ($pg - 1) * $limit;
        }

        $id_lpt = $_REQUEST['id_lpt'];

        $query = mysqli_query($config, "SELECT * FROM tbl_lpt WHERE id_lpt='$id_lpt'");

        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {

                if ($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] == 1) {
                    echo '<script language="javascript">
                                window.alert("ERROR! Anda tidak memiliki hak akses untuk melihat data ini");
                                window.location.href="./admin.php?page=lpt";
                              </script>';
                } else {

                    echo '<!-- Row Start -->
                            <div class="row">
                                <!-- Secondary Nav START -->
                                <div class="col s12">
                                    <div class="z-depth-1">
                                        <nav class="secondary-nav">
                                            <div class="nav-wrapper blue-grey darken-1">
                                                <div class="col m12">
                                                    <ul class="left">
                                                        <li class="waves-effect waves-light hide-on-small-only"><a href="#" class="judul"><i class="material-icons">description</i>Verifikasi LPT</a></li>
                                                        <li class="waves-effect waves-light">
                                                            <a href="?page=lpt&act=verifikasi&id_lpt=' . $row['id_lpt'] . '&sub=add"><i class="material-icons md-24">add_circle</i> Tambah Verifikasi LPT</a>
                                                        </li>
                                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=lpt"><i class="material-icons">arrow_back</i> Kembali</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <!-- Secondary Nav END -->
                            </div>
                            <!-- Row END -->

                            <!-- Perihal START -->
                            <div class="col s12">
                                <div class="card blue lighten-5">
                                    <div class="card-content">
                                        <p><p class="description">Jenis Pekerjaan :</p>' . $row['jenis_pekerjaan'] . '</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Perihal END -->';

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

                    echo '
                            <!-- Row form Start -->
                            <div class="row jarak-form">

                                <div class="col m12" id="colres">
                                    <table class="bordered" id="tbl">
                                        <thead class="blue lighten-4" id="head">
                                            <tr>
                                                <th width="6%">No</th>
                                                <th width="24%">Nama Verifikator</th>
                                                <th width="24%">Tgl.Verifikasi</th>
                                                <th width="16%">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                    $query2 = mysqli_query($config, "SELECT * FROM tbl_verifikasi_lpt JOIN tbl_lpt ON tbl_verifikasi_lpt.id_lpt = tbl_lpt.id_lpt WHERE tbl_verifikasi_lpt.id_lpt='$id_lpt'");


                    
                    if (mysqli_num_rows($query2) > 0) {
                        $no = 0;
                        while ($row = mysqli_fetch_array($query2)) {
                            $no++;
                            echo '
                                                <tr>
                                                    <td>' . $no . '</td>
                                                    <td>' . $row['nama_verifikator'] . '</td>
                                                    <td>' . indoDate($row['tgl_verifikasi']) . '<br/>' . '</td>
                                                        
                                                    <td><a class="btn small blue waves-effect waves-light" href="?page=lpt&act=verifikasi&id_lpt=' . $id_lpt . '&sub=edit&id_verifikasi=' . $row['id_verifikasi'] . '">
                                                            <i class="material-icons">edit</i> EDIT</a>
                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=lpt&act=verifikasi&id_lpt=' . $id_lpt . '&sub=del&id_verifikasi=' . $row['id_verifikasi'] . '"><i class="material-icons">delete</i> DEL</a>
                                                    </td>
                                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=lpt&act=verifikasi&id_lpt=' . $row['id_lpt'] . '&sub=add">Tambah data baru</a></u></p></center></td></tr>';
                    }
                    echo '</tbody></table>
                                </div>
                            </div>
                            <!-- Row form END -->';
                }
            }
        }
    }
}
?>
