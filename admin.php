<?php
//cek session
session_start();

if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
}
?>


<!doctype html>
<html lang="en">

<!-- Include Head START -->
<?php include('include/head.php'); ?>

<!-- Include Head END -->

<!-- Body START -->

<body class="bg">

    <!-- Header START -->
    <header>

        <!-- Include Navigation START -->
        <?php include('include/menu.php'); ?>
        <!-- Include Navigation END -->

    </header>
    <!-- Header END -->

    <!-- Main START -->
    <main>


        <!-- container START -->
        <div class="container">

            <?php
            function routePath()
            {

            }
            if (isset($_REQUEST['excel'])) {
                $excel = $_REQUEST['excel'];
                switch ($excel) {
                    case 'excel_cuti':
                        include "excel_cuti_copy.php";
                        break;
                }
            } else {

            }
            if (isset($_REQUEST['page'])) {
                $page = $_REQUEST['page'];
                switch ($page) {
                    case 'usr':
                        include "user.php";
                        break;
                    case 'cal':
                        ?>
                        <script>window.location.href = "bootstrap/calender.php"</script>
                        <?php
                        break;
                    case 'booking':
                        include "booking.php";
                        break;
                    case 'excel_cuti_copy':
                        include "excel_cuti_copy.php";
                        break;
                    case 'cuti_normatif':
                        include "cuti_normatif.php";
                        break;
                    case 'cuti_bersama':
                        include "cuti_bersama.php";
                        break;
                    case 'gaji':
                        include "gaji.php";
                        break;
                    case 'tsm':
                        include "transaksi_surat_masuk.php";
                        break;
                    case 'disposisi':
                        include "disposisi.php";
                        break;
                    case 'tlpt':
                        include "tambah_lpt.php";
                        break;
                    case 'lpt':
                        include "lpt.php";
                        break;
                    case 'lpg':
                        include "lpg.php";
                        break;
                    case 'lpg_gudang':
                        include "lpg_gudang.php";
                        break;
                    case 'lapor':
                        include "lapor.php";
                        break;
                    case 'app_lapor':
                        include "approve_lapor_hkp.php";
                        break;
                    case 'mod':
                        include "mod.php";
                        break;
                    case 'pa':
                        include "permintaan_acara.php";
                        break;
                    case 'ppi':
                        include "ppi.php";
                        break;
                    case 'edit_ppi':
                        include "edit_ppi.php";
                        break;
                    case 'eng':
                        include "engineering.php";
                        break;
                    case 'facility':
                        include "facility.php";
                        break;
                    case 'pp':
                        include "pp.php";
                        break;
                    case 'pp_complete':
                        include "pp_complete.php";
                        break;
                    case 'pp_uncomplete':
                        include "pp_uncomplete.php";
                        break;
                    case 'dashboard_pp':
                        include "dashboard_pp.php";
                        break;
                    case 'ppp':
                        include "ppp.php";
                        break;
                    case 'op':
                        include "op.php";
                        break;
                    case 'invoice':
                        include "invoice.php";
                        break;
                    case 'invoice_all':
                        include "invoice_all.php";
                        break;
                    case 'pengaduan':
                        include "pengaduan.php";
                        break;
                    case 'pengaduan_tenant':
                        include "pengaduan_tenant.php";
                        break;
                    case 'work_order':
                        include "work_order.php";
                        break;
                    case 'work_order_divisi':
                        include "work_order_divisi.php";
                        break;
                    case 't_wo':
                        include "tambah_wo.php";
                        break;
                    case 'master_alat':
                        include "master_alat.php";
                        break;
                    case 'master_utility':
                        include "master_utility.php";
                        break;
                    case 'master_apar':
                        include "master_apar.php";
                        break;
                    case 'master_kendaraan':
                        include "master_kendaraan.php";
                        break;
                    case 'master_pajak':
                        include "master_pajak.php";
                        break;
                    case 'master_supplier':
                        include "master_supplier.php";
                        break;
                    case 'master_pph':
                        include "master_pph.php";
                        break;
                    case 'master_satuan':
                        include "master_satuan.php";
                        break;
                    case 'master_barang':
                        include "master_barang.php";
                        break;
                    case 'master_tenant':
                        include "master_tenant.php";
                        break;
                    case 'master_karyawan':
                        include "master_karyawan.php";
                        break;
                    case 'master_jabatan':
                        include "master_jabatan.php";
                        break;
                    case 'pinjam_alat':
                        include "pinjam_alat.php";
                        break;
                    case 'pinjam_kendaraan':
                        include "pinjam_kendaraan.php";
                        break;
                    case 'kembali_alat':
                        include "kembali_alat.php";
                        break;
                    case 'tdp':
                        include "tambah_disposisi.php";
                        break;
                    case 'tlpg':
                        include "tambah_lpg.php";
                        break;
                    case 't_pinjam_alat':
                        include "tambah_pinjam_alat.php";
                        break;
                    case 'app_lpt_v':
                        include "approve_lpt.php";
                        break;
                    case 'app_lpt':
                        include "tambah_approve_lpt.php";
                        break;
                    case 'app_pa':
                        include "approve_pa.php";
                        break;
                    case 'app_ppi':
                        include "approve_ppi.php";
                        break;
                    case 'app_gm_pp':
                        include "approve_pp_gm.php";
                        break;
                    case 'app_gm':
                        include "approve_pmk_gm.php";
                        break;
                    case 'app_kabag_pp':
                        include "approve_pp_kabag.php";
                        break;
                    case 'app_kabag_opb':
                        include "approve_opb_kabag.php";
                        break;
                    case 'app_petugas_opb':
                        include "approve_opb_petugas.php";
                        break;
                    case 'app_kabag_cuti':
                        include "approve_cuti_kabag.php";
                        break;
                    case 'app_hrd_cuti':
                        include "approve_cuti_hrd.php";
                        break;
                    case 'app_keu_pp':
                        include "approve_pp_keu.php";
                        break;
                    case 'app_pembelian_pp':
                        include "approve_pp_pembelian.php";
                        break;
                    case 'app_lpg':
                        include "approve_lpg.php";
                        break;
                    case 'ctk':
                        include "cetak_disposisi.php";
                        break;
                    case 'verifikasi':
                        include "verifikasi_lpt.php";
                        break;
                    case 'ctk_lpt':
                        include "cetak_lpt.php";
                        break;
                    case 'ctk_pa':
                        include "cetak_pa.php";
                        break;
                    case 'ctk_pa_hasil':
                        include "cetak_pa_hasil.php";
                        break;
                    case 'ctk_ppi':
                        include "cetak_ppi.php";
                        break;
                    case 'ctk_eng':
                        include "cetak_engineering.php";
                        break;
                    case 'ctk_facility':
                        include "cetak_facility.php";
                        break;
                    case 'ctk_pp':
                        include "cetak_pp.php";
                        break;
                    case 'ctk_opb':
                        include "cetak_opb.php";
                        break;
                    case 'ctk_op':
                        include "cetak_op.php";
                        break;
                    case 'ctk_cuti':
                        include "cetak_cuti.php";
                        break;
                    case 'opb':
                        include "opb.php";
                        break;
                    case 'cuti':
                        include "cuti.php";
                        break;
                    case 'ctk_lpg':
                        include "cetak_lpg.php";
                        break;
                    case 'tsk':
                        include "transaksi_surat_keluar.php";
                        break;
                    case 'asm':
                        include "agenda_surat_masuk.php";
                        break;
                    case 'report_lpt':
                        include "report_lpt.php";
                        break;
                    case 'report_pengaduan':
                        include "report_pengaduan.php";
                        break;
                    case 'report_pa':
                        include "report_pa.php";
                        break;
                    case 'report_ppi':
                        include "report_ppi.php";
                        break;
                    case 'report_eng':
                        include "report_engineering.php";
                        break;
                    case 'report_pp':
                        include "report_pp.php";
                        break;
                    case 'report_opb':
                        include "report_opb.php";
                        break;
                    case 'report_facility':
                        include "report_facility.php";
                        break;
                    case 'report_lpg':
                        include "report_lpg.php";
                        break;
                    case 'report_tenant':
                        include "report_tenant.php";
                        break;
                    case 'report_karyawan':
                        include "report_karyawan.php";
                        break;
                    case 'sett':
                        include "pengaturan.php";
                        break;
                    case 'pro':
                        include "profil.php";
                        break;
                    case 'pro_karyawan':
                        include "profil_karyawan.php";
                        break;
                    case 'gsm':
                        include "galeri_sm.php";
                        break;
                    case 'gpa':
                        include "galeri_pa.php";
                        break;
                    case 'gppi':
                        include "galeri_ppi.php";
                        break;
                    case 'gsk':
                        include "galeri_sk.php";
                        break;
                    case 'geng':
                        include "galeri_eng.php";
                        break;
                    case 'gal_fac':
                        include "galeri_facility.php";
                        break;
                    case 'gpp':
                        include "galeri_pp.php";
                        break;
                    case 'galeri_alat':
                        include "galeri_alat.php";
                        break;
                    case 'galeri_master_barang':
                        include "galeri_master_barang.php";
                        break;
                    case 'absen':
                        include "absensi.php";
                        break;
                    case 'genset':
                        include "main_genset.php";
                        break;
                    case 'panel':
                        include "main_panel.php";
                        break;
                    case 'apar':
                        include "main_apar.php";
                        break;
                    case 'ac':
                        include "main_ac.php";
                        break;
                    case 'pompa':
                        include "main_pompa.php";
                        break;
                    case 'chiller':
                        include "main_chiller.php";
                        break;
                }
            } else {
                ?>
                <!-- Row START -->
                <div class="row">

                    <!-- Include Header Instansi START -->
                    <?php include('include/header_instansi.php'); ?>

                    <!-- Include Header Instansi END -->

                    <!-- Welcome Message START -->
                    <div class="col s12">
                        <div class="card card1 white-text">
                            <div class="card-content">

                                <h4 class="center" style="font-family: 'Barlow Condensed', sans-serif;font-weight:400">
                                    Selamat Datang "
                                    <?php echo $_SESSION['nama']; ?>"
                                </h4>
                                <?php
                                // Ambil data cuaca dari API
                                $weatherData = file_get_contents('https://api.weatherapi.com/v1/current.json?key=88b00f6f3bc046cdb3a153709231309&q=Surabaya&aqi=no');

                                if ($weatherData === false) {
                                    echo 'Gagal mengambil data cuaca dari API';
                                } else {
                                    // Parse data JSON
                                    $weatherData = json_decode($weatherData);

                                    // Ambil lokasi, suhu, dan waktu
                                    $lokasi = $weatherData->location->name;
                                    $suhu = $weatherData->current->temp_c;
                                    $waktu = $weatherData->current->last_updated;
                                    $kondisiCuaca = strtolower($weatherData->current->condition->text);
                                    $icon = $weatherData->current->condition->icon; // Ambil ikon cuaca
                            
                                    // Mapping kondisi cuaca dalam bahasa Inggris ke Bahasa Indonesia
                                    $terjemahanCuaca = [
                                        'sunny' => 'cerah',
                                        'clear' => 'cerah',
                                        'partly cloudy' => 'sedikit berawan',
                                        'cloudy' => 'berawan',
                                        'overcast' => 'mendung',
                                        'rain' => 'hujan',
                                        'showers' => 'hujan deras',
                                        'thunderstorm' => 'badai petir',
                                        'snow' => 'salju', // Kondisi cuaca salju
                                        'fog' => 'kabut', // Kondisi cuaca kabut
                                        'windy' => 'berangin',
                                        'mist' => 'BerKabut' // Kondisi cuaca berangin
                                        // Anda bisa menambahkan lebih banyak mapping untuk kondisi cuaca lainnya sesuai kebutuhan
                                    ];
                                    $iconCuaca = [
                                        'sunny' => 'sunny',
                                        'clear' => 'sunny',
                                        'partly cloudy' => 'cloudy',
                                        'cloudy' => 'cloudy',
                                        'rain' => 'rainy',
                                        'showers' => 'rainy',
                                        'thunderstorm' => 'stormy',
                                        'overcast' => 'cloudy',
                                        'snow' => 'snowy',
                                        'fair' => 'rainbow'
                                        // Anda bisa menambahkan lebih banyak mapping untuk kondisi cuaca lainnya sesuai kebutuhan
                                    ];

                                    // Terjemahkan kondisi cuaca ke Bahasa Indonesia
                                    $terjemahanKondisiSaatIni = isset($terjemahanCuaca[$kondisiCuaca]) ? $terjemahanCuaca[$kondisiCuaca] : 'tidak diketahui';
                                    $iconCuacaTerjemah = isset($iconCuaca[$kondisiCuaca]) ? $iconCuaca[$kondisiCuaca] : '';
                                    $jam = date("H");
                                    if ($jam > 18 || $jam < 6) {
                                        $iconCuacaTerjemah = "starry";
                                    }
                                }
                                ?>

                                <div class="row keranjang center-align">
                                    <div class="col s12  l3 weather-card">
                                        <div class="wet1">
                                            <h5 class="card-title">
                                                <?= $lokasi ?>
                                            </h5>
                                            <p class="temperature">
                                                <?= $suhu; ?>°C
                                            </p>
                                            <p class="cuaca">
                                                <?= $kondisiCuaca; ?>
                                            </p>
                                        </div>

                                        <div class="wet2">
                                            <?php
                                            if (empty($iconCuacaTerjemah)) {
                                                ?>
                                                <div>
                                                    <img class="weather-icon2" src="<?= $icon; ?>" alt="cuaca">
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="<?= $iconCuacaTerjemah ?>">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="no-padding">
                                        <p class="time-text"><span>
                                                <?= date("g:i") ?>
                                            </span><span class="time-sub-text">
                                                <?= date("A"); ?>
                                            </span></p>
                                        <p class="day-text">
                                            <?= date("l, M-d"); ?>
                                        </p>
                                    </div>



                                    <?php
                                    $hour = date("H");
                                    $dayOfWeek = date("N");

                                    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
                                        if ($hour >= 8 && $hour < 12) {
                                            $gif = "Work Time";
                                        } elseif ($hour >= 12 && $hour < 13) {
                                            $gif = "Break Time";
                                        } elseif ($hour >= 13 && $hour < 17) {
                                            $gif = "Work Time";
                                        } else {
                                            $gif = "Back Home";
                                        }
                                    } else {
                                        $gif = "Day Off";
                                    }
                                    ?>
                                    <img class="gif" src="./asset/gif/<?= $gif ?>.gif" />



                                    <!--p class="description">Anda login sebagai
                                    <?php
                                    if ($_SESSION['admin'] == 1) {
                                        echo "<strong>Super Admin</strong>. Anda memiliki akses penuh terhadap sistem.";
                                    } elseif ($_SESSION['admin'] == 19 and $_SESSION['admin'] == 11) {
                                        echo "<strong>Administrator</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                    } else {
                                        echo "<strong></strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                    }
                                    ?></p-->

                                </div>
                            </div>
                        </div>

                        <!-- Welcome Message END -->
                        <?php if ($_SESSION['admin'] != 19 and $_SESSION['admin'] != 11) { ?>
                            <!--div class="col s12 absensi">
                                    <div class="card card-panel col s12" style="background: none; border-radius: 8px; padding:8px;">
                                        <div class="card-content card2 grey lighten-5" style="border-radius: 8px;">
                                            <?php
                                            $id_user = $_SESSION['id_user'];
                                            // Membuat query SQL
                                            $query = mysqli_query($conn, "SELECT * FROM tbl_absen WHERE id_user = '$id_user' AND DATE(tanggal) = CURDATE()");
                                            $row = $query->fetch_assoc();
                                            ?>
                                            <h5 class="black-text link" style="font-weight:500;"><i class="material-icons">alarm</i>
                                                <?php
                                                if ($query->num_rows == null) {
                                                    echo "Absen Masuk";
                                                } else {
                                                    echo ($row['status_absen'] == "Sudah Pulang") ? "Selamat Istirahat" : "Absen Pulang";
                                                }

                                                ?>
                                            </h5>
                                            <?php
                                            $nama = $_SESSION['nama'];

                                            if ($query->num_rows == null) {
                                                echo '<button class="btn waves-effect waves-light light-blue" style="border-radius:7px;" onclick="window.location.href=\'?page=absen&act=add\'">Absen</button>';
                                            } else {
                                                $id_absen = $row['id_absen'];
                                                echo ($row['status_absen'] != "Sudah Pulang") ? '<button class="btn waves-effect waves-light light-blue" style="border-radius:7px;"onclick="window.location.href=\'?page=absen&act=pulang&id_absen=' . $id_absen . '\'">Absen</button>' : '';
                                            }
                        }
                        ?>
                                        </div>
                                    </div>
                                </div-->
                        <?php
                        //   CHART BOOKING 
                        $table = 'tbl_pesanan'; // nama table
                        $tgl = 'tanggal'; // tanggal (timestamp)
                        // BOOKING
                        $bulan = chartAdmin($config, $table, $tgl);
                        $chartId = 1;
                        // PAKET
                        $bulanPaket = chartAdminPaket($config, $table, $tgl);
                        $chartIdPaket = 2;
                        ?>

                        <div class="col s12 m6">
                            <div class="card" style="background: none; border-radius: 15px; padding:16px;">
                                <div class="card-content card2 grey lighten-5" style="border-radius: 8px;">
                                    <h5 class="card-title black-text"> Data Booking </h5>
                                    <div class="row">
                                        <canvas id="chart-<?= $chartId ?>"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="card" style="background: none; border-radius: 15px; padding:16px;">
                                <div class="card-content card2 grey lighten-5" style="border-radius: 8px;">
                                    <h5 class="card-title black-text"> Data Paket </h5>
                                    <div class="row">
                                        <canvas id="chart-<?= $chartIdPaket ?>"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="node_modules/chart.js/dist/chart.umd.js"></script>
                        <script src="asset/js/chartCustom.js"></script>
                        <script>
                            var dataBulan = <?= json_encode($bulan) ?>;
                            var chartId = '<?= $chartId ?>';
                            var dataBulanPaket = <?= json_encode($bulanPaket) ?>;
                            var chartIdPaket = '<?= $chartIdPaket ?>';
                            chartAdminJs(dataBulan, chartId);
                            chartAdminJs(dataBulanPaket, chartIdPaket);
                        </script>
                        <!-- CHART END -->
                        <?php if ($_SESSION['admin'] != 19 and $_SESSION['admin'] != 11) { ?>
                            <div class="col s12">
                                <div class="card card-panel" style="background: none; border-radius: 15px;padding:16px;">
                                    <center>
                                        <marquee behavior="alternatif" bgcolor="transparent">
                                            <?php
                                            $images = glob("upload/iklan/*.*");
                                            for ($i = 0; $i < count($images); $i++) {
                                                $single_image = $images[$i];
                                                ?>
                                                <img src="<?php echo $single_image; ?>" width="80" height="80" />
                                                <?php
                                            }
                        }
                        ?>
                                    </marquee>
                                </center>
                            </div>
                        </div>



                        <!-- Info Statistic START -->




                        <?php if ($_SESSION['admin'] == 19 | $_SESSION['admin'] == 11) { ?>
                            <div class="container">
                                <div class="col s12 m4">
                                    <div class="card card-panel" style="background: none; border-radius: 15px;padding:16px;">
                                        <div class="card-content card2 grey lighten-5" style="border-radius: 8px;">
                                            <h4>
                                                <center>PT Graha Pena Jawa Pos</center>
                                            </h4>
                                        </div>
                                        <br />
                                        <center>
                                            <marquee behavior="alternatif" bgcolor="white">
                                                <?php
                                                $images = glob("upload/iklan/*.*");
                                                for ($i = 0; $i < count($images); $i++) {
                                                    $single_image = $images[$i];
                                                    ?>
                                                    <img src="<?php echo $single_image; ?>" width="100" height="100" />
                                                    <?php
                                                }
                                                ?>
                                            </marquee>
                                        </center>
                                    </div>
                                </div>
                            </div>



                            <!-- Info Statistic START -->
                            <?php
                        }
                        ?>

                    </div>
                    <!-- Welcome Message END -->

                </div>
                <!-- Row END -->
                <?php
            }
            ?>
        </div>
        <!-- container END -->

    </main>
    <!-- Main END -->

    <div class="loader" id="loader">
        <!-- <div class="boxes">
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div> -->
        <div class="spinner"></div>
    </div>
    <!-- Include Footer START -->
    <?php require('include/footer.php'); ?>
    <!-- Include Footer END -->


</body>
<!-- Body END -->
<!-- font expletus Sans -->
<!-- <script type="text/javascript">
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
    </script>IE=internet explorer 4+ dan NS=netscape 4+0 -->
<!-- Javascript END -->

<noscript>
    <meta http-equiv="refresh" content="0;URL='/enable-javascript.html'" />
</noscript>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@100;300;400;500;600&family=Bebas+Neue&family=Expletus+Sans:ital,wght@0,400;0,600;1,400;1,500&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&family=Urbanist:wght@100;200;400;600&display=swap');
</style>


</html>