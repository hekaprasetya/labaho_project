<?php
session_start();
$form_qrcode_data = isset($_SESSION['form_qrcode']) ? $_SESSION['form_qrcode'] : null;



if ($form_qrcode_data) {
    // Periksa apakah data ada
    include('include/config.php');
    include('include/functions.php');
    $id_apar = $form_qrcode_data['id_apar'];
    $tbl_name = "utility_apar";
    $qer = mysqli_query($conn, "SELECT posisi FROM utility_apar WHERE id_apar = '$id_apar' AND tanggal IS NULL");
    $gg = $qer->fetch_assoc();
    $posisi = $gg['posisi'];


    $conn = new mysqli($host, $username, $password, $database);
    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    $query2 = mysqli_query($conn, "SELECT logo FROM tbl_instansi");
    list($logo) = mysqli_fetch_array($query2);
    $l = $logo;

    $isi_row = array("nama", "tanggal", "jenis_apar", "berat", "posisi", "keterangan", "status");
    $header = array("Pemeriksa", "Tanggal Pengerjaan", "jenis Apar", "BERAT", "POSISI", "KETERANGAN", "STATUS");


    // $tbl_name = isset($_GET['tbl_name']) ? "utility_" . htmlspecialchars($_GET['tbl_name'], ENT_QUOTES, 'UTF-8') : 'kosong';
    // $id_apar = isset($_GET['id_apar']) ? htmlspecialchars($_GET['id_apar'], ENT_QUOTES, 'UTF-8') : 'kosong';
    // config master Kendaraan start
    // Buat query
    $query = "SELECT a.*,
b.nama
FROM $tbl_name a
LEFT JOIN tbl_user b
ON a.id_user=b.id_user
WHERE a.posisi='$posisi' AND tanggal IS NOT NULL";

    // Eksekusi query
    $result = mysqli_query($conn, $query);
    $cek = mysqli_num_rows($result);
    if ($cek == 0) {
        // Simpan pesan kosong ke dalam session
        $_SESSION['pesan_kosong'] = 'kosong';
        header("Location: ./form_qrcode_apar.php");
        exit;
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- icon -->
        <link rel="shortcut icon" href="asset/img/logo.png" type="image/png">
        <link rel="stylesheet" href="asset/css/materialize.min.css">
        <title>BARCODE</title>
    </head>
    <style>
        body {
            background: #fff;
            height: 95vh;
            font-family: "roboto", sans-serif !important;
        }


        .disp {
            text-align: center;
            margin: -.5rem 0;
        }

        .logodisp {
            float: left;
            position: relative;
            width: 80px;
            height: 77px;
            margin: .5rem 0 0 .5rem;
        }

        .up {
            font-size: 20px !important;
            font-weight: normal;
        }

        #alamat {
            margin-top: -15px;
            font-size: 13px;
        }

        .separator {
            border-bottom: 1px solid #616161;
            margin: -1rem 0 1rem;
        }



        /* @media (max-width: 600px) {
            #colres {
                width: 90%;
            }

            #tbl {
                margin: 20px;
                padding: 20px;
            }

        } */
    </style>

    <body>
        <div class="row">
            <div class="disp">
                <img class="logodisp" src="./upload/<?= $l ?>" />
                <h2 class="up">Master Utility APAR</h2>
                <span id="alamat">(Daftar Perbaikan)</span><br />
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br /></br>

            </div>
            <div class="separator"></div>
            <div class="container">
                <h4>History Perbaikan</h4>
                <div class="col m12" id="colres">
                    <table class="bordered centered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th>No</th>
                                <?php
                                foreach ($header as $head) {
                                ?>
                                    <th><?= ucwords(str_replace('_', ' ', $head)) ?></th>
                                <?php
                                }
                                ?>


                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            // Periksa hasil query
                            if ($cek > 0) {
                                // Ada data
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {

                            ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <?php foreach ($isi_row as $kolom) { ?>
                                            <td><?php if ($kolom != "file") :
                                                    echo isset($row[$kolom]) ? $row[$kolom] : "<p class='red-text'>No Data</p>";
                                                else :
                                                    echo ($row[$kolom]) ? "<img class='materialboxed' src='upload/apar/" . $row[$kolom] . "' width=100px>" : "<em>Tidak ada file yang di upload</em>";
                                                endif; ?></td>
                                        <?php } ?>
                                    </tr>



                            <?php
                                    $no++;
                                }
                            } else {
                                // Tidak ada data
                                echo "Tidak ada data";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var message = "Ngapain?";

            function clickIE4() {

                if (event.button == 2) {

                    alert(message);

                    return false;

                }

            }

            function clickNS4(e) {

                if (document.layers || document.getElementById && !document.all) {

                    if (e.which == 2 || e.which == 3) {

                        alert(message);

                        return false;

                    }

                }

            }

            if (document.layers) {

                document.captureEvents(Event.MOUSEDOWN);

                document.onmousedown = clickNS4;

            } else if (document.all && !document.getElementById) {

                document.onmousedown = clickIE4;

            }

            document.oncontextmenu = new Function("alert(message);return false");
        </script>
    </body>

    </html>
<?php
    unset($_SESSION['form_qrcode']);
} else {
    // Simpan pesan kembali ke dalam session
    $_SESSION['pesan'] = 'back';
    header("Location: ./form_qrcode_apar.php");
    exit;
}
