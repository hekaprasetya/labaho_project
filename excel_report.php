<?php

$header = json_decode($_POST['header'], true);
$dataArray = json_decode($_POST['dataArray'], true);
$fileName = $_POST['fileName'];

// Menentukan header untuk file CSV yang akan diunduh
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');

// Membuka file output dalam mode penulisan
$output = fopen("php://output", "w");

// Menulis baris header ke dalam file CSV
fputcsv($output, $header);

// Menulis baris data ke dalam file CSV menggunakan fputcsv
foreach ($dataArray as $data) {
    fputcsv($output, $data);
}

// Menutup file output
fclose($output);
