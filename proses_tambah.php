<?php
include('include/config.php');
include('include/functions.php');
$config = conn($host, $username, $password, $database);
$response = array();
$ket = $_GET['ket'];
// Mengecek apakah permintaan datang dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data formulir dari permintaan POST
    if ($ket === "booking") {
        // pelanggan
        $pelanggan = $_POST['pelanggan'];
        $telp = $_POST['telp'];
        $email = $_POST['email'];
        // paket
        $nama_paket = $_POST['nama_paket'];
        $durasi_paket = $_POST['durasi_paket'];
        $harga_orang = $_POST['harga_orang'];
        $jumlah_org = $_POST['jumlah_org'];
        // Jadwal
        $tanggal_berangkat = $_POST['tanggal_berangkat'];
        $tanggal_kembali = $_POST['tanggal_kembali'];
        $rincian = $_POST['rincian'];
        // Pesanan
        $nomor_pesanan = $_POST['nomor_pesanan'];
        $status = $_POST['status'];
        $total_biaya = $_POST['total_biaya'];

        // INSERT tbl_pelanggan
        $query_pelanggan = mysqli_query($config, "INSERT INTO tbl_pelanggan (pelanggan, telp, email) VALUES ('$pelanggan', '$telp', '$email')");

        if ($query_pelanggan == TRUE) {
            $id_pelanggan = $config->insert_id;
            // INSERT tbl_paket_wisata
            $query_paket = mysqli_query($config, "INSERT INTO tbl_paket_wisata (nama_paket, harga_orang, durasi_paket) VALUES ('$nama_paket', '$harga_orang', '$durasi_paket','$jumlah_org')");
            $id_paket = $config->insert_id;
            // INSERT tbl_pesanan
            $query_pesanan = mysqli_query($config, "INSERT INTO tbl_pesanan (nomor_pesanan,status_pesanan,total_biaya,id_pelanggan,id_paket) VALUES('$nomor_pesanan','$status','$total_biaya','$id_pelanggan','$id_paket')");
            $id_pesanan = $config->insert_id;
            // INSERT tbl_jadwal
            $tbl = 'tbl_jadwal';
            $columnString = "tanggal_berangkat, tanggal_kembali, rincian, nomor_pesanan";
            $setValues = [$tanggal_berangkat, $tanggal_kembali, $rincian];
            $params = array_merge($setValues, array($id_pesanan));

        }
    }
    $columns = explode(', ', $columnString);

    // Membuat string kolom
    $columnNames = implode(', ', $columns);

    // Mengisi nilai yang akan di-insert
    $valuesString = implode(', ', array_fill(0, count($columns), '?'));

    $query = "INSERT INTO $tbl ($columnNames) VALUES ($valuesString)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters

    mysqli_stmt_bind_param($stmt, str_repeat('s', count($columns)), ...$params);
    // Mengirim respons kembali ke klien
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($ket === "pembayaran") {
        $metode_pembayaran = $_GET['metode'];
        $nomor_pemesanan = $_GET['id'];
        $jumlah = $_GET['jumlah'];
        $status = 'Lunas';

        $query = mysqli_query($config, "UPDATE tbl_pesanan SET status_pesanan = '$status' WHERE id ='$nomor_pemesanan'");
        if ($query == TRUE) {
            $tbl = 'tbl_pembayaran';
            $columnString = "metode_pembayaran, jumlah, nomor_pesanan";
            $setValues = [$metode_pembayaran, $jumlah];
            $params = array_merge($setValues, array($nomor_pemesanan));
        }
    }
    $columns = explode(', ', $columnString);

    // Membuat string kolom
    $columnNames = implode(', ', $columns);

    // Mengisi nilai yang akan di-insert
    $valuesString = implode(', ', array_fill(0, count($columns), '?'));

    $query = "INSERT INTO $tbl ($columnNames) VALUES ($valuesString)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters

    mysqli_stmt_bind_param($stmt, str_repeat('s', count($columns)), ...$params);
    // Mengirim respons kembali ke klien
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    // Jika metode bukan POST, kirim respons error
    http_response_code(405); // Method Not Allowed
    echo "Metode tidak diizinkan.";
}
echo json_encode($response);
mysqli_close($conn);