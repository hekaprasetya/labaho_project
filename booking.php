    <?php
    //cek session
    if (empty($_SESSION['admin'])) {
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } 
            $actArray = [
                'add' => 'tambah_booking.php',
                'edit' => 'edit_edit.php',
                'del' => 'hapus_booking.php'
            ];
            if (isset($_REQUEST['act'])) {
                $act = $_REQUEST['act'];
                if (array_key_exists($act, $actArray)) {
                    $halaman = $actArray[$act];
                    (file_exists($halaman)) ? include $halaman : print("File tidak ditemukan: $halaman");
                } else {
                    echo "Halaman tidak ditemukan!";
                }
            } else {
                $query = mysqli_query($config, "SELECT tbl_pesanan FROM tbl_sett");
                list($booking) = mysqli_fetch_array($query);

                //pagging
                $limit = $booking;
                $pg = @$_GET['pg'];
                if (empty($pg)) {
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }

                // untuk function
                $booking = new CRUD();

                // id pada tabel berisi id_"$id_name" 
                $booking->id_name = 'booking';

                // nama tabel utama halaman
                $booking->tbl_name = 'tbl_pesanan';

                // page halaman pemangilan di admin
                $booking->pg_name = 'booking';

                // judul pada secon nav
                $booking->judul = "BOOKING";

                // icon untuk judul
                $booking->icon_judul = "book";


                // array isi ari tabel
                $isi_row = array("nomor_pesanan", "tanggal", "pelanggan", "nama_paket", "status_pesanan", "total_biaya");
                $header = array("Nomor", "Tgl", "Nama Pelanggan", "Paket", "Status", "Total");

                // SECONDARY NAV START
                $booking->judul_s();
                // SECONDARY NAV END
                ?>
                <div class="row jarak-form">
                    <div class="col m12" id="colres">
                        <table class="bordered centered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th>No</th>
                                    <?php foreach ($header as $head) { ?>
                                    <th><?= ucfirst(str_replace('_', ' ', $head)) ?></th> <?php } ?>
                                    <th>Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal_function"><i class="material-icons" style="color: #333;">settings</i></a></span></th>
                                    <?php $booking->hal($config); ?>
                                </tr>
                            </thead>
                            <tbody>

                                            <?php
                                            // menambahkan untuk variabel query untuk mencari
                                            $query_apar = "SELECT
                                            a.*,
                                            a.id as id_booking,
                                            b.pelanggan,
                                            c.nama_paket,
                                            d.nomor_pemesanan as id_pembayaran
                                        FROM
                                            tbl_pesanan a
                                        JOIN
                                            tbl_pelanggan b ON a.id_pelanggan = b.id
                                        JOIN
                                            tbl_paket_wisata c ON a.id_paket = c.id
                                        LEFT JOIN tbl_pembayaran d ON a.id = d.nomor_pemesanan ";
                                            // membuat varibel untuk mengambil data
                                if (isset($_REQUEST['submit'])) {
                                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                                    $query_apar .= "WHERE a.nomor_pesanan LIKE '%$cari%'
                                    OR a.tanggal LIKE '%$cari%' 
                                    OR b.pelanggan LIKE '%$cari%'
                                    ORDER by a.id DESC";
                                } else {
                                            //script untuk menampilkan data
                                            $query_apar .= " ORDER BY a.id DESC LIMIT $curr, $limit";
                                }
                                            // meenggunakan fuction query
                                            $result = mysqli_query($config, $query_apar);
                                            $cek = mysqli_num_rows($result);
                                            if ($cek) {
                                                $no = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $id = $row['id'];
                                                    $booking->id = $row['id'];
                                                    ?>
                                                            <tr>
                                                                <td><?= $no ?></td>
                                                                <?php
                                                                foreach ($isi_row as $kolom) {
                                                                    if($kolom == "status_pesanan") {
                                                                        echo ($row[$kolom] == "Pending") ?'<td class="red-text">'. $row[$kolom] .'</td>' : '<td class="green-text">'. $row[$kolom] .'</td>';
                                                                    } else {
                                                                        ?> <td><?= $row[$kolom] ?></td>  <?php
                                                                    }
                                                                }
                                                                  //** PEMBAYARAN
                                                                  if (is_null($row['id_pembayaran'])) {
                                                                    ?>
                                                                    <td>
                                                                        <button type="button" class="btn small red waves-effect waves-light tooltipped" data-position="left" data-tooltip="Konformasi Pembayaran" onclick="bayar(<?= $id ?>)">
                                                                        <i class="material-icons">warning</i></button>
                                                                    </td>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <td><?= $booking->crud(); ?></td>
                                                                    <?php
                                                                } ?>
                                                            </tr>
                                                    <?php
                                                    $no++;
                                                }
                                            } else {
                                                $booking->nodata();
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?= $booking->pagging($conn, $limit, $pg) ?>
                                </div> 
                                </div><?php } ?>
                                <script>
                                  function bayar(id) {
                                    Swal.fire({
                                        title: "Konfirmasi Pembayaran",
                                        html:
                                        '<select id="swal-input2" class="browser-default validate" >' +
                                        '<option value="" disabled selected>Metode Pembayaran</option>' +
                                        '<optgroup label="Transfer Bank">' +
                                        '<option value="BCA">BCA</option>' +
                                        '<option value="BRI">BRI</option>' +
                                        '<option value="BNI">BNI</option>' +
                                        '<option value="MANDIRI">MANDIRI</option>' +
                                        '</optgroup>' +
                                        '<optgroup label="Ewallet">' +
                                        '<option value="Dana">Dana</option>' +
                                        '<option value="ShoppePay">ShoppePay</option>' +
                                        '<option value="Gopay">Gopay</option>' +
                                        '</optgroup>' +
                                        '</select>'+
                                        '<input type="number" placeholder="Jumlah Pembayaran" id="swal-input3" class="swal2-input" pattern="[0-9,.]*">',
                                        showCancelButton: true,
                                        preConfirm: () => {
                                        const metode = document.getElementById("swal-input2").value;
                                        const jumlah = document.getElementById("swal-input3").value;

                                        return [metode, jumlah, id];
                                        }
                                    }).then((result) => {
                                        if (result.value) {
                                        const [metode, jumlah, id] = result.value;
                                        console.log(result.value);
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
                                                    text: "Anda berhasil menambahkan Data.",
                                                    icon: "success"
                                                    }).then(() => {
                                                            window.location.href = '?page=booking';
                                                    });
                                                } else {
                                                    Swal.fire({
                                                    icon: "error",
                                                    title: "Maaf...",
                                                    text: "Terjadi Kesalahan. Silakan Coba Lagi!"
                                                    });
                                                }
                                                } catch (error) {
                                                console.error("Error parsing JSON:", error);
                                                }
                                            } else {
                                                console.error("HTTP request failed with status:", this.status);
                                            }
                                            }
                                        };

                                        // Sesuaikan URL dan metode HTTP yang sesuai dengan kebutuhan Anda
                                        const url = "proses_tambah.php";
                                        const params = `ket=pembayaran&metode=${metode}&jumlah=${jumlah}&id=${id}`;
                                        xhttp.open("GET", `${url}?${params}`, true);
                                        xhttp.send();
                                        }
                                    });
                                    }

                                </script>