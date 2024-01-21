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
    $id_ac = intval($_REQUEST['id_ac']);
    $query = mysqli_query($config, "SELECT * FROM utility_ac WHERE id_ac='$id_ac'");
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
                            $header = array("Nama AC", "No.Form", "Tanggal", "Cuci Unit", "Kondisi Kompressor", "Kondisi outdoor", "Kondisi Indoor", "Arus AC", "Isi Freon", "Lain-lain", "Bukti Foto");
                            $isi_row = array("nama_ac", "no_form", "tgl_ac", "cuci_unit", "kondisi_kompressor", "kondisi_outdoor", "kondisi_indoor", "arus_ac", "isi_freon", "lain", "file");
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
                                                            echo ($row[$kolom]) ? "<img class='materialboxed' src='upload/ac/" . $row[$kolom] . "' width=100px>" : "<em>Tidak ada file yang di upload</em>";
                                                        endif; ?> </td>
                                <?php
                                }
                            } else {
                                $pg_name = "ac";
                                $ac->nodata($pg_name);
                            }
                                ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    <a href="?page=ac&act=del&submit=yes&id_ac= <?= $row['id_ac'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                    <a href="./admin.php?page=ac" class="btn small blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row form END -->
<?php
    if (isset($_REQUEST['submit'])) {
        $id_ac = $_REQUEST['id_ac'];

        $query = mysqli_query($conn, "DELETE FROM utility_ac WHERE id_ac='$id_ac'");

        if ($query === true) {
            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
            header("Location: ./admin.php?page=ac");
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            header("Location: ./admin.php?page=ac");
        }
    }
}
