<?php
date_default_timezone_set("Asia/Jakarta");


// Datasheet labaho PAKET
function paket()
{
    return [
        'TOUR DENGAN KAPAL PINISI LABAHO 01' => ["1 HARI"],
        'TOUR DENGAN KAPAL PINISI LABAHO 02' => ["1 HARI"],
        'TOUR KE KOMODO BERSAMA PINISI LABAHO 01' => ['2 HARI 1 MALAM'],
        'TOUR KE KOMODO BERSAMA PINISI LABAHO 02' => ['2 HARI 1 MALAM'],
        'TOUR LABAHO KE KOMODO DENGAN KAPAL PINISI LABAHO 01' => [
            '3 HARI 2 MALAM',
            '4 HARI 3 MALAM'
        ],
        'TOUR LABAHO KE KOMODO DENGAN KAPAL PINISI LABAHO 02' => [
            '3 HARI 2 MALAM',
            '4 HARI 3 MALAM'
        ],
        'KAPAL CEPAT LABAHO 01' => ['1 HARI'],
        'KAPAL CEPAT LABAHO 02' => ['1 HARI'],
        'KAPAL CEPAT LABAHO 03' => ['1 HARI'],
        'PRIVATE TOUR WITH WHITE PEARL 02' => ['5 HARI 4 MALAM'],
        'HALF DAY TOUR' => ['SETENGAH HARI'],
        'TRIP MANCING BY RRI BAHARI' => ['SETENGAH HARI'],
        '1 DAY TRIP DISEKITAR LABUAN BAJO BERSAMA LABAHO' => ['1 HARI'],
        'TRIP WAE REBO BERSAMA LABAHO' => [
            '2 HARI 1 MALAM',
            '3 HARI 1 MALAM'
        ],
        'TRIP DANAU KELIMUTU' => ['4 HARI 3 MALAM'],
        'TRIP FLORES TOUR' => ['7 HARI 6 MALAM'],
        'TRIP AROUND FLORES' => ['8 HARI 7 MALAM'],
        'MENGEJAR SUNRISE DI BUKIT LONTAR' => ['SETENGAH HARI'],
        'SUNSET AND BBQ ON BEACH' => ['SETENGAH HARI'],
        'TRIP DI LABUAN BAJO' => ['3 HARI 2 MALAM']
    ];
}

/**
 * FUngsi koneksi database.
 */
function conn($host, $username, $password, $database)
{
    $conn = new mysqli($host, $username, $password, $database);

    // Menampilkan pesan error jika database tidak terhubung
    return ($conn) ? $conn : "Koneksi database gagal: " . mysqli_connect_error();
}

// Fungsi mengambil database.
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Mengembalikan pesan error jika kueri gagal dijalankan
        return "Kesalahan dalam menjalankan kueri: " . mysqli_error($conn);
    }

    $rows = [];
    while ($row = mysqli_fetch_object($result)) {
        $rows[] = $row;
    }

    // Membebaskan hasil kueri
    mysqli_free_result($result);

    return $rows;
}
// Fungsi mengambil database.
function query_assoc($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Mengembalikan pesan error jika kueri gagal dijalankan
        return "Kesalahan dalam menjalankan kueri: " . mysqli_error($conn);
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    // Membebaskan hasil kueri
    mysqli_free_result($result);

    return $rows;
}



/**
 * Fungsi untuk mengkonversi format tanggal menjadi format Indonesia.
 */
function indoDate($date)
{
    $exp = explode("-", substr($date, 0, 10));
    return $exp[2] . ' ' . month($exp[1]) . ' ' . $exp[0];
}


// Fungsi untuk mengkonversi format tanggal dan waktu menjadi format indonesia
function indoDateTime($date)
{
    // Mendapatkan komponen tanggal
    $exp = explode(" ", $date);
    $tanggal = $exp[0];

    // Mendapatkan komponen waktu (jam, menit, detik)
    $waktu = $exp[1];

    // Ubah format tanggal menjadi format Indonesia
    $tanggalIndonesia = indoDate($tanggal);

    // Ubah format waktu (jam, menit, detik)
    $expWaktu = explode(":", $waktu);
    $jam = $expWaktu[0];
    $menit = $expWaktu[1];
    $detik = $expWaktu[2];

    // Gabungkan tanggal dan waktu dalam format yang diinginkan
    $hasil = $tanggalIndonesia . ' /(' . $jam . ':' . $menit . ')';

    return $hasil;
}

/**
 * Fungsi untuk mengkonversi format bulan angka menjadi nama bulan.
 */
function month($kode)
{
    $month = '';
    switch ($kode) {
        case '01':
            $month = 'Januari';
            break;
        case '02':
            $month = 'Februari';
            break;
        case '03':
            $month = 'Maret';
            break;
        case '04':
            $month = 'April';
            break;
        case '05':
            $month = 'Mei';
            break;
        case '06':
            $month = 'Juni';
            break;
        case '07':
            $month = 'Juli';
            break;
        case '08':
            $month = 'Agustus';
            break;
        case '09':
            $month = 'September';
            break;
        case '10':
            $month = 'Oktober';
            break;
        case '11':
            $month = 'November';
            break;
        case '12':
            $month = 'Desember';
            break;
    }
    return $month;
}

/**
 * Fungsi backup database.
 */
function backup($host, $user, $pass, $dbname, $nama_file, $tables)
{

    //untuk koneksi database
    $return = "";
    $link = mysqli_connect($host, $user, $pass, $dbname);

    //backup semua tabel database
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {

        //backup tabel tertentu
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    //looping table
    foreach ($tables as $table) {
        $result = mysqli_query($link, 'SELECT * FROM ' . $table);
        $num_fields = mysqli_num_fields($result);

        $return .= 'DROP TABLE ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";

        //looping field table
        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return .= 'INSERT INTO ' . $table . ' VALUES(';

                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n", "\n", $row[$j]);

                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }
        $return .= "\n\n\n";
    }

    //otomatis menyimpan hasil backup database dalam root folder aplikasi
    $dir = "backup/";
    if (!is_dir($dir)) {
        mkdir($dir, 0755);
    }

    $file = $dir . $nama_file;
    $handle = fopen($file, 'w+');
    fwrite($handle, $return);
    fclose($handle);
}

// fungsi chart
function chart($conn, $dari_tanggal, $sampai_tanggal, $table, $id, $tgl)
{
    // Ubah tanggal menjadi format bulan dan tahun saja
    $dari_bulan_tahun = date('Y-m', strtotime($dari_tanggal));
    $sampai_bulan_tahun = date('Y-m', strtotime($sampai_tanggal));

    // Buat array untuk menyimpan jumlah surat berdasarkan bulan
    $hasilPerBulan = [];

    // Looping untuk setiap bulan dalam rentang tanggal
    $current_date = $dari_bulan_tahun;
    while ($current_date <= $sampai_bulan_tahun) {
        // Ekstrak bulan dan tahun dari tanggal saat ini
        list($tahun, $bulan) = explode('-', $current_date);

        // Buat query untuk mengambil data surat pada bulan tertentu
        $query = "SELECT COUNT(*) AS $id
        FROM $table
        WHERE $tgl BETWEEN '$dari_tanggal' AND '$sampai_tanggal'
        AND YEAR($tgl) = $tahun
        AND MONTH($tgl) = $bulan";
        $namaBulan = [
            "01" => "Januari $tahun",
            "02" => "Februari $tahun",
            "03" => "Maret $tahun",
            "04" => "April $tahun",
            "05" => "Mei $tahun",
            "06" => "Juni $tahun",
            "07" => "Juli $tahun",
            "08" => "Agustus $tahun",
            "09" => "September $tahun",
            10 => "Oktober $tahun",
            11 => "November $tahun",
            12 => "Desember $tahun"
        ];
        // Eksekusi query dan simpan hasil ke dalam array
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $hasilPerBulan[] = [$namaBulan[$bulan], $row[$id]];


        // Tambahkan 1 bulan untuk iterasi berikutnya
        $current_date = date('Y-m', strtotime("$current_date +1 month"));
    }

    // Kembalikan array hasilPerBulan
    return $hasilPerBulan;
}

// Fungsi chart kepuasan dengan status
function chartkepuasan($conn, $dari_tanggal, $sampai_tanggal, $table, $tgl, $status_column)
{
    // Ubah tanggal menjadi format bulan dan tahun saja
    $dari_bulan_tahun = date('Y', strtotime($dari_tanggal));


    // Ekstrak bulan dan tahun dari tanggal saat ini
    list($tahun) = explode('-', $dari_bulan_tahun);
    $query = "SELECT DATE_FORMAT($tgl, '%m') AS bulan, 
                     SUM(CASE WHEN $status_column = 'Puas' THEN 1 ELSE 0 END) AS jumlah_puas,
                     SUM(CASE WHEN $status_column = 'Tidak Puas' THEN 1 ELSE 0 END) AS jumlah_tidak_puas
              FROM $table
              WHERE $tgl BETWEEN '$dari_tanggal' AND '$sampai_tanggal'
              GROUP BY bulan";


    $namaBulan = [
        "01" => "Januari $tahun",
        "02" => "Februari $tahun",
        "03" => "Maret $tahun",
        "04" => "April $tahun",
        "05" => "Mei $tahun",
        "06" => "Juni $tahun",
        "07" => "Juli $tahun",
        "08" => "Agustus $tahun",
        "09" => "September $tahun",
        10 => "Oktober $tahun",
        11 => "November $tahun",
        12 => "Desember $tahun"
    ];
    $result = mysqli_query($conn, $query);

    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array($namaBulan[$row['bulan']], $row['jumlah_puas'], $row['jumlah_tidak_puas']);
    }

    return $data;
}

// Fungsi chart kategori
function chartkategori($conn, $dari_tanggal, $sampai_tanggal, $table, $tgl, $status_column)
{
    // Ubah tanggal menjadi format bulan dan tahun saja
    $dari_bulan_tahun = date('Y', strtotime($dari_tanggal));


    // Ekstrak bulan dan tahun dari tanggal saat ini
    list($tahun) = explode('-', $dari_bulan_tahun);
    $query = "SELECT DATE_FORMAT($tgl, '%m') AS bulan, 
                     SUM(CASE WHEN $status_column = 'Listrik' THEN 1 ELSE 0 END) AS listrik,
                     SUM(CASE WHEN $status_column = 'AC' THEN 1 ELSE 0 END) AS ac,
                     SUM(CASE WHEN $status_column = 'Plumbing' THEN 1 ELSE 0 END) AS plumbing,
                     SUM(CASE WHEN $status_column = 'Kebersihan' THEN 1 ELSE 0 END) AS kebersihan,
                     SUM(CASE WHEN $status_column = 'Parkir' THEN 1 ELSE 0 END) AS parkir
              FROM $table
              WHERE $tgl BETWEEN '$dari_tanggal' AND '$sampai_tanggal'
              GROUP BY bulan";


    $namaBulan = [
        "01" => "Januari $tahun",
        "02" => "Februari $tahun",
        "03" => "Maret $tahun",
        "04" => "April $tahun",
        "05" => "Mei $tahun",
        "06" => "Juni $tahun",
        "07" => "Juli $tahun",
        "08" => "Agustus $tahun",
        "09" => "September $tahun",
        10 => "Oktober $tahun",
        11 => "November $tahun",
        12 => "Desember $tahun"
    ];
    $result = mysqli_query($conn, $query);

    $data_kategori = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data_kategori[] = array($namaBulan[$row['bulan']], $row['listrik'], $row['ac'], $row['plumbing'], $row['kebersihan'], $row['parkir']);
    }

    return $data_kategori;
}



/**
 * Fungsi retore database.
 */
function restore($host, $user, $pass, $dbname, $file)
{
    global $rest_dir;

    //konfigurasi restore database: host, user, password, database
    $koneksi = mysqli_connect($host, $user, $pass, $dbname);

    $nama_file = $file['name'];
    $ukrn_file = $file['size'];
    $tmp_file = $file['tmp_name'];

    if ($nama_file == "" || $_REQUEST['password'] == "") {
        $_SESSION['errEmpty'] = 'ERROR! Semua Form wajib diisi';
        header("Location: ./admin.php?page=sett&sub=rest");
        die();
    } else {

        $password = $_REQUEST['password'];
        $id_user = $_SESSION['id_user'];

        $query = mysqli_query($koneksi, "SELECT password FROM tbl_user WHERE id_user='$id_user' AND password=MD5('$password')");
        if (mysqli_num_rows($query) > 0) {

            $alamatfile = $rest_dir . $nama_file;
            $templine = array();

            $ekstensi = array('sql');
            $nama_file = $file['name'];
            $x = explode('.', $nama_file);
            $eks = strtolower(end($x));

            //validasi tipe file
            if (in_array($eks, $ekstensi) == true) {

                if (move_uploaded_file($tmp_file, $alamatfile)) {

                    $templine = '';
                    $lines = file($alamatfile);

                    foreach ($lines as $line) {
                        if (substr($line, 0, 2) == '--' || $line == '')
                            continue;

                        $templine .= $line;

                        if (substr(trim($line), -1, 1) == ';') {
                            mysqli_query($koneksi, $templine);
                            $templine = '';
                        }
                    }

                    unlink($nama_file);
                    $_SESSION['succRestore'] = 'SUKSES! Database berhasil direstore';
                    header("Location: ./admin.php?page=sett&sub=rest");
                    die();
                } else {
                    $_SESSION['errUpload'] = 'ERROR! Proses upload database gagal';
                    header("Location: ./admin.php?page=ref&act=imp");
                    die();
                }
            } else {
                $_SESSION['errFormat'] = 'ERROR! Format file yang diperbolehkan hanya *.SQL';
                header("Location: ./admin.php?page=sett&sub=rest");
                die();
            }
        } else {
            session_destroy();
            echo '<script language="javascript">
                    window.alert("ERROR! Password salah. Anda mungkin tidak memiliki akses ke halaman ini");
                    window.location.href="index.php";
                  </script>';
        }
    }
}
