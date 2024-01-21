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

    $id_invoice = mysqli_real_escape_string($config, $_REQUEST['id_invoice']);

    $query = mysqli_query($config, "SELECT * FROM tbl_invoice WHERE id_invoice='$id_invoice'");

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
                                        <td width="13%">No.Invoice</td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['no_invoice'] ?></td>
                                    </tr>
                                  
                                    <tr>
                                        <td width="13%">Nama Tenant </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['nama_tenant'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-action">
                            <a href="?page=invoice&act=del&submit=yes&id_invoice= <?= $row['id_invoice'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                            <a href="./admin.php?page=invoice" class="btn small blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row form END -->

            <?php
            if (isset($_REQUEST['submit'])) {
                $id_invoice = $_REQUEST['id_invoice'];

                $query = mysqli_query($config, "DELETE FROM tbl_invoice WHERE id_invoice='$id_invoice'");

                if ($query == true) {
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=invoice_all";
                          </script>';
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                              window.location.href="./admin.php?page=invoice_all";
                         </script>';
                }
            }
        }
    }
}
?>
