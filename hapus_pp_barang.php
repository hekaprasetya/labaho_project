<?php
include "./include/config.php";
$id_barang = $_GET['id_barang'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_pp_barang WHERE id_barang='$id_barang'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

