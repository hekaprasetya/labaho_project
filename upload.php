<?php

include 'include/config.php';

// Ambil file yang diunggah
$file = $_FILES['file'];
$nama = $_POST['nama'];
$id_user = $_POST['id_user'];

// Validasi file
if (!$file['name']) {
    echo 'Tidak ada file yang diunggah.';
    header("HTTP/1.1 800 Tidak ada file yang diunggah.");
    exit;
}

// Validasi ukuran file
if ($file['size'] > 2500000) {
    echo 'Ukuran file yang diupload terlalu besar!';
    header("HTTP/1.1 600 File terlalu besar");
    exit;
}

// Validasi jenis file
if ($file['type'] != 'image/png' && $file['type'] != 'image/jpeg') {
    echo 'Hanya file gambar yang diperbolehkan.';
    header("HTTP/1.1 700 hanya file gambar yang diperbolehkan");
    exit;
}



// Simpan file ke server
$uploadDir = 'upload/gaji/';
$fileName = $file['name'];
$namaFile = uniqid() . "-" . $fileName;
$uploadPath = $uploadDir . $namaFile;
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    header('Content-Type: ' . $_FILES['file']['type']);
    readfile($uploadPath);
    // Berhasil mengunggah file
    $sql = "INSERT INTO tbl_gaji(nama,file,id_user) VALUES ('$nama', '$namaFile', '$id_user')";
    $result = mysqli_query($conn, $sql);
    echo $namaFile;
    // Periksa hasil kueri
    if ($result) {
        // Berhasil menyimpan data

        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
        header("Location: ./admin.php?page=gaji");
        die();
    } else {
        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
        echo '<script language="javascript">window.history.back();</script>';
    }
} else {
    header("HTTP/1.1 400 Bad Request");
}
