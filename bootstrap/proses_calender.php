<?php
session_start();
include '../include/config.php';
include '../include/functions.php';

$config = conn($host, $username, $password, $database);
$info = $_GET['info'];
$id_user = $_SESSION['id_user'];
if ($info === 'get') {


    // Ambil ID pengguna dari sesi atau sumber lainnya
    // Query untuk mengambil data dari tabel tbl_kalender
    $query = "SELECT id,title, theme_color AS className, start_date AS start, end_date AS end FROM tbl_kalender WHERE id_user = ?";
    $stmt = mysqli_prepare($config, $query);

    // Bind parameter untuk parameterized query
    mysqli_stmt_bind_param($stmt, 'i', $id_user);

    // Eksekusi query
    mysqli_stmt_execute($stmt);

    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);

    // Inisialisasi array untuk menyimpan data acara
    $response = array();

    // Loop untuk membaca hasil query
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }


    // Mengembalikan data dalam format JSON
    header('Content-Type: application/json');
} else if ($info === 'add') {


    // Mendapatkan data JSON dari permintaan POST
    $json_data = file_get_contents('php://input');

    // Mengonversi data JSON menjadi array PHP
    $data = json_decode($json_data, true);

    // Menangani data sesuai kebutuhan
    if (!empty($data)) {
        $title = $data['title'];
        $start = $data['start'];
        $end = $data['end'];
        $className = $data['className'];
        $id_user = $_SESSION['id_user'];

        $query = "INSERT INTO tbl_kalender (title, theme_color, start_date, end_date, id_user) VALUES (?, ?, ?, ?, ?)";
        if (isset($query)) {
            $stmt = mysqli_prepare($config, $query);
            // Bind parameter untuk parameterized query
            mysqli_stmt_bind_param($stmt, 'ssssi', $title, $className, $start, $end, $id_user);
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
        } else {
            $response['success'] = false;
        }
    } else {
        // Jika data tidak valid atau kosong
        $response['success'] = false;
    }
} else if ($info === 'update') {
    // Mendapatkan data JSON dari permintaan POST
    $json_data = file_get_contents('php://input');

    // Mengonversi data JSON menjadi array PHP
    $data = json_decode($json_data, true);
    $title = $data['title'];
    $eventId = $data['id']; // ID acara yang akan diupdate

    // Query untuk mengupdate data dalam tabel tbl_kalender
    $query = "UPDATE tbl_kalender SET title = ? WHERE id = ? AND id_user = ?";
    $stmt = mysqli_prepare($config, $query);

    // Bind parameter untuk parameterized query
    mysqli_stmt_bind_param($stmt, 'sii', $title, $eventId, $id_user);

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
} else if ($info === 'delete') {
    $json_data = file_get_contents('php://input');

    // Mengonversi data JSON menjadi array PHP
    $data = json_decode($json_data, true);
    $id = $data['id']; // ID acara yang akan diupdate

    // Query untuk mengupdate data dalam tabel tbl_kalender
    $query = "DELETE FROM tbl_kalender WHERE id = ?";
    $stmt = mysqli_prepare($config, $query);

    // Bind parameter untuk parameterized query
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
}
// Tutup statement dan koneksi database
mysqli_stmt_close($stmt);
// kirim data
echo json_encode($response);
// tutup koneksi database
mysqli_close($config);