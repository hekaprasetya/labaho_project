<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header("Location: ./");
    die();
} else {
?>

    <style type="text/css">
        table {
            background: #fff;
            padding: 5px;
            line-height: 1.5em;
        }

        tr,
        td {
            border: table-cell;
            border: 1px solid #444;
            line-height: 1;
        }

        tr,
        td {
            vertical-align: top !important;
        }

        #right {
            border-right: none !important;
        }

        #left {
            border-left: none !important;
        }

        .isi {
            height: 300px !important;
        }

        .disp {
            text-align: center;
            padding: 1rem 0;
            margin-bottom: .5rem;
        }

        .logodisp {
            float: left;
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 0 0 1rem;
        }

        #lead {
            width: auto;
            position: relative;
            margin: 25px 0 0 75%;
        }

        .lead {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: -1px;
        }

        .tgh {
            text-align: center;
        }

        #nama {
            font-size: 2.1rem;
            margin-bottom: -1rem;
        }

        #alamat {
            font-size: 16px;
        }

        .up {
            text-transform: uppercase;
            margin: 0;
            line-height: 2.2rem;
            font-size: 1.5rem;
        }

        .status {
            margin: 0;
            font-size: 1.3rem;
            margin-bottom: .5rem;
        }

        #lbr {
            font-size: 20px;
            font-weight: bold;
        }

        .separator {
            border-bottom: 2px solid #616161;
            margin: -1.3rem 0 1.5rem;
        }

        @media print {
            body {
                font-size: 11px;
                color: #212121;
            }

            nav {
                display: none;
            }

            table {
                width: 100%;
                font-size: 10px;
                color: #212121;
            }

            tr,
            td {
                border: table-cell;
                border: 1px solid #444;
                padding: 8px !important;

            }

            tr,
            td {
                vertical-align: top !important;
            }

            #lbr {
                font-size: 20px;
            }

            .isi {
                height: 200px !important;
            }

            .tgh {
                text-align: center;
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

            #lead {
                width: auto;
                position: relative;
                margin: 15px 0 0 75%;
            }

            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }

            #nama {
                font-size: 20px !important;
                font-weight: bold;
                text-transform: uppercase;
                margin: -10px 0 -20px 0;
            }

            .up {
                font-size: 17px !important;
                font-weight: normal;
            }

            .status {
                font-size: 17px !important;
                font-weight: normal;
                margin-bottom: -.1rem;
            }

            #alamat {
                margin-top: -15px;
                font-size: 13px;
            }

            #lbr {
                font-size: 17px;
                font-weight: bold;
            }

            .separator {
                border-bottom: 1px solid #616161;
                margin: -1rem 0 1rem;
            }

        }
    </style>

    <body>
        <script>
            $(document).ready(function() {
                cetak();
            });
        </script>

        <!-- Container START -->
        <div id="colres">
            <div class="disp">
                <?php
                $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
                ?>

                <img class="logodisp" src="./upload/<?= $logo ?>" />
                <h2 class="up">O P B</h2>
                <span id="alamat">( Order Permintaan Barang )</span><br />
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br /></br>

            </div>
            <div class="separator"></div>
            <?php
            $id_opb = mysqli_real_escape_string($config, $_REQUEST['id_opb']);
            $query = mysqli_query($config, "SELECT * FROM tbl_opb WHERE id_opb='$id_opb'");

            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
            ?>

                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>No.Form</strong></td>
                                <td id="left" style="border-right" colspan="6">: <?= $row['no_form'] ?></td>
                                <td id="left" colspan="1"><strong>Tgl.OPB</strong> : <?= indoDate($row['tgl_opb']) ?></td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>Divisi</strong></td>
                                <td id="left" style="border-right" colspan="6">: <?= $row['divisi_opb'] ?></td>
                            </tr>
                            <tr>
                        </tbody>
                    </table>

                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="10%">No</th>
                                <th width="20%">Nama Peminta</th>
                                <th width="20%">Nama barang</th>
                                <th width="15%">Jumlah</th>
                                <th width="15%">Satuan</th>
                                <th width="20%">Keperluan</th>
                            </tr>
                        </thead>


                        <?php
                        $query2 = mysqli_query($config, "SELECT a.*,
                        b.id_app_opb_kabag,status_opb_kabag,waktu_opb_kabag, 
                        c.id_app_opb_petugas,status_opb_petugas,waktu_opb_petugas,
                        d.id_opb_detail,nama_opb,nama_barang,jumlah,satuan,keperluan,
                        e.nama 
                        FROM tbl_opb a
                        LEFT JOIN tbl_approve_opb_kabag b
                        ON a.id_opb=b.id_opb
                        LEFT JOIN tbl_approve_opb_petugas c 
                        ON a.id_opb=c.id_opb
                        LEFT JOIN tbl_opb_detail d 
                        ON a.id_opb=d.id_opb  
                        LEFT JOIN tbl_user e
                        ON a.id_user=e.id_user
                        
                        WHERE d.id_opb='$id_opb'");
                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords(nl2br(htmlentities(strtolower($row['nama_opb'])))) ?><br /></td>
                                    <td><?= ucwords(nl2br(htmlentities(strtolower($row['nama_barang'])))) ?><br /></td>
                                    <td><?= $row['jumlah'] ?></td>
                                    <td><?= $row['satuan'] ?></td>
                                    <td><?= $row['keperluan'] ?></td>
                                </tr>

                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <center>
                                        <p class="add">Tidak ada data untuk ditampilkan.</p>
                                    </center>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>




                        <?php
                        $query3 = mysqli_query($config, "SELECT a.*, 
                                            f.nama, f.file                      as ttd,
                                            b.status_opb_kabag, b.id_user       as id_app_opb_kabag, 
                                            d.nama                              as nama_kabag, 
                                            d.file                              as ttd_kabag,
                                            c.status_opb_petugas, c.id_user     as id_app_opb_petugas,
                                            e.nama                              as nama_petugas,
                                            e.file                              as ttd_petugas
                                            FROM tbl_opb a
                                            LEFT JOIN tbl_approve_opb_kabag     b ON a.id_opb   = b.id_opb
                                            LEFT JOIN tbl_user                  d ON b.id_user  = d.id_user
                                            LEFT JOIN tbl_approve_opb_petugas   c ON a.id_opb   = c.id_opb
                                            LEFT JOIN tbl_user                  e ON c.id_user  = e.id_user
                                            LEFT JOIN tbl_user                  f ON a.id_user  = f.id_user
                                            WHERE a.id_opb='$id_opb'");

                        if (mysqli_num_rows($query3) > 0) {
                            $no = 0;
                            $row = mysqli_fetch_array($query3); {
                                $ttd_kabag = '';
                                $ttd_petugas = '';
                                $ttd = '';
                                if ($row['ttd'] != "") {
                                    $ttd = '<img src = "/./upload/ttd/' . $row['ttd'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_kabag'] != "") {
                                    $ttd_kabag = '<img src = "/./upload/ttd/' . $row['ttd_kabag'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_petugas'] != "") {
                                    $ttd_petugas = '<img src = "/./upload/ttd/' . $row['ttd_petugas'] . '" style = "width: 80px">';
                                }
                        ?>

                                <table class="bordered" id="tbl">
                                    <tr>
                                        <td><strong>
                                                <center>DIBUAT : <br />
                                                    <center><?= $ttd ?><br><?= $row['nama'] ?></center>
                                        </td>
                                        <td><strong>
                                                <center>DISETUJUI : <br>Kepala Bagian
                                            </strong></center>
                                            <center><?= $ttd_kabag ?><br><?= $row['status_opb_kabag'] ?><br><?= $row['nama_kabag'] ?><br>
                                                <center>
                                        </td>
                                        <td><strong>
                                                <center>DIKETAHUI : <BR>Petugas
                                            </strong>
                                            <center><?= $ttd_petugas ?><br><?= $row['status_opb_petugas'] ?><br><?= $row['nama_petugas'] ?><br>
                                        </td>
                                    </tr>
                                <?php
                            }
                        } else {
                                ?>

                                <tr height="100">
                                    <td id="right" rowspan="2"><strong>
                                            <center>DIBUAT
                                        </strong> </td>
                                    <td colspan="1"><strong>
                                            <center>DISETUJUI
                                        </strong> </td>
                                    <td colspan="1"><strong>
                                            <center>DIKETAHUI
                                        </strong> </td>
                                </tr>
                        <?php
                        }
                    }
                        ?>
                        </tbody>
                                </table>

        </div>
        <div class="jarak2"></div>
        <!-- Container END -->

    </body>
<?php
            }
        }
?>