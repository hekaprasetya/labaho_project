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
             line-height: 1.1;
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
                <span id="alamat"><h5><strong>E-OP</h5></strong> </span>
                <span id="alamat">( ORDER PURCHASING )</span><br/>
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/></br>

            </div>
            <div class="separator"></div>
            <?php
            $id_op = mysqli_real_escape_string($config, $_REQUEST['id_op']);
            $query = mysqli_query($config, "SELECT *
                                           FROM tbl_op 
                                           WHERE id_op='$id_op'");

            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
                    ?>

                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>

                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>No.Urut</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: <?= $row['no_op'] ?></td>
                                <td id="left" width="18%"><strong>Tanggal OP</strong> : <?= indoDate($row['tgl_op']) ?></td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>Tanggal Brg.Dtg</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: <?= indoDate($row['tgl_brg_dtg']) ?></td>
                                <td id="left" width="18%"><strong>Syarat Pembayaran</strong> : <?= $row['syarat_pembayaran'] ?></td>
                            </tr>
                            <tr>
                               <td id="right" width="8%"><strong>Keterangan</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: <?= $row['keterangan_op'] ?></td>
                                <td id="left" width="18%"><strong>Supplier</strong> : <?= $row['supplier'] ?></td>
                            </tr>
                            <tr>
                    </table>

                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="3%">No</th>
                                <th width="12%">Nama Barang</th>
                                <th width="5%">Jumlah<br/><hr/>Satuan</th>
                                <th width="10%">Harga</th>
                                <th width="10%">Total</th>
                                <th width="10%">Total+PPN</th>
                                <th width="15%">Keterangan</th>
                                <!--th width="15%">Supplier</th-->
                            </tr>
                        </thead>

                        <?php
                        $query2 = mysqli_query($config, "SELECT *from tbl_op_detail
                                           WHERE id_op='$id_op'");
                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><?= $row['jumlah_op'] ?><br/><hr/><?= $row['satuan'] ?></td>
                                    <td><?= $row['harga_op'] = "Rp " . number_format((float) $row['harga_op'], 0, ',', '.') ?></td>
                                    <td><?= $row['total_op'] = "Rp " . number_format((float) $row['total_op'], 0, ',', '.') ?></td>
                                    <td>      
                                    <?php
                                    if (!empty($row['total_ppn'])) {
                                                        ?>
                                                        <strong><?= $row['total_ppn'] = "Rp " . number_format((float) $row['total_ppn'], 0, ',', '.') ?></strong>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <em>Tidak ada PPN</em>
                                                        <?php
                                                    } 
                                                    ?>
                                    </td>
                                    <td><?= $row['keterangan_op_detail'] ?></td>
                                    <!--td><?= $row['nama_supplier'] ?></td-->
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
                        $query3 = mysqli_query($config, "SELECT a.*, 
                                                                    f.file_ttd as ttd, 
                                                                    b.status_op_gm, b.id_user as id_gm,
                                                                    g.nama,
                                                                    d.file_ttd as ttd_gm,
                                                                    h.nama as nama_gm,
                                                                    c.status_op_kabag, c.id_user as id_kabag, 
                                                                    i.nama as nama_kabag,
                                                                    e.file_ttd as ttd_kabag 
                                                                    FROM tbl_op a
                                                                    left join tbl_approve_op_gm b on a.id_op=b.id_op
                                                                    left join tbl_user_upload d on b.id_user=d.id_user
                                                                    left join tbl_approve_op_kabag c on a.id_op=c.id_op
                                                                    left join tbl_user_upload e on c.id_user=e.id_user
                                                                    left join tbl_user_upload f on a.id_user=f.id_user
                                                                    left join tbl_user g on a.id_user=g.id_user
                                                                    left join tbl_user h on b.id_user=h.id_user
                                                                    left join tbl_user i on c.id_user=i.id_user
                                                                    where a.id_op='$id_op'");
                        if (mysqli_num_rows($query3) > 0) {
                            $no = 0;
                            $row = mysqli_fetch_array($query3); {
                                $ttd_kabag = '';
                                $ttd_gm = '';
                                $ttd = '';
                                if ($row['ttd'] != "") {
                                    $ttd = '<img src="/./upload/ttd/' . $row['ttd'] . '" style="width: 100px">';
                                }
                                if ($row['ttd_kabag'] != "") {
                                    $ttd_kabag = '<img src="/./upload/ttd/' . $row['ttd_kabag'] . '" style="width: 100px">';
                                }
                                if ($row['ttd_gm'] != "") {
                                    $ttd_gm = '<img src="/./upload/ttd/' . $row['ttd_gm'] . '" style="width: 100px">';
                                }
                                echo '
                                        <table border="2" width="500px">
                            <tr height="90">
                                <td><strong><center>DIBUAT :</strong></center><br/><center>' . $ttd . '<br>' . $row['nama'] . '</center></td>
                                    
                                </td>
                                <td><strong><center>DISETUJUI : <br>Manager Keuangan</strong></center><br/><br/><center>' . $ttd_kabag . '<br><strong>' . strtoupper($row['status_op_kabag']) . '</strong><br>' . $row['nama_kabag'] . '<br><center></td>
                                <td><strong><center>DIKETAHUI : <BR>General Manager</strong><center>' . $ttd_gm . '<br><strong>' . strtoupper($row['status_op_gm']) . '</strong><br>' . $row['nama_gm'] . '<br></td>
                                    
                            </tr>';
                                
                            }
                        } else {
                            echo '
                                <tr height="100">
                                    <td id="right" rowspan="2"><strong><center>DIBUAT</strong>
                                    
                                    </td>
                                        <td colspan="1"><strong><center>DIKETAHUI</strong>
                                        
                                        </td>
                                    <td colspan="1"><strong><center>DISETUJUI</strong>
                                    </td>
                                </tr>';
                        }
                    } echo '
                </tbody>
            </table>
            <!--div id="lead">
                <p>Kepala Sekolah</p>
                <div style="height: 50px;"></div>';
                    $query = mysqli_query($config, "SELECT kepsek, nip FROM tbl_instansi");
                    list($kepsek, $nip) = mysqli_fetch_array($query);
                    if (!empty($kepsek)) {
                        echo '<p class="lead">' . $kepsek . '</p>';
                    } else {
                        echo '<p class="lead">H. Riza Fachri, S.Kom.</p>';
                    }
                    if (!empty($nip)) {
                        echo '<p>NIP. ' . $nip . '</p>';
                    } else {
                        echo '<p>NIP. -</p>';
                    }
                    echo '
            </div>
        </div-->
        <div class="jarak2"></div>
    <!-- Container END -->

    </body>';
                }
            }
            ?>
