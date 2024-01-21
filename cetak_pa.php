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
        }
        tr, td {
            border: table-cell;
            border: 1px  solid #444;
        }
        tr,td {
            vertical-align: top!important;
        }
        #right {
            border-right: none !important;
        }
        #left {
            border-left: none !important;
        }
        .isi {
            height: 300px!important;
        }
        .disp {
            text-align: center;
            padding: 1.5rem 0;
            margin-bottom: .5rem;
        }
        .logodisp {
            float: left;
            position: relative;
            width: 110px;
            height: 110px;
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
            margin-bottom: -10px;
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
        @media print{
            body {
                font-size: 12px;
                color: #212121;
            }
            nav {
                display: none;
            }
            table {
                width: 100%;
                font-size: 12px;
                color: #212121;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
                padding: 8px!important;

            }
            tr,td {
                vertical-align: top!important;
            }
            #lbr {
                font-size: 20px;
            }
            .isi {
                height: 200px!important;
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
                font-size: 20px!important;
                font-weight: bold;
                text-transform: uppercase;
                margin: -10px 0 -20px 0;
            }
            .up {
                font-size: 17px!important;
                font-weight: normal;
            }
            .status {
                font-size: 17px!important;
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
                border-bottom: 2px solid #616161;
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
                <img class="logodisp" src="./upload/<?= $logo ?>"/>
                <h1 class="up"><strong>P A</strong></h1>
                <span id="alamat">( Persiapan Acara )</span><br/>
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/></br>

            </div>
            <div class="separator"></div>

            <?php
            $id_pa = mysqli_real_escape_string($config, $_REQUEST['id_pa']);
            $query = mysqli_query($config, "SELECT * FROM tbl_pa WHERE id_pa='$id_pa'");

            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
                    ?>

                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                            </tr>
                        <!--button onclick="window.history.back()" class="btn-large green waves-effect waves-light left"><i class="material-icons">arrow_back</i> KEMBALI</button-->
                        <tr>
                            <td id="right" width="8%"><strong>No.Form</strong></td>
                            <td id="left" style="border-right:" width="20%">: <?= $row['no_pa'] ?></td>
                            <td id="left" width="18%"><strong>Tanggal Dibuat</strong> : <?= indoDate($row['tgl_pa']) ?></td>
                        </tr>
                        <tr>
                            <td id="right" width="8%"><strong>Nama Perusahaan</strong></td>
                            <td id="left" style="border-right:" width="20%">: <?= $row['nama_perusahaan'] ?></td>
                            <td id="left" width="18%"><strong>Penanggung Jawab</strong> :  <?= ucwords(nl2br(htmlentities(strtolower($row['penanggung_jawab'])))) ?></td>
                        </tr>
                        <tr>
                            <td id="right" width="8%"><strong>No.Telp</strong></td>
                            <td id="left" style="border-right:" width="20%">: <?= $row['no_telp'] ?></td>
                            <td id="left" width="18%"><strong>Ruangan Sewa</strong> : <?= $row['ruangan_sewa'] ?></td>
                        </tr>
                        <tr>
                            <td id="right"><strong>Tanggal Acara</strong></td>
                            <td id="left"style="border-right:" width="18%">: <?= indoDate($row['tgl_acara']) ?></td>
                            <td id="left" width="18%"><strong>Tanggal Selesai</strong> : <?= indoDate($row['tgl_selesai']) ?></td>
                        </tr>
                        <tr>
                            <td id="right"><strong>Judul Acara</strong></td>
                            <td id="left"style="border-right:" width="18%">: <?= ucwords(nl2br(htmlentities(strtolower($row['judul'])))) ?></td>
                            <td id="left" width="18%"><strong>Jam</strong> : <?= $row['jam'] ?></td>
                        </tr>
                        <tr>
                            <td id="right"><strong>Fasilitas</strong></td>
                            <td id="left"style="border-right:" width="18%">: <?= ucwords(nl2br(htmlentities(strtolower($row['fasilitas'])))) ?></td>
                            <td id="left" width="18%"><strong>Detail Harga Sewa</strong> : <?= ucwords(nl2br(htmlentities(strtolower($row['tambahan_lain'])))) ?></td>
                        </tr> 
                        <tr>
                            <td id="right" width="8%"><strong>Status Surat</strong></td>
                            <td id="left" style="border-right:" width="20%">: <?= $row['status'] ?></td>
                            <td id="left" width="18%"><strong>File Lampiran</strong> : <?php
                                if (!empty($row['file'])) {
                                    echo ' <strong><a href = "/./upload/permintaan_acara/' . $row['file'] . '"><img src="/./upload/permintaan_acara/' . $row['file'] . '" style="width: 200px"></a></strong>';
                                } else {
                                    echo '<em>Tidak ada file yang di upload</em>';
                                }
                                ?>
                        </tr>
                        <tr>

                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                            <th width="50%"><center>RINCIAN HARGA</center></th>
                            </thead>
                        </table>
                        <table class="bordered" id="tbl">
                            <td id="right" width="18%"><strong>Harga Sewa</strong></td>
                            <td id="left" style="border-right:" width="20%">: <?= $row['harga_sewa'] = "Rp " . number_format((float) $row['harga_sewa'], 0, ',', '.') ?></td>
                            <td id="left" width="30%"><strong>DP</strong> : <?= $row['dp'] = "Rp " . number_format((float) $row['dp'], 0, ',', '.') ?></td>
                            <td id="right" width="8%"><strong>Discount</strong></td>
                            <td id="left">: <?= $row['promo'] = "Rp " . number_format((float) $row['promo'], 0, ',', '.') ?></td>

                        </table>
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="5%"><center>No</center></th>
                            <th width="12%"><center>Charge Tambahan</center></th>
                            <th width="5%"><center>Harga</center></th>
                            </tr>
                            </thead>

                            <?php
                            $query2 = mysqli_query($config, "SELECT *from tbl_pa_detail
                                                                    WHERE id_pa='$id_pa'");
                            if (mysqli_num_rows($query2) > 0) {
                                $no = 0;
                                while ($row = mysqli_fetch_array($query2)) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><center><?= $no ?></center></td>
                                    <td><center><?= ucwords(nl2br(htmlentities(strtolower($row['nama_paket'])))) ?></center><br/></td>
                                    <td><center><?= $row['harga'] = "Rp " . number_format((float) $row['harga'], 0, ',', '.') ?></center></td>
                                    </tr>  
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="5"><center><p class="add">Tidak ada charge tambahan</p></center></td></tr>
                                <?php
                            }
                            ?>

                            <tr>
                                <?php
                                $pengeluaran = mysqli_fetch_array(mysqli_query($config, "SELECT sum(harga) as pengeluaran
                                                                                               FROM tbl_pa_detail  
                                                                                               WHERE id_pa='$id_pa'"));
                                $sewa = mysqli_fetch_array(mysqli_query($config, "SELECT harga_sewa as sewa
                                                                                               FROM tbl_pa  
                                                                                               WHERE id_pa='$id_pa'"));
                                $promo = mysqli_fetch_array(mysqli_query($config, "SELECT promo as promo
                                                                                               FROM tbl_pa  
                                                                                               WHERE id_pa='$id_pa'"));
                                $dp = mysqli_fetch_array(mysqli_query($config, "SELECT dp as dp
                                                                                               FROM tbl_pa  
                                                                                               WHERE id_pa='$id_pa'"));
                                $ppn = mysqli_fetch_array(mysqli_query($config, "SELECT ppn as ppn_baru
                                                                                               FROM tbl_pa  
                                                                                               WHERE id_pa='$id_pa'"));

                                $dpp = $sewa['sewa'] - $promo['promo'];
                                $ppn = $dpp * $ppn['ppn_baru'];
                                $total = $dpp + $ppn + $pengeluaran['pengeluaran'] - $dp['dp']; // kurang bayar
                                $total_all = $dpp + $ppn + $pengeluaran['pengeluaran']; //total
                                ?>
                            <tr>
                                <td id="right" width="8%"><strong>DPP</strong></td>
                                <td id="left" style="border-right:" width="20%">: <strong><?php echo "Rp " . number_format("$dpp", '0', '.', '.') ?> </strong></td>
                                <td id="left" width="18%"><strong>TOTAL</strong> : <strong><?php echo "Rp " . number_format("$total_all", '0', '.', '.') ?> </strong></td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>PPN</strong></td>
                                <td id="left" style="border-right:" width="20%">: <?php echo "Rp " . number_format("$ppn", '0', '.', '.') ?></strong></td>
                                <td id="left" width="18%"><strong>Kurang Bayar</strong> :  <strong><?php echo "Rp " . number_format("$total", '0', '.', '.') ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan ="5"><strong><i>BANK BCA Cab. Bhayangkara a/n PT Graha Pena Jawa Pos Ac. 6100070004</i></strong></td>

                            </tr>

                            <?php
                            $query3 = mysqli_query($config, "SELECT a.*,
                                                                    b.mng_mkt,
                                                                    b.id_user as id_mkt,
                                                                    c.nama,
                                                                    d.file_ttd as ttd_mkt,
                                                                    f.file_ttd as ttd,
                                                                    e.nama as nama_mkt
                                                                    
                                                                   FROM tbl_pa a
                                                                   
                                                                    left join tbl_approve_pa b
                                                                    on a.id_pa=b.id_pa
                                                                    left join tbl_user_upload d 
                                                                    on b.id_user=d.id_user
                                                                    left join tbl_user_upload f 
                                                                    on a.id_user=f.id_user
                                                                    left join tbl_user c 
                                                                    on a.id_user=c.id_user
                                                                    left join tbl_user e 
                                                                    on b.id_user=e.id_user
                                                                    
                                                                 where a.id_pa='$id_pa'");
                            if (mysqli_num_rows($query3) > 0) {
                                $no = 0;
                                $row = mysqli_fetch_array($query3);
                                {
                                    $ttd_mkt = '';
                                    $ttd = '';
                                    if ($row['ttd'] != "") {
                                        $ttd = '<img src="/./upload/ttd/' . $row['ttd'] . '" style="width: 60px">';
                                    }
                                    if ($row['ttd_mkt'] != "") {
                                        $ttd_mkt = '<img src="/./upload/ttd/' . $row['ttd_mkt'] . '" style="width: 60px">';
                                    }
                                    ?>
                                    <tr height="70">
                                        <td><strong><center>DIBUAT :</strong></center><br/><center><?= $ttd ?><br><?= $row['nama'] ?></center></td>
                                    <td><strong><center>DIKETAHUI : <br>Manager Marketing</strong></center><center><?= $ttd_mkt ?><br><?= $row['mng_mkt'] ?><br><?= $row['nama_mkt'] ?><br><center></td>
                                                    <td><strong><center>DISETUJUI : <BR>Penyewa Acara</strong><center><br></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr height="70">
                                                                    <td id="right" rowspan="2"><strong><center>DIBUAT</strong>

                                                                    </td>
                                                                    <td colspan="1"><strong><center>DIKETAHUI</strong>

                                                                    </td>
                                                                    <td colspan="1"><strong><center>DISETUJUI</strong>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>
                                                        </table>

                                                        <div class="jarak2"></div>
                                                        <!-- Container END -->

                                                        </body>
                                                        <?php
                                                    }
                                                }
                                                ?>
