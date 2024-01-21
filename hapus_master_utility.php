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
    $id_utility = mysqli_real_escape_string($config, $_REQUEST['id_utility']);
    $query = mysqli_query($config, "SELECT * FROM master_utility WHERE id_utility='$id_utility'");
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_assoc()) {
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
                                        <td width="13%">Utility </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['nama_utility'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Plat Nomer </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['lokasi'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Tanggal Pengadaan </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['tgl'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Merk </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['merk'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Tipe </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['type'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">S/N </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['sn'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Volt </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['volt'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Kva </td>
                                        <td width="1%">:</td>
                                        <td width="86%"><?= $row['kva'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-action">
                            <a href="?page=master_utility&act=del&submit=yes&id_utility= <?= $row['id_utility'] ?>" class="btn small deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                            <a href="./admin.php?page=master_utility" class="btn small blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row form END -->
            <?php
            if (isset($_REQUEST['submit'])) {
                $id_utility = $_REQUEST['id_utility'];

                $query = mysqli_query($conn, "DELETE FROM master_utility WHERE id_utility='$id_utility'");

                if ($query === true) {
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
            ?><script language="javascript">
                        window.location.href = "./admin.php?page=master_utility";
                    </script>
                <?php
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                ?><script language="javascript">
                        window.location.href = "./admin.php?page=master_utility";
                    </script>
<?php
                }
            }
        }
    }
}
