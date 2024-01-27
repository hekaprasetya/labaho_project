<?php
session_start();
include '../include/config.php';
function conn($host, $username, $password, $database)
{
    $conn = new mysqli($host, $username, $password, $database);

    // Menampilkan pesan error jika database tidak terhubung
    return ($conn) ? $conn : "Koneksi database gagal: " . mysqli_connect_error();
}
$config = conn($host, $username, $password, $database);
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
        mysqli_stmt_close($stmt);
    } else {
        $response['success'] = false;
    }
} else {
    // Jika data tidak valid atau kosong
    $response['success'] = false;
}
echo json_encode($response);
mysqli_close($config);