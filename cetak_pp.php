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
        tr, td {
            border: table-cell;
            border: 1px  solid #444;
            line-height: 1;
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
        @media print{
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

                <img class="logodisp" src="./upload/<?= $logo ?>"/>
                <h2 class="up">P P</h2>
                <span id="alamat">( Permintaan Pembelian )</span><br/>
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/></br>

            </div>
            <div class="separator"></div>
            <?php
            $id_pp = mysqli_real_escape_string($config, $_REQUEST['id_pp']);
            $query = mysqli_query($config, "SELECT * FROM tbl_pp WHERE id_pp='$id_pp'");

            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
                    ?>

                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                            </tr>
                            <tr>
                                <td id="right"  width="8%"><strong>No.PP</strong></td>
                                <td id="left" style="border-right" colspan="6">: <?= $row['no_pp'] ?></td>
                                <td id="left" colspan="1"><strong>Tgl.PP</strong> : <?= indoDate($row['tgl_pp']) ?></td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>Target</strong></td>
                                <td id="left" style="border-right" colspan="6">: <?= indoDate($row['target']) ?></td>
                                <td id="left" colspan="1"><strong>Catatan Pembuat</strong> : <?= ucwords(nl2br(htmlentities(strtolower($row['catatan_pp'])))) ?></td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>Divisi</strong></td>
                                <td id="left" style="border-right" colspan="6">: <?= $row['divisi'] ?></td>
                                <td id="left" colspan="1"><strong>File Lampiran</strong> : <?= $row['file'] ?></td>
                            </tr>
                            <tr>
                        </tbody>
                    </table>

                    <table class="bordered" id="tbl">
                        <thead class="blue lighten-4" id="head">
                            <tr>
                                <th width="4%">No</th>
                                <th width="15%">Nama Barang</th>
                                <th width="5%">Jumlah<br/><hr/>Satuan</th>
                        <th width="15%">Keterangan<br/><hr/>Tujuan PP</th>
                        <th width="3%">Disetujui purchasing</th>
                        <th width="11%">Estimasi Harga</th>
                        <th width="12%">Status GM<br/><hr/>Catatan GM</th>
                        <th width="12%">Status Gudang<br/><hr/>Catatan Gudang</th>
                        </tr>
                        </thead>


                        <?php
                        $query2 = mysqli_query($config, "SELECT *, tbl_pp_barang.id_barang as id_barang_detail FROM tbl_pp_barang
                                                                  LEFT JOIN tbl_gm_pp ON tbl_pp_barang.id_pp = tbl_gm_pp.id_pp  and  tbl_pp_barang.id_barang = tbl_gm_pp.id_barang
                                                                  LEFT JOIN tbl_pembelian_realisasi ON tbl_pp_barang.id_pp = tbl_pembelian_realisasi.id_pp and tbl_pp_barang.id_barang = tbl_pembelian_realisasi.id_barang
                                                                  LEFT JOIN tbl_pp_gudang ON tbl_pp_barang.id_pp = tbl_pp_gudang.id_pp and tbl_pp_barang.id_barang = tbl_pp_gudang.id_barang
                                                                  WHERE tbl_pp_barang.id_pp='$id_pp'");
                        if (mysqli_num_rows($query2) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query2)) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords(nl2br(htmlentities(strtolower($row['nama_barang'])))) ?><br/></td>
                                    <td><?= $row['jumlah'] ?><br/><hr/><?= $row['satuan'] ?></td>
                                    <td><?= $row['keterangan_pp'] ?><br/><hr/><?= $row['tujuan_pp'] ?></td>
                                    <td><strong>
                                            <?php
                                            if (!empty($row['jumlah_realisasi'])) {
                                                echo ' <strong>' . $row['jumlah_realisasi'] . '</strong>';
                                            } else {
                                                echo '<em><font color="red">Kosong</font></em>';
                                            }
                                            ?>
                                        </strong><br/><hr/><?= $row['satuan_realisasi'] ?></td>
                                    <td><strong><i><?= $row['harga'] = "Rp " . number_format($row['harga'], 0, ',', '.') ?><br/><hr/><?= $row['jumlah_harga'] = "Rp " . number_format($row['jumlah_harga'], 0, ',', '.') ?></i></strong></td>
                                    <td><strong><?= $row['status_gm'] ?>  <?= $row['waktu'] ?> <br/></strong><hr/><?= ucwords(nl2br(htmlentities(strtolower($row['catatan_gm'])))) ?></td>
                                    <td><strong><?= $row['status_gudang'] ?></strong>  <?= $row['waktu_gudang'] ?> <br/><hr/><?= ucwords(nl2br(htmlentities(strtolower($row['catatan_gudang'])))) ?></td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan.</p></center></td></tr>

                            <?php
                        }
                        ?>
                        <?php
                        $harga_total = mysqli_fetch_array(mysqli_query($config, "SELECT sum(jumlah_harga) as harga_total
                                                                                               FROM tbl_pembelian_realisasi  
                                                                                               WHERE id_pp='$id_pp'"));
                        ?>
                        <table class="bordered" id="tbl" width="100%">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                <th class="right"><i>HARGA TOTAL ESTIMASI : </i><strong><?php echo "Rp " . number_format((float) "$harga_total[harga_total]", 0, '.', '.') ?></strong></th>
                                </thead>
                            </table>
                        </table>

                        <?php
                        $id_pp = mysqli_real_escape_string($config, $_REQUEST['id_pp']);
                        $query7 = mysqli_query($config, "SELECT a.catatan_kabag,
                                                                b.catatan_pembelian, 
                                                                c.catatan_keu 
                                                                FROM tbl_pp d 
                                                 LEFT JOIN tbl_kabag_pp  a ON d.id_pp = a.id_pp
                                                 LEFT JOIN tbl_pembelian b ON d.id_pp = b.id_pp
                                                 LEFT JOIN tbl_kabag_keu c ON d.id_pp = c.id_pp WHERE d.id_pp='$id_pp'");
                        if (mysqli_num_rows($query7) > 0) {
                            $no = 0;
                            while ($row = mysqli_fetch_array($query7)) {
                                ?>

                                <table class="bordered" id="tbl">

                                    <tr><td id="right"><strong>Catatan Kabag</strong></td>
                                        <td id="left" colspan="2">:<?= ucwords(nl2br(htmlentities(strtolower($row['catatan_kabag'])))) ?></td>
                                    </tr>

                                    <tr><td id="right"><strong>Catatan Pembelian</strong></td>
                                        <td id="left" colspan="2">:<?= ucwords(nl2br(htmlentities(strtolower($row['catatan_pembelian'])))) ?></td>
                                    </tr>

                                    <tr><td id="right"><strong>Catatan Mng.Keuangan</strong></td>
                                        <td id="left" colspan="2">:<?= ucwords(nl2br(htmlentities(strtolower($row['catatan_keu'])))) ?></td>
                                    </tr>

                                </table>

                                <?php
                            }
                        }
                        ?>


                        <?php
                        $query3 = mysqli_query($config, "SELECT a.*, 
                                            f.file_ttd                          as ttd,
                                            m.nama,                              
                                            b.status_kabag, b.id_user           as id_kabag_pp, 
                                            d.file_ttd                          as ttd_kabag,
                                            n.nama                              as nama_kabag,
                                            c.status_pembelian, c.id_user       as id_pembelian,
                                            e.file_ttd                          as ttd_pembelian,
                                            o.nama                              as nama_pembelian,
                                            g.status_keu, g.id_user             as id_kabag_keu,
                                            h.file_ttd                          as ttd_keu,
                                            p.nama                              as nama_kabag_keu,
                                            i.terbit_gm, i.id_user              as id_gm_terbit,
                                            j.file_ttd                          as ttd_gm,
                                            q.nama                              as nama_gm,
                                            k.status_gudang_terbit, k.id_user   as id_pp_gudang_terbit,
                                            l.file_ttd                          as ttd_gudang,
                                            r.nama                              as nama_gudang

                                            FROM tbl_pp a
                                            left join tbl_kabag_pp          b on a.id_pp    =   b.id_pp
                                            left join tbl_user_upload       d on b.id_user  =   d.id_user
                                            left join tbl_pembelian         c on a.id_pp    =   c.id_pp
                                            left join tbl_user_upload       e on c.id_user  =   e.id_user
                                            left join tbl_kabag_keu         g on a.id_pp    =   g.id_pp
                                            left join tbl_user_upload       h on g.id_user  =   h.id_user
                                            left join tbl_gm_pp_terbit      i on a.id_pp    =   i.id_pp
                                            left join tbl_user_upload       j on i.id_user  =   j.id_user
                                            left join tbl_pp_gudang_terbit  k on a.id_pp    =   k.id_pp
                                            left join tbl_user_upload       l on k.id_user  =   l.id_user
                                            left join tbl_user_upload       f on a.id_user  =   f.id_user
                                            left join tbl_user              m on a.id_user  =   m.id_user
                                            left join tbl_user              n on b.id_user  =   n.id_user
                                            left join tbl_user              o on e.id_user  =   o.id_user
                                            left join tbl_user              p on p.id_user  =   h.id_user
                                            left join tbl_user              q on q.id_user  =   j.id_user
                                            left join tbl_user              r on r.id_user  =   l.id_user
                                            where a.id_pp='$id_pp'");

                        if (mysqli_num_rows($query3) > 0) {
                            $no = 0;
                            $row = mysqli_fetch_array($query3); {
                                $ttd_kabag = '';
                                $ttd_pembelian = '';
                                $ttd_keu = '';
                                $ttd_gm = '';
                                $ttd_gudang = '';
                                $ttd = '';
                                if ($row['ttd'] != "") {
                                    $ttd = '<img src = "/./upload/ttd/' . $row['ttd'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_kabag'] != "") {
                                    $ttd_kabag = '<img src = "/./upload/ttd/' . $row['ttd_kabag'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_pembelian'] != "") {
                                    $ttd_pembelian = '<img src = "/./upload/ttd/' . $row['ttd_pembelian'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_keu'] != "") {
                                    $ttd_keu = '<img src = "/./upload/ttd/' . $row['ttd_keu'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_gm'] != "") {
                                    $ttd_gm = '<img src = "/./upload/ttd/' . $row['ttd_gm'] . '" style = "width: 80px">';
                                }
                                if ($row['ttd_gudang'] != "") {
                                    $ttd_gudang = '<img src = "/./upload/ttd/' . $row['ttd_gudang'] . '" style = "width: 80px">';
                                }
                                ?>
                                <table class="bordered" id="tbl">
                                    <tr>
                                        <td><strong><center>DIBUAT      : <br><br><center><?= $ttd ?><br><br><?= $row['nama'] ?></center></td>
                                                    <td><strong><center>DISETUJUI   : <br>Kepala Bagian</strong></center><center><?= $ttd_kabag ?><br><?= $row['status_kabag'] ?><br><?= $row['nama_kabag'] ?><br><center></td>
                                                                    <td><strong><center>DIKETAHUI   : <br>Pembelian</strong><center><?= $ttd_pembelian ?><br><br><?= $row['status_pembelian'] ?><br><?= $row['nama_pembelian'] ?><br></td>
                                                                                    <td><strong><center>DIKETAHUI   : <BR>Keuangan</strong><center><br/><br/><?= $ttd_keu ?><br><br><br><?= $row['status_keu'] ?><br><?= $row['nama_kabag_keu'] ?><br></td>  
                                                                                                    <td><strong><center>DISETUJUI   : <BR>GM</strong><center><?= $ttd_gm ?><br><?= $row['terbit_gm'] ?><br><?= $row['nama_gm'] ?><br></td>  
                                                                                                                    <td><strong><center>GUDANG   : <BR>Gudang</strong><center><?= $ttd_gudang ?><br><?= $row['status_gudang_terbit'] ?><br><?= $row['nama_gudang'] ?><br></td>  
                                                                                                                                    </tr>
                                                                                                                                    <?php
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                ?>

                                                                                                                                <tr height="100">
                                                                                                                                    <td id="right" rowspan="2"><strong><center>DIBUAT</strong>  </td>
                                                                                                                                    <td colspan="1"><strong><center>DIKETAHUI</strong> </td>
                                                                                                                                    <td colspan="1"><strong><center>DISETUJUI</strong> </td>
                                                                                                                                    <td colspan="1"><strong><center>DIKETAHUI</strong> </td>
                                                                                                                                    <td colspan="1"><strong><center>DIKETAHUI</strong> </td>
                                                                                                                                    </td>


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
