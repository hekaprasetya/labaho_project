<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    ?>
    <style type="text/css">
        .hidd {
            display: none
        }
        @media print{
            body {
                font-size: 12px!important;
                color: #212121;
            }
            .disp {
                text-align: center;
                margin: -.5rem 0;
                width: 100%;
            }
            nav {
                display: none
            }
            .hidd {
                display: block
            }
            .logodisp {
                position: absolute;
                width: 80px;
                height: 80px;
                left: 50px;
                margin: 0 0 0 1.2rem;
            }
            .up {
                font-size: 17px!important;
                font-weight: normal;
                margin-top: 45px;
                text-transform: uppercase
            }
            #nama {
                font-size: 20px!important;
                text-transform: uppercase;
                margin-top: 5px;
                font-weight: bold;
            }
            .status {
                font-size: 17px!important;
                font-weight: normal;
                margin-top: -1.5rem;
            }
            #alamat {
                margin-top: -15px;
                font-size: 13px;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: 1rem 0;
            }
        }
    </style>
    <?php
    if (isset($_REQUEST['submit'])) {

        $dari_tanggal = $_REQUEST['dari_tanggal'];
        $sampai_tanggal = $_REQUEST['sampai_tanggal'];

        if ($_REQUEST['dari_tanggal'] == "" || $_REQUEST['sampai_tanggal'] == "") {
            header("Location: ./admin.php?page=report_cuti");
            die();
        } else {

            $query1 = "SELECT a.*,
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
                                                        WHERE DATE(tgl_cuti) BETWEEN '$dari_tanggal' AND '$sampai_tanggal'";
            
            $query = mysqli_query($config, $query1);
            $query2 = mysqli_query($config, "SELECT nama FROM tbl_instansi");
            list($nama) = mysqli_fetch_array($query2);
            ?>
            <!-- SHOW DAFTAR AGENDA -->
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <div class="z-depth-1">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <div class="col 12">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="?page=cuti&act=report" class="judul"><i class="material-icons">print</i> Cetak Laporan E-CUTI<a></li>
                                                    </ul>
                                                    </div>
                                                    </div>
                                                    </nav>
                                                    </div>
                                                    </div>
                                                    <!-- Secondary Nav END -->
                                                    </div>
                                                    <!-- Row END -->

                                                    <!-- Row form Start -->
                                                    <div class="row jarak-form black-text">
                                                        <form class="col s12" method="post" action="">
                                                            <div class="input-field col s8">
                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                <input id="dari_tanggal" type="text" name="dari_tanggal" id="dari_tanggal" required>
                                                                <label for="dari_tanggal">Dari Tanggal</label>
                                                            </div>
                                                            <div class="input-field col s8">
                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                                                                <label for="sampai_tanggal">Sampai Tanggal</label>
                                                            </div>
                                                            <div class="col s6">
                                                                <button type="submit" name="submit" class="btn small blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- Row form END -->

                                                    <div class="row agenda">
                                                        <div class="disp hidd">
                                                            <?php
                                                            $query2 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                                                            list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query2);
                                                            ?>
                                                            <span></span><br/>
                                                            <img class="logodisp" src="./upload/<?= $logo ?>"/>
                                                            <span></span><br/>
                                                            <span><h6>LAPORAN E - CUTI</h6></span><br/>
                                                            <span id="alamat">PT Graha Pena Jawa Pos Jl.Ayani No: 88, Surabaya</span><br/>

                                                        </div>
                                                        <div class="separator"></div>
                                                        <div class="col s10">
                                                            <p class="warna agenda">Laporan dari tanggal <strong><?= indoDate($dari_tanggal) ?></strong> sampai dengan tanggal <strong><?= indoDate($sampai_tanggal) ?></strong></p>
                                                        </div>
                                                         <div class="col s6">
                                                            <a class="btn-large red" type="submit" onClick="window.print()">
                                                                <i class="material-icons"></i>pdf</a>
                                                             <?php
                                                            // Menggunakan fungsi untuk menghasilkan dan mengunduh file CSV
                                                            $date = date('d-m-y');
                                                            $date = str_replace(".", "", $date);
                                                            $fileName = "Laporan-cuti1-" . $date . ".csv";

                                                            // Menambahkan header 
                                                            $header = array(
                                                                "No",
                                                                "No.Form",
                                                                "Tanggal",
                                                                "Nama",
                                                                "Jabatan",
                                                                "HP",
                                                                "Tgl.Cuti",
                                                                "Akhir Cuti",
                                                                "Jumlah Hari",
                                                                "Di Setujui",
                                                                "Disetujui.Kabag",
                                                                "Disetujui.HRD",
                                                                "Dibuat"
                                                            );

                                                            // Mengambil hasil dari query
                                                            $res = mysqli_query($config, $query1);
                                                            $no = 1;

                                                            // Inisialisasi dataArray di luar loop
                                                            $dataArray = array();

                                                            while ($row = $res->fetch_assoc()) {
                                                                $dataArray[] = array(
                                                                    $no, $row['no_form'],
                                                                    date('Y-m-d'),
                                                                    $row['nama'],
                                                                    $row['jabatan'],
                                                                    $row['no_hp'],
                                                                    $row['tgl_cuti'],
                                                                    $row['akhir_cuti'],
                                                                    $row['jumlah_hari'],
                                                                    (!empty($row['jumlah_trm'])) ? $row['jumlah_trm'] : 'Kosong',
                                                                    (!empty($row['status_cuti_kabag'])) ? "{$row['status_cuti_kabag']}{$row['waktu_cuti_kabag']}" : 'Kabag Kosong',
                                                                    (!empty($row['status_cuti_hrd'])) ? "{$row['status_cuti_hrd']}{$row['status_cuti_hrd']}" : 'Kabag Kosong',
                                                                    $row['nama']
                                                                );
                                                                $no++;
                                                            }
                                                            ?>

                                                            <form action="excel_report.php" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="header" value="<?= htmlspecialchars(json_encode($header)) ?>">
                                                                <input type="hidden" name="dataArray" value="<?= htmlspecialchars(json_encode($dataArray)) ?>">
                                                                <input type="hidden" name="fileName" value="<?= htmlspecialchars($fileName) ?>">
                                                                <button type="submit" class="btn-large green">excel <i class="material-icons"></i></button>
                                                            </form>
                                                        </div>
                                                        <!-- CHART START -->
                                                    <canvas id="chart" width="250" height="120"></canvas>
                                                    <?php
                                                    $table = 'tbl_cuti'; // nama table
                                                    $id = 'id_cuti'; //id table
                                                    $tgl = 'tgl_cuti'; // tanggal (timestamp)
                                                    // Hitung jumlah surat per bulan
                                                    $bulan = chart($conn, $dari_tanggal, $sampai_tanggal, $table, $id, $tgl);
                                                    ?>
                                                    <script src="node_modules/chart.js/dist/chart.umd.js"></script>
                                                    <script>
                                                        const ctx = document.querySelector("#chart").getContext("2d");
                                                        const data = <?= json_encode($bulan) ?>;
                                    
                                                        // Pisahkan data menjadi label bulan dan data jumlah surat
                                                        const bulan = data.map((item) => item[0]);
                                                        const jumlahSurat = data.map((item) => item[1]);
                                    
                                                        const angkaTerbesar = Math.max(...jumlahSurat);
                                                        const angkaTerkecil = Math.min(...jumlahSurat);
                                                        const backgroundColors = [];
                                                        const borderColors = [];
                                    
                                                        const chartAreaBorder = {
                                                            id: "chartAreaBorder",
                                                            beforeDraw(chart, args, options) {
                                                                const {
                                                                    ctx,
                                                                    chartArea: {
                                                                        left,
                                                                        top,
                                                                        width,
                                                                        height
                                                                    },
                                                                } = chart;
                                                                ctx.save();
                                                                ctx.strokeStyle = options.borderColor;
                                                                ctx.lineWidth = options.borderWidth;
                                                                ctx.setLineDash(options.borderDash || []);
                                                                ctx.lineDashOffset = options.borderDashOffset;
                                                                ctx.strokeRect(left, top, width, height);
                                                                ctx.restore();
                                                            },
                                                        };
                                    
                                                        // genered color
                                                        for (let i = 0; i < 12; i++) {
                                                            const r = Math.floor(Math.random() * 256);
                                                            const g = Math.floor(Math.random() * 256);
                                                            const b = Math.floor(Math.random() * 256);
                                    
                                                            const backgroundColor = `rgba(${r}, ${g}, ${b}, 0.2)`;
                                                            backgroundColors.push(backgroundColor);
                                    
                                                            // Buat warna border dengan opasitas penuh (1.0)
                                                            const borderColor = `rgba(${r}, ${g}, ${b}, 1.0)`;
                                                            borderColors.push(borderColor);
                                                        }
                                    
                                                        // Tentukan opacity yang berbeda untuk angkaTerbesar dan angkaTerkecil
                                                        for (let i = 0; i < jumlahSurat.length; i++) {
                                                            if (Math.abs(jumlahSurat[i] - angkaTerbesar) < 0.1) {
                                                                backgroundColors[i] = "rgba(0, 0, 255, 0.7)"; // Ganti warna biru untuk angkaTerbesar
                                                                borderColors[i] = "rgba(0, 0, 255, 1.0)"; // Ganti warna biru untuk angkaTerbesar
                                                            }
                                                            if (Math.abs(jumlahSurat[i] - angkaTerkecil) < 0.1) {
                                                                backgroundColors[i] = "rgba(255, 0, 0, 0.7)"; // Ganti warna merah untuk angkaTerkecil
                                                                borderColors[i] = "rgba(255, 0, 0, 1.0)"; // Ganti warna merah untuk angkaTerkecil
                                                            }
                                                        }
                                                        const isMobile = window.innerWidth <= 600; // Ubah nilai 600 sesuai dengan batas lebar layar untuk perangkat mobile
                                                        let delayed;
                                                        const myChart = new Chart(ctx, {
                                                            type: "bar",
                                                            data: {
                                                                labels: bulan,
                                                                datasets: [{
                                                                    label: "Data Surat",
                                                                    data: data.map((item) => item[1]),
                                                                    backgroundColor: "rgba(0, 128, 255, 0.6)",
                                                                    borderColor: "rgba(0, 128, 255, 1.0)",
                                                                    borderWidth: 1.5,
                                                                }],
                                                            },
                                                            options: {
                                                                scales: {
                                                                    y: {
                                                                        beginAtZero: true,
                                                                    },
                                                                },
                                                                animation: {
                                                                    onComplete: () => {
                                                                        delayed = true;
                                                                    },
                                                                    delay: (context) => {
                                                                        let delay = 0;
                                                                        if (context.type === "data" || context.type === "tooltip" || context.type === "legend" && !delayed) {
                                                                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                                                        }
                                                                        return delay;
                                                                    },
                                                                },
                                                                plugins: {
                                                                    chartAreaBorder: {
                                                                        borderColor: "blue",
                                                                        borderWidth: 2,
                                                                        borderDash: [5, 5],
                                                                        borderDashOffset: 2,
                                                                    },
                                                                },
                                                                indexAxis: isMobile ? "y" : "x", // Memilih sumbu indeks berdasarkan lebar layar
                                                                responsive: true,
                                                            },
                                                            plugins: [chartAreaBorder],
                                                        });
                                                        // Update the chart
                                                        myChart.render();
                                                    </script>
                                                    <!-- CHART END -->
                                                    </div>
                                                    <div id="colres" class="warna cetak">
                                                        <table class="bordered" id="tbl" width="100%">
                                                            <thead class="blue lighten-1">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th width="15%">No.Form<br/><hr/>
                                                                        Tanggal</th>
                                                                        <th width="20%">Nama<br/><hr/>
                                                                        Jabatan</th>
                                                                        <th width="15%">No.HP</th>
                                                                        <th width="10%">Tgl.Cuti<br/><hr/>
                                                                        Akhir Cuti</th>
                                                                        <th width="10%">Jumlah Hari<br/><hr/>
                                                                        Di Setujui</th>
                                                                        <th width="20%">Disetujui.Kabag<br/><hr/>
                                                                        Disetujui.HRD</th>
                                                                        <th width="10%">Dibuat</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                <?php
                                                                if (mysqli_num_rows($query) > 0) {
                                                                    $no = 0;
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        $no++;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $no ?></td>
                                                                            <td><strong><i><?= $row['no_form'] ?><br/><hr/><?= indoDate(date('Y-m-d')) ?></td>
                                                                                        <td><?= $row['nama'] ?><br/><hr/><?= $row['jabatan'] ?></td>
                                                                                        <td><?= $row['no_hp'] ?></td>
                                                                                        <td><?= indoDate($row['tgl_cuti']) ?><br/><hr/><?= indoDate($row['akhir_cuti']) ?></td>
                                                                                        <td><?= $row['jumlah_hari'] ?><br/><hr/><?= $row['jumlah_trm'] ?></td>
                                                                                        <td>
                                                                                            <?php
                                                                                            if (!empty($row['status_cuti_kabag'])) {
                                                                                                ?>
                                                                                                <strong><?= $row['status_cuti_kabag'] ?></a></strong>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <font color="red"><i>Kabag Kosong</i></font>
                                                                                                <?php
                                                                                            }
                                                                                            ?>, <br>
                                                                                            <?= $row['waktu_cuti_kabag'] ?>
                                                                                            <br/><hr/>
                                                                                            <?php
                                                                                            if (!empty($row['status_cuti_hrd'])) {
                                                                                                ?> <strong><?= $row['status_cuti_hrd'] ?></a></strong>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?> 
                                                                                                <font color="red"><i>HRD Kosong</i></font>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                            , <br>
                                                                                            <?= $row['waktu_cuti_hrd'] ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $id_user = $row['id_user'];
                                                                                            $query3 = mysqli_query($config, "SELECT nama FROM tbl_user WHERE id_user='$id_user'");

                                                                                            list($nama) = mysqli_fetch_array($query3);
                                                                                            {
                                                                                                $row['id_user'] = '' . $nama . '';
                                                                                            }
                                                                                            ?>
                                                                                    <?= $row['id_user'] ?>
                                                                                        </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                } else {
                                                                                    ?>
                                                                                    <tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>      
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                </tbody>
                                                                                </table>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <!-- Row Start -->
                                                                            <div class="row">
                                                                                <!-- Secondary Nav START -->
                                                                                <div class="col s12">
                                                                                    <div class="z-depth-1">
                                                                                        <nav class="secondary-nav">
                                                                                            <div class="nav-wrapper blue darken-2">
                                                                                                <div class="col 12">
                                                                                                    <ul class="left">
                                                                                                        <li class="waves-effect waves-light"><a href="?page=cuti&act=report" class="judul"><i class="material-icons">print</i> Cetak Laporan E-CUTI<a></li>
                                                                                                                    </ul>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </nav>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    <!-- Secondary Nav END -->
                                                                                                                    </div>
                                                                                                                    <!-- Row END -->

                                                                                                                    <!-- Row form Start -->
                                                                                                                    <div class="row jarak-form black-text">
                                                                                                                        <form class="col s12" method="post" action="">
                                                                                                                            <div class="input-field col s8">
                                                                                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                                                                                <input id="dari_tanggal" type="text" name="dari_tanggal" id="dari_tanggal" required>
                                                                                                                                <label for="dari_tanggal">Dari Tanggal</label>
                                                                                                                            </div>
                                                                                                                            <div class="input-field col s8">
                                                                                                                                <i class="material-icons prefix md-prefix">date_range</i>
                                                                                                                                <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                                                                                                                                <label for="sampai_tanggal">Sampai Tanggal</label>
                                                                                                                            </div>
                                                                                                                            <div class="col s6">
                                                                                                                                <button type="submit" name="submit" class="btn small blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                                                                                                                            </div>
                                                                                                                        </form>
                                                                                                                    </div>
                                                                                                                    <!-- Row form END --><?php
                                                                                                                }
                                                                                                            }
                                                                                                            ?>

