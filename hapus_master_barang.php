<?php
include "./include/config.php";
$id_barang_gudang = $_GET['id_barang_gudang'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from master_barang WHERE id_barang_gudang='$id_barang_gudang'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

