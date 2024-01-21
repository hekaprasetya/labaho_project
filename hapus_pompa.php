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
    $id_pompa = intval($_REQUEST['id_pompa']);
    $query = mysqli_query($config, "SELECT * FROM utility_pompa WHERE id_pompa='$id_pompa'");
    $row = $query->fetch_assoc();
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
                            <?php
                            // array isi ari tabel
                            $isi_row = array("no_form", "tanggal", "nama", "lokasi", "jokey_on", "jokey_off", "main_on", "main_off", "catatan");
                            $header = array("No.Form", "Tanggal", "Pemeriksa", "LOKASI", "JOKEY ON", "JOKEY OFF", "MAIN ON", "MAIN OFF", "CATATAN");
                            if (!empty($row)) {
                                foreach ($isi_row as $index => $kolom) {
                                    $head = $header[$index];

                            ?>
                                    <tr>
                                        <td width="13%"><?= $head ?></td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= isset($row[$kolom]) ? $row[$kolom] : "<p class='red-text'>No Data</p>" ?></td>
                                    </tr>
                                <?php } ?>

                            <?php
                            } else {
                                $pg_name = "pompa";
                                $pompa->nodata($pg_name);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    <a href="?page=pompa&act=del&submit=yes&id_pompa= <?= $row['id_pompa'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                    <a href="./admin.php?page=pompa" class="btn small blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row form END -->
<?php
    if (isset($_REQUEST['submit'])) {
        $id_pompa = $_REQUEST['id_pompa'];

        $query = mysqli_query($conn, "DELETE FROM utility_pompa WHERE id_pompa='$id_pompa'");

        if ($query === true) {
            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
            header("Location: ./admin.php?page=pompa");
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            header("Location: ./admin.php?page=pompa");
        }
    }
}
