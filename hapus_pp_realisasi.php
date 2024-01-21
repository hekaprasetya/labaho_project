<?php
include "./include/config.php";
$id_pembelian_realisasi = $_GET['id_pembelian_realisasi'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_pembelian_realisasi WHERE id_pembelian_realisasi='$id_pembelian_realisasi'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

