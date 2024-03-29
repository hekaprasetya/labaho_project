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
            header("Location: ./admin.php?page=asm");
            die();
        } else {

            $query = mysqli_query($config, "SELECT a.*,
                                                           b.manager_mkt,
                                                           c.id_lpt,
                                                           d.id_approve_gm,gm,
                                                           e.id_lpg
                                                           FROM tbl_surat_masuk a
                                                            LEFT JOIN tbl_disposisi b 
                                                           ON a.id_surat=b.id_surat 
                                                            LEFT JOIN tbl_lpt c 
                                                           ON a.id_surat=c. id_surat
                                                            LEFT JOIN tbl_approve_gm d
                                                           ON a.id_surat=d.id_surat
                                                            LEFT JOIN tbl_lpg e
                                                           ON a.id_surat=e.id_surat
                                                    WHERE tgl_surat BETWEEN '$dari_tanggal' AND '$sampai_tanggal'");

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
                                        <li class="waves-effect waves-light"><a href="?page=asm" class="judul"><i class="material-icons">print</i> Cetak Laporan E-PMK<a></li>
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
                    <span></span><br />
                    <img class="logodisp" src="./upload/<?= $logo ?>" />
                    <span></span><br />
                    <span>
                        <h6>LAPORAN E - PMK</h6>
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
                <!-- CHART START -->
                <canvas id="chart" width="250" height="120"></canvas>
                <?php
                $table = 'tbl_surat_masuk'; // nama table
                $id = 'id_surat'; //id table
                $tgl = 'tgl_surat'; // tanggal (timestamp)
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
                    <thead class="blue lighten-4">
                        <tr>
                            <th>No</th>
                            <th width="10%">No.PMK<br />
                                <hr />Status PMK
                            </th>
                            <th width="30%">Jenis Pekerjaan<br />
                                <hr /> File
                            </th>
                            <th width="20%">Lokasi<br />
                                <hr />Nama Perusahaan
                            </th>
                            <th width="20%">Ditujukan Kepada<br />
                                <hr />Tanggal Surat
                            </th>
                            <th width="20%">Disetujui.Mng<br />
                                <hr />Diketahui.GM
                            </th>
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
                                    <td><strong><?= $row['no_agenda'] ?></strong><br />
                                        <hr /><?= $row['status'] ?>
                                    </td>
                                    <td><?= ucwords(nl2br(htmlentities(strtolower($row['isi'])))) ?><br /><br /><strong>File :</strong>
                                        <?php
                                        if (!empty($row['file'])) {
                                        ?> <strong><a href="?page=gsm&act=fsm&id_surat=<?= $row['id_surat'] ?>"><?= $row['file'] ?></a></strong>
                                        <?php
                                        } else {
                                        ?><em>Tidak ada file yang di upload</em>
                                        <?php } ?></td>
                                    <td><?= ucwords(strtolower($row['asal_surat'])) ?><br />
                                        <hr><?= ucwords(strtolower($row['indeks'])) ?>
                                    </td>
                                    <td><?= ucwords(strtolower($row['no_surat'])) ?><br />
                                        <hr /><?= indoDate($row['tgl_surat']) ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($row['manager_mkt'])) {
                                        ?> <strong><?= $row['manager_mkt'] ?></a></strong>
                                        <?php
                                        } else {
                                        ?><font color="red"><i>Manager Kosong</i></font>
                                        <?php
                                        } ?>

                                        <br />
                                        <hr />
                                        <?php
                                        if (!empty($row['gm'])) {
                                        ?> <strong><?= $row['gm'] ?></a></strong>
                                        <?php
                                        } else {
                                        ?><font color="red"><i>GM Kosong</i></font>
                                        <?php
                                        } ?>
                                    </td>

                                    <?php
                                }
                            } else {
                                    ?>
                                <tr>
                                    <td colspan="9">
                                        <center>
                                            <p class="add">Tidak ada agenda surat</p>
                                        </center>
                                    </td>
                                </tr>
                            <?php } ?>
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
                                    <li class="waves-effect waves-light"><a href="?page=asm" class="judul"><i class="material-icons">print</i> Cetak Laporan E-PMK<a></li>
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

<?php
    }
}
?>