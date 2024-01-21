<?php

// include 'include/head.php';
// Perulangan untuk mereset sisa cuti
$sql = mysqli_query($config, "SELECT id_user FROM tbl_user");

// Hitung jumlah user
$result = mysqli_num_rows($sql);

// Ambil tahun sekarang
$tahun_sekarang = date("d");

// Ambil tahun sebelumnya
$tahun_sebelumnya = date("d", strtotime("- 1 day"));

// Mereset hitungan
if ($tahun_sekarang != $tahun_sebelumnya) {
    // Perulangan untuk mereset sisa cuti
    $sql = mysqli_query($config, "SELECT id_user FROM tbl_user");
    while ($data = mysqli_fetch_assoc($sql)) {

        $id_user = $data['id_user'];
        // Set sisa cuti menjadi 12
        mysqli_query($config, "UPDATE tbl_user SET sisa_cuti = 12 WHERE id_user = $id_user");
    }
    header("success");
    $_SESSION['succAdd'] = 'SUKSES! Data berhasil Reset';
?>
    <script language="javascript">
        window.history.back();
    </script>
<?php
}
header("error");
?>
<script language="javascript">
    window.history.back();
</script>