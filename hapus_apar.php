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
    $id_apar = intval($_REQUEST['id_apar']);
    $query = mysqli_query($config, "SELECT * FROM utility_apar WHERE id_apar='$id_apar'");
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
                            $isi_row = array("no_form", "tanggal", "jenis_apar", "berat", "posisi", "keterangan", "status", "file");
                            $header = array("No.Form", "Tanggal", "jenis Apar", "BERAT", "POSISI", "KETERANGAN", "STATUS", "BUKTI FOTO");
                            if (!empty($row)) {
                                foreach ($isi_row as $index => $kolom) {
                                    $head = $header[$index];

                            ?>
                                    <tr>
                                        <td width="13%"><?= $head ?></td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?php if ($kolom != "file") :
                                                            echo isset($row[$kolom]) ? $row[$kolom] : "<p class='red-text'>No Data</p>";
                                                        else :
                                                            echo ($row[$kolom]) ? "<img class='materialboxed' src='upload/apar/" . $row[$kolom] . "' width=100px>" : "<em>Tidak ada file yang di upload</em>";
                                                        endif; ?> </td>
                                    </tr>
                                <?php } ?>

                            <?php
                            } else {
                                $pg_name = "apar";
                                $apar->nodata($pg_name);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    <a href="?page=apar&act=del&submit=yes&id_apar= <?= $row['id_apar'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                    <a href="./admin.php?page=apar" class="btn small blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row form END -->
<?php
    if (isset($_REQUEST['submit'])) {
        $id_apar = $_REQUEST['id_apar'];

        $query = mysqli_query($conn, "DELETE FROM utility_apar WHERE id_apar='$id_apar'");

        if ($query === true) {
            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
            header("Location: ./admin.php?page=apar");
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            header("Location: ./admin.php?page=apar");
        }
    }
}
