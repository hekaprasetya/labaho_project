<?php
include('include/config.php');
include('include/functions.php');
$config = conn($host, $username, $password, $database);
$response = array();
$ket = $_GET['ket'];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Mengambil data formulir dari permintaan POST
    if ($ket === "booking") {
        $id_pesanan = $_GET['id'];
        $id_pelanggan = $_GET['id_pelanggan'];
        $id_paket = $_GET['id_paket'];
        $tbl = [
            'tbl_pesanan',
            'tbl_pembayaran',
            'tbl_jadwal',
            'tbl_pelanggan',
            'tbl_paket_wisata'
        ];
        $column = [
            'id',
            'nomor_pesanan',
            'nomor_pesanan',
            'id',
            'id',
        ];
        $conditions = [
            $id_pesanan,
            $id_pesanan,
            $id_pesanan,
            $id_pelanggan,
            $id_paket
        ];
    }
    if (is_array($tbl)) {
        // Jika $tbl adalah array, lakukan looping untuk menghapus tabel
        foreach ($tbl as $index => $table) {
            // Membuat klausa WHERE untuk setiap tabel
            $kolom = $column[$index];
            $values = $conditions[$index];

            $query = "DELETE FROM $table WHERE $kolom = '$values'";
            $res = mysqli_query($config, $query);
        }
    } else {

        $query = "DELETE FROM $tbl WHERE $kolom = '$condition'";
        $res = mysqli_query($config, $query);

    }
    // Mengirim respons kembali ke klien
    if ($res == TRUE) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = mysqli_error($conn);
    }
} else {
    // Jika metode bukan POST, kirim respons error
    http_response_code(405); // Method Not Allowed
    echo "Metode tidak diizinkan.";
}
echo json_encode($response);
mysqli_close($conn);