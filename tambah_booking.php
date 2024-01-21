<head>
    <link href="bootstrap/plugins/jquery-steps/css/jquery.steps.css" rel="stylesheet">
    <link href="asset/css/style2.css" rel="stylesheet">
</head>
<style>
    .wizard>.actions a,
    .wizard>.actions a:hover,
    .wizard>.actions a:active {
        padding: 0.55em 1em !important;
    }
</style>

<!-- Row Start -->
<div class="row">
    <!-- Secondary Nav START -->
    <div class="col s12">
        <div class="z-depth-1">
            <nav class="secondary-nav">
                <div class="nav-wrapper blue darken-2">
                    <div class="col m7">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i
                                        class="material-icons md-3">book</i>Tambah Data Pesanan</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Secondary Nav END -->
</div>
<!-- Row END -->
<!-- row -->
<div class="container-fluid">
    <div class="card">
        <form action="#" method="POST" id="step-form-horizontal" class="step-form-horizontal">
            <div>
                <h4>Pelanggan</h4>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pelanggan">1</label>
                                <input type="text" name="pelanggan" class="form-control" placeholder="Nama Pelanggan"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="telp">2</label>
                                <input type="number" name="telp" class="form-control" placeholder="Nomor Telepon"
                                    required pattern="[0-9()+\s-]*">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                </section>
                <h4>Paket</h4>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-field form-group">
                                <select name="nama_paket" class="browser-default validate theSelect form-control"
                                    onchange="updateDurasiOptions()">
                                    <option value="" disabled selected>Nama Paket</option>
                                    <?php
                                    $paket = paket();
                                    foreach ($paket as $row => $durasi) {
                                        echo '<option value="' . $row . '">' . $row . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-field form-group">
                                <select name="durasi_paket" class="browser-default validate theSelect form-control">
                                    <option value="" disabled selected>Durasi Paket</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" name="harga_orang" class="form-control"
                                    placeholder="Harga Paket Per-orang" pattern="[0-9,.]*" required>
                            </div>
                        </div>
                    </div>
                </section>
                <h4>Jadwal</h4>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-field form-group">
                                <input id="tgl" type="text" name="tanggal_berangkat" class="datepicker" required>
                                <label for="tgl">Tanggal Keberangkatan</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-field form-group">
                                <input id="tgl_surat" type="text" name="tanggal_kembali" class="datepicker" required>
                                <label for="tgl_surat">Tanggal Kembali</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rincian</span>
                                </div>
                                <textarea name="rincian" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </section>
                <h4>Pesanan</h4>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php
                                // memulai mengambil datanya
                                $sql = mysqli_query($config, "SELECT nomor_pesanan, tanggal FROM tbl_pesanan ORDER BY id DESC LIMIT 1");

                                // mengambil nilai no_form terbaru
                                $result = mysqli_fetch_assoc($sql);

                                if ($result['nomor_pesanan'] && $result['tanggal']) {
                                    $tanggal_terakhir = $result['tanggal'];
                                    $tahun_terakhir = date("Y", strtotime($tanggal_terakhir));
                                    $tahun_sekarang = date("Y");
                                    // Memecah string $nomor menggunakan delimiter "/"
                                    $pecah_nomor = explode("/", $result['nomor_pesanan']);

                                    // Mengambil nilai terakhir dari array hasil pecahan sebagai $kode
                                    $kode1 = end($pecah_nomor);

                                    // Menghapus nol yang di-padding pada $kode, jika ada
                                    $res = ltrim($kode1, "0");
                                    // Periksa apakah input terakhir pada tahun yang sama
                                    ($tahun_sekarang == $tahun_terakhir) ? $kode = $res + 1 : $kode = 1;
                                } else {
                                    $kode = 1;
                                }
                                //mulai bikin kode
                                $bikin_kode = str_pad($kode, 4, "0", STR_PAD_LEFT);
                                $tahun = date('Y-m');
                                $nomor = "PKT/$tahun/$bikin_kode";
                                ?>
                                <input type="text" readonly="readonly" class="form-control-plaintext"
                                    value="<?= $nomor ?>" required>
                                <input type="hidden" name="nomor_pesanan" value="<?= $nomor ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp.</span>
                                    </div>
                                    <input placeholder="Total Biaya" type="text" name="total_biaya" class="form-control"
                                        pattern="[0-9,.]*" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-field form-group">
                                <select name="status" class="browser-default validate theSelect form-control">
                                    <option value="" disabled selected>Status Pembayaran</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
                <h4>Confirmation</h4>
                <section>
                    <div class="row h-100">
                        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
                            <h2>selesai</h2>
                            <p>Pastikan Semua Data benar.</p>
                            <button type="button" onclick="sub()" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</div>
<!-- <script>
    document.getElementsByName('total_biaya')[0].addEventListener('input', function (e) {
        // Mengambil nilai input
        let inputValue = e.target.value;

        // Menghapus semua karakter selain angka, koma, dan titik
        inputValue = inputValue.replace(/[^\d,.]/g, '');

        // Mengubah string menjadi angka float
        let floatValue = parseFloat(inputValue.replace(',', '.'));

        // Mengecek apakah floatValue bukan NaN
        if (!isNaN(floatValue)) {
            // Mengubah nilai input menjadi format rupiah
            e.target.value = floatValue.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });
        } else {
            // Jika nilai floatValue NaN, biarkan input kosong
            e.target.value = '';
        }
    });
</script> -->
<script>
    // JavaScript
    const form = document.querySelector('#step-form-horizontal');
    // Menambahkan event listener untuk menangani klik tombol
    function sub() {
        const formData = new FormData(form);
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    console.log(this.responseText); // Tampilkan respons dari server dalam konsol
                    try {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data Berhasil Dibuat",
                                icon: "success"
                            }).then(() => {
                                window.location.href = '?page=booking';
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Maaf...",
                                text: "Terjadi Kesalahan. Silakan Coba Lagi!"
                            }).then(() => {
                                window.location.href = '?page=booking&act=add';
                            });
                        }
                    } catch (error) {
                        console.error("Error parsing JSON response:", error);
                    }
                } else {
                    console.error("HTTP request failed with status:", this.status);
                }
            }
        };
        xhttp.open('POST', 'proses_tambah.php?ket=booking', true);
        xhttp.send(formData);
    };
</script>
<script>
    function updateDurasiOptions() {
        var namaPaketSelect = document.getElementsByName("nama_paket")[0];
        var durasiPaketSelect = document.getElementsByName("durasi_paket")[0];

        // Bersihkan opsi durasi saat nama paket berubah
        durasiPaketSelect.innerHTML = '<option value="" disabled selected>Durasi Paket</option>';

        // Ambil nama paket yang dipilih
        var selectedNamaPaket = namaPaketSelect.value;

        // Jika nama paket dipilih, tambahkan opsi durasi yang sesuai
        if (selectedNamaPaket in namaPaketDurasiMap) {
            namaPaketDurasiMap[selectedNamaPaket].forEach(function (durasi) {
                var option = document.createElement("option");
                option.value = durasi;
                option.text = durasi;
                durasiPaketSelect.add(option);
            });
        }
    }

    // Nama paket dan durasi mapping
    var namaPaketDurasiMap = <?php echo json_encode(paket()); ?>;
</script>

<script src="bootstrap/plugins/jquery-steps/build/jquery.steps.min.js"></script>
<script src="bootstrap/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="bootstrap/js/plugins-init/jquery-steps-init.js"></script>