<?php

//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header("Location: ./");
    die();
} else {

    echo '
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
                <div class="disp">';
    $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
    list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
    echo '<img class="logodisp" src="./upload/' . $logo . '"/>';
    echo '<span id="alamat"><h6><strong></h6></strong> </span>';
    echo '<span id="alamat"><h5><sgtrong>Permintaan Pekerjaan Internal</h5></strong></strong></span>';
    echo '<span id="alamat">PT Graha Pena-Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/></br>';


    echo '
                </div>
                <div class="separator"></div>';

    $id_ppi = mysqli_real_escape_string($config, $_REQUEST['id_ppi']);
    $query = mysqli_query($config, "SELECT * FROM tbl_ppi WHERE id_ppi='$id_ppi'");

    if (mysqli_num_rows($query) > 0) {
        $no = 0;
        while ($row = mysqli_fetch_array($query)) {

            echo '
                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                               
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>No.PPI</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: ' . $row['no_ppi'] . '</td>
                                <td id="left" width="18%"><strong>Tanggal PPI</strong> : ' . indoDate($row['tgl_ppi']) . '</td>
                            </tr>
                              <tr>
                                <td id="right" width="8%"><strong>Nama Peminta</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: ' . $row['nama_peminta'] . '</td>
                                <td id="left" width="18%"><strong>Divisi</strong> : ' . $row['divisi'] .  '</td>
                            </tr>
                            <tr>
                                <td id="right" width="8%"><strong>Tujuan Divisi</strong></td>
                                <td id="left" style="border-right: none;" width="20%">: ' . $row['tujuan_divisi'] . '</td>
                                <td id="left" width="18%"><strong>File</strong> : ' . $row['file'] .  '</td>
                            </tr>
                            <tr>
                             <tr>
                                <td id="right"><strong>Lokasi</strong></td>
                                <td id="left" colspan="2">: ' . $row['lokasi'] . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Permintaan Pekerjaan</strong></td>
                                <td id="left" colspan="2">: ' . nl2br(htmlentities($row['permintaan_pekerjaan'])) .'</td>
                            </tr>
                            <tr>';
            $query3 = mysqli_query($config, "SELECT a.*, f.file_ttd as ttd,
                                                    b.manager, b.id_user as id_approve_ppi, 
                                                    d.file_ttd as ttd_manager,
                                                    c.nama,
                                                    e.nama as nama_manager
                                                    FROM tbl_ppi a
                                       left join tbl_approve_ppi    b on a.id_ppi  = b.id_ppi
                                       left join tbl_user_upload    d on b.id_user = d.id_user
                                       left join tbl_user_upload    f on a.id_user = f.id_user
                                       left join tbl_user           c on a.id_user = c.id_user
                                       left join tbl_user           e on b.id_user = e.id_user
                                       where a.id_ppi='$id_ppi'");
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

                    echo '
                            <tr>
                                <td colspan="2"><strong><center>DIBUAT      : <br/><br/><center>' . $ttd . '<br><br>' . $row['nama'] . '</center></td>
                                <td><strong><center>DISETUJUI   : <br>Kepala Bagian</strong></center><center>' . $ttd_manager . '<br><strong>' .strtoupper($row['manager']) . '</strong><br>' . $row['nama_manager'] . '<br><center></td>

                            </tr>';
                }
            } else {
                echo '
                                <tr height="120">
                                    <td colspan="2"><strong><center>DIBUAT</strong></td>
                                    <!--td colspan="1"><strong><center>DIKETAHUI</strong> </td-->
                                    <td colspan="2"><strong><center>DIKETAHUI</strong></td>
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
