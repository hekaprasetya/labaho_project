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

        @media print {
            body {
                font-size: 12px !important;
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
                font-size: 17px !important;
                font-weight: normal;
                margin-top: 45px;
                text-transform: uppercase
            }

            #nama {
                font-size: 20px !important;
                text-transform: uppercase;
                margin-top: 5px;
                font-weight: bold;
            }

            .status {
                font-size: 17px !important;
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
            header("Location: ./admin.php?page=report_pengaduan");
            die();
        } else {

            $query = mysqli_query($config, "SELECT a.*,
                                                                    b.nama,nama_tenant,
                                                                    c.id_approve_pengaduan,status_pengaduan,waktu_ttd_pengaduan,kategori_masalah,
                                                                    d.status_kepuasan
                                                                    FROM tbl_pengaduan a
                                                                    LEFT JOIN tbl_user b
                                                                    ON a.id_user=b.id_user
                                                                    LEFT JOIN tbl_approve_pengaduan c
                                                                    ON a.id_pengaduan=c.id_pengaduan
                                                                    LEFT JOIN tbl_kepuasan d
                                                                    ON a.id_pengaduan=d.id_pengaduan
                                                          
                                                          WHERE tgl_pengaduan
                                    BETWEEN '$dari_tanggal' AND '$sampai_tanggal' ");

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
                            <div class="nav-wrapper blue-grey darken-1">
                                <div class="col 12">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="?page=report_pengaduan" class="judul"><i class="material-icons">print</i> Cetak Laporan Pengaduan<a></li>
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
                        <i class="material-icons prefix md-prefix">event</i>
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
                    $query5 = mysqli_query($config, "SELECT institusi, nama, status, alamat, logo FROM tbl_instansi");
                    list($institusi, $nama, $status, $alamat, $logo) = mysqli_fetch_array($query5)
                    ?>
                    <span></span><br />
                    <img class="logodisp" src="./upload/<?= $logo ?>" />
                    <span></span><br />
                    <span>
                        <h6>LAPORAN E - PENGADUAN</h6>
                    </span><br />
                    <span id="alamat">PT Graha Pena-Jawa Pos Jl.Ayani No: 88, Surabaya</span><br />

                </div>
                <div class="separator"></div>
                <div class="col s10">
                    <p class="warna agenda">Laporan dari tanggal <strong><?= indoDate($dari_tanggal) ?></strong> sampai dengan tanggal <strong><?= indoDate($sampai_tanggal) ?></strong></p>
                </div>
                <div class="col s6">
                    <a class="btn-large red" type="submit" onClick="window.print()">
                        <i class="material-icons"></i>pdf</a>
                </div>
                <?php
                $mobileH = "180";
                $mobileW = "200";
                ?>
                <!-- CHART START -->

                <canvas id="chart"></canvas>
                <canvas id="chart_kepuasan"></canvas>
                <canvas id="chart_kategori"></canvas>


                <?php
                // PENGADUAN
                $table = 'tbl_pengaduan'; // nama table
                $id = 'id_pengaduan'; //id table
                $tgl = 'tgl_pengaduan'; // tanggal (timestamp)

                // Hitung jumlah surat per bulan
                $bulan = chart($conn, $dari_tanggal, $sampai_tanggal, $table, $id, $tgl);
                ?>
                <script src="node_modules/chart.js/dist/chart.umd.js"></script>
                
                <script>
                    const ctx = document.querySelector("#chart").getContext("2d");
                    const data = <?= json_encode($bulan) ?>;
                    console.log(data);
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
                        if (Math.abs(jumlahSurat[i] - angkaTerkecil) < 0.) {
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
                                backgroundColor: "rgba(128,0,0)",
                                borderColor: "rgba(128,0,0)",
                                borderWidth: 2,
                                
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
                                    borderColor: "brown",
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    borderDashOffset: 2,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Data Surat'
                            },
                            // indexAxis: isMobile ? "y" : "x", // Memilih sumbu indeks berdasarkan lebar layar
                            responsive: true,
                        },
                        plugins: [chartAreaBorder],
                    });
                </script>
                <br/>
                <?php
                // KEPUASAN
                $table = 'tbl_kepuasan'; // Nama tabel
                $tgl = 'tgl_kepuasan'; // Kolom tanggal (timestamp)
                $status_column = 'status_kepuasan'; // Kolom status kepuasan
                $bulan_kepuasan = chartkepuasan($conn, $dari_tanggal, $sampai_tanggal, $table, $tgl, $status_column);

                ?>
                <script>
                    const ctx_kepuasan = document.querySelector("#chart_kepuasan").getContext("2d");
                    const data_kepuasan = <?= json_encode($bulan_kepuasan) ?>;
                    console.log(data_kepuasan);
                    // Pisahkan data menjadi label bulan dan data jumlah surat
                    const bulan_kepuasan = data_kepuasan.map((item) => item[0]);
                    const jumlahSuratPuas_kepuasan = data_kepuasan.filter(item => item[1]).map((item) => item[1]);
                    const jumlahSuratTidakPuas_kepuasan = data_kepuasan.filter(item => item[1]).map((item) => item[2]);
                    // console.log(jumlahSuratTidakPuas_kepuasan);
                    // console.log(jumlahSuratPuas_kepuasan);

                    // Perbaikan pada console.log
                    console.log(data_kepuasan.filter(item => item[1]).map((item) => item[1])); // Mencetak semua nilai dari kolom dengan indeks 2

                    const myChart_kepuasan = new Chart(ctx_kepuasan, {
                        type: "bar",
                        data: {
                            labels: bulan_kepuasan,
                            datasets: [{
                                    label: "Tidak Puas",
                                    data: jumlahSuratTidakPuas_kepuasan,
                                    backgroundColor: "rgba(255,0,0)", // Warna biru dengan opasitas 0.6
                                    borderColor: "rgba(255,0,0)", // Warna biru dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }, {
                                    label: "Puas",
                                    data: jumlahSuratPuas_kepuasan,
                                    backgroundColor: "rgba(0, 128, 255, 0.6)", // Warna merah dengan opasitas 0.6
                                    borderColor: "rgba(0, 128, 255, 1.0)", // Warna merah dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }

                            ],
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
                                tooltip: {
                                    callbacks: {
                                        label: (context) => {
                                            const label = context.dataset.label || '';
                                            const value = context.parsed.y;
                                            return `${label}: ${value}`;
                                        },
                                    },
                                },
                                chartAreaBorder: {
                                    borderColor: "red",
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    borderDashOffset: 2,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Data Kepuasan'
                            },
                            // indexAxis: isMobile ? "y" : "x", // Memilih sumbu indeks berdasarkan lebar layar
                            responsive: true,
                        },
                        plugins: [chartAreaBorder],
                    });
                </script>
                
                 <?php
                // KATEGORI
                $table = 'tbl_approve_pengaduan'; // Nama tabel
                $tgl = 'waktu_ttd_pengaduan'; // Kolom tanggal (timestamp)
                $status_column = 'kategori_masalah'; // Kolom status kategori
                $bulan_kategori = chartkategori($conn, $dari_tanggal, $sampai_tanggal, $table, $tgl, $status_column);

                ?>
                <script>
                    const ctx_kategori = document.querySelector("#chart_kategori").getContext("2d");
                    const data_kategori = <?= json_encode($bulan_kategori) ?>;
                    console.log(data_kategori);
                    // Pisahkan data menjadi label bulan dan data jumlah surat
                    const bulan_kategori = data_kategori.map((item) => item[0]);
                    const jumlahSuratListrik_kategori = data_kategori.filter(item => item[1]).map((item) => item[1]);
                    const jumlahSuratAC_kategori = data_kategori.filter(item => item[1]).map((item) => item[2]);
                    const jumlahSuratPlumbing_kategori = data_kategori.filter(item => item[1]).map((item) => item[3]);
                    const jumlahSuratKebersihan_kategori = data_kategori.filter(item => item[1]).map((item) => item[4]);
                    const jumlahSuratParkir_kategori = data_kategori.filter(item => item[1]).map((item) => item[5]);
                     console.log(jumlahSuratListrik_kategori);
                     console.log(jumlahSuratAC_kategori);
                     console.log(jumlahSuratPlumbing_kategori);
                     console.log(jumlahSuratKebersihan_kategori);
                     console.log(jumlahSuratParkir_kategori);

                    // Perbaikan pada console.log
                    console.log(data_kategori.filter(item => item[1]).map((item) => item[1])); // Mencetak semua nilai dari kolom dengan indeks 2

                    const myChart_kategori = new Chart(ctx_kategori, {
                        type: "bar",
                        data: {
                            labels: bulan_kategori,
                            datasets: [
                                {
                                    label: "Listrik",
                                    data: jumlahSuratListrik_kategori,
                                    backgroundColor: "rgba(48, 206, 209)", // Warna biru dengan opasitas 0.6
                                    borderColor: "rgba(48, 206, 209)", // Warna biru dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }, {
                                    label: "AC",
                                    data: jumlahSuratAC_kategori,
                                    backgroundColor: "rgba(72, 61, 139)", // Warna merah dengan opasitas 0.6
                                    borderColor: "rgba(72, 61, 139)", // Warna merah dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }, {
                                    label: "Plumbing",
                                    data: jumlahSuratPlumbing_kategori,
                                    backgroundColor: "rgba(251,127,80)", // Warna merah dengan opasitas 0.6
                                    borderColor: "rgba(251,127,80)", // Warna merah dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }, {
                                    label: "Kebersihan",
                                    data: jumlahSuratKebersihan_kategori,
                                    backgroundColor: "rgba(255,255,0)", // Warna merah dengan opasitas 0.6
                                    borderColor: "rgba(255,255,0)", // Warna merah dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }, {
                                    label: "Parkir",
                                    data: jumlahSuratParkir_kategori,
                                    backgroundColor: "rgba(95,73,0)", // Warna merah dengan opasitas 0.6
                                    borderColor: "rgba(95,73,0)", // Warna merah dengan opasitas penuh (1.0)
                                    borderWidth: 1.5,
                                }

                            ],
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
                                tooltip: {
                                    callbacks: {
                                        label: (context) => {
                                            const label = context.dataset.label || '';
                                            const value = context.parsed.y;
                                            return `${label}: ${value}`;
                                        },
                                    },
                                },
                                chartAreaBorder: {
                                    borderColor: "red",
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    borderDashOffset: 2,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Grafik Kategori'
                            },
                            // indexAxis: isMobile ? "y" : "x", // Memilih sumbu indeks berdasarkan lebar layar
                            responsive: true,
                        },
                        plugins: [chartAreaBorder],
                    });
                </script>
                <!-- CHART END -->

            </div>
            <div id="colres" class="warna cetak">
                <table class="bordered" id="tbl" width="100%">
                    <thead class="blue lighten-1">
                        <tr>
                            <th width="3%">No</th>
                            <th width="25%">No.Pengaduan<br />
                                <hr />Pengaduan
                            </th>
                            <th width="15%">Kategori</th>
                            <th width="15%">File</th>
                            <th width="15%">Nama<br />
                                <hr />Nama Tenant
                            </th>
                            <th width="15%">Status</th>
                            <th width="15%">Kepuasan</th>
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
                                    <td><strong><?= $row['no_pengaduan'] ?></strong><br />
                                        <hr /><?= ucwords(nl2br(htmlentities(strtolower($row['pengaduan'])))) ?>
                                    </td>
                                    <td><center><?= $row['kategori_masalah'] ?></center></td>
                                    <td>
                                        <?php
                                        if (!empty($row['file'])) {
                                            echo ' <strong><a href = "/./upload/pengaduan/' . $row['file'] . '"><img src="/./upload/pengaduan/' . $row['file'] . '" style="width: 70px"></a></strong>';
                                        } else {
                                            echo '<em>Tidak ada file yang di upload</em>';
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row['nama'] ?><br />
                                        <hr /><?= $row['nama_tenant'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($row['status_pengaduan'])) {
                                            echo '<strong><i>' . $row['status_pengaduan'] . ',' . $row['waktu_ttd_pengaduan'] . '<br/><hr/>' . $row['status_kepuasan'] . '</i> </strong>';
                                        } else {
                                            echo '<em><font color="red"><i>Belum ada tanggapan</i></font></em>';
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row['status_kepuasan'] ?></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="9">
                                    <center>
                                        <p class="add">Tidak ada Data</p>
                                    </center>
                                </td>
                            </tr>
                        <?php }
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
                        <div class="nav-wrapper blue-grey darken-1">
                            <div class="col 12">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=report_pengaduan" class="judul"><i class="material-icons">print</i> Cetak Laporan PENGADUAN</a></li>
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
                    <i class="material-icons prefix md-prefix">event</i>
                    <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                    <label for="sampai_tanggal">Sampai Tanggal</label>
                </div>
                <div class="col s6">
                    <button type="submit" name="submit" class="btn small blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                </div>
            </form>
        </div>
        <!-- Row form END -->
<?php
    }
}
?>