<?php
// Ambil konfigurasi database
session_start();
include '../include/config.php';
include '../include/functions.php';

$config = conn($host, $username, $password, $database);

// Ambil ID pengguna dari sesi atau sumber lainnya
$id_user = $_SESSION['id_user'];

// Query untuk mengambil data dari tabel tbl_kalender
$query = "SELECT title, theme_color AS className, start_date AS start, end_date AS end FROM tbl_kalender WHERE id_user = ?";
$stmt = mysqli_prepare($config, $query);

// Bind parameter untuk parameterized query
mysqli_stmt_bind_param($stmt, 'i', $id_user);

// Eksekusi query
mysqli_stmt_execute($stmt);

// Ambil hasil query
$result = mysqli_stmt_get_result($stmt);

// Inisialisasi array untuk menyimpan data acara
$events = array();

// Loop untuk membaca hasil query
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

// Tutup statement dan koneksi database
mysqli_stmt_close($stmt);
mysqli_close($config);

// Mengembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($events);