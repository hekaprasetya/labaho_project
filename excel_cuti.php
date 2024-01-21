<?php

require 'vendor/autoload.php';

include "config.php";
include "functions.php";

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Buat objek Spreadsheet
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

// Ambil aktifkan lembar kerja pertama
$sheet = $spreadsheet->getActiveSheet();

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = [
    'font' => ['bold' => true], // Set font nya jadi bold
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];
// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];



// Isi header untuk kolom
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'No.Form');
$sheet->setCellValue('C1', 'Tanggal');
$sheet->setCellValue('D1', 'Nama');
$sheet->setCellValue('E1', 'Jabatan');
$sheet->setCellValue('F1', 'No.HP');
$sheet->setCellValue('G1', 'TGL.Cuti');
$sheet->setCellValue('H1', 'Akhir Cuti');
$sheet->setCellValue('I1', 'Jumlah Cuti');
$sheet->setCellValue('J1', 'Hari Di Setujui');
$sheet->setCellValue('K1', 'Disetujui Kabag');
$sheet->setCellValue('L1', 'Mengetahui HRD');
$sheet->setCellValue('M1', 'dibuat');

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$sheet->getStyle('A1')->applyFromArray($style_col);
$sheet->getStyle('B1')->applyFromArray($style_col);
$sheet->getStyle('C1')->applyFromArray($style_col);
$sheet->getStyle('D1')->applyFromArray($style_col);
$sheet->getStyle('E1')->applyFromArray($style_col);
$sheet->getStyle('F1')->applyFromArray($style_col);
$sheet->getStyle('G1')->applyFromArray($style_col);
$sheet->getStyle('H1')->applyFromArray($style_col);
$sheet->getStyle('I1')->applyFromArray($style_col);
$sheet->getStyle('J1')->applyFromArray($style_col);
$sheet->getStyle('K1')->applyFromArray($style_col);
$sheet->getStyle('L1')->applyFromArray($style_col);
$sheet->getStyle('M1')->applyFromArray($style_col);
// Set height baris ke 1, 2 dan 3
$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('2')->setRowHeight(20);
$sheet->getRowDimension('3')->setRowHeight(20);


// Loop melalui hasil kueri dan mengisi data ke dalam lembar kerja
  $query = mysqli_query($config, "SELECT a.*,
                                b.id_app_cuti_kabag,status_cuti_kabag,waktu_cuti_kabag,jumlah_trm, 
                                c.id_app_cuti_hrd,status_cuti_hrd,waktu_cuti_hrd,
                                d.nama,jabatan,no_hp,sisa_cuti
                                FROM tbl_cuti a
                                LEFT JOIN tbl_approve_cuti_kabag b
                                ON a.id_cuti=b.id_cuti
                                LEFT JOIN tbl_approve_cuti_hrd c 
                                ON a.id_cuti=c.id_cuti
                                LEFT JOIN tbl_user d
                                ON a.id_user=d.id_user
                                
                                ORDER by id_cuti");
$rowNumber = 2; // Inisialisasi nomor baris
$no = 1;
// Daftar huruf kolom
$hurufKolom = range('A', 'Z');

foreach ($query as $row) {
    $kolomIndex = 0; // Inisialisasi indeks kolom

    // Sisipkan data yang sudah diurutkan
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $no);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->no_form);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->tgl);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->nama);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->jabatan);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->no_hp);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->tgl_cuti);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->akhir_cuti);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->jumlah_hari);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->jumlah_trm);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->status_cuti_kabag);
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $row->status_cuti_hrd);

    // Get the user's name by querying the tbl_user table
    $query3 = mysqli_query($conn, "SELECT nama FROM tbl_user WHERE id_user='$row->id_user'");
    $nama = mysqli_fetch_assoc($query3)['nama'];

    // Set the user's name in the Excel worksheet
    $kolomIndex++;
    $sheet->setCellValue($hurufKolom[$kolomIndex] . $rowNumber, $nama);

    $rowNumber++;
    $no++;
}


// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$sheet->setTitle("Laporan Data Cuti");

$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
$date = str_replace(".", "", $date);
$fileName = "cuti_" . $date . ".xlsx";
// Tentukan header untuk mengunduh file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
header('Content-Type: application/vnd.ms-excel');

ob_end_clean();
// Buat objek writer untuk menyimpan file
$writer = new Xlsx($spreadsheet);
// Keluarkan hasil ke browser
$writer->save('php://output');
