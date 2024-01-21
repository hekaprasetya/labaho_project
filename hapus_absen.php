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
    $id_absen = intval($_REQUEST['id_absen']);
    $query = mysqli_query($config, "SELECT a.*, b.nama FROM tbl_absen a LEFT JOIN tbl_user b ON a.id_user = b.id_user WHERE id_absen='$id_absen'");
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
                            $isi_row = array("nama", "tanggal", "jenis_absen", "status_absen", "lati");
                            $header = array("Nama", "Tanggal", "Jenis Absen", "Status Absen", "Lokasi");
                            if (!empty($row)) {
                                foreach ($isi_row as $index => $kolom) {
                                    $head = $header[$index];
                                    $long = $row['longi'];
                                    $lati = $row['lati'];
                            ?>
                                    <tr>
                                        <td width="13%"><?= $head ?></td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?php if ($kolom != "file") :
                                                            if ($kolom == "lati") {
                                                                echo isset($row[$kolom]) ? '<a target="_blank" href="https://www.google.com/maps/place/' . $lati . ',' . $long . '/@' . $lati . ',' . $long . ',17z/data=!3m1!4b1!4m4!3m3!8m2!3d' . $lati . '!4d' . $long . '?entry=ttu"><img src="asset/img/google-maps.webp" width="50px" alt="lokasi"></a>' : "<p class='red-text'>No Data</p>";
                                                            } else {
                                                                echo isset($row[$kolom]) ? $row[$kolom] : "<p class='red-text'>No Data</p>";
                                                            }
                                                        else :
                                                            echo ($row[$kolom]) ? "<img class='materialboxed' src='upload/absen/" . $row[$kolom] . "' width=100px>" : "<em>Tidak ada file yang di upload</em>";
                                                        endif; ?> </td>
                                <?php
                                }
                            } else {
                                $pg_name = "absen";
                                $absen->nodata($pg_name);
                            }
                                ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    <a href="?page=absen&act=del&submit=yes&id_absen= <?= $row['id_absen'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                    <a href="./admin.php?page=absen" class="btn small blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row form END -->
<?php
    if (isset($_REQUEST['submit'])) {
        $id_absen = $_REQUEST['id_absen'];

        $query = mysqli_query($conn, "DELETE FROM tbl_absen WHERE id_absen='$id_absen'");

        if ($query === true) {
            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
            header("Location: ./admin.php?page=absen");
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            header("Location: ./admin.php?page=absen");
        }
    }
}
