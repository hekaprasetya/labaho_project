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
                <h2 class="up">E-CUTI</h2> <br>
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br /></br>

            </div>
            <div class="separator"></div>
            <?php
            $id_cuti = mysqli_real_escape_string($config, $_REQUEST['id_cuti']);
            $query = mysqli_query($config, "SELECT a.*,
                                                           b.nama,jabatan
                                                           
                                                           FROM tbl_cuti a
                                                           LEFT JOIN tbl_user b
                                                           ON a.id_user=b.id_user
                         WHERE id_cuti='$id_cuti'");

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
                                <td id="left" style="border-right: none;" width="20%">: <?= $row['no_form'] ?></td>
                                <td id="left" width="18%"><strong>Tgl.Cuti </strong> : <?= indoDate($row['tgl']) ?></td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>Nama</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: <?= $row['nama'] ?></td>
                                <td id="left" width="18%"><strong>Jabatan </strong> : <?= $row['jabatan'] ?></td>
                            </tr>
                            <tr>
                        </tbody>
                    </table>

                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">No.Hp</th>
                                <th width="10%">Keperluan</th>
                                <th width="15%">tanggal cuti</th>
                                <th width="15%">Akhir Cuti</th>
                                <th width="10%">Jumlah Hari</th>
                                <th width="10%">DiSetujui</th>
                            </tr>
                        </thead>

                        <?php
                        $query2 = mysqli_query($config, "SELECT a.*,
                                                           b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                                           c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                                           d.nama,jabatan,no_hp
                                                           
                                                           FROM tbl_cuti a
                                                           LEFT JOIN tbl_approve_cuti_kabag b
                                                           ON a.id_cuti=b.id_cuti
                                                           LEFT JOIN tbl_approve_cuti_hrd c 
                                                           ON a.id_cuti=c.id_cuti
                                                           LEFT JOIN tbl_user d
                                                           ON a.id_user=d.id_user
                        
                        WHERE a.id_cuti='$id_cuti'");
                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                        ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['no_hp'] ?></td>
                                    <td><?= $row['alasan_cuti'] ?></td>
                                    <td><?= indoDate($row['tgl_cuti']) ?></td>
                                    <td><?= indoDate($row['akhir_cuti']) ?></td>
                                    <td><?= $row['jumlah_hari'] ?> Hari</td>
                                    <td><?= $row['jumlah_trm'] ?> Hari</td>
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
                                                                f.file_ttd as ttd,
                                                                g.nama,
                                                                b.status_cuti_kabag, 
                                                                b.id_user as id_app_cuti_kabag,
                                                                h.nama as nama_kabag,
                                                                d.file_ttd as ttd_kabag,
                                                                c.status_cuti_hrd, 
                                                                c.id_user as id_app_cuti_hrd,
                                                                i.nama as nama_hrd,
                                                                e.file_ttd as ttd_hrd
                                                        FROM tbl_cuti a
                                                        LEFT JOIN tbl_approve_cuti_kabag b ON a.id_cuti = b.id_cuti
                                                        LEFT JOIN tbl_user_upload  d ON b.id_user = d.id_user
                                                        LEFT JOIN tbl_approve_cuti_hrd c ON a.id_cuti = c.id_cuti
                                                        LEFT JOIN tbl_user_upload e ON c.id_user  = e.id_user
                                                        LEFT JOIN tbl_user_upload f ON a.id_user  = f.id_user
                                                        left join tbl_user g on a.id_user=g.id_user
                                                        left join tbl_user h on b.id_user=h.id_user
                                                        left join tbl_user i on c.id_user=i.id_user
                                                        WHERE a.id_cuti='$id_cuti'");

                        if (mysqli_num_rows($query3) > 0) {
                            $no = 0;
                            $row = mysqli_fetch_array($query3); {
                                $ttd_kabag = '';
                                $ttd_hrd = '';
                                $ttd = '';
                                if ($row['ttd'] != "") {
                                    $ttd = '<img src = "/./upload/ttd/' . $row['ttd'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_kabag'] != "") {
                                    $ttd_kabag = '<img src = "/./upload/ttd/' . $row['ttd_kabag'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_hrd'] != "") {
                                    $ttd_hrd = '<img src = "/./upload/ttd/' . $row['ttd_hrd'] . '" style = "width: 80px">';
                                }
                        ?>

                                <table class="bordered" id="tbl">
                                    <tr>
                                        <td><strong>
                                                <center>DIBUAT : <br><br>
                                                    <center><?= $ttd ?><br><br><?= $row['nama'] ?></center>
                                        </td>
                                        <td><strong>
                                                <center>DISETUJUI : <br>Kepala Bagian
                                            </strong></center>
                                            <center><?= $ttd_kabag ?><br><?= $row['status_cuti_kabag'] ?><br><?= $row['nama_kabag'] ?><br>
                                                <center>
                                        </td>
                                        <td><strong>
                                                <center>DIKETAHUI :
                                            </strong>
                                            <center><?= $ttd_hrd ?><br><br><?= $row['status_cuti_hrd'] ?><br><?= $row['nama_hrd'] ?><br>
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