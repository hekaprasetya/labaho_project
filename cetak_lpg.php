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

    <body onload="window.print()">

        <!-- Container START -->
        <div id="colres">
            <div class="disp">
                <?php
                $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
                ?>
                <img class="logodisp" src="./upload/<?= $logo ?>"/>
                <span id="alamat"><h5><strong> L P G</h5></strong> </span>
                <span id="alamat">( LAPORAN PEKERJAAN GUDANG )</span><br/>
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/></br>

            </div>
            <div class="separator"></div>
            <?php
            $id_lpg = mysqli_real_escape_string($config, $_REQUEST['id_lpg']);
            $query = mysqli_query($config, "SELECT a.*, 
                                           b.no_agenda,indeks,asal_surat
                                           FROM tbl_lpg a
                                           LEFT JOIN tbl_surat_masuk b
                                           ON a.id_surat=b.id_surat
                                           WHERE id_lpg='$id_lpg'");

            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
                    ?>

                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>

                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>No.LPG </strong></td>
                                <td id="left" colspan="2">: <?= $row['no_lpg'] ?></td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Tgl.LPG </strong></td>
                                <td id="left" colspan="2">: <?= indoDate($row['tgl_lpg']) ?></td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Nama Perusahaan </strong></td>
                                <td id="left" colspan="2">: <?= $row['indeks'] ?></td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Jenis Pekerjaan </strong></td>
                                <td id="left" colspan="2">: <?= $row['pekerjaan_lpg'] ?></td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Lokasi Pekerjaan </strong></td>
                                <td id="left" colspan="2">: <?= $row['asal_surat'] ?></td>
                            </tr>
                            <tr>
                                 <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="3%">No</th>
                                <th width="12%">Nama Barang</th>
                                <th width="5%">Jumlah</th>
                                <th width="5%">Satuan</th>
                                <th width="15%">Catatan</th>
                                <th width="12%"><center>File</center></th>
                                <th width="3%"><center>Tindakan</center></th>
                        </tr>
                        </thead>
                        
                        <?php
                        $query2 = mysqli_query($config, "SELECT *from tbl_lpg_detail
                                           WHERE id_lpg='$id_lpg'");
                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords(nl2br(htmlentities(strtolower($row['nama_barang'])))) ?><br/></td>
                                    <td><?= $row['jumlah'] ?></td>
                                    <td><?= $row['satuan'] ?></td>
                                    <td><?= $row['catatan'] ?><br/></td>
                                    <td><center><?= '<a href = "/./upload/lpg_detail/' . $row['file'] . '"><img src="/./upload/lpg_detail/' . $row['file'] . '" style="width: 70px">'; ?></center></td>
                                  <td><center><a href="hapus_lpg_detail.php?id_lpg_detail=<?= $row["id_lpg_detail"] ?>" class="btn small btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center></td>
                                 </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="7"><center><p class="add">Tidak ada detail barang</p></center></td></tr>
                            <?php
                        }
                        ?>

                                <?php
                                $query3 = mysqli_query($config, "SELECT a.*, f.nama, f.file as ttd,
                                                                        b.status_app_lpg, b.id_user as id_approve_lpg, 
                                                                        d.nama as nama_manager, d.file as ttd_manager
                                                                        FROM tbl_lpg a
                                                                        left join tbl_approve_lpg    b on a.id_lpg    =   b.id_lpg
                                                                        left join tbl_user           d on b.id_user  =   d.id_user
                                                                        left join tbl_user           f on a.id_user=f.id_user
                                                                        where a.id_lpg='$id_lpg'");
                                if (mysqli_num_rows($query3) > 0) {
                                    $no = 0;
                                    $row = mysqli_fetch_array($query3);
                                    {
                                        $ttd_manager = '';
                                        $ttd = '';
                                        if ($row['ttd'] != "") {
                                            $ttd = '<img src="/./upload/ttd/' . $row['ttd'] . '" style="width: 100px">';
                                        }
                                        if ($row['ttd_manager'] != "") {
                                            $ttd_manager = '<img src="/./upload/ttd/' . $row['ttd_manager'] . '" style="width: 100px">';
                                        }
                                        ?>
                                    <tr>
                                        <td colspan="4"><strong><center>DIBUAT      : <br/><center><?= $ttd ?><br><?= $row['nama'] ?></center></td>
                                                    <td colspan="3"><strong><center>DISETUJUI   : <br>Kepala Bagian</strong></center><center><?= $ttd_manager ?><br><?= $row['status_app_lpg'] ?><br><?= $row['nama_manager'] ?><br><center></td>

                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>

                                                                <tr height="120">
                                                                    <td colspan="2"><strong><center>DIBUAT</strong></td>
                                                                    <td colspan="2"><strong><center>DIKETAHUI</strong></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>
                                                        </table>
                                                        <div class="jarak2"></div>
                                                        </body>
                                                        <?php
                                                    }
                                                }
                                                ?>
