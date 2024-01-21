<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_SESSION['errQ'])) {
        $errQ = $_SESSION['errQ'];
        echo '<div id="alert-message" class="row jarak-card">
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

    $id_lpg = mysqli_real_escape_string($config, $_REQUEST['id_lpg']);

    $query = mysqli_query($config, "SELECT * FROM tbl_lpg WHERE id_lpg='$id_lpg'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {
            ?>

            <!-- Row form Start -->
            <div class="row jarak-card">
                <div class="col m12">
                    <div class="card">
                        <div class="card-content">
                            <table>
                                <thead class="red lighten-5 red-text">
                                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
                                    Apakah Anda yakin akan menghapus data ini?</div>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td width="13%">No.LPG</td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['no_lpg'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Tgl.LPG</td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= date('d M Y', strtotime($row['tgl_lpg'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Pekerjaan </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['pekerjaan_lpg'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-action">
                            <a href="?page=lpg_gudang&sub=del&submit=yes&id_lpg= <?= $row['id_lpg'] ?>" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                            <a href="./admin.php?page=lpg_gudang" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row form END -->

            <?php
            if (isset($_REQUEST['submit'])) {
                $id_lpg = $_REQUEST['id_lpg'];

                $query = mysqli_query($config, "DELETE FROM tbl_lpg WHERE id_lpg='$id_lpg'");

                if ($query == true) {
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=lpg_gudang";
                          </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                              window.location.href="./admin.php?page=lpg_gudang";
                         </script>';
                }
            }
        }
    }
}
?>
