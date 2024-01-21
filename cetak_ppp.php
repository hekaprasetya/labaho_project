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
                <h2 class="up">E - Parkir</h2>
                <span id="alamat">Permintaan Pekerjaan Parkir</span><br/>
                <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/></br>

            </div>
            <div class="separator"></div>
            <?php
            $id_ppp = mysqli_real_escape_string($config, $_REQUEST['id_ppp']);
            $query = mysqli_query($config, "SELECT * FROM tbl_ppp WHERE id_ppp='$id_ppp'");

            if (mysqli_num_rows($query) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query)) {
                    ?>

                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                               
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>No.PPP</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: <?= $row['no_ppp'] ?></td>
                                <td id="left" width="18%"><strong>Tanggal PPP</strong> : <?= indoDate($row['tgl_ppp']) ?></td>
                            </tr>
                            <tr>
                               <td id="right" width="8%"><strong>Lokasi </strong></td>
                                <td id="left" style="border-right: none;" width="20%">: <?= $row['lokasi_ppp'] ?></td>
                                <td id="left" width="18%"><strong>Nama Perusahaan</strong> : <?= $row['nama_perusahaan'] ?></td>
                            </tr>
                             <tr height="100">
                                <td id="right" rowspan="2"><strong>Permintaan Pekerjaan</strong></td>
                                <td id="left" colspan="2">: <?= ucwords(nl2br(htmlentities(strtolower($row['permintaan_pekerjaan'])))) ?></td>
                            </tr>
                            <tr>
                            <tr>
                                <td id="right" rowspan="2"><strong>File :</strong></td>
                                <td id="left" colspan="2">: <?= ucwords(nl2br(htmlentities(strtolower($row['file']))))?></td>
                            </tr>
                            
                            
                            <tr>
                        </tbody>
                    </table>

                    <?php
                    $query3 = mysqli_query($config, "SELECT a.*, 
                                            f.nama, f.file                      as ttd,
                                            b.status_ppp, b.id_user             as id_app_ppp, 
                                            d.nama                              as nama_kabag, 
                                            d.file                              as ttd_kabag,
                                            c.status_ppp_keu, c.id_user         as id_app_ppp_keu,
                                            e.nama                              as nama_keu,
                                            e.file                              as ttd_keu,
                                            g.status_ppp_parkir, g.id_user      as id_app_ppp_parkir,
                                            h.nama                              as nama_adm_parkir,
                                            h.file                              as ttd_parkir
                                           
                                            FROM tbl_ppp a
                                            left join tbl_approve_ppp          b on a.id_ppp    =   b.id_ppp
                                            left join tbl_user                 d on b.id_user  =   d.id_user
                                            left join tbl_approve_ppp_keu      c on a.id_ppp   =   c.id_ppp
                                            left join tbl_user                 e on c.id_user  =   e.id_user
                                            left join tbl_approve_ppp_parkir   g on a.id_ppp    =   g.id_ppp
                                            left join tbl_user                 h on g.id_user  =   h.id_user
                                            left join tbl_user                 f on a.id_user  =   f.id_user
                                            
                                             where a.id_ppp='$id_ppp'");

                    if (mysqli_num_rows($query3) > 0) {
                        $no = 0;
                        $row = mysqli_fetch_array($query3);
                        {
                            $ttd_kabag = '';
                            $ttd_keu = '';
                            $ttd_parkir = '';
                            $ttd = '';
                            if ($row['ttd'] != "") {
                                $ttd = '<img src = "/./upload/ttd/' . $row['ttd'] . '" style = "width: 100px">';
                            }
                            if ($row['ttd_kabag'] != "") {
                                $ttd_kabag = '<img src = "/./upload/ttd/' . $row['ttd_kabag'] . '" style = "width: 100px">';
                            }
                            if ($row['ttd_keu'] != "") {
                                $ttd_keu = '<img src = "/./upload/ttd/' . $row['ttd_keu'] . '" style = "width: 100px">';
                            }
                            if ($row['ttd_parkir'] != "") {
                                $ttd_gm = '<img src = "/./upload/ttd/' . $row['ttd_parkir'] . '" style = "width: 100px">';
                            }
                            ?>
                            <table class="bordered" id="tbl">
                                <tr>
                                    <td><strong><center>DIBUAT      : <br/><center><?= $ttd ?><br><?= $row['nama'] ?></center></td>
                                                <td><strong><center>DISETUJUI   : <br>Kepala Bagian</strong></center><center><?= $ttd_kabag ?><br><?= $row['status_ppp'] ?><br><?= $row['nama_kabag'] ?><br><center></td>
                                                                <td><strong><center>DIKETAHUI   : <BR>Finance Manager</strong><center><?= $ttd_keu ?><br><?= $row['status_ppp_keu'] ?><br><?= $row['nama_keu'] ?><br></td>  
                                                                                <td><strong><center>DIKETAHUI  : <BR>Admin Parkir</strong><center><?= $ttd_parkir ?><br><?= $row['status_ppp_parkir'] ?><br><?= $row['nama_adm_parkir'] ?><br></td>  
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                        } else {
                                                                                            ?>

                                                                                            <tr height="100">
                                                                                                <td id="right" rowspan="2"><strong><center>DIBUAT</strong>  </td>
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
