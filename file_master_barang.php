<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    $id_barang_gudang = mysqli_real_escape_string($config, $_REQUEST['id_barang_gudang']);
    $query = mysqli_query($config, "SELECT * FROM master_barang WHERE id_barang_gudang='$id_barang_gudang'");
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            ?>
            <div class="row jarak-form">
                <ul class="collapsible white" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header white"><i class="material-icons md-prefix md-36">expand_more</i><span class="add">Tampilkan detail data barang</span></div>
                        <div class="collapsible-body white">
                            <div class="col m12 white">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="13%">No.Barang</td>
                                            <td width="1%">:</td>
                                            <td width="86%"><?= $row['no_barang'] ?></td>
                                        </tr>
                                        <tr>
                                            <td width="13%">Nama Barang</td>
                                            <td width="1%">:</td>
                                            <td width="86%"><?= $row['nama_barang_gudang'] ?></td
                                        </tr>
                                        <tr>
                                            <td width="13%">Satuan</td>
                                            <td width="1%">:</td>
                                            <td width="86%"><?= $row['satuan_barang'] ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </li>
                </ul>

                <button onclick="window.history.back()" class="btn small blue waves-effect waves-light left"><i class="material-icons">arrow_back</i> KEMBALI</button>
                <?php
                if (empty($row['file'])) {
                    ?>
                    <?php
                } else {

                    $ekstensi = array('jpg', 'png', 'jpeg');
                    $ekstensi2 = array('doc', 'docx');
                    $file = $row['file'];
                    $x = explode('.', $file);
                    $eks = strtolower(end($x));

                    if (in_array($eks, $ekstensi) == true) {
                        ?>
                        <img class="gbr" data-caption="<?= date('d M Y', strtotime($row['tgl_master_barang'])) ?>" src="./upload/master_barang/<?= $row['file'] ?>"/>
                        <?php
                    } else {

                        if (in_array($eks, $ekstensi2) == true) {
                            ?>
                            <div class="gbr">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="col s9 left">
                                            <div class="card">
                                                <div class="card-content">
                                                    <p>File lampiran ini bertipe <strong>document</strong>, silakan klik link dibawah ini untuk melihat file lampiran tersebut.</p>
                                                </div>
                                                <div class="card-action">
                                                    <strong>Lihat file :</strong> <a class="blue-text" href="./upload/master_alat/<?= $row['file'] ?>" target="_blank"><?= $row['file'] ?></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col s3 right">
                                            <img class="file" src="./asset/img/word.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="gbr">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="col s9 left">
                                            <div class="card">
                                                <div class="card-content">
                                                    <p>File lampiran surat masuk ini bertipe <strong>PDF</strong>, silakan klik link dibawah ini untuk melihat file lampiran tersebut.</p>
                                                </div>
                                                <div class="card-action">
                                                    <strong>Lihat file :</strong> <a class="blue-text" href="./upload/master_alat/<?= $row['file'] ?>" target="_blank"><?= $row['file'] ?></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col s3 right">
                                            <img class="file" src="./asset/img/pdf.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
            <?php
        }
    }
}
?>
